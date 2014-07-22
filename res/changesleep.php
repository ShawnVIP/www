<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$ftime=$obj -> ftime;
$ttime=$obj -> ttime;
$fdate=$obj -> fdate;
$tdate=$obj -> tdate;
$sdate=$obj -> sdate;

checkuser($ucode,$scode,$ecode,$source);


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$sql="select id from sleepdata where sid=? and sdate=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $scode,$sdate);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id);
if($stmt->fetch()){
	$sql="update sleepdata set ftime=?,fdate=?,ttime=?,tdate=? where id=$id";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ssss", $ftime,$fdate,$ttime,$tdate);
	$stmt->execute();
	$stmt->close();
}else{
	$sql="insert into sleepdata (sid,ftime,fdate,ttime,tdate,sdate) values (?,?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssss",$scode, $ftime,$fdate,$ttime,$tdate,$sdate);
	$stmt->execute();
	$stmt->close();
}

$mysqli-> close();

echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>