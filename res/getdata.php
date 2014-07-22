<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-3-22","cdate":"2014-3-23 21:42:35","ecode":"v4v9S7e4kEYTmbq1","source":"w"}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;

$vipmode=checkuser($ucode,$scode,$ecode,$source);
//$vipmode=1;
$bmr=0;
$tmpdate=explode("T", $dates); 
$moment="24:00:00";
$today=0;

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);

$checkdate=date("Y-m-d",strtotime($tmpdate[0]));
$currentdate=date("Y-m-d",strtotime($cdate));
if($checkdate==$currentdate){
	$today=1;
	$moment=date("H:i:s",strtotime($cdate));
}
function checkWarning($scode,$ndate,$istoday,$moment,$mid){ //----------calc warning data, after upload, goal setting, --------------
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $conn;

	$mdate=str_replace("-","",$ndate);

	$ym=substr($mdate,0,6);
	$day=intval(substr($mdate,6,8));

	$sql="select * from sensordate where yearmonth='$ym' and day=$day and sensorid=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){return;}
		
	
	$sql="select stepgoal,caloriesgoal,distancegoal,bmr from dailyvalue where sensorid=$scode and date='$ndate'";
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		//-------------没有找到查询日期的数据，找查询日期之前的数据-------------
		$sql="select * from dailyvalue where sensorid=$scode and date<'$ndate' order by date desc limit 0,1";
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$sql="INSERT INTO dailyvalue(height, weight, step, date, stepgoal, caloriesgoal, stepwidth, distancegoal, runningwidth, bmi, sensorid, updated, age, bmr, sleepgoal, totalcal, totalsteps, totaldistance, totalsleep) VALUES (" . $row['height'] ."," . $row['weight'] ."," . $row['step'] .",'$ndate', " . $row['stepgoal'] ."," . $row['caloriesgoal'] ."," . $row['stepwidth'] ."," . $row['distancegoal'] ."," . $row['runningwidth'] ."," . $row['bmi'] .", $scode, 0," . $row['age'] ."," . $row['bmr'] ."," . $row['sleepgoal'] .",0,0,0,0)";
		$result=mysql_query($sql,$conn); 
	}else{
		$row=mysql_fetch_array($result);
		$stepgoal=$row['stepgoal'];
		$caloriesgoal=$row['caloriesgoal'];
		$distancegoal=$row['distancegoal'];
		$bmr=$row['bmr'];
	}
	
	$totalsteps=0;
	$totaldistance=0;
	$totalcal=0;

	$sql="select sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance from basedata_$mdate where sensorid=$scode and delmark=0 and stime<'$moment'";
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		return;
	}else{
		
		$row=mysql_fetch_array($result);
		$totalcal=$row['totalcal'];
		$totalsteps=$row['totalsteps'];
		$totaldistance=$row['totaldistance'];
	}
	
	$totaldistance=$totaldistance/100000;
	
	$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance where sensorid=$scode and date='$ndate'";
	$result=mysql_query($sql,$conn); 
	
	$sql="update warninginfo set delmark=1 where sensorid=$scode and date='$ndate'";
	$result=mysql_query($sql,$conn); 

	if($totalcal<$caloriesgoal){

		$rest=$caloriesgoal-$totalcal;
		$titleinfo='Less Calories';
		$cata=1;
		$restinfo=round($rest,1) . " Calroeis to Go " . $caloriesgoal;
	}
	if($totalsteps<$stepgoal){

		$rest=$stepgoal-$totalsteps;
		$titleinfo='Less Steps';
		$restinfo=round($rest,0) . " Steps to Go " . $stepgoal;
		$cata=2;
	}
	if($totaldistance<$distancegoal){
		$rest=($distancegoal-$totaldistance);
		$titleinfo='Less Distance';
		$restinfo=round($rest,2) . " Distance to Go " . $distancegoal;
		$cata=3;
	}
	$sql="insert into warninginfo ( sensorid,date,catalog,title,detail) value ( $scode,'$ndate',$cata,'$titleinfo','$restinfo')";
	$result=mysql_query($sql,$conn); 
	
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

checkWarning($scode,$reqdate,$today,$moment,$currentNumber);

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
//------------------获取当天的dailydata bmr

$sql="select bmr,stepgoal,caloriesgoal,distancegoal,stepwidth,totalcal,totaldistance, totalsteps FROM dailyvalue where sensorid=$scode and date<='$reqdate'  order by id desc limit 0,1";

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

	//-------------------get upload station----------------
$umode=1;

$sql="SELECT umode from uploadstation where sensorid=$scode and udate='$reqdate'";
$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	$umode=$row['umode'];
}else{
	$sql="insert into uploadstation ( sensorid,udate,umode) value ($scode,'$reqdate',1)";
	$result=mysql_query($sql,$conn); 
}

	
$sql="SELECT totime,position FROM sensorstation where sensorid=$scode and sdate='$reqdate' and adjtype=0 order by totime";
$result=mysql_query($sql,$conn); 	
while ($row=mysql_fetch_array($result)){
	array_push($edata, array('t'=>$row['totime'] ,'i'=>($row['position']-1)));
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

