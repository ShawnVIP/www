<?php

include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 
$ucode=$obj ->ucode;
$scode=$obj ->scode;
$ecode=$obj ->ecode;
$source=$obj ->source;

$category=$obj ->category;
$k_met=$obj ->k_met;
$a_interval=$obj ->a_interval;
$type=$obj ->type;
$goal=$obj ->goal;
$sleeptime=$obj ->sleeptime;
$getuptime=$obj ->getuptime;
$s_interval=$obj ->s_interval;
$sleep_quality=$obj ->sleep_quality;
$activity_level_threshold=$obj ->activity_level_threshold;
$raw_data_enable=$obj ->raw_data_enable;
$num_3D=$obj ->num_3D;
$rf_interval=$obj ->rf_interval;

checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql="insert into  learningdata (scode,category,k_met,a_interval,type,goal,sleeptime,getuptime,s_interval,sleep_quality,activity_level_threshold,raw_data_enable,num_3D,rf_interval) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	//echo "insert into rawdata_timelist (sensorid,start,stop) values ($scode,$start,$stop)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssssssssssssss",$scode,$category, $k_met, $a_interval,$type,$goal,$sleeptime,$getuptime,$s_interval, $sleep_quality, $activity_level_threshold,$raw_data_enable,$num_3D,$rf_interval);
$stmt->execute();
$stmt->close();
	
echo json_encode(array('status'=>200,'ecode'=>$ecode));

?>