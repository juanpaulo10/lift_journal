<?php
use App\Events\Created;

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
Route::get('/', ['as' => 'home', 'uses' =>'JournalsController@index']);

//api
Route::post('/api/feed', 'JournalsController@show');
Route::post('/api/bodyparts', 'JournalsController@bodyparts');
Route::post('/api/exercises', 'JournalsController@exercises');

Route::post('/api/journal/create', 'JournalsController@store');
Route::delete('/api/journal/{oJournal}', 'JournalsController@destroy');
Route::patch('/api/journal/{oJournal}', 'JournalsController@update');
