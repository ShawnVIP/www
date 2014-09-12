<?php

include "dbconnect.php";
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
$dates=array();
array_push($dates,'2014-08-27');
buildSensorStation(605,$dates);
function buildSensorStation($scode,$dateList){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $conn;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

	$statusList=array();
	$ordList=array();
	for($i=0;$i<count($dateList);$i++){
		$tdatelong=date('Y-m-d',strtotime($dateList[$i] . " 1 day"));
		$ydatelong=date('Y-m-d',strtotime($dateList[$i] . " -1 day"));
		$ldate=$dateList[$i];
		$sdate=str_replace("-","",$ldate);
		$ydatesort=str_replace("-","",$ydatelong);
		$tdatesort=str_replace("-","",$tdatelong);
		

		$sql="delete from sensorstation where sensorid=$scode and sdate='" . $ldate. "' and adjtype=0";
		$result=mysql_query($sql,$conn); 
		$statusList=array();
		for($k=0;$k<=1440;$k++){
			array_push($ordList,0);
			array_push($statusList,7);
		}
		
		//----------------------------分析标准数据，从当天的第一个数字到第二天第一数字--------------------
		
		$sql="SELECT detectedposition,concat('" . $ldate ." ',stime) as stime FROM basedata_" . $sdate . " where sensorid=$scode";
		$sql .=" union SELECT detectedposition,concat('" . $tdatelong ." ',stime) as stime FROM basedata_" . $tdatesort . " where sensorid=$scode and stime<'00:05:00'";
		$result=mysql_query($sql,$conn); 
		while ($row=mysql_fetch_array($result)){
			$detectedposition=$row['detectedposition'];
			if($detectedposition==2){$detectedposition=1;} //---1,2 都是睡眠模式------
			$stime=$row['stime'];
			$tmpdate=date("Y-m-d H:i:s",strtotime($stime));
			for($k=0;$k>-5;$k--){
				$newtime=date('H:i:s',strtotime("$tmpdate $k minute"));	
				$newday=date("Y-m-d",strtotime("$tmpdate $k minute"));	
				if($newday==$ldate){
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
		if($statusList[$j-1] != 7){
			array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	
		}
		
		
		$sql="insert into sensorstation (sensorid,sdate,totime,position,adjtype,lasttime) values ($scode,'$ldate',?,?,0,?)";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql);
		for($k=0;$k<count($ordList);$k++){
			if($ordList[$k][position] !=-1){
				$stmt->bind_param("sss",$ordList[$k][totime],$ordList[$k][position],$ordList[$k][lasttime]);
				$stmt->execute();
			}
		}
		$stmt->close();
		
		//------------------update dailyvalue-------------------
		$sql="select sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance  from  basedata_" . $sdate . "  where sensorid=$scode";
		echo $sql;
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$totalcal=$row['totalcal'];
		$totalsteps=$row['totalsteps'];
		$totaldistance=$row['totaldistance']/100000; //距离单位在sensor中是厘米
		
		//----------------------------分析睡眠数据，从昨天中午12点到今天中午12点-------------------------
		$sql="SELECT detectedposition,concat('" . $ydatelong ." ',stime) as stime FROM basedata_" . $ydatesort . " where sensorid=$scode and (detectedposition=1 or detectedposition=2) and stime>'12:00:00'";
		$sql .=" union SELECT detectedposition,concat('" . $ldate ." ',stime) as stime FROM basedata_" . $sdate . " where sensorid=$scode and (detectedposition=1 or detectedposition=2)  and stime<'12:00:00'";
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$fromtime=$ldate . " 00:00:00";
		$totime=$ldate . " 00:00:00";
		
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
			$fromtime=$ydatelong. " 22:00:00";
			$totime=$ldate . " 07:00:00";
		}
		
		
		$ftime=date('H:i:s',strtotime($fromtime));	
		$fdate=date("Y-m-d",strtotime($fromtime));	
		$ttime=date('H:i:s',strtotime($totime));	
		$tdate=date("Y-m-d",strtotime($totime));	
		
		$sql="select * from sleepdata where sid=$scode and sdate='$tdate'";
		$result=mysql_query($sql,$conn); 
		if($row=mysql_fetch_array($result)){
			$sql="update sleepdata set fdate='$fdate', ftime='$ftime', tdate='$tdate', ttime='$ttime' where sid=$scode and sdate='$ldate'";
			$result=mysql_query($sql,$conn); 
		}else{
			$sql="INSERT INTO sleepdata(sid, sdate, ftime, ttime, fdate, tdate) VALUES ($scode, '$ldate','$ftime', '$ttime', '$fdate', '$ldate')";
			$result=mysql_query($sql,$conn); 
		}
		//echo $sql;
		$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance, totalsleep=$totalsleep,deepsleep=$deepsleep where sensorid=$scode and date='".$ldate. "'";
		echo $sql;
		$result=mysql_query($sql,$conn); 
		
		
	}

	$mysqli->close;	
}
?>