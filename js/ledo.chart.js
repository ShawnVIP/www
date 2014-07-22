// JavaScript Document
var cenx=600;
var ceny=200;

var bigsize=52;
var smallsize=40;
var itemNumber;
var r=60;
var dealys=100;
//var iconList=["DR","FA","IA","RU","SI","SIA","SIB","SL","ST","WA","UN"]
var iconPos=new Array();
var centName="FA";
var cenID="";

var iconList=new Array();

iconList.push({id:'ST',color:'#9d9d9d',cnname:"静止",enname:"Stand"});
iconList.push({id:'SL',color:'#27b1df',cnname:"睡眠",enname:"Sleep"});
iconList.push({id:'SI',color:'#6aba0d',cnname:"端坐",enname:"Sit"});
iconList.push({id:'SIA',color:'#f29806',cnname:"歪坐",enname:"Sitting"});
iconList.push({id:'WA',color:'#6aba0d',cnname:"步行",enname:"Walk"});
iconList.push({id:'RU',color:'#6aba0d',cnname:"跑步",enname:"Run"});
iconList.push({id:'UN',color:'#e0e0e0',cnname:"未知",enname:"Unknown"});


function getColorID(name){
	for(i=0;i<iconList.length;i++){
		if(iconList[i].id ==name){
			return iconList[i].color;
		}
	}
	return 'bfbfbf';
}

function getItemID(itemName){
	for(var i=0;i<iconList.length;i++){
		if (iconList[i].id==itemName){
			return i;
		}
	}
	return -1;
}

