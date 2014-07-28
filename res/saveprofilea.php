<?php
include "dbconnect.php";

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
		$titleinfo='less calories';
		$cata=1;
		$restinfo='less calories ' . round($rest,1);
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totalsteps<$stepgoal){
		$rest=$stepgoal-$totalsteps;
		$restinfo='less steps ' . round($rest,0);
		$titleinfo='less steps';
		$cata=2;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totaldistance<$distancegoal){
		$rest=($distancegoal-$totaldistance);
		$restinfo='less distance ' .round($rest,3);
		$titleinfo='less distance';
		$cata=3;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	$stmt->close();
}
function DateDiff ( $interval , $date1 , $date2 ) {
	$timedifference = $date2 - $date1 ;
	switch ( $interval ) {
	case "y" : $retval = bcdiv ($timedifference ,31536000);break;
	case "w" : $retval = bcdiv ( $timedifference ,604800); break ;
	case "d" : $retval = bcdiv ( $timedifference ,86400); break ;
	case "h" : $retval = bcdiv ( $timedifference ,3600); break ;
	case "n" : $retval = bcdiv ( $timedifference ,60); break ;
	case "s" : $retval = $timedifference ; break ;
}
return floor($retval) ;
} 

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","password":"1234","newpass":"12"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","password":"1234","newpass":"123"}';
//$json_string='{"unit":"Metric","username":"Xiao Miao","weight":"55","height":"160","email":"xiaomao@gmail.com","dob":"1924-2-5","userid":"46","gender":"F"}';
//$json_string='{"ucode":"f2026d8c-d99c-4535-2a7b-7ad18c28c4b5","scode":"1","username":"Shawn","gender":"M","dob":"2009-2-2","height":"180","weight":"80","stepwidth":"73","timezone":"+08:00","unit":"Metric"}';
//$json_string='{"ucode":"c74e57a4-124e-582a-0dc8-1744d974bbab","scode":"6","caloriesgoal":"6000","stepgoal":"10953","distancegoal":"8"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","caloriesgoal":"6200","stepgoal":"6846","distancegoal":"4.86","moment":"20:22:10"}';

$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"U4r8ECyTFlUd0hzO","nickname":"Peter","gender":"M","dob":"1931-6-21","height":"178","weight":"80","stepwidth":"73.87","timezone":"+08:00","cdate":"2014-4-18 14:56:16","unit":"Metric","source":"w"}';
$obj=json_decode($json_string); 


$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$email=$obj -> email;
$nickname=$obj -> nickname;
$gender=$obj -> gender;
$height=$obj -> height;
$weight=$obj -> weight;
$dob=$obj -> dob;
$timezone=$obj -> timezone;
$stepwidth=$obj -> stepwidth;
$unit=$obj -> unit;
$password=$obj -> password;
$newpass=$obj-> newpass;
$stepgoal=$obj-> stepgoal;
$caloriesgoal=$obj-> caloriesgoal;
$distancegoal=$obj-> distancegoal;
$defaultgoal=$obj-> defaultgoal;
$changeID=$obj-> changeID;

$sumList=array();
$sumList[0]="Ste";
$sumList[1]="Dis";
$sumList[2]="Cal";

$datestr=explode(" ", $obj -> cdate);
$cdate=$datestr[0];
$moment=date("H:i:s",strtotime($cdate));

//checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

if ($caloriesgoal != ""){

	$sql="update dailyvalue set caloriesgoal=$caloriesgoal, stepgoal=$stepgoal, distancegoal=$distancegoal where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $scode,$now);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();
	checkWarning($scode,$now,1,$moment);
	
	$sql="select detailid from sensorinfo where id=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("s", $scode);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($detailid); 
	$stmt->fetch();
	$valueList=array(0, $caloriesgoal,$stepgoal,$distancegoal);
	buildLearning($scode,$valueList[$detailid],$detailid);
	
	$sql="update sensorinfo set updated=1, defaultgoal=? where id=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("ss", $defaultgoal,$scode);
	$stmt->execute();
	
}else{
	$sql="select stepgoal,caloriesgoal,distancegoal from dailyvalue where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("ss", $ucode,$now);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stepgoal,$caloriesgoal,$distancegoal); 
	$stmt->fetch();
	$stmt->close();
}

if($password != ""){ //changepassword
	$sql = "select salt from  accountinfo where userid=?"; //预处理sql语句
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
	$stmt->bind_param("s", $ucode);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($salt);  
	if(! $stmt->fetch()){
		echo json_encode(array('status'=>'101'));
		exit;
	}
	$stmt->close();
	$newpass=convertpass($salt,$newpass);
	$password=convertpass($salt,$password);
	//echo "find pass";
	$sql="select * from accountinfo where userid=? and password=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $ucode,$password);
	$stmt->execute();
	$stmt->store_result();
	if(! $stmt->fetch()){
		echo json_encode(array('status'=>'401'));
		exit;
	}
	$stmt->close();
	$sql="update accountinfo set password=? where userid=?";
	//echo "update accountinfo set password='$newpass' where userid='$ucode'";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $newpass,$ucode);
	$stmt->execute();
	$stmt->close();
	
}
echo "h----".$height;
if($height !=""){ //---保存profile信息---------------------------
//$strs="email='$email',";

	$now=date("Y-m-d",strtotime($cdate));
	$age=DateDiff("y",strtotime($dob),strtotime($now));

echo "now:". $now ."--dob:" . $dob . "-------age:".$age;
	$sql="update sensorinfo set nickname=?,gender=?,dob=?,timezone=?,unit=?,updated=1,age=? where id=?";
	
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sssssss", $nickname,$gender,$dob,$timezone,$unit,$age,$scode);
	$stmt->execute();
	$stmt->close();
	
	if($gender=="F"){
		//if($height==0){$height=162;}
		//$stepwidth=$height*0.415;
		$runningwidth=$height*0.415;
		$bmr=665.1+9.563*$weight+1.85*$height-4.676*$age;
	}else{
		//if($height==0){$height=176;}
		//$stepwidth=$height*0.413;
		$runningwidth=$height*0.413;
		$bmr=66.5+13.75*$weight+5.003*$height-6.755*$age;
	}
	$nheight=$height/100;
	$bmi=$weight/($nheight*$nheight);
	
	$sql="update dailyvalue set height=?,weight=?,stepwidth=?,runningwidth=?,bmi=?,bmr=?,age=? where sensorid=? and date=?";
	
	echo "update dailyvalue set height=$height,weight=$weight,stepwidth=$stepwidth,runningwidth=$runningwidth,bmi=$bmi,bmr=$bmr,age=$age where sensorid=$scode and date='$now'";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sssssssss", $height,$weight,$stepwidth,$runningwidth,$bmi,$bmr,$age,$scode,$now);
	$stmt->execute();
	$stmt->close();
	checkWarning($scode,$now,1,$moment);
	
}
$session=$ecode;
/*
$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
*/
$mysqli->close();  
echo json_encode(array('status'=>'200','ecode'=>$session));

?>