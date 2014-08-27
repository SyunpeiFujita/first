<?php 
Log::info("ajax北");
 // 出力／内部文字コードをUTF-8に設定
mb_http_output('UTF-8');
mb_internal_encoding('UTF-8');
 /* 入力されたISBNコードをキーに対応する書名（$result）を取得。
    通常のアプリケーションでは、ここでデータベースへの検索処理などを行う */
switch($_GET['isbn']){
  case '4-7981-1070-1' :
    $result='XMLデータベース入門 NeoCore/XprioriでXMLDBを極める！';
    break;
  case '4-88337-491-2' :
    $result='書き込み式 SQLのドリル?ドンドン身に付く、スラスラ書ける';
    break;
  case '4-7980-1270-X' :
    $result='Pocket詳解PHP辞典';
    break;
  default :
    $result='不明';
}
sleep(3);  // 3秒休止（待ち時間を体感するためのダミー）
print($result);  // 取得した結果を出力
?>
