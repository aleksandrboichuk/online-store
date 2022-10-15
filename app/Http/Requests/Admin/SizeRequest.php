<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SizeRequest extends AdminFormRequest
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
                'required' ,
                Rule::unique('sizes', 'seo_name')->ignore($this->route('size')) ,
                'min:3'
            ],
        ];
    }


}
