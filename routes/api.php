<?php

use Illuminate\Http\Request;

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

Route::get('detalles', 'API\PlantillaDetallesController');
Route::get('concentrado', 'API\PlantillaConcentradoController');
Route::get('personal-activo', 'API\PersonalActivoController');
Route::get('personal-activo-detalles', 'API\ListaDetallesPersonalController');
Route::get('datos-persona/{id}', 'API\DatosPersonaController');
Route::get('tabulador', 'API\TabuladorController');