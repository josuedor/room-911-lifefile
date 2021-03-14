<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\UserController;
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
    return redirect('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('signin', [AuthController::class, 'signin']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('access', [AccessController::class, 'access']);
Route::post('createaccess', [AccessController::class, 'createAccess']);
Route::get('access-activity/{id}', [AccessController::class, 'accessUsers']);
Route::get('search-access-user/{id}', [AccessController::class, 'searchAccessUsers']);

Route::post('user-enabled-or-disable', [UserController::class, 'userEnabledOrDisable']);
Route::post('remove-user', [UserController::class, 'removeUser']);
Route::post('save-user', [UserController::class, 'saveUser']);
Route::get('search-users', [UserController::class, 'searchUsers']);
Route::post('upload-users', [UserController::class, 'import']);

Route::get('dashboard', [UserController::class, 'users']);