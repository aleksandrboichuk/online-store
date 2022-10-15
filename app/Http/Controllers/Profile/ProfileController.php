<?php

namespace App\Http\Controllers\Profile;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
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

        $this->setPageData();

        return view('pages.profile.index', $this->pageData);
    }

    /**
     * Returns status name (translated to ukrainian) and user orders by this status
     *
     * @return array
     */
    private function getUserOrdersWithStatusName(): array
    {
        $user_id = $this->userId();

        $status = $this->status ? StatusList::getOneBySeoName($this->status) : null;

        $user_orders = $this->status
            ? Order::getUserOrdersByUserIdAndStatus($user_id, $status->id)
            : Order::getUserOrders($user_id);

        return [
            'orders'      => $user_orders,
            'status_name' => $this->getStatusNameBySeoName($this->status),
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
    public function setPageData(): void
    {
        $this->setBreadcrumbs($this->getBreadcrumbs());

        $data = [
            'statuses'      => StatusList::all(),
            'breadcrumbs'   => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getUserOrdersWithStatusName());
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    private function getBreadcrumbs(): array
    {
        return [
            ['Головна', route('index', 'women')],
            ['Особистий кабінет'],
            [$this->getStatusNameBySeoName($this->status)],
        ];
    }
}
