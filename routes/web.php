<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Livewire\StudentManager;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::resource('students', StudentController::class);
Route::get('students-livewire', StudentManager::class)->name('students.livewire');

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('posts', App\Http\Controllers\PostController::class);
Route::get('list-posts', [App\Http\Controllers\PostController::class, 'listPosts'])->name('posts.list');

Route::get('/blog/{post}', function (Post $post) {
    // Solo muestra posts que estén publicados
    if ($post->status !== 'published') {
        abort(404);
    }
    return view('post.show-public', compact('post'));
})->name('posts.public.show');

Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::resource('permissions', App\Http\Controllers\PermissionController::class);

Route::get('roles/show/{role}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');