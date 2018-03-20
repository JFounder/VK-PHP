<?php
	// Сохраняет все вложенные картинки в сообщениях
	$token = "Access_token"; // token
	$offset = 100;
	while(true) {
		$get = curl( "https://api.vk.com/method/messages.get?count=100&offset=".$offset."&access_token=".$token);
		$decode = json_decode( $get, true );
		for($i = 1; $i < count ($decode); $i++) {
			if(isset ($decode[$i]["attachments"]) ) {
				for($x = 0; $x < count ($decode[$i]["attachments"]); $x++) {
					if($decode[$i]["attachments"][$x]["type"] == "photo") {
						echo date("d.m.Y H:i:s")." photo saved".PHP_EOL;
						file_put_contents( substr( md5( date( "d.m.Y H:i:s" ) ), 0, 5 ) .".png", file_get_contents($decode[$i]["attachments"][$x]["photo"]["src_big"]));
					}
				}
			}
		}
		if (count ($decode) == 1) {
			break;
		}
		$offset += 100;
	}
	Echo date( "d.m.Y H:i:s" )." COMPLETE";

	function by($method){
		$ch = curl_init("https://api.vk.com/method/".$method);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		$response = curl_exec($ch);
		curl_close($ch);
		$json = json_decode($response, true);
		return $json["response"];
	}
?>