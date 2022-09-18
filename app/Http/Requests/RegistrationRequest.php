<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:20', 'min:3'],
            'last_name' => ['required', 'string', 'max:20', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Messages
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'password.confirmed' => 'Паролі не співпадають.',
            'password.min' => 'Пароль має містити не менше 8-ми символів.',
            'first_name.min' => 'Ім\'я має містити не менше 3-х символів.',
            'last_name.min' => 'Прізвище має містити не менше 3-х символів.',
            'first_name.max' => 'Ім\'я має містити не більше 20-ти символів.',
            'last_name.max' => 'Прізвище має містити не більше 20-ти символів.',
            'email.min' => 'Пошта має містити не менше 8-ми символів.',
            'email.max' => 'Пошта має містити не більше 30-ти символів.',
            'email.unique' => 'Користувач з такою поштою вже існує.',
        ];
    }
}
