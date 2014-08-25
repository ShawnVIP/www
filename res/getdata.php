<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-7-29","cdate":"2014-7-29 下午6:18:32","ecode":"K9ALSLrAwtK4QDEP","source":"w","fcode":632}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;
$fcode=(int)$obj -> fcode;
$vipmode=checkuser($ucode,$scode,$ecode,$source);
//$vipmode=1;
$bmr=0;
$tmpdate=explode(" ", $dates); 
$moment="24:00:00";
$today=0;
if($fcode >0){
	$sql="select * from familylist where sensorid=$scode and friendid=$fcode and guardian=1";
	$result=mysql_query($sql,$conn); 
	if(! mysql_fetch_array($result)){
		
		echo json_encode(array('status'=>506,'message'=>'wrong linkage between two sensorid'));
		exit();
	}
	
	$scode=$fcode;
}
$checkdate=date("Y-m-d",strtotime($tmpdate[0]));
$currentdate=date("Y-m-d",strtotime($cdate));
if($checkdate==$currentdate){
	$today=1;
	$moment=date("H:i:s",strtotime($cdate));
}

function checkNull($val){
	if (is_null($val)){
		return '';
	}else{
		if($val==0){return '';}else{return $val;}
	}
}

$reqdate=date("Y-m-d",strtotime($tmpdate[0]));
//echo $reqdate;
$datestr=str_replace("-","",$reqdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);
$currentNumber=timeToID($moment);


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例
/*
$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
*/
$session=$ecode;

checkDailyValue($scode,$reqdate,1,false);
//------------------获取当天的dailydata bmr

$sql="select bmr,stepgoal,caloriesgoal,distancegoal,stepwidth,totalcal,totaldistance, totalsteps FROM dailyvalue where sensorid=$scode and date<='$reqdate'  order by date desc limit 0,1";

//echo $sql;

$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
$bmr=$row['bmr'];
$stepgoal=$row['stepgoal'];
$caloriesgoal=$row['caloriesgoal'];
$distancegoal=$row['distancegoal'];
$stepwidth=$row['stepwidth'];
$totalcal=$row['totalcal'];
$totaldistance=$row['totaldistance'];
$totalsteps=$row['totalsteps'];


$timeList=array();
$valueList=array();
$modeList=array();
//$sleepmode=array();
$calList=array();
$stepList=array();
$disList=array();
$tempList=array();
$moveList=array();
$amode=array();
$smode=array();
$tmode=array();
$wakupList=array();
$outlist=array();
//----------预设act和sleep空值

$havedata=1;

//---------------是否有当天数据------------------
$sql="select * from  sensordate  where sensorid=$scode and yearmonth='$yearmonth' and day=$day";
$result=mysql_query($sql,$conn); 
$row=mysql_num_rows($result);
if($row==0){$havedata=0;}


function buildTime($fh,$fm,$th,$tm){
	$fromNum=$fh*60+$fm;
	$toNum=$th*60+$tm;
	$time=rand($fromNum,$toNum);
	$hour=intval($time/60);
	$min=$time-$hour*60;
	$min=floor($min/5)*5;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}
function countTime($id){

	$time=$id*5;
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour .':' : $rndTime=$hour.':';
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}
//---------分钟转id
function timeToID($time){
	$min=explode(":", $time);
	return floor(($min[0]*60+$min[1])/5);
}
//---------分钟转id不除以4
function timeToRealID($time){
	$min=explode(":", $time);
	return $min[0]*60+$min[1];
}
//---------id转分钟
function idToTime($id){
	$time=$id*5;
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour  : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}
//---------id转分钟
function realIdToTime($time){
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour  : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.':0'.$min : $rndTime=$rndTime.":".$min;
	return  $rndTime;
}

function ctod($s){
	//global $reqdate;
	$s=substr($s,0,2) . ":" . substr($s,2,2) . ":00";	
	return $s;
}
function ttos($s){
	//global $reqdate;
	$s=substr($s,0,2) .substr($s,3,2) ;	
	return $s;
}
//----------------getdata

if($havedata==1){
	$sql="SELECT stime,calories,steps,distance FROM basedata_$datestr where sensorid=$scode  and stime<'$moment' order by stime";
	$result=mysql_query($sql,$conn); 
	while ($row=mysql_fetch_array($result)) {
		$calories=checkNull($row['calories']);
		$steps=checkNull($row['steps']);
		$distance=checkNull($row['distance']);
		array_push($outlist, str_replace(":","",substr($row['stime'],0,5))."|$calories|$steps|$distance" );
	}
	
}

$edata=array();

$statusList=array();


$sql="SELECT totime,position FROM sensorstation where sensorid=$scode and sdate='$reqdate' and adjtype=0 order by totime";
$result=mysql_query($sql,$conn); 	

while ($row=mysql_fetch_array($result)){
	
	array_push($edata, array('t'=>$row['totime'] ,'i'=>($row['position'])));
}

$fdata=array();


$sql="SELECT alertdate,alerttype FROM alertlist where sid=$scode and DATE_FORMAT(alertdate,'%Y-%m-%d')='$reqdate' and delmark=0";
$result=mysql_query($sql,$conn); 	
while ($row=mysql_fetch_array($result)){
	array_push($fdata, array('date'=>$row['alertdate'] ,'type'=>$row['alerttype']));
}

$out=array('status'=>200,'caloriesgoal'=>$caloriesgoal,'disgoal'=>$distancegoal,'stepgoal'=>$stepgoal,'stepstaken'=>$totalsteps,'caltaken'=>$totalcal,'distaken'=>$totaldistance,'footperstep'=>$stepwidth, 'bmr'=> $bmr,'data'=>$outlist,'ecode'=>$session,'actedata'=>$edata,'falldata'=>$fdata);

echo json_encode($out);
?>

