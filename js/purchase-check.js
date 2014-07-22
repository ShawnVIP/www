document.write("<script type='text/javascript' src='js/reglogin.js'></"+"script>"); 

var pageID=4; // userpage
var pageName="purchase";
var sameAddressMode=0
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
var colorList=["Black","White"];
var cardList=[{id:'VI',text:'VISA'},{id:'JC',text:'JCB'},{id:'MA',text:'Mastercard'},{id:'DC',text:'Diners Club Intenational'},{id:'AE',text:'American Express'}];
var countryList=[{id:'America',text:'America'}]
var shipList=[{id:'GR',text:'Ground:'},{id:'SE',text:'Second day:'},{id:'NE',text:'Next day:'}];
var shipCostList=[{id:'GR',text:9.99},{id:'SE',text:14.99},{id:'NE',text:19.99}];
var totalCost=0
function getValuefromList(list,id){
	for(var i=0;i<list.length;i++){
		if(list[i].id==id){
			return list[i].text
		}
	}
}

$(function(){
	checkstr="input[id^='input_']"
	$(checkstr).each(function(){
		var mname=$(this).attr("id")
		var mvalue=getCookies($(this).attr("id"),0)
		switch(mname){
			case "input_quantity":
				totalCost+=parseInt(mvalue)*11999
				break;			
		}
		$(this).html(mvalue)
	});
	sameAddressMode=getCookies("input_same",1)
	checkstr="td[id^='menu_']"
	$(checkstr).each(function(){
		var mname=$(this).attr("id")
		var mvalue=getCookies($(this).attr("id"),0)
		switch(mname){
			case "menu_colorID":
				mvalue=colorList[mvalue]
				break;
			case "menu_pay":
				mvalue=getValuefromList(cardList,mvalue)
				break;
			case "menu_ship":
				mvalue=getValuefromList(shipList,mvalue)
				break;
			case "menu_shipCost":
				mvalue=getValuefromList(shipCostList,mvalue)
				totalCost+=mvalue*100
				mvalue="$"+mvalue
				break;			
		}
		$(this).html(mvalue)
	});
	totalCost="$"+totalCost
	$('#menu_totalCost').html(totalCost.substring(1,totalCost.length-2)+"."+totalCost.substring(totalCost.length-2,totalCost.length));
	$("#goback").bind({
			click:function(){
				location.href="purchase-pay.php";
			}
	});
	if(sameAddressMode==1){
		$('#sameinfo').show()
		$('#shipaddress').hide()	
	}else{
		$('#sameinfo').hide()
		$('#shipaddress').show()	
	}
});
