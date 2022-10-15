<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ColorRequest extends AdminFormRequest
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
                'required' ,
                Rule::unique('colors', 'seo_name')->ignore($this->route('color')) ,
                'min:2'
            ],
        ];
    }
}
