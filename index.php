<?php

/*
 * show me your ip!
 */

 ini_set('display_errors','on');
 include "db.class.php";
 header("Content-Type: text/plain");

 if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
 {
	 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
	 $ip = $_SERVER['REMOTE_ADDR'];
 }
 echo $ip;
 $f = fopen("ips.txt","a") or die("Unable to open appended file!");
 fwrite($f, date("Y-n-j,H:i:s") . "," . $ip . "\n") or die("Cannot write to file");
 fclose($f) or die("Cannot close the file");
 $db = new MyDB() or die ("SQL CLASS ERROR");
 $db->run("insert into ip (address,aDate,aTime) values ('" . $ip . "','".date("Y-n-j")."','".date("H:i:s")."');") or die ("ERROR");
 //print_r($_SERVER);
?>
