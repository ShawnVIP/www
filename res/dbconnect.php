<?php

//$backend_server="54.245.106.189:8080";
//$backend_server="127.0.0.1:8000";
define('RootPath', ".."); 

$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; 
$HOMEURL= dirname($url);
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
/*
**
* 写文件
* @param    string  $file   文件路径
* @param    string  $str    写入内容
* @param    char    $mode   写入模式
*/
 
function mess(){   
    echo json_encode(array('status'=>'400','message'=>'over time 30s'));
	exit();
}
  
//register_shutdown_function('mess');   
//error_reporting(0);  

function writeFile($file,$str,$mode='w')
{
    $oldmask = @umask(0);
    $fp = @fopen($file,$mode);
    @flock($fp, 3);
    if(!$fp)
    {
        Return false;
    }
    else
    {
        @fwrite($fp,$str);
        @fclose($fp);
        @umask($oldmask);
        Return true;
    }
}

 

//扩展应用，比如记录每次请求的url内容

function writeGetUrlInfo($scode)
{

    global $conn;
	$ndate=date('Y-m-d');
	$sql="select * from loginfo where ldate='$ndate' and scode=$scode";
	$result=mysql_query($sql,$conn); 
	$filename='log_'.date('Y-m-d').'_' . $scode . '.log';
	if(!$row=mysql_fetch_array($result)){
		$sql="select * from loginfo where ldate='$ndate' and scode=$scode";
		$sql="INSERT INTO loginfo (ldate,scode,lname) value ('$ndate',$scode,'$filename')";
		$result=mysql_query($sql,$conn); 
	}
	
	$requestInformation =date("Y-m-d H:i:s").",". $_SERVER['REMOTE_ADDR'].','.$_SERVER['HTTP_USER_AGENT'].', http://'.$_SERVER['HTTP_HOST'].htmlentities($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']."\n" . $GLOBALS['HTTP_RAW_POST_DATA']."\n" ; 
	$fileName = RootPath.'/log/'. $filename; //网站根目录RootPath是在配置文件里define('RootPath', substr(dirname(__FILE__))); 
	//echo $fileName;
	writeFile($fileName, $requestInformation, 'a'); //表示追加
	
}

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
	writeGetUrlInfo($scode);
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
function loadFunction($url,$data,$showReturn){
	global $HOMEURL;
	$loadurl = $HOMEURL ."/" . $url;
	//echo $loadurl;
	//echo  json_encode($data);

	$post_data = $data;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变量
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	if($showReturn){
		echo($output );
	}
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

function DiffDate($date1, $date2) { 
  if (strtotime($date1) > strtotime($date2)) { 
    $ymd = $date2; 
    $date2 = $date1; 
    $date1 = $ymd; 
  } 
  list($y1, $m1, $d1) = explode('-', $date1); 
  list($y2, $m2, $d2) = explode('-', $date2); 
  $y = $m = $d = $_m = 0; 
  $math = ($y2 - $y1) * 12 + $m2 - $m1; 
  $y = round($math / 12); 
  $m = intval($math % 12); 
  $d = (mktime(0, 0, 0, $m2, $d2, $y2) - mktime(0, 0, 0, $m2, $d1, $y2)) / 86400; 
  if ($d < 0) { 
    $m -= 1; 
    $d += date('j', mktime(0, 0, 0, $m2, 0, $y2)); 
  } 
  $m < 0 && $y -= 1; 
  return array($y, $m, $d); 
} 

function checkDailyValue($scode,$date,$addnew,$returnmode){
	global $conn;
	global $now;
	$valueList=array();
	$sql="select dob from sensorinfo where id=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$dob=$row['dob'];
	if($dob=="0000-00-00"){
		$age=0; 
	}else{
		$datediff=DiffDate($now,$dob);
		$age=$datediff[0];
		
	}
	//echo "from: $dob to $now . year:" . $datediff[0];
	$sql="select * from dailyvalue where sensorid='$scode' and date='$date'";
	$newmode=0;
	$result=mysql_query($sql,$conn); 
	if(!$row=mysql_fetch_array($result)){
		$sql="SELECT * FROM dailyvalue where sensorid=$scode and date<'$date' order by date desc limit 0,1 ";	
		$result=mysql_query($sql,$conn); 
		if($row=mysql_fetch_array($result)){
			$newmode=1;
		}else{
			//初次注册	
			$default_height=176;
			$default_stepwidth=$default_height*0.415;
			$default_runningwidth=$default_stepwidth;
			$default_weight=87;
			$default_stepgoal=10000;
			$default_distancegoal=$default_stepgoal*$default_stepwidth/100000;
			$default_age=30;
			$default_bmr=66.5+13.75*$default_weight+5.003*$default_height-6.755*$default_age;
			$default_bmi=$default_weight*10000/($default_height*$default_height);
			$default_sleepgoal=480;
			$default_caloriesgial=4000;
			
			$sql="insert into dailyvalue (height,weight,step,date,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,updated,age,bmr,sleepgoal,sensorid) values ($default_height,$default_weight,0,'$date',$default_stepgoal,$default_caloriesgial,$default_stepwidth,$default_distancegoal,$default_runningwidth,$default_bmi,1,$default_age,$default_bmr,$default_sleepgoal, '$scode')";
			$result=mysql_query($sql,$conn); 
			$sql="select * from dailyvalue where sensorid='$scode' and date='$date'";
			$result=mysql_query($sql,$conn); 
		}
	}
	$height=$row['height'];
	$weight=$row['weight'];
	$step=$row['step'];
	$stepwidth=$row['stepwidth'];
	$runningwidth=$row['runningwidth'];
	$bmr=$row['bmr'];
	$bmi=$row['bmi'];
	$stepgoal=$row['stepgoal'];
	$caloriesgoal=$row['caloriesgoal'];
	$distancegoal=$row['distancegoal'];
	$sleepgoal=$row['sleepgoal'];
	//echo " newmode:$newmode addnew:$addnew";
	if($newmode==1){	
		if($addnew==1){
			$sql="INSERT INTO dailyvalue (date,sensorid,age,height,weight,step,stepwidth,runningwidth,bmr,bmi,stepgoal,caloriesgoal,distancegoal,sleepgoal) value ('$date',$scode,$age,$height,$weight,$step,$stepwidth,$runningwidth,$bmr,$bmi,$stepgoal,$caloriesgoal,$distancegoal,$sleepgoal)";
			$result=mysql_query($sql,$conn);
			//echo $sql;
		}
		$totalsteps=0;
		$totalcal=0;
		$totaldistance=0;
		$totalsleep=0;
		$updated=0;
		$deepsleep=0;
	}else{
		$totalsteps=$row['totalsteps'];
		$totalcal=$row['totalcal'];
		$totaldistance=$row['totaldistance'];
		$totalsleep=$row['totalsleep'];
		$deepsleep=$row['deepsleep'];
		$updated=$row['updated'];
	}
	
	if($returnmode){
		
		$vname=array();
		$value=array();
		
		array_push($vname,"age");
		array_push($value,(string)$age);
		
		array_push($vname,"updated");
		array_push($value,(string)$updated);
		
		array_push($vname,"height");
		array_push($value,(string)$height);
		
		array_push($vname,"weight");
		array_push($value,(string)$weight);
		array_push($vname,"step");
		array_push($value,(string)$step);
		array_push($vname,"stepwidth");
		array_push($value,(string)$stepwidth);
		array_push($vname,"runningwidth");
		array_push($value,(string)$runningwidth);
		
		array_push($vname,"bmr");
		array_push($value,(string)$bmr);
		array_push($vname,"bmi");
		array_push($value,(string)$bmi);
		
		array_push($vname,"stepgoal");
		array_push($value,(string)$stepgoal);
		
		array_push($vname,"totalsteps");
		array_push($value,(string)$totalsteps);
		
		array_push($vname,"caloriesgoal");
		array_push($value,(string)$caloriesgoal);
		
		array_push($vname,"totalcal");
		array_push($value,(string)$totalcal);
		
		array_push($vname,"distancegoal");
		array_push($value,(string)$distancegoal);
		
		array_push($vname,"totaldistance");
		array_push($value,(float)$totaldistance);
		
		array_push($vname,"sleepgoal");
		array_push($value,(string)$sleepgoal);
		
		array_push($vname,"totalsleep");
		array_push($value,(string)$totalsleep);
		
		array_push($vname,"deepsleep");
		array_push($value,(string)$deepsleep);	
		array_push($valueList,array_combine($vname,$value));
		return $valueList;
	}
	
}


?>