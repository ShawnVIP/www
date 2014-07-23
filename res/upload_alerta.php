<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alertlist":[{"stamp":"'.$now.'","type":129}]}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$lang=$obj -> lang;


$alertlist=$obj -> alertlist;

if($lang==""){
	$lang="cn";
}
checkuser($ucode,$scode,$ecode,$source);



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

$sql="select nickname from sensorinfo where id=$scode";
		//echo $sql;
$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
$nickname=$row['nickname'];
		
		
//$sql="SELECT  devicetoken  FROM devicelist where sensorid=?";
//$sql="SELECT  sensorid,devicetoken  FROM devicelist where sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0)";
//$sql="SELECT  a.nickname,b.sensorid,b.devicetoken  FROM sensorinfo as a, devicelist as b where b.sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0) and a.id=b.sensorid";
$sql="SELECT  b.sensorid,b.devicetoken,c.relation  FROM sensorinfo as a, devicelist as b, familylist as c where b.sensorid in (select sensorid from familylist where guardian=1 and friendid=? and delmark=0) and a.id=b.sensorid and c.friendid=? and b.delmark=0 and c.delmark=0 and c.sensorid=a.id";

//echo "SELECT  a.nickname,b.sensorid,b.devicetoken,c.relation  FROM sensorinfo as a, devicelist as b, familylist as c where b.sensorid in (select sensorid from familylist where guardian=1 and friendid=$scode and delmark=0) and a.id=b.sensorid and c.friendid=$scode and b.delmark=0 and c.delmark=0 and c.sensorid=a.id";


$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $scode,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sensorid,$devicetoken,$relation);

$datalist=array();
$popinfo="";
$pmode=200;
while($stmt->fetch()){
	for($i=0;$i<count($alertlist);$i++){
		$devicetoken=str_replace(" ","",$devicetoken);
		$typeid=$alertlist[$i] -> type;
		$falltime=$alertlist[$i] -> stamp;
		$message="";
		
		$sql="select nickname,language from sensorinfo where id=$sensorid";
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$lang=$row['language'];
		$rname=$row['nickname'];
		
		
		
		
		$sql="select " . $lang . "_name as rname, relation from relation where id=$relation";
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$rname=$row["rname"];
		$rtype=$row["relation"];
		
		echo $lang;
		
		if($lang=="EN"){
			if($typeid==1){
				$message="Your $rname $nickname fall down at $falltime.";
			}
			if($typeid==129){
				$message="Your $rname $nickname fall down at $falltime and then press button to cancel the alert.";
			}
		}else{
			if($typeid==1){
				$message="您的 $rname $nickname 在 $falltime 跌倒了.";
			}
			if($typeid==129){
				$message="您的 $rname $nickname 在 $falltime 跌倒了，并随后按键取消了跌倒警告.";
			}
		
		}
		//echo $message;
		if($message !=""){
			popmessage($devicetoken,$message);
			array_push($datalist,array('senderid'=>$scode,'receivername'=>$rname,'receiverid'=>$sensorid,'devicetoken'=> $devicetoken,'status'=>$pmode, 'extinfo'=>$popinfo, 'message' => $message));
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