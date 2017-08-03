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


Route::post('/auth/register', 'ApiControllers\UserController@register');
Route::post('/auth/login', 'ApiControllers\UserController@login');




// NOTE:

Route::group(['prefix' => 'v1'], function() {



    Route::group(['middleware' => ['custom.verify.jwt.auth']], function () {
        Route::get('/user', [
          'as' => 'api.v1.user.index',
          'uses' => 'ApiControllers\UserController@getAuthUser'
        ]);

        // REMEMBER: Route::resource() -> defines your controller as a "resourceful controller", which have "limited amount of actions".
        // Categories
        Route::resource('/categories', 'ApiControllers\CategoryController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);
        // Route::get('/categories/test', function() {}); // <- WON'T WORK BECAUSE ABOVE IS Route::resource('/categories', ...);

        // Inventory
        Route::resource('/inventories', 'ApiControllers\InventoryController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // Service
        Route::resource('/services', 'ApiControllers\ServiceController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // ServiceType
        Route::resource('/service_types', 'ApiControllers\ServiceTypeController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // Payment
        Route::resource('/payments', 'ApiControllers\PaymentController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // Department
        Route::resource('/departments', 'ApiControllers\DepartmentController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // Staff
        Route::resource('/staffs', 'ApiControllers\StaffController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // Customer
        Route::resource('/customers', 'ApiControllers\CustomerController', ['as' => 'api.v1', 'except' => ['store', 'create', 'edit']]);

        // Car
        Route::resource('/cars', 'ApiControllers\CarController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // ServiceStatus
        Route::resource('/service_statuses', 'ApiControllers\ServiceStatusController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // TransactionStatus
        Route::resource('/transaction_statuses', 'ApiControllers\TransactionStatusController', ['as' => 'api.v1', 'except' => ['create', 'edit']]);

        // StatusKendaraan
        //Route::resource('/status', 'StatusController', ['except' => ['create', 'edit']]);
    });




});
