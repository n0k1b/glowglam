<?php

namespace App\Http\Requests\AttributeSet;

use Illuminate\Foundation\Http\FormRequest;

class AttributeSetStoreRequest extends FormRequest
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
            // 'attribute_set_name' => 'required|unique:attribute_set_translations,attribute_set_name',
            'attribute_set_name' => 'required|unique:attribute_set_translations,attribute_set_name,NULL,id,deleted_at,NULL',
            // name'=>'required|unique:form_types,name,NULL,id,deleted_at,NULL',
        ];
    }
}
