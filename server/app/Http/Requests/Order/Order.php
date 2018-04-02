<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class Order extends FormRequest
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
            'items.*.amount' => 'required',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variants.*.id' => 'required|exists:product_variants,id'
        ];
    }
}
