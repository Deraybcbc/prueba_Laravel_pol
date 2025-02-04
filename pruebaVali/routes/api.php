<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('/user')->group(function () {
        Route::get('/getUser', [UserController::class, 'getUser'])->name('get-user');
        Route::post('/create', [UserController::class, 'createInfo'])->name('create-info');
    });
});
