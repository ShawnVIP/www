<?php 
include "dbconnect.php";
//---------分钟转id不除以4
function timeToRealID($time){
	$min=explode(":", $time);
	return $min[0]*60+$min[1];
}
//---------id转分钟
function realIdToTime($time){
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour  : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.':0'.$min : $rndTime=$rndTime.":".$min;
	return  $rndTime;
}
$dates=array('2014-9-18');
buildSensorStation(595,$dates);
function buildSensorStation($scode,$dateList){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $conn;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

	$statusList=array();
	$ordList=array();
	for($i=0;$i<count($dateList);$i++){
		$tdatelong=date('Y-m-d',strtotime($dateList[$i] . " 1 day"));
		$ydatelong=date('Y-m-d',strtotime($dateList[$i] . " -1 day"));
		$ldate=date('Y-m-d',$dateList[$i]);
		$sdate=str_replace("-","",$ldate);
		$ydatesort=str_replace("-","",$ydatelong);
		$tdatesort=str_replace("-","",$tdatelong);
		

		$sql="delete from sensorstation where sensorid=$scode and sdate='" . $ldate. "' and adjtype=0";
		echo $sql;
		//$result=mysql_query($sql,$conn); 
		$statusList=array();
		for($k=0;$k<=1440;$k++){
			array_push($ordList,0);
			array_push($statusList,7);
		}
		
		//----------------------------分析标准数据，从当天的第一个数字到第二天第一数字--------------------
		
		$sql="SELECT detectedposition,concat('" . $ldate ." ',stime) as stime FROM basedata_" . $sdate . " where sensorid=$scode";
		$sql .=" union SELECT detectedposition,concat('" . $tdatelong ." ',stime) as stime FROM basedata_" . $tdatesort . " where sensorid=$scode and stime<'00:05:00'";
		$result=mysql_query($sql,$conn); 
		echo $sql;
		while ($row=mysql_fetch_array($result)){
			$detectedposition=$row['detectedposition'];
			if($detectedposition==2){$detectedposition=1;} //---1,2 都是睡眠模式------
			$stime=$row['stime'];
			$tmpdate=date("Y-m-d H:i:s",strtotime($stime));
			for($k=0;$k>-5;$k--){
				$newtime=date('H:i:s',strtotime("$tmpdate $k minute"));	
				$newday=date("Y-m-d",strtotime("$tmpdate $k minute"));	
				if($newday==$ldate){
					$statusList[timeToRealID($newtime)]=$detectedposition;
				}
				
			}
			
		}
		
		
		$olddata=-1;
		$ordList=array();
		$lasttime=1;
		for($j=2;$j<1440;$j++){
			if($statusList[$j] !=$statusList[$j-1]){
				array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	
				$lasttime=1;
			}else{
				$lasttime++;
			}
		}
		
		
		//----------
		
		if($statusList[$j-1] != 7){
			array_push($ordList, array('totime'=>realIdToTime($j-1),'position'=>$statusList[$j-1],'lasttime'=>$lasttime));	
		}
		//-----------处理单独1-------------
		$independ=0;
		for($i=0;$i<count($ordList);$i++){
			$independ=0;
			if($ordList[$i][position]==1 && $ordList[$i][lasttime]==5){
				
				$independ=1;
				
				switch ($i){
				case 0:
				 if($ordList[1][position] ==1){$independ=0;}
				
				  break;  
				case count($ordList)-1:
				  if($ordList[$i-1][position] ==1){$independ=0;}
				   
				  break;
				default:
				  if($ordList[$i-1][position] ==1 || $ordList[$i+1][position] ==1){$independ=0;}
				 
				}
				
				if($independ==1){$ordList[$i][position]=7;}
			}
		}
		//---------处理结束-----------------
		echo json_encode($ordList);
		exit;
		
		$sql="insert into sensorstation (sensorid,sdate,totime,position,adjtype,lasttime) values ($scode,'$ldate',?,?,0,?)";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql);
		for($k=0;$k<count($ordList);$k++){
			if($ordList[$k][position] !=-1){
				$stmt->bind_param("sss",$ordList[$k][totime],$ordList[$k][position],$ordList[$k][lasttime]);
				$stmt->execute();
			}
		}
		$stmt->close();
		
		//------------------update dailyvalue-------------------
		$sql="select sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance  from  basedata_" . $sdate . "  where sensorid=$scode";
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$row=mysql_fetch_array($result);
		$totalcal=$row['totalcal'];
		$totalsteps=$row['totalsteps'];
		$totaldistance=$row['totaldistance']/100000; //距离单位在sensor中是厘米
		$sql="update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance where sensorid=$scode and date='".$ldate. "'";
		$result=mysql_query($sql,$conn); 
	
		calcsleeptime($ldate,$scode);
		
	}

	$mysqli->close;	
}


