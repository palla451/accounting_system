<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('layout.dashboard');
//});


Route::prefix('dashboard')->group(function(){

    Route::get('/', function (){
          return redirect()->route('inputs.index');
    });

//    Route::get('/index', 'InputsController@index');

    Route::resource('inputs','InputsController');

});
