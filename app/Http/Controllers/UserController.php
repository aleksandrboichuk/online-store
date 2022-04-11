<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrdersList;
use App\Models\StatusList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // =====================================  Orders  ==============================================
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

    // =====================================  Settings  ==============================================

    public function getUserSettings(Request $request){

        return view('personal-area.settings',[
            'user' => $this->getUser(),
        ]);
    }

    public function saveUserSettings(Request $request){
        $user = $this->getUser();
        if(Hash::check($request['old-pass-field'], $user->password)){
            if($request['email-field'] != $user->email){
                $users = User::all();
                foreach ($users as $u) {
                    if($request['email-field'] == $u->email){
                        session(
                            [
                                'email' => 'Користувач з таким email\'ом вже існує.'
                            ]);
                        return redirect()->back()->withInput($request->all());
                    }
                }
            }
            $user->update([
                'first_name'=> $request['firstname-field'],
                'last_name'=> $request['lastname-field'],
                'email'=> $request['email-field'],
            ]);

            // ============================ Если указан телефон ====================================
            if(!empty($request['phone-field']) && $user->phone != intval($request['phone-field'])){
                $users = User::all();
                foreach ($users as $u) {
                    if($request['phone-field'] == $u->phone){
                        session(
                        [
                            'phone' => 'Користувач з таким номером телефону вже існує.'
                        ]);
                        return redirect()->back()->withInput($request->all());
                    }
                }
                $user->update([
                    'phone'=> $request['phone-field'],
                ]);
            }elseif(empty($request['phone-field']) && $user->phone != intval($request['phone-field'])){
                $user->update([
                    'phone'=> null,
                ]);
            }

            // ============================ Если указан город ====================================

            if(!empty($request['city-field']) && $user->city != $request['city-field']){
                $user->update([
                    'city'=> $request['city-field'],
                ]);
            }elseif(empty($request['phone-field']) && $user->city != $request['city-field']){
                $user->update([
                    'city'=> null,
                ]);
            }

            // ============================ Если указан новый пароль ====================================

            if(!empty($request['new-pass-field']) && !empty($request['confirm-new-pass-field'])){
                if($request['confirm-new-pass-field'] == $request['new-pass-field']){
                    $user->update([
                        'password' => Hash::make($request['new-pass-field'])
                    ]);
                    return redirect('/personal/orders');
                }else {
                    session(
                        [
                            'confirm-new-pass-error' => 'Підтвердження нового паролю не співпадає з новим паролем.'
                        ]);
                    return redirect()->back()->withInput($request->all());
                }
            }
        }else{
            session(
                [
                    'old-pass-error' => 'Пароль невірний.'
                ]);
            return redirect()->back()->withInput($request->all());
        }

        session(
            [
                'settings-save-success' => 'Налаштування профілю успішно змінено.'
            ]);
        return redirect('/personal/orders');

    }

    // =====================================  Promocodes  ==============================================

    public function getUserPromocodes(){
        $user =  $this->getUser();
        return view('personal-area.promocodes', [
            'user' => $user,
            'promocodes' => isset($user->promocodes) && !empty($user->promocodes) ? $user->promocodes : null,
        ]);
    }
}
