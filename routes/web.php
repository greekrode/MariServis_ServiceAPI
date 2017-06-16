<?php




Route::get('/', function () {
    return "MARISERVIS";
});

use Carbon\Carbon;
Route::get('/randomNum', function () {
    return Carbon::now();
});

Route::get('/testIf', "ApiControllers\UserController@testIf");
