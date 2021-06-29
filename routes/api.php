<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::post('/login', 'Auth\LoginController@login');


Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('/home', 'API\HomeController')->except(['show']);
    Route::resource('/sections', 'API\SectionController')->except(['show']);
    Route::resource('/positions', 'API\PositionController')->except(['show']);
    Route::resource('/users', 'API\UserController')->except(['show']);
    Route::resource('/activities', 'API\ActivityController')->except(['show']);

    Route::resource('/assignments', 'API\AssignmentController')->except(['show']);
    Route::get('/assignments/download', 'API\AssignmentController@download');

    Route::resource('/personscore', 'API\PersonScoreController')->except(['show']);
    Route::resource('/sectionscore', 'API\SectionScoreController')->except(['show']);

    Route::resource('/recapitulation', 'API\RecapitulationController')->except(['show']);
    Route::get('/recapitulation/download', 'API\RecapitulationController@download');

    Route::resource('/loas', 'API\LoaController')->except(['show']);

    Route::resource('/monitoring', 'API\MonitoringController')->except(['show']);
    Route::get('/monitoring/assignments', 'API\MonitoringController@getAssignments');

    Route::resource('/notifications', 'API\NotificationController')->except(['show']);

    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::post('/upload/{id}', 'API\AssignmentController@upload');
    Route::post('/storeregtoken', 'API\UserController@storeRegToken');
    Route::post('/uploadphoto/{id}', 'API\UserController@uploadPhoto');
    Route::post('/update-status/{id}', 'API\AssignmentController@updateStatus');
    Route::post('/count-score/{id}', 'API\ScoreController@countFinalScore');
    Route::get('/activities/{id}', 'API\ActivityController@getActivitiesBySection');
    Route::get('/usersechelonstaff', 'API\UserController@getUsersEchelonStaff');
    Route::post('/count-person', 'API\PersonScoreController@recap');
    Route::post('/count-section', 'API\SectionScoreController@recap');
});
