<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class Item extends FormRequest
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
                'item.amount' => 'required'
            ];
        }

        return [
            'item.amount' => 'required',
            'item.product_id' => 'required|exists:products,id',
            'item.variants.*.id' => 'required|exists:product_variants,id'
        ];
    }
}
