document.write("<script type='text/javascript' src='js/reglogin.js'></"+"script>"); 
var sameAddressMode=0 //billing和shipping不同地址
var pageID=4; // userpage
var maxIndex=100;
var quantity=1;
var colorID=0;
var pageName="purchase";
var currentPopName,popUpChanged=false;
var INFO_popupValue=[]
var cardStation=false
var stateList=[{id:'AL',text:'AL'},{id:'AK',text:'AK'},{id:'AZ',text:'AZ'},{id:'AR',text:'AR'},{id:'CA',text:'CA'},{id:'CO',text:'CO'},{id:'CT',text:'CT'},{id:'DE',text:'DE'},{id:'FL',text:'FL'},{id:'GA',text:'GA'},{id:'HI',text:'HI'},{id:'ID',text:'ID'},{id:'IL',text:'IL'},{id:'IN',text:'IN'},{id:'IA',text:'IA'},{id:'KS',text:'KS'},{id:'KY',text:'KY'},{id:'LA',text:'LA'},{id:'ME',text:'ME'},{id:'MD',text:'MD'},{id:'MA',text:'MA'},{id:'MI',text:'MI'},{id:'MN',text:'MN'},{id:'MS',text:'MS'},{id:'MO',text:'MO'},{id:'MT',text:'MT'},{id:'NE',text:'NE'},{id:'NV',text:'NV'},{id:'NH',text:'NH'},{id:'NJ',text:'NJ'},{id:'NM',text:'NM'},{id:'NY',text:'NY'},{id:'NC',text:'NC'},{id:'ND',text:'ND'},{id:'OH',text:'OH'},{id:'OK',text:'OK'},{id:'OR',text:'OR'},{id:'PA',text:'PA'},{id:'RI',text:'RI'},{id:'SC',text:'SC'},{id:'SD',text:'SD'},{id:'TN',text:'TN'},{id:'TX',text:'TX'},{id:'UT',text:'UT'},{id:'VT',text:'VT'},{id:'VA',text:'VA'},{id:'WA',text:'WA'},{id:'WV',text:'WV'},{id:'WI',text:'WI'},{id:'WY',text:'WY'}];
var cardList=[{id:'VI',text:'VISA'},{id:'JC',text:'JCB'},{id:'MA',text:'Mastercard'},{id:'DC',text:'Diners Club Intenational'},{id:'AE',text:'American Express'},{id:'DS',text:'Discover Card'}];
var countryList=[{id:'America',text:'America'}]
var shipList=[{id:'GR',text:'Ground:$9.99'},{id:'SE',text:'Second day: $14.99'},{id:'NE',text:'Next day: $19.99'}];

var monthList=[];
var yearList=[];
for(var i=1;i<=12;i++){
	var temptext="0"+i
	monthList.push({id:i,text:temptext.substring(temptext.length-2,temptext.length)});
}
for (i=13;i<=18;i++){
	yearList.push({id:i,text:i});
}
INFO_popupValue.push({name:"menu_pay",posx:337,posy:182,width:203,rowNumber:5,value:cardList});
INFO_popupValue.push({name:"menu_ship",posx:209,posy:434,width:338,rowNumber:3,value:shipList});
INFO_popupValue.push({name:"menu_country1",posx:715,posy:362,width:203,rowNumber:1,value:countryList});
INFO_popupValue.push({name:"menu_state1",posx:715,posy:398,width:94,rowNumber:6,value:stateList});
INFO_popupValue.push({name:"menu_country2",posx:715,posy:687,width:203,rowNumber:1,value:countryList});
INFO_popupValue.push({name:"menu_state2",posx:715,posy:724,width:94,rowNumber:6,value:stateList});
INFO_popupValue.push({name:"menu_year",posx:449,posy:294,width:94,rowNumber:6,value:yearList});
INFO_popupValue.push({name:"menu_month",posx:339,posy:294,width:94,rowNumber:6,value:monthList});

