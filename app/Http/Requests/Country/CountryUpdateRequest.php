<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryUpdateRequest extends FormRequest
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
            'country_name' => 'required|unique:countries,country_name,'.$this->country_id.',id,deleted_at,NULL',
            'country_code' => 'required|unique:countries,country_code,'.$this->country_id.',id,deleted_at,NULL',
        ];
    }
}
