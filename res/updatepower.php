<?php
include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$power=$obj -> power;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$cdate=$obj -> cdate;

checkuser($ucode,$scode,$ecode,$source);
//$scode=1;
//$cdate="2014-5-6 22:29:00";
//$power=80;
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$sql="update sensorinfo set power=?, lastupdate=? where id=?";
//echo "update sensorinfo set power=$power, lastupdate=$cdate  where id=$scode";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss",$power,$cdate,$scode);
$stmt->execute();
$stmt->close();
$mysqli->close();
echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>
