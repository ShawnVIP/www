<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$type=$obj -> type;
$num=$obj -> num;

checkuser($ucode,$scode,$ecode,$source);
$accept=0;
if($type=="accept"){$accept=1;}

//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	
$sqla ="update familyreqlist set accept=". $accept .", deal=1 where fromscode=? and toscode=? and delmark=0";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ss", $num, $scode);
$stmta->execute();


$sqla="select reltome,relforme from familyreqlist where fromscode=? and toscode=?";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ss", $num, $scode);
$stmta->execute();
$stmta->bind_result($reltome,$relforme);  
if(! $stmta->fetch()){
	echo json_encode(array('status'=>'101'));
	exit;
}



$sqla="insert into familylist ( sensorid,friendid,sdate,relation) values (?,?,?,?)";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ssss", $num,$scode,$now,$reltome);
$stmta->execute();
$stmta->bind_param("ssss",$scode,$num,$now,$relforme);
$stmta->execute();
echo json_encode(array('status'=>200,'ecode'=>$ecode));


?>