 <?php 

include ("../db/db_connect.php");

$json = array('status'=>0,'msg'=>"Update Failed");


$autonumber      =    trim($_POST['autonumber']);

//$batchnumber   =    $_POST['batchnumber'];

$bankdate    = 	trim($_POST['bankdate']);

if($autonumber !="")
{
	$item_update_qry = "UPDATE `bank_record` SET `bankdate` = '".$bankdate."' WHERE auto_number = '".$autonumber."'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query 2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$json = array('status'=>1,'msg'=>"Statement Date Updated Successfully");
}


echo json_encode($json);

?>