function showpop(popName){
	popUpChanged=(currentPopName!=popName);
	currentPopName=popName;
	
	for(var i=0;i<INFO_popupValue.length;i++){
		var nobj=INFO_popupValue[i]
		if(popName==nobj.name){
			$('#PRO_popup').css("left",nobj.posx);
			$('#PRO_popup').css("top",nobj.posy+165);
			$('#PRO_sel').width(nobj.width)
			$('#PRO_sel').attr("size",nobj.rowNumber)
			$('#PRO_sel option').each(function(){$(this).remove();}); 
			for(var j=0;j<nobj.value.length;j++){$("#PRO_sel").append("<option value='"+nobj.value[j].id+"'>"+nobj.value[j].text+"</option>");}
			if(popUpChanged){
				$("#PRO_sel").hide();
			}
			
			$("#PRO_sel").slideToggle("fast");
			break;
		}
	}
}
function getCookies(cname,tmode){
	var cvalue=$.cookie(cname)	
	if(tmode==1 && cvalue==null){
		cvalue=0
	}
	if(tmode==0 && cvalue==null){
		cvalue=""
	}
	return cvalue;
}
function saveValue(){
	checkstr="input:not([id$='_e'])[id^='input_']";
	$(checkstr).each(function(){
		$.cookie($(this).attr("id"),$(this).val());
	}); 
	checkstr="input:not([id$='_e'])[id^='menu_']";
	$(checkstr).each(function(){
		$.cookie($(this).attr("id"),$(this).val());
	}); 
	$.cookie("menu_shipCost",$("#menu_ship").val());
}
function getlabel(gname,gvalue){
	
	for(var i=0;i<INFO_popupValue.length;i++){ 
		if(INFO_popupValue[i].name==gname){
			for(j=0;j<INFO_popupValue[i].value.length;j++){
				if(gvalue==INFO_popupValue[i].value[j].id){
					return  INFO_popupValue[i].value[j].text
				}
			}
		}
	}
}

