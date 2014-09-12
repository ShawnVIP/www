<?php 
include "calcdeepsleep.php";
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
		
		
		//----------
		
		if($statusList[$j-1] != 7){
			array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	
		}
		//-----------处理单独1-------------
		$independ=0;
		for($i=0;$i<count($ordList);$i++){
			$independ=0;
			if($ordList[$i][position]==1 && $ordList[$i][lasttime]==5){
				
				$independ=1;
				
				switch ($i){
				case 0:
				 if($ordList[1][position] ==1){$independ=0;}
				
				  break;  
				case count($ordList)-1:
				  if($ordList[$i-1][position] ==1){$independ=0;}
				   
				  break;
				default:
				  if($ordList[$i-1][position] ==1 || $ordList[$i+1][position] ==1){$independ=0;}
				 
				}
				
				if($independ==1){$ordList[$i][position]=7;}
			}
		}
		//---------处理结束-----------------
		
		
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
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$totalcal=$row['totalcal'];
		$totalsteps=$row['totalsteps'];
		$totaldistance=$row['totaldistance']/100000; //距离单位在sensor中是厘米
		$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance where sensorid=$scode and date='".$ldate. "'";
		$result=mysql_query($sql,$conn); 
	
		calcsleeptime($ldate,$fdate,$ftime,$tdate,$ttime,$scode);
		
	}

	$mysqli->close;	
}
?>