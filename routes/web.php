<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('root');


Route::group(['prefix' => 'admin' , 'middleware' => 'auth'] , function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('categories', CategoryController::class);

    //Post
    Route::get('/posts' , [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}/draft' , [PostController::class , 'draft'])->name('posts.draft');
});

Route::group(['prefix' => 'auth'] , function() {
    Auth::routes();
    // Route::get('/login' , [AuthController::class , 'login'])->name('auth.login');
});
