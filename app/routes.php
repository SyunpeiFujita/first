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
		echo "WANTER<br>";
		return "最高かよ";
		//return View::make('hello');
	});

// //フィルターを登録する
// Route::filter('filter',function(){
// 	if ("1" == "1") {
// 	echo 'フィルターです';
// 	} else {
// 		return null;
// 	}
// });
// //ルートにフィルターを付ける
// Route::get('/',array('after'=>'filter',function(){
// 	echo 'トップページです';
// }));

Route::controller('hello','HelloController');

Route::filter('pattern: hello/*',array('name'=>'filter',function(){
 echo 'Hello World!<br>';
 }));



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
		var_dump("login");
		// バリデーション省略
		if (Auth::attempt(Input::only('username', 'password')))
		{
			var_dump("中");
			return Redirect::intended('/');
		}
		var_dump("外");
		return Redirect::back()->withInput();
	});

Route::get('logout', function()
	{
		Auth::logout();
		return Redirect::to('/');
	});

Route::get('create/user/tables',function()
{
	//userテーブルの存在確認
	if(!Schema::hasTable('users'))
	{
		//userテーブルの作成
		Shema::create('users',function($table)
		{
			$table->increments('id');
			$table->string('username',50);
			$table->string('email',100);
			$table->string('password',100);
			$table->tinyinteger('active')->default(0);
			$table->tinyinteger('suspended')->default(0);
			$table->tinyinteger('level')->default(1);
			$table->timestamps();
		});
		return 'usersテーブルを作成しました。';
	} else {
		return 'usersテーブルが存在するので、処理を中止します。';
	}
});



Route::get('create/users/table',function()
{
	//usersテーブルの存在確認
	if(!Schema::hasTable('users'))
	{
		// usersテーブルの作成
		Schema::create('users',function($table)
		{
			$table->increments('id');
			$table->string('username',50);
			$table->string('email',100);
			$table->string('password',100);
			$table->tinyinteger('active')->default(0);
			$table->tinyinteger('suspended')->default(0);
			$table->integer('level')->default(1);
			$table->timestamps();
		});
		return 'usersテーブルを作成しました。';
	}else{
		return 'usersテーブルが存在しますので、処理を中止します。';
	}
});

