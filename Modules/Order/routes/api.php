<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\DepartmentController;
use Modules\Order\Http\Controllers\OrderController;

//TODO add middleware
Route::group(
    [
        'prefix' => 'orders',
        'where' => ['id' => '[0-9]+'],
        'middleware' => 'auth:api',
    ],
    function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/manager', [OrderController::class, 'mangerIndex']);
        Route::post('/manager', [OrderController::class, 'createOrder']);
        Route::get('/department-expanses/{id}', [DepartmentController::class, 'departmentExpanses']);
    }
);
