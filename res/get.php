<?php 
include "dbconnect.php";

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"type":"family","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-6-1","ecode":"GkwkYjVklmFFO6jC","source":"w"}';
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
/* ----

先把所有的id和本人的id放在一个数组中

随后读取这个id数组的所有固定信息（头像、昵称、和本人关系）

建立一个goal数组，保存dailyvalue，第1个数据存储小于本月1日的最后一个dailyvalue，随后读取本月1日开始到现在的所有dailyvalue，按照日期值存入相应数组中

从第二个数据开始判断数组，若value为空则设为上一个值

*/

$datalist=array();
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

/*先把所有的id和本人的id放在一个数组中

随后读取这个id数组的所有固定信息（头像、昵称、和本人关系）
*/
$memberList=array();

$sql=" select headimage,nickname FROM sensorinfo where id=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->bind_result($headimage,$nickname);
$stmt->fetch();
if ($type=="family"){
	array_push($memberList,array('scode'=> $scode,'relation'=>'Me','nickname'=>$nickname,'headimage'=>$headimage,'goalList'=>array(),'sum'=>array(),'percentage'=>array(),'station'=>array()));
}

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
	array_push($memberList,array('scode'=> $friendid,'relation'=>$relation,'nickname'=>$nickname,'headimage'=>$headimage,'goalList'=>array(),'sum'=>array(),'percentage'=>array(),'station'=>array()));
}
 


//------calc weekly date period.
$fromdate=getyear($dates)."-".getmonth($dates)."-1";
$fromweekid=date("w",strtotime($fromdate));

$fromdate=date('Y-m-d',strtotime("$fromdate -$fromweekid day"));
$enddate=$dates;

