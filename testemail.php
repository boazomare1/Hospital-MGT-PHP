<?php 
$to = 'francis.meru@nhl.co.ug, natrajan23@gmail.com, collins@tis-direct.com'; 
$subject = 'Test email using PHP'; 
$message = 'This is a test email message, please confirm receipt. Kindly note that I\'ve not used PHPMailer anywhere. '; 
$headers = 'From: nakaserohospitallimited@gmail.com' . "\r\n" . 'Reply-To: nakaserohospitallimited@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 

if(mail($to, $subject, $message, $headers, '-fnakaserohospitallimited@gmail.com'))
{
echo 'ok - superb';
}
else
{
echo 'Bad';
}

?>
