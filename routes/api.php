<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\WebsiteController;
use App\Http\Controllers\api\UserController;

Route::controller(WebsiteController::class)->group(function () {
    Route::post('/websites', 'store');
});

Route::controller(PostController::class)->group(function () {
    Route::post('/posts', 'store');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'subscribe');
});
