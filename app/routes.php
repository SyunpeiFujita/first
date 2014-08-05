<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
	{
		return View::make('hello');
	});

Route::when('protect*', 'auth');

Route::get('protect1', array(function()
	{
		return '秘密のページ１';
	}));

Route::get('protect2', array(function()
	{
		return '秘密のページ２';
	}));

Route::get('login', function()
	{
		return View::make('login');
	});

Route::post('login', function()
	{
		// バリデーション省略

		if (Auth::attempt(Input::only('username', 'password')))
		{
			return Redirect::intended('/');
		}
		return Redirect::back()->withInput();
	});

Route::get('logout', function()
	{
		Auth::logout();
		return Redirect::to('/');
	});
