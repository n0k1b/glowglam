<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyStoreRequest extends FormRequest
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
            'currency_name' => 'required|unique:currencies,currency_name,NULL,id,deleted_at,NULL',
            'currency_code' => 'required|unique:currencies,currency_code,NULL,id,deleted_at,NULL',
        ];
    }
}
