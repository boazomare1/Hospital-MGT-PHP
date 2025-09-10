<?php
/*require("phpmailer/class.phpmailer.php");
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

if($action=='purchaseindent')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Purchase Indent ".$remarks."</td></tr>";
	$message .= "</table>";

	//echo $bamailfrom.','.$bamailcc.','.$piemailfrom.','.$username;
	$mail->AddAddress($bamailfrom);
	$mail->AddCC($bamailcc);
	$mail->SetFrom($piemailfrom,$username);
	$mail->Subject = $billnumbercode." Indent From ".ucfirst($username).' - '.ucfirst($jobdescription);
	$mail->IsHTML(true);
	//$mail->Body = "Purchase Indent".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;	   
	}
	else
	{
	   echo "Letter sent";	   
	}
}
else if($action=='budgetapproval'&&$actionstatus=='approve')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Budget Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	//echo $bamailfrom.','.$famailfrom.','.$famailcc.','.$username;
	$mail->AddAddress($famailfrom);
	$mail->AddCC($famailcc);
	$mail->SetFrom($bamailfrom,'Budget Approval');
	$mail->Subject = $docno." Indent Approved by Budget Approval";
	$mail->IsHTML(true);
	//$mail->Body = "Budget Approval".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;	   
	}
	else
	{
	   echo "Letter sent";	   
	}
}
else if($action=='budgetapproval'&&$actionstatus=='reject')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Budget Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	//echo $baemailfrom.','.$famailfrom.','.$baemailcc.','.$username;
	$mail->AddAddress($bamailfrom);
	$mail->AddCC($baemailcc);
	$mail->SetFrom($baemailfrom,'Budget Approval');
	$mail->Subject = $docno." Indent Rejected by Budget Approval";
	$mail->IsHTML(true);
	//$mail->Body = "Budget Approval".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;	   
	}
	else
	{
	   echo "Letter sent";	   
	}
}
else if($action=='financeapproval'&&$actionstatus=='approve')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Finance Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	//echo $famailfrom.','.$ceomailfrom.','.$ceomailcc.','.$username;
	$mail->AddAddress($ceomailfrom);
	$mail->AddCC($ceomailcc);
	$mail->SetFrom($famailfrom,'Finance Approval');
	$mail->Subject = $docno." Indent Approved by Finance Approval";
	$mail->IsHTML(true);
	//$mail->Body = "Finance Approve".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
	   echo "Letter sent";
	}
}
else if($action=='financeapproval'&&$actionstatus=='reject')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>Finance Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	$mail->AddAddress($bamailfrom);
	$mail->AddCC($famailcc);
	$mail->SetFrom($famailfrom,'Finance Approval');
	$mail->Subject = $docno." Indent Rejected by Finance Approval";
	$mail->IsHTML(true);
	//$mail->Body = "Finance Approve".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
	   echo "Letter sent";
	}
}
else if($action=='ceoapproval'&&$actionstatus=='approve')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>CEO Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	$mail->AddAddress($poamailfrom);
	$mail->AddCC($poamailcc);
	$mail->SetFrom($ceomailfrom,'CEO Approval');
	$mail->Subject = $docno." Indent Approved by CEO Approval";
	$mail->IsHTML(true);
	//$mail->Body = "CEO Approve".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
	   echo "Letter sent";
	}
}
else if($action=='ceoapproval'&&$actionstatus=='reject')
{
	$message = "<table width='100%' border='0' cellspacing='1' cellpadding='1'>";
	$message .= "<tr><td colspan='2' width='200'>Dear Sir/Madam,</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>&#32;</td></tr>";
	$message .= "<tr><td colspan='2' width='200'>CEO Approval ".$remarks."</td></tr>";
	$message .= "</table>";
	
	$mail->AddAddress($famailfrom);
	$mail->AddCC($ceomailcc);
	$mail->SetFrom($ceomailfrom,'CEO Approval');
	$mail->Subject = $docno." Indent Rejected by CEO Approval";
	$mail->IsHTML(true);
	//$mail->Body = "CEO Approve".$remarks;
	$mail->Body = $message;
	
	if(!$mail->Send())
	{
	   echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
	   echo "Letter sent";
	}
}*/
?>
