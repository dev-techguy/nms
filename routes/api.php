<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

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

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Api'], function ()
{
    /*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });*/

    //Setup APIs
    Route::post('/register', 'RegisterController@register');
    Route::post('/register/otp', 'RegisterController@validateOTP');
    Route::get('/register/verify', 'RegisterController@verify');

    //Route::post('/login/otp', 'LoginController@getOTP');

    Route::post('/login', 'LoginController@login');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/vehicles', 'VehicleController@listVehicles');

        Route::get('/profile', 'ProfileController@index');
        Route::get('/profile-emt', 'ProfileController@getEMTProfile');
        Route::get('/profile-nurse', 'ProfileController@getNurseProfile');

        //Route::post('/check-in', 'DriverController@checkIn');
        //Route::post('/check-out', 'DriverController@checkOut');
        Route::post('/fcm', 'DriverController@saveFCM');

        Route::post('/check-in-emt-nurse', 'ResponderController@checkInEMTNurse');
        Route::post('/check-out-emt-nurse', 'ResponderController@checkOutEMTNurse');

        Route::get('/tasks', 'TaskController@tasks');
        Route::get('/task/{id}', 'TaskController@singleTask');
        Route::post('/task/{action}/{id}', 'TaskController@taskAction');
        Route::get('/tasks/summary', 'TaskController@tasksSummary');

        Route::get('/case/{id}', 'TaskController@singleCase');

        Route::get('/logs', 'ProfileController@logs');

        Route::post('/logout', 'LoginController@logout');
    });

});



Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
