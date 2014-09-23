<?php 
include "dbconnect.php";



$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-1-1","cdate":"2014-1-1 23:03:22","ecode":"FShs3C7M8o37W5Vk","source":"w"}';
$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"527","dates":"2014-9-18","cdate":"2014-6-26 22:50:51","ecode":"qyRYwl3L4LUKXkir","source":"a"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$dates=$obj -> dates;
$source=$obj -> source;

//checkuser($ucode,$scode,$ecode,$source);

$valueList=checkDailyValue($scode,$dates,1,true);

echo json_encode(array('status'=>200,'caloriesgoal'=>$valueList[0][caloriesgoal],'disgoal'=>$valueList[0][distancegoal],'stepgoal'=>$valueList[0][stepgoal],'sleepgoal'=>$valueList[0][sleepgoal],'caltaken'=>$valueList[0][totalcal],'distaken'=>$valueList[0][totaldistance],'stepstaken'=>$valueList[0][totalsteps],'sleeptaken'=>$valueList[0][totalsleep],'deepsleep'=>$valueList[0][deepsleep],'ecode'=>$ecode));
	

?>

