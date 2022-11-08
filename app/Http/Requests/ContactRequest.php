<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required', 'string', 'min:10'],
            'email' => ['required', 'email', 'min:3'],
            'theme' => ['required', 'string', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Пошта є обов\'язковою.',
            'email.min' => 'Пошта має містити не менше :min символів.',

            'theme.required' => 'Тема повідомлення є обов\'язковою.',
            'theme.min' => 'Тема повідомлення має містити не менше :min символів.',

            'message.required' => 'Текст повідомлення є обов\'язковим.',
            'message.min' => 'Текст повідомлення має містити не менше :min символів.',
        ];
    }
}
