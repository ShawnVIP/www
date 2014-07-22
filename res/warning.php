<?php 

function checkWarning($scode,$ndate,$today,$moment){ //----------calc warning data, after upload, goal setting, --------------
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
	
	$mdate=str_replace("-","",$ndate);
	//-------get daily target--------------
	
	$ym=substr($mdate,0,6);
	$day=substr($mdate,6,8);
	$sql="select * from sensordate where yearmonth=? and day=? and sensorid=?";
	//echo "select * from sensordate where yearmonth=$ym and day=$day and sensorid=$scode";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("sss",$ym,$day ,$scode);
	$stmt->execute();
	$stmt->store_result();
	if(! $stmt->fetch()){
		return;
	}
	
	
	$sql="select stepgoal,caloriesgoal,distancegoal,bmr from dailyvalue where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$ndate);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stepgoal,$caloriesgoal,$distancegoal,$bmr); 
	if(! $stmt->fetch()){
		return;
	}
	$stmt->close();
	$dataname=" basedata_" . $mdate ;
	$sql="select count(calories) as itemnumber, sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance from $dataname where sensorid=? and delmark=0 and stime<?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$moment);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($itemnumber,$totalcal,$totalsteps,$totaldistance);
	if(! $stmt->fetch()){
		return;
	}
	$stmt->close();
	
	//-------sensor just gather extra cal from BMR, so add in total------------
	$totalcal=$totalcal + $bmr*$itemnumber/288;
	$totaldistance=$totaldistance/1000;
	
	$sql="update dailyvalue set totalcal=?, totalsteps=?, totaldistance=? where sensorid=? and date=?";
	//echo "update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance where sensorid=$scode and date=$ndate";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("sssss", $totalcal,$totalsteps,$totaldistance,$scode,$ndate);
	$stmt->execute();
	$stmt->close();
	
	$sql="update warninginfo set delmark=1 where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$ndate);
	$stmt->execute();
	$stmt->close();
	
	$sql="insert into warninginfo ( sensorid,date,catalog,title,detail) value (?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 	
	
	//echo "cal: $totalcal $caloriesgoal | step: $totalsteps $stepgoal | distance: $totaldistance $distancegoal";
	if($totalcal<$caloriesgoal){
		$rest=$caloriesgoal-$totalcal;
		$titleinfo='Less Calories';
		$cata=1;
		$restinfo=round($rest,1) . " Calroeis to Go " . $caloriesgoal;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totalsteps<$stepgoal){
		$rest=$stepgoal-$totalsteps;
		$titleinfo='Less Steps';
		$restinfo=round($rest,0) . " Steps to Go " . $stepgoal;
		$cata=2;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totaldistance<$distancegoal){
		$rest=($distancegoal-$totaldistance);
		$titleinfo='Less Distance';
		$restinfo=round($rest,1) . " Distance to Go " . $distancegoal;
		$cata=3;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	$stmt->close();
}

?>