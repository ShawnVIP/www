<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$umail=$obj -> umail;
$passkey=$obj -> passkey;
$password=$obj -> password;


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql ="select salt from accountinfo where userid=? and email=? and forgetstr=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("sss", $ucode,$umail,$passkey);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($salt); 
if (! $stmt->fetch()) {
	echo json_encode(array('status'=>401)); 
}else{
	$password = convertpass($salt,$password);
	$sql ="update accountinfo set password=?,forgetstr='' where userid=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("ss", $password,$ucode);
	$stmt->execute();
	echo json_encode(array('status'=>'200'));
}

?>
