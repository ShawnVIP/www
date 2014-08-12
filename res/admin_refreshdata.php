<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 


$scode=$obj -> sensorid;
$dates=$obj -> date;


$statusList=array();
$dateList=array();

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


array_push($dateList,  array('ldate'=>$dates ,'sdate'=>str_replace("-","",$dates)));

//-------------dedupe-----------------
for($i=0;$i<count($dateList);$i++){
	
	//----rebuild----------------------
	$reqdate=$dateList[$i][ldate];
	$sql="delete from sensorstation where sensorid=$scode and sdate='" . $dateList[$i][ldate] . "' and adjtype=0";
	$result=mysql_query($sql,$conn); 
	for($k=0;$k<=1440;$k++){
		array_push($statusList, 0);
	}
	$sql="SELECT detectedposition,stime FROM basedata_" . $dateList[$i][sdate] . " where sensorid=$scode and delmark=0 and detectedposition is not null order by id";
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	while ($row=mysql_fetch_array($result)){
		$detectedposition=$row['detectedposition'];
		if($detectedposition==2){$detectedposition=1;} //---1,2 都是睡眠模式------
		$stime=$row['stime'];
		$tmpdate=date("Y-m-d H:i:s",strtotime($reqdate . " " .$stime));
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
	/*	
	$sql="update uploadstation set umode=0 where sensorid=$scode and udate='$reqdate'";
	$result=mysql_query($sql,$conn); 
	*/
	//------------------update dailyvalue-------------------
	$sql="select sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance  from  basedata_" . $dateList[$i][sdate] . "  where sensorid=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$totalcal=$row['totalcal'];
	$totalsteps=$row['totalsteps'];
	$totaldistance=$row['totaldistance'];
	
	$tdate=$dateList[$i][ldate];
	$fdate=date('Y-m-d',strtotime("$tdate -1 day"));


	$sql="select * from basedata_" .str_replace("-","",$fdate) . " where stime>'12:00:00' and detectedposition=1 and sensorid=$scode order by stime limit 0,1";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$ftime=$row['stime'];
	}else{
		$sqla="select * from basedata_" .str_replace("-","",$tdate) . " where stime<'12:00:00' and detectedposition=1 and sensorid=$scode  order by stime limit 0,1";
		$resulta=mysql_query($sqla,$conn); 
		if($rowa=mysql_fetch_array($resulta)){
			$ftime=$rowa['stime'];
			$fdate=$tdate;
		}else{
			$ftime="22:00:00";
		}
	}
	$sql="select * from basedata_" .str_replace("-","",$tdate) . " where stime<'12:00:00' $addstr and (detectedposition=5 or detectedposition=6) and sensorid=$scode  order by stime limit 0,1";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$ttime=$row['stime'];
	}else{
		$ttime="07:00:00";
	}
	//echo $sql;
	
	$sql="select * from sleepdata where sid=$scode and sdate='$tdate'";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$sql="update sleepdata set fdate='$fdate', ftime='$ftime', tdate='$tdate', ttime='$ttime' where sid=$scode and sdate='$tdate'";
		$result=mysql_query($sql,$conn); 
	}else{
		$sql="INSERT INTO sleepdata(sid, sdate, ftime, ttime, fdate, tdate) VALUES ($scode, '$ftime', '$ttime', '$fdate', '$tdate')";
		$result=mysql_query($sql,$conn); 
	}
	
	
	
	if($fdate==$tdate){
		$sql="select count(id) as cid from basedata_" .str_replace("-","",$tdate) . " where  stime>='$ftime'  and stime<='$ttime' and detectedposition=2 and sensorid=$scode";
		$result=mysql_query($sql,$conn);
		$row=mysql_fetch_array($result);
		$totalsleep=$row['cid']*5;
	}else{
		$sql="select count(id) as cid from basedata_" .str_replace("-","",$fdate) . " where stime>='$ftime' and detectedposition=2 and sensorid=$scode";
		$result=mysql_query($sql,$conn);
		$row=mysql_fetch_array($result);
		$totalsleep=$row['cid']*5;
		$sql="select count(id) as cid from basedata_" .str_replace("-","",$tdate) . " where stime<='$ttime'  and detectedposition=2 and sensorid=$scode";
		$result=mysql_query($sql,$conn);
		$row=mysql_fetch_array($result);
		$totalsleep+=$row['cid']*5;
		
	}
	//echo $sql;
	//------------------count total sleep---------------------
	$sql="select * from dailyvalue where sensorid=$scode and date='".$dateList[$i][ldate]. "'";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance, totalsleep=$totalsleep where sensorid=$scode and date='".$dateList[$i][ldate]. "'";
		$result=mysql_query($sql,$conn); 
		
	}else{
		$sql="select * from dailyvalue where sensorid=$scode and date<'".$dateList[$i][ldate]. "'";
		$result=mysql_query($sql,$conn);
		$row=mysql_fetch_array($result);
		$height=$row['height'];
		$weight=$row['weight'];
		$step=$row['step'];
		$stepgoal=$row['stepgoal'];
		$caloriesgoal=$row['caloriesgoal'];
		$distancegoal=$row['distancegoal'];
		$runningwidth=$row['runningwidth'];
		$stepwidth=$row['stepwidth'];
		$sleepgoal=$row['sleepgoal'];
		$bmi=$row['bmi'];
		$bmr=$row['bmr'];
		$age=$row['age'];
		$updated=$row['updated'];
		
		$sql="INSERT INTO dailyvalue(height, weight, step, date, stepgoal, caloriesgoal, stepwidth, distancegoal, runningwidth, bmi, sensorid, updated, age, bmr, sleepgoal, totalcal, totalsteps, totaldistance, totalsleep) VALUES ($height, $weight, $step, '".$dateList[$i][ldate]. "', $stepgoal, $caloriesgoal, $stepwidth, $distancegoal, $runningwidth, $bmi, $scode, $updated, $age, $bmr, $sleepgoal, $totalcal, $totalsteps, $totaldistance, $totalsleep)";
		$result=mysql_query($sql,$conn); 		
		
	}
	//echo $sql;
	

}

$mysqli->close;	
	
echo json_encode(array('status'=>200));
?>