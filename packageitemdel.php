 <?php 

include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"Failed to delete the Package Item");

$auto_number   =    $_POST['auto_number'];

if($auto_number)
{
	$item_update_qry = "update package_items set is_deleted = 1 where id = '$auto_number'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	// record updated successfully
	$json = array('status'=>1,'msg'=>"Package Item  deleted successfully.");
}
echo json_encode($json);
?>