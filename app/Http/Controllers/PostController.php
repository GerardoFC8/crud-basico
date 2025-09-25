<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::with('category')->get();

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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Post creado exitosamente.');
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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post actualizado exitosamente.');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post eliminado exitosamente.');
    }
}

