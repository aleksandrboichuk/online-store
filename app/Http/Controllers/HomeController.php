<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function contact(){
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }
        return view('contact.contact', [
           'user' => $this->getUser(),
            'cart' => isset($cart) && !empty($cart) ? $cart : null,
        ]);
    }
    public function sendMessage(Request $request)
    {
       UserMessage::create([
          'user_id' => $request['id'],
           'email' => $request['email'],
           'theme' => $request['theme'],
           'message'=> $request['message']
       ]);
       return redirect('/shop/women');

    }
}
