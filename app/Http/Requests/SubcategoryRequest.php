<?php

namespace App\Http\Requests;

use App\Models\Subcategory;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
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
        $subcategoryId = $this->route('id');
        return [
            'title' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique(Subcategory::class)->ignore($subcategoryId),
            ],
            'category_id' => [
                'bail',
                'required',
                'integer',
                'exists:categories,id',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Назва обовязкова',
            'title.max' => 'Назва не повинна перевищувати 255 символів',
            'title.unique' => 'Назва повинна бути унікальною і не має повторюватися',
            'category_id.required' => 'Виберіть категорію з випадаючого списку',
            'category_id.exists' => 'Данної категорії не існує'
        ];
    }
}
