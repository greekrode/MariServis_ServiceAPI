<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
"USER" NEED TO HAVE A "LOGIN" TO GET "ACCESS TO THEIR OWN INFORMATION".
THE "TOKEN" FOR USER IS GENERATED USING "JWTAuth".

ADDITIONAL MEANING FROM ABOVE WORDS:
THE ABOVE MEANS... TO GET ACCESS TO "API", USER NEED TO "LOGIN".

NOTE:
WHY NEED "JSON Web Token(JWT)" or "OAuth2"(OAuth2 -> "access_token")?
BECAUSE USER RETRIEVE THEIR INFORMATION THROUGH "TOKEN", NOT "ID".
*/


Route::get('/', function () {
    return "MARISERVIS";
});

use Carbon\Carbon;
Route::get('/randomNum', function () {
    // time() -> Unix timestamp.
    $ref_no = time() . rand(10*45, 100*98);

    return $ref_no; // better CONCATENATE with customer_id
});

Route::get('/explode/{str?}', function ($str = "") {
    $array = array();

    if(strlen($str) > 0) {
      $array = explode(',', $str);
      return count($array);
    }
    return "strlen of $str: " . strlen($str);// -> 0
});

// Route::get('/arraypush', function () {
//     $a = [1, 2, 3, 4, 5];
//     $b = [];
//     $c = array();
//     $d = [];
//     $i = 0;
//
//     foreach ($a as $num) {
//       array_push($b, $num);
//       $c[] = $num;
//       $d[$i] = $num;
//
//       $i += 1;
//     }
//
//     echo '$a = ' . implode($a);
//     echo '$b = ' . implode($b);
//     echo '$c = ' . implode($c);
//     echo '$d = ' . implode($d) . $d[1];
// });

Route::get('/testIf', "ApiControllers\UserController@testIf");

/*
The VerifyCsrfToken middleware, which is included in the "web middleware" group,
will automatically verify that the token in the request input matches the token stored in the session.

THAT'S WHY TokenMismatchException -> in VerifyCsrfToken.php
BY DEFAULT "web.php" protected by "web middleware"
*/
// Route::post('/auth/register', 'UserController@register');
// Route::post('/auth/login', 'UserController@login');
// Route::group(['middleware' => 'jwt.auth'], function () {
//     Route::get('/user', 'UserController@getAuthUser');
// });
