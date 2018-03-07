<?php

use Illuminate\Http\Request;
use Laravel\Passport\Passport;

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

// GET Current user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



// Todas as rotas de GRUPO

Route::get('/group/{id?}', 'Api\GroupController@getGroupById');
Route::get('/group/{id?}/owner', 'Api\GroupController@getOwnerOfGroupById');
Route::get('/group/{id?}/members', 'Api\GroupController@getMembersOfGroupById');
Route::get('/group/{id?}/events', 'Api\GroupController@getEventsOfGroupById');
Route::get('/my-groups', 'Api\GroupController@getMyGroups');
Route::get('/groups-joined', 'Api\GroupController@getGroupsJoined');
Route::get('/all-groups/{search?}', 'Api\GroupController@getAllGroups');
Route::get('/all-groups-except-joined/{search?}', 'Api\GroupController@getAllGroupsExceptJoined');
Route::post('/create-group', 'Api\GroupController@createGroup');
Route::post('/group/join', 'Api\GroupController@joinGroup');

Route::get('/event/{id?}', 'Api\EventController@getEventById');
Route::get('/event/{id?}/participants', 'Api\EventController@getParticipantsOfEventById');
Route::get('/all-my-events', 'Api\EventController@getAllMyEvents');
Route::post('/event-check-in', 'Api\EventController@eventCheckIn');
Route::post('/create-event', 'Api\EventController@createEvent');
Route::post('/change-event-payment-status', 'Api\EventController@changePaymentStatus');