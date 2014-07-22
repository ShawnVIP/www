// JavaScript Document
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate()
	
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  

function request(paras){
		var url = location.href;
		var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
		var paraObj = {}
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


	$(function(){
		//$('.mainFrame').hide();
		$('.mainFrame').css("top",0);
		$('.mainFrame').css("left",0);
		//-------------------三个圆角------------------
		$('.mainFrame').corner();
		//------------三个关闭
		$('#regClose').click(function(){
  			//$('#regBack').hide();
			
			if(parent.pageID==2){return}
			$('#regArea').hide();
			parent.hidePop('popupReg');
		});
		$('#loginClose').click(function(){
  			//$('#regBack').hide();
			
			if(parent.pageID==2){return}
			$('#loginArea').hide();
			parent.hidePop('popupReg');
		});
		$('#resetClose').click(function(){
			parent.hidePop('popupReg');
		});
		
		$('#forgetClose').click(function(){
  			//$('#regBack').hide();
			if(parent.pagdID==2){return}
			$('#forgetArea').hide();
			parent.hidePop('popupReg');
		});
		//-------------两个切换-----------
		$('#signUpToLogin').click(function(){
			$('.blankRow').html("");
			$('#regArea').hide();
			$('#loginArea').show();
			//$("#loginArea").css("background:url(images/pop_c_bg.png) repeat-x");
  		});
		$('#loginToSignUp').click(function(){
			$('.blankRow').html("");
			$('#regArea').show();
			//$("#regArea").css("background:url(images/pop_c_bg.png) repeat-x");
			$('#loginArea').hide();
  		});
		$('#btnClose').click(function(){
			$('#forgetArea').hide();
			parent.hidePop('popupReg');
  		});
		//-=------三个检查-------------------
		$('.bigButton img').hide();
		$('.bigButton').bind({
			mouseenter:function(event){showover($(this).attr("id"))},
			mouseleave:function(event){showout($(this).attr("id"))}
		});	
		
		$('#btnSignup').click(function(){checkSignUp()});
		$('#btnForget').click(function(){checkForget()});
		$('#pop_btnLogin').click(function(){checkLogin()});
		$('#getPassHelp').click(function(){getHelp()});
		$('#btnResetPass').click(function(){checkReset()});
		//--------初始化赋值---------------------
		if($.cookie('userEmail') != null){
			$('#pop_loginEmail').val($.cookie('userEmail'));
			$('#saveEmailCookies').attr('checked','checked');
		}
		if($('#G_mode').val()=="forget"){
			showForget();
		}
		var frameid=$('#frameid').val();
		if(frameid !=""){$('#'+frameid).show();}
		
		$("#pop_loginPass").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 13)
				checkLogin();
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		$("#SignReInputPass").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 13)
				checkSignUp();
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		$("#pop_forgetEmail").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 13)
				checkForget();
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		//https://sense-u.com/test/popupreg.php?act=reset
		act=request("act");
		switch(act){
			case "reset":
			showReset();
			break;
			case "login":
			showLogin();
			break;
			case "signup":
			showSignUp();
			break;
		}
	});
	function getHelp(){
		window.open("mailto:info@sense-u.com?subject=need help on forget passward");
	}
	function showover(id){
		$('#'+id+' img').stop(false,true).fadeIn();
	}
	function showout(id){
		$('#'+id+' img').stop(false,true).fadeOut();
	}
	function checkReset(){
		$('.blankRow').html("");
		
		var jpass=$('#ResetInputPass').val();
		var rpass=$('#ResetReInputPass').val();
		if(jpass==""){
        	$('#wrongResetPass').html("Please enter your password.");
			$('#ResetInputPass').focus();
       	 	return false;
    	}
		if(jpass !=rpass){
			$('#wrongResetPass').html("This does not match the password entered above.");
			$('#ResetInputPass').focus();
			return false;
		}
		var outData={ucode:$.cookie('back_ucode'),umail:$.cookie('back_umail'),passkey:$.cookie('back_passkey'),password:jpass};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/resetpass.php',
			data:JSON.stringify(outData), 
			success: function (msg) {dealResetBack(msg);},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				enableSignUpArea();
				$('#wrongResetPass').html('unknown error.'); 
			}
		});

	}
	
	function checkSignUp(){
		
		//alert($("input[name='agreeSignUp']").attr('checked'));
		$('.blankRow').html("");
		var jmail=$('#signInputEmail').val();
		var jpass=$('#SignInputPass').val();
		var rpass=$('#SignReInputPass').val();
		if(jmail==""){
        	$('#wrongEmail').html("Please enter your email address.");
			$('#signInputEmail').focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		
		if(!reg.test(jmail)){
        	$('#wrongEmail').html("Please use a valid email address.");
			$('#signInputEmail').focus();
       	 	return false;
    	}
		if(jpass==""){
        	$('#wrongPass').html("Please enter your password.");
			$('#SignInputPass').focus();
       	 	return false;
    	}
		if(jpass.length<6){
        	$('#wrongPass').html("Password length could not less than 6.");
			$('#SignInputPass').focus();
       	 	return false;
    	}
		if(jpass !=rpass){
			$('#wrongPass').html("This does not match the password entered above.");
			$('#SignInputPass').focus();
			return false;
		}
		/*
		$('#btnSignup').attr('src','images/pop_login.gif');
		$('#btnSignup').width(32);
		$('#btnSignup').height(32);
		*/
		
		
		if(! $("input[name='agreeSignUp']").is(':checked')){
			$('#pop_regWrong').html("Please check you agree the terms of service.");
			return false;
		}
		$('#btnSignup').css('cursor','auto');
		$('#btnSignup').unbind("click") 
		$('.popupLongText').attr('disabled', "disabled"); 
		$('.popupShortText').attr('disabled', "disabled"); 
		
		var outData={email:jmail,password:jpass,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/signup.php',
			data:JSON.stringify(outData), 
			success: function (msg) {dealSignUpBack(msg);},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				enableSignUpArea();
				$('#wrongPass').html('unknown error.'); 
			}
		});

	}
	function enableSignUpArea(){

		$('#btnSignup').css('cursor','pointer');
		$('#btnSignup').click(function(){checkSignUp();});
		$('.popupLongText').removeAttr("disabled"); 
		$('.popupShortText').removeAttr("disabled"); 
	}
	function dealResetBack(value){
		var status=value.status;
		if(status!=200){
			$('#wrongPass').html('unknown error.'); 
		}else{
			
			showLogin();
			$('#pop_loginEmail').val($.cookie('back_umail'));
			$('#loginWrongPass').html("password reset ok, please login using new password");
		}
		
	}
	function dealSignUpBack(value){
		//-------------注册成功后，返回userid--因为此注册没有传感器信息，所以没有个人信息可以返回--------
		var status=value.status;
		if(status==400){
			$('#wrongEmail').html("email has already existed.");
			enableSignUpArea();	
			return;
		}
		if(status==201){ //--------OK
			$.cookie('back_ucode', value.userInfo.ucode);
			$.cookie('back_scode', value.userInfo.scode);
			$.cookie('back_ecode', value.userInfo.ecode);
			$.cookie('back_loginMode', "1");
			/*
			if($.cookie('afterLoginJump') == null){
				parent.location.reload()
			}else{
				parent.location=$.cookie('afterLoginJump');
			}
			*/
			parent.location="senseu.php";
			
		}
	}
	//---------------------check login
	function checkLogin(){
		$('.blankRow').html("");
		var loginEmail=$('#pop_loginEmail');
		var loginPass=$('#pop_loginPass');
		var errInfo=$('#loginWrongEmail');
		
		var jmail=$('#pop_loginEmail').val();
		var jpass=$('#pop_loginPass').val();
		
		
		if(jmail==""){
			$('#loginWrongEmail').html("Please enter your email address.");
			loginEmail.focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		if(!reg.test(jmail)){
        	$('#loginWrongEmail').html("Please use a valid email address.");
			loginEmail.focus();
       	 	return false;
    	}

		if(jpass=="" ){
        	$('#loginWrongPass').html("Please enter your password.");
			loginPass.focus();
       	 	return false;
    	}
		
		$.cookie('tempEmail', jmail);
		$('#pop_btnLogin').css('cursor','auto');
		$('#pop_btnLogin').unbind("click") 
		$('.pop_loginInput').attr('disabled', "disabled"); 
		
		var outData={email:jmail,password:jpass,ndate:mytime,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/login.php',
			data:JSON.stringify(outData), 
			success: function (msg) {
				//enableLoginArea();
				//parent.document.getElementById('topmenu').contentWindow.dealLoginRes(msg);
				dealLoginRes(msg);
        	},
 			error: function(XMLHttpRequest, textStatus, errorThrown) {
                enableLoginArea();
				$('#pop_loginWrong').html('unknown error.'); 
             }
		});

		//-------------------send to server --------------
	}
	
	function dealLoginRes(value){
		
		if(value.status==200){
			self.location='senseu.php';
			$.cookie('back_ucode', value.userInfo.ucode);
			$.cookie('back_scode', value.userInfo.scode);
			$.cookie('back_ecode', value.userInfo.ecode);
			
			$.cookie('back_loginMode', "1");
			if($('input[name="saveEmailCookies"]:checked')){
				$.cookie('userEmail', $('#pop_loginEmail').val(),{path:'/', expires:1000});
			}else{
				$.cookie('userEmail', null);
			};
			parent.location="senseu.php";
		}else{
			enableLoginArea();
			$('#loginWrongEmail').html('User does not exist or password is incorrect.');
			$('#loginWrongPass').html('User does not exist or password is incorrect.');
			
		}
	}
	
	function enableLoginArea(){

		$('#pop_btnLogin').css('cursor','pointer');
		$('#pop_btnLogin').click(function(){checkLogin()});
		$('.pop_loginInput').removeAttr("disabled"); 
	}
