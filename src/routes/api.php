<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'auth'
], function($router) {
    Route::post('register', [UserController::class, 'register'])->withoutMiddleware(['auth:api']);
    Route::post('login', [UserController::class, 'login'])->withoutMiddleware(['auth:api']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);
    Route::get('user', [UserController::class, 'me']);
    Route::post('work_index', [WorkController::class, 'index']);
    Route::post('work_start', [WorkController::class, 'store']);
    Route::post('work_end', [WorkController::class, 'update']);
    Route::post('break_index', [RestController::class, 'index']);
    Route::post('break_start', [RestController::class, 'store']);
    Route::post('break_end', [RestController::class, 'update']);
});
