<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 


$scode=$obj -> sensorid;
$dates=$obj -> date;


$statusList=array();
$dateList=array();
if($_POST[mode]==1){
	$scode=$_POST[scode];
	$dates=$_POST[date];
}
//---------分钟转id不除以4
function timeToRealID($time){
	$min=explode(":", $time);
	return $min[0]*60+$min[1];
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

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$tempstr=explode("|",$dates);
for($i=0;$i<count($tempstr);$i++){
	$tomorrow=date('Y-m-d',strtotime($tempstr[$i] . " 1 day"));
	$yesterday=date('Y-m-d',strtotime($tempstr[$i] . " -1 day"));
	array_push($dateList,  array('ldate'=>$tempstr[$i] ,'sdate'=>str_replace("-","",$tempstr[$i]), 'ydatelong'=>$yesterday,'ydatesort'=>str_replace("-","",$yesterday),'tdatelong'=>$tomorrow,'tdatesort'=>str_replace("-","",$tomorrow)));
}

//echo json_encode(array('status'=>$dateList));
//-------------dedupe-----------------
$sqllist=array();
for($i=0;$i<count($dateList);$i++){
	
	//----rebuild----------------------
	$reqdate=$dateList[$i][ldate];
	$sql="delete from sensorstation where sensorid=$scode and sdate='" . $dateList[$i][ldate] . "' and adjtype=0";
	$result=mysql_query($sql,$conn); 
	for($k=0;$k<=1440;$k++){
		array_push($statusList, 0);
	}
	

	//----------------------------分析标准数据，从当天的第一个数字到第二天第一数字--------------------
	
	
	
	
	
	$sql="SELECT detectedposition,concat('" . $dateList[$i][ldate] ." ',stime) as stime FROM basedata_" . $dateList[$i][sdate] . " where sensorid=$scode";
	$sql .=" union SELECT detectedposition,concat('" . $dateList[$i][tdatelong] ." ',stime) as stime FROM basedata_" . $dateList[$i][tdatesort] . " where sensorid=$scode and stime<'00:05:00'";
	
	$result=mysql_query($sql,$conn); 
	while ($row=mysql_fetch_array($result)){
		$detectedposition=$row['detectedposition'];
		if($detectedposition==2){$detectedposition=1;} //---1,2 都是睡眠模式------
		$stime=$row['stime'];
		$tmpdate=date("Y-m-d H:i:s",strtotime($stime));
		for($k=0;$k>-5;$k--){
			$newtime=date('H:i:s',strtotime("$tmpdate $k minute"));	
			$newday=date("Y-m-d",strtotime("$tmpdate $k minute"));	
			if($newday==$reqdate){
				$statusList[timeToRealID($newtime)]=$detectedposition;
			}
		}
	}
	$olddata=-1;
	$ordList=array();
	$lasttime=1;
	for($j=2;$j<1440;$j++){
		if($statusList[$j] !=$statusList[$j-1]){
			array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	
			$lasttime=1;
		}else{
			$lasttime++;
		}
	}
	array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	

	$sql="insert into sensorstation (sensorid,sdate,totime,position,adjtype,lasttime) values ($scode,'$reqdate',?,?,0,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	for($k=0;$k<count($ordList);$k++){
		$stmt->bind_param("sss",$ordList[$k][totime],$ordList[$k][position],$ordList[$k][lasttime]);
		$stmt->execute();
	}
	$stmt->close();
	
	//------------------update dailyvalue-------------------
	$sql="select sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance  from  basedata_" . $dateList[$i][sdate] . "  where sensorid=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$totalcal=$row['totalcal'];
	$totalsteps=$row['totalsteps'];
	$totaldistance=$row['totaldistance'];
	
	//----------------------------分析睡眠数据，从昨天中午12点到今天中午12点-------------------------
	$sql="SELECT detectedposition,concat('" . $dateList[$i][ydatelong] ." ',stime) as stime FROM basedata_" . $dateList[$i][ydatesort] . " where sensorid=$scode and (detectedposition=1 or detectedposition=2) and stime>'12:00:00'";
	$sql .=" union SELECT detectedposition,concat('" . $dateList[$i][ldate] ." ',stime) as stime FROM basedata_" . $dateList[$i][sdate] . " where sensorid=$scode and (detectedposition=1 or detectedposition=2)  and stime<'12:00:00'";
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	$fromtime=$dateList[$i][ldate] . " 00:00:00";
	$totime=$dateList[$i][ldate] . " 00:00:00";
	
	$deepsleep=0;
	$totalsleep=0;
	
	while($row=mysql_fetch_array($result)){
		
		$totalsleep+=5;
		if($row['detectedposition']==2){
			$deepsleep+=5;	
		}
		if($row['stime']<$fromtime){$fromtime=$row['stime'];}
		if($row['stime']>$totime){$totime=$row['stime'];}
		
	}
	if($fromtime==$totime){
		$fromtime=$dateList[$i][ydatelong] . " 22:00:00";
		$totime=$dateList[$i][ldate] . " 07:00:00";
	}
	
	
	$ftime=date('H:i:s',strtotime($fromtime));	
	$fdate=date("Y-m-d",strtotime($fromtime));	
	$ttime=date('H:i:s',strtotime($totime));	
	$tdate=date("Y-m-d",strtotime($totime));	
	
	$sql="select * from sleepdata where sid=$scode and sdate='$tdate'";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$sql="update sleepdata set fdate='$fdate', ftime='$ftime', tdate='$tdate', ttime='$ttime' where sid=$scode and sdate='$tdate'";
		$result=mysql_query($sql,$conn); 
	}else{
		$sql="INSERT INTO sleepdata(sid, sdate, ftime, ttime, fdate, tdate) VALUES ($scode, '$ftime', '$ttime', '$fdate', '$tdate')";
		$result=mysql_query($sql,$conn); 
	}
	//echo $sql;
	$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance, totalsleep=$totalsleep,deepsleep=$deepsleep where sensorid=$scode and date='".$tdate. "'";
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	
	
}

$mysqli->close;	
	
echo json_encode(array('status'=>200));

?>