<?php
session_start();
$username=$_SESSION['username'];
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
	$updatedate = date('Y-m-d');
	$doc='';
	
		
		$amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '';
	    $amount=str_replace(',', '', $amount);
		$aamount = isset($_REQUEST['aamount']) ? $_REQUEST['aamount'] : '';
		$aamount=str_replace(',', '', $aamount);
		$doc = isset($_REQUEST['doc']) ? $_REQUEST['doc'] : '';
		
		$user1 = isset($_REQUEST['user1']) ? $_REQUEST['user1'] : '';
		$currentd = isset($_REQUEST['currentd']) ? $_REQUEST['currentd'] : '';
		$selValue = isset($_REQUEST['selValue']) ? $_REQUEST['selValue'] : '';
		if($selValue==3){
		
		 $query31 = "update  pcrequest set amount='$amount',	approved_amt='$aamount',approved_status='$selValue',second_approvel_user='$user1',second_approval_date='$updatedate',final_status='pending' WHERE doc_no = '$doc'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($exec31){
		echo 'success';
	}else{
		echo 'failed';
	} 
		}
		if($selValue==4){
		$query31 = "update  pcrequest set amount='$amount',approved_amt='$aamount',approved_status='$selValue',	second_rejected_user='$user1',second_rejected_date='$updatedate' WHERE doc_no = '$doc'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($exec31){
		echo 'success';
	}else{
		echo 'failed';
	} 
		}	
			
		

?>