<?php

include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
$json_string='{"scode":"1","fcode":"629","ecode":"aaa","source":"w","message":"测试一下","cdate":"'.$now.'"}';


$obj=json_decode($json_string); 

$ucode=$obj -> ucode;


$scode=$obj -> scode;
$ecode=$obj -> ecode;


$fcode=$obj -> fcode;
$source=$obj -> source;

$message=$obj -> message;
$sdate=$obj ->cdate;

$idlist=array(629,630,631,632);
$msglist=array('hello, this is a test!','这是一个测试信息','随便测试一下吧','I miss you!','What are you doing?');
$k=rand(0,count($idlist)-1);
//$fcode=$idlist[$k];
//$scode=1;
$k=rand(0,count($msglist)-1);
$message=$msglist[$k];



//checkuser($ucode,$scode,$ecode,$source);



$now=date("Y-m-d H:i:s");


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql="select * from familylist where sensorid=$scode and friendid=$fcode and delmark=0";

$result=mysql_query($sql, $conn);
if(! $row=mysql_fetch_array($result)){
	echo json_encode(array('status'=>601));	
	exit;
}


$sql="INSERT INTO message( fromid, toid, message, sdate) VALUES ( $scode,$fcode,'$message','$sdate')";
$result=mysql_query($sql, $conn);

echo $sql;

//$sql="SELECT  devicetoken  FROM sensorinfo where id=?";
$sql="SELECT a.nickname,a.devicetoken,b.nickname as fromname FROM sensorinfo as a, sensorinfo as b where a.id=$fcode and b.id=$scode";
$result=mysql_query($sql, $conn);



$popinfo='';
$pmode=200;

if($row=mysql_fetch_array($result)){
	$nickname=$row['nickname'];
	$devicetoken=$row['devicetoken'];
	$fromname=$row['fromname'];
	$devicetoken=str_replace(" ","",$devicetoken);
	$message="Hi $nickname, your friend $fromname just leave you message :'$message'.";
	popmessage($devicetoken,$message);
	echo json_encode(array('status'=>200,'ecode'=>$ecode,'extinfo'=>array('devicetoken'=> $devicetoken, 'message'=> $message,'result'=>$popinfo)));
	
}else{
	$popinfo='cannot find your friends devicetoken';
	echo json_encode(array('status'=>200,'ecode'=>$ecode,'extinfo'=>'cannot find your friends devicetoken'));
}



// Put your device token here (without spaces):
function popmessage($deviceToken,$message){
	global $popinfo,$pmode;
	// Put your private key's passphrase here:
	$passphrase = '123456';
	
	// Put your alert message here:
	//$message = 'My first push notification!';
	//$deviceToken = '8d0ceae37d93f07d8022070fc107bbe7d93187cd8b3d4747c210abc55f52ebf6';
	
	////////////////////////////////////////////////////////////////////////////////
	
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	// Open a connection to the APNS server
	$fp = stream_socket_client(
		'ssl://gateway.sandbox.push.apple.com:2195', $err,
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	if (!$fp){
		$pmode=202;
		$popinfo="Failed to connect: $err $errstr" ;
	    return;
	}

	//echo 'Connected to APNS' . PHP_EOL;
	
	// Create the payload body
	$body['aps'] = array(
		'alert' => $message,
		'sound' => 'default'
		);
	
	// Encode the payload as JSON
	$payload = json_encode($body);
	
	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
	
	if (!$result){
		$pmode=203;
		$popinfo='Message not delivered';
	    exit;
	}else{
		$pmode=200;
		$popinfo='Message successfully delivered';
	}
	// Close the connection to the server
	fclose($fp);
}
$mysqli-> close();

	 
?>

