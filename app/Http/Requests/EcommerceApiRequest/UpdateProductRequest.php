<?php

namespace App\Http\Requests\EcommerceApiRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id'=>'max:191',
            'slug'=>'max:191',
            'name'=>'max:191',
            'sellingPrice'=>'max:20',
            'originalPrice'=>'max:20',
            'brand'=>'max:20',
            'quantity'=>'max:4',
            'description'=>'max:225',
            'feature' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'popular' => 'nullable|boolean',
           
        ];
    }
}
