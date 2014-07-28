<?php

include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$messageid=$obj -> messageid;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);



$now=date("Y-m-d H:i:s");
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql="select * from message where toid=? and id=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss",$scode,$messageid);
$stmt->execute();
if (!$stmt->fetch()) {
	echo json_encode(array('status'=>602));	
	exit;
}



$sql = "update message set  readmode=1 where id=?"; //预处理sql语句

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("s", $messageid);
$stmt->execute();
$mysqli->close();

echo json_encode(array('status'=>200));	
	 
?>

