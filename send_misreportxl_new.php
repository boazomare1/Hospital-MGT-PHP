<?php
include ("db/db_connect.php");
$today=date('Y-m-d');
$currentdates =strtotime("$today -1 day");
$enddate =date('Y-m-d',$currentdates);
$startdate =date('Y-m-01',$currentdates);

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $enddate; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $gmaiADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $startdate; }

$sqlchk="select * from mismail_send where sentdate='$today'";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlchk) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_num_rows($exec22);
if ($res22 == 0)
{
//mysqli_query($GLOBALS["___mysqli_ston"], "insert into mismail_send(sentdate) values ('$today')");

require_once('settings_mails.php');
require_once('mail_dailykpireport.php');
//require_once('mail_monthlycumulative.php');
//require_once('mail_daytodayflash.php');
//require_once('mail_debtorreport.php');
//require_once('mail_opipconversion.php');
require_once('class.phpmailer.php');
$mail = new PHPMailer(true);
$mail->IsSMTP();
try {

	  $subject = $mis_subject.' '.$ADate1.' - Zazi Hospitals';

	  $mail->SMTPAuth   = true;                  
	  $mail->SMTPSecure = $smtp_secure;                 
	  $mail->Host       = $smtp_host;      
	  $mail->Port       = $smtp_port;                   
	  $mail->Username   = $smtp_user;  
	  $mail->Password   = $smtp_psw;  
	  
	  $mail->SetFrom($mis_from);
	  
	  if ( $mis_to != '' ) {
		$indibb = explode(";", $mis_to);
		foreach ($indibb as $key => $value) {
		  $mail->AddAddress($value);
		}
	 }

	if ( $mis_cc != '' ) {
		$indiCC = explode(";", $mis_cc);
		foreach ($indiCC as $key => $value) {
		  $mail->AddCC($value);
		}
	 }

	
  $mail->Subject = $subject;
  $mail->MsgHTML($mis_message.$kpicontent);
  
  //$mail->AddAttachment($cumfile);
 // $mail->AddAttachment($flashfile);
  //$mail->AddAttachment($docfile);
  //$mail->AddAttachment($debtorfile);
  //$mail->AddAttachment($opipconvfile);

	if ($mail->Send()) 
	   echo 'Mail sent successfully';
	else               
		echo 'Mail failure';



	// delete old files
	/* $dir = getcwd()."/".$mis_path;
	$interval = strtotime('-2 day');

	foreach (glob($dir."*.xls") as $file) {
	if (filemtime($file) <= $interval ) unlink($file); 

	} */
	
} catch (phpmailerException $e) {
  echo $e->errorMessage(); 
} catch (Exception $e) {
  echo $e->getMessage(); 
}
}
?>