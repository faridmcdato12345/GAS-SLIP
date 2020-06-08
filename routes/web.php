<?php

use App\Application;
use App\Department;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return redirect('/home');
});
Auth::routes();
Route::get('/register',function(){
    abort(404);
});
Route::get('/pinaka-kusog-na-admin','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/pinaka-kusog-na-admin','Auth\RegisterController@register')->name('superadminsave');
Route::post('admin/userprofile/changepass',"UserProfileController@changePass")->name('password.update');
Route::get('admin/userprofile/changepass','UserProfileController@showChangepassView')->name('userprofile.changepass');

Route::resource('/report','ReportController');
Route::group(['middleware'=>'admin'], function (){
    Route::resource('/admin/users', 'AdminUserController');
    Route::resource('/admin/role', 'AdminRoleController');
    Route::resource('/admin/userprofile', 'UserProfileController');
    Route::patch('admin/users/{id}/in_active/','AdminUserController@inActive')->name('user.inactive');
    Route::patch('admin/users/{id}/is_active/','AdminUserController@isActive')->name('user.active');
    Route::resource('/admin/departments', 'DepartmentController');
    Route::resource('/admin/applicants', 'ApplicantController');
    Route::resource('/admin/applications','AdminApplicationController');
    

    Route::get('/report/search','ReportController@action')->name('report.search');
    Route::post('/report/print','ReportController@printReport')->name('report.print');
    Route::get('/department_manager','HomeController@getDmapplication')->name('dm.applicant');
    Route::get('/general_manager','HomeController@getGmApplication')->name('gm.applicant');
    Route::get('/general_manager/application','HomeController@ogmDepartmentShowApplicant')->name('general_manager.application');
    Route::get('/department_manager/{id}/gm_disapproved','gmDisapprovedController@edit')->name('gm_disapprove.edit');
    Route::patch('/department_manager/{id}','HomeController@update')->name('dm.update');
    Route::patch('/department_manager/{id}/approve/','HomeController@approve')->name('application.approve');
    Route::patch('/department_manager/{id}/disapprove/','HomeController@disapprove')->name('application.disapprove');
    Route::patch('/general_manager/{id}/approve/','HomeController@gmapprove')->name('application.gmapprove');
    Route::patch('/general_manager/{id}/disapprove/','HomeController@gmdisapprove')->name('application.gmdisapprove');
    Route::get('/gas_slip','HomeController@gasSlip')->name('gas_slip_print');
    Route::post('/gas_slip','HomeController@gas_slip_get_info')->name('gas_slip_get_info');
    Route::get('/gas_slip_emergency','gasSlipController@index')->name('gas_slip_emergency');
    Route::post('/gas_slip_emergency','gasSlipController@store')->name('gas_slip_emergency.store');
    Route::post('/gas_slip_emergency/print','gasSlipController@showPrint')->name('gas_slip_emergency.print');
    Route::patch('/gas_slip_emergency/{id}','gasSlipController@update')->name('gas_slip_emergency.update');
    Route::post('/gas_slip_save','gasSlipController@gas_slip_get_info')->name('gas_slip_get_info');
    Route::get('/applicant_disapproved','HomeController@getGmApplicationDisapprove')->name('applicant.disapproved');
    Route::patch('/general_manager/application/{id}/approve/','HomeController@gmapproveApplication')->name('application.gmapproveApplicant');
    Route::patch('/general_manager/application/{id}/disapprove/','HomeController@gmdisapproveApplication')->name('application.gmdisapproveApplicant');

    Route::get('/home', 'HomeController@index')->name('home.index');
    Route::post('/home', 'HomeController@getReportDate')->name('home.getReportDate');

    
});
Route::resource('/applications', 'ApplicationController');
Route::get('/applications/get/{application}','ApplicationController@getApplicant')->name('applications.getApplicant');
Route::get('/applications/show/{application}','ApplicationController@showApplicant')->name('applications.showApplicant');
