var bigcirBack = new Image();  
var contentImgData;
function drawProcess() {
    // 选出页面上所有class为process的canvas元素,然后迭代每一个元素画图(这里用Jquery的选择器选的)
	$('canvas.process').each(function() {
            // 第一部先拿到canvas标签中间的文字,就是那个61%(这里的stringTrim方法是我自己的方法,去前后空格的方法很多的,这里就不贴出来了)
		var text = $(this).text();
		//var process = text.substring(0, text.length-1);
        var process =parseInt(Math.random()*100);     
            // 一个canvas标签
		var canvas = this;
            // 拿到绘图上下文,目前只支持"2d"
		var context = canvas.getContext('2d');
	// 将绘图区域清空,如果是第一次在这个画布上画图,画布上没有东西,这步就不需要了
		/*
		context.clearRect(0, 0, 48, 48);
		
	// ***开始画一个灰色的圆
		context.beginPath();
        // 坐标移动到圆心
		context.moveTo(24, 24);
            // 画圆,圆心是24,24,半径24,从角度0开始,画到2PI结束,最后一个参数是方向顺时针还是逆时针
		context.arc(24, 24, 24, 0, Math.PI * 2, false);
		context.closePath();
            // 填充颜色
		context.fillStyle = '#ddd';
		context.fill();
            // ***灰色的圆画完
		
		// 画进度
		
		context.beginPath();
            // 画扇形的时候这步很重要,画笔不在圆心画出来的不是扇形
		context.moveTo(24, 24);
            // 跟上面的圆唯一的区别在这里,不画满圆,画个扇形
		context.arc(24, 24, 24, 0, Math.PI * 2 * process / 100, false);
		context.closePath();
		context.fillStyle = '#e74c3c';
		context.fill();
		*/
		
		var temp={pos:0,lastpos:0};
		var outRadio=58;
		var inRadio=52;
		var cenX=65;
		var cenY=65;
		var coreRadio=47;
		
		var backColor='#a5a5a5';
		var insideColor='#b7b7b7';
		var itemColor="#66bd00";
		if(process<60){itemColor='#ff9e04';}
		//this.width=outRadio;
		//this.height=outRadio;
		TweenLite.to(temp,1,{pos:process, onUpdate:function(){
			context.clearRect(0, 0, outRadio*2, outRadio*2);
			// ***开始画一个灰色的圆
			//context.globalCompositeOperation="source-over";
			context.beginPath();
        	// 坐标移动到圆心
            // 画圆,圆心是24,24,半径24,从角度0开始,画到2PI结束,最后一个参数是方向顺时针还是逆时针
			context.arc(cenX, cenY, outRadio, 0, Math.PI * 2, false);
			
            context.lineWidth = 8;
			context.strokeStyle = backColor;
			context.stroke();
			
			

			
			// 画文字背景
			context.beginPath();
			context.arc(cenX, cenY, coreRadio, 0, Math.PI * 2, true);
			context.closePath();
            // 与画实心圆的区别,fill是填充,stroke是画线
			//context.strokeStyle = '#ddd';
			//context.stroke();
			context.fillStyle = insideColor;
			context.fill();
            
            // 画进度
			context.beginPath();
			
			var ang=Math.PI * 2 * temp.pos / 100;
			context.arc(cenX, cenY, outRadio, -Math.PI/2, ang-Math.PI/2, false);
			
			
			context.lineWidth = 8;
			context.strokeStyle = itemColor;
			context.stroke();
	
	
	
			var ra=(Math.PI-ang)/2;
			context.beginPath();
			context.moveTo(cenX+coreRadio*Math.cos(ra),cenY+coreRadio*Math.sin(ra));
			context.arc(cenX, cenY, coreRadio, ra,ang+ra, false);
			context.closePath();
			context.fillStyle = itemColor;
			context.fill();
			
		
            //在中间写字
            //context.globalCompositeOperation="xor";
	    	context.font = "bold 30pt Arial";
	    	context.fillStyle = 'white';
	    	context.textAlign = 'right';
	   	 	context.textBaseline = 'middle';
	    	context.moveTo(cenX, cenY);
	    	context.fillText(parseInt(temp.pos), cenX+15, cenX-5);
	    	
		 	context.font = "bold 15pt Arial";
	    	context.fillStyle = 'white';
	    	context.textAlign = 'center';
	   	 	context.textBaseline = 'middle';
	    	context.moveTo(cenX, cenY);
	    	context.fillText('%', cenX+25, cenY);
	    	
			}
		});
		
		
		
		$('canvas.midCircle').each(function() {
            // 第一部先拿到canvas标签中间的文字,就是那个61%(这里的stringTrim方法是我自己的方法,去前后空格的方法很多的,这里就不贴出来了)
			var text = $(this).text();
			//var process = text.substring(0, text.length-1);
	        var process =parseInt(Math.random()*100);     
	            // 一个canvas标签
			var canvas = this;
	            // 拿到绘图上下文,目前只支持"2d"
			var context = canvas.getContext('2d');
	
			
			var temp={pos:0,lastpos:0};
			var outRadio=145;
			var inRadio=121;
			var backRadio=133;
			var cenX=outRadio;
			var cenY=outRadio;
			var itemColor="#66bd00";
			
			if(process<60){itemColor='#ff9e04';}
			TweenLite.to(temp,1,{pos:process, onUpdate:function(){
				context.clearRect(0, 0, outRadio*2, outRadio*2);
				// ***开始画一个灰色的圆
				
				//context.globalCompositeOperation="lighter";
				//context.drawImage(bigcirBack, 0, 0, outRadio*2, outRadio*2); 
				context.beginPath();
				context.moveTo(cenX, cenY);
				context.arc(cenX, cenY, backRadio, 0, Math.PI * 2, true);
				context.closePath();
				//context.fillStyle = 'rgba(255,255,255,1)';
				context.fillStyle = '#dde4f0';
				context.fill();
			
				context.beginPath();
				//context.lineJoin="round";
				context.lineCap="round";
	        	context.moveTo(cenX, cenY-inRadio);
	        	var ang=Math.PI * 2 * temp.pos / 100-Math.PI/2;
				context.arc(cenX, cenY, inRadio, -Math.PI/2, ang, false);
				context.lineWidth = 24;
				context.strokeStyle = itemColor;
				context.stroke();
				
				context.drawImage(bigcirBack, 0, 0, outRadio*2, outRadio*2); 
				//context.globalCompositeOperation="source-over";
	            //在中间写字
	            //context.globalCompositeOperation="xor";
		    	context.font = "bold 80pt Arial";
		    	context.fillStyle = itemColor;
		    	context.textAlign = 'right';
		   	 	context.textBaseline = 'middle';
		    	context.moveTo(cenX, cenY);
		    	
		    	context.fillText(parseInt(temp.pos), cenX+45, cenX);
		    	
			 	context.font = "bold 30pt Arial";
		    	context.fillStyle = itemColor;
		    	context.textAlign = 'center';
		   	 	context.textBaseline = 'middle';
		   	 	
		    	context.moveTo(cenX, cenY);
		    	context.fillText('%', cenX+70, cenY+15);
		    	
			
			}});
			
			
		});
		
	});
}
function redraw(){
	var mainWidth=700;
	var mainHeight=600;
	
	$('<canvas id="mainCanvas" class="process" width="'+mainWidth+'px" height="'+mainHeight+'px" >61%</canvas> ').appendTo($('#main'));
	$('<div id="itemContent"></div>').appendTo($('#main'));
	$('#itemContent').hide();
	var cenX=mainWidth/2;
	var cenY=mainHeight/2;
	var canvas =document.getElementById('mainCanvas');
    var context = canvas.getContext('2d');
    var perList=new Array();
    
    var itemLength=parseInt(Math.random()*10)+2;
    

    var cenPer=parseInt(Math.random()*100);
    var cenItemColor="#66bd00";
			
	if(cenPer<60){cenItemColor='#ff9e04';}
			
    
    var cenBackColor='#dde4f0';
    var itemBackColor='#a5a5a5';
    var cenBackRadio=133;
    var cenInRadio=121;
    var itemRadio=220;
    var itemOutRadio=58;
	var itemInRadio=52;
	var itemCoreRadio=47;
	var itemCoreColor='#b7b7b7';
	
	drawCirItem(context,cenX,cenY,cenBackRadio,0, Math.PI*2, cenBackColor,1,true,false);
	
	for(var i=0;i<itemLength;i++){
		$('<div class="process" id="item'+i+'"></div>').appendTo($('#itemContent'));
		$('#item'+i).attr("itemID",i);
		var itemPer=parseInt(Math.random()*80)+20;
		var itemColor="#66bd00";
		var itemX=cenX+itemRadio*Math.cos(i*Math.PI*2/itemLength-Math.PI/2);
		var itemY=cenY+itemRadio*Math.sin(i*Math.PI*2/itemLength-Math.PI/2);
		if(itemPer<60){itemColor='#ff9e04';}
		//alert(i+"  "+itemX+"  "+itemY);
		perList.push({percent:itemPer,itemColor:itemColor,cenx:itemX,ceny:itemY});
		
		drawCirItem(context,itemX,itemY,itemOutRadio,0, Math.PI*2, itemBackColor,8,false,false);
    	drawCirItem(context,itemX,itemY,itemCoreRadio,0, Math.PI*2, itemCoreColor,1,true,false);
	}
	contentImgData=	context.getImageData(0, 0, mainWidth, mainHeight);
   
    var temp={pos:0};
    TweenLite.to(temp,1,{pos:1, onUpdate:function(){
    	context.clearRect(0, 0, mainWidth, mainHeight);
    	context.putImageData(contentImgData,0,0);
	    $('div.process').each(function() {
	        var currentID =$(this).attr("itemID"); 
	        var currentAng=perList[currentID].percent*temp.pos*Math.PI/50;
	    	drawCirItem(context,perList[currentID].cenx,perList[currentID].ceny,itemOutRadio,-Math.PI/2, currentAng-Math.PI/2, perList[currentID].itemColor,8,false,false);
	    	var ra=(Math.PI-currentAng)/2;
	    	drawCirItem(context,perList[currentID].cenx,perList[currentID].ceny,itemCoreRadio,ra, currentAng+ra, perList[currentID].itemColor,1,true,true);

	    });
	    var cenAng=Math.PI *  temp.pos*cenPer / 50-Math.PI/2;
	    drawCirItem(context,cenX,cenY,cenInRadio,-Math.PI/2, cenAng, cenItemColor,24,false,false);
	    context.drawImage(bigcirBack, cenX-145, cenY-145,290, 290); 
	  
   }});
}
function drawCirItem(obj,cenx,ceny,radio,startAng,endAng,color,penWidth,fillMode,closeMode){
	obj.beginPath();
	obj.arc(cenx, ceny, radio, startAng,endAng, false);
	if(fillMode){	
		if(closeMode){
			obj.closePath();	
		}		
		obj.fillStyle = color;
		obj.fill();
	}else{
		obj.lineCap="round";
		obj.lineWidth = penWidth;
		obj.strokeStyle = color;
		obj.stroke();
	}
	
}
$(function(){
	bigcirBack.src ="images/per_big.png";
	//bigcirBack.load();
  	redraw();
	
});