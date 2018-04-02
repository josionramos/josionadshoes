<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class VariantType extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|max:100|unique:product_variant_types',
        ];

        if ($this->isMethod('put')) {
            $rules['name'] .= ',id,' . $this->id;
        }

        return $rules;
    }
}
