<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class Customer extends FormRequest
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
            'name' => 'required|min:5',
            'email' => ['required', 'email'],
            'cpf' => ['required', new Cpf],
            'phone' => ['required', new Phone],
            'birthdate' => 'required'
        ];

        if ($this->isMethod('post')) {
            $rules['cpf'][] = 'unique:customers,cpf';
            $rules['email'][] = 'unique:users';
            $rules['password'] = 'required|min:6|confirmed';
        }

        if ($this->isMethod('put')) {
            $rules['cpf'][] = 'unique:customers,cpf,' . $this->user()->id;
            $rules['email'][] = 'unique:users,email,' . $this->user()->id;
            $rules['password'] = 'nullable|min:6|confirmed';
        }

        return $rules;
    }
}
