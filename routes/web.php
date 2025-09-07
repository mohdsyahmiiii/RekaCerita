<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    $posts = App\Models\Post::published()->with(['user', 'media'])->take(3)->get();
    return view('welcome', compact('posts'));
})->name('home');
Route::get('/blog', [App\Http\Controllers\PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/blog/{slug}', [App\Http\Controllers\PublicPostController::class, 'show'])->name('public.posts.show');

// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/verify-email/{token}', [App\Http\Controllers\AuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('password.update');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User management
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Post management
    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::delete('/posts/{post}/media/{media}', [App\Http\Controllers\PostController::class, 'destroyMedia'])->name('posts.media.destroy');
});
