<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index');
Route::delete('/booking/{id}', 'HomeController@destroy');
Route::get('ajax', 'AjaxController@getIndex');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('monday', 'MondayController@index');
Route::post('monday', 'MondayController@store');

Route::get('saturday', 'SaturdayController@index');
Route::post('saturday', 'SaturdayController@store');
Route::post('feedback', 'HomeController@feedback');

Route::post('store', 'HomeController@store')->name('admin.feedback.store');

// Auth::routes(['register' => false, 'reset' => false,  'confirm' => false]);
Auth::routes();
Route::get('login', 'Auth\LoginController@index')->name('login'); // login
Route::post('login', 'Auth\LoginController@login')->name('admin.login.submit'); // login submit

Route::get('adminlogin/admin', 'Auth\LoginController@adminLogin')->name('login.adminLogin'); // login
Route::post('adminsubmit/admin', 'Auth\LoginController@adminSubmit')->name('login.adminsubmit'); // login submit
// Route::post('updatePassword', 'LoginController@updatePassword')->name('admin.updatePassword'); // change password submit   change-password
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['auth']], function () {


        Route::get('booking', 'Admin\BookingController@index')->name('admin.booking.index');
        Route::get('/booking/mondayprint', 'Admin\BookingController@mondayprint');
        Route::get('/booking/satprint', 'Admin\BookingController@satprint');
        Route::delete('/booking/{id}', 'Admin\BookingController@destroy');

        Route::get('/closing', 'Admin\ClosingController@index')->name('closing');
        Route::post('/closing', 'Admin\ClosingController@cutoff');

        // Route::get('/employees', 'Admin\EmployeesController@index')->name('employees');
        // Route::post('/employees', 'Admin\EmployeesController@store');
        // Route::any('/employees/search', 'Admin\EmployeesController@search');
        // Route::put('/employee/{id}', 'Admin\EmployeesController@deactivate');

        // Route::get('/blacklist', 'Admin\BlacklistController@index');
        // Route::post('/blacklist', 'Admin\BlacklistController@store');
        // Route::any('/blacklist/search', 'Admin\BlacklistController@search');
        // Route::delete('/blacklist/{id}', 'Admin\BlacklistController@destroy');

        // Route::get('/priority', 'Admin\PriorityController@index');
        // Route::post('/priority', 'Admin\PriorityController@store');
        // Route::any('/priority/search', 'Admin\PriorityController@search');
        // Route::delete('/priority/{id}', 'Admin\PriorityController@destroy');
        // Route::delete('{id}/destroy', 'Admin\PriorityController@destroy')->name('admin.priority.destroy');

        Route::get('/synch-davao', 'Admin\SynchronizeHRISController@synchronize_davao')->name('hris.synchronize_davao');
        Route::get('/synch-agusan', 'Admin\SynchronizeHRISController@synchronize_agusan')->name('hris.synchronize_agusan');

        // Route::get('/change-password', function () 
        // {
        //     $id = \Auth::user()->id;
        //     return view('auth.passwords.change', compact('id'));
        // });
        // Route::patch('/change-password', 'LoginUserController@updatePassword');

        //Route::get('/', 'LoginUserController@change')->name('auth.change'); // change_password
        //Route::post('updatePassword', 'LoginUserController@updatePassword')->name('auth.updatePassword'); // change password submit  

        // Change Password routes
        Route::get('change', 'LoginUserController@change')->name('auth.change'); // change_password
        Route::post('updatePassword', 'LoginUserController@updatePassword')->name('auth.updatePassword'); // change password submit      

        Route::get('/change-password', 'LoginUserController@change_password'); // change_password
        Route::group(['namespace' => 'Admin'], function () {

            // User routes
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', 'UserController@index')->name('admin.users');
                Route::post('store', 'UserController@store')->name('admin.users.store');
                Route::any('search', 'UserController@search')->name('admin.users.search');
                Route::post('/edit', 'UserController@edit')->name('admin.users.edit');
                Route::put('update', 'UserController@update')->name('admin.users.update');
            });

            // Employees routes
            Route::group(['prefix' => 'employees'], function () {
                Route::get('/', 'EmployeesController@index')->name('admin.employees');
                Route::post('store', 'EmployeesController@store')->name('admin.employees.store');
                Route::any('search', 'EmployeesController@search')->name('admin.employees.search');
                Route::put('{id}/deactivate', 'EmployeesController@deactivate')->name('admin.employees.deactivate');
                Route::put('{id}/activate', 'EmployeesController@activate')->name('admin.employees.activate');
                Route::put('{id}/priorities', 'EmployeesController@priorities')->name('admin.employees.priorities');
                Route::delete('{id}/destroy_priorities', 'EmployeesController@destroy_priorities')->name('admin.employees.destroy_priorities');
                Route::put('{id}/blacklists', 'EmployeesController@blacklists')->name('admin.employees.blacklists');
                Route::delete('{id}/destroy_blacklists', 'EmployeesController@destroy_blacklists')->name('admin.employees.destroy_blacklists');
            });

            // Priority routes
            Route::group(['prefix' => 'priority'], function () {
                Route::get('/', 'PriorityController@index')->name('admin.priority');
                Route::any('search', 'PriorityController@search')->name('admin.priority.search');
                Route::delete('{id}/destroy', 'PriorityController@destroy')->name('admin.priority.destroy');
            });

            // Blacklist routes
            Route::group(['prefix' => 'blacklist'], function () {
                Route::get('/', 'BlacklistController@index')->name('admin.blacklist');
                Route::post('store', 'BlacklistController@store')->name('admin.blacklist.store');
                Route::any('search', 'BlacklistController@search')->name('admin.blacklist.search');
                Route::delete('{id}/destroy', 'BlacklistController@destroy')->name('admin.blacklist.destroy');
            });

            // Role routes
            Route::group(['prefix' => 'roles'], function () {
                Route::get('/', 'RoleController@index')->name('admin.roles');
                Route::post('store', 'RoleController@store')->name('admin.roles.store');
                Route::post('/edit', 'RoleController@edit')->name('admin.roles.edit');
                Route::put('update', 'RoleController@update')->name('admin.roles.update');
                Route::any('search', 'RoleController@search')->name('admin.roles.search');
            });

            // Permission routes
            Route::group(['prefix' => 'permissions'], function () {
                Route::get('/', 'PermissionController@index')->name('admin.permissions');
                Route::post('store', 'PermissionController@store')->name('admin.permissions.store');
                Route::post('/edit', 'PermissionController@edit')->name('admin.permissions.edit');
                Route::put('update', 'PermissionController@update')->name('admin.permissions.update');
                Route::any('/search', 'PermissionController@search')->name('admin.permissions.search');
                Route::delete('{id}/destroy', 'PermissionController@destroy')->name('admin.permissions.destroy');
            });

            //Role Access right routes
            Route::group(['prefix' => 'roleaccessrights'], function () {
                Route::get('/', 'RoleRightController@index')->name('admin.roleaccessrights');
                Route::post('store', 'RoleRightController@store')->name('admin.roleaccessrights.store');
                Route::get('store', 'RoleRightController@store')->name('admin.roleaccessrights.store');
            });

            //User Access right routes
            Route::group(['prefix' => 'useraccessrights'], function () {
                Route::get('/', 'UserRightController@index')->name('admin.useraccessrights');
                Route::post('store', 'UserRightController@store')->name('admin.useraccessrights.store');
                Route::get('store', 'UserRightController@store')->name('admin.useraccessrights.store');
            });

            // Report
            Route::group(['prefix' => 'reports'], function () {
                Route::get('licenses/{status}', 'ReportController@licenses')->name('admin.reports.licenses');
                Route::get('listings/{status}', 'ReportController@listings')->name('admin.reports.listings');
                Route::get('violations', 'ReportController@violations')->name('admin.reports.violations');
                Route::get('traffic-violation-report', 'ReportController@trafficViolationReport')->name('admin.reports.traffic-violation-report');
                Route::get('audit-logs', 'ReportController@auditLogs')->name('admin.reports.audit-logs');
                // Route::post('audit-logs', 'ReportController@auditLogs')->name('admin.reports.audit-logs');
                Route::get('error-logs', 'ReportController@errorLogs')->name('admin.reports.error-logs');
            });

            // Application routes
            Route::group(['prefix' => 'application/maintenance'], function () {
                Route::get('/', 'ApplicationController@index')->name('admin.application.index');
                Route::post('store', 'ApplicationController@store')->name('admin.application.store');
                Route::post('edit', 'ApplicationController@edit')->name('admin.application.edit');
                Route::put('update', 'ApplicationController@update')->name('admin.application.update');
                Route::delete('{id}/destroy', 'ApplicationController@destroy')->name('admin.application.destroy');
                Route::any('/search', 'ApplicationController@search')->name('admin.application.search');

                Route::get('{id}/destroy', 'ApplicationController@destroy')->name('admin.application.destroy');

                Route::get('systemDown', 'ApplicationController@systemDown')->name('admin.application.systemDown');
                Route::get('systemUp', 'ApplicationController@systemUp')->name('admin.application.systemUp');

                Route::get('create_indexing', 'ApplicationController@create_indexing')->name('admin.application.create_indexing');
            });
        });


        Route::get('/home/', 'Admin\BookingController@index');
    });
});

Route::group(['prefix' => 'admin/reports'], function () {
    Route::get('/booking-history', 'Admin\BookingHistoryController@index');
    Route::get('/booking-summary', 'Admin\BookingSummaryController@index');
    Route::get('/booking-per-employee', 'Admin\BookingPerEmployeeController@index');
    Route::get('/feedback', 'Admin\FeedbackController@index');
});
