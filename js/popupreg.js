// JavaScript Document
var txtLib=({
	reg_mailSubject:{cn:"请求协助找回密码",en:"need help on forget passward"},
	reg_enterPass:{cn:"输入您的密码.",en:"Please enter your password."},
	reg_noMathPass:{cn:"两次输入的密码不一致.",en:"This does not match the password entered above."},
	reg_unknowErr:{cn:"未知错误.",en:"unknown error."},
	reg_enterEmail:{cn:"输入您的电子邮箱.",en:"Please enter your email address."},
	reg_enterValEmail:{cn:"输入有效的电子邮箱.",en:"Please use a valid email address."},
	reg_emailExist:{cn:"该邮箱已被注册.",en:"Email has already been used."},
	reg_emailNoExist:{cn:"该邮箱不存在.",en:"Email does not exist."},
	reg_passSorter:{cn:"密码长度需不少于6个字符.",en:"Password must be at least 6 characters."},
	reg_noCheck:{cn:"请选择同意隐私与条款.",en:"Please check you agree the terms of service."},
	reg_resetOK:{cn:"密码已改变，请重新登录.",en:"Password already be change."},
	reg_sendOK:{cn:"邮件发送成功，如果10分钟内没有收到邮件，请检查垃圾邮件箱，或者再次发送。若始终无法接收到，请<span class='btnHand' id='getPassHelpAfter'>点击这里</span>联系我们.",en:"Your email is on its way!<br>For your security. If you don't see the email in the next 10 minutes, check your spam folder first or try sending it again. Still don't see it? Please <span class='btnHand' id='getPassHelpAfter'>contact us</span>."},
	reg_forgetInfo:{cn:"输入您的电子邮箱地址，我们将发送一封邮件指导您如何重设密码。",en:"Enter your email address and we'll send you an email with instructions to reset your password."},
	reg_errAccount:{cn:"用户不存在或者密码错误.",en:"User does not exist or password is incorrect."},
	reg_findPass:{cn:"密码找回",en:"Get Password"},
	reg_fogetinfo:{cn:"输入您注册使用的电子邮箱，我们会发一封邮件用于密码找回。",en:"Enter your email address and we'll send you an email with instructions to reset your password."},
	reg_cont:{cn:"继续",en:"Countinue"},
	reg_close:{cn:"关闭",en:"Close"},
	reg_login:{cn:"登录",en:"Login"},
	reg_email:{cn:"电子邮箱",en:"Email Address"},
	reg_pass:{cn:"密码",en:"Password"},
	reg_repass:{cn:"再次输入密码",en:"Retype Password"},
	reg_forget:{cn:"忘记密码?",en:"Forgot your password?"},
	reg_keepmail:{cn:"在此计算机上保留电子邮箱地址",en:"Remember my email on this computer"},
	reg_nous:{cn:"还不是我们的一员?",en:"Still not a member?"},
	reg_joinNow:{cn:"现在加入",en:"Join now"},
	reg_reg:{cn:"注册",en:"Sign Up"},
	reg_agree:{cn:"我同意",en:"By signing up, I agree to the "},
	reg_prav:{cn:"条款和各项条件",en:"Terms of Service"},
	reg_already:{cn:"已经是我们的一员?",en:"Are you already member?"},
	reg_loginNow:{cn:"现在登录",en:"Login now"},
	reg_resetPass:{cn:"密码重设",en:"Reset Password"},
	reg_createPass:{cn:"创建一个新密码",en:"Create a new password"},
    reg_resetBtn:{cn:"重设",en:"Reset"},
	reg_newuser:{cn:"新用户",en:"New user"},
});

var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate();
	
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  

