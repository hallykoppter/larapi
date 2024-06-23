<?php

use App\Http\Controllers\AuthControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthControlller::class, 'register']);
Route::post('/login', [AuthControlller::class, 'login']);
Route::post('/logout', [AuthControlller::class, 'logout'])->middleware('auth:sanctum');
