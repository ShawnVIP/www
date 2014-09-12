<?php
include "dbconnect.php";
include "build_sensor_station.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$json_string='{"data":[{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:30:00","angle":"13","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:40:00","angle":"13","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:40:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:50:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:00:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:10:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:20:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"4","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 10:25:00","angle":"10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 10:30:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:35:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:45:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 10:55:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:05:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"6","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 11:15:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"9","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:20:00","angle":"13","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:25:00","angle":"13","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 11:35:00","angle":"13","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 11:45:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"3","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 11:50:00","angle":"-9","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 11:55:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"569","move":"9","maxspeed":"104","minspeed":"36","calories":"11.200000","averagespeed":"65","detectedposition":"6","stamp":"2014-09-12 12:00:00","angle":"-90","steps":"68"},{"sleepmode":"0","distance":"3712","move":"20","maxspeed":"104","minspeed":"36","calories":"24.100000","averagespeed":"61","detectedposition":"5","stamp":"2014-09-12 12:05:00","angle":"73","steps":"442"},{"sleepmode":"0","distance":"253","move":"56","maxspeed":"130","minspeed":"26","calories":"9.900000","averagespeed":"71","detectedposition":"6","stamp":"2014-09-12 12:10:00","angle":"87","steps":"33"},{"sleepmode":"1","distance":"81","move":"18","maxspeed":"104","minspeed":"35","calories":"8.900000","averagespeed":"58","detectedposition":"3","stamp":"2014-09-12 12:15:00","angle":"-77","steps":"11"},{"sleepmode":"1","distance":"0","move":"7","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"3","stamp":"2014-09-12 12:25:00","angle":"-78","steps":"0"},{"sleepmode":"1","distance":"0","move":"11","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"3","stamp":"2014-09-12 12:20:00","angle":"-71","steps":"0"},{"sleepmode":"0","distance":"433","move":"51","maxspeed":"130","minspeed":"31","calories":"10.300000","averagespeed":"61","detectedposition":"5","stamp":"2014-09-12 12:30:00","angle":"77","steps":"58"},{"sleepmode":"0","distance":"1857","move":"28","maxspeed":"104","minspeed":"26","calories":"14.000000","averagespeed":"47","detectedposition":"5","stamp":"2014-09-12 12:35:00","angle":"-86","steps":"235"},{"sleepmode":"0","distance":"237","move":"32","maxspeed":"104","minspeed":"26","calories":"9.400000","averagespeed":"50","detectedposition":"5","stamp":"2014-09-12 12:40:00","angle":"-10","steps":"32"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 12:45:00","angle":"-9","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 12:50:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 12:55:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:00:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"6","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 13:05:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:10:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:15:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:20:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:25:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:30:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 13:35:00","angle":"10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 13:40:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:45:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:50:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 13:55:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 14:00:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 14:05:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"4","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 14:10:00","angle":"-11","steps":"0"},{"sleepmode":"1","distance":"0","move":"17","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 14:15:00","angle":"10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 14:20:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 14:25:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 14:30:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"4","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 14:35:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 14:40:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 14:45:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"1","stamp":"2014-09-12 14:50:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:05:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"4","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 14:55:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:00:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:10:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:15:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:20:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:25:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:30:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:35:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:40:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:45:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:50:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 15:55:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:00:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:05:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:10:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:15:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:20:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:30:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:25:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:35:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:40:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:45:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:50:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 16:55:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:00:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:05:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:10:00","angle":"11","steps":"0"},{"sleepmode":"1","distance":"50","move":"1","maxspeed":"104","minspeed":"78","calories":"8.800000","averagespeed":"91","detectedposition":"4","stamp":"2014-09-12 17:15:00","angle":"-10","steps":"7"},{"sleepmode":"1","distance":"0","move":"1","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:20:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:25:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"0","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:30:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"2","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"0","stamp":"2014-09-12 17:35:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"5","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 17:40:00","angle":"-10","steps":"0"},{"sleepmode":"1","distance":"0","move":"4","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 17:45:00","angle":"10","steps":"0"},{"sleepmode":"1","distance":"0","move":"3","maxspeed":"0","minspeed":"0","calories":"8.600000","averagespeed":"0","detectedposition":"4","stamp":"2014-09-12 17:50:00","angle":"-9","steps":"0"},{"sleepmode":"0","distance":"115","move":"9","maxspeed":"130","minspeed":"45","calories":"9.100000","averagespeed":"72","detectedposition":"6","stamp":"2014-09-12 17:55:00","angle":"-10","steps":"15"}],"cdate":"2014-09-12 17:55:02","ecode":"I94JznFXi4V87y5h","ucode":"yPRMDctJYWYOxSmR7Dlp4GHhMFbhuatm4IXT","source":"a","scode":"1","devicetoken":"b4960c98 7be9cfae 47aee3f7 fc58724f 706b9619 239070e5 25bfe0be 1c403444"}';

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

//checkuser($ucode,$scode,$ecode,$source);

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
	$tDate=explode(" ", $data[$i] ->stamp);
	
	$bdate=date('Y-m-d',strtotime($tDate[0]));
	array_push($dateList,$bdate);
}


