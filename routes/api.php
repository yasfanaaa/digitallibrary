<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\LoansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewController;


// Route::get('/user', function (Request $request) {
 //   return $request->user();
// })->middleware('auth:sanctum');

Route::post('/users/{id}', [UsersController::class, 'store']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);
Route::put('/users/{id}', [UsersController::class, 'update']);

Route::apiResource('categories', CategoryController::class);

Route::apiResource('reviews', ReviewController::class);

Route::apiResource('loans', LoansController::class);

Route::apiResource('books', BooksController::class);

Route::get('/reviews', [ReviewController::class, 'index']);


