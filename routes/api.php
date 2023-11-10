<?php
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FollowingsController;
use App\Http\Controllers\BlipsController;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('auth.logout');

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Create blip
    Route::post('/blip/create', [BlipsController::class, 'create'])->middleware(['auth'])->name('blip.create');

    // Delete blip
    Route::delete('/blip/delete', [BlipsController::class, 'delete'])->middleware(['auth:sanctum'])->name('blip.delete');

    // Blip reply
    Route::post('/blip/reply', [BlipsController::class, 'reply'])->middleware(['auth'])->name('blip.reply');

    // Blip like
    Route::post('/blip/like', [BlipsController::class, 'like'])->middleware(['auth'])->name('blip.like');

    // Blip unlike
    Route::post('/blip/unlike', [BlipsController::class, 'unlike'])->middleware(['auth'])->name('blip.unlike');
});
