<?php 
include "dbconnect.php";
 
/*
create view totalinfo as select a.orderlist,a.userid,a.station,a.connected,a.power,a.lastuppower as lastupdate,b.nickname,b.headimage,b.dob,b.gender,b.unit, b.vipmode, c.*,b.detailid  from sensorlist as a, sensorinfo as b,dailyvalue as c where  a.sensorid=b.id and c.sensorid=b.id
*/

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"ucode":"4G90r6WxC1KjcV0Ik8hwMktANJoEwRk6i3qy","scode":"496","ecode":"iIqdwuDBZXCy4EBE","source":"w","cdate":"2014-5-6 下午10:04:59"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$cdate=formatDateStr($obj -> cdate);

$now=date("Y-m-d",strtotime($cdate));

//checkuser($ucode,$scode,$ecode,$source);



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

checkDaily($scode,$now);

/*
$mdate=str_replace("-","",$now);
$libname="basedata_" . $mdate ;

$sql="CREATE TABLE IF NOT EXISTS $libname (id int(11) NOT NULL AUTO_INCREMENT, stime time DEFAULT NULL, temp decimal(6,2) DEFAULT '0.00', ";
$sql .="calories decimal(6,2) DEFAULT '0.00', steps smallint(6) DEFAULT '0', distance decimal(6,4) DEFAULT '0.0000', move decimal(6,2) DEFAULT '0.00', ";
$sql .="sleepmode tinyint(1) NOT NULL DEFAULT '0',actmode tinyint(4) DEFAULT '0', tempmode tinyint(4) DEFAULT '0',delmark tinyint(4) DEFAULT '0', wakeup tinyint(4) DEFAULT '0',";
$sql .="sleepbelongs tinyint(4) NOT NULL, sensorid int(11) NOT NULL, PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

$stmt->execute();
$stmt->close();
*/
$sensor=array();
$sql ="SELECT orderlist, station, connected, power, lastupdate,nickname, headimage, dob, gender, unit, height, weight, step, stepgoal, caloriesgoal, stepwidth, distancegoal, runningwidth, bmi, sensorid, updated, age, bmr, sleepgoal, totalcal, totalsteps, totaldistance, totalsleep,detailid,vipmode FROM totalinfo  WHERE  userid=? and date=? order by orderlist";

echo "SELECT orderlist, station, connected, power, lastuppower,nickname, headimage, dob, gender, unit, height, weight, step, stepgoal, caloriesgoal, stepwidth, distancegoal, runningwidth, bmi, sensorid, updated, age, bmr, sleepgoal, totalcal, totalsteps, totaldistance, totalsleep,detailid,vipmode  FROM totalinfo  WHERE  userid=$ucode and date=$now order by orderlist";


$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $ucode,$now);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($orderlist, $station, $connected, $power,$lastupdate, $nickname, $headimage, $dob, $gender, $unit,  $height, $weight, $step, $stepgoal, $caloriesgoal, $stepwidth, $distancegoal, $runningwidth, $bmi, $sensorid, $updated, $age, $bmr, $sleepgoal, $totalcal, $totalsteps, $totaldistance, $totalsleep,$detailid,$vipmode); 
while ($stmt->fetch()) {
	
	$vname=array();
	$value=array();
	array_push($vname,"station");
	array_push($value,$station);
	array_push($vname,"connected");
	array_push($value,$connected);
	array_push($vname,"power");
	array_push($value,$power);
	array_push($vname,"lastupdate");
	array_push($value,$lastupdate);
	array_push($vname,"sensorid");
	array_push($value,$scode);
	array_push($vname,"nickname");
	array_push($value,$nickname);
	array_push($vname,"headimage");
	array_push($value,$headimage);
	array_push($vname,"dob");
	array_push($value,$dob);
	array_push($vname,"unit");
	array_push($value,$unit);
	array_push($vname,"gender");
	array_push($value,$gender);
	array_push($vname,"updated");
	array_push($value,$updated);
	array_push($vname,"age");
	array_push($value,$age);
	array_push($vname,"height");
	array_push($value,$height);
	array_push($vname,"weight");
	array_push($value,$weight);
	array_push($vname,"stepgoal");
	array_push($value,$stepgoal);
	array_push($vname,"caloriesgoal");
	array_push($value,$caloriesgoal);
	array_push($vname,"stepwidth");
	array_push($value,$stepwidth);
	array_push($vname,"distancegoal");
	array_push($value,$distancegoal);
	array_push($vname,"runningwidth");
	array_push($value,$runningwidth);
	array_push($vname,"bmi");
	array_push($value,$bmi);	
	array_push($vname,"bmr");
	array_push($value,$bmr);	
	array_push($vname,"sleepgoal");
	array_push($value,$sleepgoal);	
	array_push($vname,"detailid");
	array_push($value,$detailid);	
	array_push($vname,"usertype");
	array_push($value,$vipmode);	
	
	
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

echo json_encode(array('status'=>200,'sensorList'=>$sensor,'ecode'=>$ecode));


?>