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
Route::apiResources(['procedimiento' => 'API\ProcedimientoController']);
Route::apiResources(['ruta' => 'API\RutaController']);
Route::apiResources(['requisito' => 'API\RequisitoController']);
Route::apiResources(['persona' => 'API\PersonaController']);
Route::apiResources(['solicitante' => 'API\SolicitanteController']);
Route::apiResources(['expediente' => 'API\ExpedienteController']);

//Route::apiResources(['requisitoprocedimiento','API\RequisitoProcedimientoController']);

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
Route::get('procedimientoLista','API\ProcedimientoController@lista')->name('procedimiento.lista');
Route::get('tipoDocumentoLista','API\TipoDocumentoController@lista')->name('tipodocumento.lista');
Route::get('requisitoLista','API\RequisitoController@lista')->name('requisito.lista');
route::get('requiprocLista','API\RequisitoController@requiproc_paginate');
route::get('buscardni','API\PersonaController@buscar_dni')->name('persona.buscardni');
route::get('buscarruc','API\PersonaController@buscar_ruc')->name('persona.buscar.ruc');
Route::get('tipoMovimientoLista','API\TipoMovimientoController@lista')->name('tipomovimiento.lista');

Route::post('ubigeoProcesar','API\UbigeoController@procesar')->name('ubigeo.procesar');
Route::post('guardarProcRequi','API\ProcedimientoController@store_procedimiento_requisito');

