<?php

namespace App\Http\Requests;

use App\Models\Color;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
        $colorId = $this->route('color');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Color::class)->ignore($colorId),
            ],
            'hex' => [
                'required',
                'string',
                'min:4',
                'max:7',
                Rule::unique(Color::class, 'hex')->ignore($colorId),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва обовязкова',
            'name.max' => 'Назва не повинна перевищувати 255 символів',
            'name.unique' => 'Назва повинна бути унікальною',
            'hex' => 'Колір обовязковий',
            // 'hex.min' => 'Колір не повиннен бути меншим, ніж 4 символи',
            // 'hex.max' => 'Колір не повиннен перевищувати 255 символів',
            // 'hex.unique' => 'Колір повиннен бути унікальним',
        ];
    }
}
