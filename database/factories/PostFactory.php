<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(["['draft'",""]),
            'is_featured' => fake()->boolean(),
            'views_count' => fake()->randomNumber(),
            'published_at' => fake()->dateTime(),
            'category_id' => Category::factory(),
        ];
    }
}
