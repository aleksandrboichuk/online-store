<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Cart;
use App\Models\UserMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ContactController extends Controller
{
    /**
     * Contact page
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('pages.contact.index');
    }

    /**
     * Receiving message from contact page
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function sendMessage(ContactRequest $request): Redirector|RedirectResponse|Application
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
