<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('id');
        return [
            'title' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique(Product::class)->ignore($productId),
            ],
            'description' => [
                'required',
                'string',
                'max:1000'
            ],
            'price' => [
                'required',
                'decimal:0,2',
                'max:1000000',
            ],
            'availability' => [
                'required',
                'string',
                'max:255'
            ],
            'discount' => [
                'nullable',
                'integer',
                'min:0',
                'max:100'
            ],
            'sub_subcategory_id' => [
                'bail',
                'required',
                'integer',
                'exists:sub_subcategories,id',
            ],
            'currency_id' => [
                'bail',
                'required',
                'integer',
                'exists:rates,id',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Назва обовязкова',
            'title.max' => 'Назва не повинна перевищувати 255 символів',
            'title.unique' => 'Назва повинна бути унікальною',
            'description' => 'Опис обовязковий і не має перевищувати 1000 символів',
            'price' => 'Ціна має бути у форматі числа',
            'availability' => 'Виберіть наявність',
            'discount' => 'Знижка не може бути більше 100%',
            'sub_subcategory_id' => 'Оберіть підпідкатегорії товару',
            'sub_subcategory_id.exists' => 'Такої підпідкатегорії не існує',


        ];
    }
}
