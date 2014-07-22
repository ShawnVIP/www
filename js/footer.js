var txtLib=({
	foot_prv:{cn:"隐私&安全",en:"PRIVACY & SECURITY"},
	foot_abo:{cn:"关于 SENSE-U",en:"ABOUT SENSE-U"},
	foot_help:{cn:"帮助",en:"HELP"},
	foot_pro:{cn:"产品&下载",en:"PRODUCTS & DOWNLOAD"},
	
});
var menuList=new Array();
menuList[11]="privacy.php";
menuList[12]="about.php";
menuList[13]="help.php";
menuList[14]="download.php";


function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}
$(function(){
	
	var url = parent.location.href; 
	var pos=url.lastIndexOf("/");
	var lastStr=url.substring(pos+1)
	menuList[15]="../cn/"+lastStr;
	menuList[16]="../en/"+lastStr;

	
	$('#menu11').text(getText("foot_prv"));
	$('#menu12').text(getText("foot_abo"));
	$('#menu13').text(getText("foot_help"));
	$('#menu14').text(getText("foot_pro"));
	for(var i=11;i<17;i++){
		if(i != parent.pageID){
			$('#menu'+i).addClass("G_bottomMenuTextBtn");
			$('#menu'+i).attr("mid",i);
			$('#menu'+i).click(function(){
				//alert(menuList[$(this).attr("mid")]);
				var mid=$(this).attr("mid");
				if(mid==15 || mid==16){
					$.cookie('back_ucode', null);
					$.cookie('back_scode', null);
					$.cookie('back_ecode', null);
					$.cookie('back_loginMode', null);
				}
				parent.location=menuList[mid];
			
			});
			$('#menu'+i).mouseover(function(){$(this).addClass('G_menuOver'); });
			$('#menu'+i).mouseout(function(){$(this).removeClass('G_menuOver'); });
		}
	}
});
