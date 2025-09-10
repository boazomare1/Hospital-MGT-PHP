<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$name = 'Test';
$mail_from = 'natrajan@spyceit.com';
$mail_to = 'natrajan23@gmail.com';
$mail_body = 'Hello';
$mail_subject = 'Hello S';
$mail_header = 'From: natrajan@spyceit.com';

//ini_set('SMTP', 'mail.spyceit.com'); 
//ini_set('smtp_port', 465); 

$sendmail = mail($mail_to,$mail_subject,$mail_body,$mail_header);

if($sendmail==true)
{
 echo 'OK';
}
else
{
 echo 'Bad';
}
?>
