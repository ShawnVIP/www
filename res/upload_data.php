<?php
include "dbconnect.php";
include "build_sensor_station.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

//$json_string='{"ucode":"f2026d8c-d99c-4535-2a7b-7ad18c28c4b5","scode":"1","data":[{"stamp":"2013-05-31 13:02","rawdata":[{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30}]}],"type":"raw"}';

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
	//echo $sql;
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