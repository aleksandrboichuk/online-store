<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\UserMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

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
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
    }

    /**
     * Страница контактов
     * @return Application|Factory|View
     */
    public function contact(): View|Factory|Application
    {
        return view('pages.contact.index');
    }

    /**
     * Отправка сообщения со страницы контактов
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function sendMessage(Request $request): Redirector|RedirectResponse|Application
    {
        //TODO:: validation
       UserMessage::query()->create([
           'user_id' => $request['id'],
           'email' => $request['email'],
           'theme' => $request['theme'],
           'message'=> $request['message']
       ]);

       return redirect('/shop/women');

    }
}
