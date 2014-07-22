<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-1-1","cdate":"2014-1-1 23:03:22","ecode":"FShs3C7M8o37W5Vk","source":"w"}';
$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"552","dates":"2014-6-26","cdate":"2014-6-26 22:50:51","ecode":"qyRYwl3L4LUKXkir","source":"a"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;

//$vipmode=checkuser($ucode,$scode,$ecode,$source);
$vipmode=1;
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
function checkWarning($scode,$ndate,$today,$moment,$mid){ //----------calc warning data, after upload, goal setting, --------------
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
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		return;
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
		$titleinfo='less calories';
		$cata=1;
		$restinfo='less calories ' . round($rest,1);
		
	}
	if($totalsteps<$stepgoal){
		$rest=$stepgoal-$totalsteps;
		$restinfo='less steps ' . round($rest,0);
		$titleinfo='less steps';
		$cata=2;
		
	}
	if($totaldistance<$distancegoal){
		$rest=($distancegoal-$totaldistance);
		$restinfo='less distance ' .round($rest,3);
		$titleinfo='less distance';
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

checkWarning($scode,$datestr,$today,$moment,$currentNumber);

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

$sql="select bmr,stepgoal,caloriesgoal,distancegoal,stepwidth,totalcal,totaldistance, totalsteps,sleepgoal FROM dailyvalue where sensorid=$scode and date='$reqdate'";
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
$sleepgoal=$row['sleepgoal'];

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
/*
if($havedata==1){
	$sql="SELECT stime,calories,steps,distance FROM basedata_$datestr where sensorid=$scode  and stime<'$moment' order by stime";
	$result=mysql_query($sql,$conn); 
	while ($row=mysql_fetch_array($result)) {
		$calories=checkNull($row['calories']);
		$steps=checkNull($row['steps']);
		$distance=checkNull($row['distance']);
		//array_push($outlist, str_replace(":","",substr($row['stime'],0,5))."|$calories|$steps|$distance" );
	}
	
}
*/
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
	
if($umode==1){//------------rebuild data--------------------
	$sql="delete from sensorstation where sensorid=$scode and sdate='$reqdate' and adjtype=0";
	$result=mysql_query($sql,$conn); 
	for($i=0;$i<=1440;$i++){
		array_push($statusList, 0);
	}
	$sql="SELECT detectedposition,stime FROM basedata_$datestr where sensorid=$scode and delmark=0 and detectedposition is not null order by id";
	
	$result=mysql_query($sql,$conn); 
	while ($row=mysql_fetch_array($result)){
		$detectedposition=$row['detectedposition'];
		$stime=$row['stime'];
		$tmpdate=date("Y-m-d H:i:s",strtotime($reqdate . " " .$stime));
		for($k=0;$k>-5;$k--){
			$newtime=date('H:i:s',strtotime("$tmpdate $k minute"));	
			$newday=date("Y-m-d",strtotime("$tmpdate $k minute"));	
			if($newday==$reqdate && $detectedposition>2 && $detectedposition<7){
				//---------------------屏蔽 1,2,7
				$statusList[timeToRealID($newtime)]=$detectedposition;
			}
		}
	}
	$olddata=-1;
	$ordList=array();
	for($j=2;$j<1440;$j++){
		if($statusList[$j] !=$statusList[$j-1]){
			array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1]));	
		}
	}
	array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1]));	

	$sql="insert into sensorstation (sensorid,sdate,totime,position,adjtype) values ($scode,'$reqdate',?,?,0)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	for($i=0;$i<count($ordList);$i++){
		$stmt->bind_param("ss",$ordList[$i][totime],$ordList[$i][position]);
		$stmt->execute();
	}
	$stmt->close();
		
	$sql="update uploadstation set umode=0 where sensorid=$scode and udate='$reqdate'";
	$result=mysql_query($sql,$conn); 

}

//------------get sleep time-----------------------------------------


$bmr=0;
$tmpdate=explode("T", $dates); 
$moment="24:00:00";
$today=0;


$checkdate=date("Y-m-d",strtotime($tmpdate[0]));
$currentdate=date("Y-m-d",strtotime($cdate));
if($checkdate==$currentdate){
	$today=1;
	$moment=date("H:i:s",strtotime($cdate));
}


$reqdate=date("Y-m-d",strtotime($tmpdate[0]));
//echo $reqdate;
$datestr=str_replace("-","",$reqdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);


//------------------获取人工设置的sleep时间-----------------------
$sql="select fdate,ftime,tdate,ttime from sleepdata where sid=? and sdate=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $scode,$reqdate);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $fdate,$ftime,$tdate,$ttime);

if(!$stmt->fetch()){
	$fdate=date('Y-m-d',strtotime("$reqdate -1 day"));
	$ftime="22:00:00";
	$tdate=$reqdate;
	$ttime="07:00:00";
	$sql="insert into sleepdata (sid,ftime,fdate,ttime,tdate,sdate) values (?,?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssss",$scode, $ftime,$fdate,$ttime,$tdate,$reqdate);
	$stmt->execute();
	$stmt->close();
	
}




//----------预设sleep值,从前一天中午12点到当天中午12点--------------


//------开始查询
$lastdatestr=str_replace("-","",$fdate);

/*
$sql="select id,stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=? and stime>='$ftime' union select id,stime,move,sleepmode from basedata_" . $datestr . " where sensorid=? and stime<='$ttime' order by stime";
echo "select id,stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=$scode and stime>='$ftime' union select id,stime,move,sleepmode from basedata_" . $datestr . " where sensorid=$scode and stime<='$ttime'";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $scode,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(  $id,$stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	
	//array_push($moveList,array('id'=>$id,'stime'=>$stime,'move'=>$move*$sleepmode));
	array_push($moveList,$id . "|" . $stime ."|" . $move*$sleepmode);
}
echo json_encode($moveList);
*/
$sleepTime=0;
$sql="select stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=? and stime>='$ftime' order by stime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	if($move==0){
		$sleepTime+=5;
	}
}
$stmt->close();
$sql="select stime,move,sleepmode from basedata_" .$datestr . " where sensorid=? and stime<='$ttime' order by stime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	if($move==0){
		$sleepTime+=5;
	}
}

$stmt->close();
$mysqli->close;	

$sleepdata=array('mindate'=>date('Y-m-d',strtotime("$reqdate -1 day")),'fdate'=>$fdate,'ftime'=>$ftime,'tdate'=>$tdate,'ttime'=>$ttime);

$out=array('status'=>200,'caloriesGoal'=>$caloriesgoal,'calTaken'=>$totalcal,'disGoal'=>$distancegoal,'disTaken'=>$totaldistance,'stepGoal'=>$stepgoal,'stepsTaken'=>(string)$totalsteps,'sleepGoal'=>$sleepgoal,'sleepTaken'=>$sleepTime,'totalDistance'=>'0','ecode'=>$session);

echo json_encode($out);
?>

