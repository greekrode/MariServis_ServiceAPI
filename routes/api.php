<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {

    // Categories
    Route::resource('/categories', 'CategoryController', ['except' => ['create', 'edit']]);

    // Inventory
    Route::resource('/inventories', 'InventoryController', ['except' => ['create', 'edit']]);

    // Service
    Route::resource('/services', 'ServiceController', ['except' => ['create', 'edit']]);

    // ServiceType
    Route::resource('/servicetypes', 'ServiceTypeController', ['except' => ['create', 'edit']]);

    // Payment
    Route::resource('/payments', 'PaymentController', ['except' => ['create', 'edit']]);

    // Department
    Route::resource('/Departments', 'DepartmentController', ['except' => ['create', 'edit']]);

    // Staff
    Route::resource('/staffs', 'StaffController', ['except' => ['create', 'edit']]);

    // Pelanggan
    Route::resource('/customers', 'CustomerController', ['except' => ['create', 'edit']]);

    // Kendaraan
    Route::resource('/cars', 'CarController', ['except' => ['create', 'edit']]);

    // StatusKendaraan
    Route::resource('/status', 'StatusController', ['except' => ['create', 'edit']]);

});
