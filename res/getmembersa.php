<?php 
include "dbconnect.php";
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

//$json_string='{"type":"friend","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"591","dates":"2014-7-14","cdate":"2014-7-14 0:13:17","ecode":"GkwkYjVklmFFO6jC","source":"a"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$dates=$obj -> dates;
$type=$obj -> type; //family or friend

$dates=date('Y-m-d',strtotime($dates));

$lang=strtolower($obj -> lang);
if($lang==""){$lang="cn";}


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
if ($type=="family"){
	
	array_push($datalist,array('scode'=> $scode,'relation'=>'Me','nickname'=>$nickname,'headimage'=>$headimage,'percentage'=>array(),'values'=>array(),'alert'=>array(),'station'=>array()));
}

if($type=="friend"){
	$extInfo=" and a.relation =17";
}else{
	$extInfo=" and a.relation <>17";
}

$sql="SELECT a.friendid, a.relation, b.nickname, b.headimage, c." . $lang . "_name as relname FROM familylist as a, sensorinfo as b ,relation as c WHERE a.relation=c.id and  a.sensorid=? and b.id=a.friendid  and a.delmark=0". $extInfo;

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($friendid, $relation,$nickname,$headimage,$relname);
while($stmt->fetch()){
	array_push($datalist,array('scode'=> $friendid,'relation'=>$relname,'nickname'=>$nickname,'headimage'=>$headimage,'percentage'=>array(),'values'=>array(),'alert'=>array(),'station'=>array()));
}

//------calc weekly date period.
//---0 : sunday, 1:monday.
$weekid=date("w",$dates);
if($weekid==0){$weekid=7;}

$toStartDay=2-$weekid;
$toEndDay=8-$weekid;
$fromdate=date('Y-m-d',strtotime("$dates $toStartDay day"));
//$enddate=date('Y-m-d',strtotime("$dates $toEndDay day"));
$enddate=$dates;


//---------------------------------所有人的dailydata进行调整，空缺的数据用上次有效的部分补足------------------

$sqlinsert="insert into dailyvalue ( height,weight,step,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,bmr,age,sleepgoal,updated,sensorid,date) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sqlinsert); //?sql???mysqli????

for($i=$toStartDay;$i<=0;$i++){
	$tempdate=date('Y-m-d',strtotime("$dates $i day"));
	for($j=0;$j<count($datalist);$j++){
		
		//SELECT `id`, `height`, `weight`, `step`, `date`, `stepgoal`, `caloriesgoal`, `stepwidth`, `distancegoal`, `runningwidth`, `bmi`, `sensorid`, `updated`, `age`, `bmr`, `sleepgoal`, `totalcal`, `totalsteps`, `totaldistance`, `totalsleep` FROM `dailyvalue` WHERE 1
		$sql="SELECT * from dailyvalue where sensorid=" . $datalist[$j]['scode'] . " and date='$tempdate'";
		//echo $sql . "\n";
		
		$result=mysql_query($sql,$conn); 
		$row=mysql_num_rows($result);
		if($row==0){
			$sql="SELECT * from dailyvalue where sensorid=" . $datalist[$j]['scode'] . " and date<'$tempdate' order by date desc limit 0,1";
			$result=mysql_query($sql,$conn); 
			$row=mysql_fetch_array($result);
			
			
			$stmt->bind_param("sssssssssssssss", $row['height'],$row['weight'],$row['step'],$row['stepgoal'],$row['caloriesgoal'],$row['stepwidth'],
			                  $row['distancegoal'],$row['runningwidth'],$row['bmi'],$row['bmr'],$row['age'],$row['sleepgoal'],$row['updated'], $datalist[$j]['scode'] ,$tempdate);
			$stmt->execute();
		}
			
	}

}
//----------get detaildata for each family, include station and percentage----------------------------
//$sql ="SELECT stepgoal,caloriesgoal,distancegoal,sleepgoal,totalcal,totalsteps,totaldistance,totalsleep FROM dailyvalue WHERE sensorid=? and date=?";
$sql ="SELECT sum(stepgoal) as stepgoal,sum(caloriesgoal) as caloriesgoal, sum(distancegoal) as distancegoal, sum(sleepgoal) as sleepgoal,sum(totalcal) as totalcal, sum(totalsteps) as totalsteps, sum(totaldistance) as totalsteps ,sum(totalsleep) as totalsleep FROM dailyvalue WHERE sensorid=? and date>='$fromdate' and date<='$enddate'";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处

