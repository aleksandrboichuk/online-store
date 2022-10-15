<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Showing form to fill new password
     *
     * @param string $token
     * @return Application|Factory|View
     */
    public function showPasswordResetForm(string $token): View|Factory|Application
    {
        return view('pages.auth.passwords.password-reset', compact('token'));
    }

    /**
     * Receive new password and save it in database
     *
     * @param PasswordResetRequest $request
     * @return RedirectResponse
     */
    public function toResetPassword(PasswordResetRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Пароль успішно змінено!')
            : back()->withErrors(['error' => 'Щось пішло не так. Спробуйте, будь ласка, пізніше.']);
    }

}
