<?php

/*
 * show me your ip!
 */

 ini_set('display_errors','on');
 include "db.class.php";
 //print_r($_SERVER);
 //die();

header("Content-Type: text/plain");

 if ($_SERVER['REQUEST_URI'] != "/")
 {
//echo $_SERVER['REQUEST_URI'];
switch ($_SERVER['REQUEST_URI'])
{
  case "/ip":
    echo showIP();
  break;
  case "/fqdn":
    echo showFQDN();
  break;
  case "/ping":
    $out = array();
    $pat = '/Win/';
    if (preg_match($pat,$_SERVER['SERVER_SIGNATURE']))
    {
      exec('ping -n 4 '.$_SERVER['REMOTE_ADDR'], $out);

    }
    else {
      exec('ping -c 4 '.$_SERVER['REMOTE_ADDR'], $out);
    }
    print_r($out);
  break;
  case "/dl":
    echo "Under Construction.";
  break;
  case "/ul":
    echo "Under Construction.";
  break;
  case "/server":
      echo json_encode($_SERVER);
  break;
  case "/os":
    echo getOS();
  break;
  case "/browser":
    echo getBrowser();
  break;

}
$db = new MyDB() or die ("SQL CLASS ERROR");
$type= str_replace("/","",$_SERVER['REQUEST_URI']);
$db->run("insert into ip (type,address,aDate,aTime) values ('$type','" . showIP2() . "','".date("Y-m-d")."','".date("H:i:s")."');");

 }
 else {
   # code...
   echo showIP();

}


function getOS() {
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }

    return $os_platform;

}

function getBrowser() {

    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}

function showFQDN(){
  return gethostbyaddr(showIP());
}

function showIP()
{
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  $f = fopen("ips.txt","a") or die("Unable to open appended file!");
  fwrite($f, date("Y-m-d,H:i:s") . "," . $ip . "\n") or die("Cannot write to file");
  fclose($f) or die("Cannot close the file");
  $db = new MyDB() or die ("SQL CLASS ERROR");
  $db->run("insert into ip (type,address,aDate,aTime) values ('IP','" . $ip . "','".date("Y-m-d")."','".date("H:i:s")."');");
  return $ip;
  //print_r($_SERVER);

}

function showIP2()
{
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
  //print_r($_SERVER);

}
?>
