<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::all();

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function listPosts(Request $request): View
    {
        $posts = Post::where('status', 'published')->get();

        return view('post.list', [
            'posts' => $posts,
        ]);
    }

    public function create(Request $request): View
    {
        $categories = Category::all();
        return view('post.create', [
            'categories' => $categories,
        ]);
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
        $post = Post::create($request->validated());

        $request->session()->flash('post.id', $post->id);

        return redirect()->route('posts.index');
    }

    public function show(Request $request, Post $post): View
    {
        return view('post.show', [
            'post' => $post,
        ]);
    }

    public function edit(Request $request, Post $post): View
    {
        $categories = Category::all();
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        $request->session()->flash('post.id', $post->id);

        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
