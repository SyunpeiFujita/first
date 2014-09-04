<?php

//Ajax通信ではなく、直接URLを叩かれた場合はエラーメッセージを表示
if (
    !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
    && (!empty($_SERVER['SCRIPT_FILENAME']) && 'json.php' === basename($_SERVER['SCRIPT_FILENAME']))
    ) 
{
    die ('このページは直接ロードしないでください。');
}

	
	
//接続文字列 
$dsn = 'mysql:dbname=laravel;host=localhost;charset=utf8';

//ユーザ名
$user = 'navi';

//パスワード
$password = 'navi';

try
{
    //nullで初期化
//     $users = null;
    
    //DBに接続
    $dbh = new PDO($dsn, $user, $password);
    
    //'users' テーブルのデータを取得する
    $sql = 'select * from byokimenus';
    $stmts = $dbh->query($sql);
    
    //取得したデータを配列に格納
    foreach ($stmts as $stmt) {
    	$byoki[] =(array) $stmt; 
    }
    
    //JSON形式で出力する
    header('Content-Type: application/json');
    echo json_encode( $byoki );
    exit;
}
catch (PDOException $e)
{
    //例外処理
    Log::info("まさかここ？");
    die('Error:' . $e->getMessage());
}