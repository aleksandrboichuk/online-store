<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class BrandRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:2'],
            'seo_name' => [
                'string',
                Rule::unique('brands', 'seo_name')->ignore($this->route('brand')) ,
                'min:2'
            ],
        ];
    }
}
