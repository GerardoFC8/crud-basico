<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\;
use App\Models\Notice;
use App\Models\NoticeFromRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NoticeController
 */
final class NoticeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $notices = Notice::factory()->count(3)->create();

        $response = $this->get(route('notices.index'));

        $response->assertOk();
        $response->assertViewIs('notice.index');
        $response->assertViewHas('notice');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('notices.create'));

        $response->assertOk();
        $response->assertViewIs('notice.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoticeController::class,
            'store',
            \App\Http\Requests\NoticeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $slug = fake()->slug();
        $summary = fake()->text();
        $content = fake()->paragraphs(3, true);
        $status = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();
        $category = ::factory()->create();

        $response = $this->post(route('notices.store'), [
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'status' => $status,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $notices = NoticeFromRequest::query()
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('summary', $summary)
            ->where('content', $content)
            ->where('status', $status)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->get();
        $this->assertCount(1, $notices);
        $notice = $notices->first();

        $response->assertRedirect(route('notice.index'));
        $response->assertSessionHas('success', $success);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $notice = Notice::factory()->create();

        $response = $this->get(route('notices.show', $notice));

        $response->assertOk();
        $response->assertViewIs('notice.show');
        $response->assertViewHas('notice');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $notice = Notice::factory()->create();

        $response = $this->get(route('notices.edit', $notice));

        $response->assertOk();
        $response->assertViewIs('notice.edit');
        $response->assertViewHas('notice');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoticeController::class,
            'update',
            \App\Http\Requests\NoticeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $notice = Notice::factory()->create();
        $title = fake()->sentence(4);
        $slug = fake()->slug();
        $summary = fake()->text();
        $content = fake()->paragraphs(3, true);
        $status = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();
        $category = ::factory()->create();

        $response = $this->put(route('notices.update', $notice), [
            'title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'status' => $status,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $notice->refresh();

        $response->assertRedirect(route('notice.show', [$notice]));

        $this->assertEquals($title, $notice->title);
        $this->assertEquals($slug, $notice->slug);
        $this->assertEquals($summary, $notice->summary);
        $this->assertEquals($content, $notice->content);
        $this->assertEquals($status, $notice->status);
        $this->assertEquals($user->id, $notice->user_id);
        $this->assertEquals($category->id, $notice->category_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $notice = Notice::factory()->create();

        $response = $this->delete(route('notices.destroy', $notice));

        $response->assertRedirect(route('notice.index'));

        $this->assertModelMissing($notice);
    }


    #[Test]
    public function test_displays_view(): void
    {
        $response = $this->get(route('notices.test'));

        $response->assertOk();
        $response->assertViewIs('notice.test');
        $response->assertViewHas('notice');
    }
}