var currentShowType="";
	var myLedo = {
		chartWidth:864,colHeight:114,
		currentChart:'',mouseX:0,mouseY:0,paddingX:0,paddingY:0,
		dataList: new Array(),paddingLeft:0,itemWidth:0,showID:0,paddingTimeID:0,
		hourNumber:13,eachHourWidth:72,leftPadding:-23,startPos:11
	};
	var px,py;
	var eposition=new Array();
	function chartArea(){
	
		this.length=1;
		this.belongs="";
		this.data=new Array();
		this.color=new Array(); //---------三种状态颜色----------
		this.ecolor=new Array();
		this.tData=new Array(); //---------时间列表数组----------
		this.vData=new Array(); //---------数值列表数组----------
		this.revTData=new Array(); //---------反向数组，存储时间id对应的数据数组中中的编号
		this.pointList=new Array();
		this.fromTimeId=0;
		this.toTimeId=0;
		this.addNewDay=0;
		this.itemMainType='';
		this.itemLineType='';
		this.edata=new Array();
		this.deepSleep=0; //deepsleep minitues.
		this.falldata=new Array(); //---------跌倒提醒----------
		this.slpTimeLong=0;
		//this.itemType='bar','dot','dotline','dotcurv','barline','dotline'

	}
	chartArea.prototype.add =function (){
		//--------------建立辅助信息时间轴，分布用ecolor对应不同的颜色区分，先转换为288的id，再分别建立像素为4的DIV。长度从chartWidth中读取。绘制以id值取整数
		//------------------div添加在this.belongs+'_ebar'中。
		//convertTimetoID
		this.fromid="00:00:00";
		for(this.i=0;this.i<this.edata.length;this.i++){
			this.obj=this.edata[this.i];
			this.toid=this.obj.t;
			
			//---------------暂时不显示角度信息
			if(this.obj.i != -1){
				drawBox(this.i,this.belongs,this.fromid,this.obj.t,iconList[this.obj.i].color,iconList[this.obj.i].id);
			}
			this.fromid=this.toid;
		}
		
	};
	chartArea.prototype.addFall =function (){
		//--------------建立辅助信息时间轴，分布用ecolor对应不同的颜色区分，先转换为288的id，再分别建立像素为4的DIV。长度从chartWidth中读取。绘制以id值取整数
		//------------------div添加在this.belongs+'_ebar'中。
		//convertTimetoID
		
		for(this.i=0;this.i<this.falldata.length;this.i++){

			putFallIcon(this.i,this.belongs,this.falldata[this.i].date,this.falldata[this.i].type);

		}
		
	};
	function putFallIcon(id,belongs,falltime,alerttype){
		
		var sortFallTime=falltime.substr(11,5);
		var currentID=convertTimetoID(sortFallTime,2,1);
		$('<div class="ext_iconItem" id="'+belongs+'_iconFall'+id+'"><img src="../images/ex_FA.png" width="100%" height="100%" /></div>').appendTo($('#'+belongs+'_ebar'));
		$('#'+belongs+'_iconFall'+id).attr("iconID",id);
	
		$('#'+belongs+'_iconFall'+id).width(26);
		$('#'+belongs+'_iconFall'+id).height(26);
		$('#'+belongs+'_iconFall'+id).css("left",currentID*3-13);
		$('#'+belongs+'_iconFall'+id).css("top",-13);
		$('#'+belongs+'_iconFall'+id).bind("mouseover",{id:id,x:currentID*3-26,y:-26,w:52,h:52,time:falltime,type:alerttype},overFallPic);
		$('#'+belongs+'_iconFall'+id).bind("mouseout",{id:id,x:currentID*3-13,y:-13,w:26,h:26},outFallPic);
	
		
	}
	function overFallPic(event){
		var obj=$('#'+event.data.name);
		var floatname="#extInfoBox"
		$(floatname).css("left",event.data.x);
		//$(floatname).html(getText('s_status')+' '+getText('s_fall')+"<br>"+getText('s_time')+event.data.time+"  <br>info:"+event.data.type);
		
		$(floatname).html(getText('s_status')+' '+getText('s_fall')+"<br>"+getText('s_time')+event.data.time);
				
		$(floatname).css("background",'#F00');
		$(floatname).show();
		//alert("From:"+event.data.from+" To:"+event.data.to+" <br>angle:"+event.data.angle);
		$('#ACT_iconFall'+event.data.id).stop(false,true).animate({left:event.data.x,top:event.data.y,width:event.data.w,height:event.data.h},200);
		$('#ACT_iconFall'+event.data.id).css("z-index",100);
	}
	
	function outFallPic(event){
		var floatname="#extInfoBox"
		$(floatname).hide();
	
		$('#ACT_iconFall'+event.data.id).stop(false,true).animate({left:event.data.x,top:event.data.y,width:event.data.w,height:event.data.h},200);
		$('#ACT_iconFall'+event.data.id).css("z-index",90);
	}

	function drawBox(id,belongs,from,to,color,pic){
		/*
		anglestr=JSON.stringify(angle)
		if(angle.poor != undefined){
			anglestr=" poor:"+angle.poor.toFixed(2)+" good:"+angle.good.toFixed(2)+" fair:"+angle.fair.toFixed(2)
		}else{
			anglestr=""
		}
		*/
		
		var fromid=convertTimetoID(from,2,1);
		var toid=convertTimetoID(to,2,1);
		//alert(id+":"+belongs+" from:"+from+" to:"+to+" color:"+color+" pic:"+pic+" fromid:"+fromid+"  toid:"+toid);
		anglestr="temp no angle info";
		//anglestr=getInfo("s_nodata");
		//
		$('<div class="ext_actItem" id="'+belongs+'_actItem'+id+'"></div>').appendTo($('#'+belongs+'_ebar'));
		$('#'+belongs+'_actItem'+id).css("left",fromid*3);
		$('#'+belongs+'_actItem'+id).width((toid-fromid)*3);
		$('#'+belongs+'_actItem'+id).css("background",color);
		//$('#'+belongs+'_actItem'+id).attr("angle",JSON.stringify(angle))
		$('<div class="ext_iconItem" id="'+belongs+'_iconItem'+id+'"><img src="../images/ex_'+pic+'.png" width="100%" height="100%" /></div>').appendTo($('#'+belongs+'_ebar'));
		$('#'+belongs+'_iconItem'+id).attr("iconID",id);
		$('#'+belongs+'_iconItem'+id).attr("iconName",pic);
		$('#'+belongs+'_iconItem'+id).width(26);
		$('#'+belongs+'_iconItem'+id).height(26);
		$('#'+belongs+'_iconItem'+id).css("left",fromid*3-13);
		$('#'+belongs+'_iconItem'+id).css("top",-13);
		$('#'+belongs+'_iconItem'+id).bind("mouseover",{id:id,x:fromid*3-26,y:-26,w:52,h:52,from:from,to:to,angle:anglestr,name:belongs+'_iconItem'+id,belongs:belongs},overPic);
		$('#'+belongs+'_iconItem'+id).bind("mouseout",{id:id,x:fromid*3-13,y:-13,w:26,h:26,belongs:belongs},outPic);
		$('#'+belongs+'_iconItem'+id).bind("click",{id:id,cenx:fromid*3,ceny:0,belongs:belongs,from:from,to:to},changeID);
		eposition[id]={ox:fromid*3-13,oy:-13,dx:fromid*3-26,dy:-26};
	}
	var centItemID;
	var currentBelongs;
	var currentFrom,currentTo;
	function changeID(event){
		currentBelongs=event.data.belongs;
		
		$('#itemContainer').fadeIn();
		$('#extInfoBox').hide();
		cenx=event.data.cenx-13;
		ceny=event.data.ceny+87;
		//cenx=0
		//alert(cenx+"  "+ceny)
		//ceny=10
		//alert(event.data.name)
		centItemID=event.data.id;
		//alert(centItemID+"  "+'#'+currentBelongs+'_iconItem'+centItemID)
		centName=$('#'+currentBelongs+'_iconItem'+centItemID).attr("iconName");
		//alert($('#'+currentBelongs+'_iconItem'+centItemID).attr("id"))
		initIcons();
		putIcons();
		$('#itemContainer').css("left",cenx);
		$('#itemContainer').css("top",ceny);
		//save to database-------------
		
		
		
		ftime=event.data.from;
		ttime=event.data.to;
		//currentFrom=dateStr+" "+ftime.substring(0,2)+":"+ftime.substring(2,4)+":00"
		currentTo=dateStr+" "+ttime;

	}
	
	function overPic(event){
		var obj=$('#'+event.data.name);
		var floatName='#extInfoBox'
		
		$(floatName).css("left",event.data.x);
		//$('#extInfoBox').html(getText('s_status')+obj.attr("iconName")+"<br>"+getText('s_from')+event.data.from+"  "+getText('s_to')+event.data.to+" <br>"+getText('s_angle')+event.data.angle);
		var iconShowName="";
		for(var i=0;i<iconList.length;i++){
			if(obj.attr("iconName")==iconList[i].id){
				iconShowName=eval("iconList["+i+"]."+LANG+"name");
			}
		}
		$(floatName).html(getText('s_status')+iconShowName+"<br>"+getText('s_from')+event.data.from+"  "+getText('s_to')+event.data.to+" <br>"+getText('s_angle')+getText("s_nodata"));

		
		$(floatName).css("background",getColorID(obj.attr("iconName")));
		$(floatName).show();
		//alert("From:"+event.data.from+" To:"+event.data.to+" <br>angle:"+event.data.angle);
		$('#ACT_iconItem'+event.data.id).stop(false,true).animate({left:event.data.x,top:event.data.y,width:event.data.w,height:event.data.h},200);
		$('#ACT_iconItem'+event.data.id).css("z-index",100);
	}
	
	function outPic(event){
		$('#extInfoBox').hide();
	
		$('#ACT_iconItem'+event.data.id).stop(false,true).animate({left:event.data.x,top:event.data.y,width:event.data.w,height:event.data.h},200);
		$('#ACT_iconItem'+event.data.id).css("z-index",90);
	}


