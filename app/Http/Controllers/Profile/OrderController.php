<?php

namespace App\Http\Controllers\Profile;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserSettingsRequest;
use App\Models\Order;
use App\Models\StatusList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{

    /**
     * View details about order
     *
     * @param int $order_id
     * @return Application|Factory|View
     */
    public function index(int $order_id): View|Factory|Application
    {
        $order = Order::query()->find($order_id);

        if(!$order){
            abort(404);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs($order_id));

        return view('pages.profile.order',[
            'status'        => $order->status()->first()->name ?? '-',
            'order'         => $order,
            'items'         => $order->items,
            'breadcrumbs'   => $this->breadcrumbs
        ]);
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
            ['Особистий кабінет', route('user.orders')],
            ['Деталі замовлення'],
        ];
    }
}
