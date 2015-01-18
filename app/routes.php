<?php

Route::get('/', ['as'=>'home', 'uses'=>'MovieController@index']);
Route::post('movie/search', ['as'=>'movie.search', 'uses'=>'MovieController@search']);
Route::get('movie/filter/{field}/{param}', ['as'=>'movie.filter', 'uses'=>'MovieController@filter']);
Route::get('movie/{movie}', ['as'=>'movie.description', 'uses'=>'MovieController@description']);
Route::get('movie/{movie}/preview', ['as'=>'movie.preview', 'uses'=>'MovieController@preview']);

// Redirect to this route if detect mobile browser
Route::get('mobile', function() {
	return View::make('mobile');
});
