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

$sql="select id from sleepdata where sid=$scode and sdate='$sdate'";
$result=mysql_query($sql,$conn);
if($row=mysql_fetch_array($result)){
	$id=$row['id'];	
	$sql="update sleepdata set ftime='$ftime',fdate='$fdate',ttime='$ttime',tdate='$tdate',manual=1 where id=$id";
}else{
	$sql="insert into sleepdata (sid,ftime,fdate,ttime,tdate,sdate,manual) values ($scode,'$ftime','$fdate','$ttime','$tdate', '$sdate',1)";
	
}
$result=mysql_query($sql,$conn);

$f=strtotime("$fdate $ftime");	
$t=strtotime("$tdate $ttime");	
$totalsleep=($t-$f)/60;
//echo $totalsleep ;

$ydatesort=str_replace("-","",$fdate);
$tdatesort=str_replace("-","",$tdate);
$lightsleep=0;
if($fdate != $sdate){//----------get yesterday data---------
	$sql="SELECT count(id) as lightsleepcounts FROM basedata_" . $ydatesort . " where sensorid=$scode and (move>0 or steps=2) and stime>'$ftime'";
	$result=mysql_query($sql,$conn);
	if($row=mysql_fetch_array($result)){
		$lightsleep +=$row['lightsleepcounts']*5;
	}
	//echo $sql;
	//echo "lightsleep".$lightsleep;
}

$sql="SELECT count(id) as lightsleepcounts FROM basedata_" . $tdatesort . " where sensorid=$scode and (move>0 or steps=2) and stime<='$ttime'";
$result=mysql_query($sql,$conn);
if($row=mysql_fetch_array($result)){
	$lightsleep +=$row['lightsleepcounts']*5;
}
//echo $sql;
//echo "lightsleep".$lightsleep;
$deepsleep=$totalsleep-$lightsleep;

//echo "deepsleep".$deepsleep;
$sql="update dailyvalue set totalsleep=$totalsleep, deepsleep=$deepsleep where sensorid=$scode and date='$sdate'";
//echo $sql;
$result=mysql_query($sql,$conn);
echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>