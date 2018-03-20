<?php
	/*Clears saved photos
	  Очищает сохранённые фотографии
	*/
	$token = "ACCESS_TOKEN"; // ACCESS_TOKEN 
	
	$photo = by("photos.get?album_id=saved&count=1000&access_token=".$token);
	for ($i = 0; $i < 1000; $i++) {
		if($photo[$i]["pid"]) {
			by("photos.delete?photo_id=".$photo[$i]["pid"]."&access_token=".$token);
			usleep(77777);
		} else {
			break;
		}
	}

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