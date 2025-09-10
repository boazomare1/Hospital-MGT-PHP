 <?php 
include ("../db/db_connect.php");
$json = array('status'=>0,'msg'=>"Update Failed");
$mptxn_no   =    $_POST['mptxn_no'];
$autono    = 	$_POST['autono'];
$tablename    = 	$_POST['tablename'];


$select_qry = "SELECT  * FROM $tablename WHERE docno ='$autono' ";
$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0)
{

		//$item_update_qry = "UPDATE `$tablename` SET `rateperunit` = '$mptxn_no' WHERE auto_number = '$autono'  ";
		//$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$item_update_qry = "UPDATE  `$tablename`
		SET 
			cashamount = CASE WHEN cashamount <> 0 THEN '$mptxn_no' ELSE cashamount END,
			onlineamount = CASE WHEN onlineamount <> 0 THEN '$mptxn_no' ELSE onlineamount END,
			creditamount = CASE WHEN creditamount <> 0 THEN '$mptxn_no' ELSE creditamount END,
			chequeamount = CASE WHEN chequeamount <> 0 THEN '$mptxn_no' ELSE chequeamount END,
			cardamount = CASE WHEN cardamount <> 0 THEN '$mptxn_no' ELSE cardamount END,
			transactionamount='$mptxn_no'
		WHERE
			(cashamount <> 0 OR
			onlineamount <> 0 OR
			creditamount <> 0 OR
			chequeamount <> 0 OR
			cardamount <> 0 ) and docno = '$autono' ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$item_update_qry = "UPDATE `tb` SET `transaction_amount` = '$mptxn_no' WHERE doc_number = '$autono'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
		

}
echo json_encode($json);
?>