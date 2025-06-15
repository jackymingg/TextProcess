<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TextProcessRequest extends FormRequest
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
            'text' => 'required|string',
            'operations' => 'required|array|min:1',
            'operations.*' => 'required|string|in:reverse,uppercase,lowercase,remove_spaces'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'text.required' => 'Text field is required',
            'text.string' => 'Text must be a string',
            'operations.required' => 'Operations field is required',
            'operations.array' => 'Operations must be an array',
            'operations.min' => 'At least one operation is required',
            'operations.*.required' => 'Each operation is required',
            'operations.*.string' => 'Each operation must be a string',
            'operations.*.in' => 'Invalid operation. Allowed operations are: reverse, uppercase, lowercase, remove_spaces'
        ];
    }
}