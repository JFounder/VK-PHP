<?php
	$token = "Access_token"; // Токен
	$chat_id = "0123456789"; // ID чата. Пример: vk.com/im?sel=c2434 - вводим 2434
	
	date_default_timezone_set ("Europe/Kiev"); // Часовой пояс Europe/Kiev - это Украина . Europe/Moscow - это Россия.

	$getHistory = by("messages.getHistory?chat_id=".$chat_id."&access_token=".$token);
	$countM = $getHistory[0];

	$text = "Время: ".date("H:i")." . В данной беседки: ".$countM." сообщений.";

	by("messages.editChat?chat_id=".$chat_id."&title=".urlencode($text)."&access_token=".$token);

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