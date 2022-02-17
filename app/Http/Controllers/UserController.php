<?php

namespace App\Http\Controllers;

use App\Models\OrdersList;
use App\Models\StatusList;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserOrders(){
        $user_orders = OrdersList::where('user_id', $this->getUser()->id)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();

        return view('personal-area.orders',[
            'user' => $this->getUser(),
           'orders' => $user_orders,
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
