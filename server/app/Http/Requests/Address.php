<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Address extends FormRequest
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
            'zipcode' => 'required|min:8|max:9',
            'street' => 'required|min:5|max:255',
            'number' => 'required|min:1|max:10',
            'complement' => 'nullable',
            'district' => 'required|min:3|max:255',
            'city_id' => 'required|exists:address_cities,id',
        ];
    }
}
