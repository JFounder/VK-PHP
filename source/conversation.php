<?php
	//Автоматом добавляет в беседу, если в лс написали#addchatuser Automatically adds to the conversation, if the HP wrote #addchatuser
	$token = "ACCESS_TOKEN"; // ACCESS_TOKEN
	$chat_id = chatid; // ID conversation
	$uid = id_user; // ID создателя беседки (ID user ACCESS_TOKEN)
	$chat_title_update = "Название беседки"; // Название беседки, в случаии если кто-то изменит
	
	$getDialogs = by("messages.getDialogs?v=5.14&count=100&access_token=".$token);
	for ($i = 0; $i < 50; $i++) {
		if($getDialogs["items"][$i]["message"]["read_state"] == 0) {
			$message = mb_convert_case($getDialogs["items"][$i]["message"]["body"], MB_CASE_LOWER, "UTF-8");
			if(preg_match("/#addchatuser/", $message)) {
				$addChatUser = by("messages.addChatUser?chat_id=".$chat_id."&user_id=".$getDialogs["items"][$i]["message"]["user_id"]."&access_token=".$token);
				if($addChatUser == 1) {
					$user = by("users.get?lang=ru&fields=photo_50&https=1&uid=".$getDialogs["items"][$i]["message"]["user_id"]);
					$first_name = $user[0]["first_name"];
					$last_name = $user[0]["last_name"];
					by("messages.markAsRead?message_ids=".$getDialogs["items"][$i]["message"]["id"]."&access_token=".$token);
					by("messages.send?chat_id=".$chat_id."&message=".urlencode("Новый пользователь, ".$first_name." ".$last_name."!\nУспешно добавлен в беседку.\n\nЗапрещено изменять название беседки!!!")."&access_token=".$token);
				} elseif($addChatUser["error_code"] == 103) {
					by("messages.send?user_id=".$getDialogs["items"][$i]["message"]["user_id"]."&message=".urlencode("К сожалению, в беседе могут участвовать не более 50 человек.\nПопробуйте через 5 минут написать ещё раз, за это время Мы исключим пару людей с беседки.")."&access_token=".$token);
				} elseif($addChatUser["error_code"] == 15) {
					by("messages.send?user_id=".$getDialogs["items"][$i]["message"]["user_id"]."&message=".urlencode("Вы уже присутствуете в беседки.")."&access_token=".$token);
				}
			} elseif($getDialogs["items"][$i]["message"]["action"] == "chat_title_update") {
				if($getDialogs["items"][$i]["message"]["user_id"] != $uid) {
					if($getDialogs["items"][$i]["message"]["action_text"] != $chat_title_update) {
						by("messages.editChat?chat_id=".$chat_id."&title=".urlencode($chat_title_update)."&access_token=".$token);
						by("messages.send?chat_id=".$chat_id."&message=".urlencode("Запрещено изменять название беседки!!!")."&access_token=".$token);
						by("messages.removeChatUser?chat_id=".$chat_id."&user_id=".$getDialogs["items"][$i]["message"]["user_id"]."&access_token=".$token);
					}
				}
			}
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