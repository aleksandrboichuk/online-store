<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
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

        return view('contact.contact', [
           'user' => $this->getUser()
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

    public function throwError($code){
        return view('404.404', [
            'user'=>$this->getUser()
        ]);
    }
}
