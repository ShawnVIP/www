var iconID=0;
var pageID=1; // homepage
var t=n=0;
var nextIconID=0;
var count=6;
var clickIconID=1;
var showmode=1;


mail=request("mail");
key=request("passkey");
if(mail !="" && key !=""){
	$.cookie('back_ucode', null);
	$.cookie('back_scode', null);
	$.cookie('back_ecode', null);
	$.cookie('back_loginMode', null);
}


document.write("<script type='text/javascript' src='../js/reglogin.js'></"+"script>"); 
function request(paras){
		var url = location.href;
		var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
		var paraObj = {};
		for (i=0; j=paraString[i]; i++){
			paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length);
		}
		var returnValue = paraObj[paras.toLowerCase()];
		if(typeof(returnValue)=="undefined"){
			return "";
		}else{
			return returnValue;
		}
}

function writeFlash(objname,w,h){
	
	var flashvars = {};
	var params = {quality: "high",swLiveConnect:"true",menu: "false",allowScriptAccess: "sameDomain",allowFullScreen:"false",wmode:"transparent"};
	var attributes = {};
	swfobject.embedSWF(objname+".swf", objname, w, h, "9.0.0","expressInstall.swf", flashvars, params, attributes);
	
}
	
$(function(){
	$('#buyover').hide(); 
	for(i=0;i<count;i++){
		$('<div id="icon'+i+'" class="iconItem"></div>').appendTo($('#iconList'));	
		//$('<div id="icon'+i+'" class="iconItem"><div id="iconImg'+i+'"><img src="../images/icon'+i+'_0.png" width=48 height=48 id="smallIcon'+i+'" /></div></div>').appendTo($('#iconList'));	
		$('#icon'+i).css("background","url(../images/icon"+i+"_1.png)");
		$('<div id="iconImg'+i+'"><img src="../images/icon'+i+'_0.png" width=48 height=48 id="smallIcon'+i+'" /></div>').appendTo($('#icon'+i));	
		
		$('#iconImg'+i).bind("mouseenter",{id:i},showin);
		$('#iconImg'+i).bind("mouseleave",{id:i},showout);
		$('#iconImg'+i).bind("click",{id:i},jumppage);
		$('#iconImg'+i).css("cursor","pointer");
	}
	
	$('.pic').hide();
	$('#pic0').show();
	$('#buy').click(function(){
		//window.open("http://www.indiegogo.com/projects/sense-u-the-world-s-first-all-in-one-activity-tracker-to-connect-your-family/");
		location="purchase.php";
	});
	$('#buy').bind("mouseenter",{},showbuyin);
	$('#buy').bind("mouseleave",{},showbuyout);
	//t=setInterval("showAuto()", 9000);
	
	//https://sense-u.com/?mail=shier@sohu.com&passkey=LKbGX0Is5nVCQ3nIaQgbtniBbgS4U2Zx
	
	
	$('#closeVideo').click(function(){
		hideVideo();
	});
	$('#homeVideo').hide();
	
	if(checkMobile()){ //-----移动终端，显示图片-----------
		$('<img src="../images/videocover.png" width="189" height="120" />').appendTo($('#videoButton'));
		$('#videoButton').click(function(){showVideo();});
	}else{
		$('<div id="videoclick"></div>').appendTo($('#videoButton'));
		writeFlash("videoclick",189,120);
		$('#homeVideo').height(426);
		$('#videoFrame').height(426);
	}
	showAuto();
});
function showVideo(){
	$('body').stopTime();
	showmode=0;
	showPop("homeVideo","");
	if(checkMobile()){
		$('#videoFrame').attr("src","homevideo.html");
		$('#darkBack').click(function(){
			hideVideo();
		});
	}else{
		$('#videoFrame').attr("src","homevideoflv.html");
	}
	$('#videoButton').fadeOut();
	
}
function hideVideo(){
	hidePop("homeVideo");
	$('#videoFrame').attr("src","empty.html");
	showmode=1;
	$('#videoButton').fadeIn();
	$('body').oneTime('6s','autoload',function(){ showAuto();});
	if(checkMobile()){
		$('#darkBack').click(function(){}); 
	}
}

function checkForget(){
	mail=request("mail");
	key=request("passkey");
	if(mail !="" && key !=""){
		var outData={mail:mail,key:key};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/checkforget.php',
			data:JSON.stringify(outData), 
			success: function (msg) {dealCheckBack(msg);}
		});
	}
}
function dealCheckBack(r){
	
	var status=r.status;
	if(status==200){
		$.cookie('back_ucode', r.ucode, {path:'/'});
		$.cookie('back_umail', request("mail"), {path:'/'});
		$.cookie('back_passkey', request("passkey"), {path:'/'});
		showPop('popupReg','reset');
		//document.getElementById('popupRegFrame').contentWindow.showReset();
		//$('#popupRegFrame').contentWindow.showReset();
		//$("#popupRegFrame")[0].contentWindow.showReset();
	}
		
}
	
function showbuyin(event){
	$('#buyover').stop(false,true).fadeIn();
}
function showbuyout(event){
	$('#buyover').stop(false,true).fadeOut();
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function showout(event){
	MM_swapImgRestore();
}
function showin(event){
	id=event.data.id;
	MM_swapImage('smallIcon'+id,'','../images/icon'+id+'_2.png',1);
	
}
function autoshow(){
	$('body').oneTime('9s','autoload',function(){ showAuto();}); 
}
function showIcon(){
	for(i=0;i<count;i++){
		obj=$("#iconImg"+i);
		if(i==iconID){
			obj.hide();
		}else{
			
			obj.show();
		}
	}
}

function jumppage(event){
	iconID=event.data.id;
	showAuto();
	
}

function showAuto(){
	if(showmode==1){
		$('body').stopTime();
		for(var i=0;i<count;i++){
			i==iconID ? $("#pic"+i).fadeIn():$("#pic"+i).fadeOut();
		}
		showIcon();
		iconID==count-1 ? iconID=0:iconID++;
		$('body').oneTime('6s','autoload',function(){ showAuto();}); 
	}
}