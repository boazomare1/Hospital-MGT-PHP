<?php 
include ("../db/db_connect.php");
$json = array('status'=>0,'msg'=>"Update Failed");
$itemcode      =    $_POST['itemcode'];

$batchnumber   =    $_POST['batchnumber'];

$expirydate    = 	trim($_POST['expirydate']);

$itemname      = 	trim($_POST['itemname']);

$newbatch   =    $_POST['newbatch'];

$select_qry = "SELECT  auto_number FROM purchase_details WHERE itemcode = '".$itemcode."' and batchnumber= '".$batchnumber."'";

$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);

$num_rows = mysqli_num_rows($result);

if($num_rows > 0)

{

	

	if($num_rows == 1)

	{

		// matched only 1 record for item

		$data = mysqli_fetch_row($result);

		

		if(count($data) > 0)

		{

			$row_id = $data[0];

			$item_update_qry = "UPDATE `purchase_details` SET `expirydate` = '".$expirydate."',batchnumber= '".$newbatch."' WHERE `auto_number` = ".$row_id.";";

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));

			$upd_success = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);

			

			// record updated successfully

			$json = array('status'=>1,'msg'=>"Item Updated Successfully");

			

		}

		

	}

	else

	{

		$item_update_qry = "UPDATE `purchase_details` SET `expirydate` = '".$expirydate."',batchnumber= '".$newbatch."' WHERE itemcode = '".$itemcode."' and batchnumber= '".$batchnumber."' ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$json = array('status'=>1,'msg'=>"Item Updated Successfully");

	}



}

$select_qry = "SELECT  auto_number FROM materialreceiptnote_details WHERE itemcode = '".$itemcode."' and batchnumber= '".$batchnumber."' ";

$result =  mysqli_query($GLOBALS["___mysqli_ston"], $select_qry);

$num_rows = mysqli_num_rows($result);

if($num_rows > 0)
{
	$item_update_qry = "UPDATE `materialreceiptnote_details` SET `expirydate` = '".$expirydate."',batchnumber= '".$newbatch."' WHERE itemcode = '".$itemcode."' and batchnumber= '".$batchnumber."'";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query 2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$json = array('status'=>1,'msg'=>"Item Updated Successfully");
}

if($json["status"]=='1' && $batchnumber!=$newbatch){

$item_update_qry = "UPDATE transaction_stock SET batchnumber= '".$newbatch."' WHERE itemcode = '".$itemcode."' and batchnumber= '".$batchnumber."'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query 2".mysqli_error($GLOBALS["___mysqli_ston"]));

}

echo json_encode($json);

?>