<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$now=date("Y-m-d H:i:s");
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"605","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alertlist":[{"stamp":"'.$now.'","type":129}]}';
$json_string='{"ecode":"ERPirHWC1yDa6BjO","source":"u","scode":"654","ucode":"bzi2FvsakV521Z25XqBC5pJ3sQEG12OvGJhj","alertlist":[{"stamp":"2014-09-03 09:48:59","alerttype":"1"}]}';

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
//checkuser($ucode,$scode,$ecode,$source);

//$sql="INSERT INTO sleepdata(sid, sdate, ftime, ttime, fdate, tdate) VALUES ($scode, '$tdate','$ftime', '$ttime', '$fdate', '$tdate')";
//$result=mysql_query($sql,$conn); 

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql="insert into alertlist (sid,alertdate,alerttype,delmark,userid) values (?,?,?,0,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

for($i=0;$i<count($alertlist);$i++){
	$stamp=$alertlist[$i] -> stamp;
	$alerttype=$alertlist[$i] -> type;
	echo "insert into alertlist (sid,alertdate,alerttype,delmark,userid) values ($scode,$stamp,$alerttype,0,$ucode)";

	$stmt->bind_param("ssss",$scode,$stamp,$alerttype,$ucode);
	$stmt->execute();
}
$stmt->close();

$sendlist=array();
$datalist=array();
$myname="";
//--------------------------

$sql="select nickname from sensorinfo where id=$scode";
$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	$sendername=$row['nickname'];
}else{
	exit();
}

$sql="select id,nickname,devicetoken,language from sensorinfo  where (id in (select sensorid from familylist where friendid=$scode and delmark=0 and guardian=1) or id=$scode)  and devicetoken <>''";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sqla="select b." . $row['language'] . "_name as relation from familylist as a, relation as b where sensorid=" . $row['id']. " and friendid=$scode and b.id=a.relation";
	//echo $sqla;
	$resulta=mysql_query($sqla,$conn); 
	if($rowa=mysql_fetch_array($resulta)){
		$relation=$rowa['relation'];
	}else{
		$relation="";
		
	}
	array_push($sendlist,array('receiverid'=> $row['id'],'nickname'=>$row['nickname'],'devicetoken'=>str_replace(" ","",$row['devicetoken']),'language'=>$row['language'],'relation'=>$relation));
}

//echo json_encode($sendlist);


for($j=0;$j<count($sendlist);$j++){
	for($i=0;$i<count($alertlist);$i++){
		
		$typeid=$alertlist[$i] -> type;
		$falltime=$alertlist[$i] -> stamp;
		$message="";
		
		
		if($sendlist[$j][language]=="EN"){
			if($sendlist[$j][relation]==""){
				$startmsg=$sendlist[$j][nickname] . ", you";
			}else{
				$startmsg=$sendlist[$j][nickname]. ", your ".$sendlist[$j][relation]." " .$sendername;
			}
			if($typeid==1){
				$message=$startmsg . " fall down at $falltime.";
			}
			if($typeid==129){
				$message=$startmsg ." fall down at $falltime and then press button to cancel the alert.";
			}
		}else{
			if($sendlist[$j][relation]==""){
				$startmsg=$sendlist[$j][nickname]. ",您";
			}else{
				$startmsg=$sendlist[$j][nickname]. ",您的 ".$sendlist[$j][relation]." " .$sendername;
			}
			if($typeid==1){
				$message=$startmsg ."在 $falltime 跌倒了.";
			}
			if($typeid==129){
				$message=$startmsg."在 $falltime 跌倒了，并随后按键取消了跌倒警告.";
			}
		
		}
		//echo $message;
		if($message !=""){
			popmessage($sendlist[$j][devicetoken],$message);
			array_push($datalist,array('senderid'=>$scode,'receivername'=>$sendlist[$j][nickname],'receiverid'=>$sendlist[$j][receiverid],'devicetoken'=> $sendlist[$j][devicetoken],'status'=>$pmode, 'extinfo'=>$popinfo, 'message' => $message));
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

echo json_encode(array('status'=>200,'ecode'=>$ecode,'datalist'=>$datalist));
?>