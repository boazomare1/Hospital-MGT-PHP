 <?php 

include ("../db/db_connect.php");





$json = array('status'=>0,'msg'=>"Update Failed");





$cdtxn_no      =    $_POST['cdtxn_no'];

$mptxn_no   =    $_POST['mptxn_no'];

$autono    = 	$_POST['autono'];

$billno   =    $_POST['billno'];

$tablename    = 	$_POST['tablename'];

if($tablename=='master_billing')
{
$datetime    = 	$_POST['datetime'];
}



if($tablename=='master_transactionipdeposit' || $tablename=='master_transactionadvancedeposit' || $tablename=='master_transactionpaylater' || $tablename=='deposit_refund')
{
$select_qry = "SELECT  * FROM $tablename WHERE auto_number ='$autono' and (docno= '$billno')";
}else{

 $select_qry = "SELECT  * FROM $tablename WHERE auto_number ='$autono' and (billnumber= '$billno')";
 }

$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);

$num_rows = mysqli_num_rows($result);

if($num_rows > 0)

{
if($tablename=='master_transactionipdeposit' || $tablename=='master_transactionadvancedeposit' || $tablename=='master_transactionpaylater' || $tablename=='deposit_refund')
{

$item_update_qry = "UPDATE `$tablename` SET `creditcardnumber` = '$cdtxn_no',`mpesanumber` = '$mptxn_no' WHERE auto_number = '$autono' and (docno= '$billno') ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
		
}
else{

$item_update_qry = "UPDATE `$tablename` SET `creditcardnumber` = '$cdtxn_no',`mpesanumber` = '$mptxn_no'WHERE auto_number = '$autono' and (billnumber= '$billno') ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		if($tablename=='master_billing')
        {
		
		$item_update_qry1 = "UPDATE `$tablename` SET `updatetime` = '$datetime' WHERE auto_number = '$autono' and (billnumber= '$billno') ";

		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry1) or die ("Error in Update Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
	
}

}

echo json_encode($json);

?>