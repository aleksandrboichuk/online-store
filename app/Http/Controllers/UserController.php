<?php

namespace App\Http\Controllers;

use App\Models\OrdersList;
use App\Models\StatusList;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserOrders($status = null){
        $user_orders = OrdersList::where('user_id', $this->getUser()->id)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
        $statusName = "Замовлення";
        if (!empty($status)) {
            switch ($status) {
                case 'new':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 1)->get();
                    $statusName = "Нові";
                    break;
                case 'processed':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 2)->get();
                    $statusName = "Оброблені";
                    break;
                case 'paid':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 3)->get();
                    $statusName = "Оплачені";
                    break;
                case 'delivering':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 4)->get();
                    $statusName = "Доставляються";
                    break;
                case 'delivered':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 5)->get();
                    $statusName = "Доставлені";
                    break;
                case 'completed':
                    $user_orders = OrdersList::where('user_id', $this->getUser()->id)->where('status', 6)->get();
                    $statusName = "Завершені";
                    break;
            }
        }


        return view('personal-area.index', [
            'user' => $this->getUser(),
            'orders' => $user_orders,
            'status_name' =>  $statusName,
            'statuses' => StatusList::all(),
        ]);
    }

    public function viewUserOrder($order_id){
        $order = OrdersList::find($order_id);
        $statuses = StatusList::all();

        foreach ($statuses as $s){
            if($order->status == $s->id ){
                $status = $s->name;
            }
        }

        return view('personal-area.view-order',[
            'user' => $this->getUser(),
            'status' => isset($status) ? $status : "-",
            'order' => $order,
            'items' =>  $order->items
        ]);
    }
}
