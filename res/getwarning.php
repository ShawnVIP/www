<?php
 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"3h1DOHA9ojm2uynCXx7L4DUIUrhv0a0KhDd5","scode":"12"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$dates=$obj -> dates;
$source=$obj -> source;
checkuser($ucode,$scode,$ecode,$source);

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);

$info=array();

$session=$ecode;
$sql="SELECT catalog, title, detail FROM warninginfo where sensorid=$scode and date='$dates' and delmark=0";
$result=mysql_query($sql,$conn); 
while ($row=mysql_fetch_array($result)) {
	array_push($info, array('catalog'=>$row['catalog'],'title'=>$row['title'],'detail'=>$row['detail']));	
}
echo json_encode(array('status'=>'200','info'=>$info,'ecode'=>$session));

?>