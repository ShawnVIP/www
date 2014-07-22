<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
$json_string='{"scode":"201","fcode":"1","ecode":"aaa","source":"w","message":"I ping you !"}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$fcode=$obj -> fcode;
$message=$obj -> message;

//checkuser($ucode,$scode,$ecode,$source);



$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 



$sql="SELECT  sensorid,friendid  FROM familylist where sensorid=? and friendid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $scode,$fcode);
$stmt->execute();
if(! $stmt->fetch()){
	echo json_encode(array('status'=>601,'ecode'=>$ecode));
	exit;
}
$datalist=array();

//$sql="SELECT  devicetoken  FROM sensorinfo where id=?";
$sql="SELECT a.nickname,a.devicetoken,b.nickname as fromname FROM sensorinfo as a, sensorinfo as b where a.id=? and b.id=? ";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $fcode,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nickname,$devicetoken,$fromname);

$popinfo='';

$pmode=200;
if($stmt->fetch()){
	$devicetoken=str_replace(" ","",$devicetoken);
	$message="Hi $nickname, your friend $fromname just ping you at $now and leave message:'$message'.";
	popmessage($devicetoken,$message);
	echo json_encode(array('status'=>$pmode,'ecode'=>$ecode,'extinfo'=>array('devicetoken'=> $devicetoken, 'message'=> $message,'result'=>$popinfo)));
	
}else{
	$popinfo='cannot find your friends devicetoken';
	echo json_encode(array('status'=>201,'ecode'=>$ecode,'errinfo'=>'cannot find your friends devicetoken'));
}


$sql="insert into pinglist (scode,fcode,message,pdate,info) values(?,?,?,?,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("sssss", $scode,$fcode,$message,date("Y-m-d H:i:s"),$popinfo);
$stmt->execute();
// Put your device token here (without spaces):


// Put your device token here (without spaces):
function popmessage($deviceToken,$message){
	global $popinfo,$pmode;
	// Put your private key's passphrase here:
	$passphrase = 'pushchat';
	
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