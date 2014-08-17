<?php
include "dbconnect.php";

$a=array("a"=>"Cat","b"=>"Dog","c"=>"Cat");
$a=array_unique($a);
print_r(date('Y-m-d',strtotime('2012-8-1')));
//loadFunction('admin_getdailyvalue.php',array ("mode"=>1,"scode" => 1,"date" => '2014-08-16',"addnew"=>1,"returnmode"=>1),true);


/*
$datelListStr="2014-08-11|2014-08-12|2014-08-13";
$scode=1;
//-------------------refresh sensor station.-----------------------

$url = "http://haisw.net/sense-u/res/admin_refreshdata.php";

$post_data = array ("mode"=>1,"scode" => $scode,"date" => $datelListStr);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
echo($output );
*/
/*
$sql="SELECT sensorid, sdate, totime, position, delmark, adjtype, lasttime FROM sensorstation order by id";
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sensorid=$row['sensorid'];
	$sdate=$row['sdate'];
	$totime=$row['totime'];
	$position=$row['position'];
	$delmark=$row['delmark'];
	$adjtype=$row['adjtype'];
	$lasttime=$row['lasttime'];
	$sqla="INSERT INTO sensorstationa(sensorid, sdate, totime, position, delmark, adjtype, lasttime) VALUES ($sensorid, '$sdate', '$totime', $position, $delmark, $adjtype, $lasttime)";
	$resulta=mysql_query($sqla,$conn); 

}
*/
/*
//获取域名或主机地址 
echo $_SERVER['HTTP_HOST']."<br>"; #localhost

//获取网页地址 
echo $_SERVER['PHP_SELF']."<br>"; #/blog/testurl.php

//获取网址参数 
echo $_SERVER["QUERY_STRING"]."<br>"; #id=5

//获取用户代理 
echo $_SERVER['HTTP_REFERER']."<br>"; 

//获取完整的url
echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>"; 
echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."<br>"; 
#http://localhost/blog/testurl.php?id=5

//包含端口号的完整url
echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]."<br>"; 
#http://localhost:80/blog/testurl.php?id=5

//只取路径
$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; 
echo dirname($url);
#http://localhost/blog
*/
?>