function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}
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


	$(function(){
		$('#l_findpass').text(getText('reg_findPass'));
		$('#find_email').text(getText('reg_email'));
		$('#forget_back').text(getText('reg_fogetinfo'));
		$('#btnForget').text(getText('reg_cont'));
		$('#btnClose').text(getText('reg_close'));
		$('#l_login').text(getText('reg_login'));
		$('#login_email').text(getText('reg_email'));
		$('#login_pass').text(getText('reg_pass'));
		$('#forgetpass').text(getText('reg_forget'));
		$('#keepEmail').text(getText('reg_keepmail'));
		$('#pop_btnLogin').text(getText('reg_login'));
		$('#noJoin').text(getText('reg_nous'));
		$('#loginToSignUp').text(getText('reg_joinNow'));
		$('#l_reg').text(getText('reg_reg'));
		$('#reg_email').text(getText('reg_email'));
		$('#reg_pass').text(getText('reg_pass'));
		$('#reg_repass').text(getText('reg_repass'));
		$('#reg_agree').text(getText('reg_agree'));
		$('#reg_prav').text(getText('reg_prav'));
		$('#btnSignup').text(getText('reg_reg'));
		$('#reg_already').text(getText('reg_already'));
		$('#signUpToLogin').text(getText('reg_loginNow'));
		$('#l_reset').text(getText('reg_resetPass'));
		$('#btnResetPass').text(getText('reg_resetBtn'));
		$('#res_create').text(getText('reg_createPass'));
		$('#res_pass').text(getText('reg_pass'));
		$('#res_repass').text(getText('reg_repass'));
		
		//$('.mainFrame').hide();
		buildButton('btnSignup');
		buildButton('pop_btnLogin');
		buildButton('btnForget');
		buildButton('btnClose');
		buildButton('btnResetPass');
		$('.mainFrame').css("top",0);
		$('.mainFrame').css("left",0);
		//-------------------三个圆角------------------
		$('.mainFrame').corner();
		//------------三个关闭
		$('#regClose').click(function(){
  			//$('#regBack').hide();
			
			if(parent.pageID==2){return;}
			$('#regArea').hide();
			parent.hidePop('popupReg');
		});
		$('#loginClose').click(function(){
  			//$('#regBack').hide();
			
			if(parent.pageID==2){return;}
			$('#loginArea').hide();
			parent.hidePop('popupReg');
		});
		$('#resetClose').click(function(){
			parent.hidePop('popupReg');
		});
		
		$('#forgetClose').click(function(){
  			//$('#regBack').hide();
			if(parent.pagdID==2){return;}
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
			mouseenter:function(event){showover($(this).attr("id"));},
			mouseleave:function(event){showout($(this).attr("id"));}
		});	
		
		$('#btnSignup').click(function(){checkSignUp();});
		$('#btnForget').click(function(){checkForget();});
		$('#pop_btnLogin').click(function(){checkLogin();});
		$('#getPassHelp').click(function(){getHelp();});
		$('#btnResetPass').click(function(){checkReset();});
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
		window.open("mailto:info@sense-u.com?subject="+getText('reg_mailSubject'));
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
        	$('#wrongResetPass').html(getText('reg_enterPass'));
			$('#ResetInputPass').focus();
       	 	return false;
    	}
		if(jpass !=rpass){
			$('#wrongResetPass').html(getText('reg_noMathPass'));
			$('#ResetInputPass').focus();
			return false;
		}
		var outData={ucode:$.cookie('back_ucode'),umail:$.cookie('back_umail'),passkey:$.cookie('back_passkey'),password:jpass};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/resetpass.php',
			data:JSON.stringify(outData), 
			success: function (msg) {dealResetBack(msg);},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				enableSignUpArea();
				$('#wrongResetPass').html(getText('reg_unknowErr')); 
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
        	$('#wrongEmail').html(getText('reg_enterEmail'));
			$('#signInputEmail').focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		
		if(!reg.test(jmail)){
        	$('#wrongEmail').html(getText('reg_enterValEmail'));
			$('#signInputEmail').focus();
       	 	return false;
    	}
		if(jpass==""){
        	$('#wrongPass').html(getText('reg_enterPass'));
			$('#SignInputPass').focus();
       	 	return false;
    	}
		if(jpass.length<6){
        	$('#wrongPass').html(getText('reg_passSorter'));
			$('#SignInputPass').focus();
       	 	return false;
    	}
		if(jpass !=rpass){
			$('#wrongPass').html(getText('reg_noMathPass'));
			$('#SignInputPass').focus();
			return false;
		}
		/*
		$('#btnSignup').attr('src','images/pop_login.gif');
		$('#btnSignup').width(32);
		$('#btnSignup').height(32);
		*/
		
		
		if(! $("input[name='agreeSignUp']").is(':checked')){
			$('#pop_regWrong').html(getText('reg_noCheck'));
			return false;
		}
		
		$('#btnSignup').unbind("click"); 
		$('.popupLongText').attr('disabled', "disabled"); 
		$('.popupShortText').attr('disabled', "disabled"); 
		
		var outData={email:jmail,password:jpass,source:"w",lang:LANG};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/signup.php',
			data:JSON.stringify(outData), 
			success: function (msg) {dealSignUpBack(msg);},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				enableSignUpArea();
				$('#wrongPass').html(getText('reg_unknowErr')); 
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
			$('#wrongPass').html(getText('reg_unknowErr')); 
		}else{
			
			showLogin();
			$('#pop_loginEmail').val($.cookie('back_umail'));
			$('#loginWrongPass').html(getText('reg_resetOK'));
		}
		
	}
	function dealSignUpBack(value){
		//-------------注册成功后，返回userid--因为此注册没有传感器信息，所以没有个人信息可以返回--------
		var status=value.status;
		if(status==400){
			$('#wrongEmail').html(getText('reg_emailExist'));
			enableSignUpArea();	
			return;
		}
		if(status==201){ //--------OK
			$.cookie('back_ucode', value.userInfo.ucode,{path:'/', expires:1000});
			$.cookie('back_scode', value.userInfo.scode,{path:'/', expires:1000});
			$.cookie('back_ecode', value.userInfo.ecode,{path:'/', expires:1000});
			$.cookie('back_loginMode', "1",{path:'/', expires:1000});
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
			$('#loginWrongEmail').html(getText('reg_enterEmail'));
			loginEmail.focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		if(!reg.test(jmail)){
        	$('#loginWrongEmail').html(getText('reg_enterValEmail'));
			loginEmail.focus();
       	 	return false;
    	}

		if(jpass=="" ){
        	$('#loginWrongPass').html(getText('reg_enterPass'));
			loginPass.focus();
       	 	return false;
    	}
		
		$.cookie('tempEmail', jmail);
		$('#pop_btnLogin').css('cursor','auto');
		$('#pop_btnLogin').unbind("click") ;
		$('.pop_loginInput').attr('disabled', "disabled"); 
		
		var outData={email:jmail,password:jpass,ndate:mytime,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/login.php',
			data:JSON.stringify(outData), 
			success: function (msg) {
				//enableLoginArea();
				//parent.document.getElementById('topmenu').contentWindow.dealLoginRes(msg);
				dealLoginRes(msg);
        	},
 			error: function(XMLHttpRequest, textStatus, errorThrown) {
                enableLoginArea();
				$('#pop_loginWrong').html(getText('reg_unknowErr')); 
             }
		});

		//-------------------send to server --------------
	}
	
	function dealLoginRes(value){
		
		if(value.status==200){
			self.location='senseu.php';
			$.cookie('back_ucode', value.userInfo.ucode,{path:'/', expires:1000});
			$.cookie('back_scode', value.userInfo.scode,{path:'/', expires:1000});
			$.cookie('back_ecode', value.userInfo.ecode,{path:'/', expires:1000});
			
			$.cookie('back_loginMode', "1");
			if($('input[name="saveEmailCookies"]:checked')){
				$.cookie('userEmail', $('#pop_loginEmail').val(),{path:'/', expires:1000});
			}else{
				$.cookie('userEmail', null);
			};
			parent.location="senseu.php";
		}else{
			enableLoginArea();
			$('#loginWrongEmail').html(getText('reg_errAccount'));
			$('#loginWrongPass').html(getText('reg_errAccount'));
			
		}
	}
	
	function enableLoginArea(){

		$('#pop_btnLogin').css('cursor','pointer');
		$('#pop_btnLogin').click(function(){checkLogin();});
		$('.pop_loginInput').removeAttr("disabled"); 
	}
