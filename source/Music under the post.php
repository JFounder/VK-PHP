<?php
	$token = "ТОКЕН"; //токен
	
	$post = explode("_", "ID записи"); // ID записи заменить на свою запись (3234_135)
	
	$usersGet = by("users.get?access_token=".$token);
	$users_id = $usersGet[0]["uid"];
	$name = $usersGet[0]["first_name"]." ".$usersGet[0]["last_name"];
	
	$text = random(array("Котэ предлагает послушать этот трэк 😼\n\nТреки от пользователя: «".$name."»", "Музыка от души 😉\n\nТреки от пользователя: «".$name."»", "Хиты 2016 года 👍\n\nТреки от пользователя: «".$name."»", "Самые топовые музыки 👊\n\nТреки от пользователя: «".$name."»", "Только популярный музыки 😈\n\nТреки от пользователя: «".$name."»")); 
	
	$getPopular = by("audio.getPopular?genre_id=".rand(1, 18)."&offset=".rand(1, 200)."&access_token=".$token);
	$attachments = "audio".$getPopular[0]["owner_id"]."_".$getPopular[0]["aid"].",audio".$getPopular[1]["owner_id"]."_".$getPopular[1]["aid"];
	by("wall.addComment?owner_id=".$post[0]."&post_id=".$post[1]."&text=".urlencode($text)."&attachments=".$attachments."&access_token=".$token);
	
	function random($text){
		$random = mt_rand(0,count($text)-1); 
		return $text[$random]; 
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