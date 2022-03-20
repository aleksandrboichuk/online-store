<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdersList;
use App\Models\ProductSize;
use App\Models\StatusList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
     *
     * Editing/Adding/Saving ORDERS
     *
    */


    public  function index(){
        $orders = OrdersList::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);

        if(request()->ajax()){
            return view('admin.order.ajax.ajax-pagination', [
                'orders' => $orders,
                'statuses' => StatusList::all(),
            ])->render();
        }

        return view('admin.order.orders',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'orders' =>$orders
        ]);
    }
    public function editOrder($order_id){
        $order = OrdersList::find($order_id);
        if(!$order){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.order.edit',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'order' => $order,
            'items' =>  $order->items
        ]);
    }

    public function saveEditOrder(Request $request){
        $order = OrdersList::find($request['id']);

        $sum_field = explode('₴', $request['sum-field']);
        $total_cost = intval($sum_field[1]);

        if($request['status-field'] == 4){
            foreach($order->items as $item){
                $product = $item->product->where('id', $item->product_id)->first();
                foreach ($product->sizes as $size) {
                    $sizes = ProductSize::where('name', strval($item->size))->first();
                    if($size->id == $sizes->id){
                        $product->sizes()->where('product_size_id', $sizes->id)->update([
                            'count' =>  $size->pivot->count - $item->count
                        ]);
                    }
                }

                $product->update([
                    'count' => $product->count - $item->count,
                    'popularity' => $product->popularity + 1
                ]);
            }

        }

        $order->update([
            'user_id' => $request['id-field'],
            'name' => $request['name-field'],
            'email' => $request['email-field'],
            'phone' => $request['phone-field'],
            'address' => $request['address-field'],
            'comment' => $request['comment-field'],
            'total_cost' => $total_cost,
            'status' => $request['status-field'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        session(['success-message' => 'Замовлення успішно змінено.']);
        return redirect('/admin/orders');
    }

    public function delOrder($order_id){
        session(['success-message' => 'Замовлення успішно видалено.']);
        OrdersList::find($order_id)->delete();
        return redirect("/admin/orders");
    }
}
