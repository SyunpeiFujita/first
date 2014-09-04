<?php
class HomeController extends BaseController {
	
	// コンストラクター
	public function __construct() {
		Log::info ( "HomeController::コンストラクタ::start" );
		Log::info ( "HomeController::コンストラクタ::end" );
	}
	// トップページ
	public function getIndex() {
		Log::info ( "HomeController::getIndex::start" );
		// Log::info($_GET['loginUser']);
		// $data['loginUser'] = $_GET['loginUser'];
		$data ['loginUser'] = Session::get ( 'loginUser' );
		Log::info ( "HomeController::getIndex::end" );
		return View::make ( 'home', $data );
	}
	// メインページ
	public function getMain() {
		Log::info ( "HomeController::getMain::start" );
		Log::info ( "HomeController::getMain::end" );
		return View::make ( 'main' );
	}
	// 病気の知識
	public function getByoki() {
		Log::info ( "HomeController::getByoki::start" );
		
		/*
		 * jsonのパスを指定
		 */
		$path = 'json/byokimenus.json'; // ByokiMenusパス
		$pathDisp = 'json/displays.json'; // displaysのパス
		
		/*
		 * パスから値を取得
		 */
		$json = file_get_contents ( asset ( $path ) );
		$jsonDisp = file_get_contents ( asset ( $pathDisp ) );
		
		/*
		 * 値をjsonに変換
		 */
		$obj = json_decode ( $json );
		$objDisp = json_decode ( $jsonDisp );
		
		/*
		 * jsonから連想配列へ
		 */
		foreach ( $obj as $objval ) {
			$titles [] = ( array ) $objval;
		}
		
		foreach ( $objDisp as $objDispVal ) {
			$titlesDisp [] = ( array ) $objDispVal;
		}
		
		$val = "";
		
		// メインタイトル生成
		foreach ( $titles as $title ) {
			
			$val = $val . self::mainMenu ( $titles, $title, $titlesDisp );
			
			$val = $val . '</ul>';
			$val = $val . '</li>';
		}
		
		// Viewに渡す値を詰め込む
		$data ['loginUser'] = Session::get ( 'loginUser' );
		$data ['titleMenus'] = $titles;
		
		$data ['val'] = $val; // ここで値を一気に渡す
		Log::info($val);
		                      
		// $data ['titleMenus'] = $titleMenus;
		                      // $data ['displays'] = $displays;
		$data ['displays'] = $titlesDisp;
		
		Log::info ( "HomeController::getByoki::end" );
		return View::make ( 'byoki', $data );
	}
	
	// 症状とセルフケア
	public function getShojo() {
		Log::info ( "HomeController::getShojo::start" );
		$data ['loginUser'] = Session::get ( 'loginUser' );
		
		// サイドバーテーブルから値を取得
// 		$sidebars = Sidebar::all ();
		Log::info ( "▼▼▼▼▼サイドバーテーブルの値▼▼▼▼▼" );
// 		Log::info ( $sidebars );
		
		Log::info ( "HomeController::getShojo::end" );
		return View::make ( 'shojo', $data );
	}
	
	// 救命処置と応急手当
	public function getKyukyu() {
		Log::info ( "HomeController::getKyukyu::start" );
		
		// ファイルパスを指定
		$path = 'json/json.txt';
		// ファイルを読み込み
		$json = file_get_contents ( asset ( $path ) );
		// ファイルをJSONに変換
		$obj = json_decode ( $json );
		
		Log::info ( $obj );
		
		// JSONファイルを連想配列に詰め替える
		foreach ( $obj as $val ) {
			$titles [] = ( array ) $val;
		}
		
		Log::info ( $titles );
		
		$data ['loginUser'] = Session::get ( 'loginUser' ); // ログインユーザー
		$data ['titles'] = $titles; // JSON
		$data ['header'] = self::makeHtmlHeader ();
		
		$sor = "";
		// サイドバー
		foreach ( $titles as $title ) {
			if ($title ['parent'] == "") {
				Log::info ( "サイドバータイトル生成" );
				$sor = $sor . self::makeHtmlSidebar ( $titles, $title );
			}
		}
		
		$data ['sidebar'] = $sor;
		
		Log::info ( "HomeController::getKyukyu::end" );
		return View::make ( 'kyukyu', $data );
	}
	// 健康な生活の為に
	public function getSeikatsu() {
		Log::info ( "HomeController::getSeikatsu::start" );
		Log::info ( "HomeController::getSeikatsu::end" );
		return View::make ( 'content.seikatsu' );
	}
	// 医師の選び方、かかり方
	public function getIshi() {
		Log::info ( "HomeController::getIshi::start" );
		Log::info ( "HomeController::getIshi::end" );
		return View::make ( 'content.ishi' );
	}
	
