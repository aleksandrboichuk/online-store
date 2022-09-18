<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends AdminFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>'required|string|min:5',
            'email' => 'email',
            'phone' => 'required|string|min:10|max:13',
            'address' => 'string|min:8',
            'post_department' => 'integer|min:1',
            'city' => 'string|min:3',
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
            'name.min' => 'Ім\'я' . $min_message,
            'name.required' => 'Необхідно вказати ім\'я.',
            'address.min' => 'Адреса' . $min_message,
            'post_department.min' => 'Номер поштового відділення' . $min_message,
            'email.required' => 'Необхідно вказати E-mail',
            'phone.min' => 'Телефон' . $min_message,
            'phone.required' => 'Необхідно вказати номер телефону',
            'phone.max' => 'Телефон має містити не більше :max символів.',
            'city.required' => 'Місто' . $min_message ,
        ];
    }
}
