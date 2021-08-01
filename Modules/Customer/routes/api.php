<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\DepartmentController;
use Modules\Customer\Http\Controllers\CustomerController;

//TODO add middleware
Route::group(
    [
        'prefix' => 'customers',
        'where' => ['id' => '[0-9]+'],
        'middleware' => 'auth:api',
    ],
    function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/manager', [CustomerController::class, 'mangerIndex']);
        Route::post('/manager', [CustomerController::class, 'createCustomer']);
        Route::get('/department-expanses/{id}', [DepartmentController::class, 'departmentExpanses']);
    }
);
