<?php 
include "dbconnect.php";

/*
create view totalinfo as select b.fallalert,b.positionalert, b.defaultgoal, b.transmitpower,b.fallthreshold,b.fallimpact,b.fallangleh,b.fallanglel,a.orderlist,a.userid,a.station,a.connected,b.power,b.lastupdate as lastupdate,b.nickname,b.headimage,b.dob,b.gender,b.unit, b.vipmode,b.language, c.*,b.detailid  from sensorlist as a, sensorinfo as b,dailyvalue as c where  a.sensorid=b.id and c.sensorid=b.id
*/


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"CvYdlBkGHxgUfH3d","source":"w"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$cdate=formatDateStr($obj -> cdate);

checkuser($ucode,$scode,$ecode,$source);



//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例
/*
$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
*/
//-----add in daily data----------------


loadFunction('admin_getdailyvalue.php',array ("mode"=>1,"scode" => $scode,"date" => $cdate),false);

$sensor=array();

$email="";
$sql="select email from accountinfo where  userid='$ucode'";
$result=mysql_query($sql,$conn);
if ($row=mysql_fetch_array($result)) {
	$email=$row['email'];
}

$sql ="SELECT * FROM totalinfo  WHERE  sensorid='$scode' and date='$cdate' order by orderlist";
//echo $sql;
$result=mysql_query($sql,$conn);
while ($row=mysql_fetch_array($result)) {
	
	$vname=array();
	$value=array();
	array_push($vname,"email");
	array_push($value,$email);
	array_push($vname,"station");
	array_push($value,$row['station']);
	array_push($vname,"connected");
	array_push($value,$row['connected']);
	array_push($vname,"power");
	array_push($value,$row['power']);
	array_push($vname,"lastupdate");
	array_push($value,$row['lastupdate']);
	array_push($vname,"sensorid");
	array_push($value,$row['sensorid']);
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
	array_push($vname,"updated");
	array_push($value,$row['updated']);
	array_push($vname,"age");
	array_push($value,$row['age']);
	array_push($vname,"language");
	array_push($value,$row['language']);
	
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
	array_push($value,round($row['distancegoal'],3));
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
	
	
	$sqla ="SELECT count(a.message) as message from familyreqlist as a,sensorinfo as b where a.fromscode=b.id and a.toscode=? and a.deal=0";
	//echo  "SELECT count(a.message) as message from friendreqlist as a,sensorinfo as b where a.fromscode=b.id and a.toscode=$scode and a.accept=0";
	$stmta = $mysqli->stmt_init();
	$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
	$stmta->bind_param("s", $scode);
	$stmta->execute();
	$stmta->store_result();
	$stmta->bind_result($message);
	$stmta->fetch();
	array_push($vname,"message");
	array_push($value,$message);
	array_push($sensor,array_combine($vname,$value));
	
}
echo json_encode(array('status'=>200,'sensorlist'=>$sensor,'ecode'=>$ecode));


?>