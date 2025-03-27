<?php

use App\Http\Controllers\Landing\ThumbnailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Landing\PostController;

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

// halaman home
Route::get('/', function () {
    return Inertia::render('Home1', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('post/{id}', [PostController::class,'show'])
    ->name('posts.show');

Route::get('/thumbnails', [ThumbnailController::class, 'index'])
    ->name('thumbnail.index');
Route::get('/thumbnail/{id}', [ThumbnailController::class, 'show'])
    ->name('thumbnail.show');

Route::get('/music', function () {
    return Inertia::render('Music/Index');
})->name('music.index');

Route::get('/menu', function() {
    return Inertia::render('Menu/Index');
})->name('menu.index');

Route::get('note', function () {
    return Inertia::render('Note/Index');
})->name('note.index');

// rute untuk user dashbord
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// halaman 404
Route::get('/{any}', function () {
    return Inertia::render('404');  // Menyajikan halaman 404
})->where('any', '.*')->name('404');
