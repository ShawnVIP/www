<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$ccid=$obj -> ccid;


checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$sql="update sensorinfo set detailid=? where id=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $ccid,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->close();
$mysqli->close();  
echo json_encode(array('status'=>'200'));

?>