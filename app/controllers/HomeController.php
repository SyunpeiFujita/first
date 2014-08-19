<?php
class HomeController extends BaseController {
	//コンストラクター
	public function __construct()
	{
		Log::info("HomeController::コンストラクタ::start");
		
		
		Log::info("HomeController::コンストラクタ::end");
	}
 	//トップページ
	public function getIndex()
	{
		Log::info("HomeController::getIndex::start");
// 		Log::info($_GET['loginUser']);
// 		$data['loginUser'] = $_GET['loginUser'];
		$data['loginUser'] = Session::get('loginUser');
		Log::info("HomeController::getIndex::end");
		return View::make('home', $data);
	}
 	//メインページ
	public function getMain()
	{
		Log::info("HomeController::getMain::start");
		Log::info("HomeController::getMain::end");
		return View::make('main');
	}
	//症状とセルフケア
	public function getShojo()
	{
		Log::info("HomeController::getShojo::start");
		$data['loginUser'] = Session::get('loginUser');
		Log::info("HomeController::getShojo::end");
		return View::make('shojo', $data);
	}
	//救命処置と応急手当
	public function getKyukyu()
	{
		Log::info("HomeController::getKyukyu::start");
		Log::info("HomeController::getKyukyu::end");
		return View::make('content.kyukyu');
	}
	//健康な生活の為に
	public function getSeikatsu()
	{
		Log::info("HomeController::getSeikatsu::start");
		Log::info("HomeController::getSeikatsu::end");
		return View::make('content.seikatsu');
	}
	//医師の選び方、かかり方
	public function getIshi()
	{
		Log::info("HomeController::getIshi::start");
		Log::info("HomeController::getIshi::end");
		return View::make('content.ishi');
	}
}
