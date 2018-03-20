<?php
	//Выберает того, кто лайкает записи в группе
	$token = "Access_token"; // Token
	$owner_id = "0123456789"; // ID group, водим без минуса
	$offset = 0; // Если в группе закреплена запись ставим 1, если нет, то 0
	$count = "50"; // Сколько людей вывести. Больше 100 не ставить

	$walGet = by("wall.get?owner_id=-".$owner_id."&offset=".$offset."&filter=owner&access_token=".$token);
	$item_id = $walGet[2]["id"];

	for ($i = 0; $i < $count; $i++) {
		sleep(1);

		$getLikes = by("likes.getList?type=post&owner_id=-".$owner_id."&item_id=".$item_id."&filter=likes&count=100&access_token=".$token);

		$userGet = by("users.get?user_ids=".$getLikes["users"][$i]);
		$uid = $userGet[0]["uid"];
		$names = $userGet[0]["first_name"]." ".$json_user[0]["last_name"];

		$message = "Привет [id".$uid."|".$names."], спасибо за то что лайкаешь посты в группе :-D";

		if($uid){
			by("wall.post?message=".urlencode($message)."&access_token=".$token);
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