<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'api'], function () {
    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/current_user', function () {
        return Auth::user();
    })->name('current_user');

    //----------------------------------------------------------------
    Route::apiResource('/posts', PostsController::class)
        ->except('index', 'show', 'update', 'destroy');

    Route::get('/room/{roomId}', [RoomController::class, 'index'])
        ->name('room.index');

    Route::get('/posts/{download}', [PostsController::class, 'download'])
        ->name('posts.download');
});

Route::middleware(['auth','can:isAdmin'])->group(function () {
    Route::apiResource('/admin', AdminController::class)
        ->except('store', 'update', 'destroy');

    Route::post('/admin/{admin}', [AdminController::class, 'delete'])
        ->name('admin.destroy');
});
