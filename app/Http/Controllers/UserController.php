<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrdersList;
use App\Models\StatusList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function getUserSettings(){

        return view('personal-area.settings',[
            'user' => $this->getUser(),
        ]);
    }

    protected function validator(array $data){
        $messages = [
            'firstname-field.min' => 'Ім\'я має містити не менше 2-х символів.',
            'lastname-field.min' => 'Прізвище має містити не менше 2-х символів.',
            'email-field.min' => 'Email має містити не менше 8-ми символів.',
            'email-field.unique' => 'Користувач з такми Email вже існує.',
            'city-field.exists' => 'В дане місто доставка неможлива.',
            'phone-field.unique' => 'Користувач з такми  телефоном вже існує.',
            'phone-field.min' => 'Телефон має містити не менше 10-ти символів.',
            'password.confirmed' => 'Паролі не співпадають.',
            'password.min' => 'Пароль має містити не менше 3-х символів.',
        ];
        return Validator::make($data, [
            'firstname-field' => ['string', 'min:2'],
            'lastname-field' => ['string', 'min:2'],
            'phone-field' => ['string', 'min:10', 'unique:users,phone'],
            'city-field' => ['string', 'exists:ukraine_cities,name'],
            'email-field' => ['string', 'unique:users,email', 'min:8'],
            'password' => ['string', 'min:3', 'confirmed'],
        ], $messages);
    }

    public function saveUserSettings(Request $request){
        $user = $this->getUser();
        if(Hash::check($request['old-pass-field'], $user->password)){
            if($request['email-field'] != $user->email){
                $validator = $this->validator($request->only(['firstname-field', 'lastname-field', 'email-field']));
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            $user->update([
                'first_name'=> $request['firstname-field'],
                'last_name'=> $request['lastname-field'],
                'email'=> $request['email-field'],
            ]);

            // ============================ Если указан телефон ====================================

            if(!empty($request['phone-field']) && $user->phone != intval($request['phone-field'])){
                $validator = $this->validator($request->only(['phone-field']));
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
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
                $validator = $this->validator($request->only(['city-field']));
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $user->update([
                    'city'=> $request['city-field'],
                ]);
            }elseif(empty($request['city-field']) && $user->city != $request['city-field']){
                $user->update([
                    'city'=> null,
                ]);
            }

            // ============================ Если указан новый пароль ====================================

            if(!empty($request['password'])){
                $validator = $this->validator($request->only(['password', 'password_confirmation']));
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $user->update([
                    'password' => Hash::make($request['password'])
                ]);
            }
        }else{
            return redirect()->back()->withInput($request->all())->with(['old-pass-error' => 'Пароль невірний.']);
        }
        return redirect('/personal/orders')->with(['settings-save-success' => 'Налаштування профілю успішно змінено.']);
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
