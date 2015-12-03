<?php 
/*
	if($_GET["zipcode"]) {
		$user_zipcode = $_GET["zipcode"];
	} else {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		try {
			$API_KEY = "6a7eb4263fab5bf9a38c52df94da19794caeee070032906aa0c9c9e36ca29d0f";
			$ip_info = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$API_KEY&ip=$ipaddress&format=json"),TRUE);
			$user_zipcode = $ip_info['zipCode'];
		}	
		catch(Exception $e) {
			$user_zipcode = "95112";
		}
}
*/
?>