<?php

include ("db/db_connect.php");

 $machinename=trim($_REQUEST['term']);

$a_json = array();
$a_json_row = array();
 $query1 = "select * from master_interfacemachine where machine like '%$machinename%' and recordstatus <> 'deleted' order by machine limit 0,20";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$citemcode = $res1["machinecode"];
	$citemcode = strtoupper($citemcode);
	$citemname = $res1["machine"];
	$citemname = strtoupper($citemname);

	$citemname = stripslashes($citemname);
	$citemname = preg_replace('/,/', ' ', $citemname);
	$citemname = preg_replace ('/["]/i','\"', $citemname);
	$citemname = preg_replace ("/[']/i","\'", $citemname);
	
	$a_json_row["citemcode"] = trim($citemcode);
	$a_json_row["citemname"] = trim($citemname);
	$a_json_row["value"] = $citemname;
	$a_json_row["label"] = $citemcode.'||'.$citemname;
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);

?>