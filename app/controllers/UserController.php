<?php
class UserController extends BaseController {
	
	//登録用変数
	public $email = "";
	public $name = "";
	public $password = "";
	
	
	
	// コンストラクター
	public function __construct() {
		Log::info("コンストラクタstart");
		$this->beforeFilter ( 'auth' );
		$this->beforeFilter ( 'csrf', array (
				'on' => 'post' 
		) );
		Log::info("コンストラクタend");
	}
	// トップページ
	public function getIndex() {
		Log::info("getIndex():start");
		// EloquentORMでデータの取得
		$data ['users'] = User::orderBy ( 'created_at', 'desc' )->get ();
		$view = View::make ( 'user.index', $data );
		Log::info("getIndex():end");
		return $view;
	}
	// createビューファイルの表示
	public function getCreate() {
		return View::make ( 'user.create' );
	}
	
	public function getKey() {
		Log::info("getKey()::start");
		Log::info("パラメーターは".$_GET['link_pass']);
// 		Log::info("ローカル変数は".$this->link_pass);
		
		global $link_pass;
		Log::info("グローバル変数は".$link_pass);
		
// 		$link_pass = $_GET['link_pass'];
// 		if ($link_pass == $this->link_pass) {
// 			Log::info("完全に一致");
// 		}
		
		
// 		Log::info($results);
		Log::info("getKey()::end");
		return var_dump("キター―ーーーーー");
	}
	
	// 新規ユーザー作成
	public function postCreate() {
		Log::info("postCreate():start");
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
				Log::info("postCreate():バリデーションNG");
				return Redirect::back ()->withErrors ( $val )->withInput ();
			}
			Log::info("postCreate():バリデーションOK");

			//値を変数へ格納
			$this->name = Input::get ( 'username' );
			$this->password = Input::get ( 'password' );
			$this->email = Input::get ( 'email' );
			
			
			// ユーザーの新規作成
			$user = new User ();
			$user->username = Input::get ( 'username' );
			$user->email = Input::get ( 'email' );
// 			$user->password = Hash::make ( Input::get ( 'password' ) );
			$user->password = Input::get ( 'password' );
			
			//変数のグローバル可
			global $email;
			global $name;
			global $link_pass;
			
			$email = Input::get ('email'); // 暫定的に
			$name = Input::get ('username'); // 暫定的に
			
			//登録時(メールで送信するリンクに付加する文字列)に、md5関数、uniqid関数、rand関数を使ってランダムパスワードを自動生成
			$link_pass = md5(uniqid(rand(),1));
			$data['link_pass'] = $link_pass;
			$this->link_pass = $link_pass;
			Log::info("ランダム文字列は".$data['link_pass']);
			
 			
//  			Log::info("送信するメールアドレスは:".$email);
			$adress = 'http://127.0.0.1/laravel/public/user/key?link_pass='.$link_pass; // 暫定的に
			$username = Input::get ( 'username' ); // 暫定的に
			$data ['name'] = $username;
			$data ['adress'] = $adress;
			Log::info($data);
			Mail::send ( 'emails.test', $data, function ($m) { // ここでエラー起きてる
				global $email;
				global $name;
				$m->to ( $email, '登録用メール配信' )->subject ( 'ようこそ!'.$name.'さん');

			} );
			
			
			
			
// 			$user->save ();
			Log::info("postCreate():end");
			// トップページへリダイレクト
			
// 			return Redirect::to ( 'user' );
		}
	}
	public function getHello() {
		echo "最高かよ";
	}
	
	//GETで削除
	public function getDelete($id){
		Log::info("getDelete():start");
		Log::info("削除するIDは".$id);
		$user=User::find($id);
		$user->delete();
		Log::info("getDelete():end");
		// トップページへリダイレクト
		return Redirect::to ( 'user' );
		
	}
	//POSTで削除
	public function postDelete(){
		Log::info("postDelete():start");
		$user=User::find(Input::get('id'));
		$user=User::find(Input::get('id'));
		$user->delete();
		Log::info("postDelete():end");
	}
}