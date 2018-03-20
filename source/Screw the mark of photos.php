<?php
	//Накрутка отметки фотографий
	$token = "Access_token"; // Токен
	$album_id = ""; // ID альбома
	$uid = ""; // ID кого отмечать
	
	$photosgetUploadServer = api("photos.getUploadServer", "album_id=".$album_id."&access_token=".$token);
	$upload_url = $photosgetUploadServer["response"]["upload_url"];
	$path  = dirname(__FILE__);
	$array = array("file1" => "@".$path."/test.jpg", "file2" => "@".$path."/test.jpg");
	$upload = curl($upload_url, $array);
	$json = json_decode($upload, 1);
	$server = $json["server"];
	$photos_list = $json["photos_list"];
	$hash = $json["hash"];
	$photossave = api("photos.save", "album_id=".$album_id."&hash=".$hash."&server=".$server."&photos_list=".$photos_list."&access_token=".$token);
	api("photos.putTag", "photo_id=".$photossave["response"][0]["pid"]."&user_id=".$uid."&x=10&y=10&x2=80&y2=80&access_token=".$token).'<br>';
	api("photos.putTag", "photo_id=".$photossave["response"][1]["pid"]."&user_id=".$uid."&x=10&y=10&x2=80&y2=80&access_token=".$token);
	function api($method, $peremeter){ 
		return json_decode(curl("https://api.vk.com/method/" . $method . "?" . $peremeter),1); 
	}
	function curl($url, $post = null){
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417
		Firefox/3.0.3');
		if($post){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec( $ch );
		curl_close( $ch );
		return $response;
	}
?>