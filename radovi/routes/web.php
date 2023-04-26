<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::post('/home', [UserController::class, 'setUserRole']);

Route::post('/editUser', [UserController::class, 'editUserRole']);

Route::get('/addWork', [TaskController::class, 'openMenu']);

Route::post('/addWork', [TaskController::class, 'addWork']);

Route::post('/english', [HomeController::class, 'changeEn']);

Route::post('/croatian', [HomeController::class, 'changeHr']);

Route::post('/registerWork', [UserController::class, 'registerWork']);

Route::get('/accept', [TaskController::class, 'acceptStudent']);

Route::post('/accept/confirm', [UserController::class, 'confirmStudent']);
