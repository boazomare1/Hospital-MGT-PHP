 <?php 
include ("../db/db_connect.php");
$json = array('status'=>0,'msg'=>"Update Failed");
$mptxn_no   =    $_POST['mptxn_no'];
$autono    = 	$_POST['autono'];
$billno   =    $_POST['billno'];
$tablename    = 	$_POST['tablename'];


$select_qry = "SELECT  * FROM $tablename WHERE auto_number ='$autono' and (billno= '$billno')";
$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0)
{

		$item_update_qry = "UPDATE `$tablename` SET `preauthcode` = '$mptxn_no' WHERE auto_number = '$autono' and (billno= '$billno') ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
		

}
echo json_encode($json);
?>