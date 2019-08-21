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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['role' => 'API\RoleController']);
Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['institucional' => 'API\InstitucionalController']);
Route::apiResources(['unidadorganica' => 'API\UnidadOrganicaController']);
Route::apiResources(['dependencia' => 'API\DependenciaController']);
Route::apiResources(['cargo' => 'API\CargoController']);
Route::apiResources(['cargocalificado' => 'API\CargoCalificadoController']);

Route::get('rolelist','API\RoleController@lista')->name('role.list');
Route::get('unidadorganicalist','API\UnidadOrganicaController@lista');
Route::get('dependencialist','API\DependenciaController@lista');
Route::get('cargolist','API\CargoController@lista')->name('cargo.lista');
Route::get('cargocalificadolist','API\CargoCalificadoController@lista')->name('cargocalificado.lista');
Route::get('rolesearch/{busqueda}','API\UserController@search')->name('role.search');
Route::get('perfil','API\UserController@perfil');
Route::get('rolebyUser','API\RoleController@rolebyuser');
Route::get('dataPersonalUser','API\UserControler@datosPersonales');
Route::get('documentoIdentidadList','API\DocumentoIdentidadController@lista');

Route::post('ubigeoProcesar','API\UbigeoController@procesar')->name('ubigeo.procesar');