/*
VISA和MASTERCARD信用卡卡号通常为16位：
ｘｘｘｘ　　ｘｘｘｘ　　ｘｘｘｘ　　ｘｘｘｘ
其中：
第1—6位 为发卡行的 BIN NO.
第7—12位 卡顺序号
第13位 0 代表主卡，1-9 代表副卡
第14位 代表卡结单发出日期
第15位 代表该卡为第几张卡，补发卡后会加1
第16位 检验码
维萨卡（VISA）
卡号长度：16位（以前有极少数的卡为13位，现已停止发行了）
卡号范围：400000 — 499999

万事达卡（MasterCard）
卡号长度：16位
卡号范围：510000 — 559999

美国运通卡（American Express）
卡号长度：15位
卡号范围：340000 — 349999，370000 — 379999


大莱卡（DinersClub）
卡号长度：14位
卡号范围：300000 — 305999，309500 — 309599，360000 — 369999，380000 — 399999


日本国际卡（JCB）
卡号长度：16位
卡号范围：352800 — 358999

Discover card 6011

6011111111111117
*/
function checkcard(){
	
	cardNumber=$('#input_card').val()+"";
	if(cardNumber.length<14 || cardNumber.length>16){
		return "";
	}
	var leftnumber=parseInt(cardNumber.substr(0,4))
	switch(cardNumber.length){
		case 16:
			if(leftnumber>=4000 && leftnumber<=4999){
				return "VI";
			}
			if(leftnumber>=5100 && leftnumber<=5599){
				return "MA";
			}
			if(leftnumber>=3528 && leftnumber<=3589){
				return "JC";
			}
			if(leftnumber==6011){
				return "DS"
			}
			break;
		case 15:
			if(leftnumber>=3400 && leftnumber<=3499){
				return "AE";
			}
			if(leftnumber>=3700 && leftnumber<=3799){
				return "AE";
			}
			break;
		case 14:
			if(leftnumber>=3000 && leftnumber<=3059){
				return "DC";
			}
			if(leftnumber==3095 ){
				return "DC";
			}
			if(leftnumber>=3600 && leftnumber<=3699){
				return "DC";
			}
			if(leftnumber>=3800 && leftnumber<=3999){
				return "DC";
			}	
			break;
	}
	return "";
}
$(function(){
	//读取cookie-----------------
	
	checkstr="input:not([id$='_e'])[id^='input_']"
	//checkstr="input[id^='input_']"
	$(checkstr).each(function(){
		$(this).val(getCookies($(this).attr("id"),0))
		$.cookie($(this).attr("id"),$(this).val());
	}); 
	sameAddressMode=getCookies("input_same",1)
	
	//checkstr="#[id^='menu_']";
	checkstr="td[id^='menu_']";
	for(var i=0;i<INFO_popupValue.length;i++){
		$('#'+INFO_popupValue[i].name).html(INFO_popupValue[i].value[0].text)
		$('#'+INFO_popupValue[i].name).attr("value",INFO_popupValue[i].value[0].id)
	}
	$(checkstr).each(function(){
		tempstr=getCookies($(this).attr("id"),0)
		if(tempstr != ""){
			$(this).html(getlabel($(this).attr("id"),tempstr));
			$(this).attr("value",tempstr);
		}
		//$.cookie($(this).attr("id"),$(this).val());
	}); 
	if($('#input_month').val() != ""){
		$('#input_month').removeClass("smallBarM");
		$('#input_month').addClass("smallBar");
	}
	if($('#input_year').val() != ""){
		$('#input_year').removeClass("smallBarY");
		$('#input_year').addClass("smallBar");
	}
	//$("#[id^='input_']").val("");
	$("img[id$='_e']").hide();
	$('#color_0').bind({
		click:function(event){showColor(0);}
	});	
	$('#color_1').bind({
		click:function(event){showColor(1);}
	});	
	//监听键盘，只允许输入数字和小数点
	$("#inputNumber").keypress(function(event) {
		var keyCode = event.which;
		if ( (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127){
			return true;
		}else{
			return false;
		}
		}).focus(function() {
			this.style.imeMode='disabled';
	});
	 $("#inputNumber").blur(function(){
	 	if(parseInt($('#inputNumber').val())==0 || $('#inputNumber').val()==""){
			$('#inputNumber').val(1)
		}
		quantity=parseInt($('#inputNumber').val());
		showTotal()
	 });
	 
	$('#addNumber').bind({
		click:function(event){changeNum(1);}
	});	
	$('#minNumber').bind({
		click:function(event){changeNum(-1);}
	});	
	
	$('#input_card').bind({
		blur:function(event){
			var v=checkcard();
			if (v==""){
				cardStation=false
				$('#info_pay').html("Credit card cannot be identified")
				$('#input_card_e').show();
			}else{
				cardStation=true
				$('#info_pay').html(getlabel("menu_pay",v))	
				$('#input_card_e').hide();
			}
		}
	});	
	$("td[id^='menu_']").each(function(){
			$(this).click(function(){showpop($(this).attr("id"))})
	});
	$('#PRO_sel').bind({
			change:function(event){
				$(this).fadeOut();
				$("#"+currentPopName).html($(this).find("option:selected").text())
				
				$("#"+currentPopName).attr("value",$(this).find("option:selected").val())
				
				$("#"+currentPopName).css("color","#6b6b6b");
				var value=$("#"+currentPopName).attr("value")
				var showValue;
			
				
			}
	});
	
	$(".numInput").keypress(function(event) {
			var keyCode = event.which;
			if ( (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
				return true;
			else
				return false;
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		$(".phoneInput").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 45 || keyCode == 32 || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
				return true;
			else
				return false;
			}).focus(function() {
				this.style.imeMode='disabled';
	});
	$("#checkout").bind({
			click:function(){
				saveValue();
				checkOut();
			}
	});
	$("#goback").bind({
			click:function(){
				saveValue();
				location.href="purchase.php";
			}
	});
	
	$('#changeAddStation').bind({
			click:function(){
				sameAddressMode=1-sameAddressMode
				checkSameAdd();
				}
	});
	
	$('input').bind({
			focus:function(){ 
			$("#PRO_sel").hide();
		}
	});
	checkSameAdd();
	$('#main').show();
});
function checkSameAdd(){
	if(sameAddressMode==0){
		$('#shippingAddress').show()
		$('#checkSame').attr('src',"images/p_box.jpg");	
		
	}else{
		$('#shippingAddress').hide()
		$('#checkSame').attr('src',"images/p_box_c.jpg");
		
	}
	$('#input_same').val(sameAddressMode)
}
function checkOut(){
	if(!cardStation){
		$('#input_card_e').show()
		return
	}
	$('#input_miss').val(0)
	if(sameAddressMode==0){
		checkstr="input:not([id$='_e']):not([id$='_u'])[id^='input_']"
	}else{
		checkstr="input:not([id$='_e']):not([id$='_u']):not([id*='_s_'])[id^='input_']"
	}
	$(checkstr).each(function(){
		if($(this).val()==""){
			$('#input_miss').val(1)
			if($(this).attr("id")=="input_pay"){
				$('#input_card_e').show();
			}else{
				$("#"+$(this).attr("id")+"_e").show()
			}
		}else{
			$("#"+$(this).attr("id")+"_e").hide()
		}
	}); 
	if(($('#input_scode').html()).length<3){
		$('#input_miss').val(0)
		$('#input_scode_e').show()
	}
	if($('#input_miss').val()==0){
		location.href="purchase-check.php"
	}
	
}
function changeNum(num){
	quantity=parseInt($('#inputNumber').val());
	quantity+=num
	if(quantity<1){quantity=1}
	if(quantity>9999){quantity=9999}
	$('#inputNumber').val(quantity);
	showTotal();
}
function showTotal(){
	var totalNum=quantity*11999
	$('#priceBig').html("$"+parseInt(totalNum/100)+".");
	var subNum=totalNum-100*parseInt(totalNum/100)
	if(subNum>9){
	$('#priceSmall').html(subNum);
	}else{
	$('#priceSmall').html(subNum+"0");	
	}
	$('#priceBigTotal').html($('#priceBig').html())
	$('#priceSmallTotal').html($('#priceSmall').html())
}
function showColor(cid){
	$('.colorChoice').removeClass("greenBorder");
	//$('.colorChoice').removeClass("whiteBorder");
	$('#color_'+cid).addClass("greenBorder");
	//$('#color_'+(1-cid)).addClass("whiteBorder");
	colorID=cid;
}

