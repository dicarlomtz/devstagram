<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', HomeController::class)->name('home');

Route::controller(ProfileController::class)->group(function() {
    Route::get('/edit', 'index')->name('profile.index');
    Route::post('/edit', 'store')->name('profile.store');
});

Route::controller(RegisterController::class)->group(function() {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'store');
});

/* Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
 */

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'store');
});

/* Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']); */

Route::controller(LogoutController::class)->group(function() {
   Route::post('/logout', 'store')->name('logout'); 
});

/* Route::post('/logout', [LogoutController::class, 'store'])->name('logout'); */

Route::controller(PostController::class)->group(function() {
    Route::get('/{user:username}', 'index')->name('posts.index');
    Route::get('/posts/create', 'create')->name('posts.create');
    Route::post('/posts', 'store')->name('posts.store');
    Route::get('/{user:username}/posts/{post}', 'show')->name('posts.show');
    Route::delete('/posts/{post}', 'destroy')->name('posts.destroy');
});

/* Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); */

Route::controller(CommentController::class)->group(function() {
    Route::post('/{user:username}/posts/{post}', 'store')->name('comment.store');
});

/* Route::post('/{user:username}/posts/{post}', [CommentController::class, 'store'])->name('comment.store'); */

Route::controller(ImageController::class)->group(function() {
    Route::post('/images', 'store')->name('images.store');
});

/* Route::post('/images', [ImageController::class, 'store'])->name('images.store'); */

Route::controller(LikeController::class)->group(function() {
    Route::post('/posts/{post}/likes', 'store')->name('posts.likes.store');
    Route::delete('/posts/{post}/likes', 'destroy')->name('posts.likes.destroy');
});

/* Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');*/

Route::controller(FollowerController::class)->group(function() {
    Route::post('/{user:username}/follow', 'store')->name('users.follow');
    Route::delete('/{user:username}/unfollow', 'destroy')->name('users.unfollow');
});