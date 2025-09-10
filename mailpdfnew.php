<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$updatetime = date('H:i:s');

require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsMail();

$mail->AddAddress("natrajan@spyceit.com");
$mail->AddCC("natrajan@spyceit.com");
$mail->SetFrom('natrajan@spyceit.com','NHL_Admin');
$mail->Subject = "Test 1";
$mail->Body = "Test 1 of PHPMailer.";

if(!$mail->Send())
{
   echo "Error sending: " . $mail->ErrorInfo;;
}
else
{
   echo "Letter sent";
}

?>