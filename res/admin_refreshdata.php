<?php
include "dbconnect.php";
include "build_sensor_station.php";
writeGetUrlInfo();

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 


$scode=$obj -> sensorid;
$dates=$obj -> date;
$dateList=array();
array_push($dateList,$dates);

buildSensorStation($scode,$dateList);
	
echo json_encode(array('status'=>200));

?>