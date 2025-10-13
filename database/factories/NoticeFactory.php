<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Notice;
use App\Models\User;

class NoticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'summary' => fake()->text(),
            'content' => fake()->paragraphs(3, true),
            'image' => fake()->regexify('[A-Za-z0-9]{255}'),
            'source' => fake()->regexify('[A-Za-z0-9]{255}'),
            'tags' => fake()->text(),
            'status' => fake()->randomElement(["draft","published","archived"]),
            'published_at' => fake()->dateTime(),
            'user_id' => User::factory(),
            'category_id' => ::factory(),
        ];
    }
}
