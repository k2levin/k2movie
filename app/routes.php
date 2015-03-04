<?php

Route::get('mobile', ['as'=>'mobile', 'uses'=>'HomeController@mobile']);
Route::get('sitemap', ['as'=>'sitemap', 'uses'=>'HomeController@sitemap']);

// Movie
Route::get('/', ['as'=>'home', 'uses'=>'MovieController@index']);
Route::post('movie/search', ['as'=>'movie.search', 'before'=>'csrf', 'uses'=>'MovieController@search']);
Route::get('movie/filter/{field}/{param}', ['as'=>'movie.filter', 'uses'=>'MovieController@filter']);
Route::get('movie/{movie}', ['as'=>'movie.description', 'uses'=>'MovieController@description']);
Route::get('movie/{movie}/preview', ['as'=>'movie.preview', 'before'=>'auth', 'uses'=>'MovieController@preview']);

// User
Route::get('user/register', ['as'=>'user.register', 'uses'=>'UserController@register']);
Route::post('user/register', ['as'=>'user.register', 'before'=>'csrf', 'uses'=>'UserController@post_register']);

Route::get('user/activate/{confirmation_code}', ['as'=>'user.activate', 'uses'=>'UserController@activate']);
Route::put('user/activate', ['as'=>'user.activate', 'before'=>'csrf', 'uses'=>'UserController@put_activate']);

Route::get('user/login', ['as'=>'user.login', 'uses'=>'UserController@login']);
Route::put('user/login', ['as'=>'user.login', 'before'=>'csrf', 'uses'=>'UserController@put_login']);

Route::get('user/login2', ['as'=>'user.login2', 'uses'=>'UserController@login2']);
Route::put('user/login2', ['as'=>'user.login2', 'before'=>'csrf', 'uses'=>'UserController@put_login2']);

Route::get('user/profile', ['as'=>'user.profile', 'before'=>'auth', 'uses'=>'UserController@profile']);

Route::get('user/profile/edit', ['as'=>'user.profile.edit', 'before'=>'auth', 'uses'=>'UserController@edit_profile']);
Route::put('user/profile/edit', ['as'=>'user.profile.edit', 'before'=>'csrf', 'uses'=>'UserController@put_profile']);

Route::get('user/logout', ['as'=>'user.logout', 'before'=>'auth', 'uses'=>'UserController@logout']);

// Reminder
Route::get('user/password/remind', ['as'=>'user.password.remind', 'uses'=>'ReminderController@getRemind']);
Route::post('user/password/remind', ['as'=>'user.password.remind', 'before'=>'csrf', 'uses'=>'ReminderController@postRemind']);

Route::get('user/password/reset/{token}', ['as'=>'user.password.reset', 'uses'=>'ReminderController@getReset']);
Route::put('user/password/reset', ['as'=>'user.password.reset', 'before'=>'csrf', 'uses'=>'ReminderController@putReset']);

// Tsa
Route::get('user/tsa/login', ['as'=>'user.tsa.login', 'uses'=>'TsaController@login_tsa']);
Route::put('user/tsa/login', ['as'=>'user.tsa.login', 'before'=>'csrf', 'uses'=>'TsaController@put_login_tsa']);

Route::get('user/tsa/remind', ['as'=>'user.tsa.remind', 'uses'=>'TsaController@remind_tsa']);
Route::put('user/tsa/remind', ['as'=>'user.tsa.remind', 'before'=>'csrf', 'uses'=>'TsaController@put_remind_tsa']);

Route::get('user/tsa/setup', ['as'=>'user.tsa.setup', 'before'=>'auth', 'uses'=>'TsaController@setup_tsa']);
Route::post('user/tsa/setup', ['as'=>'user.tsa.setup', 'before'=>'csrf', 'uses'=>'TsaController@post_setup_tsa']);

Route::get('user/tsa/remove/{token}', ['as'=>'user.tsa.remove', 'uses'=>'TsaController@remove_tsa']);
Route::put('user/tsa/remove', ['as'=>'user.tsa.remove', 'before'=>'csrf', 'uses'=>'TsaController@put_remove_tsa']);
