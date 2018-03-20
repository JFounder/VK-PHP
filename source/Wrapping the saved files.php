<?php
	$token = "ACCESS_TOKEN"; // Access_token от приложения iPhone
	$photo = "ID_PHOTO"; // ID фотографии, пример: photo220353117_392254216, ввобить без photo, то есть: 220353117_392254216
	
	$explode = explode("_", $photo);
	for ($i = 0; $i < 15; $i++) {
		$photos = by("photos.copy?owner_id=".$explode[0]."&photo_id=".$explode[1]."&access_token=".$token);
		if(!$photos) {
			break;
		}
	}
	
	function by($method) {
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