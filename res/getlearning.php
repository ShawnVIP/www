<?php 
include "dbconnect.php";

/*
CREATE TABLE IF NOT EXISTS learningdata (
  id int(11) NOT NULL AUTO_INCREMENT,
  scode varchar(36) DEFAULT NULL,
 ucode varchar(36) DEFAULT NULL, 
 activity_goal int(4) DEFAULT 0,
 sleep_quality_type varchar(36) DEFAULT NULL, 
 sleep_quality varchar(20) DEFAULT NULL,
 activity_sleep_tracking_interval tinyint(4) DEFAULT 0,
 activity_level_threshold int(4) DEFAULT 0,
 raw_data_enable tinyint(2) DEFAULT 0,
 rf_interval tinyint(4) DEFAULT 0,
 rf_power int(4) DEFAULT 0,
 inactivity_duration int(4) DEFAULT 0,
 fall_threshold int(4) DEFAULT 0,
 fall_impact_threshold int(4) DEFAULT 0,
 fall_angle int(4) DEFAULT 0,
 activity_goal_type tinyint(2) DEFAULT 0,
  builddate datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


*/

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"CvYdlBkGHxgUfH3d","source":"w"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;


//checkuser($ucode,$scode,$ecode,$source);
$scode=1;
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql="select caloriesgoal,stepgoal,distancegoal from dailyvalue where sensorid=? order by date desc limit 0,1";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $caloriesgoal,$stepgoal,$distancegoal); 
$stmt->fetch();
$valueList=array(0, $caloriesgoal,$stepgoal,$distancegoal);
$sql="select detailid from sensorinfo where id=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($detailid); 
$stmt->fetch();
	
$datalist=buildLearning($scode,$valueList[$detailid],$detailid);

$stmt->close();
echo json_encode(array('status'=>200,'datalist'=>$datalist));


?>