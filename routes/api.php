<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
});

/**
 * Author Routes
 */
Route::middleware('auth:api')->prefix('authors')->group(function () {
    Route::post('/', [AuthorController::class, 'store']);
    Route::get('/', [AuthorController::class, 'index']);
    Route::put('/{id}', [AuthorController::class, 'update']);
    Route::delete('/{id}', [AuthorController::class, 'destroy']);
    Route::get('/trashed', [AuthorController::class, 'trashed']);

});




/**
 * category Routes
 */
Route::middleware('auth:api')->prefix('categories')->group(function () {
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/', [CategoryController::class, 'index']);
    Route::delete('/{id}', action: [CategoryController::class, 'destroy']);
    Route::get('/trashed', action: [CategoryController::class, 'trashed']);

});


/**
 * book Routes
 */
Route::middleware('auth:api')->prefix('books')->group(function () {
    Route::post('/', [BookController::class, 'store']);
    Route::get('/', [BookController::class, 'index']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
    Route::get('/trashed', action: [BookController::class, 'trashed']);
    Route::post('/searching', [BookController::class, 'search']);

});


/**
 * order Routes
 */
Route::middleware('auth:api')->group(function () {
    Route::post('/orders', [OrderController::class, 'create']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

