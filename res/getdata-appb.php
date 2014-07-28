<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-1-1","cdate":"2014-1-1 23:03:22","ecode":"FShs3C7M8o37W5Vk","source":"w"}';
$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"552","dates":"2014-6-26","cdate":"2014-6-26 22:50:51","ecode":"qyRYwl3L4LUKXkir","source":"a"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;


$dates=date('Y-m-d',strtotime($dates));

$lang=strtolower($obj -> lang);
if($lang==""){$lang="cn";}


//checkuser($ucode,$scode,$ecode,$source);

$valueNameList=array('calories','distance','step','sleep');

$valueList=array('status'=>200,'caloriesgoal'=>0,'distancegoal'=>0,'stepgoal'=>0,'sleepgoal'=>0,'caloriestoken'=>0,'distancetoken'=>0,'steptoken'=>0,'sleeptoken'=>0,'ecode'=>$ecode);

for($i=0;$i<count($valueNameList);$i++){
	
	$sql="select " . $valueNameList[$i] . "goal from dailyvalue where sensorid=$scode and " . $valueNameList[$i] ."goal>0 and date<='$dates' order by date desc limit 0,1";	
	//echo $sql;
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$valueList[$valueNameList[$i] . 'goal']=$row[$valueNameList[$i] . 'goal'];
		//echo $valueNameList[$i] . "  " . $valueNameList[$i] . 'goal' . "    " . $row[$valueNameList[$i] . 'goal'] . "    " . $valueList[$valueNameList[$i]] . "----";
	}

}

$sql="select *,totalcal as totalcalories,totalsteps as totalstep from dailyvalue where sensorid=$scode and date='$dates'";
//echo $sql;
$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	for($k=0;$k<4;$k++){;
		$valueList[$valueNameList[$k].'token']=$row['total' .$valueNameList[$k]];
	}
}

echo json_encode($valueList);

?>

