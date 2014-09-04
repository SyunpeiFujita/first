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
			
 			if(obj.display == "block"){
 				obj.display = "none";		//ツリーを閉じる
 			}
//			else{
// 				if (honmon) {
					obj.display == "block";// ツリー平井徳
	
					// ここにajaxを組み込むと予想
					$.ajax({
		            type: "POST",
            		url: "http://localhost/laravel/public/ajax/display.php",
		            dataType: "json",
//		            dataType: "jsonp",
//		            jsonp: 'jsoncallback',
		            data: { id: id}, //idをphpへ
		            /**
		             * Ajax通信が成功した場合に呼び出されるメソッド
		             */
		            success: function(data) 
// 		            success: function(data, dataType) 
		            {
		            	alert('成功' + data);
		            	alert('成功' + id);
//		            	var len = data.length;
//		                for(var i=0; i < len; i++){
//		                  $displaydb.append(data[i].display + ' ' + data[i].subdisplay + ' ' + data[i].submenu + '<br>');
//		                }
		            	
		            	
		            	
		            	
		            	
		            	
			            
// 		                //結果が0件の場合
		                if(data == null) alert('データが0件でした');
		                
		                //返ってきたデータの表示
		                $('#display').remove(); // ツリーが連続しないようにクリアする(一行ずつずれる)
		                var $display = $('#display' + id);
		                
//		                alert($display + "だってよ");
		                
		                console.log("取得データは" + data.length);
		                for (var i =0; i<data.length; i++) 
		                {
		                	
		                	console.log(data[i].submenu);
		                    $display.append("<li><a title=\"\">" + data[i].submenu + "</a>" + "<ul id=\'" + data + "\'style=\"display: none\">" + "</ul></li>");
			
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
                var $contents = $('#contents');
                for (var i =0; i<data.length; i++) 
                {
                	console.log("現在" + i + "番目");
                    $contents.append("<li><a title=\"\" href=\"javascript:onclick=Display(\'" + data[i].display + "\',0)\">" + data[i].menu + "</a>"
                    		+ "<ul id=\'" + data[i].display + "\'style=\"display: none\">" + "<p id=\"display" + data[i].display + "\"></p>" + "</ul>" + "</li>");
                }
                
                console.log("メニューは" + $contents[0].innerHTML);
            },
            /**
             * Ajax通信が失敗場合に呼び出されるメソッド
             */
            error: function(XMLHttpRequest, textStatus, errorThrown) 
            {
                //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。c1c
                //this;
                //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。

                //エラーメッセージの表示
                alert('Error : ' + errorThrown);
            }
        });
    });