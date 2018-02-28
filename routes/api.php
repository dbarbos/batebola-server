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

Route::get('/meus-grupos', 'Api\GrupoController@getMeusGrupos');
Route::get('/todos-os-grupos/{search?}', 'Api\GrupoController@getTodosOsGrupos');
Route::post('/criar-grupo', 'Api\GrupoController@createGrupo');
