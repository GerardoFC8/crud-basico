<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
final class PostControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $posts = Post::factory()->count(3)->create();

        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertViewIs('post.index');
        $response->assertViewHas('posts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('posts.create'));

        $response->assertOk();
        $response->assertViewIs('post.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'store',
            \App\Http\Requests\PostStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);
        $status = fake()->randomElement(/** enum_attributes **/);
        $is_featured = fake()->boolean();
        $views_count = fake()->numberBetween(-10000, 10000);
        $category = Category::factory()->create();

        $response = $this->post(route('posts.store'), [
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'is_featured' => $is_featured,
            'views_count' => $views_count,
            'category_id' => $category->id,
        ]);

        $posts = Post::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('status', $status)
            ->where('is_featured', $is_featured)
            ->where('views_count', $views_count)
            ->where('category_id', $category->id)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('post.id', $post->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post));

        $response->assertOk();
        $response->assertViewIs('post.show');
        $response->assertViewHas('post');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.edit', $post));

        $response->assertOk();
        $response->assertViewIs('post.edit');
        $response->assertViewHas('post');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'update',
            \App\Http\Requests\PostUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $post = Post::factory()->create();
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);
        $status = fake()->randomElement(/** enum_attributes **/);
        $is_featured = fake()->boolean();
        $views_count = fake()->numberBetween(-10000, 10000);
        $category = Category::factory()->create();

        $response = $this->put(route('posts.update', $post), [
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'is_featured' => $is_featured,
            'views_count' => $views_count,
            'category_id' => $category->id,
        ]);

        $post->refresh();

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('post.id', $post->id);

        $this->assertEquals($title, $post->title);
        $this->assertEquals($content, $post->content);
        $this->assertEquals($status, $post->status);
        $this->assertEquals($is_featured, $post->is_featured);
        $this->assertEquals($views_count, $post->views_count);
        $this->assertEquals($category->id, $post->category_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));

        $this->assertSoftDeleted($post);
    }
}
