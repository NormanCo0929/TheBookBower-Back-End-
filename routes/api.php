<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Public Routes
Route::post('/login', ['App\Http\Controllers\AuthController', 'login']);
Route::post('/register', ['App\Http\Controllers\AuthController', 'register']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // <---------------User Management CRUD Functions--------------->
    Route::get('/users', ['App\Http\Controllers\UsersController', 'index']);
    Route::get('/users/{id}', ['App\Http\Controllers\UsersController', 'show']);
    Route::post('/users', ['App\Http\Controllers\UsersController', 'store']);
    Route::patch('/users/{id}', ['App\Http\Controllers\UsersController', 'update']);
    Route::delete('/users/{id}', ['App\Http\Controllers\UsersController', 'destroy']);
    Route::get('search/{users}', ['App\Http\Controllers\UsersController', 'search']);

    // <---------------Book Management CRUD Functions--------------->
    Route::get('/books', ['App\Http\Controllers\BooksAdminController', 'index']);
    Route::get('/books/{id}', ['App\Http\Controllers\BooksAdminController', 'show']);
    Route::patch('/books/{id}', ['App\Http\Controllers\BooksAdminController', 'update']);
    Route::post('/books', ['App\Http\Controllers\BooksAdminController', 'store']);
    Route::delete('/books/{id}', ['App\Http\Controllers\BooksAdminController', 'destroy']);
    Route::get('search/{books}', ['App\Http\Controllers\BooksAdminController', 'search']);

    Route::post('/logout', ['App\Http\Controllers\AuthController', 'logout']);
});