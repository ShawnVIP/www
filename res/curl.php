<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title></head>
<body><?php
$scode=$_REQUEST[scode];
$dates=$_REQUEST[dates];
echo "scode:" .$scode . "<br>";
echo "dates:" .$dates . "<br>";
$ch = curl_init();
	$options = array(
		//CURLOPT_URL => "http://54.245.106.189:8080/data/get_activities/",
		CURLOPT_URL => "http://54.245.106.189:8080/data/get_sleep_duration/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '{"scode":"'. $scode .'","dates":"'. $dates . '"}'
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if(curl_errno($ch)){//出错则显示错误信息
  		print curl_error($ch);
	}else{
		echo "get_sleep_duration:<br>";
		echo $response ;
	}

	// var_dump($response);
	
	$options = array(
		CURLOPT_URL => "http://54.245.106.189:8080/data/get_activities/",
		//CURLOPT_URL => "http://54.245.106.189:8080/data/get_sleep_duration/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '{"scode":"'. $scode .'","dates":"'. $dates . '"}'
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if(curl_errno($ch)){//出错则显示错误信息
  		print curl_error($ch);
	}else{
		echo "<br>get_activities:<br>";
		echo $response ;
	}
	
	
	curl_close($ch);
	


?></body></html>