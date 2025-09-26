<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
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

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('can:users.index');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('can:users.edit');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show'])
         ->middleware('can:categories.index,index')
         ->middleware('can:categories.create,create,store')
         ->middleware('can:categories.edit,edit,update')
         ->middleware('can:categories.destroy,destroy');

    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show')->middleware('can:categories.index');

    // LO MISMO DE ARRIBA, PERO USANDO ROLES
    // Route::middleware('role:CategoriesManager')->group(function () {
    //     Route::resource('categories', CategoryController::class);
    // });

    // Posts
    Route::middleware('role:PostsManager')->group(function () {
        Route::resource('posts', PostController::class);
    });
    
    // Roles & Permissions
    Route::resource('roles', RoleController::class)->middleware('can:roles.index,index')
         ->middleware('can:roles.create,create,store')
         ->middleware('can:roles.edit,edit,update')
         ->middleware('can:roles.destroy,destroy');
         
    Route::resource('permissions', PermissionController::class)->middleware('can:permissions.index,index')
         ->middleware('can:permissions.create,create,store')
         ->middleware('can:permissions.edit,edit,update')
         ->middleware('can:permissions.destroy,destroy');

    // Rutas sin permisos específicos por ahora
    Route::resource('students', StudentController::class);
    Route::get('students-livewire', StudentManager::class)->name('students.livewire');
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