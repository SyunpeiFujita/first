<?php
class HomeController extends BaseController {
	//コンストラクター
	public function __construct()
	{
		Log::info("HomeController::コンストラクタ::start");
		$log = Logger::getLogger("www");
		$log->info('コンストラクター');
		Log::info("HomeController::コンストラクタ::end");
	}
 	//トップページ
	public function getIndex()
	{
		Log::info("HomeController::getIndex::start");
		$log = Logger::getLogger("www");
		$log->info('index');
		Log::info("HomeController::getIndex::end");
		return View::make('home');
	}
 	//メインページ
	public function getMain()
	{
		Log::info("HomeController::getMain::start");
		$log = Logger::getLogger("www");
		$log->info('main');
		Log::info("HomeController::getMain::end");
		return View::make('main');
	}
}