$averPercent=array('step'=>0,'calories'=>0,'distance'=>0,'sleep'=>0);
for($i=0;$i<count($datalist);$i++){
	$stmt->bind_param("s", $datalist[$i]['scode']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stepgoal,$caloriesgoal,$distancegoal,$sleepgoal,$totalcal,$totalsteps,$totaldistance,$totalsleep);
	if($stmt->fetch()){
		$datalist[$i]["percentage"] = array('step'=> getPercentage($totalsteps,$stepgoal),'calories'=>getPercentage($totalcal,$caloriesgoal),'distance'=>getPercentage($totaldistance,$distancegoal),'sleep'=>getPercentage($totalsleep,$sleepgoal));
		$datalist[$i]["values"] = array('stepgoal'=> $stepgoal,'caloriesgoal'=>$caloriesgoal,'distancegoal'=>$distancegoal,'sleepgoal'=>$sleepgoal,'totalcal'=>$totalcal,'totalsteps'=>$totalsteps,'totaldistance'=>$totaldistance,'totalsleep'=>$totalsleep);
		$averPercent["step"]+=getPercentage($totalsteps,$stepgoal);
		$averPercent["calories"]+=getPercentage($totalcal,$caloriesgoal);
		$averPercent["distance"]+=getPercentage($totaldistance,$distancegoal);
		$averPercent["sleep"]+=getPercentage($totalsleep,$sleepgoal);
		
	}else{
		$datalist[$i]["percentage"] = array('step'=> 0,'calories'=>0,'distance'=>0,'sleep'=>0);
		$datalist[$i]["values"] = array('stepgoal'=> 0,'caloriesgoal'=>0,'distancegoal'=>0,'sleepgoal'=>0,'totalcal'=>0,'totalsteps'=>0,'totaldistance'=>0,'totalsleep'=>0);
	
	}
}
if(count($datalist)==0){
	echo json_encode(array('status'=>200,'peoplelist'=>'','peopleaverange'=>'','ecode'=>$ecode));
	exit();
}

$averPercent["step"]=floor($averPercent["step"]/count($datalist));
$averPercent["distance"]=floor($averPercent["distance"]/count($datalist));
$averPercent["calories"]=floor($averPercent["calories"]/count($datalist));
$averPercent["sleep"]=floor($averPercent["sleep"]/count($datalist));


//------get alert----------
$sql="SELECT alertdate,alerttype,alertmark FROM alertlist where sid=? and DATE_FORMAT(alertdate,'%Y-%m-%d')>='$fromdate' and DATE_FORMAT(alertdate,'%Y-%m-%d')<='$enddate' and delmark=0 order by alertdate desc limit 0,1";

//echo $sql;

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处

for($i=0;$i<count($datalist);$i++){
	$stmt->bind_param("s", $datalist[$i]['scode']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($alertdate,$alerttype,$alertmark);
	if($stmt->fetch()){
		$datalist[$i]["alert"] = array('time'=>date('H:i:s',strtotime($alertdate)) ,'date'=>date('Y-m-d',strtotime($alertdate)) ,'type'=>$alertmark,'describe'=>$alerttype);
	}else{
        $datalist[$i]["alert"] = array('info'=>'none');
	}
}


//-----get station-------------------
$sql="SELECT totime,position,sdate FROM sensorstation where sensorid=? and sdate>='$fromdate'  and sdate<='$enddate' and adjtype=0 order by sdate,totime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //

for($i=0;$i<count($datalist);$i++){
	//echo "SELECT totime,position,sdate FROM sensorstation where sensorid=" . $datalist[$i]['scode'] . " and sdate>='$fromdate'  and sdate<='$enddate' and adjtype=0 order by sdate,totime";
	$stmt->bind_param("s", $datalist[$i]['scode']);

	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($totime,$position,$todate);
	while($stmt->fetch()){
		array_push($datalist[$i]["station"],array('totime'=>$totime ,'todate'=>$todate ,'position'=>$position,'station'=>$stationList[$position]));
	}
}



//$values = array_values($datalist);  
//print_r($values);  


echo json_encode(array('status'=>200,'peoplelist'=>$datalist,'peopleaverange'=>$averPercent,'ecode'=>$ecode));


?>