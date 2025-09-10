<?
session_start();
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d H:i:s');
$http_referrer = $_SESSION[http_referrer];
$browserinfo = $_SERVER['HTTP_USER_AGENT'];


$messageproper =
"Date & Time			:".$updatedate."\n".
"IPAddress				:".$ipaddress."\n".
"HTTP Referer			:".$http_referrer."\n".	
"                                             \n".	
"Browser 				:".$browserinfo."\n".
"\n\n------------------------------------------------------------\n" ;

	include "libmail.php";
	$m= new Mail; // create the mail
	$m->From( "prem@simpleindia.com" );
	$m->To( "prem@simpleindia.com" );
	$m->Subject( "Barocde - SL Lumax" );
	$m->Body( $messageproper );	// set the body
	//$m->Cc( "simpleinfotech@gmail.com");
	//$m->Bcc( "premkumarcv@yahoo.com");
	$m->Priority(4) ;	// set the priority to Low
	//$m->Attach( $target_path, "application/msword", "inline" ) ;	// attach a file of type image/gif to be displayed in the message if possible
	$m->Send();	// send the mail
	//echo "Mail was sent:<br><pre>", $m->Get(), "</pre>";

?>