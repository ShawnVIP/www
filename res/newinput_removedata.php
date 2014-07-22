<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];


$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$rdate=$obj -> rdate;

checkuser($ucode,$scode,$ecode,$source);

$mdate=str_replace("-","",$rdate);

//--------------check ucode---------------------
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);

$sql="delete from basedata_" . str_replace("-","",$rdate) . " where sensorid=$scode";
//echo $sql;
$result=mysql_query($sql,$conn); 


$sql="delete from uploadstation where sensorid=$scode and udate='$rdate'";
$result=mysql_query($sql,$conn); 
	
$sql="delete FROM sensorstation where sensorid=$scode and sdate='$rdate'";
$result=mysql_query($sql,$conn); 	
	
$sql="delete FROM alertlist where sid=$scode and alertdate like '$rdate%'";

$result=mysql_query($sql,$conn); 	

$sql="delete from dailyvalue where sensorid=$scode and date='$rdate'";
$result=mysql_query($sql,$conn); 	



	
/*
$sql="update basedata_" . $mdate . "  set delmark=1 where sensorid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->close();
*/


echo json_encode(array('status'=>'200','ecode'=>$ecode));

?>