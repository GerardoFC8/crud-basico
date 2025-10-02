<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'max:3096'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['nullable', 'boolean'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'string'],
            'meta_data' => ['nullable', 'array'],
            'meta_data.*.key' => ['nullable', 'string', 'max:255'],
            'meta_data.*.value' => ['nullable', 'string', 'max:255'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['max:3096'],
            'author_info' => ['nullable', 'array'],
            'author_info.name' => ['nullable', 'string', 'max:255'],
            'author_info.role' => ['nullable', 'string', 'max:255'],
            'manual_created_at' => ['nullable', 'date'], // Regla para el nuevo campo
            'published_at' => ['nullable', 'date'],      // Regla para el campo condicional
        ];
    }
}