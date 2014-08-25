<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"605","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alertlist":[{"stamp":"'.$now.'","type":129}]}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$poslist=$obj -> poslist;
$alertlist=$obj -> alertlist;
checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql="INSERT INTO sensorposition(scode, udate, longitude, latitude) values ($scode,?,?,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

for($i=0;$i<count($poslist);$i++){
	$stamp=$poslist[$i] -> stamp;
	$longitude=$poslist[$i] -> longitude;
	$latitude=$poslist[$i] -> latitude;
	
	$stmt->bind_param("sss",$stamp,$longitude,$latitude);
	$stmt->execute();
}
$stmt->close();

$sql="INSERT INTO alertposition(scode, udate, longitude, latitude) values ($scode,?,?,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

for($i=0;$i<count($alertlist);$i++){
	$stamp=$alertlist[$i] -> stamp;
	$longitude=$alertlist[$i] -> longitude;
	$latitude=$alertlist[$i] -> latitude;
	
	$stmt->bind_param("sss",$stamp,$longitude,$latitude);
	$stmt->execute();
}
$stmt->close();

echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>