//--------------check forget

	function checkForget(){
		$('.blankRow').html("");
		var mail=$('#pop_forgetEmail').val();
		if(mail==""){
        	$('#pop_forgetWrong').html("Please enter your email address.");
			$('#pop_forgetEmail').focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		if(!reg.test(mail)){
        	$('#pop_forgetWrong').html("Please use a valid email address.");
			$('#pop_forgetEmail').focus();
       	 	return false;
    	}

		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
        	//url: 'http://184.72.40.64/api/index.php/users',
			url:'res/forget.php',
        	data:'{"email":"'+mail+'"}', 
        	success: function (msg) {
				dealForgetBack(msg);
        	},
 			error: function(XMLHttpRequest, textStatus, errorThrown) {
               
				$('#pop_forgetWrong').html('unknown error.'); 
             }
    	});

	}
	function dealForgetBack(value){
		var status=value.status;
		if(status==401){
			$('#pop_forgetWrong').html("email does not exist.");
			//enableSignUpArea();	
			return;
		}
		if(status==402){
			$('#pop_forgetWrong').html(value.message);
			//enableSignUpArea();	
			return;
		}
		if(status==200){ //--------OK
			$('#forget_back').html("Your email is on its way!<br>For your security, the reset email is only active for the next 24 hours. If you don't see the email in the next 10 minutes, check your spam folder first then try sending it again. Still don't see it? Please <span class='btnHand' id='getPassHelpAfter'>contact us</span>.");
			$('#getPassHelpAfter').click(function(){getHelp();});
			$('#btnForget').hide();
			$('#btnClose').show();
			
		}
	}
	function showSignUp(){
  		//$('#regBack').fadeTo(0,0.77);
		$('#forgetArea').hide();
		$('#loginArea').hide();
		$('#resetArea').hide();
		$('#regArea').show();
	}
	function showReset(){
  		//$('#regBack').fadeTo(0,0.77);
		$('#forgetArea').hide();
		$('#loginArea').hide();
		$('#resetArea').show();
		$('#regArea').hide();
	}
	//popupReg({mail:"",pass:jpass,mode:"email",err:"Please enter your email address."});
	function showLogin(obj){
		$('.blankRow').html("");
		if(obj != undefined){
			$('#pop_loginEmail').val(obj.mail);
			$('#pop_loginPass').val(obj.pass);
			if(obj.mode=="email"){
				$('#loginWrongEmail').html(obj.err)
			}else{
				$('#loginWrongPass').html(obj.err)
			}
		}
  		//$('#regBack').fadeTo(0,0.77);
		$('#forgetArea').hide();
		$('#loginArea').show();
		$('#regArea').hide();
		$('#resetArea').hide();
	}
	function showForget(){
		$('#loginArea').hide();
		$('#regArea').hide();
		$('#resetArea').hide();
		$('#forget_back').html("Enter your email address and we'll send you an email with instructions to reset your password.");
		$('#forgetArea').show();
		$('#btnClose').hide();
		$('#btnForget').show();
	}
	
	function hideParentBack(){
		$("#darkBack",parent.document).fadeOut();
	}