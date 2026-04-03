<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Публичные маршруты (без авторизации)
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');

// Публичные маршруты для справочников (ДО регистрации)
Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Country', 'prefix' => 'countries'], function () {
        Route::get('/', [App\Http\Controllers\Api\CountryController::class, 'index']);
    });

    Route::group(['namespace' => 'District', 'prefix' => 'districts'], function () {
        Route::get('/', [App\Http\Controllers\Api\DistrictController::class, 'index']);
    });

    Route::group(['namespace' => 'City', 'prefix' => 'cities'], function () {
        Route::get('/', [App\Http\Controllers\Api\CityController::class, 'index']);
    });

    Route::group(['namespace' => 'School', 'prefix' => 'schools'], function () {
        Route::get('/', [App\Http\Controllers\Api\SchoolController::class, 'index']);
    });
});

// Получение текущего пользователя (требует авторизацию)
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Защищенные маршруты (только для авторизованных)
Route::group(['middleware' => 'auth:sanctum','namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Role', 'prefix' => 'roles'], function () {
        Route::get('/', [App\Http\Controllers\Api\RoleController::class, 'index']);
    });
    
});