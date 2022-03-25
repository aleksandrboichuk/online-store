<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrdersList;
use App\Models\StatusList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        if(!$order){
            return response()->view('errors.404', [
                'user' => $this->getUser(),
            ], 404);
        }
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

    public function getUserSettings(Request $request){

        return view('personal-area.settings',[
            'user' => $this->getUser(),
        ]);
    }

    public function saveUserSettings(Request $request){
        $user = $this->getUser();
        if(!empty($request['new-pass-field']) && !empty($request['confirm-new-pass-field'])){
            if(Hash::check($request['old-pass-field'], $user->password)){
                if($request['confirm-new-pass-field'] == $request['new-pass-field']){
                    $user->update([
                        'password' => Hash::make($request['new-pass-field'])
                    ]);
                    return redirect('/personal/orders');
                }else{
                    session(
                        [
                            'confirm-new-pass-error' => 'Підтвердження нового паролю не співпадає з новим паролем.'
                        ]);
                    return redirect()->back()->withInput($request->all());
                }
            }else{
                session(
                    [
                        'old-pass-error' => 'Пароль невірний.'
                    ]);
                return redirect()->back()->withInput($request->all());
            }
        }else{
            if(Hash::check($request['old-pass-field'], $user->password)){
                $user->update([
                    'first_name'=> $request['firstname-field'],
                    'last_name'=> $request['lastname-field'],
                    'email'=> $request['email-field'],
                    'phone'=> $request['phone-field'],
                    'city'=> $request['city-field'],
                ]);
                session(
                    [
                        'settings-save-success' => 'Налаштування профілю успішно змінено.'
                    ]);
                return redirect('/personal/orders');
            }else{
                session(
                    [
                        'old-pass-error' => 'Пароль невірний.'
                    ]);
                return redirect()->back()->withInput($request->all());
            }
        }
    }
}
