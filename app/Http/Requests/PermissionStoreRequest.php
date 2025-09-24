<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:125'],
            'guard_name' => ['required', 'string', 'max:125'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 125 caracteres.',
            'guard_name.required' => 'El nombre del guardia es obligatorio.',
            'guard_name.string' => 'El nombre del guardia debe ser una cadena de texto.',
            'guard_name.max' => 'El nombre del guardia no debe exceder los 125 caracteres.',
        ];
    }
}
