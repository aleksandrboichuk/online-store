<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\OrdersList;
use App\Models\UkraineCity;
use App\Models\UserPromocode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CheckoutController extends Controller
{
    /**
     * Переменная суммы корзины
     *
     * @var int
     */
    private int $total;

    /**
     * Переменная с корзиной пользователя
     *
     * @var Model
     */
    private Model $cart;

    /**
     * Страница оформления заказа
     *
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request): Application|Factory|View|RedirectResponse
    {
        $this->cart = $this->getCart();

        //   Если кто-то додумается без товаров в корзине пойти на чекаут по урлу
        if(!$this->cart->products || count($this->cart->products) < 1){
           return redirect()->back();
        }

        $this->total = $this->cart->calculateTotal();

        $promocodeParameter = $request->get('promocode');

        if($promocodeParameter && $promocodeParameter != 'no'){
            $promocode = $this->getPromocode($promocodeParameter);
        }

        return view('checkout.checkout', [
            'products' => $this->cart->products,
            'totalSum' => $this->total,
            'promocode' => $promocode ?? null,
            'cities' => UkraineCity::all(),
        ]);
    }

    /**
     * Сохранение заказа
     *
     * @param $request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public  function saveOrder(CheckoutRequest $request): Application|RedirectResponse|Redirector
    {
        $this->cart = $this->getCart();
        $this->total = $this->cart->calculateTotal();

        $promocodeParameter = $request->get('promocode');

        if($promocodeParameter && Auth::check()){
            $this->setTotalWithPromocode($promocodeParameter);
        }

        $ordersList = $this->saveOrderEntry($request);

        $this->saveOrderItems($ordersList);

        $this->clearCart();

        return $this->redirectUser();
    }

    /**
     * Сохраняет запись заказа
     *
     * @param CheckoutRequest $request
     * @return Builder|Model
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function saveOrderEntry(CheckoutRequest $request): Builder|Model
    {
        $userOrToken = $this->getUserIdOrSessionId();
        $status = $this->definePaymentStatus();
        $delivery = $this->defineDelivery();

        $arrBasicData = [
            'name'       => $request->get('first_name') . ' ' . $request->get('last_name'),
            'total_cost' => $this->total,
            'user_id'    => is_int($userOrToken) ? $userOrToken : null,
            'token'      => is_string($userOrToken) ? $userOrToken : null,
        ];

        $arrBasicData = array_merge($arrBasicData, $status, $delivery);

        $request->merge($arrBasicData);

       return OrdersList::query()->create($request->toArray());
    }

    /**
     * Сохраняет продукты из корзины в заказ
     *
     * @param Model $ordersList
     * @return void
     */
    private function saveOrderItems(Model $ordersList)
    {
        foreach ($this->cart->products as $product){
            $productPrice =  $product->getProductPriceWithDiscount();
            $ordersList->items()->create([
                "order_id" =>  $ordersList->id,
                "product_id" => $product->id,
                "name" => $product->name,
                "price" => $productPrice,
                "product_count" => $product->pivot->product_count,
                "total_cost" => $productPrice * $product->pivot->product_count,
                "size" => $product->pivot->size,
            ]);
        }
    }

    /**
     * Удаление продуктов из корзины
     * @return void
     */
    private function clearCart(): void
    {
        foreach ($this->cart->products as $product) {
            $product->pivot->delete();
        }
    }

    /**
     * Проверка выполнения условий промокода
     *
     * @param Model $promocodeEntry
     * @param int $total
     * @param $cart
     * @return bool|RedirectResponse
     */
    private function checkPromocodeAllow(Model $promocodeEntry, int $total,  $cart): bool|RedirectResponse
    {
        $allowPromocode = false;

        if($promocodeEntry->min_cart_total){
            if($promocodeEntry->min_cart_total >  $total){
                session(
                    [
                        'warning-message' => 'Недостатня сума товарів кошику для застосування обраного вами промокоду. Потрібно не менше  ₴'. $promocodeEntry->min_cart_total .'. Спробуйте обрати інший промокод, або додати ще товарів до кошику.'
                    ]);
                return redirect()->back();
            }else{
                $allowPromocode = true;
            }
        }

        if(!empty($promocodeEntry->min_cart_products)){
            if($promocodeEntry->min_cart_products >  count($cart->products)){
                return redirect()->back()->with(
                    [
                        'warning-message' => 'Недостатня кількість товарів кошику для застосування обраного вами промокоду. Потрібно не менше '. $promocodeEntry->min_cart_products .'. Спробуйте обрати інший промокод, або додати ще товарів до кошику.'
                    ]
                );
            }else{
                $allowPromocode = true;
            }
        }

        return $allowPromocode;
    }

    /**
     * Получение/не получение промокода согласно условиям
     *
     * @param $promocode
     * @return Builder|Model|null
     */
    private function getPromocode($promocode): Builder|Model|null
    {
        $promocodeEntry = UserPromocode::getPromocode($promocode);

        $allowPromocode = $this->checkPromocodeAllow($promocodeEntry, $this->total, $this->cart);

        return $allowPromocode ? $promocodeEntry : null;
    }

    /**
     * Установка полной стоимости с учетом промокода
     *
     * @param string $promocodeParameter
     * @return void
     */
    private function setTotalWithPromocode(string $promocodeParameter): void
    {
        $promocode = UserPromocode::getPromocode($promocodeParameter);

        if($promocode){

            $this->total = $this->total - (round($this->total * ($promocode->discount * 0.01)));

            $this->user()->promocodes()->where('user_promocode_id', $promocode->id)->detach();
        }
    }

    /**
     * определение поля доставки
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function defineDelivery(): array
    {
        $arrDelivery = [];
        if(request()->get('post-department-field')){

            $arrDelivery['post_department'] = intval(request()->get('post-department-field'));

        }elseif(request()->get('address-field')){

            $arrDelivery['address'] = request()->get('address-field');
        }
        return $arrDelivery;
    }

    /**
     * Определение статуса оплаты
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function definePaymentStatus(): array
    {
        $arPayment = [];
        if(request()->get('email-field')){
            $arPayment['email'] = request()->get('email-field');
            $arPayment['pay_now'] = true;
        }else{
            $arPayment['pay_now'] = false;
        }

        return $arPayment;
    }

    /**
     * Редирект юзера в зависимости от регистрации
     *
     * @return RedirectResponse
     */
    private function redirectUser(): RedirectResponse
    {
        if(!$this->user()){
            return redirect('/cart')->with(
                ['success-message' => 'Ви успішно виконали замовлення. У найближчий час з вами зв\'яжеться адміністратор для уточнення деталей.']
            );
        }else{
            return redirect('/personal/orders')->with(
                ['success-message' => 'Ви успішно виконали замовлення. У найближчий час з вами зв\'яжеться адміністратор для уточнення деталей.']
            );
        }
    }
}
