<?php
$devicetoken='8d0ceae3 7d93f07d 8022070f c107bbe7 d93187cd 8b3d4747 c210abc5 5f52ebf6';
$now=date("Y-m-d H:i:s");
$alerttype='alert test at' . $now;

$popinfo=array();

popmessage($devicetoken,$alerttype);



function popmessage($devicetoken,$message){
	
	global $popinfo;
	// Put your private key's passphrase here:
	$passphrase = 'pushchat';
	$devicetoken=str_replace(" ","",$devicetoken);
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
		array_push($popinfo,array('device'=>$devicetoken,'result'=>"Failed to connect: $err $errstr" ));
	    return;
	}

	echo 'Connected to APNS' . PHP_EOL;
	
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
		array_push($popinfo,array('device'=>$devicetoken,'result'=>'Message not delivered'  ));
	    exit;
	}else{
		array_push($popinfo,array('device'=>$devicetoken,'result'=>'Message successfully delivered' ));
	}
	// Close the connection to the server
	fclose($fp);
}

echo json_encode(array('status'=>200,'devicetoken'=>$devicetoken,'alerttype'=>$alerttype,'extinfo'=>$popinfo));
?>