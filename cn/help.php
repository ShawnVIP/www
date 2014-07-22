<?php
$lang="cn";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<style type="text/css">



.textContent{
	padding-top:80px
	 ;width:1000px
}
.textContent div {
	width: 790px;
	position: relative;
	padding-left:100px;
}
.imgTable {width:200px; vertical-align:top; padding-top:10px}
.txtTable { padding:0px 20px 40px 0px;}
.bigGreenText {font-size:24px; color:#66bd00;}
.qtext {font-size:14px; color:#66bd00;}


#menuarea{ background:url(../images/help_menuback.png) bottom no-repeat; padding-top:41px; padding-left:50px;}

.que{padding-top:10px; padding-bottom:10px; cursor:pointer}
.ans{margin-left:10px;}
#btnArea {width:1000px;height:260px; background:white; }
#help_table {padding:40px 100px 70px 90px;}
.contentArea {	
	width:1000px; background:url(../images/help_back.jpg) bottom repeat-x;
}
#a1 {background:url(../images/help_img_r1_c12.png) center right no-repeat;}
#contacts {
	width: 193px;
	height: 41px; position:relative
	
}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7840951-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
var LANG="cn";
</script>
<script>var pageID=13</script>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/reglogin.js"></script>
<script type="text/javascript" src="../js/jquery.corner.js"></script>
<script>
var oldid=0
$(function(){
	$(".ans").hide();
	for(var i=1;i<=8;i++){
		$('#t'+i).attr("qid",i)
		$('#t'+i).attr("showmode",0)
		$('#t'+i).bind({
			click:function(event){
				
				showans($(this).attr("qid"));
				
			}
		});	
	}
	buildButton('contacts');
	
	$('#contacts').bind({
			click:function(){
				var ifr = document.createElement('iframe');           
				ifr.src = 'mailto:info@sense-u.com';           
				document.body.appendChild(ifr);           
				document.body.removeChild(ifr);           
				
			}
		});
});

function showans(sid){
	if(sid== oldid){
		$("#a"+sid).slideToggle(); 	
		$('#q'+sid+" img").attr("src","../images/help_arr1.png");
		oldid=0
		return false
		
	}
	for(i=1;i<=8;i++){
		if(i==sid ||i== oldid){
			$("#a"+i).slideToggle(); 	
			if(i==sid){
				$('#q'+i+" img").attr("src","../images/help_arr0.png");
			
			}
			if(i==oldid){
				$('#q'+i+" img").attr("src","../images/help_arr1.png");
			}		
		}
	}
	oldid=sid
}

</script>
</head>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7840951-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<body> 
<div id="main"> 
    
   		<div  class="G_bigRoundShadow contentArea">
      		<div class="G_leftLabelBig">帮助</div>
            <div class="textContent">
            <div class="bigGreenText">常见问题</div><div id="menuarea"><table style="margin-left:50px" cellpadding="1" cellspacing="0"><tr>
              <td><img src="../images/help_btn_r1_c1.png" width="208" height="49" /></td><td><img src="../images/help_btn_r1_c3.png" width="208" height="49" /></td><td><img src="../images/help_btn_r1_c5.png" width="208" height="49" /></td></tr></table></div>
              <div class="blank"></div>
              <div id="q1" class="que"><span><img src="../images/help_arr1.png" width="13" height="20" /></span><span class="qtext" id="t1">我该如何开始使用Sense-U</span></div>
              <div id="a1" class="ans">
              <table width=480 ><tr  ><td style="padding:5px">
              <table border="0" cellpadding="0" cellspacing="0"><tr><td class="G_contentBlack">开始使用Sense-U只需要花您几分钟时间。</td></tr>
              <tr><td class="G_contentBlack" style="padding-top:10px; padding-bottom:10px">
              
              <table bgcolor="#66bd00" cellpadding="0" cellspacing="1"><tr bgcolor="#FFFFFF"><td><ol style="padding-left:25px; margin-top:0px; margin-bottom:0px;">
<li style="padding:0px">首先，到<a href="download.php" target="_self">这里</a>下载并安装 Sense-U 适用于 Windows 或 Mac 的桌面应用程序。</li>
<li>安装完成后，系统会提示您创建一个新的帐户，或请使用您现有的ID登录，这个账号会和您在登录www.sense-u.com时使用的一样。</li>
<li>之后，你会被要求插入USB底座，之后就可以跟着教程通过程序来注册你的Sense-U设备。</li></ol></td></tr></table>
</td></tr> <tr><td class="G_contentBlack">Sense-U桌面应用程序将与您Sense-U无线自动同步，并实时将您的数据在线更新。</td></tr></table>
              </td></tr>
             </table>
              </div>
              <div id="q2" class="que"><span><img src="../images/help_arr1.png" width="13" height="20" /></span><span class="qtext" id="t2">我如何佩戴Sense-U？</span></div>
              <div id="a2" class="ans"><table><tr><td class="G_contentBlack">超便携的Sense-U可以随心配戴。你可以将它夹在衬衣、外套、运动服、背包上，甚至夹在内衣上也完全没问题。无论您在日常工作、跑步、睡觉时，Sense-U都可以正常工作。</td></tr></table></div>
              
              <div id="q3" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t3">Sense-U桌面应用程序是什么？</span></div>
              <div id="a3" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">您可以下载Sense-U桌面应用程序，它可以在Windows和Mac上运行。这个程序可以帮您直接通过无线基站和网络上传您的Sense-U数据。</td>
                  </tr>
                </table>
              </div>
              <div id="q4" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t4">我如何判断桌面应用程序工作是否正常？</span></div>
              <div id="a4" class="ans">
                <table width=100%  border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="G_contentBlack"><table width=100%><tr><td>Sense-U的小图标会出现在您系统托盘或菜单栏里。这样，你就会通过小图标的颜色来判断桌面应用程序的工作是否正常。在Windows 7中，Sense-U的图标会在您系统托盘的如下位置：</td></tr>
                    <tr><td><table width=400 align=center>
                    <tr align=center>
                      <td><img src="../images/help_img_r3_c5.png" width="132" height="41" /></td>
                      <td><img src="../images/help_img_r3_c10.png" width="132" height="41" /></td></tr> <tr align=center><td>正常工作</td><td>底座未连接</td></tr></table>
                    
                    </td></tr></table>
                    </td>
                  </tr>
                </table>
              </div>
              <div id="q5" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t5">如何访问我的在线数据？</span></div>
              <div id="a5" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack"><table border="0" cellpadding="0" cellspacing="0"><tr><td>您的在线数据随时待您查阅，您可以登录：<span class="G_contentGreen">www.sense-u.com</span> 并通过您的账户进行查看。从这里，你可以细致的了解您的健身进度和睡眠情况。</td></tr><tr>
                    <td height="340" align=center><img src="../images/help_img_r5_c2.png" width="613" height="326" /></td></tr></table> </td>
                  </tr>
                </table>
              </div>
              <div id="q6" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t6">我的在线数据安全吗？</span></div>
              <div id="a6" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">我们使用AES-256的标准来加密您在www.sense-u.com存储的每个数据。这是和银行保护客户数据采用的相同加密标准。数据在上传之后，我们就会在存储时进行加密并妥善管理加密密钥。Sense-U使用亚马逊S3存储数据。亚马逊将数据存储在多个不同大型的数据中心。据亚马逊介绍，他们使用的是军工级别的外围控制护堤、视频监控、和专业的保安人员，以保证他们数据中心的物理安全。
<br />你可以在亚马逊网络服务的网站查看到关于亚马逊的安全性的更多信息。
<br />对于分布式拒绝服务（DDoS）攻击，中间人（MITM）攻击，以及数据包嗅探网络安全问题，亚马逊和Sense-U也采用了针对性的、有效的保护。
</td>
                  </tr>
                </table>
              </div>
              <div id="q7" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t7">能介绍下Sense-U的隐私政策吗？</span></div>
              <div id="a7" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">我们的私隐政策的副本可以在<span class="G_contentGreen"><a href="privacy.php">这里</a></span>找到。总之，对任何人，以任何理由，在任何时候，我们也不会出售或出租您的个人信息，尤其是用户数据。我们会尽最大努力保护您的隐私，使您的信息免受未经授权的访问。</td>
                  </tr>
                </table>
              </div>
<div id="q8" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t8">Sense-U的退货政策是怎样的？</span></div>
<div id="a8" class="ans">
  <table>
    <tr>
      <td class="G_contentBlack">Sense-U为您提供了30天的退款保证。如果你对从Sense-U在线商城购买的产品不是很满意，无论什么原因，你都可以在发货后30天内退回它并得到全额退款。要进行退款并准备退回产品时，你可以给<span class="G_contentGreen"><a href="mailto:support@sense-u.com">support@sense-u.com</a></span>发送电子邮件。如果您购买产品被认为是有问题的，我们将提供一个返回货运标签，以支付返回的运费。否则，这部分成本将由您承担。
</td>
    </tr>
  </table>
</div>
               
          </div>
          <div id="btnArea"> <div id="help_table"><table><tr><td colspan="2" class="bigGreenText">需要更多帮助？</td></tr>
          <tr>
            <td rowspan="3"><img src="../images/help_img_r7_c1.png" width="136" height="121" /></td></tr>
          <tr>
            <td  class="G_contentBlack"><p>如果你有特殊的问题，如银行账户、交易、或无法在社区论坛得到答案的，你可以在这里联系客服。您通常会在24小时内得到回复。</p></td>
          </tr>
          <tr>
            <td><div id="contacts">联系 Sense-U</div></td>
          </tr>
          </table>
          </div>
         
          </div> <div class="blank"></div>
    	</div>
	
</div>
</body>
</html>
