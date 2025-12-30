<?php

use Illuminate\Support\Facades\Route;

Route::get("/test", function () {
    return response()->json(["message" => "API is working"]);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

});

Route::middleware(["jwt.auth"])->group(function () {
    Route::get('/me', [App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']);
});



