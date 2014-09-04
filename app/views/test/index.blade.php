<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />

<title>家庭の医学</title>

<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script>
/** ツリー制御 */
function Display(id, honmon){
alert(id);
	if(document.all || document.getElementById){	//IE4,N6以降
		
		if (id) {
			if(document.all){
				obj = document.all(id).style;
			}else if(document.getElementById){
				obj = document.getElementById(id).style;
				
			}
			
			//alert(obj.display);
			
// 			if(obj.display == "block"){
// 				obj.display = "none";		//ツリーを閉じる
// 			}else{
// 				if (honmon) {
					obj.display == "block";// ツリー平井徳
	
					alert("ajax開始");
					// ここにajaxを組み込むと予想
					$.ajax({
		            type: "POST",
// 		            url: "http://localhost/laravel/app/views/test/display.php",
            		url: "http://localhost/laravel/public/ajax/display.php",
		            dataType: "jsonp",
		            jsonp: 'jsoncallback',
		            data: { test: "てすとでーた"}, //idをphpへ
		            /**
		             * Ajax通信が成功した場合に呼び出されるメソッド
		             */
		            success: function(data) 
// 		            success: function(data, dataType) 
		            {
			            alert('成功' + data);
// 		                //結果が0件の場合
		                if(data == null) alert('データが0件でした');
		                
		                //返ってきたデータの表示
		                var $display = $('#display');

		                for (var i =0; i<data.length; i++) 
		                {
		                    $display.append("<li><a title=\"\" href=\"javascript:onclick=Display(\'" + data + "\',0)\">" + data + "</a></li>"
							 + "<ul id=\'" + data + "\'style=\"display: none\">");
// 		                    $content.append("<li><a title=\"\" href=\"javascript:onclick=Display(\'" + data[i].display + "\',0)\">" + data[i].submenu + "</a></li>"
// 							 + "<ul id=\'" + data[i].display + "\'style=\"display: none\">");
			
		                }
		            },
		            /**
		             * Ajax通信が失敗場合に呼び出されるメソッド
		             */
		            error: function(XMLHttpRequest, textStatus, errorThrown) 
		            {
		                //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
		
		                //this;
		                //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。
		
		                //エラーメッセージの表示
		                alert('Error : ' + errorThrown);
		            }
		        });


					obj.display = "block";		//ツリーを開くにする
					return;
// 				} else {
// 					obj.display = "block";		//ツリーを開くにする
// 				}
// 			}
		}
	}
}

function test() {
	alert('test');
}


    $(document).ready(function() 
    {
        /**
         * Ajax通信メソッド
         * @param type      : HTTP通信の種類
         * @param url       : リクエスト送信先のURL
         * @param dataType  : データの種類
         */
        $.ajax({
            type: "POST",
            url: "http://localhost/laravel/public/ajax/json.php",
            dataType: "json",
            /**
             * Ajax通信が成功した場合に呼び出されるメソッド
             */
            success: function(data, dataType) 
            {
                //結果が0件の場合
                if(data == null) alert('データが0件でした');
                
                //返ってきたデータの表示
                var $content = $('#content');
                for (var i =0; i<data.length; i++) 
                {
                    $content.append("<li><a title=\"\" href=\"javascript:onclick=Display(\'" + data[i].display + "\',0)\">" + data[i].menu + "</a></li>"
					 + "<ul id=\'" + data[i].display + "\'style=\"display: none\">");
	
                }
            },
            /**
             * Ajax通信が失敗場合に呼び出されるメソッド
             */
            error: function(XMLHttpRequest, textStatus, errorThrown) 
            {
                //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
                //this;
                //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。

                //エラーメッセージの表示
                alert('Error : ' + errorThrown);
            }
        });
    });
    </script>
</head>
<body>
	<h1>家庭の医学DBバージョン</h1>
	<ul id="content">
	<li id="display"></li>
	</ul>
	
</body>
</html>