//--------------check forget

	function checkForget(){
		$('.blankRow').html("");
		var mail=$('#pop_forgetEmail').val();
		if(mail==""){
        	$('#pop_forgetWrong').html(getText('reg_enterEmail'));
			$('#pop_forgetEmail').focus();
       	 	return false;
    	}
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
		if(!reg.test(mail)){
        	$('#pop_forgetWrong').html(getText('reg_enterValEmail'));
			$('#pop_forgetEmail').focus();
       	 	return false;
    	}

		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
        	//url: 'http://184.72.40.64/api/index.php/users',
			url:'../res/forget.php',
        	data:'{"email":"'+mail+'"}', 
        	success: function (msg) {
				dealForgetBack(msg);
        	},
 			error: function(XMLHttpRequest, textStatus, errorThrown) {
               
				$('#pop_forgetWrong').html(getText('reg_unknowErr')); 
             }
    	});

	}
	function dealForgetBack(value){
		var status=value.status;
		if(status==401){
			$('#pop_forgetWrong').html(getText('reg_emailNoExist'));
			//enableSignUpArea();	
			return;
		}
		if(status==402){
			$('#pop_forgetWrong').html(value.message);
			//enableSignUpArea();	
			return;
		}
		if(status==200){ //--------OK
			$('#forget_back').html(getText('reg_forgetInfo'));
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
				$('#loginWrongEmail').html(obj.err);
			}else{
				$('#loginWrongPass').html(obj.err);
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
		$('#forget_back').html(getText('reg_forgetInfo'));
		$('#forgetArea').show();
		$('#btnClose').hide();
		$('#btnForget').show();
	}
	
	function hideParentBack(){
		$("#darkBack",parent.document).fadeOut();
	}