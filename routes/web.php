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
    return view('welcome');
});

Auth::routes();

// notes

Route::get('/home', 'HomeController@index')
    ->name('notes-list')
    ->middleware('auth');

Route::get('/home/{note_id}', 'HomeController@show')
     ->name('notes-view')
     ->middleware('auth');

// facebook-auth
Route::get('oauth/service-two', 'ServiceTwoAuthController@redirectToProvider')->name('service-two-auth');
Route::get('oauth/service-two/callback', 'ServiceTwoAuthController@handleProviderCallback');
