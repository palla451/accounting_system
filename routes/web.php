<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/','UserAuthController@login');
Route::get('index', 'UserAuthController@index');
Route::get('login', 'UserAuthController@login')->name('login');
Route::get('register', 'UserAuthController@register');
Route::post('post-login', 'UserAuthController@postLogin');
Route::post('post-register', 'UserAuthController@postRegister');
Route::get('dashboard', 'UserAuthController@dashboard');
Route::get('logout', 'UserAuthController@logout')->name('logout');


Route::middleware('auth')->prefix('dashboard')->group(function(){

    Route::get('/', function (){
          return redirect()->route('inputs.index');
    });

    Route::get('user/profile/{id}', 'ShowProfile')->name('myProfile');
    Route::resource('inputs','InputsController');
    Route::resource('outputs','OutputsController');

    Route::get('chartApiInput', 'InputsController@chartApiInput')->name('chartApiInput');
    Route::get('chartApiOutput', 'OutputsController@chartApiOutput')->name('chartApiOutput');

    Route::resource('users','UserController');
    Route::delete('users/delete/{id}','UserController@delete');
    Route::patch('users/restore/{id}', 'UserController@restore');

});

Route::get('/clear-cache', function() {
   Artisan::call('cache:clear');
    return "Cache is cleared";
});
