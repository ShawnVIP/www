var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
var back_email=$.cookie('tempEmail');
var dataList=new Array();
var relationList=new Array();


var pickedRelationID;

var txtLib=({
	fam_title:{cn:"添加家庭成员",en:"Add Family Member"},
	fam_go:{cn:"查找",en:"GO"},
	fam_tips:{cn:"您可以通过输入完整电子邮箱地址查找家庭成员",en:"You can invite your family members by searching full Email address."},
	fam_choose:{cn:"他/她是我的______",en:"He/She is my ______"},
	fam_guard:{cn:"我是监护人.",en:"I am guardian."},
	fam_send:{cn:"发送请求",en:"Send Request"},
	fam_emailNoExist:{cn:"该用户不存在.",en:"User does not exist."},
	fam_noRela:{cn:"请选择和您的关系",en:"please choose the relationship"},
	fam_noEmail:{cn:"请输入电子邮箱地址.",en:"Please provide an existed  email address."},
	fam_selfEmail:{cn:"输入的是您自己的邮箱地址.",en:"You must be kidding to find yourself :)"},
	fam_sendOK:{cn:"请求已经被送出.",en:"Request has been sent."},
	fam_userExist:{cn:"该用户已存在于您家庭成员列表中",en:"Already added in your family list."},
	fam_reqExist:{cn:"申请请求已存在",en:"Request already exist."}

});

function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}

/*
great-grandfather（外）曾祖父
great-grandmother（外）曾祖母
great-aunt叔、伯祖母
great-uncle叔、伯祖父
grand-father（外）祖父
grand-mother（外）祖母
uncle 姨夫 叔叔 姑父 舅舅
aunt 姨母 姑姑 婶婶 舅妈
mother 母亲
father 父亲
mother-in-law婆婆 岳母
father-in-law公公 岳父
cousin （表，堂）姐妹 兄弟
sister-in-law 嫂子，弟妹，小姑
brother 兄弟
sister 姐妹
wife 妻子
husband 丈夫
brother-in-law 大伯，小叔，姐夫，妹夫
nephew 侄子
niece 侄女
son-in-law 女婿
daughter 女儿
son 儿子
daughter-in-law 媳妇
grandson 孙子
granddaughter 孙女
great-grandson （外）曾孙
great-granddaughter（外）曾孙女
*/


function getRelation(){
	
	var outData={lang:LANG,relation:"family"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/getrelation.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			obj=msg.outdata
			
			$('#relationList').empty()
			for(i=0;i<obj.length;i++){
				relationList.push({id:obj[i].id,r:obj[i].name,mid:obj[i].mid,fid:obj[i].fid});
				$('<option value="'+obj[i].id+'">'+obj[i].name+'</option>').appendTo($('#relationTable'));
			}
			$('#relationTable').bind({
		
				click:function(){
					$('#wronginfo').html('');
					//pickedRelationID=$('#relationTable').children('option:selected').val();
					//$('#PRO_selectLong').html(relationList[pickedRelationID].r);
					pickedRelationID=$("#relationTable").get(0).selectedIndex;
					
					$('#PRO_selectLong').html($("#relationTable").find("option:selected").text());
					$('#relaDiv').hide();
				}
			});
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
		
}

$(function(){
	$('#PRO_title').text(getText('fam_title'));
	$('#tips').text(getText('fam_tips'));
	$('#searchBtn').text(getText('fam_go'));
	$('#chooseTitle').text(getText('fam_choose'));
	$('#guardianText').text(getText('fam_guard'));
	$('#sendBtn').text(getText('fam_send'));
	$('#chooseRela').hide();
	$('#downarea').show();
	
	$(".PRO_senNameBack input").keypress(function(event) {
		var keyCode = event.which;
		/*
		if ((keyCode >= 97 && keyCode <=122) || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127 ||keyCode == 32 ||(keyCode >=64 && keyCode <=90) )
			return true;
		else
			return false;
		*/
		}).focus(function() {
			this.style.imeMode='disabled';
			$('#relaDiv').hide();
	});
	buildButton("searchBtn",{Width:100});
	$('#searchBtn').bind({
			click:function(){
				$('#chooseRela').hide();
				goSearch();
			}
		});	
	$('#mainFrame').show();
	$('#piclist').hide();
	buildButton("sendBtn",{Width:200})
	$('#sendBtn').bind({
			mouseenter:function(event){showover();},
			mouseleave:function(event){showout();},
			click:function(event){
				$('#relaDiv').hide();
				if($('#PRO_selectLong').html()==''){
					$('#wronginfo').html(getText('fam_choose'));
				}else{
					switchItem();
				}
			}
	});	

	$('#PRO_selectLong').bind({
			click:function(){
				
				$('#relaDiv').show();
			}
	});	

	$('#PRO_close').bind({
		click:function(event){hidethis();}
	});
	$("#guardian").click(function(){
        if($(this).attr("isCheck") == "true") {
            $(this).removeAttr("isCheck")
        } else {
            $(this).attr("isCheck", "true");
        }
    })
	getRelation();
	
});

function hidethis(){
	parent.closeSearch();
	
}
function showover(){
	$('#sendImg').stop(false,true).fadeIn();
}
function showout(){
	$('#sendImg').stop(false,true).fadeOut();
}


function goSearch(){
	$('#PRO_selectLong').html('');
	$('#wronginfo').html('');
	var value=$('#s1').val();
	/*
	var regExp=/^[0-9a-zA-Z-]+$/;

	if(! regExp.test(value)){
		showerror("No special letters allowed, Please reinput");
		return;
	}
	*/
	if(value.length==0){
		showerror(getText('fam_noEmail'));
		return;
	}
	if( value.toLowerCase()==back_email){
		showerror(getText('fam_selfEmail'));
		return;
	}
	$('#waitload').show();
	$('#goSearch').hide();
	$('.wrapper').html("");
	var outData={ucode:back_ucode,scode:back_scode,keyword:value.toLowerCase(),ecode:back_ecode,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/searchmembers.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				dealback(msg);
        	}
    });
	
}

