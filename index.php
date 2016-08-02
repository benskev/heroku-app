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
 echo "IP: " . $ip;
 print_r($_SERVER);
?>
