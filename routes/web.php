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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')->post('/change-password', 'HomeController@cambiarContrasenia');

//Rutas protegidas con autenticación y sesion valida
Route::middleware('auth')->group(function () {
    Route::resource('/inventory', 'InventoryController');
    Route::post('/inventory/upload', 'InventoryController@importExcel');
    Route::delete('/inventory/delete-assignment/{id}', 'InventoryController@eliminarAsignacion');
});
