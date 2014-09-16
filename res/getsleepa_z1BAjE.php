<?php 
include "dbconnect.php";



$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
$json_string='{"type":"sleep","ucode":"EQsaWrSnsNxKoxuAnVeWI9I1xLoiJXH8knf6","scode":"675","dates":"2014-9-15","cdate":"2014-9-15 上午11:37:15","ecode":"iyk5VJ7pI5D1rYMI","source":"w"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;
$fcode=(int)$obj -> fcode;

checkuser($ucode,$scode,$ecode,$source);

$bmr=0;

function checkNull($val){
	if (is_null($val)){
		return 0;
	}else{
		return $val;
	}
}
function timeToRealID($time){
	global $dates;
	$fdate=date('Y-m-d',strtotime($dates . " -1 day"));
	
	return (strtotime($time)-strtotime($fdate))/60;
}
//echo $cdate;


if($fcode >0){
	$sql="select * from familylist where sensorid=$scode and friendid=$fcode and guardian=1";
	$result=mysql_query($sql,$conn); 
	if(! mysql_fetch_array($result)){
		echo json_encode(array('status'=>506,'message'=>'wrong linkage between two sensorid'));
		exit();
	}
	
	$scode=$fcode;
}



$sql="select fdate,ftime,tdate,ttime from sleepdata where sid=$scode and sdate='$dates'";

$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	$fdate=$row['fdate'];
	$ftime=$row['ftime'];
	$tdate=$row['tdate'];
	$ttime=$row['ttime'];
}else{
	$fdate=date('Y-m-d',strtotime($dates . " -1 day"));
	$ftime="22:01:00";
	$tdate=$dates;
	$ttime="07:01:00";
	

}
$fdatesort=str_replace("-","",$fdate);
$tdatesort=str_replace("-","",$tdate);




$moveList=array();
$outlist=array();

$newmoveList=array();




/*
$sql="SELECT detectedposition,move+steps as move,concat('" . $yesterday ." ',stime) as stime FROM basedata_" . $ydatesort . " where sensorid=$scode and (detectedposition=1 or detectedposition=2) and stime>'12:00:00' ";
$sql .=" union SELECT detectedposition,move+steps as move,concat('" . $ldate ." ',stime) as stime FROM basedata_" . $sdate . " where sensorid=$scode and (detectedposition=1 or detectedposition=2)  and stime<'12:00:00'";

$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){

	array_push($newmoveList,  timeToRealID($row['stime']) ."|" . $row['move']."|".$row['detectedposition']);
		//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
}

*/

if($fdate != $tdate){
	$sql="SELECT move+steps as move,concat('" . $fdate ." ',stime) as stime FROM basedata_" . $fdatesort . " where sensorid=$scode and  stime>'$ftime' order by stime";
	
	
	$result=mysql_query($sql,$conn); 
	while($row=mysql_fetch_array($result)){
		$row['move']==0 ? $sleepmode=2:$sleepmode=1;
		array_push($moveList,  timeToRealID($row['stime']) ."|" . $row['move']."|".$sleepmode);
			//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
	}
	//echo $sql;
	$sql="SELECT move+steps as move,concat('" . $tdate ." ',stime) as stime FROM basedata_" . $tdatesort . " where sensorid=$scode and stime<'$ttime' order by stime";
	echo $sql;
	$result=mysql_query($sql,$conn); 
	while($row=mysql_fetch_array($result)){
		$row['move']==0 ? $sleepmode=2:$sleepmode=1;
		array_push($moveList,  timeToRealID($row['stime'])-1440 ."|" . $row['move']."|".$sleepmode);
			//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
	}
	//echo $sql;
}else{
	
	$sql="SELECT move+steps as move,concat('" . $tdate ." ',stime) as stime FROM basedata_" . $tdatesort . " where sensorid=$scode and stime>'$ftime'  and stime<'$ttime' order by stime";
	
	$result=mysql_query($sql,$conn); 
	while($row=mysql_fetch_array($result)){
		$row['move']==0 ? $sleepmode=2:$sleepmode=1;
		array_push($moveList,  timeToRealID($row['stime'])-1440 ."|" . $row['move']."|".$sleepmode);
			//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
	}
	
}



$sql="SELECT a.*,b.totalsleep,b.sleepgoal,b.deepsleep FROM sleepdata as a, dailyvalue as b WHERE a.sid=$scode and a.sid=b.sensorid and a.sdate='$dates' and a.sdate=b.date";
//echo $sql;
$result=mysql_query($sql,$conn);
if($row=mysql_fetch_array($result)){
	$out=array('status'=>200,'mindate'=>$fdate,'fdate'=>$row['fdate'],'ftime'=>$row['ftime'],'tdate'=>$row['tdate'],'ttime'=>$row['ttime'],'ecode'=>$ecode,'sleepgoal'=>$row['sleepgoal'],'totalsleep'=>$row['totalsleep'],'deepsleep'=>$row['deepsleep'],'data'=>$moveList);
	
}else{
	$out=array('status'=>200,'mindate'=>$fdate,'fdate'=>$fdate,'ftime'=>$ftime,'tdate'=>$tdate,'ttime'=>$ttime,'ecode'=>$ecode,'totalsleep'=>0,'deepsleep'=>0,'sleepgoal'=>0,'data'=>array());
	
}

echo json_encode($out);
?>

