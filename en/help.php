<?php

$lang="en";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/main_<?php echo $lang; ?>.css" type="text/css" rel="stylesheet" />
<!--[if IE]><link rel="stylesheet" href="../css/globalie_<?php echo $lang; ?>.css" type="text/css" /><![endif]-->

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
var LANG="<?php echo $lang; ?>";
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
	buildButton('contacts','Contact Sense-U');
	
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
      		<div class="G_leftLabelBig">HELP</div>
            <div class="textContent">
            <div class="bigGreenText">Start with the Frequently Asked Questions</div><div id="menuarea"><table style="margin-left:50px" cellpadding="1" cellspacing="0"><tr>
              <td><img src="../images/help_btn_r1_c1.png" width="208" height="49" /></td><td><img src="../images/help_btn_r1_c3.png" width="208" height="49" /></td><td><img src="../images/help_btn_r1_c5.png" width="208" height="49" /></td></tr></table></div>
              <div class="blank"></div>
              <div id="q1" class="que"><span><img src="../images/help_arr1.png" width="13" height="20" /></span><span class="qtext" id="t1">How do I get started using Sense-U?</span></div>
              <div id="a1" class="ans">
              <table width=480 ><tr  ><td style="padding:5px">
              <table border="0" cellpadding="0" cellspacing="0"><tr><td class="G_contentBlack">Getting started with Sense-U takes only a few quick minutes.</td></tr>
              <tr><td class="G_contentBlack" style="padding-top:10px; padding-bottom:10px">
              
              <table bgcolor="#66bd00" cellpadding="0" cellspacing="1"><tr bgcolor="#FFFFFF"><td><ol style="padding-left:25px; margin-top:0px; margin-bottom:0px;">
<li style="padding:0px">Head to <a href="download.php" target="_self">here</a> to download and install Sense-U desktop application, for Windows or Mac. </li>
<li>After installing, you will be prompted to create a new account or<br />sign in with your existing ID, which will be the same login when you<br />sign in your online account: www.sense-u.com</li>
<li>Afterward, you will be asked to plug in USB Base Station and the tutorial will walk you through the procedure to register your Sense-U</li></ol></td></tr></table>
</td></tr> <tr><td class="G_contentBlack">That’s it. Sense-U desktop application will sync with your Sense-U wirelessly and automatically and make sure your online data is up-to-date
</td></tr></table>
              </td></tr>
             </table>
              </div>
              <div id="q2" class="que"><span><img src="../images/help_arr1.png" width="13" height="20" /></span><span class="qtext" id="t2">Where can I wear my Sense-U gadget?</span></div>
              <div id="a2" class="ans"><table><tr><td class="G_contentBlack">The clip-and-go Sense-U is wearable the way you want. Clip it to your shirt, jacket, workout gear, backpack, or even your underwear and it stays put — whether you’re running an errand, running around the track, or laying on bed.</td></tr></table></div>
              
              <div id="q3" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t3">What is the Sense-U desktop application?</span></div>
              <div id="a3" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">
The downloadable Sense-U desktop application runs on Windows and Mac operating systems and uploads data from Sense-U to your online account directly through wirelessly base station and internet.</td>
                  </tr>
                </table>
              </div>
              <div id="q4" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t4">How do I know desktop application is working properly?</span></div>
              <div id="a4" class="ans">
                <table width=100%  border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="G_contentBlack"><table width=100%><tr><td>Sense-U overlays icons on your system tray or menu bar.
For instance, you’ll know if desktop application is working properly by the color of the Sense-U status indicator.
In Windows 7, the Sense-U icon is on your system tray:</td></tr>
                    <tr><td><table width=400 align=center>
                    <tr align=center>
                      <td><img src="../images/help_img_r3_c5.png" width="132" height="41" /></td>
                      <td><img src="../images/help_img_r3_c10.png" width="132" height="41" /></td></tr> <tr align=center><td>Working Properly</td><td>Base Station is detached</td></tr></table>
                    
                    </td></tr></table>
                    </td>
                  </tr>
                </table>
              </div>
              <div id="q5" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext" id="t5">How to access my online data?</span></div>
              <div id="a5" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack"><table border="0" cellpadding="0" cellspacing="0"><tr><td>Your online data is always available and you can sign in your online account: <span class="G_contentGreen">www.sense-u.com</span> to view it. From there, you get a close look at your fitness progress and sleep pattern.</td></tr><tr>
                    <td height="340" align=center><img src="../images/help_img_r5_c2.png" width="613" height="326" /></td></tr></table> </td>
                  </tr>
                </table>
              </div>
              <div id="q6" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t6">Is my online data safe?</span></div>
              <div id="a6" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">We encrypt the data that you store on www.sense-u.com using the AES-256 standard, which is the same encryption standard used by banks to secure customer data. Encryption for storage is applied after data is uploaded, and we manage the encryption keys.
Sense-U uses Amazon S3 for data storage. Amazon stores data over several large-scale data centers. According to Amazon, they use military grade perimeter control berms, video surveillance, and professional security staff to keep their data centers physically secure.<br />
You can find more information about Amazon's security at the Amazon Web Services' website.<br />
Amazon and Sense-U also employ significant protection against network security issues such as Distributed Denial of Service (DDoS) attacks, Man in the Middle (MITM) attacks, and packet sniffing.</td>
                  </tr>
                </table>
              </div>
              <div id="q7" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t7">What is the privacy policy of Sense-U?</span></div>
              <div id="a7" class="ans">
                <table>
                  <tr>
                    <td class="G_contentBlack">A copy of our full privacy policy can be found  <span class="G_contentGreen"><a href="https://www.sense-u.com/privacy.php">here</a></span>.<br />
In one word, we do not and will not sell or rent your personal information, especially user data, to anyone, for any reason, at any time. We guard your privacy to the best of our ability and work hard to protect your information from unauthorized access.</td>
                  </tr>
                </table>
              </div>
<div id="q8" class="que"><span><img src="../images/help_arr1.png" alt="" width="13" height="20" /></span><span class="qtext"  id="t8">What is the return policy of Sense-U?</span></div>
<div id="a8" class="ans">
  <table>
    <tr>
      <td class="G_contentBlack">Sense-U offers a 30-day money back guarantee. If, for any reason, you are not completely satisfied with your product purchased from the Sense-U Store, you can return it within 30 days of shipment for a full product refund.  To initiate a refund, and to arrange for the return of the product, you can email us at <span class="G_contentGreen"><a href="mailto:support@sense-u.com">support@sense-u.com</a></span>.  If your product is deemed to be defective, we will provide a return-shipping label to cover the shipping costs of the return. Otherwise, you are responsible for the costs of shipping the product back to Sense-U.</td>
    </tr>
  </table>
</div>
               
          </div>
          <div id="btnArea"> <div id="help_table"><table><tr><td colspan="2" class="bigGreenText">Need More Help?</td></tr>
          <tr>
            <td rowspan="3"><img src="../images/help_img_r7_c1.png" width="136" height="121" /></td></tr>
          <tr>
            <td  class="G_contentBlack"><p>If you have a specific issue with bank accounts, transactions, or can’t find your answer in the community- powered forum, you can contact Customer Service here. You’ll typically get a response within 24 hours.</p></td>
          </tr>
          <tr>
            <td><div id="contacts">Contact Sense-U</div></td>
          </tr>
          </table>
          </div>
         
          </div> <div class="blank"></div>
    	</div>
	
</div>
</body>
</html>
