<?php

// Movie
Route::get('/', ['as'=>'home', 'uses'=>'MovieController@index']);
Route::post('movie/search', ['as'=>'movie.search', 'before'=>'csrf', 'uses'=>'MovieController@search']);
Route::get('movie/filter/{field}/{param}', ['as'=>'movie.filter', 'uses'=>'MovieController@filter']);
Route::get('movie/{movie}', ['as'=>'movie.description', 'uses'=>'MovieController@description']);
Route::get('movie/{movie}/preview', ['as'=>'movie.preview', 'before'=>'auth', 'uses'=>'MovieController@preview']);

// Redirect to this route if detect mobile browser
Route::get('mobile', function() {
	return View::make('mobile');
});

// User
Route::get('user/register', ['as'=>'user.register', 'uses'=>'UserController@register']);
Route::post('user/register', ['as'=>'user.register', 'before'=>'csrf', 'uses'=>'UserController@post_register']);

Route::get('user/activate/{confirmation_code}', ['as'=>'user.activate', 'uses'=>'UserController@activate']);

Route::get('user/login', ['as'=>'user.login', 'uses'=>'UserController@login']);
Route::post('user/login', ['as'=>'user.login', 'before'=>'csrf', 'uses'=>'UserController@post_login']);

Route::get('user/profile', ['as'=>'user.profile', 'before'=>'auth', 'uses'=>'UserController@profile']);

Route::get('user/logout', ['as'=>'user.logout', 'before'=>'auth', 'uses'=>'UserController@logout']);

Route::get('user/password/remind', ['as'=>'user.password.remind', 'uses'=>'ReminderController@getRemind']);
Route::post('user/password/remind', ['as'=>'user.password.remind', 'before'=>'csrf', 'uses'=>'ReminderController@postRemind']);

Route::get('user/password/reset/{token}', ['as'=>'user.password.reset', 'uses'=>'ReminderController@getReset']);
Route::post('user/password/reset', ['as'=>'user.password.reset', 'before'=>'csrf', 'uses'=>'ReminderController@postReset']);




