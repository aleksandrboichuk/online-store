<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class BannerRequest extends AdminFormRequest
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
            'description' => [ 'string', 'min:10'],
            'seo_name' => [
                'string',
                Rule::unique('banners', 'seo_name')->ignore($this->route('banner')) ,
                'min:3'
            ],
        ];
    }

}
