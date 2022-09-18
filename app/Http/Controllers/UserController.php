<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserSettingsRequest;
use App\Models\OrdersList;
use App\Models\StatusList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class UserController extends Controller
{

    /**
     * Статус заказа
     *
     * @var string|null
     */
    protected string|null $status;

    /**
     * Страница личного кабинета
     *
     * @param $status
     * @return Application|Factory|View
     */
    public function index($status = null): View|Factory|Application
    {
        $this->status = $status;

        $this->getPageData();

        return view('personal-area.index', $this->pageData);
    }

    /**
     * Returns status name (translated to ukrainian) and user orders by this status
     *
     * @return array
     */
    private function getUserOrdersWithStatusName(): array
    {
        $user_id = $this->userId();

        $status = StatusList::getOneBySeoName($this->status);

        $user_orders = $this->status
            ? OrdersList::getUserOrdersByUserIdAndStatus($user_id, $status->id)
            : OrdersList::getUserOrders($user_id);

        return [
            'orders'      => $user_orders,
            'status_name' =>  $this->getStatusNameBySeoName($this->status),
        ];
    }

    /**
     * Returns translated status name by it seo name
     *
     * @param $status_seo_name
     * @return string
     */
    private function getStatusNameBySeoName($status_seo_name): string
    {
        return match ($status_seo_name){
            'new'        => 'Нові',
            'processed'  => 'Оброблені',
            'paid'       => 'Оплачені',
            'delivering' => 'Доставляються',
            'delivered'  => 'Доставлені',
            'completed'  => 'Завершені',
            default      => 'Замовлення'
        };
    }

    /**
     * Returns array for the view
     *
     * @return void
     */
    public function getPageData(): void
    {
        $data = [
            'statuses' => StatusList::all(),
        ];

        $this->pageData = array_merge($data, $this->getUserOrdersWithStatusName());
    }


    /**
     * Просмотр заказа
     *
     * @param int $order_id
     * @return Application|Factory|View
     */
    public function viewUserOrder(int $order_id): View|Factory|Application
    {
        $order = OrdersList::query()->find($order_id);

        if(!$order){
            abort(404);
        }

        $status = $order->status()->first()->name ?? '-';

        return view('personal-area.view-order',[
            'status' => $status,
            'order' => $order,
            'items' =>  $order->items
        ]);
    }


    /**
     * Настройки аккаунта пользователя
     * @return Application|Factory|View
     */
    public function getUserSettings(): View|Factory|Application
    {
        return view('personal-area.settings');
    }

    /**
     * Получение страницы промокодов
     * @return Application|Factory|View
     */
    public function getUserPromocodes(): View|Factory|Application
    {
        $user =  $this->user();

        return view('personal-area.promocodes', [
            'promocodes' => $user->promocodes ?? null,
        ]);
    }

    /**
     * Сохранение настроек
     * @param UserSettingsRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function saveUserSettings(UserSettingsRequest $request): Redirector|RedirectResponse|Application
    {
        $user = $this->user();

        if(!Hash::check($request->get('old-pass'), $user->password)) {
            return redirect()->back()->withInput($request->all())->with(['old-pass-error' => 'Пароль невірний.']);
        }

        $requestData = $request->except(['password']);

        //  if filled in a new password
        if($request->get('password')){
            $requestData['password'] = Hash::make($request->get('password'));
        }

        $this->updateUserData($requestData);

        return redirect('/personal/orders')->with(['settings-save-success' => 'Налаштування профілю успішно змінено.']);
    }

    /**
     * Updating data of user in database
     *
     * @param array $data
     * @return mixed
     */
    protected function updateUserData(array $data): mixed
    {
       return $this->user()->update($data);
    }

}
