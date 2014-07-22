

$(function(){
	$('#search').button({icons:{primary:"ui-icon-plusthick"}});
	$( "#search" ).click(function() {searchByEmail()});
	$('#changeTime').button({icons:{primary:"ui-icon-plusthick"}});
	$( "#changeTime" ).click(function() {getDailyData()});
});
function searchByEmail(){
	$('#alertinfo').html("search this email, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	//var outData={ucode:100,data:outList,sensorid:1};
	/*
	var newData=[];
	for(i=0;i<20;i++){
		newData.push(outList[i]);
	}
	*/
	var outData={email:$('#email').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getinfo.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			if(msg.status != 200){
				$('#alertinfo').html("Nothing found!");
				return;
			}
			info=msg.sensorList[0]
			$('#userid').text(info.userid);
			$('#sensorid').text(info.sensorid);
			$('#language').text(info.language);
			$('#power').text(info.power);
			$('#lastupdate').text(info.lastupdate);
			$('#nickname').text(info.nickname);
			$('#headimage').text(info.headimage);
			$('#headpic').attr("src","upload/"+info.headimage);
			$('#dob').text(info.dob);
			$('#unit').text(info.unit);
			$('#gender').text(info.gender);
			$('#updated').text(info.updated);
			$('#defaultgoal').text(info.defaultgoal);
			$('#fallalert').text(info.fallalert);
			$('#positionalert').text(info.positionalert);
			$('#para0').text(info.para0);
			$('#para1').text(info.para1);
			$('#para2').text(info.para2);
			$('#para3').text(info.para3);
			$('#para4').text(info.para4);
			$('#detailid').text(info.detailid);
			$('#usertype').text(info.usertype);
			$('#createdate').text(info.createdate);
			$('#timezone').text(info.timezone);
			$('#age').text(info.age);
			
			getMemberData();
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
	
}
function getMemberData(){
	$('#alertinfo').html("get member info, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getmember.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.myfriend
			$('#myFriendList').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].sdate+"</td><td>"+info[i].friendid+"</td><td>"+info[i].relation+"</td><td>"+info[i].guardian+"</td></tr>";
				$("#myFriendList").append(str);
				
			}
			info=msg.friendme
			$('#friendToMeList').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].sdate+"</td><td>"+info[i].sensorid+"</td><td>"+info[i].relation+"</td><td>"+info[i].guardian+"</td></tr>";
				$("#friendToMeList").append(str);
				
			}
			
			getDailyValue();
			
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}

function getDailyValue(){
	$('#alertinfo').html("search date list for this sensor, please wait...");
	var outData={sensorid:$('#sensorid').text()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getdaylist.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			$('#dateList').empty();
			info=msg.dateList;
			for(i=0;i<info.length;i++){
				var dayinfo=covertYMD(info[i].yearmonth,info[i].day);
				$("#dateList").prepend("<option value='"+dayinfo+"'>"+dayinfo+"</option>");
				
			}
			$( "#dialog-modal" ).dialog("close");
			getDailyData();
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
}
function getDailyData(){
	$('#alertinfo').html("get dailyvalue, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text(),date:$('#dateList').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getdailyvalue.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			if(msg.status != 200){
				$('#alertinfo').html("No dailyvalue for "+$('#dateList').val()+" found!");
				return;
			}
			info=msg.sensorList[0]
			$('#sensorAge').text(info.age);
			$('#updated').text(info.updated);
			$('#height').text(info.height);
			$('#weight').text(info.weight);
			$('#step').text(info.step);
			$('#stepwidth').text(info.stepwidth);
			$('#runningwidth').text(info.runningwidth);
			
			$('#bmi').text(info.bmi);
			$('#bmr').text(info.bmr);
			$('#stepgoal').text(info.stepgoal);
			$('#totalsteps').text(info.totalsteps);
			$('#caloriesgoal').text(info.caloriesgoal);
			$('#totalcal').text(info.totalcal);
			$('#distancegoal').text(info.distancegoal);
			$('#totaldistance').text(info.totaldistance);
			$('#sleepgoal').text(info.sleepgoal);
			$('#totalsleep').text(info.totalsleep);
			getAlertData();
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}

function getAlertData(){
	$('#alertinfo').html("get alertData, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text(),date:$('#dateList').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getalertdata.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.sensorList
			$('#alertTable').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].alertdate+"</td><td>"+info[i].alerttype+"</td><td>"+info[i].alertmark+"</td></tr>";
				$("#alertTable").append(str);
				
			}
			getUploadData();
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}


