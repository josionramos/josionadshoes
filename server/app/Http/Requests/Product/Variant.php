<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class Variant extends FormRequest
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
        if ($this->isMethod('put')) {
            return [
                'active' => 'nullable|boolean',
                'media_id' => 'nullable|exists:medias,id'
            ];
        }

        return [
            'price' => 'nullable|integer|min:1',
            'value' => 'required|min:1|max:100',
            'extra' => 'nullable',
            'type_id' => 'required|exists:product_variant_types,id',
        ];
    }
}
