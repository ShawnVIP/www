<?php

$datelListStr="2014-8-11|2014-8-12|2014-8-13";
$scode=1;
//-------------------refresh sensor station.-----------------------

$url = "http://haisw.net/sense-u/res/admin_refreshdata.php";

$post_data = array ("scode" => $scode,"date" => $datelListStr);
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

?>
