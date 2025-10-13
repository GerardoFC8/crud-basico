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

    public function store(NoticeStoreRequest $request): RedirectResponse
    {
        $noticeFromRequest = Notice::create($request->validated());

        $request->session()->flash('success', 'Noticia creada exitosamente.');
        return redirect()->route('notices.index');
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

        $request->session()->flash('success', 'Noticia actualizada exitosamente.');
        return redirect()->route('notices.index');
    }

    public function destroy(Request $request, Notice $notice): RedirectResponse
    {
        $notice->delete();

        return redirect()->route('notices.index');
    }
}
