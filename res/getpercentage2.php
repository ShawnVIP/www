<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"type":"family","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-6-3","ecode":"GkwkYjVklmFFO6jC","source":"w"}';
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
/*
l  0x00表示DONG放置在桌面上未佩戴，未佩戴，连续五分钟内(或者超过五分钟)设备没有任何动作，没有任何角度变化；
l  0x01表示DONG佩戴在身上，浅睡眠，当用户长按按键四秒后LED灯会全部点亮，进入睡眠模式；
l  0x02表示DONG佩戴在身上，深睡眠，在睡眠模式中根据用户的轻微动作来判断用户是进入浅睡眠还是深睡眠；
l  0x03表示 DONG佩戴在身上，端正坐姿，判断标准为步伐检测小于12步，Z轴与重力轴接近垂直，夹角在-90~-70度和70~90之间;
l  0x04表示 DONG佩戴在身上，非端正坐姿，判断标准为步伐检测小于12步，Z轴与重力轴夹角0-70，-70~-0度；
l  0x05表示走路，判断标准为五分钟区间内步伐超过12步，且平均速度小于6.4km/h
l  0x06表示跑步，判断标准为五分钟区间内步伐超过12步，且平均速度大于6.4km/h
HH的意思是深睡眠和浅睡眠不区分，都表示睡眠
*/
$sit=3;
$crook=4;


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

$sql=" select headimage,nickname FROM sensorinfo where id=$scode";

$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
$headimage=$row['headimage'];
$nickname=$row['nickname'];

array_push($memberList,array('scode'=> $scode,'relation'=>'Me','nickname'=>$nickname,'head'=>$headimage,'goalList'=>array(),'alertlist'=>array(),'percentage'=>array(),'sum'=>array()));

if($type=="friend"){
	$extInfo=" and a.relation =17";
}else{
	$extInfo=" and a.relation <>17";
}

//$sql="SELECT a.friendid, a.relation, b.nickname, b.headimage FROM familylist as a, sensorinfo as b WHERE a.sensorid=? and b.id=a.friendid  and a.delmark=0". $extInfo;
$sql="SELECT a.friendid, a.relation, b.nickname, b.headimage, c." . $lang . "_name as relname FROM familylist as a, sensorinfo as b ,relation as c WHERE a.relation=c.id and  a.sensorid=$scode and b.id=a.friendid  and a.delmark=0". $extInfo;


$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	array_push($memberList,array('scode'=> $row['friendid'],'relation'=>$row['relname'],'nickname'=>$row['nickname'],'head'=>$row['headimage'],'goalList'=>array(),'alertlist'=>array(),'percentage'=>array(),'sum'=>array(),'station'=>array()));
}
 


//------calc weekly date period.
$fromdate=getyear($dates)."-".getmonth($dates)."-1";
$fromweekid=date("w",strtotime($fromdate));

$fromdate=date('Y-m-d',strtotime("$fromdate -$fromweekid day"));
$enddate=$dates;

$dateList=array();
$valueNameList=array('calories','distance','step','sleep');




$valueList=array();
$dayList=array();
$tempdate=$fromdate;
while($tempdate<=$enddate){
	array_push($dateList,array('date'=> $tempdate,'weekid'=>date("w",strtotime($tempdate)),'dayid'=>date("d",strtotime($tempdate))));
	array_push($valueList,array('date'=> $tempdate,'weekid'=>date("w",strtotime($tempdate)),'calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0,'caloriestaken'=>0,'distancetaken'=>0,'steptaken'=>0,'sleeptaken'=>0,'caloriesper'=>0,'distanceper'=>0,'stepper'=>0,'sleepper'=>0,'sit'=>0,'crook'=>0));
	
	array_push($dayList,array('date'=> $tempdate,'alert'=>array()));
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
	//-----------添加空白警告信息----------------------
	array_push($memberList[$i][alertlist],$dayList);
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
	$date=date("Y-m-d",strtotime($date));
	
	for($i=0;$i<count($dateList);$i++){
		if($dateList[$i][date]==$date){
			return $i;
		}
	}
	return -1;
}


$sql="select *,totalcal as totalcalories,totalsteps as totalstep from dailyvalue where sensorid in ($idlist) and date>='$fromdate' and date<='$enddate'";

$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sid=findIDfromList($row['sensorid']);
	$did=findDatefromList($row['date']);
	for($k=0;$k<4;$k++){;
		$memberList[$sid][goalList][0][$did][$valueNameList[$k]]=(int)$row[$valueNameList[$k].'goal'];
		$memberList[$sid][goalList][0][$did][$valueNameList[$k].'taken']=(int)$row['total' .$valueNameList[$k]];
	}
}
//---------------------add in alert
$sql="select sid,alerttype,alertdate  from alertlist where sid in ($idlist) and alertdate>='$fromdate' and DATE_FORMAT(alertdate,'%Y-%m-%d')<='$enddate' and delmark=0";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sid=findIDfromList($row['sid']);
	$did=findDatefromList($row['alertdate']);
	
	array_push($memberList[$sid][alertlist][0][$did][alert],array('time'=> $row['alertdate'],'alertid'=>$row['alerttype']));
	
}
//---------------------add in position
/*
$sql="select sensorid,position,sdate,totime  from sensorstation where sensorid in ($idlist) and sdate>='$fromdate' and sdate<='$enddate' and delmark=0 order by sensorid,sdate,totime";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sid=findIDfromList($row['sensorid']);
	$did=findDatefromList($row['sdate']);
	
	array_push($memberList[$sid][alertlist][0][$did][position],array('time'=> $row['sdate'].' '.$row['totime'],'position'=>$row['position']));
	
}
*/



