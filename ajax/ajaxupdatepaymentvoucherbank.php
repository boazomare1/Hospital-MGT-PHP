 <?php 
include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"Update Failed");
$mptxn_no   =    $_POST['mptxn_no'];
$autono    = 	$_POST['autono'];
$tablename    = 	$_POST['tablename'];
$useron    = 	$_POST['useron'];
$userby    = 	$_POST['userby'];

$iparr = explode ("||", $mptxn_no); 
$bankcode=$iparr[0];
$bankname=$iparr[1];


$select_qry = "SELECT  * FROM $tablename WHERE docno ='$autono' ";
$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0)
{

		$item_update_qry = "UPDATE `$tablename` SET `bankname` = '$bankname',`bankcode` = '$bankcode' WHERE docno = '$autono'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$item_update_qry = "UPDATE `master_transactionpharmacy` SET `bankname` = '$bankname',`bankcode` = '$bankcode',bank_editedby='$userby',bank_editedon='$useron' WHERE docno = '$autono'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$item_update_qry = "UPDATE `master_transactionaponaccount` SET `bankname` = '$bankname',`bankcode` = '$bankcode' WHERE docno = '$autono'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$item_update_qry = "UPDATE `tb` SET `ledger_id` = '$bankcode' WHERE doc_number = '$autono' and remarks='Payment' ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
		

}
echo json_encode($json);
?>