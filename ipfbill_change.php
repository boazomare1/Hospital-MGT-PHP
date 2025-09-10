<?php
include ("db/db_connect.php");
$a=0;
// where auto_number='6390'
$query = "select * from print_deliverysubtype where billno like '%IPF%' ";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res = mysqli_fetch_array($exec))
{
	$billno = $res['billno'];
	$auto_number = $res['auto_number'];
	$amount = $res['amount'];

	$query1 = "select * from master_transactionpaylater where billnumber='$billno' and transactiontype='finalize' and transactionamount='$amount'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$accountnameid=$res1['accountnameid'];

	$query5 = "UPDATE print_deliverysubtype SET accountnameid = '$accountnameid' WHERE auto_number = '$auto_number' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));	
	if($exec5){
			echo 'UPDATED SUCCSSFULLY		-- '.$billno.'<br>';
	}else{
		echo $billno.'<br>';
	}
	$a++;
	
}
echo $a;

?>