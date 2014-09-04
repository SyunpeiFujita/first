var idCheck = []; //クリックID格納用配列

/**
 * 画面読み込み時にメインタイトル生成
 */
$(document).ready(function() {
	// メインタイトル取得
	getMainTitle();

});

/**
 * メインタイトルクリック時
 * 
 * @param id
 * @param honmon
 */
function Display(id, honmon) {
	
	if (document.all || document.getElementById) { // IE4,N6以降
		if (id) {
			if (document.all) {
				obj = document.all(id).style;
			} else if (document.getElementById) {
				obj = document.getElementById(id).style;
			}

			// クリック履歴判定
			if(idCheck.indexOf(id) == -1){
				
				// してない場合
				idCheck.push(id); // クリックしたIDを格納
				getSubTitle(obj, id); // 二階層目を生成
			} else {
				
				// した場合はツリー制御のみ
				if(obj.display == "block") {
					obj.display = "none"; // ツリーを閉じる
				} else {
					obj.display = "block"; // ツリーを開く
				}
			}
			return;
		}
	}
}

/**
 * メインタイトル取得メソッド
 */
function getMainTitle() {
	/**
	 * Ajax通信メソッド
	 * 
	 * @param type :
	 *            HTTP通信の種類
	 * @param url :
	 *            リクエスト送信先のURL
	 * @param dataType :
	 *            データの種類
	 */
	$.ajax({
				type : "POST",
				url : "http://localhost/laravel/public/ajax/json.php",
				dataType : "json",
				/**
				 * Ajax通信が成功した場合に呼び出されるメソッド
				 */
				success : function(data, dataType) {
					// 結果が0件の場合
					if (data == null)
						alert('データが0件でした');

					// 返ってきたデータの表示
					var $contents = $('#contents');
					for (var i = 0; i < data.length; i++) {
						$contents.append("<li><a title=\"\" href=\"javascript:onclick=Display(\'"
										+ data[i].display
										+ "\',0)\">"
										+ data[i].menu
										+ "</a>"
										+ "<ul id=\'"
										+ data[i].display
										+ "\'style=\"display: none\">"
										+ "<p id=\"display"
										+ data[i].display
										+ "\"></p>" + "</ul>" + "</li>");
					}

				},
				/**
				 * Ajax通信が失敗場合に呼び出されるメソッド
				 */
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					// エラーメッセージの表示
					alert('Error : ' + errorThrown);
				}
			});
}

/**
 * 二階層目の取得メソッド
 * 
 * @param obj
 * @param id
 */
function getSubTitle(obj, id) {
	// ここにajaxを組み込むと予想
	$.ajax({
		type : "POST",
		url : "http://localhost/laravel/public/ajax/display.php",
		dataType : "json",
		// dataType: "jsonp",
		// jsonp: 'jsoncallback',
		data : {
			id : id // idをphpへ
		}, 
		/**
		 * Ajax通信が成功した場合に呼び出されるメソッド
		 */
		success : function(data)
		// success: function(data, dataType)
		{

			// //結果が0件の場合
			if (data == null)
				alert('データが0件でした');

			// 返ってきたデータの表示
			$('#display').remove(); // ツリーが連続しないようにクリアする(一行ずつずれる)
			var $display = $('#display' + id);

			// alert($display + "だってよ");

			for (var i = 0; i < data.length; i++) {

				$display.append("<li><a title=\"\">" + data[i].submenu + "</a>"
						+ "<ul id=\'" + data + "\'style=\"display: none\">"
						+ "</ul></li>");

			}

		},
		/**
		 * Ajax通信が失敗場合に呼び出されるメソッド
		 */
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			// エラーメッセージの表示
			alert('Error : ' + errorThrown);
		}
	});
	obj.display = "block"; // ツリーを開くにする
}