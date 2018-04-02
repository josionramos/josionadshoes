<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class Category extends FormRequest
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
            'name' => 'required|min:3|max:100|unique:product_categories',
            'parent_id' => 'nullable|exists:product_categories,id',
            'active' => 'boolean',
            'variants.*.id' => 'nullable|exists:product_variant_types,id',
        ];

        if ($this->isMethod('put')) {
            $rules['name'] .= ',id,' . $this->id;
        }

        return $rules;
    }
}
