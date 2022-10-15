<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UserRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['string', 'min:2'],
            'last_name' => ['string', 'min:2'],
            'phone' => 'required|string|min:10|max:13',
            'email' => [
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')) ,
                'min:8'
            ],
        ];
    }

    /**
     * Messages for validation errors
     *
     * @return string[]
     */
    public function messages(): array
    {
        $min_message = ' має містити не менше :min символів.';

        return [
            'first_name.min' => 'Ім\'я' . $min_message,
            'last_name.min' => 'Прізвище' . $min_message,
            'email.min' => 'E-mail' . $min_message,
            'email.unique' => 'Користувач з таким E-mail вже існує.',
            'phone.min' => 'Телефон' . $min_message,
            'phone.required' => 'Необхідно вказати номер телефону',
            'phone.max' => 'Телефон має містити не більше :max символів.',
        ];
    }
}
