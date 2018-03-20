<?php
	/*
	Отписываемся от всех
	Unsubscribe from all
	*/
	$token = "Access_token"; // user token

	$getRequests = by('friends.getRequests?out=1&count=1&access_token='.$token);

	by("friends.delete?user_id=".$getRequests[0]."&access_token=".$token);

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