<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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
// authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

// route for book
Route::get('/book', [BookController::class, 'index']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::get('/search/{search}',[BookController::class, 'search']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/book', [BookController::class, 'store'])->middleware(['admin']);
    Route::patch('/book/{id}', [BookController::class, 'update'])->middleware(['admin']);
    Route::delete('/book/{id}', [BookController::class, 'destroy'])->middleware(['admin']);
});

// Route for review
Route::post('/review', [ReviewController::class, 'store'])->middleware(['auth:sanctum']);
Route::patch('/review/{id}', [ReviewController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->middleware(['auth:sanctum']);


