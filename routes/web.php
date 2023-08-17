<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FollowingsController;
use App\Http\Controllers\BlipsController;

use Illuminate\Support\Facades\Route;

use App\Models\User;

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
})->name('home');

Route::get('/timeline', function () {
    return view('pages.authenticated.timeline');
})->middleware(['auth'])->name('timeline.index');

/* Blips: Post routes */

// Create blip
Route::post('/blip/create', [BlipsController::class, 'create'])->middleware(['auth'])->name('blip.create');

// Delete blip
Route::delete('/blip/delete', [BlipsController::class, 'delete'])->middleware(['auth'])->name('blip.delete');

// Blip reply
Route::post('/blip/reply', [BlipsController::class, 'reply'])->middleware(['auth'])->name('blip.reply');

// Blip like
Route::post('/blip/like', [BlipsController::class, 'like'])->middleware(['auth'])->name('blip.like');

// Blip unlike
Route::post('/blip/unlike', [BlipsController::class, 'unlike'])->middleware(['auth'])->name('blip.unlike');

Route::get('/blip/{id}', function ($id) {
    return view('pages.blip', ['id' => $id]);
})->name('blip.index'); 

// Settings page
Route::get('/settings', function () {
    return view('pages.authenticated.settings');
})->middleware(['auth'])->name('settings.index');


// Settings page: Post route
Route::post('/settings/info', [SettingsController::class, 'saveBasicInfo'])->middleware(['auth'])->name('settings.save.info');
Route::post('/settings/profile_picture', [SettingsController::class, 'saveProfilePicture'])->middleware(['auth'])->name('settings.save.profile_picture');

// Profile route 
Route::get('/p/{username}', function ($username) {
    // Make sure username exists
    if (!User::where('username', $username)->exists()) {
        return redirect()->route('home')->with('error', 'User does not exist.');
    }
    return view('pages.profile', ['user' => User::where('username', $username)->first()]);
})->name('profile.index');

// Follow route
Route::post('/follow', [FollowingsController::class, 'follow'])->middleware(['auth'])->name('follow');
Route::post('/unfollow', [FollowingsController::class, 'unfollow'])->middleware(['auth'])->name('unfollow');

require __DIR__.'/auth.php';
