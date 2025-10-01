<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Livewire\StudentManager;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web,professor,student'])->name('dashboard');

Route::middleware(['auth:web'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('professors', ProfessorController::class); // Nueva ruta para profesores
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class); // <-- Permitir todas las acciones
    Route::resource('user-types', UserTypeController::class); // <-- Añadir ruta para tipos
});

// Rutas Públicas de Posts
Route::get('list-posts', [PostController::class, 'listPosts'])->name('posts.list');
Route::get('/blog/{post}', function (Post $post) {
    if ($post->status !== 'published') {
        abort(404);
    }
    return view('post.show-public', compact('post'));
})->name('posts.public.show');


require __DIR__.'/auth.php';