	// ヘッダー用HTMLを生成
	private function makeHtmlHeader() {
		Log::info ( "HomeController::makeHtml::start" );
		$makeHtml = <<<EOS
		 <body id=\"kyukyu\">
			<div id=\"header\">
				<!--▼ヘッダーボタン-->
					<script type="text/JavaScript">
					<!--
					document.write(header);
					//-->
					</script>
				<!--▲ヘッダーボタン-->
				<ol id=\"bread-crumb\">
					<li><a title=\"\" href=\"http://www.egao-library.net:80/akahon/login.php?f=index.html">ホーム</a></li>
					<li><a class=\"active\" title=\"\" href="http://www.egao-library.net:80/akahon/login.php?f=bu2/01_byoki.html">救命処置と応急手当</a></li>
				</ol>
			</div>
EOS;
		
		Log::info ( "HomeController::makeHtml::end" );
		return $makeHtml;
	}
	
	// サイドバー用HTMLを生成
	public function makeHtmlSidebar($titles, $title) {
		Log::info ( "HomeController::makeHtmlSidebar::start" );
		$val = "<li>";
		$valtmp = "";
		
		// 動作追尾用フラグ
		$flg = 0;
		
		if ($title ['parent'] == "") {
		}
		
		foreach ( $titles as $titletmp ) {
			
			if ($title ['id'] == $titletmp ['parent']) {
				
				$valtmp = $valtmp . self::makeHtmlSidebar ( $titles, $titletmp );
			}
		}
		// $log->info('$navitmp:'.$navitmp);
		if (strlen ( $valtmp ) > 0) {
			$val = $val . "<a title=\"\" href=\"javascript:onclick=Display('" . $title ['id'] . "',0)\">";
		}
		$val = $val . $title ['text'];
		if (strlen ( $valtmp ) > 0) {
			$val = $val . "</a>";
			$val = $val . "<ul id=\"" . $title ['id'] . "\" style=\"display:none\">";
		}
		$val = $val . $valtmp . "</li>";
		if (strlen ( $valtmp ) > 0) {
			$val = $val . "</ul>";
		}
		
		Log::info ( "HomeController::makeHtmlSidebar::End" );
		
		return $val;
	}
	
	/**
	 * 画面のサブメニュー生成用
	 */
	public function subMenu($displays, $title, $flg) {
		Log::info ( "HomeController::subMenu::start" );
		$val = "";
		$valtmp = "";
		$count = 0;
		
		if ($flg == 0) {
			
			foreach ( $displays as $display ) {
				if ($title ['display'] == $display ['display']) {
					if (0 == $display ['column_t']) {
						$val = $val . '<li class="column_t">';
					} else {
						$val = $val . '<li>';
					}
					
					$val = $val . '<a title=\"\" href="javascript:onclick=Display(\'' . $display ['display'] . '\',0)">';
					$val = $val . $display ['submenu'];
					$val = $val . '</a>';
					
					// $val = $val . '</li>';
				}
				$val = $val . self::subMenu ( $displays, $display, 1 );
			}
		} else {
			foreach ( $displays as $display ) {
				if ($title ['display'] == $display ['subdisplay']) {
					$val = $val . '<li>';
					$val = $val . '<a title=\"\" href="javascript:onclick=Display(\'' . $display ['display'] . '\',0)">';
					$val = $val . $title ['submenu'];
					$val = $val . '</a>';
					
					$val = $val . '</li>';
					
					$val = $val . self::subMenu ( $displays, $display, 1 );
					// Log::info ( $val );
				}
				
				// $val = $val.self::subMenu($displays, $title, 1);
			}
		}
		
		$val = $val . '</li>';
		
		Log::info ( "HomeController::subMenu::End" );
		return $val;
	}
	public function mainMenu($titles, $title, $displays) {
		Log::info ( "HomeController::mainMenu::start" );
		$val = "";
		
		// メニューを作る
		$val = '<li><a title="" href="javascript:onclick=Display(\'' . $title ['display'] . '\',0)">' . $title ['menu'] . '</a><ul id="' . $title ['display'] . '" style="display:none">';
		
// 		$val = $val . self::subMenu ( $displays, $title, 0 );
		Log::info ( "HomeController::mainMenu::End" );
		
		return $val;
	}
}
