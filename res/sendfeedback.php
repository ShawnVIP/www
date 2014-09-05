<?php

include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

$message=$obj -> message;
$appversion=$obj -> appversion;
$mdate=$obj -> mdate;
$mobile=$obj -> mobile;


checkuser($ucode,$scode,$ecode,$source);


$sql= "INSERT INTO feedback(ucode, scode, message, appversion, mdate, mobile) VALUES ('$ucode', $scode, '$message', '$appversion', '$mdate', '$mobile')"; //预处理sql语句
$result=mysql_query($sql, $conn);


echo json_encode(array('status'=>200));

	 
?>

