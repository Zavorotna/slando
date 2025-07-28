<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sub_subcategory_id' => 'nullable|integer|exists:sub_subcategories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'colors' => 'nullable|array',
            'colors.*' => 'integer|exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'integer|exists:sizes,id',
        ];
    }
}
