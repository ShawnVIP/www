<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$action=$obj -> action;
$reqcode=$obj -> reqcode;

checkuser($ucode,$scode,$ecode,$source);

if($action=="accept"){$accept=1;}else{$accept=2;}

//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	
$sqla ="update familyreqlist set accept=". $accept .", deal=1 where fromscode=? and toscode=? and delmark=0 and deal=0";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ss", $reqcode, $scode);
$stmta->execute();


$sqla="select reltome,relforme,guardian from familyreqlist where fromscode=? and toscode=? and deal=1";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ss", $reqcode, $scode);
$stmta->execute();
$stmta->bind_result($reltome,$relforme,$guardian);  
if(! $stmta->fetch()){
	echo json_encode(array('status'=>'505'));
	exit;
}

if($accept==1){
	$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
	mysql_select_db($mysql_database,$conn);
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");


	$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian) values ($reqcode,$scode,'$now','$reltome',0)";
	$result=mysql_query($sql, $conn);
	$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian) values ($scode,$reqcode,'$now','$relforme',$guardian)";
	$result=mysql_query($sql, $conn);
	

}
echo json_encode(array('status'=>200,'ecode'=>$ecode));


?>