function getUploadData(){
	$('#alertinfo').html("get uploadData, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text(),date:covertYM($('#dateList').val())};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getuploaddata.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.sensorList
			$('#uploadDataTable').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].time+"</td>";
				str+="<td>"+info[i].calories+"</td>";
				str+="<td>"+info[i].steps+"</td>";
				str+="<td>"+info[i].distance+"</td>";
				str+="<td>"+info[i].move+"</td>";
				str+="<td>"+info[i].sleepmode+"</td>";
				str+="<td>"+info[i].angle+"</td>";
				str+="<td>"+info[i].maxspeed+"</td>";
				str+="<td>"+info[i].minspeed+"</td>";
				str+="<td>"+info[i].averagespeed+"</td>";
				str+="<td>"+info[i].detectedposition+"</td></tr>";
				$("#uploadDataTable").append(str);
				
			}
			getStationData();

			
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}
var stationList=new Array("ST","SL","SI","SIA","WA","RU","UN");
function getStationData(){
	$('#alertinfo').html("get sensor station, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text(),date:$('#dateList').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getstationdata.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.sensorList
			$('#stationTable').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td>"+info[i].totime+"</td>";
				str+="<td>"+info[i].position+"</td>";
				str+="<td>"+stationList[info[i].position]+"</td>";
				str+='<td><img  width="30" height="30" src="images/ex_'+stationList[info[i].position]+'.png"/></td>';
				str+="<td>"+info[i].lasttime+"</td></tr>";
				$("#stationTable").append(str);
				
			}
			
			getPercentData();
			
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}
var period=new Array("day","week","month");
function getPercentData(){
	$('#alertinfo').html("get sensor station, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={sensorid:$('#sensorid').text(),date:$('#dateList').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/admin_getpercentage.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			info=msg.memberlist
			$('#goalList').empty()
			$('#percentage').empty()
			for(i=0;i<info.length;i++){
				str="<tr><td colspan=14 >sensorid:"+info[i].scode+" relation:"+info[i].relation+" nickname:"+info[i].nickname+"</td></tr>";
				$("#goalList").append(str);
				str=" <tr><td >date</td> <td >week id</td><td >cal token</td><td>cal goal</td><td>cal per</td><td >dis token</td><td>dis goal</td>";
    			str+="<td>dis per</td><td >step token</td>    <td>step goal</td><td>dis per</td><td >sleep token</td><td>sleep goal</td><td>slp per</td></tr>";
				$("#goalList").append(str);
				
				str="<tr><td colspan=9 >sensorid:"+info[i].scode+" relation:"+info[i].relation+" nickname:"+info[i].nickname+"</td></tr>";
				$("#percentage").append(str);
				
				for(j=0;j<info[i].goallist.length;j++){
					var obj=info[i].goallist[j]
					str="<tr><td >"+obj.date+"</td> <td >"+obj.weekid+"</td>";
					str+="<td >"+obj.caloriestoken+"</td><td>"+obj.calories+"</td><td>"+obj.caloriesper+"</td>";
					str+="<td >"+obj.distancetoken+"</td><td>"+obj.distance+"</td><td>"+obj.distanceper+"</td>";
					str+="<td >"+obj.steptoken+"</td><td>"+obj.step+"</td><td>"+obj.stepper+"</td>";
					str+="<td >"+obj.sleeptoken+"</td><td>"+obj.sleep+"</td><td>"+obj.sleepper+"</td></tr>";
					$("#goalList").append(str);
				}
				obj=info[i].percentage
				for(j=0;j<period.length;j++){
					str='<tr><td  >summary by '+period[j]+':</td> <td  style="text-align: right" >claories</td><td>'+eval("obj."+period[j]+".calories")+'</td>';
					str+='<td  style="text-align: right" >distance</td><td>'+eval("obj."+period[j]+".distance")+'</td>';
					str+='<td  style="text-align: right" >step</td><td>'+eval("obj."+period[j]+".step")+'</td>';
					str+='<td  style="text-align: right" >sleep</td><td>'+eval("obj."+period[j]+".sleep")+'</td></tr>';
					$("#percentage").append(str);
				}
				
			}
			str="<tr><td colspan=9 >total summary</td></tr>";
			$("#percentage").append(str);
			obj=msg.summary
			for(j=0;j<period.length;j++){
				str='<tr><td  >summary by '+period[j]+':</td> <td  style="text-align: right" >claories</td><td>'+eval("obj."+period[j]+".calories")+'</td>';
				str+='<td  style="text-align: right" >distance</td><td>'+eval("obj."+period[j]+".distance")+'</td>';
				str+='<td  style="text-align: right" >step</td><td>'+eval("obj."+period[j]+".step")+'</td>';
				str+='<td  style="text-align: right" >sleep</td><td>'+eval("obj."+period[j]+".sleep")+'</td></tr>';
				$("#percentage").append(str);
			}
			getRelation();
			$( "#dialog-modal" ).dialog("close");
			
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}

function getRelation(){
	$('#alertinfo').html("get sensor station, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	
	var outData={lang:"CN"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/getrelation.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			obj=msg.outdata
			
			$('#relationList').empty()
			for(i=0;i<obj.length;i++){
				str='<tr><td  >'+obj[i].id+':</td> <td >'+obj[i].name+'</td><td>'+obj[i].mname+'</td><td>'+obj[i].fname+'</td></tr>';
				$("#relationList").append(str);
			}
			$( "#dialog-modal" ).dialog("close");
			
			
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}

function covertYMD(ym,d){
	var temp=ym.substring(0,4)+"-"+ym.substring(4,6)+"-";
	if(d<10){temp+="0"}
	temp+=Math.floor(d)
	return temp;
}
function covertYM(ymd){
	var temp=ymd.substring(0,4)+ymd.substring(5,7)+ymd.substring(8,10);
	return temp;
}
