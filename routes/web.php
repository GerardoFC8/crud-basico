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
    Route::get('/posts/reporte/pdf', [PostController::class, 'generatePDF'])->name('posts.pdf');
    Route::get('/posts/{post}/reporte/pdf', [PostController::class, 'generatePostPDF'])->name('posts.single.pdf');

    Route::get('/posts/reporte/excel', [PostController::class, 'exportExcel'])->name('posts.excel');
    Route::get('/posts/{post}/reporte/excel', [PostController::class, 'exportPostExcel'])->name('posts.single.excel');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class); // <-- Permitir todas las acciones
    Route::resource('user-types', UserTypeController::class); // <-- Añadir ruta para tipos

    Route::get('/users/{user}/json', [UserController::class, 'showJson'])->name('users.show.json');
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
require __DIR__.'/profesores.php';

Route::resource('notices', App\Http\Controllers\NoticeController::class);