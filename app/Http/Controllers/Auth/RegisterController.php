<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\UserPromocode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }

    protected function validator(array $data){
        $messages = [
          'password.confirmed' => 'Паролі не співпадають.',
          'password.min' => 'Пароль має містити не менше 8-ми символів.',
          'firstname.min' => 'Ім\'я має містити не менше 3-х символів.',
          'lastname.min' => 'Прізвище має містити не менше 3-х символів.',
          'firstname.max' => 'Ім\'я має містити не більше 20-ти символів.',
          'lastname.max' => 'Прізвище має містити не більше 20-ти символів.',
          'email.min' => 'Пошта має містити не менше 8-ми символів.',
          'email.max' => 'Пошта має містити не більше 30-ти символів.',
          'email.unique' => 'Користувач з такою поштою вже існує.',
        ];
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:20', 'min:3'],
            'lastname' => ['required', 'string', 'max:20', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    public function showRegistrationForm(){
        if(!$this->getUser()){
            $cart = $this->getCartByToken();
        }
        return view('auth.register', [
            'user' => $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
        ]);

    }

    public function toRegister(Request $request){

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ================================= Создаем юзера  ===========================================
        $user = User::create([
            'first_name' => $request['firstname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'last_name' => $request['lastname'],
        ]);

        // ================================= Создание корзины  ===========================================
        Cart::create([
            'user_id' => $user->id
        ]);

        // ================================= Выдаем юзеру промокод  ===========================================
        $promocode = UserPromocode::where('promocode', 'special-for-reg-user')->first();
        $user->promocodes()->attach($promocode->id, [
            'user_id' => $user->id,
            'user_promocode_id' => $promocode->id
        ]);

        // ================================= Автовход в кабинет  ===========================================
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        User::where('email', $request['email'])->update([
            'session_token' => Str::random(60),
            'last_logged_in' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/shop/women');
    }
}
