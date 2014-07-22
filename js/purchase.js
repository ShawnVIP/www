
document.write("<script type='text/javascript' src='../js/reglogin.js'></"+"script>"); 

var pageID=4; // userpage
var maxIndex=100;
var quantity=1;
var colorID=0;
var pageName="purchase";
var colorName=["Black","White"];
function getCookies(cname,tmode){
	var cvalue=$.cookie(cname);	
	if(tmode==1 && cvalue==null){
		cvalue=0;
	}
	if(tmode==0 && cvalue==null){
		cvalue="";
	}
	return cvalue;
}
$(function(){
	//读取Cookies
	
	if(quantity==0){quantity=1;}
	$('#color_0').bind({
		click:function(event){showColor(0);}
	});	
	$('#color_1').bind({
		click:function(event){showColor(1);}
	});	
	showColor(colorID);
	showTotal();
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
			$('#inputNumber').val(1);
		}
		quantity=parseInt($('#inputNumber').val());
		showTotal();
	 });
	 
	$('#addNumber').bind({
		click:function(event){changeNum(1);}
	});	
	$('#minNumber').bind({
		click:function(event){changeNum(-1);}
	});	

	showColor(colorID);
});
function changeNum(num){
	quantity=parseInt($('#inputNumber').val());
	quantity+=num;
	if(quantity<1){quantity=1;}
	if(quantity>9999){quantity=9999;}
	$('#inputNumber').val(quantity);
	showTotal();
}
function showTotal(){
	var totalNum=quantity*9998;
	$('#priceBig').html("$"+parseInt(totalNum/100)+".");
	var subNum=totalNum-100*parseInt(totalNum/100);
	if(subNum>9){
	$('#priceSmall').html(subNum);
	}else{
	$('#priceSmall').html(subNum+"0");	
	}
	$('#priceBigTotal').html($('#priceBig').html());
	$('#priceSmallTotal').html($('#priceSmall').html());
	$('#inputNumber').val(quantity);
	outPay();
}
function showColor(cid){
	$('.colorChoice').removeClass("greenBorder");
	//$('.colorChoice').removeClass("whiteBorder");
	$('#color_'+cid).addClass("greenBorder");
	//$('#color_'+(1-cid)).addClass("whiteBorder");
	$('#p_product img').attr('src','../images/p_product_'+cid+'.png');
	colorID=cid;
	outPay();
}

function outPay(){
	/*
	str='<form action="savepurchase.php" method="POST">';
	str+='<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"';
    str+=' data-key="pk_test_MdtM7lXaGy1geFw0lJMPIeHn"';
   	//str+=' data-amount="'+ quantity*9998+'"';
	str+=' data-amount="'+ quantity*100+'"';
    str+=' data-name="sense-u purchase"';
    str+=' data-description="'+quantity+' '+colorName[colorID]+' sensors"';
    str+=' data-shipping-address=""';
    str+=' data-billing-address=""';
    str+=' data-image="128x128.png"></'+'script></form>';
	*/
	totalamount=quantity*9998;
	//totalamount=quantity*100;
	desc=quantity+'_'+colorName[colorID]+'_Sense-U_Device.';
	back_ucode=$.cookie('back_ucode');
	back_scode=$.cookie('back_scode');
	
	str='<form action="savepurchase.php?amount='+totalamount+'&desc='+desc+'&ucode='+back_ucode+'&scode='+back_scode+'"  method="POST">';
  	str+='<script ';
    str+='src="https://checkout.stripe.com/checkout.js" class="stripe-button"';
    str+=' data-key="pk_live_IaFABXjser7H5FuhXu9MkQ1u"';
    //str+=' data-key="pk_test_ItNxf13zVRs80qLXYKe2Cpda"';
    str+=' data-image="logo.jpg" ';
    str+=' data-name="sense-u purchase"';
	str+=' data-billing-address=true'; 
	str+=' data-shipping-address=true'; 
	str+=' data-email=""'; 
	
    str+=' data-description='+desc;
    str+=' data-amount="'+totalamount+'">';
  	str+='<' + '/script>';
	str+='</form>';
  	$("#payit").html(str);
}

