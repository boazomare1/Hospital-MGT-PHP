<?php

include ("../db/db_connect.php");

$json = array('status'=>0,'costcenter_id'=>"",'costcenter_name'=>"");

if(!empty($_REQUEST['store_code'])) {

	$store_code= trim($_REQUEST['store_code']);
	

	if($store_code !="")
	{

		
		$query10 = "select cost_center from `master_store` where storecode = '$store_code'";
		
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows = mysqli_num_rows($exec10);
		if($num_rows > 0)
		{
		   $res10 = mysqli_fetch_array($exec10);
		   $cost_center_id = $res10["cost_center"];

		   // get cost center name from cost center id

		   $query11 = "select name from `master_costcenter` where auto_number = '$cost_center_id'";

		   $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res11 = mysqli_fetch_array($exec11);
		   $cost_center_name = $res11["name"];
		 	$json = array('status'=>1,'costcenter_id'=>$cost_center_id,'costcenter_name'=>$cost_center_name);
	

		}
		
	 

	}
	
}
echo json_encode($json);
?>
