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

Route::get('/login', ['as' => 'login', 'uses' => 'SessionsController@create']);

Route::post('/login', 'SessionsController@store');
Route::post('/logout', 'SessionsController@destroy');

Route::get('/home', 'JournalsController@index');
Route::post('/create', 'JournalsController@store');


//api
Route::post('/api/bodyparts', function(){
    return \App\Body_part::all()->toArray();
});
Route::post('/api/exercises', function(){
    return App\Exercise::where('bodypart_id', request(['selectedExercise']) )->get()->toArray();
});