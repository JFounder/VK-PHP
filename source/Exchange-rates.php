<?php
	/*
	Exchange rates, with the exact time, a number of dialogues, etc.
	Курсы валют, с точным временем, количеством диалогов и т. Д.
	*/
	$token = "Access_token"; // user token
	$post_id = "0123456789"; // id wall
	
	date_default_timezone_set ("Europe/Moscow"); // time zone
	$by = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
	$servk = array("1⃣", "2⃣", "3⃣", "4⃣", "5⃣", "6⃣", "7⃣", "8⃣", "9⃣", "0⃣");
	
	$getLikes = by("photos.get?album_id=profile&rev=1&extended=1&count=1&access_token=".$token);
	$countL = $getLikes[0]["likes"]["count"];
	$comments = $getLikes[0]["comments"]["count"];

	$messageGet = by("messages.get?access_token=".$token);
	$countM = $messageGet[0];
	
	$getDialogs = by("messages.getDialogs?count&access_token=".$token);
	$countD = $getDialogs[0];
	
	$getMessages = by("messages.get?v=3.0&count=1&access_token=".$token);
	$uid = $getMessages[1]["uid"];

	$usersGet = by("users.get?user_ids=".$uid."&name_case=gen&access_token=".$token);
	$first_name = $usersGet[0]["first_name"];
	$last_name = $usersGet[0]["last_name"];
	
	$getBanned = by("account.getBanned?access_token=".$token);
	$countB = $getBanned[0];

	$usersGet = by("users.get?fields=online&name_case=Nom&access_token=".$token);
	$users_id = $usersGet[0]["uid"];
	$name = $usersGet[0]["first_name"];
	$countR = $usersGet[0]["online_mobile"];
	$countP = $usersGet[0]["online"];
	$online2 = array(0 => "спит", 1 => "с компьютера");
	$online = array( 1 => "с телефона");
	if ($countR == 1) {
		$answer = $online[$countR];
	} else {
		$answer = $online2[$countP];
	}
	
	$a = rand(1, 5);
	if($a == 1) {
		$id845175 = "Прочитай шутку: ".strip_tags(file_get_contents("http://bohdash.com/random/joke/random.php"));
	} elseif($a == 2) {
		$id845175 = "Прочитай анекдот: ".strip_tags(file_get_contents("http://bohdash.com/random/anekdot/random.php"));
	} elseif($a == 3) {
		$id845175 = "Прочитай цитату: ".strip_tags(file_get_contents("http://bohdash.com/random/citata/random.php"));
	} elseif($a == 4) {
		$url = "http://bash.im/rss/";
		$xml = xml_parser_create();
		xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($xml, file_get_contents($url), $el, $fe);
		xml_parser_free($xml);
		$return = array(12, 26, 40, 54, 68, 82, 96);
		$column = random($return);
		$bashGet = strtolower($el[$column]["value"]);
		$str_deleted = trim($bashGet);
		$id845175 = "Прочитай башорг: ".strtr($str_deleted, array("<br>" => "\n", "<div>" => "", "&quot;" => ""));
	} elseif($a == 5) {
		preg_match("/<title>	(.*?) #factroom/", file_get_contents("http://www.factroom.ru/random/"), $a);
		$id845175 = "Прочитай факты: ".$a[1];
	}
	
	$file = file_get_contents("http://www.cbr.ru/scripts/XML_daily.asp");
	preg_match("/\<Valute ID=\"R01235\".*?\>(.*?)\<\/Valute\>/is", $file, $m);
	preg_match("/<Value>(.*?)<\/Value>/is", $m[1], $r);
	preg_match("/\<Valute ID=\"R01239\".*?\>(.*?)\<\/Valute\>/is", $file, $eu);
	preg_match("/<Value>(.*?)<\/Value>/is", $eu[1], $eur);
	preg_match("/\<Valute ID=\"R01720\".*?\>(.*?)\<\/Valute\>/is", $file, $uk);
	preg_match("/<Value>(.*?)<\/Value>/is", $uk[1], $ukr);
	$rate = "\n\n💰Курс валют💰\n💵 Доллар $ - " . str_replace(",", ".", $r[1]) . " 💵\n💶 Евро € - " . str_replace(",", ".", $eur[1]) . " 💶\n🔰 Гривна - " . str_replace(",", ".", $ukr[1]) . " 🔰\n\n";

	$start  = strtotime("1 January ".date("Y"));
	$end = strtotime("1 January ".(date("Y")+1));
	$all = $end - $start;
	$now = time() - $start;
	$finish = round((100 * $now) / $all, 3);
	
	$weather = "http://export.yandex.ru/weather-ng/forecasts/34300.xml";
	$xml = simplexml_load_file($weather);
	$wiz = $xml -> fact-> temperature;
	$cloudiness = $xml -> fact -> weather_type;
	if ($wiz > 0) {
		$wiz = "+".$wiz;
	}

	$likeS = array("💗", "💘", "💙", "💚", "💛");
	$randL = rand(0,count($likeS) - 1);  
	$like = $likeS[$randL]; 
	
	$smileS = array("😸", "🙀", "😿","😾", "😹", "😼", "😻", "😎","😉", "😈", "😂", "😃", "😀");
	$randS = rand(0,count($smileS) - 1);  
	$smile = $smileS[$randS]; 
	
	$text = str_replace($by, $servk, "Обновлено: ".date("H:i")."\nВходящих сообщений: ".$countM."\nВсего переписок: ".$countD."\nПоследнее сообщение от: ".$first_name." ".$last_name."\nВ чёрном списке: ".$countB." пользователей\nНа моей аватарке: ".$countL." лайков ".$like."\nНа моей аватарке: ".$comments." комментариев\n".$rate."\n".date("Y")." год прошёл на ".$finish."%\nВ городе: ".$wiz." (".$cloudiness.")");
	
	by("wall.addComment?post_id=".$post_id."&text=".urlencode($text)."&access_token=".$token);

	function random($array) { 
		$num = rand(0, count($array)-1);
		return $array[$num]; 
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