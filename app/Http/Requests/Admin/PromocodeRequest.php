<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromocodeRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['string', 'min:3'],
            'description' => ['string', 'min:10'],
            'promocode' => [
                'string',
                Rule::unique('user_promocodes', 'promocode')->ignore($this->route('promocode')) ,
                'min:3'
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
            'title.min' => 'Заголовок' . $min_message,
            'description.min' => 'Опис' . $min_message,
            'promocode.min' => 'Промокод' . $min_message,
            'promocode.unique' => 'Промокод з таким кодом вже існує.',
        ];
    }

    /**
     * If request has fields, which designate conditions to use promocode
     * this function sets it to request to fill in fields in database
     *
     * @return void
     */
    public function setMinimalPromocodeConditionsFields(): void
    {
        $min_cart_total = $this->get('min_cart_total');
        $min_cart_products = $this->get('min_cart_products');

        $this->merge([
            'min_cart_total'  => $min_cart_total && $min_cart_total != '0' ? $min_cart_total : null,
            'min_cart_products'  => $min_cart_products && $min_cart_products != '0' ? $min_cart_products : null,
        ]);
    }
}
