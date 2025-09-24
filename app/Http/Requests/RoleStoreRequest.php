<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:125', 'unique:roles,name'],
            'guard_name' => ['required', 'string', 'max:125'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['exists:permissions,id'] // Valida que cada ID de permiso exista en la tabla de permisos
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 125 caracteres.',
            'name.unique' => 'Este nombre de rol ya existe.',
            'guard_name.required' => 'El campo guard_name es obligatorio.',
            'permissions.*.exists' => 'El permiso seleccionado no es válido.'
        ];
    }
}
