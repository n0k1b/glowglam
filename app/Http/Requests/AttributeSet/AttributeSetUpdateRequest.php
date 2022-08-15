<?php

namespace App\Http\Requests\AttributeSet;

use Illuminate\Foundation\Http\FormRequest;

class AttributeSetUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attribute_set_name' => 'required|unique:attribute_set_translations,attribute_set_name,'.$this->attribute_set_translation_id.',id,deleted_at,NULL',
        ];
    }
}
