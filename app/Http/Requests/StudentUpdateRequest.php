<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'nombres' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'string', 'max:100', 'unique:students,correo'],
            'cedula' => ['required', 'string', 'max:20', 'unique:students,cedula'],
            'edad' => ['nullable', 'integer'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'status' => ['required', 'in:activo,inactivo,graduado'],
        ];
    }
}
