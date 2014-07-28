<?php

//$backend_server="54.245.106.189:8080";
//$backend_server="127.0.0.1:8000";

$mysql_server_name="localhost";

/*
$mysql_username="ledo"; 
$mysql_password="Ledo!11@22"; 
$mysql_database="senseu";
*/
$mysql_username="shier"; 
$mysql_password="a!s@d#f$"; 
$mysql_database="haisw_ledo";
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
mysql_query("SET NAMES 'UTF8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");


//date_default_timezone_set('Asia/Shanghai'); 
$now=date("Y-m-d");

function saveSession($ucode,$scode,$ecode,$source){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
	$now=date("Y-m-d H:i:s");
	
	$sql="select ecode from accountsession where ucode=? and scode=? and source=?";
	
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("sss", $ucode,$scode,$source);
	$stmt->execute();
	$stmt->store_result();
	if(! $stmt->fetch()){
		$sql="insert into accountsession (ucode,scode,source,ecode,ldate) values (?,?,?,?,?)";
		
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
		$stmt->bind_param("sssss", $ucode,$scode,$source,$ecode,$now);
		$stmt->execute();
	}else{
		$sql = "update accountsession set ecode=?, ldate=? where ucode=? and scode=? and source=?"; 
		//echo "update accountsession set ecode=$ecode, ldate=$now where ucode=$ucode and scode=$scode and source=$source"; 
		
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
		$stmt->bind_param("sssss", $ecode,$now,$ucode,$scode,$source);
		$stmt->execute();
		$stmt->close();
	}
}
function buildLearning($scode,$activity_goal,$activity_goal_type){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $now;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
	//--------check value, if empty, insert default-------------
	$sql ="SELECT sleep_quality_type, sleep_quality, activity_sleep_tracking_interval, activity_level_threshold, raw_data_enable, rf_interval, rf_power, inactivity_duration, fall_threshold, fall_impact_threshold, fall_angle FROM learningdata where scode=? order by builddate desc limit 0,1";

	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("s", $scode);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($sleep_quality_type, $sleep_quality, $activity_sleep_tracking_interval, $activity_level_threshold, $raw_data_enable, $rf_interval, $rf_power, $inactivity_duration, $fall_threshold, $fall_impact_threshold, $fall_angle); 
	if (! $stmt->fetch()) {
		$sleep_quality_type="type";
		$sleep_quality=5333;
		$activity_sleep_tracking_interval=5;
		$activity_level_threshold=100;
		$raw_data_enable=1;
		$rf_interval=5;
		$rf_power=50;
		$inactivity_duration=60;
		$fall_threshold=60;
		$fall_impact_threshold=30;
		$fall_angle=30;
		
	}
	$sql='INSERT INTO learningdata(scode, activity_goal,sleep_quality_type, sleep_quality, activity_sleep_tracking_interval, activity_level_threshold, raw_data_enable, rf_interval, rf_power, inactivity_duration, fall_threshold, fall_impact_threshold, fall_angle, activity_goal_type, builddate) VALUES (?,' .$activity_goal. ',"' .$sleep_quality_type. '",' .$sleep_quality. ',' .$activity_sleep_tracking_interval. ',' .$activity_level_threshold. ',' .$raw_data_enable. ',' .$rf_interval. ',' .$rf_power. ',' .$inactivity_duration. ',' .$fall_threshold. ',' .$fall_impact_threshold. ',' .$fall_angle. ',' .$activity_goal_type. ',"' . $now . '")';
	
	
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("s", $scode);
	$stmt->execute();
	$vname=array();
	$value=array();
	array_push($vname,"activity_goal");
	array_push($value,$activity_goal);
	array_push($vname,"sleep_quality_type");
	array_push($value,$sleep_quality_type);
	array_push($vname,"sleep_quality");
	array_push($value,$sleep_quality);
	array_push($vname,"activity_sleep_tracking_interval");
	array_push($value,$activity_sleep_tracking_interval);
	array_push($vname,"activity_level_threshold");
	array_push($value,$activity_level_threshold);
	array_push($vname,"raw_data_enable");
	array_push($value,$raw_data_enable);
	array_push($vname,"rf_interval");
	array_push($value,$rf_interval);
	array_push($vname,"rf_power");
	array_push($value,$rf_power);
	array_push($vname,"inactivity_duration");
	array_push($value,$inactivity_duration);
	array_push($vname,"fall_threshold");
	array_push($value,$fall_threshold);
	array_push($vname,"fall_impact_threshold");
	array_push($value,$fall_impact_threshold);
	array_push($vname,"fall_angle");
	array_push($value,$fall_angle);
	array_push($vname,"activity_goal_type");
	array_push($value,$activity_goal_type);
	
	$stmt->close();
	$mysqli->close();
	return array_combine($vname,$value);
	
}
function checkuser($ucode,$scode,$ecode,$source){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
	
	$sql="SELECT * from sensorlist where  userid=? and sensorid=?";
	
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $ucode,$scode);
	$stmt->execute();
	$stmt->store_result();
	if(! $stmt->fetch()){
		echo json_encode(array('status'=>'102'));
		exit;
	}
	$stmt->close();
    /*
	$sql="select ecode from accountsession where scode=? and ucode=? and source=? and ecode=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ssss", $scode,$ucode,$source,$ecode);
	$stmt->execute();
	$stmt->store_result();
	//$stmt->bind_result($session);
	if(! $stmt->fetch()){
		echo json_encode(array('status'=>'103'));
		exit;
	}
    */
	$sql="SELECT b.vipmode from accountinfo as a, sensorinfo as b where a.userid=b.userid and b.id=? and a.userid=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$ucode);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vipmode);
	if(! $stmt->fetch()){
		echo json_encode(array('status'=>'103'));
		exit;
	}
	$stmt->close();
	$mysqli->close();
	
	return $vipmode;
}

