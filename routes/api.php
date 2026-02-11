<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkUser;
use App\Http\Controllers\Api\ApiController;



Route::post('/login', [ApiController::class, 'login']);
Route::post('/CompressVideo', [ApiController::class, 'CompressVideo']);
Route::post('/CompressImage', [ApiController::class, 'CompressImage']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/get_plan', [ApiController::class, 'get_plan']);
});
