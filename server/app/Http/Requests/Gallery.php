<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Gallery extends FormRequest
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
            'name' => 'required|min:3|max:100|unique:galleries',
            'width' => 'required_without:height',
            'height' => 'required_without:width',
            'cropable' => 'boolean'
        ];

        if ($this->isMethod('put')) {
            $rules['name'] .= ',id,' . $this->id;
        }

        return $rules;
    }
}
