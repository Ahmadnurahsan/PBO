<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
// Hapus UserController jika tidak dipakai untuk halaman utama user atau resource
// use App\Http\Controllers\UserController;

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

// Route untuk halaman utama, langsung arahkan ke daftar postingan
Route::get('/', function () {
    return redirect()->route('posts.index'); // Mengarahkan ke route 'posts.index'
})->name('home'); // Memberi nama 'home' pada route ini, opsional tapi baik

// Route `/post` yang lama bisa dihapus jika tidak ada tujuan spesifik lain,
// karena daftar post sudah dihandle oleh `Route::resource('posts', PostController::class);`
// Route::get('/post', function () {
//     return view('posts');
// });


// Rute Autentikasi (Sudah Bagus)
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute untuk Postingan (Sudah Bagus)
// Ini akan membuat route untuk:
// GET /posts -> PostController@index (bernama 'posts.index')
// GET /posts/create -> PostController@create (bernama 'posts.create')
// POST /posts -> PostController@store (bernama 'posts.store')
// GET /posts/{post} -> PostController@show (bernama 'posts.show')
// GET /posts/{post}/edit -> PostController@edit (bernama 'posts.edit')
// PUT/PATCH /posts/{post} -> PostController@update (bernama 'posts.update')
// DELETE /posts/{post} -> PostController@destroy (bernama 'posts.destroy')
Route::resource('posts', PostController::class);

// Route::resource('users', UserController::class); // Ini bisa kamu aktifkan jika ada manajemen user CRUD