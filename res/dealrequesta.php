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
$now=date("Y-m-d H:i:s");


$action = 'decline';
$cdate = "2014-08-04 11:06:45";
$ecode = 'zw19zNyfhimcTweD';
$reqcode = 629;
$scode = 507;
$source = 'a';
$ucode = 'L222syBlfPBqCfrcMxnh3AMWtdROaEHtlyVv';
	
checkuser($ucode,$scode,$ecode,$source);



if($action=="accept"){$accept=1;}else{$accept=2;}

//--------------check ucode---------------------


$sql="select * from familyreqlist where fromscode=$reqcode and toscode=$scode";
echo $sql;
$result=mysql_query($sql, $conn);
if($row=mysql_fetch_array($result)){
	$guardian=$row['guardian'];
	$reltome=$row['reltome'];
	$relforme=$row['relforme'];
}else{
	echo json_encode(array('status'=>'505','message'=>'no relavance'));
	exit;
}

$sql="delete from familyreqlist where fromscode=$reqcode and toscode=$scode";
$result=mysql_query($sql, $conn);
if($accept==2){
	echo json_encode(array('status'=>'200','message'=>'already decline'));
	exit;
}

$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian) values ($reqcode,$scode,'$now','$reltome',$guardian)";
$result=mysql_query($sql, $conn);
$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian) values ($scode,$reqcode,'$now','$relforme',0)";
$result=mysql_query($sql, $conn);
	

echo json_encode(array('status'=>200,'ecode'=>$ecode));


?>