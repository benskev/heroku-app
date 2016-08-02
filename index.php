<?php

/* 
 * show me your ip!
 */
 ini_set('display_errors','on');
 header("Content-Type: text/plain");

 if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
 {
	 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
	 $ip = $_SERVER['REMTOE_ADDR'];
 }
 echo $ip;
 $f = fopen("ips.txt","a") or die("Unable to open appended file!");
 fwrite($f, date("Y-n-j H:i:s") . " - " . $ip) or die("Cannot write to file");
 fclose($f) or die("Cannot close the file");
 //print_r($_SERVER);
?>
