<?php
include ("db/db_connect.php");

///////// FOR DISPATCH ////////////////
$s=0;
$accountnameid='';
$query = "select * from completed_billingpaylater where billno like '%IPF%'  ";
// $query = "select * from completed_billingpaylater  ";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res = mysqli_fetch_array($exec))
{
	$billno = $res['billno'];
	$auto_number = $res['auto_number'];
	// $amount = $res['amount'];

	$query1 = "select * from print_deliverysubtype where billno='$billno' group by billno ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$accountnameid=$res1['accountnameid'];

	if($accountnameid!=''){
			$query5 = "UPDATE completed_billingpaylater SET accountnameid = '$accountnameid' WHERE auto_number = '$auto_number' ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$s++;
		}
}
echo $s;

?>