function changesleeptime($ldate,$fdate,$ftime,$tdate,$ttime,$scode){
	global $conn;
	$ldate=date('Y-m-d',strtotime($ldate));
	$ydatelong=date('Y-m-d',strtotime($ldate . " -1 day"));
	
	$tdatesort=str_replace("-","",$ldate);
	$ydatesort=str_replace("-","",$ydatelong);
	
	$f=strtotime("$fdate $ftime");	
	$t=strtotime("$tdate $ttime");	
	$totalsleep=($t-$f)/60;
		
	$lightsleep=0;
	
	if($fdate != $sdate){//----------get yesterday data---------
		$sql="SELECT count(id) as lightsleepcounts FROM basedata_" . $ydatesort . " where sensorid=$scode and (move>0 or steps>0) and stime>='$ftime'";
		$result=mysql_query($sql,$conn);
		if($row=mysql_fetch_array($result)){
			$lightsleep +=$row['lightsleepcounts']*5;
		}
		$sql="SELECT count(id) as lightsleepcounts FROM basedata_" . $tdatesort . " where sensorid=$scode and (move>0 or steps>0) and stime<'$ttime'";
		//echo $sql;
		$result=mysql_query($sql,$conn);
		if($row=mysql_fetch_array($result)){
			$lightsleep +=$row['lightsleepcounts']*5;
		}
		
	}else{
		$sql="SELECT count(id) as lightsleepcounts FROM basedata_" . $tdatesort . " where sensorid=$scode and (move>0 or steps>0) and stime<'$ttime' and stime>='$ftime'";
		//echo $sql;
		$result=mysql_query($sql,$conn);
		if($row=mysql_fetch_array($result)){
			$lightsleep +=$row['lightsleepcounts']*5;
		}
		
	}

	$deepsleep=$totalsleep-$lightsleep;
	

	$sql="update dailyvalue set totalsleep=$totalsleep,deepsleep=$deepsleep where sensorid=$scode and date='".$ldate. "'";
	$result=mysql_query($sql,$conn); 
	
}

