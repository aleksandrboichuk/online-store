<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    /**
     * Login page
     *
     * @return Factory|View|Application
     */
    public function showLoginForm(): Factory|View|Application
    {
        return view('pages.auth.login');
    }

    /**
     * Login process
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function toLogin(Request $request): Redirector|RedirectResponse|Application
    {

        $user = User::getUserByEmail($request->get('email'));

        if($user && !$user->active){
            return redirect()->back()
                ->withErrors(['error' => 'Ваш акаунт деактивовано.'])
                ->withInput($request->all());
        }

        $email = $request->get('email');
        $remember = $request->get('remember');
        $credentials = $request->only('email', 'password');

        $authenticated = $this->attemptAuth($credentials, (bool)$remember);

        if($authenticated){

            $this->updateEntryAfterLogin($email);

            return  redirect('/shop/women');

        }else{

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['error' => 'Логін або пароль невірний' ]);
        }
    }

    /**
     * To do attempting auth
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    private function attemptAuth(array $credentials, bool $remember):bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Updating user data in database after login
     *
     * @param string $email
     * @return bool
     */
    private function updateEntryAfterLogin(string $email): bool
    {
       return (bool)User::query()->where('email', $email)->update([
            'session_token' => Str::random(60),
            'last_logged_in' => date("Y-m-d H:i:s"),
        ]);
    }

}
