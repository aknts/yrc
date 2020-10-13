<?php

//Configuration
$server='192.168.1.10';

//Target IP's
//Yealink phones

$targets=array
(
array("192.168.1.116","v61"),
array("192.168.1.112","v61"),
array("192.168.1.150","v70"),
array("192.168.1.180","v70")
);

function push2phone($server,$phone,$data)
{
$xml = "xml=".$data;
$post = "POST / HTTP/1.1\r\n";
$post .= "Host: $phone\r\n";
$post .= "Referer: $server\r\n";
$post .= "Connection: Keep-Alive\r\n";
$post .= "Content-Type: text/xml\r\n";
$post .= "Content-Length: ".strlen($xml)."\r\n\r\n";
$fp = @fsockopen ( $phone, 80, $errno, $errstr, 5);
if($fp)
{
fputs($fp, $post.$xml);
flush();
fclose($fp);
}
}

//For Yealink phones with firmware v61 and back and support push xml
$v61 = "<YealinkIPPhoneConfiguration\n";
$v61 .= "Beep=\"no\"";
$v61 .= "setType=\"config\"";
$v61 .= ">";
$v61 .= "<ConfigurationItem>\n";
$v61 .= "<Path>/yealink/config/voip/sipAccount0.cfg</Path>\n";
$v61 .= "<Session>account</Session>\n";
$v61 .= "<Parameter>SIPServerHost</Parameter>\n";
$v61 .= "<Value>192.168.1.11</Value>\n";
$v61 .= "</ConfigurationItem>\n";
$v61 .= "</YealinkIPPhoneConfiguration>\n";

//For Yealink phones with firmware v70 and up and support push xml
$v70 = "<YealinkIPPhoneConfiguration Beep=\"no\">\n";
$v70 .= "<Item>account.1.sip_server_host = 192.168.3.11</Item>\n";
$v70 .= "</YealinkIPPhoneConfiguration>\n";


foreach ($targets as $key => $value) {
	
	$ip=$value[0];
	
	if ($value[1]=="v61") {
		$xml=$v61;
	}
	if ($value[1]=="v70"){
		$xml=$v70;
	}

	push2phone($server,$ip,$xml);
	echo "Pushed change to $ip.<br />";

}

?>
