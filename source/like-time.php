<?php
	//лайктайм like-time group
	$token = "Access_token"; // токен
	
	$owner_id = "group_id"; // ID группы. ID без минуса

	$offset = "0"; // 0 не закреплена, 1 закреплена - pinner:1 no pinner:0

	$countL = "15"; // Сколько должно быть лайков под записью? - How many hounds should be under the record?

	date_default_timezone_set ("Europe/Moscow"); # <- Регион времени, time region

	$a2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
	$a3 = array("1⃣", "2⃣", "3⃣", "4⃣", "5⃣", "6⃣", "7⃣", "8⃣", "9⃣", "0⃣"); 

	$random = rand(0, 15);
	
	$code = '
		var wall = API.wall.get({"owner_id": -'.$owner_id.', "offset": '.$offset.'});
		var item_id = wall.items[0].id;

		var like = API.likes.getList({"type": "post", "owner_id": -'.$owner_id.', "item_id": "" + item_id + "", "filter": "likes"});
		var like_id = like.items['.$random.'];
		var count = like.count + 0;

		var user = API.users.get({"user_ids": "" + like_id +  ""});
		var uid = user[0].id;
		var first_name = user[0].first_name;
		var last_name = user[0].last_name;

		if(count > '.$countL.') {
			if(uid) {
				var get = API.photos.get({"owner_id": ""+uid+"", "album_id": "profile", "rev": 1, "count": 1});
				var id = get.items[0].id;
				var message = "35 - 40. Ставь ❤ и ты следующий.\nЛайкаем и предыдущие посты.\nБеру по несколько раз 😏";
				return API.wall.repost({"group_id": '.$owner_id.', "message": "" + message + "", "object": "photo" + uid + "_" + id + ""});
			}
		} else {
			var text = "Время: '.str_replace($a2, $a3, date("H:i")).' | Лайкаем этот пост vk.com/wall-'.$owner_id.'_" + item_id + "  Нужно набрать больше '.$countL.' лайков &#10084;";
			return API.status.set({"text": "" + text + "", "group_id": '.$owner_id.'});
		}
	';
	
	Echo curl("https://api.vk.com/method/execute?code=".urlencode($code)."&v=5.33&access_token=".$token);

	function curl($url) {
		$ch = curl_init($url);
		curl_setopt ($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt ($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,false);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}
	
?>