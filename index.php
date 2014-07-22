<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>check language</title>

</head>
<body><?php
    $lang=$_COOKIE['lang'];
	if($lang==""){
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); //只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。  
	
		if (preg_match("/zh-c/i", $lang)){
			//echo "简体中文";
			setcookie("lang","cn");
			$lang="cn";
			
		}else if (preg_match("/zh/i", $lang)){  
			//echo "繁體中文"; 
			setcookie("lang","zh");
			$lang="zh";
		}else{
			//echo "英文"; 
			setcookie("lang","en");
			$lang="en";
		}
		/* if (preg_match("/en/i", $lang))  
		echo "English";  
		else if (preg_match("/fr/i", $lang))  
		echo "French";  
		else if (preg_match("/de/i", $lang))  
		echo "German";  
		else if (preg_match("/jp/i", $lang))  
		echo "Japanese";  
		else if (preg_match("/ko/i", $lang))  
		echo "Korean";  
		else if (preg_match("/es/i", $lang))  
		echo "Spanish";  
		else if (preg_match("/sv/i", $lang))  
		echo "Swedish";  
		else echo $_SERVER["HTTP_ACCEPT_LANGUAGE"];  
	
		 */
	}
	
	//header("Location: " . $lang . "/"); 
	
?>
<script>

	var url = location.href; 
	var pos=url.indexOf("?");
        var paraString =""
        if(pos>0){
	   paraString = url.substring(pos);
        }
	
	location.href="<?php echo $lang; ?>/"+paraString

</script>

</body></html>