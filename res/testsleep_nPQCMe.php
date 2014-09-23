<?php
include "dbconnect.php";
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
calcsleeptime('2014-9-18',595);
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
	echo $sql;
	$result=mysql_query($sql,$conn);
	$row=mysql_fetch_array($result);
	if($row['manual']==0){
		//----------------------上床时间
		$sql="select detectedposition from  basedata_" . $ydatesort . " where sensorid=$scode  and  stime>='22:00:00'  order by stime limit 0,1";
		echo $sql;
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
			echo $sql;
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
			echo $sql;		
			if($row=mysql_fetch_array($result)){
				$fromtime=$ydatelong . " " . $row['stime'] ;	
			}else{
				//--------往后找不到默认22：01
				$fromtime=$ydatelong . " 22:00:00";
			}
		}
		echo "--". $fromtime. "--";
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
	echo "$ldate,$fdate,$ftime,$tdate,$ttime,$scode";
	//changesleeptime($ldate,$fdate,$ftime,$tdate,$ttime,$scode);
	
	//return array('totalsleep'=>$totalsleep,'deepsleep'=>$deepsleep);
}
?>