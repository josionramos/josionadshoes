<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
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
            'name' => 'required|min:3|max:100|unique:products,name',
            'title' => 'required|min:3|max:160|unique:products,title',
            'slug' => 'required|unique:products,slug',
            'sku' => 'required|unique:products,sku',
            'active' => 'boolean',
            'featured' => 'boolean',
            'price' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'required|min:50|max:200',
            'content' => 'nullable',
            'weight' => 'integer|min:16|max:30000',
            'width' => 'integer|min:16|max:105',
            'height' => 'integer|min:2|max:105',
            'length' => 'integer|min:2|max:105',
            'stock' => 'integer|min:1',
        ];

        if ($this->isMethod('put')) {
            $rules['sku'] .=  ',' . $this->product->id;
            $rules['slug'] .=  ',' . $this->product->id;
            $rules['name'] .=  ',' . $this->product->id;
            $rules['title'] .=  ',' . $this->product->id;
            \Log::debug('RULES', [$rules]);
        }


        return $rules;
    }
}
