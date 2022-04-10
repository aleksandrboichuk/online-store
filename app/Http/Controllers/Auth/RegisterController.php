<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'lastname' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'integer', 'max:10']
        ]);
    }

    public function showRegistrationForm(){
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        return view('auth.register', [
            'user' => $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
        ]);

    }

    public function toRegister(Request $request){
        $this->validator($request->all());
        foreach (User::all() as $u){
            if($request['email'] == $u->email){
                session(
                    [
                        'email' => 'Користувач з таким email\'ом вже існує.'
                    ]);
                return redirect()->back()->withInput($request->all());
            }elseif($request['phone'] == $u->phone){
                session(
                    [
                        'phone' => 'Користувач з таким номером телефону вже існує.'
                    ]);
                return redirect()->back()->withInput($request->all());
            }
        }
        if($request['password'] != $request['password_confirmation']){
            session(
                [
                    'new-pass' => 'Паролі не співпадають.'
                ]);
            return redirect()->back()->withInput($request->all());
        }

        $user = User::create([
            'first_name' => $request['firstname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'last_name' => $request['lastname'],
            'address' => $request['address'],
            'city' =>  $request['city'],
            'phone' => $request['phone'],
        ]);

        Cart::create([
            'user_id' => $user->id
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        User::where('email', $request['email'])->update([
            'session_token' => Str::random(60),
            'last_logged_in' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/shop/women');
    }
}
