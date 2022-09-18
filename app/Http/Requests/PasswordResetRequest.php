<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|min:5|confirmed',
        ];
    }

    public function messages()
    {
       return [
         'email.required' => 'Заповніть, будь ласка, поле E-mail.',
         'email.exists' => 'E-mail не зареєстрований.',
         'password.confirmed' => 'Паролі не співпадають.',
         'password.required' => 'Введіть, будь ласка, пароль.',
         'password.min' => 'Пароль має містити не менше :min символів.',
       ];
    }
}