function checkDaily($scode,$date){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$addnewData=false;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
	$sql="select caloriesgoal from dailyvalue where sensorid=? and date=?";
	//echo "select * from dailyvalue where sensorid=$scode and date=$now";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //?sql???mysqli????
	$stmt->bind_param("ss", $scode,$date);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($caloriesgoal);
	if(! $stmt->fetch()){
		$addnewData=true;
	}else{
		/*if($caloriesgoal==0){
			$addnewData=true;
			$sql="delete from dailyvalue where sensorid=? and date=?";
			$stmt = $mysqli->stmt_init();
			$stmt = $mysqli->prepare($sql); //?sql???mysqli????
			$stmt->bind_param("ss", $scode,$date);
			$stmt->execute();
		}*/
	}
	
	if($addnewData){
		$sql="select height,weight,step,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,bmr,age,sleepgoal,updated from dailyvalue where sensorid=? and date<? and caloriesgoal>0 and stepgoal>0 and sleepgoal>0 order by id desc limit 0,1";
		//echo "select height,weight,step,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,bmr,age,sleepgoal,updated from dailyvalue where sensorid=$scode and date<$date and caloriesgoal>0 and stepgoal>0 and sleepgoal>0 order by id desc limit 0,1";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql); //?sql???mysqli????
		$stmt->bind_param("ss", $scode,$date);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($height,$weight,$step,$stepgoal,$caloriesgoal,$stepwidth,$distancegoal,$runningwidth,$bmi,$bmr,$age,$sleepgoal,$updated); 
		$stmt->fetch();
		$stmt->close();
				
		$sql="insert into dailyvalue ( height,weight,step,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,bmr,age,sleepgoal,updated,sensorid,date) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		//echo $sql . "\n";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql); //?sql???mysqli????
		
		$stmt->bind_param("sssssssssssssss", $height,$weight,$step,$stepgoal,$caloriesgoal,$stepwidth,$distancegoal,$runningwidth,$bmi,$bmr,$age,$sleepgoal,$updated, $scode,$date);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();
		
		$yesterday=date('Y-m-d',strtotime("$date -1 day"));
		$sql="insert into sleepdata (sid,sdate,ftime,ttime,fdate,tdate) value ( $scode,'$date','22:00:00','07:00:00','$yesterday','$date')";
		//echo $sql . "\n";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$stmt->close();
	}
	$mysqli->close();
}
function convertpass($salt,$pass){
	$output= hash('sha256', $salt. $pass);
	return $output;
}
function getPercentage($total,$goal){
	if($goal==0 || $total>$goal){
		return 100;
	}else{
		return floor(100*$total/$goal);
	}
	
}
function randomkeys($length)
{
	$vlist=array();
	for($i=0;$i<10;$i++){
		array_push($vlist,$i);
	}
	for($i=65;$i<=90;$i++){
		array_push($vlist,chr($i));
	}
	for($i=97;$i<=122;$i++){
		array_push($vlist,chr($i));
	}
	$output='';
	for ($a = 0; $a < $length; $a++) {
		$output .= $vlist[mt_rand(0, count($vlist)-1)];    
	}
	return $output;
}

function get_real_ip(){
	$ip=false;
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip) { array_unshift($ips, $ip); $ip = FALSE; }
		for ($i = 0; $i < count($ips); $i++) {
			if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
				$ip = $ips[$i];
				break;
			}
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

function formatDateStr($cdate){
	$pos=strpos($cdate," ");
	if($pos>0){
		$cdate=substr($cdate,0,$pos);
	}
	return $cdate;
}


//取得时间的年
//echo "年：".getyear(date('Y-m-d H:i:s'));
function getyear($date)
{
$strtime = $date;
$strtimes = explode(" ",$strtime);
$timearray = explode("-",$strtimes[0]);
$year = $timearray[0];
$month = $timearray[1];
$day = $timearray[2];
return $year;
}

//取得时间的月
//echo "月：".getmonth(date('Y-m-d H:i:s'));
function getmonth($date)
{
$strtime = $date;
$strtimes = explode(" ",$strtime);
$timearray = explode("-",$strtimes[0]);
$year = $timearray[0];
$month = $timearray[1];
$day = $timearray[2];
return $month;
}

//取得时间的日
//echo "日：".getday(date('Y-m-d H:i:s'));
function getday($date)
{
$strtime = $date;
$strtimes = explode(" ",$strtime);
$timearray = explode("-",$strtimes[0]);
$year = $timearray[0];
$month = $timearray[1];
$day = $timearray[2];
return $day;
}

function formateFullDate($dates){
	$tmpdate=explode("-", $dates); 
	
	$outstr=$tmpdate[0]."-";
	if($tempdate[1]<10){
		$outstr.="0";
	}
	$outstr.=$tmpdate[1]."-";
	if($tmpdate[2]<10){
		$outstr.="0";
	}
	$outstr.=$tmpdate[2];
	return $outstr;
}
function convert2utf8($string){
	return iconv("gbk","utf-8",$string);
}

function convert2gbk($string){
	return iconv("utf-8","gbk",$string);
}
?>