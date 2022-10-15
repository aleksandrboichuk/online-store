<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class CategoryGroupRequest extends AdminFormRequest
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
            'seo_name' => [
                'string',
                Rule::unique('category_groups', 'seo_name')->ignore($this->route('category-group')) ,
                'min:3'
            ],
        ];
    }
}
