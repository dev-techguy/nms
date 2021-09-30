<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/storage', function () {
    \Artisan::call('storage:link');
    return "Symlink process successfully completed";
});

Route::get('/run-migrate', function () {
    \Artisan::call('migrate', [
        '--force' => true,
    ]);
    return "Migration process successfully completed";
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    /*Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    Route::group(['middleware' => ['permission:Read Watchers Panel', 'permission:Read Dispatchers Panel']], function () {

        Route::get('/usertype', 'WatcherDispatcherController@login')->name('watchers.dispatchers.login');
        Route::post('/usertype', 'WatcherDispatcherController@setUserType')->name('watchers.dispatchers.settype');
        Route::post('generate-report', 'ReportController@report')->name('generate.report');

        Route::group(['middleware' => ['watcher', 'permission:Read Watchers Panel']], function () {
            Route::group(['prefix' => 'watchers'], function () {
                Route::get('/', 'Watchers\DashboardController')->name('watchers.dashboard');
                Route::get('single-case', 'Watchers\CaseController@singleCasePage')->name('single.case.watchers');
                Route::get('mass-case', 'Watchers\CaseController@massCasePage')->name('mass.case.watchers');

                Route::get('incidents/{incident}/resolve', 'Watchers\IncidentController@resolveCase')->name('incidents.resolve.case');
                Route::post('incidents/{incident}/resolve', 'Watchers\IncidentController@resolve')->name('incidents.resolve');
                Route::post('incidents/{incident}/submit', 'Watchers\IncidentController@submit')->name('incidents.submit');
                Route::resource('incidents', 'Watchers\IncidentController');

                Route::get('/reports', 'Watchers\ReportController@index')->name('watchers.report');
                Route::get('/reports/cases', 'Watchers\ReportController@cases')->name('watchers.report.cases');
                Route::get('/reports/cases/pdf', 'Watchers\ReportController@casesPDF')->name('watchers.report.cases.pdf');
                Route::get('/reports/cases/excel', 'Watchers\ReportController@casesExcel')->name('watchers.report.cases.excel');

            });
        });

        Route::group(['middleware' => ['dispatcher', 'permission:Read Dispatchers Panel']], function () {
            Route::group(['prefix' => 'dispatchers'], function () {

                Route::get('/', 'Dispatchers\DashboardController')->name('dispatchers.dashboard');
                Route::get('all-cases', 'Dispatchers\CaseController@allCases')->name('cases.allcases');
                Route::post('cases/{case}/manage', 'Dispatchers\CaseController@manage')->name('cases.manage');
                Route::get('cases/{case}/details', 'Dispatchers\CaseController@details')->name('cases.dispatch.details');

                Route::get('cases/{case}/hospital-level', 'Dispatchers\CaseController@hospitalLevel')->name('cases.dispatch.hospital-level');
                Route::post('cases/{case}/hospital-level', 'Dispatchers\CaseController@storeHospitalLevel')->name('cases.dispatch.store.hospital-level');

                Route::get('cases/{case}/hospital', 'Dispatchers\CaseController@hospital')->name('cases.dispatch.hospital');
                Route::post('cases/{case}/hospital', 'Dispatchers\CaseController@storeHospital')->name('cases.dispatch.store.hospital');

                Route::get('cases/{case}/responders', 'Dispatchers\CaseController@responders')->name('cases.dispatch.responders');

                Route::get('cases/{case}/tasks', 'Dispatchers\CaseController@tasks')->name('cases.dispatch.tasks');

                Route::get('cases/{case}/task/{task}', 'Dispatchers\CaseController@taskShow')->name('cases.dispatch.task.show');

                Route::get('cases/{case}/report', 'Dispatchers\CaseController@report')->name('cases.dispatch.report');
                Route::post('cases/{case}/report', 'Dispatchers\CaseController@storeReport')->name('cases.dispatch.store.report');

                Route::get('cases/{case}/alternate-hospital', 'Dispatchers\CaseController@alternateHospital')->name('cases.dispatch.alternate-hospital');
                Route::post('cases/{case}/alternate-hospital', 'Dispatchers\CaseController@storeAlternateHospital')->name('cases.dispatch.store.alternate-hospital');

                Route::get('cases/{case}/resolve', 'Dispatchers\CaseController@resolveCase')->name('cases.resolve.case');
                Route::post('cases/{case}/resolve', 'Dispatchers\CaseController@resolve')->name('cases.resolve');

                Route::resource('cases', 'Dispatchers\CaseController')->except([
                    'create', 'store', 'update', 'destroy'
                ]);

                Route::post('/tasks/store', 'TaskController@store')->name('tasks.store');

                Route::get('/reports', 'Dispatchers\ReportController@index')->name('dispatchers.report');
                Route::get('/reports/cases', 'Dispatchers\ReportController@cases')->name('dispatchers.report.cases');

                Route::get('/reports/cases/pdf', 'Dispatchers\ReportController@casesPDF')->name('dispatchers.report.cases.pdf');
                Route::get('/reports/cases/excel', 'Dispatchers\ReportController@casesExcel')->name('dispatchers.report.cases.excel');

                Route::get('/realtime', 'Dispatchers\CaseController@realtime')->name('dispatchers.realtime');
                Route::get('/realtime-table', 'Dispatchers\CaseController@realtimeTable')->name('dispatchers.realtime.table');

            });
        });

    });

    Route::group(['middleware' => ['admin', 'permission:Read Admin Panel']], function () {

        Route::get('/', 'Dashboard')->name('dashboard');
        //Route::get('/', 'Dispatch@index')->name('dashboard');
        Route::get('/dispatch', 'DispatchController@index')->name('dispatch.index');
        Route::get('/dispatch/list', 'DispatchController@listView')->name('dispatch.list');

        Route::resource('drivers', 'DriverController');

        Route::resource('emts', 'EMTController');

        Route::resource('nurses', 'NurseController');

        Route::get('/tasks', 'TaskController@index')->name('tasks.index');
        /*Route::get('/tasks/create/{id}', 'TaskController@create')->name('tasks.create1');
        Route::post('/tasks/store/{id}', 'TaskController@store')->name('tasks.store1');*/
        Route::get('/tasks/{task}', 'TaskController@show')->name('tasks.show');
        Route::delete('/tasks/{task}', 'TaskController@destroy')->name('tasks.destroy');

        Route::get('/vehicles', 'VehicleController@index')->name('vehicles.index');

        Route::resource('emergency-centers', 'EmergencyCenterController');
        Route::resource('dispatch-centers', 'DispatchCenterController');
        Route::resource('ambulances', 'AmbulanceController');
        Route::resource('facilities', 'FacilityController');
        Route::resource('stakeholders', 'StakeholderController');

        Route::group(['middleware' => ['permission:Manage Users']], function () {

            Route::resource('users', 'Users\UserController');

            Route::resource('roles', 'Users\RoleController');

            Route::resource('permissions', 'Users\PermissionController');
        });
    });

});
