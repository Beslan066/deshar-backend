<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Role', 'prefix' => 'roles'], function () {
        Route::get('/', [App\Http\Controllers\Api\RoleController::class, 'index'])->name('api.roles.index');
    });

    Route::group(['namespace' => 'Country', 'prefix' => 'countries'], function () {
        Route::get('/', [App\Http\Controllers\Api\CountryController::class, 'index'])->name('api.countries.index');
    });

    Route::group(['namespace' => 'District', 'prefix' => 'districts'], function () {
        Route::get('/', [App\Http\Controllers\Api\DistrictController::class, 'index'])->name('api.districts.index');
    });

    Route::group(['namespace' => 'City', 'prefix' => 'cities'], function () {
        Route::get('/', [App\Http\Controllers\Api\CityController::class, 'index'])->name('api.cities.index');
    });

    Route::group(['namespace' => 'School', 'prefix' => 'schools'], function () {
        Route::get('/', [App\Http\Controllers\Api\SchoolController::class, 'index'])->name('api.schools.index');
    });
});
