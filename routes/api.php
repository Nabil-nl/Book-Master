<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// login register logout 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
//genres
Route::apiResource('genres', GenreController::class);
//  books 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'show']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
});
//member
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::post('/members', [MemberController::class, 'store']);
    Route::get('/members/{member}', [MemberController::class, 'show']);
    Route::put('/members/{member}', [MemberController::class, 'update']);
    Route::delete('/members/{member}', [MemberController::class, 'destroy']);
});
//loans
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/loans/issue', [LoanController::class, 'issue']);
    Route::put('/loans/return/{loan}', [LoanController::class, 'return']);
});

