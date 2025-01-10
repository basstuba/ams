<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\FixesController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MonthlyController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\SelectController;
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

    Route::get('all_user', [AllUserController::class, 'index']);
    Route::post('user_data', [AllUserController::class, 'show']);

    Route::get('yesterday', [DailyController::class, 'index']);
    Route::post('day_before', [DailyController::class, 'showBefore']);
    Route::post('day_after', [DailyController::class, 'showAfter']);

    Route::post('this_month', [MonthlyController::class, 'index']);
    Route::post('month_before', [MonthlyController::class, 'showBefore']);
    Route::post('month_after', [MonthlyController::class, 'showAfter']);

    Route::post('date_search', [FixesController::class, 'search']);
    Route::post('work_fixes', [FixesController::class, 'workUpdate']);
    Route::post('rest_fixes', [FixesController::class, 'restUpdate']);

    Route::post('work_add', [AddController::class, 'store']);

    Route::post('individual_register', [AdminController::class, 'store']);
    Route::post('information_change', [AdminController::class, 'update']);
    Route::post('individual_search', [AdminController::class, 'search']);

    Route::post('import', [ImportController::class, 'import']);

    Route::get('select_role', [SelectController::class, 'showRole']);
    Route::get('select_department', [SelectController::class, 'showDepartment']);
});
