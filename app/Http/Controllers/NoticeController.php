<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticeStoreRequest;
use App\Http\Requests\NoticeUpdateRequest;
use App\Models\Category;
use App\Models\Notice;
use App\Models\NoticeFromRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(Request $request): View
    {
        $notices = Notice::all();

        return view('notice.index', [
            'notices' => $notices,
        ]);
    }

    public function create(Request $request): View
    {
        $categories = Category::all();
        return view('notice.create' , [
            'categories' => $categories,
        ]);
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'title' => ['required', 'string', 'max:255'],
    //         'slug' => ['required', 'string', 'max:255', 'unique:notices,slug'],
    //         'summary' => ['required', 'string'],
    //         'content' => ['required', 'string'],
    //         'image' => ['nullable', 'string', 'max:255'],
    //         'source' => ['nullable', 'string', 'max:255'],
    //         'tags' => ['nullable', 'string'],
    //         'status' => ['required', 'in:draft,published,archived'],
    //         'published_at' => ['nullable'],
    //         'user_id' => ['required', 'integer', 'exists:users,id'],
    //         'category_id' => ['required', 'integer', 'exists:categories,id'],
    //     ]);

    //     $noticia = new Notice();
    //     $noticia->title = $request->input('title');
    //     $noticia->slug = $request->input('slug');
    //     $noticia->summary = $request->input('summary');
    //     $noticia->content = $request->input('content');
    //     $noticia->image = $request->input('image');
    //     $noticia->source = $request->input('source');
    //     $noticia->tags = $request->input('tags');
    //     $noticia->status = $request->input('status');
    //     $noticia->published_at = $request->input('published_at');
    //     $noticia->user_id = $request->input('user_id');
    //     $noticia->category_id = $request->input('category_id');

    //     // dd($noticia);
    //     $noticia->save();

    //     // $request->session()->flash('success', 'Noticia creada exitosamente.');
    //     return redirect()->route('notices.index')->with('success', 'Noticia creada exitosamente.');
    // }

    public function store(NoticeStoreRequest $request): RedirectResponse
    {
        Notice::create($request->validated());
        return redirect()->route('notices.index')->with('success', 'Noticia creada exitosamente.');
    }

    public function show(Request $request, Notice $notice): View
    {
        return view('notice.show', [
            'notice' => $notice,
        ]);
    }

    public function edit(Request $request, Notice $notice): View
    {
        $categories = Category::all();
        return view('notice.edit', [
            'notice' => $notice,
            'categories' => $categories,
        ]);
    }

    public function update(NoticeUpdateRequest $request, Notice $notice): RedirectResponse
    {
        $notice->update($request->validated());
        return redirect()->route('notices.index')->with('success', 'Noticia actualizada exitosamente.');
    }

    public function destroy(Request $request, Notice $notice): RedirectResponse
    {
        $notice->delete();

        return redirect()->route('notices.index');
    }
}
