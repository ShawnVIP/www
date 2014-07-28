<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$email=$obj -> mail;
$key=$obj -> key;
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql ="select userid from accountinfo where email=? and forgetstr=?";
$userid="";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $email,$key);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userid); 
if (! $stmt->fetch()) {
	echo json_encode(array('status'=>401)); //邮件不存在
}else{
	echo json_encode(array('status'=>'200','ucode'=>$userid));
}

?>
