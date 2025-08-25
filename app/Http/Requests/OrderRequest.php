<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'surname' => [
                'required',
                'string',
                'max:100',
            ],
            'phone' => [
                'required',
                'string',
                'regex: #^(\+\d{1,4})?(\(?\d{1,3}\)?)\s?\-?\s?(\d[\s-]?){6}\d$#'
            ],
            'adress' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}