function showerror(msg){
	$('#wronginfo').html(msg);
}
function dealback(r){
	$('#waitload').hide();
	$('#goSearch').show();
	
	if(r.status ==501){
		showerror(getText('fam_emailNoExist'));
		return;
	}
	if(r.status ==502){
		showerror(getText('fam_reqExist'));
		return;
	}
	if(r.status ==503){
		showerror(getText('fam_userExist'));
		return;
	}
	if(r.status !=200){
		return;
	}
	dataList=r.memberList;
	if(dataList.length==0){
		showerror(getText('fam_emailNoExist'));
		$('#s1').focus();
		$('#downarea').show();
		return;
	}
	
	strs="<ul>";
	for(i=0;i<dataList.length;i++){
		//strs+='<li><div class="headItem"><div class="headPic" onclick="switchItem('+dataList[i].id+')"><img src="https://sense-u.com/../upload/'+dataList[i].headimage+'"></div><div class="headName">'+dataList[i].nickname+'</div></div></li>';
		strs+='<li><div class="headItem"><div class="headPic"><img src="../upload/'+dataList[i].headimage+'"></div><div class="headName">'+dataList[i].nickname+'</div></div></li>';

	}
	strs+="</ul>";
	$('.wrapper').html(strs);
	$('.infiniteCarousel').infiniteCarousel();
	/*
	if(dataList.length<=3){
		$('.infiniteCarousel').css("left",(4-dataList.length)*60);
		$('.arrow').hide();
	}else{
		$('.infiniteCarousel').css("left",60);
		$('.arrow').show();
	}
	*/
	$('.arrow').hide();
	$('.infiniteCarousel').show();
	$('#chooseRela').show();
	$('#downarea').hide();
		
}

function switchItem(){
	

	//alert("cont"+ nid)
	var myRelation;
	var guardian=0;
	if($("#guardian").attr("isCheck") == "true"){guardian=1;}
	
	//$.cookie('back_gender')=="F" ? myRelation=relationList[pickedRelationID].m:myRelation=relationList[pickedRelationID].m;

	$.cookie('back_gender')=="F" ? myRelation=relationList[pickedRelationID].fid:myRelation=relationList[pickedRelationID].mid;
	
	
	var outData={guardian:guardian,ucode:back_ucode,scode:back_scode,fid:dataList[0].id,ecode:back_ecode,source:"w",reltome:relationList[pickedRelationID].id,relforme:myRelation};
	
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/sendrequest.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				dealreqback(msg);
        	}
    });
}
function dealreqback(r){
	$('#waitload').hide();
	$('#goSearch').show();
	$('#chooseRela').hide();
	$('.infiniteCarousel').hide();
	if(r.status ==205){
		showerror(getText('fam_reqExist'));
		return;
	}
	if(r.status ==200){
		showerror(getText('fam_sendOK'));
		
		return;
	}
}

