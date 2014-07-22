<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
$json_string='{"ucode":"A8jBnJiUuIlQggB426LooWAciaVD6NXofRLO","scode":"201","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alertlist":[{"stamp":"'.$now.'","type":129}]}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$alertlist=$obj -> alertlist;


//checkuser($ucode,$scode,$ecode,$source);



$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql="insert into alertlist (sid,alertdate,alerttype,delmark,userid) values (?,?,?,0,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

for($i=0;$i<count($alertlist);$i++){
	$stamp=$alertlist[$i] -> stamp;
	$alerttype=$alertlist[$i] -> type;
	
	$stmt->bind_param("ssss",$scode,$stamp,$alerttype,$ucode);
	$stmt->execute();
}
$stmt->close();

//$sql="SELECT  devicetoken  FROM devicelist where sensorid=?";
//$sql="SELECT  sensorid,devicetoken  FROM devicelist where sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0)";
//$sql="SELECT  a.nickname,b.sensorid,b.devicetoken  FROM sensorinfo as a, devicelist as b where b.sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0) and a.id=b.sensorid";
$sql="SELECT  a.nickname,b.sensorid,b.devicetoken,c.relation,d.nickname as familyname  FROM sensorinfo as a, devicelist as b, familylist as c,sensorinfo as d where b.sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0) and a.id=b.sensorid and c.friendid=? and b.delmark=0 and c.delmark=0 and c.sensorid=a.id and d.id=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("sss", $scode,$scode,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nickname,$sensorid,$devicetoken,$relation,$familyname);

$datalist=array();
$popinfo="";
$pmode=200;
while($stmt->fetch()){
	for($i=0;$i<count($alertlist);$i++){
		$devicetoken=str_replace(" ","",$devicetoken);
		$typeid=$alertlist[$i] -> type;
		$falltime=$alertlist[$i] -> stamp;
		$message="";
		if($relation=="other"){
			$name="Hi $nickname, your family member $familyname ";	
		}else{
			$name="Hi $nickname, your $relation $familyname ";	
		}
		if($typeid==1){$message="$name fall down at $falltime";}
		if($typeid==129){$message.="$name fall down at $falltime and then press button to cancel the alert.";}
		if($message !=""){
			popmessage($devicetoken,$message);
			array_push($datalist,array('senderid'=>$scode,'receivername'=>$nickname,'receiverid'=>$sensorid,'devicetoken'=> $devicetoken,'status'=>$pmode, 'extinfo'=>$popinfo, 'message' => $message));
		}
	}
}




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

echo json_encode(array('status'=>200,'ecode'=>$ecode,'datalist'=>$datalist));
?>