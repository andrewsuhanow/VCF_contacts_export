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


Route::post('api/saveTimeData', ['as'=>'saveTimeData', 'uses'=>'Controller@saveTimeData']);
Route::post('api/loadDataFromBD', ['as'=>'loadDataFromBD', 'uses'=>'Controller@loadDataFromBD']);

Route::post('api/DeleteTimeData', ['as'=>'DeleteTimeData', 'uses'=>'Controller@DeleteTimeData']);
Route::post('api/DeleteCard', ['as'=>'DeleteCard', 'uses'=>'Controller@DeleteCard']);
Route::post('api/UpdateCard', ['as'=>'UpdateCard', 'uses'=>'Controller@UpdateCard']);
Route::post('api/saveDataFromTimeData', ['as'=>'saveDataFromTimeData', 'uses'=>'Controller@saveDataFromTimeData']);
Route::post('api/addMewCard', ['as'=>'addMewCard', 'uses'=>'Controller@addMewCard']);
//Route::post('api/findCardIdByOtherData', ['as'=>'findCardIdByOtherData', 'uses'=>'Controller@findCardIdByOtherData']);
Route::post('api/DeleteCardAndAddToStore', ['as'=>'DeleteCardAndAddToStore', 'uses'=>'Controller@DeleteCardAndAddToStore']);

Route::post('api/loadDataFromStoreBD', ['as'=>'loadDataFromStoreBD', 'uses'=>'Controller@loadDataFromStoreBD']);
Route::post('api/restoreCard', ['as'=>'restoreCard', 'uses'=>'Controller@restoreCard']);


