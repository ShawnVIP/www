<?php
include "dbconnect.php";


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

//$json_string='{"ucode":"tmes8bOAw7jTpmcl9CGCO0h0CFv4EkShiYKc","scode":"550","ecode":"T5jARIO3lLR6xf6e","nickname":"55","gender":"M","dob":"1996-06-26","height":"170.0","weight":"70","stepwidth":"70.21","timezone":"+08:00","moment":"10:35:45","unit":"Metric","source":"a"}';


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
$language=$obj-> language;

if ($language == ""){
	$language="EN";
}

if ($unit == ""){
	$unit="Metric";
}

if ($defaultgoal == ""){
	$defaultgoal="step";
}		
$sumList=array();
$sumList[0]="Ste";
$sumList[1]="Dis";
$sumList[2]="Cal";

$datestr=explode(" ", $obj -> cdate);
$cdate=$datestr[0];
$moment=date("H:i:s",strtotime($cdate));
checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

if ($caloriesgoal != ""){

	$sql="update dailyvalue set caloriesgoal=$caloriesgoal, stepgoal=$stepgoal, distancegoal=$distancegoal where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $scode,$now);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();

	
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
if($height !=""){ //---保存profile信息---------------------------
//$strs="email='$email',";
	$now=date("Y-m-d",strtotime($cdate));
	$age=DateDiff("y",strtotime($dob),strtotime($now));
        $fallalert=0;
        if($age>=65){$fallalert=1;}
	/*
	$sql="update sensorinfo set nickname=?,gender=?,dob=?,timezone=?,unit=?,updated=1,age=$age,language='$language', fallalert=$fallalert where id=?";
	
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssss", $nickname,$gender,$dob,$timezone,$unit,$scode);
	$stmt->execute();
	$stmt->close();
	
	*/
	$sql="select headimage from sensorinfo where id=$scode";
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$headimage=$row['headimage'];	
	}
	if(substr($headimage,0,6)=="avatar"){
		$headimage="avatar_" . strtolower($gender) . ".gif";
	}
	
	
	
	$sql="update sensorinfo set headimage='$headimage', nickname='$nickname',gender='$gender',dob='$dob',timezone='$timezone',unit='$unit',updated=1,age=$age,language='$language', fallalert=$fallalert where id=$scode";
	$result=mysql_query($sql,$conn); 
	
	
	
	if($gender=="F"){
		if($height==0){$height=162;}
		$stepwidth=$height*0.415;
		$runningwidth=$height*0.415;
		$bmr=665.1+9.563*$weight+1.85*$height-4.676*$age;
	}else{
		if($height==0){$height=176;}
		$stepwidth=$height*0.413;
		$runningwidth=$height*0.413;
		$bmr=66.5+13.75*$weight+5.003*$height-6.755*$age;
	}
	$nheight=$height/100;
	
	$bmi=$weight/($nheight*$nheight);
	
	$sql="update dailyvalue set height=?,weight=?,stepwidth=?,runningwidth=?,bmi=?,bmr=?,age=? where sensorid=? and date=?";
	
	//echo "update dailyvalue set height=$height,weight=$weight,stepwidth=$stepwidth,runningwidth=$runningwidth,bmi=?,bmr=?,age=? where sensorid=? and date=$now";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sssssssss", $height,$weight,$stepwidth,$runningwidth,$bmi,$bmr,$age,$scode,$now);
	$stmt->execute();
	$stmt->close();
	
	
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