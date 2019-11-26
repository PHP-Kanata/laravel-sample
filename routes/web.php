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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ------------------------
// Notes
// ------------------------

Route::get('/notes', 'NotesController@index')
    ->name('notes-list')
    ->middleware('client');
Route::post('/notes', 'NotesController@store')
     ->name('notes-create')
     ->middleware('client');
Route::put('/notes', 'NotesController@update')
     ->name('notes-update')
     ->middleware('client');
