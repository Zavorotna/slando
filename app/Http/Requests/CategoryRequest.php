<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $categoryId = $this->route('id') ?? null;
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Category::class)->ignore($categoryId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Назва обовязкова',
            'title.max' => 'Назва не повинна перевищувати 255 символів',
            'title.unique' => 'Назва повинна бути унікальною і не має повторюватися',
        ];
    }
}
