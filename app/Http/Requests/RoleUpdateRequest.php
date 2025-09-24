<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
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
        $roleId = $this->route('role')->id;
        return [
            'name' => ['required', 'string', 'max:125', Rule::unique('roles')->ignore($roleId)],
            'guard_name' => ['required', 'string', 'max:125'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['exists:permissions,id'] // Valida que cada ID de permiso exista en la tabla de permisos
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.unique' => 'Este nombre de rol ya existe.',
            'permissions.*.exists' => 'El permiso seleccionado no es válido.'
        ];
    }
}