function initIcons(){
	areaSize=smallsize+r*2;
	centID=getItemID(centName);
	//alert(centName+"   "+centID)
	itemNumber=iconList.length;
	iconPos=[];
	iconPos.push({iconID:centID,iconName:centName,size:bigsize,x:(areaSize-bigsize)/2,y:(areaSize-bigsize)/2,cmode:1,ox:(areaSize-smallsize)/2,oy:(areaSize-smallsize)/2});
	var j=0;
	for(i=0;i<itemNumber;i++){
		if (i != centID){
			var a=(j/(itemNumber-1)-0.25)*2*Math.PI;
			var x=areaSize/2+r*Math.cos(a)-smallsize/2;
			var y=areaSize/2+r*Math.sin(a)-smallsize/2;
			iconPos.push({iconID:i,iconName:iconList[i].id,size:smallsize,x:x,y:y,cmode:0,ox:(areaSize-smallsize)/2,oy:(areaSize-smallsize)/2});
			j++;
			
		}
		
		
	}
	//alert(JSON.stringify(iconPos));
	centID=0;
	
}

function putIcons(){
	$('#itemContainer div').each(function(){$(this).remove();});
	for(var i=0;i<itemNumber;i++){
		childDiv=$('<div class="divPos" id="iconItem'+i+'"><img src="../images/ex_'+iconPos[i].iconName+'.png" width="100%" height="100%"/></div>');
		childDiv.appendTo($('#itemContainer'));
		var obj=$('#iconItem'+i);
		obj.attr("itemID",i);
		//obj.hide();
		if(i==0){
			obj.css("z-index",50);
		}else{
			obj.css("z-index",45);
			obj.addClass("cur");
		}
		obj.css("left",iconPos[i].ox);
		obj.css("top",iconPos[i].oy);
		obj.width(smallsize);
		obj.height(smallsize);
		$(obj).oneTime(i*2+'ds',function(){ 
			//$(this).fadeIn();
			var cid=$(this).attr("itemID");
			$(this).animate({top:iconPos[cid].y,left:iconPos[cid].x,width:iconPos[cid].size,height:iconPos[cid].size});
		});
		obj.bind("click",{itemid:i},switchItem);
	}
	
	
}

