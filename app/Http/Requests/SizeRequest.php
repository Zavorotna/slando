<?php

namespace App\Http\Requests;

use App\Models\Size;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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
        $sizeId = $this->route('size');
        return [
            'name' => [
                'required',
                'string',
                'min:1',
                'max:10',
                Rule::unique(Size::class)->ignore($sizeId),
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Назва обовязкова',
            'name.max' => 'Назва не повинна бути меншоб ніж 1 символ',
            'name.max' => 'Назва не повинна перевищувати 10 символів',
            'name.unique' => 'Назва повинна бути унікальною',
        ];
    }
}
