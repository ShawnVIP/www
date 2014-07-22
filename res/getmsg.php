<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);



//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	
$sqla ="SELECT a.message,b.nickname, a.rdate,b.headimage,b.id,a.relforme from familyreqlist as a,sensorinfo as b where a.fromscode=b.id and a.toscode=? and a.deal=0";
	
$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("s", $scode);
$stmta->execute();
$stmta->store_result();
$stmta->bind_result($message, $nickname, $rdate,$head,$code,$relation);
	
$mname=array();
	
while ($stmta->fetch()) {
	array_push($mname,array('message'=>$nickname . ' just invited you a friend invitation.','nickname'=>$nickname,'rdate'=>$rdate,'head'=>$head,'scode'=>$code,'relation'=>$relation));	
}

echo json_encode(array('status'=>200,'msglist'=>$mname,'ecode'=>$ecode));


?>