
<?php 
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}



if($action == 'deletedoctorpaymentamount')
{
		$docno = $_REQUEST['docno'];
		$ddocno = $_REQUEST['ddocno'];
		$mode = $_REQUEST['mode'];
		
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
		
		
		$query1222 = "update master_transactiondoctor set transactionamount = '0',$modetype ='0' WHERE docno = '$docno'";
        $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query1222 = "update paymentmodecredit set transactionamount = '0',$paymodetype ='0' WHERE billnumber = '$docno'";
        $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query1222 = "update tb set transaction_amount = '0' WHERE doc_number = '$docno'";
        $exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	
	echo $ddocno;
	
}

?>