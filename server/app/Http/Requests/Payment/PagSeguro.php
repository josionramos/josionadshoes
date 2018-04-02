<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PagSeguro extends FormRequest
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
            // Order
            'order_id' => 'required|exists:orders,id',

            // Shipping
            'shipping.price' => 'required',
            'shipping.address_id' => 'required|exists:addresses,id',

            'method' => 'required|exists:payment_types,slug'
        ];

        // Credit card
        if ($this->input('method') === 'credit_card') {
            $rules['hash'] = 'required';
            $rules['creditCard.token'] = 'required';

            $rules['creditCard.installment.price'] = 'required';
            $rules['creditCard.installment.amount'] = 'required';

            if (! $this->input('creditCard.owner')) {
                $rules['creditCard.holder.name'] = 'required';
                $rules['creditCard.holder.cpf'] = 'required';
                $rules['creditCard.holder.birthdate'] = 'required';
                $rules['creditCard.holder.phone'] = 'required';
            }
        }

        return $rules;
    }
}
