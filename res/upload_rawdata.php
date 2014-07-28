<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 
$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$rawdata=$obj -> rawdata;
$package_type=$obj -> type;
// Check valid
checkuser($ucode,$scode,$ecode,$source);
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
// Iterate received json package and add rawdata to db.
// Store the inserted raw_data id into $raw_data_ids
$raw_data_ids = array();
for($i=0; $i<count($rawdata); $i++){
	$start=$rawdata[$i] -> start;
	$stop=$rawdata[$i] -> stop;
	$data=$rawdata[$i] ->data;
	$data_array_xyz = array();
	// Append all the data into this array, will be serialized and saved to sensor_values.
	for($j=0;$j<count($data);$j++){
		array_push($data_array_xyz, $data[$j] ->x);
		array_push($data_array_xyz, $data[$j] ->y);
		array_push($data_array_xyz, $data[$j] ->z);
	}
	$sql="insert into data_rawdata (sensor_id, start_time, end_time, delmark, sensor_values, num_values, upload_time, package_type) values (?,?,?,?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$delmark = false;
	$json = json_encode($data_array_xyz);
	$num = count($data_array_xyz) / 3;
	$now = date("Y-m-d H:m:s");
	$stmt->bind_param("issisiss", $scode, $start, $stop, $delmark, $json, $num, $now, $package_type);
	$stmt->execute();
	array_push($raw_data_ids, $stmt->insert_id);
	$stmt->close();
}
// After database is saved, call backend server to process all the inserted data ids.
// Sep 21, 2031: Comment the following if() function to disable Raw Data DI function for now (HH)
/*if (count($raw_data_ids) > 0) {
	// send GET http request to backend server.
	$ch = curl_init();
	$options = array(
		CURLOPT_URL => $backend_server. "/data/process_rawdata/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
		CURLOPT_POSTFIELDS => json_encode(array('id'=>$raw_data_ids)),
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	// var_dump($response);
	curl_close($ch);
}
*/

$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
$mysqli-> close();
echo json_encode(array('status'=>200,'scode'=>$scode,'ecode'=>$session));
?>