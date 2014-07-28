<?php

$ch = curl_init();
	$options = array(
		//CURLOPT_URL => "http://54.245.106.189:8080/data/get_activities/",
		CURLOPT_URL => "http://54.245.106.189:8080/data/get_sleep_duration/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '{"scode":"85","dates":"2013-6-27"}'
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if(curl_errno($ch)){//出错则显示错误信息
  		print curl_error($ch);
	}else{
		echo $response ;
	}

	// var_dump($response);
	
	$options = array(
		CURLOPT_URL => "http://54.245.106.189:8080/data/get_activities/",
		//CURLOPT_URL => "http://54.245.106.189:8080/data/get_sleep_duration/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '{"scode":"85","dates":"2013-6-27"}'
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if(curl_errno($ch)){//出错则显示错误信息
  		print curl_error($ch);
	}else{
		echo $response ;
	}
	
	
	curl_close($ch);
	


?>