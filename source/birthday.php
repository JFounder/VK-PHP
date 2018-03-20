<?php
	/*Change the date of birth, every day, birthday
	Изменить дату рождения, каждый день, день рождения
	*/
	
	$token = "access_token"; // user token

	$usersGet = by("users.get?fields=bdate&access_token=".$token);
	$bdate = explode(".", $usersGet[0]["bdate"]);

	by("account.saveProfileInfo?bdate=".date("d.m.").$bdate[2]."&access_token=".$token);

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