<?php
include "dbconnect.php";
include "calcdeepsleep.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"zQfamcJxXgviG6C7","fdate":"2014-09-09","tdate":"2014-09-10","ftime":"22:15:00","ttime":"07:00:00","sdate":"2014-9-10","source":"w"}';
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

$sql="select id from sleepdata where sid=$scode and sdate='$sdate'";
$result=mysql_query($sql,$conn);
if($row=mysql_fetch_array($result)){
	$id=$row['id'];	
	$sql="update sleepdata set ftime='$ftime',fdate='$fdate',ttime='$ttime',tdate='$tdate',manual=1 where id=$id";
}else{
	$sql="insert into sleepdata (sid,ftime,fdate,ttime,tdate,sdate,manual) values ($scode,'$ftime','$fdate','$ttime','$tdate', '$sdate',1)";
	
}
$result=mysql_query($sql,$conn);


changesleeptime($sdate,$fdate,$ftime,$tdate,$ttime,$scode);

echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>