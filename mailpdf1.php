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

        // Instantiate Class  
		$mail = new PHPMailer();  
		
		// Set up SMTP  
		$mail->IsSMTP();                // Sets up a SMTP connection  
		$mail->SMTPAuth = true;         // Connection with the SMTP does require authorization    
		$mail->SMTPSecure = "ssl";      // Connect using a TLS connection  
		$mail->Host = "smtp.gmail.com";  //Gmail SMTP server address
		$mail->Port = 465;  //Gmail SMTP port
		$mail->Encoding = '7bit';
		$mail->SMTPDebug  = 2;
		
		// Authentication  
		$mail->Username   = "nakaserohospitallimited"; // Your full Gmail address
		$mail->Password   = "@spyc3@1ct@2015"; // Your Gmail password
		
		// Compose
		$mail->setFrom('natrajan@spyceit.com');
		//$mail->AddReplyTo('natrajan@spyceit.com','Natrajan');
		$mail->Subject = 'Certificate Issued By Chester';      // Subject (which isn't required)  
		$mail->MsgHTML("Hello Hello");
		//$mail->AddAttachment("/uploads/claims/test.pdf");
		
		// Send To  

		$mail->AddAddress('natrajan@spyceit.com'); // Where to send it - Recipient
		
		/*foreach($underwritingcc1 as $value1)
		{
		$mail->AddCC($value1); // Where to send it - Recipient
		}*/
		
		$result = $mail->Send();		// Send!  
		echo $message = $result ? 'Successfully Sent!' : 'Sending Failed!';      
		unset($mail);
?>