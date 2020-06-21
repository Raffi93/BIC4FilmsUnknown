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

Route::get('/', 'GuestController@index')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('actor', 'ActorController');
Route::resource('film', 'FilmController');

Route::get('/search/actor', 'ActorController@search')->name('actor.search');
Route::post('/search/actor', 'ActorController@query')->name('actor.query');

Route::get('/list/film', 'FilmController@list')->name('film.list');
Route::get('/list/actor', 'ActorController@list')->name('actor.list');

Route::get('/page/actor', 'ActorController@pageActor')->name('actor.page');
Route::get('/page/film', 'FilmController@pageFilm')->name('film.page');

Route::post('/actor/actorbyslug', 'ActorController@showactorbyslug')->name('actor.showactorbyslug');
Route::post('/film/filmbyslug', 'FilmController@showfilmbyslug')->name('film.showfilmbyslug');
