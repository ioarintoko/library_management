<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', function () {
    return App\Http\Resources\BookResource::collection(App\Models\Book::all());
});

Route::get('/books/{id}', [BookController::class, 'show']);

Route::post('/books', [BookController::class, 'store']);

Route::put('/books/{id}', [BookController::class, 'update']);

Route::delete('/books/{id}', [BookController::class, 'destroy']);

Route::get('/authors', function () {
    return App\Http\Resources\BookResource::collection(App\Models\Book::all());
});

Route::get('/authors/{id}', [AuthorController::class, 'show']);

Route::post('/authors', [AuthorController::class, 'store']);

Route::get('/authors/{id}/books', [AuthorController::class, 'getBooks']);

Route::put('/authors/{id}', [AuthorController::class, 'update']);

Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);