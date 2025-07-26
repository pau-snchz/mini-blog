<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikedBlogsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminCommentsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authenticated blog routes
Route::middleware(['auth'])->group(function () {
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
    Route::get('/liked-blogs', [LikedBlogsController::class, 'index'])->name('liked.blogs');
    Route::delete('/liked-blogs/{id}', [LikedBlogsController::class, 'removeLike'])->name('liked.blogs.remove');
    Route::delete('/comment/{id}', [BlogController::class, 'destroyComment'])->name('comment.destroy');
});

Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
Route::post('/blog/{id}/like', [BlogController::class, 'toggleLike'])->name('blog.like');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Dashboard (must be admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/stats', [AdminDashboardController::class, 'stats'])->name('admin.stats');
    Route::get('/admin/posts', [AdminDashboardController::class, 'posts'])->name('admin.posts');

    // Admin posts moderation
    Route::delete('/admin/posts/{id}', [AdminDashboardController::class, 'destroy'])->name('admin.posts.destroy');

    // Admin users management
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/data', [AdminUsersController::class, 'data'])->name('admin.users.data');
    Route::patch('/admin/users/{id}/type', [AdminUsersController::class, 'updateType'])->name('admin.users.type');
    Route::patch('/admin/users/{id}/ban', [AdminUsersController::class, 'updateBan'])->name('admin.users.ban');

    // Admin comments moderation
    Route::get('/admin/comments', [AdminCommentsController::class, 'index'])->name('admin.comments');
    Route::get('/admin/comments/data', [AdminCommentsController::class, 'comments'])->name('admin.comments.data');
    Route::patch('/admin/comments/{id}', [AdminCommentsController::class, 'update'])->name('admin.comments.update');
});