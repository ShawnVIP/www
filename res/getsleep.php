<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);

$bmr=0;
$tmpdate=explode("T", $dates); 
$moment="24:00:00";
$today=0;


$checkdate=date("Y-m-d",strtotime($tmpdate[0]));
$currentdate=date("Y-m-d",strtotime($cdate));
if($checkdate==$currentdate){
	$today=1;
	$moment=date("H:i:s",strtotime($cdate));
}

function checkNull($val){
	if (is_null($val)){
		return 0;
	}else{
		return $val;
	}
}

$reqdate=date("Y-m-d",strtotime($tmpdate[0]));
//echo $reqdate;
$datestr=str_replace("-","",$reqdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

//------------------获�人工设置的sleep时间-----------------------
$sql="select fdate,ftime,tdate,ttime from sleepdata where sid=? and sdate=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $scode,$reqdate);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $fdate,$ftime,$tdate,$ttime);

if(!$stmt->fetch()){
	$fdate=date('Y-m-d',strtotime("$reqdate -1 day"));
	$ftime="22:00:00";
	$tdate=$reqdate;
	$ttime="07:00:00";
	$sql="insert into sleepdata (sid,ftime,fdate,ttime,tdate,sdate) values (?,?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssss",$scode, $ftime,$fdate,$ttime,$tdate,$reqdate);
	$stmt->execute();
	$stmt->close();
	
}


$moveList=array();

$outlist=array();
//----------预设sleep值,从�一天中�12点到当天中�12点--------------


//------开始查询
$lastdatestr=str_replace("-","",$fdate);

/*
$sql="select id,stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=? and stime>='$ftime' union select id,stime,move,sleepmode from basedata_" . $datestr . " where sensorid=? and stime<='$ttime' order by stime";
echo "select id,stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=$scode and stime>='$ftime' union select id,stime,move,sleepmode from basedata_" . $datestr . " where sensorid=$scode and stime<='$ttime'";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $scode,$scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(  $id,$stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	
	//array_push($moveList,array('id'=>$id,'stime'=>$stime,'move'=>$move*$sleepmode));
	array_push($moveList,$id . "|" . $stime ."|" . $move);
}
echo json_encode($moveList);
*/
function timeToRealID($time){
	$min=explode(":", $time);
	return $min[0]*60+$min[1];
}

$sql="select stime,move,sleepmode from basedata_" .$lastdatestr . " where sensorid=? and stime>='$ftime' order by stime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	array_push($moveList,  timeToRealID($stime) ."|" . $move*$sleepmode);
	//array_push($moveList,  timeToRealID($stime)-720 ."|" . $stime ."|". $move);
}
$stmt->close();
$sql="select stime,move,sleepmode from basedata_" .$datestr . " where sensorid=? and stime<='$ttime' order by stime";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $stime,$move,$sleepmode);
//-----------save data----------------------------

while($stmt->fetch()){
	array_push($moveList,  timeToRealID($stime) ."|". $move*$sleepmode);
	//array_push($moveList,  720+timeToRealID($stime)."|" . $stime  ."|". $move);
}

$stmt->close();
$mysqli->close;	
$out=array('status'=>200,'mindate'=>date('Y-m-d',strtotime("$reqdate -1 day")),'fdate'=>$fdate,'ftime'=>$ftime,'tdate'=>$tdate,'ttime'=>$ttime,'ecode'=>$ecode,'data'=>$moveList);

echo json_encode($out);
?>

