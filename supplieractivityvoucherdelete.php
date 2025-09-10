
<?php 
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}



if($action == 'deletesuppliervoucher')
{
		$docno = $_REQUEST['docno'];
		$ddocno = $_REQUEST['ddocno'];
		$voucher = $_REQUEST['voucher'];
		$mode = $_REQUEST['mode'];
		$remarks = $_REQUEST['remarks'];
		
		if($mode=='CASH'){
		$modetype='cashamount';
		$paymodetype='cash';		
		}else if($mode=='ONLINE'){
		$modetype='onlineamount';
		$paymodetype='online';
		}else if($mode=='MPESA'){
		$modetype='mpesaamount';
		$paymodetype='mpesa';
		}else if($mode=='CHEQUE'){
		$modetype='chequeamount';
		$paymodetype='cheque';
		}else if($mode=='WRITEOFF'){
		$modetype='writeoffamount';
		$paymodetype='cash';
		}
		
	   //$query1222 = "update master_transactionpharmacy set docno = '' WHERE docno = '$docno'";
       //$exec1222 = mysql_query($query1222) or die ("Error in Query1222".mysql_error());
	   $query12 = "update tb set transaction_amount = '0' WHERE doc_number = '$docno'";
       $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	   $query122 = "update paymententry_details set supplieramount = '0',netpayable='0' WHERE docno = '$docno'";
       $exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	   $query3 = "update paymentmodecredit set transactionamount = '0',$paymodetype ='0' WHERE billnumber = '$docno'";
	   $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	   $query1222 = "update master_transactionpharmacy set transactionamount = '0',$modetype ='0',amend_username='$user',amend_date='$updatetime',amend_remarks='$remarks' WHERE docno = '$docno'";
      $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));   
	   
	   $query122 = "update master_purchase set paymentvoucherno = '' WHERE paymentvoucherno = '$voucher'";
       $exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));
	   
	echo $ddocno;
	
}

?>