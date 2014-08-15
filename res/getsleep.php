<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);

$bmr=0;

function checkNull($val){
	if (is_null($val)){
		return 0;
	}else{
		return $val;
	}
}

//echo $cdate;

$datestr=str_replace("-","",$cdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);

$sql="select fdate,ftime,tdate,ttime from sleepdata where sid=$scode and sdate='$dates'";

$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
		
$sql="select * from dailyvalue where sensorid=$scode and date='$dates'";
$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	$totalsleep=$row['totalsleep'];
	$deepsleep=$row['deepsleep'];
}else{
	$totalsleep=0;
	$deepsleep=0;
	
}

$moveList=array();
$outlist=array();



function timeToRealID($time){
	$min=explode(":", $time);
	return $min[0]*60+$min[1];
}

$yesterday=date('Y-m-d',strtotime($dates . " -1 day"));
$ydatesort=str_replace("-","",$yesterday);
$sdate=str_replace("-","",$dates);



$sql="SELECT detectedposition,concat('" . $yesterday ." ',stime) as stime FROM basedata_" . $ydatesort . " where sensorid=$scode and (detectedposition=1 or detectedposition=2) and stime>'12:00:00'";
$sql .=" union SELECT detectedposition,concat('" . $dateList[$i][ldate] ." ',stime) as stime FROM basedata_" . $dateList[$i][sdate] . " where sensorid=$scode and (detectedposition=1 or detectedposition=2)  and stime<'12:00:00'";

if($tdate>$fdate){

	$sql="select stime,move+steps as move,detectedposition as sleepmode from basedata_" .$lastdatestr . " where sensorid=? and stime>='$ftime' order by stime";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("s", $scode);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $stime,$move,$sleepmode);
	//-----------save data----------------------------
	
	while($stmt->fetch()){
		array_push($moveList,  timeToRealID($stime) ."|" . $move."|".$sleepmode);
		//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
	}
	$stmt->close();
	$baseid=0;
	$addstr="";
}else{
	$baseid=720;
	$addstr=" and stime>='$ftime' ";
}
$sql="select stime,move+steps as move,detectedposition as sleepmode from basedata_" .$datestr . " where sensorid=? and stime<='$ttime' $addstr order by stime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $stime,$move,$sleepmode);
//-----------save data----------------------------
$deepsleep=0;
while($stmt->fetch()){
	array_push($moveList,  $baseid+timeToRealID($stime) ."|". $move."|".$sleepmode);
	if($sleepmode==2){$deepsleep+=5;}
	//array_push($moveList,  720+timeToRealID($stime)."|" . $stime  ."|". $move);
}

$stmt->close();
$mysqli->close;	
$out=array('status'=>200,'mindate'=>date('Y-m-d',strtotime("$cdate -1 day")),'fdate'=>$fdate,'ftime'=>$ftime,'tdate'=>$tdate,'ttime'=>$ttime,'ecode'=>$ecode,'totalsleep'=>$totalsleep,'deepsleep'=>$deepsleep,'data'=>$moveList);

echo json_encode($out);
?>

