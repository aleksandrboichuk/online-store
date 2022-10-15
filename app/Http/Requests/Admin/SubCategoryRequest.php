<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class SubCategoryRequest extends AdminFormRequest
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
            'name' => [ 'string', 'min:3'],
            'seo_name' => [
                'string',
                'required' ,
                Rule::unique('sub_categories', 'seo_name')->ignore($this->route('subcategory')) ,
                'min:3'
            ],
        ];
    }
}
