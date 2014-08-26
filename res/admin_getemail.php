<?php 
include "dbconnect.php";
writeGetUrlInfo();

$maillist=array();

$sql="select * from usedmail order by email";

$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	array_push($maillist,$row['email']);	
}

	
echo json_encode(array('status'=>200,'mailList'=>$maillist));


?>