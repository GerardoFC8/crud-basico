<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'status',
        'is_featured',
        'views_count',
        'published_at',
        'category_id',
        'tags',
        'meta_data',
        'gallery_images',
        'author_info',
        'manual_created_at', // Campo nuevo
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'is_featured' => 'boolean',
            'published_at' => 'datetime', // Aseguramos que se trate como objeto Carbon
            'category_id' => 'integer',
            'tags' => 'array',
            'meta_data' => 'collection',
            'gallery_images' => 'array',
            'author_info' => 'object',
            'manual_created_at' => 'datetime', // Campo nuevo
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}