 <?php 

include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"");

$suppliercode   =    trim($_POST['suppliercode']);
$invoiceno      =    trim($_POST['invoiceno']);

if($suppliercode !="" && $invoiceno !="")
{
	$invoice_chk_qry = "select auto_number from materialreceiptnote_details where suppliercode ='".$suppliercode."' and supplierbillnumber = '".$invoiceno."'";
	$exec_invoice = mysqli_query($GLOBALS["___mysqli_ston"], $invoice_chk_qry) or die ("Error in Invoice Check Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows = mysqli_num_rows($exec_invoice);
	if($num_rows)
	{
		$json = array('status'=>1,'msg'=>"Invoice Number already exists for the Supplier.");
	}
}
echo json_encode($json);
?>