function calcsleeptime($ldate,$scode){
	global $conn;
	$ldate=date('Y-m-d',strtotime($ldate));
	$ydatelong=date('Y-m-d',strtotime($ldate . " -1 day"));
	
	$tdatesort=str_replace("-","",$ldate);
	$ydatesort=str_replace("-","",$ydatelong);
	/*
	新的一天开始，建立了dailyvalue data，睡眠时间定义为昨天22:00到今天的7：00


	sensor开始上传数据，随后判断数据，
	
	如果有人工保存的自定义上床时间和起床时间，则不做以下上床时间和起床时间判断。
		
	上床时间：（以下上床时间找22：00pm前后最靠前的第一个状态1，上限是昨天中午12：00整，这是UI显示的上限，如果返回为空，则以默认22：00pm为上床时间）
	如果昨天大于等于22点的第一个数据不是状态1或者2，那么就往后查询（22：05，22：10。。。）找到第一个1或者2，把这个时间作为起始时间覆盖掉初始定义的22：00
	如果昨天大于等于22点的第一个数据已经是状态1或者2，那么逆向往回查询（21：55，21：50.。。），找到第一个不是1或者2的时间，作为起始时间，覆盖掉初始定义的22：00
	起床时间：（以下起床时间找7：00am前后最靠前的第一个状态5或者6，下限是今天中午12：00整，这是UI显示的下限，如果返回为空，则以默认7：00am为起床时间）
	如果今天早上7点之后的第一个数据存在，且状态不是1或者2，则往回查询（6：55、6：50.。。），找到第一个1或者2，作为起床时间覆盖掉初始定义的7：00
	如果今天早上7点之后的第一个数据存在，且状态是1或者2，则往前查询（7：05、7：10），找到第一个不是1或者2，作为起床时间覆盖掉初始定义的7：00
	人工保存上床时间和起床时间会写入一个标志位。
	*/
	//----------------------------分析睡眠数据，从昨天中午12点到今天中午12点-------------------------
	$sql="select manual from sleepdata where sid=$scode and sdate='$ldate'";
	$result=mysql_query($sql,$conn);
	$row=mysql_fetch_array($result);
	if($row['manual']==0){
		//----------------------上床时间
		$sql="select detectedposition from  basedata_" . $ydatesort . " where sensorid=$scode  and  stime>='22:00:00'  order by stime limit 0,1";
		//echo $sql;
		$result=mysql_query($sql,$conn); 
		$founddata=0;
		$startstation=-1;
		if($row=mysql_fetch_array($result)){
			$startstation=$row['detectedposition'];
			$founddata=1;
		}
		if($startstation==1 || $startstation==2 || $founddata=0){
			//---------------往回查找	
				
			$sql="select stime from  basedata_" . $ydatesort . " where sensorid=$scode and (detectedposition>2 or detectedposition=0)  and  stime<'22:00:00' order by stime desc limit 0,1";
			$result=mysql_query($sql,$conn); 
			if($row=mysql_fetch_array($result)){
				$fromtime=date('Y-m-d H:i:s',strtotime($ydatelong . " " . $row['stime'] . " 5 minute"));	
			}else{
				//--------往回找不到默认22：01
				$fromtime=$ydatelong . " 22:00:00";
						
			}
		}else{
			//---------------往后查-----------
			
			$sql="select detectedposition from  basedata_" . $ydatesort . " where sensorid=$scode  and  stime>='22:00:00' and (detectedposition=1 or detectedposition=2)  order by stime limit 0,1";
			//echo $sql;		
			if($row=mysql_fetch_array($result)){
				$fromtime=$ydatelong . " " . $row['stime'] ;	
			}else{
				//--------往后找不到默认22：01
				$fromtime=$ydatelong . " 22:00:00";
			}
		}
			
		//-------------起床时间
		$sql="select detectedposition from  basedata_" . $tdatesort . " where sensorid=$scode  and  stime<='07:00:00' order by stime desc limit 0,1";
		$result=mysql_query($sql,$conn); 
		$founddata=0;
		$startstation=-1;
		if($row=mysql_fetch_array($result)){
			$startstation=$row['detectedposition'];
		}
		if($startstation ==5 || $startstation ==6 ){
			//---------------往回查找	
			
			$sql="select stime from  basedata_" . $tdatesort . " where sensorid=$scode and (detectedposition<5 or detectedposition>6)  and  stime<='07:00:00' order by stime desc limit 0,1";
			$result=mysql_query($sql,$conn); 
			if($row=mysql_fetch_array($result)){
				$totime=date('Y-m-d H:i:s',strtotime($ldate . " " . $row['stime'] . " 5 minute"));	
				$founddata=1;
			}
		}
		if($founddata==0){
				//---------------往后查-----------
				
			$sql="select stime from  basedata_" . $tdatesort . " where sensorid=$scode  and stime>='07:00:00' and  stime<='12:00:00' and (detectedposition=5 or detectedposition=6)  order by stime limit 0,1";	
			$result=mysql_query($sql,$conn); 
			if($row=mysql_fetch_array($result)){
				$totime=$ldate . " " . $row['stime'];	
			}else{
				//--------往后找不到默认22：01
				$totime=$ldate ." 07:00:00";
			}
		}
	
		$ftime=date('H:i:s',strtotime($fromtime));	
		$fdate=date("Y-m-d",strtotime($fromtime));	
		$ttime=date('H:i:s',strtotime($totime));	
		$tdate=date("Y-m-d",strtotime($totime));	
			
			
		$sql="select * from sleepdata where sid=$scode and sdate='$ldate'";
		$result=mysql_query($sql,$conn); 
		
		if($row=mysql_fetch_array($result)){
			$sql="update sleepdata set fdate='$fdate', ftime='$ftime', tdate='$tdate', ttime='$ttime' where sid=$scode and sdate='$ldate'";

		}else{
			$sql="insert into  sleepdata (fdate,ftime,tdate,ttime,sid,sdate) value ('$fdate','$ftime', '$tdate','$ttime',$scode,'$ldate')";

		} 
		$result=mysql_query($sql,$conn); 
		
	}else{
		$fdate=$row['fdate'];
		$ftime=$row['ftime'];
		$tdate=$row['tdate'];
		$ttime=$row['ttime'];
	}
		
	changesleeptime($ldate,$fdate,$ftime,$tdate,$ttime,$scode);
	
	//return array('totalsleep'=>$totalsleep,'deepsleep'=>$deepsleep);
}
?>