<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$stime=$obj -> stime;
$etime=$obj -> etime;
$actid=$obj -> actid;

checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$currentdate=date("Y-m-d",strtotime($etime));
$moment=date("H:i:s",strtotime($etime));
	

$sql="delete from sensorstation where sensorid=? and sdate=? and totime=? and adjtype=1";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $scode,$currentdate,$moment);
$stmt->execute();
$stmt->close();

$sql="INSERT INTO sensorstation(sensorid, sdate, totime, position, adjtype) VALUES (?,?,?,?,1)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $scode,$currentdate,$moment,$actid);
$stmt->execute();
$stmt->close();
 

$sql="update uploadstation set umode=1 where sensorid=? and udate=?";
//echo "update uploadstation set umode=1 where sensorid=$scode and udate=$currentdate";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $scode,$currentdate);
$stmt->execute();	
$mysqli->close(); 		
echo json_encode(array('status'=>'200'));

?>