<?php
	class Info {
		
		private $link_pass;
		
		//$linkPassのセッター
		public function setLinkPass($link_pass) {
			Log::info("setLinkPass()::start");
			Log::info("保持する値は".$link_pass);
			//値を詰め替え
			$this->link_pass = $link_pass;
			
	
			Log::info("setLinkPass()::end");
		}
		
		//$linkPassのゲッター
		public function getLinkPass() {
			Log::info("getLinkPass()::start");
			Log::info("返す値は".$this->link_pass);
			Log::info("getLinkPass()::end");
			return $this->link_pass;
		}
		
	}