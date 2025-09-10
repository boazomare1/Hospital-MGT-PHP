 <?php 
include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"Failed to delete the Purchase Indent Item");

$auto_number   =    $_POST['auto_number'];

if($auto_number)
{
	$item_update_qry = "update purchase_indent set is_deleted = '1' where auto_number = '$auto_number'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	// record updated successfully
	$json = array('status'=>1,'msg'=>"Purchase Indent Item  deleted successfully.");
}
echo json_encode($json);
?>