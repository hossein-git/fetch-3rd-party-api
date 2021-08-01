<?php

use Illuminate\Support\Facades\Route;
use Modules\Monitoring\Http\Controllers\DepartmentController;
use Modules\Monitoring\Http\Controllers\MonitoringController;

//TODO add middleware
Route::group(
    [
        'prefix' => 'monitorings',
        'where' => ['id' => '[0-9]+'],
        'middleware' => 'auth:api',
    ],
    function () {
        Route::get('/', [MonitoringController::class, 'index']);
        Route::get('/manager', [MonitoringController::class, 'mangerIndex']);
        Route::post('/manager', [MonitoringController::class, 'createMonitoring']);
        Route::get('/department-expanses/{id}', [DepartmentController::class, 'departmentExpanses']);
    }
);
