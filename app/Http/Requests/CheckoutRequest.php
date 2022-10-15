<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'phone' => ['required' ,'string', 'min:10'],
            'city' => ['required', 'string', 'exists:ukraine_cities,name'],
            'email' => ['nullable', 'string', 'min:8'],
            'post_department' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
          //TODO:: messages
        ];
    }
}