$dateList=array_unique($dateList);

for($i=0;$i<count($dateList);$i++){
	checkValueLib($scode,$dateList[$i]);
	checkDailyValue($scode,$dateList[$i],1,false);
}

$statusList=array();

$rndstring=randomkeys(36);
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql="insert into tempupload (sdate,stime,calories,steps,distance,move,sleepmode,angle,maxspeed,minspeed,averagespeed,detectedposition,sensorid,rndstring) values (?,?,?,?,?,?,?,?,?,?,?,?,$scode,'$rndstring')";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$datelListStr="";

for($i=0;$i<count($data);$i++){
	$ndate=explode(" ", $data[$i] -> stamp);
	$datestr=str_replace("-","",$ndate[0]);
	//checkValueLib($datestr);
	//-------------save time
	$sourcedate=$data[$i] -> stamp;
	$sourcedate= $sourcedate. ":00";
	$ntime=$ndate[1]. ":00";
	$libname="basedata_" .$datestr;
	
	$calories= $data[$i] -> calories;
	$steps= $data[$i] -> steps;
	$distance= $data[$i] -> distance;

	$temp= $data[$i] -> temp;
	$move= $data[$i] -> move;
    $distance=$distance*10;
        //$move=$move*10;
	$angle= $data[$i] -> angle;
	$maxspeed= $data[$i] -> maxspeed;
	$minspeed= $data[$i] -> minspeed;
	$averagespeed= $data[$i] -> averagespeed;
	$detectedposition= $data[$i] -> detectedposition;

	$sleepmode= $data[$i] -> sleepmode;
	

	$stmt->bind_param("ssssssssssss",$datestr,$ntime,$calories,$steps,$distance,$move,$sleepmode,$angle,$maxspeed,$minspeed,$averagespeed,$detectedposition);
	$stmt->execute();

	
}


//-------------dedupe-----------------
for($i=0;$i<count($dateList);$i++){
	$ldate=$dateList[$i];
	$sdate=str_replace("-","",$ldate);
	/*
	$sql="update uploadstation set umode=1 where sensorid=$scode and udate='" . $dateList[$i][ldate] ."'";
	$result=mysql_query($sql,$conn); 
	*/

	$sql="delete from basedata_" . $sdate. " where sensorid=$scode and stime in (select stime from tempupload where sensorid=$scode and sdate='" .$sdate."' and rndstring='" . $rndstring . "')";
	// echo $sql;
	$result=mysql_query($sql,$conn); 
	

	$sql="insert into basedata_" . $sdate. " (stime, calories, steps, distance, move, sleepmode, actmode, tempmode, wakeup, sleepbelongs, sensorid, angle, maxspeed, minspeed, averagespeed, detectedposition) select stime, calories, steps, distance, move, sleepmode, actmode, tempmode, wakeup, sleepbelongs, sensorid, angle, maxspeed, minspeed, averagespeed, detectedposition from tempupload where sensorid=$scode and sdate='" .$sdate."' and rndstring='" . $rndstring . "'";
	echo $sql;
	$result=mysql_query($sql,$conn); 
	
	//$sql="delete from tempupload where rndstring='" . $rndstring . "'";
	//$result=mysql_query($sql,$conn); 

}

$mysqli->close;	

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

	
echo json_encode(array('status'=>200,'updated'=>$updated,'scode'=>$scode,'sdata'=>$sensorinfo,'ecode'=>$ecode));
?>