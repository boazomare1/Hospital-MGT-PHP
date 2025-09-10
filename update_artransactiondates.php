<?php

session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];


if($_REQUEST['frmflag']){ $frmflag=$_REQUEST['frmflag'];}else{$frmflag='';};
if($frmflag=='frmflag'){
	
	$query = "SELECT actualtransactiondate,docno,transactiondate FROM temp_receivables";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res = mysqli_fetch_array($exec)){
		echo $transactiondate = $res['transactiondate'];	
		echo ' =====> '.$actualtransactiondate = $res['actualtransactiondate'];	
		echo '        '.$docno = $res['docno'];	
		echo '<br>';
		echo $query1 = "UPDATE master_transactionpaylater SET transactiondate = '$actualtransactiondate' WHERE docno = '$docno'";
		$exec1= mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
		echo '<br>';
		echo $query2 = "UPDATE master_transactiononaccount SET transactiondate = '$actualtransactiondate' WHERE docno = '$docno'";
		$exec2= mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		echo '<br>';
		$query3 = "SELECT billdatetime FROM paymentmodedebit WHERE billnumber = '$docno'";
		$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$billdatetime = $res3['billdatetime'];	
		
		echo $query4 = "UPDATE paymentmodedebit SET  billdate = '$actualtransactiondate',billdatetime = '$billdatetime'  WHERE billnumber = '$docno'";
		$exec4= mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));		
		
		echo $query5 = "UPDATE tb SET  transaction_date = '$actualtransactiondate'  WHERE doc_number = '$docno'";
		$exec5= mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		
		echo '<br>';
		echo '<br>';
	}
}
?>

<form action = '' method="post">

<input type="submit" id="submit" name="submit" value = "Update">
<input type="hidden" id="frmflag" name="frmflag" value="frmflag">

</form>
