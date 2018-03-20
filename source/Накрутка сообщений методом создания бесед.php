<?php
	$token = array(
		"ACCESS_TOKEN",
		"ACCESS_TOKEN",
		"ACCESS_TOKEN",
		"ACCESS_TOKEN"); // токен
	$title = "А - Анонимы"; // Название беседки
	$user_ids = ""; // ID людей кого добавлять, ID через запятую, (1,2,3,4,5,6)
	
	by("messages.createChat?user_ids=".$user_ids."&title=".urlencode($title)."&access_token=".$token);

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