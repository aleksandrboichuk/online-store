<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdersList;
use App\Models\ProductSize;
use App\Models\StatusList;
use App\Models\UserPromocode;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = OrdersList::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(7);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = OrdersList::find($id);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = OrdersList::find($id);
        $total_cost = intval($request['sum-field']);
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
            // ================ обновляем инфу о количестве заказов юззера и их сумме ===================
            if(!empty($order->users)){
                $user = $order->users;
                $user->update([
                    'orders_amount' => $user->orders_amount + 1,
                    'orders_sum' => $user->orders_sum + $order->total_cost
                ]);
                // ============================= выдаем промокод юзеру ===========================================
                if($user->orders_amount >= 10 && $user->orders_sum >= 7000){
                    $promocode = UserPromocode::where('promocode', 'many-orders-code')->first();
                    $user->promocodes()->attach($promocode->id, [
                        'user_id' => $user->id,
                        'user_promocode_id' => $promocode->id
                    ]);
                }
            }
        }
        $order->update([
            'name' => $request['name-field'],
            'phone' => $request['phone-field'],
            'city' => $request['city-field'],
            'address' => isset($request['address-field']) ? $request['address-field'] : null,
            'post_department' => isset($request['post-field']) ? $request['post-field'] : null,
            'total_cost' => $total_cost,
            'status' => $request['status-field'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return redirect('/admin/orders')->with(['success-message' => 'Замовлення успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrdersList::find($id)->delete();
        return redirect("/admin/orders")->with(['success-message' => 'Замовлення успішно видалено.']);
    }
}
