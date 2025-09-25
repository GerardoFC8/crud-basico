<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'max:10000'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['nullable'],
            'views_count' => ['nullable', 'integer'],
            'published_at' => ['nullable'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El campo título es obligatorio.',
            'content.required' => 'El campo contenido es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser un archivo de tipo: jpg, jpeg, png.',
            'image.max' => 'La imagen no debe ser mayor a 10000 kilobytes.',
            'status.required' => 'El campo estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido. Los valores permitidos son draft, published, archived.',
            'category_id.required' => 'El campo categoría es obligatorio.',
            'category_id.integer' => 'El ID de la categoría debe ser un entero.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
