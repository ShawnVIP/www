<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$dates=$obj -> dates;
$type=$obj -> type; //family or friend

$dates=date('Y-m-d',strtotime($dates));
checkuser($ucode,$scode,$ecode,$source);

$stationList=array();

array_push($stationList,array('id'=> 'UN','color'=>'#e0e0e0'));
array_push($stationList,array('id'=> 'ST','color'=>'#9d9d9d'));
array_push($stationList,array('id'=> 'SL','color'=>'#27b1df'));
array_push($stationList,array('id'=> 'SI','color'=>'#f29806'));
array_push($stationList,array('id'=> 'SIA','color'=>'#f29806'));
array_push($stationList,array('id'=> 'WA','color'=>'#6aba0d'));
array_push($stationList,array('id'=> 'RU','color'=>'#6aba0d'));
array_push($stationList,array('id'=> 'UN','color'=>'#e0e0e0'));


//--------------check ucode---------------------

//--------------get family sensor id first

$datalist=array();


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql="select headimage,nickname FROM sensorinfo where id=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->bind_result($headimage,$nickname);
$stmt->fetch();
array_push($datalist,array('scode'=> $scode,'relation'=>'Me','nickname'=>$nickname,'headimage'=>$headimage,'percentage'=>array(),'values'=>array(),'alert'=>array(),'station'=>array()));


if($type=="friend"){
	$extInfo=" and a.relation ='friend'";
}else{
	$extInfo=" and a.relation <>'friend'";
}

$sql="SELECT a.friendid, a.relation, b.nickname, b.headimage FROM familylist as a, sensorinfo as b WHERE a.sensorid=? and b.id=a.friendid  and a.delmark=0". $extInfo;

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($friendid, $relation,$nickname,$headimage);
while($stmt->fetch()){
	array_push($datalist,array('scode'=> $friendid,'relation'=>$relation,'nickname'=>$nickname,'headimage'=>$headimage,'percentage'=>array(),'values'=>array(),'alert'=>array(),'station'=>array()));
}


//----------get detaildata for each family, include station and percentage----------------------------
$sql ="SELECT stepgoal,caloriesgoal,distancegoal,sleepgoal,totalcal,totalsteps,totaldistance,totalsleep FROM dailyvalue WHERE sensorid=? and date=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处

$averPercent=array();
array_push($averPercent,array('type'=> 'steps','value'=>0));
array_push($averPercent,array('type'=> 'calories','value'=>0));
array_push($averPercent,array('type'=> 'distance','value'=>0));
array_push($averPercent,array('type'=> 'sleep','value'=>0));
for($i=0;$i<count($datalist);$i++){
	$stmt->bind_param("ss", $datalist[$i]['scode'],$dates);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stepgoal,$caloriesgoal,$distancegoal,$sleepgoal,$totalcal,$totalsteps,$totaldistance,$totalsleep);
	if($stmt->fetch()){
		$datalist[$i]["percentage"] = array('step'=> getPercentage($totalsteps,$stepgoal),'calories'=>getPercentage($totalcal,$caloriesgoal),'distance'=>getPercentage($totaldistance,$distancegoal),'sleep'=>getPercentage($totalsleep,$sleepgoal));
		$datalist[$i]["values"] = array('stepgoal'=> $stepgoal,'caloriesgoal'=>$caloriesgoal,'distancegoal'=>$distancegoal,'sleepgoal'=>$sleepgoal,'totalcal'=>$totalcal,'totalsteps'=>$totalsteps,'totaldistance'=>$totaldistance,'totalsleep'=>$totalsleep);
		$averPercent[0]["value"]+=getPercentage($totalsteps,$stepgoal);
		$averPercent[1]["value"]+=getPercentage($totalcal,$caloriesgoal);
		$averPercent[2]["value"]+=getPercentage($totaldistance,$distancegoal);
		$averPercent[3]["value"]+=getPercentage($totalsleep,$sleepgoal);
		
	}else{
		$datalist[$i]["percentage"] = array('step'=> 0,'calories'=>0,'distance'=>0,'sleep'=>0);
		$datalist[$i]["values"] = array('stepgoal'=> 0,'caloriesgoal'=>0,'distancegoal'=>0,'sleepgoal'=>0,'totalcal'=>0,'totalsteps'=>0,'totaldistance'=>0,'totalsleep'=>0);
	
	}
}

for($i=0;$i<4;$i++){
	$averPercent[$i]["value"]=floor($averPercent[$i]["value"]/count($datalist));
}


//------get alert----------
$sql="SELECT alertdate,alerttype,alertmark FROM alertlist where sid=? and DATE_FORMAT(alertdate,'%Y-%m-%d')=? and delmark=0";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处

for($i=0;$i<count($datalist);$i++){
	$stmt->bind_param("ss", $datalist[$i]['scode'],$dates);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($alertdate,$alerttype,$alertmark);
	if($stmt->fetch()){
		$datalist[$i]["alert"] = array('time'=>date('H:i:s',strtotime($alertdate)) ,'type'=>$alertmark,'describe'=>$alerttype);
	}
}


//-----get station-------------------
$sql="SELECT totime,position FROM sensorstation where sensorid=? and sdate=? and adjtype=0 order by totime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处

for($i=0;$i<count($datalist);$i++){
	$stmt->bind_param("ss", $datalist[$i]['scode'],$dates);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($totime,$position);
	while($stmt->fetch()){
		array_push($datalist[$i]["station"],array('totime'=>$totime ,'position'=>$position,'station'=>$stationList[$position]));
	}
}



//$values = array_values($datalist);  
//print_r($values);  


echo json_encode(array('status'=>200,'peopleList'=>$datalist,'peopleAverange'=>$averPercent,'ecode'=>$ecode));


?>