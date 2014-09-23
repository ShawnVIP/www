<?php
include "dbconnect.php";
include "build_sensor_station.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$json_string='{"data":[{"sleepmode":"0","distance":"362","move":"47","maxspeed":"133","minspeed":"27","calories":"10.300000","averagespeed":"67","detectedposition":"6","stamp":"2014-09-18 07:25:00","angle":"66","steps":"47"}],"cdate":"2014-09-18 09:52:11","ecode":"HvnTJLSI9tljrWQH","ucode":"sLpKCe4Viw4fjtrZZ6d4kugtEAVeTsWGhcS4","source":"a","scode":"678","devicetoken":"e68582f8 ec44b2e8 bc70f8c6 0da3036d 8d912c01 b1dde03a 36a4b8ba e87cf8f1"}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$data=$obj -> data;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$dateid=0;
$oldDate="";
$type="base";
$beginTime=date("Y-m-d H:i:s");

checkuser($ucode,$scode,$ecode,$source);

/*
$nowTime=date("Y-m-d H:i:s");
$difftime=strtotime($nowTime)-strtotime($beginTime);

// echo ("check user time cost" . $difftime . "\n");
$beginTime=$nowTime;
*/


function checkValueLib($scode,$date){

	global $conn;
	global $type;
	
	
	$mdate=str_replace("-","",$date);


	$ym=substr($mdate,0,6);
	$day= substr($mdate,6,8);
	$sql="select * from sensordate where yearmonth=$ym and day=$day and sensorid=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		$sql="insert into sensordate ( yearmonth,day,sensorid,type) value ($ym,$day,$scode,'$type')";
		$result=mysql_query($sql,$conn); 
	}
	
	
}


$dateList=array();
for($i=0;$i<count($data);$i++){

	$bdate=date('Y-m-d',strtotime( $data[$i] ->stamp));
	array_push($dateList,$bdate);
}


$dateList=array_unique($dateList);
$sqllist=array();

for($i=0;$i<count($dateList);$i++){
	checkValueLib($scode,$dateList[$i]);
	checkDailyValue($scode,$dateList[$i],1,false);
	
	array_push($sqllist,array('currentDay'=>$dateList[$i],'valuelist'=>array(),'timelist'=>array()));
}

$statusList=array();

function getdateID($bdate){
	global $dateList;
	for($i=0;$i<count($dateList);$i++){
		if($bdate==$dateList[$i]){
			return $i;
		}
	}
}

//-----------------------按照日期插入数据--------------------


for($i=0;$i<count($data);$i++){
	$bdate=date('Y-m-d H:i:s',strtotime( $data[$i] ->stamp));
	$dataDay=date('Y-m-d',strtotime( $bdate));
	$stime=date('H:i:s',strtotime( $bdate));
	$libname="basedata_" . str_replace("-","",$datestr);;
	$calories= $data[$i] -> calories;
	$steps= $data[$i] -> steps;
	$distance= $data[$i] -> distance;
	$temp= $data[$i] -> temp;
	$move= $data[$i] -> move;
    $distance=$distance*10; //距离单位为厘米，转换为毫米
	$angle= $data[$i] -> angle;
	$maxspeed= $data[$i] -> maxspeed;
	$minspeed= $data[$i] -> minspeed;
	$averagespeed= $data[$i] -> averagespeed;
	$detectedposition= $data[$i] -> detectedposition;
	$sleepmode= $data[$i] -> sleepmode;
	array_push($sqllist[getdateID($dataDay)][timelist],$stime);
	array_push($sqllist[getdateID($dataDay)][valuelist],array($stime,$calories,$steps,$distance,$move,$sleepmode,$angle,$maxspeed,$minspeed,$averagespeed,$detectedposition, $scode ));
}

