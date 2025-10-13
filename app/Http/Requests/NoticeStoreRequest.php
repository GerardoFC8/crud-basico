<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeStoreRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'unique:notices,slug'],
            'summary' => ['required', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.unique' => 'El slug ya está en uso. Por favor, elige otro.',
            'summary.required' => 'El resumen es obligatorio.',
            'content.required' => 'El contenido es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser uno de los siguientes: draft, published, archived.',
            'user_id.required' => 'El ID de usuario es obligatorio.',
            'user_id.exists' => 'El ID de usuario proporcionado no existe.',
            'category_id.required' => 'El ID de categoría es obligatorio.',
            'category_id.exists' => 'El ID de categoría proporcionado no existe.',
        ];
    }
}