function switchItem(event){
		nid=event.data.itemid;
		
		if(nid==centID){return;}
		
		//-----交换nid 和 centID-----
		//iconPos 数组里的 iconID对应位置和大小信息交换，然后定位移动
		//alert("nid"+nid+"  "+iconPos[nid].iconName);
		$('#'+currentBelongs+'_iconItem'+centItemID).attr("iconName",iconPos[nid].iconName);
		$('#'+currentBelongs+'_iconItem'+centItemID).html('<img src="../images/ex_'+iconPos[nid].iconName+'.png" width="100%" height="100%" />');
		
		
		
		$("#iconItem"+centID).animate({top:iconPos[nid].y,left:iconPos[nid].x,width:iconPos[nid].size,height:iconPos[nid].size});
		$("#iconItem"+nid).animate({top:iconPos[centID].y,left:iconPos[centID].x,width:iconPos[centID].size,height:iconPos[centID].size});
		
		
		tempFrom=iconPos[nid];
		tempTo=iconPos[centID];
		fx=tempFrom.x;
		fy=tempFrom.y;
		fox=tempFrom.ox;
		foy=tempFrom.oy;
		fsize=tempFrom.size;
		
		iconPos[nid].x=tempTo.x;
		iconPos[nid].y=tempTo.y;
		iconPos[nid].ox=tempTo.ox;
		iconPos[nid].oy=tempTo.oy;
		iconPos[nid].size=tempTo.size;
		
		iconPos[centID].x=fx;
		iconPos[centID].y=fy;
		iconPos[centID].ox=fox;
		iconPos[centID].oy=foy;
		iconPos[centID].size=fsize;
		

		//$("#iconItem"+nid).animate({top:iconPos[nid].y,left:iconPos[nid].x,width:iconPos[nid].size,height:iconPos[nid].size})
		//$("#iconItem"+centID).animate({top:iconPos[centID].y,left:iconPos[centID].x,width:iconPos[centID].size,height:iconPos[centID].size})
		$("#iconItem"+nid).css("z-index",50);
		$("#iconItem"+centID).css("z-index",45);
		$("#iconItem"+nid).removeClass("cur");
		$("#iconItem"+centID).addClass("cur");
		
		centID=nid;
		back_ecode=$.cookie('back_ecode');
		var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",etime:currentTo,actid:nid};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/saveicon.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
        	}
    	});
		
}


	
	
	
	function endpos(event){
		var catName=event.data.catName;
		$('#'+catName).unbind("mousemove");
		$('body').stopTime();   
		var nobj=$('#'+myLedo.currentChart+"_label");
		nobj.fadeOut();
	}
	chartArea.prototype.drawBaseLine=function(){
		$('#'+this.belongs+" div").each(function(){$('#'+this.id).remove();});
		$('<div class="G_time" id="'+this.belongs+'_time"></div>').appendTo($('#'+this.belongs));
		//-------draw main axis line----------
		//this.leftPadding=(myLedo.chartWidth-288*5)/2+10;
		
		$('#'+this.belongs+'_time').css("left",3);
		
		this.k=0;
		this.dw=72;
		for(this.i=0;this.i<=12;this.i++){
			//$('#'+this.belongs+'_leftLabel').html(this.i);
			this.childDiv=$('<div id='+this.belongs+'_hourLabel'+this.i+'>12pm</div>');
			this.childDiv.css("left",this.dw*this.i-20);
			this.childDiv.appendTo($('#'+this.belongs+'_time'));
		}

		
		
	};
	chartArea.prototype.setupHour=function(){
		
		for(this.i=0;this.i<=12;this.i++){
			this.currentHour=convertHourNumber(this.beginHour+this.i*2);
			$('#'+this.belongs+'_hourLabel'+this.i).html(this.currentHour);
		}
		//----------添加浮标----------------
		this.childDiv=$('<div class="G_floatBarLabel templetes" id="'+this.belongs+'_label"><div id="'+this.belongs+'_labelLeftText" class="G_labelLeftText G_unselect"></div><div id="'+this.belongs+'_labelRightText" class="G_labelRightText G_unselect"></div></div>');
	 	this.childDiv.appendTo($('#'+this.belongs));
		
	};
	chartArea.prototype.putData=function(){
		this.fromTimeId=this.beginHour*12;
		this.maxHeight=100;
		this.dw=3;
		
		//----------赋值如数组---------------------
		this.deepSleep=0;
		for(this.i=0;this.i<this.data.length;this.i++){

			this.tmpdata=(this.data[this.i]).split('|');
			this.id=Number(this.tmpdata[0]);
			this.value=Number(this.tmpdata[1]);
			if(this.maxHeight<Number(this.tmpdata[1])){this.maxHeight=Number(this.tmpdata[1]);}

			this.sid=this.id;
	
			this.gid=Math.floor(this.sid/5)-this.fromTimeId;
			if(this.gid<0){this.gid+=288;}
			this.colorType=2;
			if(this.value==0){this.colorType=1;}
			this.vData[this.i]=({id:this.gid,left:this.gid*this.dw+10,timeInfo:convertIDtoTime(this.id,2),colorType:this.colorType,valueData:this.value,itemHeight:0});
		}
		//-------------根据maxheight赋值itemheight--------------------
		for(this.i=0;this.i<this.data.length;this.i++){
			this.tmpdata=(this.data[this.i]).split('|');
			this.id=Number(this.tmpdata[0]);
			this.value=Number(this.tmpdata[1]);
			
			this.itemHeight=Math.ceil(this.vData[this.i].valueData*(myLedo.colHeight-10)/this.maxHeight);
			if(this.value==0){this.deepSleep+=5;}
			this.vData[this.i].itemHeight=this.itemHeight+5;
			
		}
		//this.vData=removeZero(this.vData,"itemHeight",0)
		//---------绘图--------------------
		$('#'+this.belongs+'_can').clearCanvas();
		$('#'+this.belongs+'_can').drawLine({
  			strokeStyle: "#bfbfbf",  strokeWidth: 1,
  			x1: myLedo.startPos, y1: myLedo.colHeight,
  			x2: (myLedo.hourNumber-1)*myLedo.eachHourWidth+myLedo.startPos, y2: myLedo.colHeight,
 
		});
		for(this.i=this.distHour*12;this.i<=this.distHour*12+this.slpTimeLong;this.i++){
			this.itemColor=this.color[2];
			this.itemLeft=this.i*this.dw+10;
			this.itemHeight=2;
			$('#'+this.belongs+'_can').drawRect({fillStyle: this.itemColor, x: this.itemLeft, y: myLedo.colHeight-this.itemHeight, width: this.dw-1, height: this.itemHeight, strokeWidth: 0, fromCenter: false});
		}
		for(this.i=0;this.i<this.vData.length;this.i++){
			
			this.itemColor=this.color[this.vData[this.i].colorType];
			this.itemLeft=this.vData[this.i].left;
			this.itemHeight=this.vData[this.i].itemHeight+2;
			$('#'+this.belongs+'_can').drawRect({fillStyle: this.itemColor, x: this.itemLeft, y: myLedo.colHeight-this.itemHeight, width: this.dw-1, height: this.itemHeight, strokeWidth: 0, fromCenter: false});
			
		}
		
		$('#'+this.belongs+'_can').bind("mouseenter",{catName:this.belongs,vData:this.vData,itemWidth:this.dw,paddingLeft:this.leftPadding,paddingTimeID:this.paddingTimeID},beginpos);
		$('#'+this.belongs+'_can').bind("mouseleave",{catName:this.belongs},endpos);	
		
		//$('#'+this.belongs+'_can').bind("mouseenter",{catName:this.belongs,vData:this.vData,itemWidth:this.dw,paddingLeft:this.leftPadding,paddingTimeID:this.paddingTimeID},beginpos);
		//$('#'+this.belongs+'_can').bind("mouseleave",{catName:this.belongs},endpos);	
		//alert(this.deepSleep);
		
	};
	chartArea.prototype.init=function(){

		//------------删除除绘图区"_can"外所有子元素------------------------
		
		$('#'+this.belongs+" div").each(function(){$('#'+this.id).remove();});
		
		var ctx = document.getElementById(this.belongs+'_can').getContext('2d');
		//alert("remove all");
		//ctx.clearRect(0,0,myLedo.chartWidth,myLedo.colHeight);
		ctx.clearRect(0,0,890,114);
		//alert("remove finished");
		this.tData=[];
		this.vData=[];
		if(this.belongs=="ACT"){
			$('<div class="G_eContent" id="'+this.belongs+'_eContent"></div>').appendTo($('#'+this.belongs));
			$('<div class="G_ebar" id="'+this.belongs+'_ebar"></div>').appendTo($('#'+this.belongs+'_eContent'));
			$('#'+this.belongs+'_ebar').width(myLedo.chartWidth);
			
		}
		$('<div class="G_time" id="'+this.belongs+'_time"></div>').appendTo($('#'+this.belongs));
		//if(this.data.length==0){
			this.fromTimeId=0;
			this.toTimeId=288;
			this.paddingTimeID=0;
		//}else{
			//this.fromTimeId=convertHourToID(this.data[0].substring(0,2),0)
			//this.toTimeId=convertHourToID(this.data[this.data.length-1].substring(0,2),1)
			
			//alert("from: "+this.data[0]+"   "+this.data[0].substring(0,2)+"   "+this.fromTimeId+"  to:"+this.data[this.data.length-1]+"   "+this.data[this.data.length-1].substring(0,2)+"  "+this.toTimeId);
			//-------------起始时间的偏移值---------------
			//this.paddingTimeID=convertTimetoID(this.data[0],0,1)-this.fromTimeId
		//}
		//------------------添加数据轴-----------------------
		this.addNewDay=0;
		if(this.toTimeId<this.fromTimeId){this.toTimeId+=288;this.addNewDay=1;}
		
		//this.itemNumber=this.toTimeId-this.fromTimeId
		this.itemNumber=288;
		this.dw=Math.floor(myLedo.chartWidth/this.itemNumber);
		if(this.dw>5){this.dw=5;}
		//---------初始化基础数据条-----------------------
		//$('#'+this.belongs+'_leftLabel').html("from:"+this.fromTimeId+" to:"+this.toTimeId+ " itemNumber:"+this.itemNumber+" width:"+this.dw);
		
		for(this.i=0;this.i<=this.itemNumber;this.i++){
			this.tData.push({id:this.i+this.fromTimeId,data:convertIDtoTime((this.i+this.fromTimeId)*5,3)});
			this.vData.push({id:this.i,timeInfo:"",timeID:0,colorType:0,valueData:0,itemHeight:0});
		}
		//$('#'+this.belongs+'_leftLabel').html("tData length:"+this.tData.length+" data:"+this.data.length);
		//$('#'+this.belongs+'_leftLabel').html("itemnumber:"+this.itemNumber+" dw:"+this.dw);
		//----------添加浮标----------------
		this.childDiv=$('<div class="G_floatBarLabel templetes" id="'+this.belongs+'_label"><div id="'+this.belongs+'_labelLeftText" class="G_labelLeftText G_unselect"></div><div id="'+this.belongs+'_labelRightText" class="G_labelRightText G_unselect"></div></div>');
	 	this.childDiv.appendTo($('#'+this.belongs));
		this.strs="";
		//-----------------cal和sleep【默认赋值30
		if(this.belongs=="ACT" || this.belongs=="SLP"){
			this.maxHeight=30;
		}else{
			this.maxHeight=0;
		}
		//this.list=""
		//-----------第一次赋值
		//alert(JSON.stringify(this.data))
		for(this.i=0;this.i<this.data.length;this.i++){
			//$('#'+this.belongs+'_leftLabel').html("i:"+this.i+" data:"+this.data[this.i]+"itemNumber:"+this.itemNumber+ "len:"+this.data.length);
			
			this.tmpdata=(this.data[this.i]).split('|');
			this.id=convertTimetoID(this.tmpdata[0],0,0);
			if(this.maxHeight<Number(this.tmpdata[1])){this.maxHeight=Number(this.tmpdata[1]);}
			
			//this.list+="id:"+this.i+" date:"+this.tmpdata[0]+" value:"+Number(this.tmpdata[1])+"max:"+this.maxHeight+"\n";
			//-------把时间赋值到数组对应ID中去
			//------------当间隔超过1天时，当数据小于起始时间时，数据时间+288
			this.sid=this.id;
			if(this.i>0 && this.addNewDay==1 && this.id<this.fromTimeId*5){this.sid=this.id+288*5;}
			this.gid=Math.floor(this.sid/5)-this.fromTimeId;
			//alert(this.i+"   "+JSON.stringify(this.data[this.i])+ "gid"+this.gid);
			this.vData[this.gid]=({id:this.gid,left:this.gid*this.dw,timeInfo:convertIDtoTime(this.id,2),colorType:Number(this.tmpdata[2]),valueData:Number(this.tmpdata[1]),itemHeight:0});
			//this.strs+="i:"+this.i+" time"+ this.tmpdata[0]+" calcID:"+ this.id+"  calcTid"+(Math.floor(this.id/5)-this.fromTimeId)+" height:"+Number(this.tmpdata[1])+"<br>"
		}
		
		/*
		if(this.belongs="ACT"){
			
			alert(this.list)
			alert("max:"+this.maxHeight);
		}
		*/
		//$('#'+this.belongs+'_leftLabel').html(this.strs);
		//---------------------调整左边偏移值---------------
		
		
		this.leftPadding=(myLedo.chartWidth-this.itemNumber*this.dw)/2+13;
		
		//myLedo.paddingLeft=this.leftPadding;
		//myLedo.itemWidth=this.dw;
		$('#'+this.belongs+'_time').css("left",this.leftPadding-10);
		//-----------------添加时间轴------------------
		//-----------------判断时间多久显示一次
		this.timeperiod=Math.ceil(6/this.dw)*12;

		this.k=0;
		for(this.i=0;this.i<=this.itemNumber;this.i+=this.timeperiod){
			//$('#'+this.belongs+'_leftLabel').html(this.i);
			this.childDiv=$('<div>'+this.tData[this.i].data+'</div>');
			this.childDiv.width(72);
			this.childDiv.css("left",this.dw*this.i-20);
			this.childDiv.appendTo($('#'+this.belongs+'_time'));
		}
		
		//----------赋值----------------------------------
		if(this.belongs=="TMP"){this.maxHeight*=1.5;}
		for(this.i=0;this.i<=this.itemNumber;this.i++){

			this.itemColor=this.color[this.vData[this.i].colorType];
			//this.itemLeft=this.i*this.dw;
			this.itemHeight=Math.ceil(this.vData[this.i].valueData*(myLedo.colHeight-10)/this.maxHeight);
			
			//alert("value:"+this.vData[this.i].valueData+"   baseHeight:"+(myLedo.colHeight-10)+"  maxHeight:"+this.maxHeight+"  thisHeight:"+this.itemHeight)
			//this.strs+="i:"+this.i+" height:"+this.itemHeight+"<br>"
			//alert(this.vData[this.i].valueData+"   "+this.itemHeight);
			this.vData[this.i].itemHeight=this.itemHeight;
		}
		//--------------删除为0的元素---------
		this.vData=removeZero(this.vData,"itemHeight",0);
		//---------绘图--------------------
		
		for(this.i=0;this.i<288;this.i++){
			this.itemColor=this.color[1];
			this.itemLeft=this.i*this.dw+this.leftPadding;
			this.itemHeight=2;
			$('#'+this.belongs+'_can').drawRect({fillStyle: this.itemColor, x: this.itemLeft, y: myLedo.colHeight-this.itemHeight, width: this.dw-1, height: this.itemHeight, strokeWidth: 0, fromCenter: false});
		}
		
		
		for(this.i=0;this.i<this.vData.length;this.i++){
			this.itemColor=this.color[this.vData[this.i].colorType];
			this.itemLeft=this.vData[this.i].left+this.leftPadding;
			this.itemHeight=Math.ceil(this.vData[this.i].valueData*(myLedo.colHeight-10)/this.maxHeight)+2;
			
			if(this.itemMainType=='bar'){ //------------柱状图
				$('#'+this.belongs+'_can').drawRect({fillStyle: this.itemColor, x: this.itemLeft, y: myLedo.colHeight-this.itemHeight, width: this.dw-1, height: this.itemHeight, strokeWidth: 0, fromCenter: false});
			}
			if(this.itemMainType=='dot'){
				$('#'+this.belongs+'_can').drawArc({ x: this.itemLeft, y: myLedo.colHeight-this.itemHeight,  radius: Math.floor(this.dw/2)+1,  start: 0, end: 359,  closed: true, fillStyle:this.itemColor,strokeWidth: 0});
			}
			/*
			if(this.itemType=='dotline'){
				$('#'+this.belongs+'_can').drawArc({ x: this.itemLeft, y: myLedo.colHeight-this.itemHeight,  radius: this.dw-1,  start: 0, end: 359,  closed: true, fillStyle:'#eeeeee',strokeWidth: 0});
			}
			
			if(this.itemType=='dotcurv'){
				$('#'+this.belongs+'_can').drawArc({ x: this.itemLeft, y: myLedo.colHeight-this.itemHeight,  radius: this.dw-1,  start: 0, end: 359,  closed: true, fillStyle:this.itemColor,strokeWidth: 0});
			}
			*/
			
		}
		//$('#'+this.belongs+'_leftLabel').html(this.strs);
		if(this.itemLineType=='line'){
			
			for(this.i=1;this.i<this.vData.length;this.i++){
				//if(this.vData[this.i].itemHeight>0){
				this.itemColor=this.color[this.vData[this.i].colorType];
				$('#'+this.belongs+'_can').drawLine({strokeStyle:'#0099ff',strokeWidth:4,opacity:0.4,x1:this.vData[this.i-1].left+this.leftPadding,y1:myLedo.colHeight-this.vData[this.i-1].itemHeight,x2:this.vData[this.i].left+this.leftPadding,y2:myLedo.colHeight-this.vData[this.i].itemHeight,rounded: true });
				//}
			}
		}
		if(this.itemLineType=='curv'){
			this.curv= {strokeStyle: '#0099ff', strokeWidth: 4, rounded: true,opacity:0.4, fillStyle:"rgba(0,0,0,0)"};
			
			// Adds the points from the array to the object
			this.m=0;this.n=0;this.p=0;this.q=0;this.sp=2;
			for (this.p=0; this.p<=Math.floor(this.vData.length/this.sp)-3; this.p+=3) {
				this.m++;
				this.n++;
				this.q=this.p*this.sp;
				//strs+="m="+m+" n="+n+" p="+p+"<br>";
				this.curv['x'+(this.m)] = this.vData[this.q].left+this.leftPadding;
				//strs+="obj['x'"+m+"]="+ pts[p][0]+"<br>"
				this.curv['y'+(this.m)] = myLedo.colHeight-this.vData[this.q].itemHeight;
				//strs+="obj['y'"+m+"]="+ pts[p][1]+"<br>"
				this.q+=this.sp;
				this.curv['cx'+(this.n)] =this.vData[this.q].left+this.leftPadding;
				//strs+="obj['cx'"+n+"]="+ pts[p+1][0]+"<br>"
				this.curv['cy'+(this.n)] =  myLedo.colHeight-this.vData[this.q].itemHeight;
				//strs+="obj['cy'"+n+"]="+ pts[p+1][1]+"<br>"
				this.n++;
				this.q+=this.sp;
				this.curv['cx'+(this.n)] =this.vData[this.q].left+this.leftPadding;
				//strs+="obj['cx'"+n+"]="+ pts[p+2][0]+"<br>"
				this.curv['cy'+(this.n)] =  myLedo.colHeight-this.vData[this.q].itemHeight;
				//strs+="obj['cy'"+n+"]="+ pts[p+2][1]+"<br>"
			}
			this.m++;
			this.q=this.p*this.sp;
			this.curv['x'+(this.m)] = this.vData[this.vData.length-1].left+this.leftPadding;
			//strs+="obj['x'"+m+"]="+ pts[p][0]+"<br>"
			this.curv['y'+(this.m)] = myLedo.colHeight-this.vData[this.vData.length-1].itemHeight;
			// Draws the line
			$('#'+this.belongs+'_can').drawBezier(this.curv);
			//$('#info').html(strs)

		}
		//----------------画水平线--------------------------------
		
		$('#'+this.belongs+'_can').drawLine({
  			strokeStyle: "#bfbfbf",  strokeWidth: 1,
  			x1: this.leftPadding, y1: myLedo.colHeight,
  			x2: this.leftPadding+this.itemNumber*this.dw, y2: myLedo.colHeight,
 
		});
		$('#'+this.belongs+'_can').bind("mouseenter",{catName:this.belongs,vData:this.vData,itemWidth:this.dw,paddingLeft:this.leftPadding,paddingTimeID:this.paddingTimeID},beginpos);
		$('#'+this.belongs+'_can').bind("mouseleave",{catName:this.belongs},endpos);	
		//$('#'+this.belongs).bind("click", {foo:'abc'} ,GetCode);
	};
	//----------删除数组中属性为objprop，值为objvalue的对象
	function removeZero(arrPerson,objPropery,objValue){
	   	return $.grep(arrPerson, function(cur,i){
          return cur[objPropery]!=objValue;
       });
	}
	function getFromArray(arrPerson,objPropery,objValue){
   		return $.grep(arrPerson, function(cur,i){
          return cur[objPropery]==objValue;
       });
	}
	//function GetCode(event) { alert(event.data.foo) }
	function beginpos(event){
		var catName=event.data.catName;
		
		currentShowType=catName.toLowerCase();
		myLedo.dataList=event.data.vData;
		myLedo.currentChart=catName;
		myLedo.itemWidth=event.data.itemWidth;
		myLedo.paddingLeft=event.data.paddingLeft;
		myLedo.paddingTimeID=event.data.paddingTimeID;
		
		$('body').everyTime('5cs',interShow);	
		$('#'+catName).bind({mousemove:function (e){
				px=e.pageX;
				py=e.pageY;
		}});
		nobj=$('#'+catName).parent();
		//rx=parseInt(nobj.offset().left)
		//ry=parseInt(nobj.offset().top)
		rx=parseInt($('#'+catName).offset().left);
		ry=parseInt($('#'+catName).offset().top);
		
	}
	function endpos(event){
		var catName=event.data.catName;
		$('#'+catName).unbind("mousemove");
		$('body').stopTime();   
		var nobj=$('#'+myLedo.currentChart+"_label");
		nobj.fadeOut();
	}
	
	function interShow(){

		var nx=px-rx-myLedo.paddingLeft;
		var ny=myLedo.colHeight-(py-ry);
		//alert(nx)
		
		myLedo.showID=Math.floor(nx/myLedo.itemWidth);
		var showItem=getFromArray(myLedo.dataList,"id",myLedo.showID);
		//--------------判断sleep数据出错----------
		if(showItem.length>0 && (myLedo.currentChart!= "ACT" || (myLedo.currentChart=="ACT" && showItem[0].valueData>0.5))){
			var nobj=$('#'+myLedo.currentChart+"_label");
			nobj.css('left',showItem[0].left+myLedo.paddingLeft-26);
			nobj.css('top',myLedo.colHeight-showItem[0].itemHeight-45);
			nobj.css("background-image","url('../images/"+currentShowType+"_"+showItem[0].colorType+".png')");
			//alert(showItem[0].timeInfo);
			$("#"+myLedo.currentChart+"_labelLeftText").html(showItem[0].timeInfo);
			
			$("#"+myLedo.currentChart+"_labelRightText").html((showItem[0].valueData));
			nobj.fadeIn();
			
			//$('#'+myLedo.currentChart+'_leftLabel').html("showID:"+myLedo.showID+"  "+myLedo.currentChart+"  left:"+myLedo.paddingLeft);
		}
		/*
		if(myLedo.showID<0){myLedo.showID=0}
		if(myLedo.showID>=myLedo.dataList.length){myLedo.showID=myLedo.dataList.length-1}
		
		if(myLedo.showID>=0 && myLedo.showID<myLedo.dataList.length && myLedo.dataList[myLedo.showID].valueData>0){
			var nobj=$('#'+myLedo.currentChart+"_label")
			nobj.css('left',myLedo.showID*myLedo.itemWidth+myLedo.paddingLeft-26)
			nobj.css('top',myLedo.colHeight-myLedo.dataList[myLedo.showID].itemHeight-45)
			nobj.css("background-image","url('../images/label_"+myLedo.dataList[myLedo.showID].colorType+".png')");
			$("#"+myLedo.currentChart+"_labelLeftText").html(myLedo.dataList[myLedo.showID].timeInfo);
			$("#"+myLedo.currentChart+"_labelRightText").html(myLedo.dataList[myLedo.showID].valueData);
			nobj.fadeIn()
			$('#'+myLedo.currentChart+'_leftLabel').html("showID:"+myLedo.showID+"  "+myLedo.currentChart);
		}
		*/
		
	}
	function convertHourToID(hourStr,addNum){
		return (Number(hourStr)+Number(addNum))*12;
	}
	function convertTimetoID(timeStr,showMode,timeMode){
		//timeMode=0 total , timeMode=1 total/5
		//showMode: 1: HH 0:HHMM,2 hh:mm
		var s_hour,s_min,sid;
		if(showMode==0){
			s_hour=Number(timeStr.substring(0,2));
			s_min=Number(timeStr.substring(2,4));
		}
		if(showMode==1){
			//-------小时转换成ID
			s_hour=Number(timeStr);
			if(showMode==2){s_hour++;}
			s_min=0;
		}
		if(showMode==2){
			s_hour=Number(timeStr.substring(0,2));
			s_min=Number(timeStr.substring(3,5));
		}
		if(timeMode==1){
			sid=Math.floor((s_hour*60+s_min)/5);
		}else{
			sid=s_hour*60+s_min;
		}
		
		return sid;
		
	}
	function convertIDtoTime(timeID,showMode){
		//----showMode:0, HHMM, 1: HH:MM 2: HH:MM <span>am/pm</span> 3: HH <span>am/pm</span> ----------------
		//timeID*=5
		var s_hour=Math.floor(timeID/60);
		if(s_hour>23){s_hour-=24;}
		var s_min=timeID-s_hour*60;
		var h,m;
		var timeStr="am";
		if(s_hour >= 12){
			timeStr="pm";
		}
		if(s_hour==0){
			s_hour=12;timeStr="am";
		}
		if(s_hour>12){
			s_hour-=12;timeStr="pm";
		}
		
		s_hour<10 ? h="0"+String(s_hour):h=String(s_hour);
		s_min<10 ? m="0"+String(s_min):m=String(s_min);
		switch(showMode){
			case 0:
			return h+m;break;
			case 1:
			return h+":"+m;break;
			case 2:
			return h+":"+m+" <span>"+timeStr+"</span>";break;
			case 3:
			return h+"<span>"+timeStr+"</span>";break;
		}
	}
function convertHourNumber(s_hour){
	var timeStr="am";
	while(s_hour>24){
		s_hour-=24;
	}
	while(s_hour<0){
		s_hour+=24;
	}
	if(s_hour >= 12){
		timeStr="pm";
	}
	if(s_hour==0){
		s_hour=12;timeStr="am";
	}
	if(s_hour>12){
		s_hour-=12;timeStr="pm";
	}
	s_hour<10 ? h="0"+String(s_hour):h=String(s_hour);
	return h+timeStr;
}