$extmessage="";
for($i=0;$i<count($sqllist);$i++){
	$longDate=$sqllist[$i][currentDay];
	$libDate=str_replace("-","",$longDate);
	//$currentValueLong=count($sqllist[$i][valuelist]);
	if(count($sqllist[$i][valuelist])>0){
		//------------dedupe-----------------------
		
		$timelist=implode(",",$sqllist[$i][timelist]);
		echo $timelist;
		exit;
		$sql="delect from basedata_" . $libDate. " where sensorid=$scode and stime in ( $timelist)";
		$result=mysql_query($sql,$conn);
		$sql="insert into basedata_" . $libDate. " (stime, calories, steps, distance, move, sleepmode, angle, maxspeed, minspeed, averagespeed, detectedposition,sensorid) value ";
		for($j=0;$j<count($sqllist[$i][valuelist]);$j++){
			$strs="('" .  implode(",",$sqllist[$i][valuelist][$j]) . ")";
			$strs=str_replace(":00,",":00',",$strs);
			if($j==0){
				$sql .=	$strs; 
			}else{
				$sql .=	"," . $strs; 
			}
		}
		if($result=mysql_query($sql,$conn)){
			$extmessage.= $longDate . " be uploaded sucessful."; 
		} else{
			$extmessage= $longDate . " be uploaded false."; 
			echo json_encode(array('status'=>201,'extmessage'=>$extmessage));
			exit;
		}
	}
}


//-------------------refresh sensor station.-----------------------

buildSensorStation($scode,$dateList);

$nowTime=date("Y-m-d H:i:s");
$difftime=strtotime($nowTime)-strtotime($beginTime);

$beginTime=$nowTime;

//---------------------------get sensor mode-------------------------------------

$sql="update sensorlist set lastupdate='" . $nowTime ."' where sensorid=$scode";

$result=mysql_query($sql,$conn); 


$sql="select updated from sensorinfo where id=$scode";
$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
$updated=$row['updated'];

$sensorinfo=array();



if ($updated==1){
	$sql ="SELECT * FROM totalinfo  WHERE  sensorid=$scode order by date desc limit 0,1";
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$vname=array();
	$value=array();
	array_push($vname,"station");
	array_push($value,$row['station']);
	array_push($vname,"connected");
	array_push($value,$row['connected']);
	array_push($vname,"power");
	array_push($value,$row['power']);
	array_push($vname,"nickname");
	array_push($value,$row['nickname']);
	array_push($vname,"headimage");
	array_push($value,$row['headimage']);
	array_push($vname,"dob");
	array_push($value,$row['dob']);
	array_push($vname,"unit");
	array_push($value,$row['unit']);
	array_push($vname,"gender");
	array_push($value,$row['gender']);
	array_push($vname,"age");
	array_push($value,$row['age']);
	array_push($vname,"height");
	array_push($value,$row['height']);
	array_push($vname,"weight");
	array_push($value,$row['weight']);
	
	array_push($vname,"defaultgoal");
	array_push($value,$row['defaultgoal']);
	array_push($vname,"fallalert");
	array_push($value,$row['fallalert']);
	array_push($vname,"positionalert");
	array_push($value,$row['positionalert']);
	array_push($vname,"para0");
	array_push($value,$row['transmitpower']);
	array_push($vname,"para1");
	array_push($value,$row['fallthreshold']);
	array_push($vname,"para2");
	array_push($value,$row['fallimpact']);
	array_push($vname,"para3");
	array_push($value,$row['fallangleh']);
	array_push($vname,"para4");
	array_push($value,$row['fallanglel']);

	array_push($vname,"stepgoal");
	array_push($value,$row['stepgoal']);
	array_push($vname,"caloriesgoal");
	array_push($value,$row['caloriesgoal']);
	array_push($vname,"stepwidth");
	array_push($value,$row['stepwidth']);
	array_push($vname,"distancegoal");
	array_push($value,$row['distancegoal']);
	array_push($vname,"runningwidth");
	array_push($value,$row['runningwidth']);
	array_push($vname,"bmi");
	array_push($value,$row['bmi']);	
	array_push($vname,"bmr");
	array_push($value,$row['bmr']);	
	array_push($vname,"sleepgoal");
	array_push($value,$row['sleepgoal']);	
	array_push($vname,"detailid");
	array_push($value,$row['detailid']);	
	array_push($vname,"usertype");
	array_push($value,$row['vipmode']);	
	$sensorinfo=array_combine($vname,$value);

}else{
	array_push($sensorinfo,array('station'=>-1));
}

//$ecode=randomkeys(16);
//saveSession($ucode,$scode,$ecode,$source);

mysql_close($conn);  

	
echo json_encode(array('status'=>200,'updated'=>$updated,'scode'=>$scode,'sdata'=>$sensorinfo,'ecode'=>$ecode,'extmessage'=>$extmessage));
?>