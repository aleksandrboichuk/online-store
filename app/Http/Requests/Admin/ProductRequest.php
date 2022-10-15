<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ProductRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [ 'string', 'min:3'],
            'description' => [ 'string', 'min:10'],
            'seo_name' => [
                'string',
                'required' ,
                Rule::unique('products', 'seo_name')->ignore($this->route('product')) ,
                'min:3'
            ],
        ];
    }
}
