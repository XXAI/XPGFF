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

Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLogin']);
Route::get('/', function () { return Redirect::to('login'); });
Route::post('sign-in','Auth\LoginController@doLogin');

Route::middleware('auth')->get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::middleware('auth')->get('personal-activo', ['as' => 'personal-activo', 'uses' => 'PersonalActivoController']);
Route::middleware('auth')->get('detalles', ['as' => 'detalles', 'uses' => 'PlantillaDetallesController']);
Route::middleware('auth')->get('concentrado', ['as' => 'concentrado', 'uses' => 'PlantillaConcentradoController']);
