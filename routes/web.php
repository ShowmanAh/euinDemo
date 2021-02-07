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

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard', function(){
    return view('Dashboard.index');
  });
  Route::group(['namespace'=>'Admin','prefix' => 'products'], function () {
    Route::get('/', 'ProductController@index')->name('admin.products');
    Route::get('/create', 'ProductController@create')->name('admin.products.create');
    Route::post('/store', 'ProductController@store')->name('admin.products.store');
    Route::get('/edit/{id}', 'ProductController@edit')->name('admin.products.edit');
    Route::put('/update/{id}', 'ProductController@update')->name('admin.products.update');
    Route::delete('/destroy/{id}', 'ProductController@destroy')->name('admin.products.destroy');
 });
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
