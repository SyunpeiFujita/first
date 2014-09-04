<?php

// class display extends BaseController{
	
// 	public function displayAjax() {
		
//接続文字列
$dsn = 'mysql:dbname=laravel;host=localhost;charset=utf8';

//ユーザ名
$user = 'navi';

//パスワード
$password = 'navi';

try{
	

	//nullで初期化
	//     $users = null;

	$test = $_POST['id'];

	//DBに接続
	$dbh = new PDO($dsn, $user, $password);

	//'users' テーブルのデータを取得する
	$sql = 'SELECT submenu FROM displays where display =\'' . $test . '\'';
// 	$sql = 'select * from byokimenus';
	$stmts = $dbh->query($sql);

	//取得したデータを配列に格納
	foreach ($stmts as $stmt) {
		$byoki[] =(array) $stmt;
	}
	
// 	$stmt = $stmts[0];
	
} catch (PDOException $e){
	echo '失敗';
}


// {
// 	//例外処理
// 	die('Error:' . $e->getMessage());
// }

// $test = "寒いエス";

// $byoki = json_encode($byoki);
$stmt = json_encode($byoki);
//JSON形式で出力する
//     header('Content-Type: application/jsonp');
    header('Content-Type: application/json');
// header('Content-type: text/javascript; charset=utf-8');
// echo $_GET['jsoncallback']."(".$byoki.")";
// 	echo $byoki[1].submenu;
echo $stmt;
// 	}
// }