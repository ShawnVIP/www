<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例


$sql="update sensorinfo set updated=0 where id=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
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

echo json_encode(array('status'=>200));
?>