$sql="SELECT sum(lasttime) as lasttime,position,sensorid,sdate FROM sensorstation where sensorid in ($idlist) and sdate>='$fromdate' and sdate<='$enddate' and delmark=0 and (position=$sit or position=$crook)  group by sensorid,position,sdate";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	$sid=findIDfromList($row['sensorid']);
	$did=findDatefromList($row['sdate']);
	
	
	if($row['position']==$sit){
		$memberList[$sid][goalList][0][$did][sit]=(int)$row['lasttime'];
	}else{
		$memberList[$sid][goalList][0][$did][crook]=(int)$row['lasttime'];
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

$valueNameValue=array('calories'=>0,'distance'=>0,'step'=>0,'sleep'=>0, 'caloriesgoal'=>0,'distancegoal'=>0,'stepgoal'=>0,'sleepgoal'=>0,'caloriestaken'=>0,'distancetaken'=>0,'steptaken'=>0,'sleeptaken'=>0,'daynumber'=>0);


$summary=array('day'=> $valueNameValue,'week'=> $valueNameValue,'month'=> $valueNameValue);

$periodNameList=array('day','week','month');

for($i=0;$i<count($memberList);$i++){
	
	$memberList[$i][percentage]=array("day"=>$valueNameValue,"week"=>$valueNameValue,"month"=>$valueNameValue);

	for($k=0;$k<4;$k++){
		for($j=0;$j<count($dateList);$j++){
			if($j>0 && $memberList[$i][goalList][0][$j][$valueNameList[$k]]==0){
				$memberList[$i][goalList][0][$j][$valueNameList[$k]]=$memberList[$i][goalList][0][$j-1][$valueNameList[$k]];
			}
			//-------求和
			$value=$memberList[$i][goalList][0][$j][$valueNameList[$k].'taken'];
			$goal=$memberList[$i][goalList][0][$j][$valueNameList[$k]];
				
			if($goal==0){$percent=0;}else{$percent=$value/$goal;}
			if($percent>1){$percent=1;}
			
			$memberList[$i][goalList][0][$j][$valueNameList[$k].'per']=round($percent,5);	
			
			if($j>=$startCurrentMonth){
				$memberList[$i][percentage][month][$valueNameList[$k].'goal']+=$goal;
				$memberList[$i][percentage][month][$valueNameList[$k].'taken']+=$value;
				
				$memberList[$i][percentage][month][$valueNameList[$k]]+=$percent;
				if($k==0){$memberList[$i][percentage][month][daynumber]++;}
				
				$summary[month][$valueNameList[$k].'goal']+=$goal;
				$summary[month][$valueNameList[$k].'taken']+=$value;
				
			}
			if($j>=$startCurrentWeek){
				$memberList[$i][percentage][week][$valueNameList[$k].'goal']+=$goal;
				$memberList[$i][percentage][week][$valueNameList[$k].'taken']+=$value;
				$memberList[$i][percentage][week][$valueNameList[$k]]+=$percent;
				if($k==0){$memberList[$i][percentage][week][daynumber]++;}
				
				$summary[week][$valueNameList[$k].'goal']+=$goal;
				$summary[week][$valueNameList[$k].'taken']+=$value;
			}
			if($j>=$startCurrentDay){
				
				$memberList[$i][percentage][day][$valueNameList[$k].'goal']+=$goal;
				$memberList[$i][percentage][day][$valueNameList[$k].'taken']+=$value;
				$memberList[$i][percentage][day][$valueNameList[$k]]+=$percent;
				if($k==0){$memberList[$i][percentage][day][daynumber]++;}
				
				$summary[day][$valueNameList[$k].'goal']+=$goal;
				$summary[day][$valueNameList[$k].'taken']+=$value;
				
			}
		}
		
	}
}
//----------------addin alert and position-----------------


$outdata=array();
$addNameValue=array('alert'=>array(),'position'=>array('sit'=>0,'crook'=>0,'crookpercent'=>0));

for($i=0;$i<count($memberList);$i++){
	
	for($k=0;$k<4;$k++){
		for($j=0;$j<3;$j++){
			$temp=$memberList[$i][percentage][$periodNameList[$j]][$valueNameList[$k]]/$memberList[$i][percentage][$periodNameList[$j]][daynumber];
			$memberList[$i][percentage][$periodNameList[$j]][$valueNameList[$k]]=round($temp,5);
			

		}
	}
	$outputAddList=array("day"=>$addNameValue,"week"=>$addNameValue,"month"=>$addNameValue);
	
	for($j=0;$j<count($dateList);$j++){
		
		$alertnum=count($memberList[$i][alertlist][0][$j][alert]);
		
		if($j>=$startCurrentMonth){
			if($alertnum>0){
				for($k=0;$k<$alertnum;$k++){
					array_push($outputAddList[month][alert],$memberList[$i][alertlist][0][$j][alert][$k]);
				}
			}
			$outputAddList[month][position][sit]+=$memberList[$i][goalList][0][$j][sit];
			$outputAddList[month][position][crook]+=$memberList[$i][goalList][0][$j][crook];
		}
		if($j>=$startCurrentWeek){
			if($alertnum>0){
				for($k=0;$k<$alertnum;$k++){
					array_push($outputAddList[week][alert],$memberList[$i][alertlist][0][$j][alert][$k]);
				}
			}
			$outputAddList[week][position][sit]+=$memberList[$i][goalList][0][$j][sit];
			$outputAddList[week][position][crook]+=$memberList[$i][goalList][0][$j][crook];
		}
		if($j>=$startCurrentDay){
			if($alertnum>0){
				for($k=0;$k<$alertnum;$k++){
					array_push($outputAddList[day][alert],$memberList[$i][alertlist][0][$j][alert][$k]);
				}
			}
			$outputAddList[day][position][sit]+=$memberList[$i][goalList][0][$j][sit];
			$outputAddList[day][position][crook]+=$memberList[$i][goalList][0][$j][crook];
		}
		
	}
	for($j=0;$j<count($periodNameList);$j++){
		$v1=$outputAddList[$periodNameList[$j]][position][sit];
		$v2=$outputAddList[$periodNameList[$j]][position][crook];
		if($v1+$v2>0){
			$outputAddList[$periodNameList[$j]][position][crookpercent]=round($v2/($v1+$v2),3);
		}else{
			$outputAddList[$periodNameList[$j]][position][crookpercent]=0;
		}
	}
	array_push($outdata,array('scode'=> $memberList[$i][scode],'relation'=>$memberList[$i][relation],'nickname'=>$memberList[$i][nickname],'head'=>$memberList[$i][head],'percentage'=>$memberList[$i][percentage],'alert'=>$outputAddList));
	
}


for($j=0;$j<3;$j++){
	for($k=0;$k<4;$k++){
		for($i=0;$i<count($memberList);$i++){
			$summary[$periodNameList[$j]][$valueNameList[$k]]+=$memberList[$i][percentage][$periodNameList[$j]][$valueNameList[$k]];
		}
		$temp=	$summary[$periodNameList[$j]][$valueNameList[$k]]/count($memberList);
		$summary[$periodNameList[$j]][$valueNameList[$k]]=round($temp,5);
	}
}


	
//-------------------计算本人目标完成百分比-------------------
//echo json_encode($memberList);

echo json_encode(array('status'=>200,'peoplelist'=>$outdata,'peopleaverange'=>$summary,'ecode'=>$ecode));

?>