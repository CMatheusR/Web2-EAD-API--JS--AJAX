<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cliente/load', 'ClienteController@loadJson');
Route::resource('cliente', 'ClienteController');
Route::get('especialidade/load', 'EspecialidadeController@loadJson');
Route::resource('especialidade', 'EspecialidadeController');
Route::get('veterinario/load', 'VeterinarioController@loadJson');
Route::resource('veterinario', 'VeterinarioController');
