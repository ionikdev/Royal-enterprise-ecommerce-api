<?php

namespace App\Http\Requests\EcommerceApiRequest;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
            'sellingPrice'=>'required|max:20',
            'originalPrice'=>'required|max:20',
            'brand'=>'required|max:20',
            'quantity'=>'required|max:4',
            'description'=>'max:225',
            'image'=> 'required|image|mimes:png,jpg,jepg|max:2048',
            'feature' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
        ];
    }
}
