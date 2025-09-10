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

/*$to = 'natrajan@spyceit.com'; 
$subject = 'Test email using PHP'; 
$message = 'This is a test email message, please confirm receipt. Kindly note that I\'ve not used PHPMailer anywhere. '; 
$headers = 'From: nhl_admin@nhl.co.ug' . "\r\n" . 'Reply-To: nhl_admin@nhl.co.ug' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 

if(mail($to, $subject, $message, $headers, '-fnhl_admin@nhl.co.ug'))
{
echo 'ok - superb';
}
else
{
echo 'Bad';
}*/
?>

<?php
require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsMail();

$mail->AddAddress("natrajan@spyceit.com");
$mail->setFrom('nhl_admin@nhl.co.ug','NHL_Admin');
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