$dateList=array();
$valueNameList=array('calories','distance','step','sleep');
$valueList=array();
$tempdate=$fromdate;
while($tempdate<=$enddate){
	array_push($dateList,array('date'=> $tempdate,'weekid'=>date("w",strtotime($tempdate)),'dayid'=>date("d",strtotime($tempdate))));
	array_push($valueList,array('date'=> $tempdate,'weekid'=>date("w",strtotime($tempdate)),'calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0,'caloriestoken'=>0,'distancetoken'=>0,'steptoken'=>0,'sleeptoken'=>0));
	$tempdate=date('Y-m-d',strtotime("$tempdate 1 day"));
}

//--------判断3个时间起点-本月，本周，本日------
$startCurrentWeek=-1;
$startCurrentMonth=-1;
$startCurrentDay=count($dateList)-1;

for($i=count($dateList)-1;$i>=0;$i--){
	if($dateList[$i][weekid]==0 && $startCurrentWeek==-1){
		$startCurrentWeek=$i;
	}
	if($dateList[$i][dayid]==1 && $startCurrentMonth==-1){
		$startCurrentMonth=$i;
	}
}

//-------formate data value 增加一个dataList save data value, add in goalList to memberList to save date and value for this date-



for($i=0;$i<count($memberList);$i++){
	if($i==0){
		$idlist=$memberList[0][scode];
	}else{
		$idlist.="," . $memberList[$i][scode];
	}
	array_push($memberList[$i][goalList],$valueList);
}
//echo json_encode($dateList); 
//echo json_encode($memberList);  


function findIDfromList($id){
	global $memberList;
	for($i=0;$i<count($memberList);$i++){
		if($memberList[$i][scode]==$id){
			return $i;
		}
	}
	return -1;
}
function findDatefromList($date){
	global $dateList;
	for($i=0;$i<count($dateList);$i++){
		if($dateList[$i][date]==$date){
			return $i;
		}
	}
	return -1;
}


$sql="select *,totalcal as totalcalories,totalsteps as totalstep from dailyvalue where sensorid in ($idlist) and date>='$fromdate' and date<='$enddate'";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sid=findIDfromList($row['sensorid']);
	$did=findDatefromList($row['date']);
	for($k=0;$k<4;$k++){;
		$memberList[$sid][goalList][0][$did][$valueNameList[$k]]=$row[$valueNameList[$k].'goal'];
		$memberList[$sid][goalList][0][$did][$valueNameList[$k].'token']=$row['total' .$valueNameList[$k]];
	}
}

//-----------如果第一个值为0，需要从数据库中调取最近一次不为0的值赋值给第一个--------
for($i=0;$i<count($memberList);$i++){
	for($k=0;$k<4;$k++){
		if($memberList[$i][goalList][0][0][$valueNameList[$k]]==0){
			$sql="select " . $valueNameList[$k] . "goal from dailyvalue where sensorid=" . $memberList[$i][scode] . " and " . $valueNameList[$k] ."goal>0 and date<'$fromdate' order by date desc limit 0,1";
			
			$result=mysql_query($sql,$conn); 
			if($row=mysql_fetch_array($result)){
				$memberList[$i][goalList][0][0][$valueNameList[$k]]=$row[$valueNameList[$k] . 'goal'];
			}
			
		}
	}
}
//--------------从第一个开始顺序赋值-------

//echo "for month:" .$startCurrentMonth. "   for week:" .$startCurrentWeek . "   for day:" .$startCurrentDay ;


for($i=0;$i<count($memberList);$i++){
	$memberList[$i][sum][month]=array('calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0,'caloriestoken'=>0,'distancetoken'=>0,'steptoken'=>0,'sleeptoken'=>0);
	$memberList[$i][sum][week]=array('calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0,'caloriestoken'=>0,'distancetoken'=>0,'steptoken'=>0,'sleeptoken'=>0);
	$memberList[$i][sum][day]=array('calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0,'caloriestoken'=>0,'distancetoken'=>0,'steptoken'=>0,'sleeptoken'=>0);
	
	for($k=0;$k<4;$k++){
		for($j=0;$j<count($dateList);$j++){
			if($j>0 && $memberList[$i][goalList][0][$j][$valueNameList[$k]]==0){
				$memberList[$i][goalList][0][$j][$valueNameList[$k]]=$memberList[$i][goalList][0][$j-1][$valueNameList[$k]];
			}
			//-------求和
			if($j>=$startCurrentMonth){
				$memberList[$i][sum][month][$valueNameList[$k]]+=$memberList[$i][goalList][0][$j][$valueNameList[$k]];
				$memberList[$i][sum][month][$valueNameList[$k].'token']+=$memberList[$i][goalList][0][$j][$valueNameList[$k].'token'];
			}
			if($j>=$startCurrentWeek){
				$memberList[$i][sum][week][$valueNameList[$k]]+=$memberList[$i][goalList][0][$j][$valueNameList[$k]];
				$memberList[$i][sum][week][$valueNameList[$k].'token']+=$memberList[$i][goalList][0][$j][$valueNameList[$k].'token'];
			}
			if($j>=$startCurrentDay){
				
				$memberList[$i][sum][day][$valueNameList[$k]]+=$memberList[$i][goalList][0][$j][$valueNameList[$k]];
				$memberList[$i][sum][day][$valueNameList[$k].'token']+=$memberList[$i][goalList][0][$j][$valueNameList[$k].'token'];
				
			}
		}
	}
}

//-------------------计算本人目标完成百分比-------------------
$periodNameList=array('day','month','week');
$valueNameValue=array('calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0);
$outdata=array();

for($i=0;$i<count($memberList);$i++){
	$memberList[$i][percentage]=array("day"=>$valueNameValue,"month"=>$valueNameValue,"week"=>$valueNameValue);
	for($m=0;$m<3;$m++){
		for($k=0;$k<4;$k++){
			if($memberList[$i][sum][$periodNameList[$m]][$valueNameList[$k]]==0){
				$memberList[$i][percentage][$periodNameList[$m]][$valueNameList[$k]]=0;
			}else{
				
			$memberList[$i][percentage][$periodNameList[$m]][$valueNameList[$k]]=$memberList[$i][sum][$periodNameList[$m]][$valueNameList[$k].'token']/$memberList[$i][sum][$periodNameList[$m]][$valueNameList[$k]];
			}
		}
	}
	
	array_push($outdata,array('scode'=> $memberList[$i][scode],'relation'=>$memberList[$i][relation],'nickname'=>$memberList[$i][nickname],'headimage'=>$memberList[$i][headimage],'sum'=>$memberList[$i][sum],'percentage'=>$memberList[$i][percentage]));
	
}

echo json_encode($outdata);  
//echo json_encode(array('status'=>200,'peopleList'=>$datalist,'peopleAverange'=>$averPercent,'ecode'=>$ecode));

exit;
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
		$datalist[$i]["alert"] = array('time'=>date('H:i:s',strtotime($alertdate)) ,'type'=>$alertmark,'describe'=>$alerttype);
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


echo json_encode(array('status'=>200,'peopleList'=>$datalist,'peopleAverange'=>$averPercent,'ecode'=>$ecode));


?>