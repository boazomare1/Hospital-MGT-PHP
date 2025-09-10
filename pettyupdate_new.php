<?php
session_start();
$username=$_SESSION['username'];
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ip=getenv('REMOTE_ADDR');
$ipaddress = $_SERVER["REMOTE_ADDR"];
	$updatedate = date('Y-m-d');
	$doc='';
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	$doc = isset($_REQUEST['doc']) ? $_REQUEST['doc'] : '';
	$ramount = isset($_REQUEST['ramount']) ? $_REQUEST['ramount'] : '';
	 $ramount=str_replace(',', '', $ramount);
	$user = isset($_REQUEST['user']) ? $_REQUEST['user'] : '';
	$aamount = isset($_REQUEST['aamount']) ? $_REQUEST['aamount'] : '';
	 $aamount=str_replace(',', '', $aamount);
	$selValue = isset($_REQUEST['selValue']) ? $_REQUEST['selValue'] : '';
	$currentd = isset($_REQUEST['currentd']) ? $_REQUEST['currentd'] : '';
	if($selValue==5)
	{
	 
	 
 	$query31 = "update  pcrequest set amount='$ramount',approved_amt='$aamount',approved_status='$selValue',first_approvel_user_new='$user',first_approval_date_new='$updatedate',ipaddress='$ipaddress' WHERE doc_no = '$doc'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($exec31){
		echo 'success';
	}else{
		echo 'failed';
	} 
	}
	if($selValue==6)
	{
		 
	  
 	$query31 = "update  pcrequest set amount='$ramount',approved_amt='$aamount',approved_status='$selValue',first_rejected_user_new='$user',first_rejected_date_new='$updatedate',ipaddress='$ipaddress' WHERE doc_no = '$doc'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($exec31){
		echo 'success';
	}else{
		echo 'failed';
	} 
		
		
		}
	
	
	

?>