<?php

$mysql_server_name="localhost"; 
$mysql_username="ledo"; 
$mysql_password="Ledo!11@22"; 
$mysql_database="ledo";
$conn=mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
mysql_select_db("ledo", $conn);
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"userid":12, "data":[{"stamp":"2012-07-13 15:20","temp":36.5}, {"stamp":"2012-07-13 15:25","temp":36.6}]}';
$obj=json_decode($json_string); 

$userid=$obj -> userid;
$data=$obj -> data;
for($i=0;$i<count($data);$i++){
	$ndate=explode(" ", $data[$i] -> stamp);
	
	$strsql="select * from data_date where userid=$userid and sdate='" . $ndate[0] . "' and actmode='temp'";
	$result=mysql_query($strsql, $conn);
	$row=mysql_num_rows($result);
	if($row>0){
		$row=mysql_fetch_array($result);
		$dateid=$row['id'];
	}else{
		$strsql="insert into data_date (userid,sdate,actmode) values ($userid,'" . $ndate[0] . "','temp')";
		//echo $strsql . "<br>";
		$result=mysql_query($strsql, $conn);
		$strsql="select * from data_date where userid=$userid and sdate='" . $ndate[0] . "' and actmode='temp'";
		$result=mysql_query($strsql, $conn);
		$row=mysql_fetch_array($result);
		$dateid=$row['id'];
	}
	//-------------save time
	$ntime=$ndate[1]. ":00";
	$nvalue= $data[$i] -> temp;
	$strsql="select * from data_tempvalue where dateid=$dateid and stime='$ntime'";
	$result=mysql_query($strsql, $conn);
	$row=mysql_num_rows($result);
	if($row==0){
		$strsql="insert into data_tempvalue (dateid,stime,temp) values ($dateid,'$ntime','$nvalue')";
		//echo $strsql . "<br>";
		$result=mysql_query($strsql, $conn);
	}
}
echo json_encode(array('status'=>'200'));

?>