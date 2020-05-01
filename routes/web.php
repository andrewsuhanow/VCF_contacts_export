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

Route::get('/', ['as'=>'main', 'uses'=>'Controller@first'])->middleware('myMiddleW');


Route::post('api/1', ['as'=>'main', 'uses'=>'Controller@main']);
Route::post('api/saveInformList', ['as'=>'saveInformList', 'uses'=>'Controller@saveInformList']);




