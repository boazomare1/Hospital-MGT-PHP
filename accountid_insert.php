<?php
include ("db/db_connect.php");
$a=0;
// where auto_number='6390'
$query = "select * from print_deliverysubtype ";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res = mysqli_fetch_array($exec))
{
	$billno = $res['billno'];
	$auto_number = $res['auto_number'];
	$amount = $res['amount'];

	$query1 = "select * from billing_paylater where billno='$billno' group by billno ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$accountnameid=$res1['accountnameid'];

	if($num1==0){
		$query2 = "select * from billing_ip where billno='$billno' group by billno ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2 = mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$accountnameid=$res2['accountnameid'];

		if($num2==0){
			$query3 = "select * from billing_ipcreditapprovedtransaction where billno='$billno' and fxamount='$amount' group by billno ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3 = mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			$accountnameid=$res3['accountnameid'];

				if($num3==0){
						$query4 = "select * from billing_ipnhif where docno='$billno' group by docno ";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num4 = mysqli_num_rows($exec4);
						$res4 = mysqli_fetch_array($exec4);
						$accountnameid=$res4['accountcode'];
				}
		}
	}

	$query5 = "UPDATE print_deliverysubtype SET accountnameid = '$accountnameid' WHERE auto_number = '$auto_number' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));	
	// if($exec5){
	// 		echo 'UPDATED SUCCSSFULLY';
	// }
	$a++;
	
}
echo $a;

?>