<?php
use Symfony\Component\HttpKernel\Tests\controller_func;
/*
 * |-------------------------------------------------------------------------- | Application Routes |-------------------------------------------------------------------------- | | Here is where you can register all of the routes for an application. | It's a breeze. Simply tell Laravel the URIs it should respond to | and give it the Closure to execute when that URI is requested. |
 */

Route::get ( '/', function () {
// 	echo "WANTER<br>";
// 	return "最高かよ";
	// return View::make('hello');
	
	
	$data = User::all();
	return var_dump($data);
} );

// //フィルターを登録する
// Route::filter('filter',function(){
// if ("1" == "1") {
// echo 'フィルターです';
// } else {
// return null;
// }
// });
// //ルートにフィルターを付ける
// Route::get('/',array('after'=>'filter',function(){
// echo 'トップページです';
// }));

Route::when ( 'protect*', 'auth' );

Route::get ( 'protect1', array (
		function () {
			return '秘密のページ１';
		} 
) );

Route::get ( 'protect2', array (
		function () {
			return '秘密のページ２';
		} 
) );

// Route::get('login', function()
// {
// return View::make('login');
// });

// Route::post('login', function()
// {
// var_dump("login");
// // バリデーション省略
// if (Auth::attempt(Input::only('username', 'password')))
// {
// var_dump("中");
// return Redirect::intended('/');
// }
// var_dump("外");
// //return Redirect::back()->withInput();
// });

Route::get ( 'logout', function () {
	Auth::logout ();
	return Redirect::to ( '/' );
} );

Route::get ( 'create/user/tables', function () {
	// userテーブルの存在確認
	if (! Schema::hasTable ( 'users' )) {
		// userテーブルの作成
		Shema::create ( 'users', function ($table) {
			$table->increments ( 'id' );
			$table->string ( 'username', 50 );
			$table->string ( 'email', 100 );
			$table->string ( 'password', 100 );
			$table->tinyinteger ( 'active' )->default ( 0 );
			$table->tinyinteger ( 'suspended' )->default ( 0 );
			$table->tinyinteger ( 'level' )->default ( 1 );
			$table->timestamps ();
		} );
		return 'usersテーブルを作成しました。';
	} else {
		return 'usersテーブルが存在するので、処理を中止します。';
	}
} );

Route::controller ( 'user', 'UserController' );

/**
 * ********************
 * ログインページの表示
 * *********************
 */
Route::get ( 'login', array (
		'as' => 'login',
		function () {
			return View::make ( 'login' );
		} 
) );
/**
 * ********************
 * ログイン処理
 * *********************
 */
Route::post ( 'login', function () {
	
	// 入力データの取得
	$inputs = Input::only ( array (
			'username',
			'password' 
	) );
	// バリデーションルールの作成
	$rules = array (
			'username' => array (
					'required' 
			),
			'password' => array (
					'required' 
			) 
	);
	// バリデーション処理
	$val = Validator::make ( $inputs, $rules );
	// バリデーションNGなら
	if ($val->fails ()) {
		// エラー値と一緒にバック
		return Redirect::back ()->withErrors ( $val )->withInput ();
	}
	// 認証NGなら
	if (! Auth::attempt ( $inputs )) {
		Log::info ( "ログイン失敗" );
		return Redirect::back ()->withErrors ( array (
				'warning' => 'ユーザー名かパスワードが違います。' 
		) )->withInput ();
	}
	// TOPページへ
	Log::info ( "ログイン成功" );
	
	// コントローラーを叩けないため処理をコピペ
	$data ['users'] = User::orderBy ( 'created_at', 'desc' )->get ();
	$view = View::make ( 'user.index', $data );
	Log::info ( "getIndex():end" );
// 	return $view;

	
	
// 	return Redirect::action('HomeController');
	return View::make('user.index');
} );

/**
 * ***********************
 * ログアウト処理
 * ************************
 */
Route::get ( 'logout', function () {
	Log::info("logout::start");
	Auth::logout ();
	Log::info("logout::end");
	return Redirect::back ();
} );
