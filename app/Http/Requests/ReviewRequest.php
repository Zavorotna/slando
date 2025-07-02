<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'comment' => [
                'required',
                'string',
                'max:1000'
            ],
            'product_id' => [
                'required',
                'exists:products,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Оберіть рейтинг',
            'rating.min' => 'Мінімальне значення 1',
            'rating.max' => 'Максимальне значення 5',
            'comment' => 'Опис обовязковий і не має перевищувати 1000 символів',
        ];
    }
}
