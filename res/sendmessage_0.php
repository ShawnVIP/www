<?php

include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$fcode=$obj -> fcode;
$source=$obj -> source;

$message=$obj -> message;
$sdate=$obj ->cdate;
checkuser($ucode,$scode,$ecode,$source);



$now=date("Y-m-d H:i:s");


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql="select * from familylist where sensorid=? and friendid=? and delmark=0";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss",$scode,$fcode);
$stmt->execute();
if (!$stmt->fetch()) {
	echo json_encode(array('status'=>601));	
	exit;
}

//$mysqli->set_charset("uft8");
//$mysqli->query("set names 'uft8'");
//$sql = "INSERT INTO message( fromid, toid, message, sdate) VALUES (?,?,?,?)"; //预处理sql语句
$sql= "INSERT INTO message( fromid, toid, message, sdate) VALUES ($scode,$fcode,'$message','$sdate')"; //预处理sql语句
$result=mysql_query($sql, $conn);




//$sql="SELECT  devicetoken  FROM sensorinfo where id=?";
$sql="SELECT a.nickname,a.devicetoken,b.nickname as fromname FROM sensorinfo as a, sensorinfo as b where a.id=$fcode and b.id=$scode ";
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
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'senseu_product.pem');
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

