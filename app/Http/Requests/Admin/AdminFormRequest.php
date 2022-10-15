<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
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
            'name.min' => 'Назва' . $min_message,
            'seo_name.min' => 'СЕО' . $min_message,
            'seo_name.unique' => 'СЕО вже існує',
            'description.min' => 'Опис' . $min_message,
        ];
    }

    /**
     * Set bool value of active field from form request
     *
     * @return AdminFormRequest
     */
    public function setActiveField(): AdminFormRequest
    {
        return $this->merge([
            'active' => $this->defineActiveField($this->get('active'))
        ]);
    }

    /**
     * Defining active field
     *
     * @param string|null $request_string
     * @return bool
     */
    private function defineActiveField(string|null $request_string = ""): bool
    {
        if($request_string == "on"){
            return true;
        }

        return false;
    }

}
