<?php
class UserController extends BaseController {
	
	// 登録用変数
	public $email = "";
	public $name = "";
	public $password = "";
	private static $link_pass;
	
	// コンストラクター
	public function __construct() {
		Log::info ( "コンストラクタstart" );
		$this->beforeFilter ( 'auth' );
		$this->beforeFilter ( 'csrf', array (
				'on' => 'post' 
		) );
		Log::info ( "コンストラクタend" );
	}
	// トップページ
	public function getIndex() {
		Log::info ( "getIndex():start" );
		// EloquentORMでデータの取得
		$data ['users'] = User::orderBy ( 'created_at', 'desc' )->get ();
		$view = View::make ( 'user.index', $data );
		Log::info ( "getIndex():end" );
		return $view;
	}
	// createビューファイルの表示
	public function getCreate() {
		return View::make ( 'user.create' );
	}
	public function getKey() {
		Log::info ( "getKey()::start" );
		Log::info ( "パラメーターIDは" . $_GET ['id'] );
		Log::info ( "パラメーターパスは" . $_GET ['link_pass'] );
		
		$pas = new Pas();
		
		$id = $_GET ['id'];

		//IDからPasテーブル取得&変数へ格納
		$val = Pas::find($id);
		$username = $val->username;
		$linkpass = $val->linkpass;
		$password = $val->password;
		$email = $val->email;
		
		
		Log::info ( "↓↓↓↓↓仮登録用DBから取得した値↓↓↓↓↓");
		Log::info ( "登録用IDは".$id);
		Log::info ( "リンクパスは".$linkpass);
		Log::info ( "ユーザーネームは".$username);
		Log::info ( "メールアドレスは".$email);
		
		
		Log::info ( '\"'.$linkpass.'\"'."と".'\"'.$_GET ['link_pass'].'\"'."が一致した場合本登録へ");
		//DB値とパラメータの認証用文字列が一致した場合登録処理へ
		if ($linkpass == $_GET ['link_pass']) {
			Log::info("認証用文字列一致");
			
			// ユーザーの新規作成
			$user = new User ();
			$user->id = $id;
			$user->username = $username;
			$user->email = $email;
			$user->password = $password;
			
			Log::info("ユーザー情報登録開始");
			$user->save ();
			Log::info("ユーザー情報登録完了");
			Log::info ( "getKey()::end" );
			return var_dump ( "登録完了!!!" );
		}
		
		
		// Log::info($results);
		Log::info ( "getKey()::end" );
		return var_dump ( "登録出来てますん" );
	}
	
	// 新規ユーザー作成
	/**
	 * @throws Illuminate\Session\TokenMismatchException
	 * @return Ambigous <\Illuminate\Http\RedirectResponse, \Illuminate\Http\RedirectResponse>
	 */
	public function postCreate() {
		Log::info ( "postCreate():start" );
		// トークンチェック
		if (Session::getToken () != Input::get ( '_token' )) {
			throw new Illuminate\Session\TokenMismatchException ();
		} else {
			$inputs = Input::all ();
			// バリデーションルールの指定
			$rules = array (
					'username' => array (
							'required',
							'min:4',
							'max:50',
							'unique:users' 
					),
					'email' => array (
							'required',
							'email',
							'max:100',
							'unique:users' 
					),
					'password' => array (
							'required',
							'min:4',
							'max:50' 
					) 
			);
			$val = Validator::make ( $inputs, $rules );
			// バリデーションNGなら
			if ($val->fails ()) {
				Log::info ( "postCreate():バリデーションNG" );
				return Redirect::back ()->withErrors ( $val )->withInput ();
			}
			Log::info ( "postCreate():バリデーションOK" );
			
			//グローバル変数宣言
			global $email;
			global $name;
			
			$email = Input::get ( 'email' );
			$name = Input::get ( 'username' );
			$id = Pas::max('id');
			$nextid = $id + 1;
			                                 
			// 登録時(メールで送信するリンクに付加する文字列)に、md5関数、uniqid関数、rand関数を使ってランダムパスワードを自動生成
			$link_pass = md5 ( uniqid ( rand (), 1 ) );
			$data ['link_pass'] = $link_pass;
			
			
			Log::info ( "ランダム文字列は" . $data ['link_pass'] );
			
			//認証用文字列と入力データをDBに格納
			$pas = new Pas ();
			$pas->id = $nextid; //新しいIDを取得
			$pas->linkpass = $link_pass;
			$pas->username = $name;
			$pas->email = $email;
			$pas->password = Input::get ('password');
			Log::info ( "格納準備OK" );
			
			$pas->save();
			Log::info ( "認証用文字列と入力データをDBに格納" );
		
			$adress = 'http://127.0.0.1/laravel/public/user/key?link_pass=' . $link_pass . '&id=' . $nextid;
			$data ['name'] = $name;
			$data ['adress'] = $adress;
			Log::info ( $data );
			Mail::send ( 'emails.test', $data, function ($m) {
				//グローバル変数宣言
				global $email;
				global $name;
				$m->to ( $email, '登録用メール配信' )->subject ( 'ようこそ!' . $name . 'さん' );
			} );
			
			// 
			Log::info ( "postCreate():end" );
			
			return View::make('user.success')->withMail($email);
// 			return View::make('user.success')->withMail($email);
		}
	}
	public function getHello() {
		echo "最高かよ";
	}
	
	// GETで削除
	public function getDelete($id) {
		Log::info ( "getDelete():start" );
		Log::info ( "削除するIDは" . $id );
		$user = User::find ( $id );
		$user->delete ();
		Log::info ( "getDelete():end" );
		// トップページへリダイレクト
		return Redirect::to ( 'user' );
	}
	// POSTで削除
	public function postDelete() {
		Log::info ( "postDelete():start" );
		$user = User::find ( Input::get ( 'id' ) );
		$user = User::find ( Input::get ( 'id' ) );
		$user->delete ();
		Log::info ( "postDelete():end" );
	}
	
}