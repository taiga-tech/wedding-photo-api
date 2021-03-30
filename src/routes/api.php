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


// Route::get('/user', fn() => Auth::user())->name('user');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('/posts', PostsController::class);

// Route::prefix('posts')->group(function()
// {
//     // Route::apiResource('/', PostsController::class);
//     Route::delete('imagedestroy/{id}', [PostsController::class, 'imageDestroy']);
// });

// -----------------

Route::group(['middleware' => 'api'], function ()
{
    // Route::post('/register', [RegisterController::class, 'register'])
        // ->name('register');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/current_user', function () {
        return Auth::user();
    });

    //----------------------------------------------------------------
    // Route::group(['prefix' => 'user'], function (User $user) {
    Route::apiResource('/posts', PostsController::class)
        ->except('index', 'show', 'update', 'destroy');
    // });

    Route::get('/room/{roomId}', [RoomController::class, 'index']);
    Route::get(
        '/room/{roomId}/photos/{id}',
        [RoomController::class, 'show']
    );
});
