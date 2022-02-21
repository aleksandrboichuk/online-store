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


    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function toRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'lastname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer', 'max:10']
        ]);

        $user = new User;
            $user->first_name = $request['firstname'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->last_name = $request['lastname'];
            $user->address = $request['address'];
            $user->city =  $request['city'];
            $user->phone = $request['phone'];
        $user->save();

        $registeredUser = User::where('email',$request['email'] )->first();

        Cart::create([
            'user_id' => $registeredUser->id
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
