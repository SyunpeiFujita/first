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
		// ByokiMenusから値を取得
		$titleMenus = ByokiMenu::all ();
		
		// displaysから値を取得
		$displays = Display::all ();
		
		// Viewに渡す値を詰め込む
		$data ['loginUser'] = Session::get ( 'loginUser' );
		$data ['titleMenus'] = $titleMenus;
		$data ['displays'] = $displays;
		
		Log::info ( "HomeController::getByoki::end" );
		return View::make ( 'byoki', $data );
	}
	// 症状とセルフケア
	public function getShojo() {
		Log::info ( "HomeController::getShojo::start" );
		$data ['loginUser'] = Session::get ( 'loginUser' );
		
		//サイドバーテーブルから値を取得
		$sidebars = Sidebar::all();
		Log::info("▼▼▼▼▼サイドバーテーブルの値▼▼▼▼▼");
		Log::info($sidebars);
		
		
		Log::info ( "HomeController::getShojo::end" );
		return View::make ( 'shojo', $data );
	}
	
	// 救命処置と応急手当
	public function getKyukyu() {
		Log::info ( "HomeController::getKyukyu::start");
		
		//ファイルパスを指定
		$path = 'json/json.txt';
		//ファイルを読み込み
		$json = file_get_contents(asset($path));
		// ファイルをJSONに変換
		$obj = json_decode($json);
	
		Log::info ( $obj );
		
		//JSONファイルを連想配列に詰め替える
		foreach ($obj as $val)
		{
			$titles[] = (array)$val;
		}
		
		Log::info($titles);
			
		$data ['loginUser'] = Session::get ( 'loginUser' ); //ログインユーザー
		$data['titles'] = $titles; //JSON
		$data['header'] = self::makeHtmlHeader();
		
		$sor = "";
		//サイドバー
		foreach ($titles as $title) {
			if($title['parent'] == "") {
			Log::info ( "サイドバータイトル生成");
			$sor = $sor.self::makeHtmlSidebar($titles, $title);
			}
		}
		
		$data['sidebar'] = $sor;
		
		Log::info ( "HomeController::getKyukyu::end");
		return View::make ('kyukyu',$data);
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
	
	//ヘッダー用HTMLを生成
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
	
	//サイドバー用HTMLを生成
	public function makeHtmlSidebar($titles, $title) {
		Log::info("HomeController::makeHtmlSidebar::start");
		$val = "<li>";
		$valtmp = "";
		foreach ($titles as $titletmp) {
			if ($title['id'] == $titletmp['parent']) {
				$valtmp = $valtmp.self::makeHtmlSidebar($titles, $titletmp);
			}
		}
//		$log->info('$navitmp:'.$navitmp);
		if (strlen($valtmp) > 0) {
			$val = $val."<a title=\"\" href=\"javascript:onclick=Display('".$title['id']."',0)\">";
		}
		$val = $val.$title['text'];
		if (strlen($valtmp) > 0) {
			$val = $val."</a>";
			$val = $val."<ul id=\"".$title['id']."\" style=\"display:none\">";
		}
		$val = $val.$valtmp."</li>";
		if (strlen($valtmp) > 0) {
			$val = $val."</ul>";
		}
		
		Log::info("HomeController::makeHtmlSidebar::End");
		
		
		return $val;
	}
}
