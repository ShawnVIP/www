<?php

require_once "zip.php"; 


$zip = new PHPZip(); 

$zip -> downloadZip("res/", "test.zip"); //打包并下载 

?>
