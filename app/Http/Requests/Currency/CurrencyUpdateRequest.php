<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyUpdateRequest extends FormRequest
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
            'currency_name' => 'required|unique:currencies,currency_name,'.$this->currency_id.',id,deleted_at,NULL',
            'currency_code' => 'required|unique:currencies,currency_code,'.$this->currency_id.',id,deleted_at,NULL',
        ];
    }
}
