<?php
	$username = "root";
	$password = "root";
	$image = $_SERVER["DOCUMENT_ROOT"].'img.png';

	function getUserIpAddr(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	date_default_timezone_set('Europe/Stockholm');
	$conn = new mysqli("127.0.0.1", $username, $password, "ip_tracker");
	mysqli_set_charset($conn,"utf8");

	$stmt = $conn->prepare("INSERT INTO `results` (`id`, `ip`, `time`) VALUES (NULL, ?, ?)");

	if($stmt) {
		$ip = getUserIpAddr();
		$time = date("Y-m-d H:i:s");
		$stmt->bind_param('ss', $ip, $time);
		$stmt->execute();
	}
	
	$fp = fopen($image, 'rb');
	
	header("Content-Type: image/png");
	header("Content-Length: " . filesize($image));

	fpassthru($fp);
?>