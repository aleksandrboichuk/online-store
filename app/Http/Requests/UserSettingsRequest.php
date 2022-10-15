<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
{
    /**
     * User id for unique fields
     *
     * @var int
     */
    protected int $user_id;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->user_id = (int)auth()->id();

        return [
            'first_name' => ['string', 'min:2'],
            'last_name' => ['string', 'min:2'],
            'phone' => ['string', 'min:10', 'unique:users,phone,' . $this->user_id . ',id'],
            'city' => ['string', 'exists:ukraine_cities,name'],
            'email' => ['string', 'unique:users,email,' . $this->user_id . ',id', 'min:8'],
            'password' => ['nullable', 'min:3', 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return string[]
     */
    public function messages():array
    {
        return [
            'first_name.min' => 'Ім\'я має містити не менше 2-х символів.',
            'last_name.min' => 'Прізвище має містити не менше 2-х символів.',
            'email.min' => 'Email має містити не менше 8-ми символів.',
            'email.unique,id,' . $this->user_id => 'Користувач з такми Email вже існує.',
            'city.exists' => 'У дане місто доставка неможлива.',
            'phone.unique' => 'Користувач з такми  телефоном вже існує.',
            'phone.min' => 'Телефон має містити не менше 10-ти символів.',
            'password.confirmed' => 'Паролі не співпадають.',
            'password.min' => 'Пароль має містити не менше 3-х символів.',
        ];
    }
}
