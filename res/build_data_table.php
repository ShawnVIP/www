<?php
include "dbconnect.php";


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

function checkValueLib($ndate){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	$mdate=str_replace("-","",$ndate);
	$libname="basedata_" . $mdate ;
	$sql="CREATE TABLE IF NOT EXISTS $libname (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  stime time DEFAULT NULL,
		  temp decimal(6,2) DEFAULT '0.00',
		  calories decimal(6,2) DEFAULT '0.00',
		  steps smallint(6) DEFAULT '0',
		  distance decimal(8,2) DEFAULT '0.00',
		  move smallint(6) DEFAULT '0',
		  sleepmode tinyint(1) NOT NULL DEFAULT '0',
		  actmode tinyint(4) DEFAULT '0',
		  tempmode tinyint(4) DEFAULT '0',
		  delmark tinyint(4) DEFAULT '0',
		  wakeup tinyint(4) DEFAULT '0',
		  sleepbelongs tinyint(4) NOT NULL,
		  sensorid int(11) NOT NULL,
		  angle smallint(4) DEFAULT '0',
		  maxspeed smallint(4) DEFAULT '0',
		  minspeed smallint(4) DEFAULT '0',
		  averagespeed smallint(4) DEFAULT '0',
		  detectedposition tinyint(2) DEFAULT '0',
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	//$sql="alter table $libname add column (angle smallint(4) DEFAULT '0',maxspeed smallint(4) DEFAULT '0',minspeed smallint(4) DEFAULT '0',averagespeed smallint(4) DEFAULT '0',detectedposition tinyint(2) DEFAULT '0')";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	//echo $sql;
	//$stmt->bind_param();
	$stmt->execute();
	$stmt->close();
	
	
	$mysqli->close();
	return;
}


$beginDate='2014-2-11';
$bdate=date('Y-m-d',strtotime($beginDate));

$endDate='2014-12-31';
$edate=date('Y-m-d',strtotime($endDate));
echo $bdate . "  " . $edate;
while($bdate <= $edate){
	echo "<br> build date:" . $bdate;
	checkValueLib($bdate);
	$bdate=date('Y-m-d',strtotime("$bdate 1 day"));
	
}

?>