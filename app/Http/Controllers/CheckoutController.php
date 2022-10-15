<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\UkraineCity;
use App\Models\Promocode;
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
     * Sum cost of products in the cart
     *
     * @var int
     */
    private int $total;

    /**
     * User cart
     *
     * @var Model
     */
    private Model $cart;

    /**
     * Checkout page
     *
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request): Application|Factory|View|RedirectResponse
    {
        $this->setCart();

        $this->setTotal();

        $promocodeParameter = $request->get('promocode');

        if($promocodeParameter && $promocodeParameter != 'no'){
            $promocode = Promocode::getPromocode($promocodeParameter);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('pages.checkout.index', [
            'products' => $this->cart->products,
            'totalSum' => $this->total,
            'promocode' => $promocode ?? null,
            'cities' => UkraineCity::all(),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Returns the breadcrumbs array
     *
     * @return array[]
     */
    private function getBreadcrumbs(): array
    {
        return [
            ['Головна', route('index', 'women')],
            ["Кошик",   route('cart')],
            ["Оформлення замовлення"],
        ];
    }

    /**
     * Save the order
     *
     * @param $request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public  function saveOrder(CheckoutRequest $request): Application|RedirectResponse|Redirector
    {
        $this->setCart();
        $this->setTotal();

        $promocodeParameter = $request->get('promocode');

        if($promocodeParameter && Auth::check()){
            $this->setTotalWithPromocode($promocodeParameter);
        }

        $ordersList = $this->saveOrderEntry($request);

        $ordersList->saveItems($this->cart->products);

        $this->cart->clear();

        return $this->redirectUser();
    }

    /**
     * Save order entry into DB
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

        return Order::query()->create($request->toArray());
    }


    /**
     * Sets total cost with promocode
     *
     * @param string $promocodeParameter
     * @return void
     */
    private function setTotalWithPromocode(string $promocodeParameter): void
    {
        $promocode = Promocode::getPromocode($promocodeParameter);

        if($promocode){

            $this->total = $this->total - (round($this->total * ($promocode->discount * 0.01)));

            $this->user()->promocodes()->where('promocode_id', $promocode->id)->detach();
        }
    }

    /**
     * Defines delivery field
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
     * Defines payment field
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
     * Set total cart field
     *
     * @return void
     */
    private function setTotal(): void
    {
        $this->total = $this->cart->getTotal();
    }

    /**
     * Set user cart field
     *
     * @return void
     */
    private function setCart(): void
    {
        $this->cart = $this->getCart();
    }

    /**
     * Redirects user (depending on auth)
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
