<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialRequest extends AdminFormRequest
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
            'seo_name' => [
                'string',
                Rule::unique('product_materials', 'seo_name')->ignore($this->route('material')) ,
                'min:3'
            ],
        ];
    }


}
