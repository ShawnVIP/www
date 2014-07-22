<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];


$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$dates=$obj -> dates;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$dayList=array();
checkuser($ucode,$scode,$ecode,$source);
//----------check weather have data on that day

$reqdate=date("Y-m-d",strtotime($dates));
$datestr=str_replace("-","",$reqdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

//------------------获取当天的dailydata bmr
$sql="select day from sensordate where yearmonth=? and sensorid=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $yearmonth,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $day);
while($stmt->fetch()){
	array_push($dayList, $day);
}
$stmt->close();
/*
$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
*/
$session=$ecode;

$mysqli ->close();
echo json_encode(array('status'=>200, 'data'=>$dayList,'ecode'=>$session));	
?>