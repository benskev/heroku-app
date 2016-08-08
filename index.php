<?php

/*
 * show me your ip!
 */

 ini_set('display_errors','on');
 include "db.class.php";
 //print_r($_SERVER);
 //die();

 if ($_SERVER['REQUEST_URI'] != "/")
 {
//echo $_SERVER['REQUEST_URI'];
switch ($_SERVER['REQUEST_URI'])
{
  case "/ip":
  header("Content-Type: text/plain");
    echo showIP();
  break;
  case "/fqdn":
  header("Content-Type: text/plain");
    echo showFQDN();
  break;
  case "/ping":
  header("Content-Type: text/plain");
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
  header("Content-Type: text/plain");
    echo "Under Construction.";
  break;
  case "/ul":
  header("Content-Type: text/plain");
    echo "Under Construction.";
  break;
  case "/server":
  header("Content-Type: text/plain");
      echo json_encode($_SERVER);
  break;
  case "/os":
  header("Content-Type: text/plain");
    echo getOS();
  break;
  case "/browser":
  header("Content-Type: text/plain");
    echo getBrowser();
  break;
  case "/help":
  header("Content-Type: text/html");
    echo getHelp();
  break;
  default:
    //echo $_SERVER['REQUEST_URI'] . "<BR>\n";
    $s = explode("/",$_SERVER['REQUEST_URI']);
    //print_r($s);
    //echo "<BR>\n";
    if (sizeOf($s) == 3)
    {
      switch (strtolower($s[2]))
      {
        case "asn":
        case "asn1":
        case "xml":
          header("Content-Type: application/xml");
          //$xml = new SimpleXMLElement('<root/>');
          $data = processData();
          //echo "XML: " . $data . "<BR>\n";
          //array_walk_recursive($data, array ($xml, 'addChild'));
          //print_r($data);
          //die();
          if ($s[1]=="server")
          {
            echo '<?xml version="1.0"?><root>';
            $xml = "";
            foreach ($data[0] as $i=>$d)
            {
              $xml .= "<" . $i . ">".$d."</".$i.">";
            }
            //array_walk_recursive($data, array ($xml, 'addChild'));
            echo $xml . "</root>";
            //print_r($xml);
          }
          else {
            # code...
            $xml = new SimpleXMLElement('<root/>');
            $data = processData();
            //echo "XML: " . $data . "<BR>\n";
            array_walk_recursive($data, array ($xml, 'addChild'));
            echo $xml->asXML();
          }
          break;
        case "xml-rpc":

          break;
        case "json":
        header("Content-Type:text/plain");
          echo json_encode(processData());
          break;
        case "jsonp":

          break;
        case "bson":
          $bson = MongoDB\BSON\fromPHP(processData());
          echo bin2hex($bson), "\n";
          break;
        case "csv":
        header("Content-Type: text/plain");
          outputCSV(processData());
          break;
        case "javaarray":

          break;
        case "yaml":
          echo "Under development.";
          break;
        default:
          echo "DEFAULT";
        break;
      }
    }
  break;

}
$db = new MyDB() or die ("SQL CLASS ERROR");
$type= str_replace("/",":",$_SERVER['REQUEST_URI']);
$db->run("insert into ip (type,address,aDate,aTime) values ('$type','" . showIP2() . "','".date("Y-m-d")."','".date("H:i:s")."');");

}
else {
# code...
echo showIP();

}

function outputCSV($data) {
        //$outputBuffer = fopen("php://output", 'w');
        if (sizeOf($data) == 1 && isset($data[0]['REQUEST_URI'])){$data = $data[0];}
        //foreach($data as $val) {
        //    fputcsv($outputBuffer, array($val));
        //}
        //fclose($outputBuffer);
        foreach ($data as $i=>$d)
        {
          echo $i . ",'" . addslashes($d) . "'\n";
        }
    }

function processData()
{
  $id = explode("/",$_SERVER['REQUEST_URI']);
  //echo $id[1];
  switch ($id[1])
  {
    case "ip":
      if ($id[2]=="xml"){return array(showIP()=>"data");}else{return array("data"=>showIP());}
    break;
    case "fqdn":
    if ($id[2] == "xml"){
    return array(showFQDN()=>"data");
    }
    else{
      return array("data"=>showFQDN());
    }
    break;
    case "ping":
      $out = array();
      $pat = '/Win/';
      if (preg_match($pat,$_SERVER['SERVER_SIGNATURE']))
      {
        exec('ping -n 4 '.$_SERVER['REMOTE_ADDR'], $out);

      }
      else {
        exec('ping -c 4 '.$_SERVER['REMOTE_ADDR'], $out);
      }
      return ($out);
    break;
    case "dl":
    if ($id[2] == "xml"){  return array("Under Construction."=>"data");}else{return array("Under Contruction");}
    break;
    case "ul":
      if ($id[2] == "xml"){return array("Under Construction."=>"data");}else{return array("Under Construction");}
    break;
    case "server":
    ini_set('display_errors','off');
        return array($_SERVER);
    break;
    case "os":
      if ($id[2] == "xml"){return array(getOS()=>"data");}else{return array(getOS());}
    break;
    case "browser":
      return array(getBrowser());
    break;
    case "help":
      return array(getHelp());
    break;
  }
}

function getHelp(){
    echo "<!DOCTYPE html>
<head>
	<title>Help</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
  <!-- Optional theme -->
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
  <!-- Latest compiled and minified jQuery -->
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>";

    echo "<div class='col-md-4'></div>";
    echo "<div class='col-md-4'>";
    echo "<div class='well'>";
    echo "<h2>Help</h2>";
    echo "<p>/ip - list your ip address<BR>";
    echo "/fqdn - list your FQDN<BR>";
    echo "/ping - ping your IP<BR>";
    echo "/dl - download speed<BR>";
    echo "/ul - upload speed<BR>";
    echo "/server - server info<BR>";
    echo "/os - show operating system<BR>";
    echo "/browser - browser system<BR></p>";
    echo "<hr><p>Simply add the data format as the second parameter (eg:/server/json) and it will represent the data as you want it.<br>The available formats are: CSV, JSON, XML, YAML, and Array.</p>";
    echo "</div>";
    echo "</div>";
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
