<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();
$query2 = "select scheme_name,scheme_id,scheme_expiry,scheme_active_status from master_planname where scheme_name like '%$term%' group by scheme_id";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$scheme_name = $res2['scheme_name'];	  
	$scheme_id = $res2['scheme_id'];	$scheme_expiry = $res2['scheme_expiry'];	$scheme_active_status = $res2['scheme_active_status'];

	$a_json_row["value"] = $scheme_name;
	//$a_json_row["label"] = $scheme_name.' | '.$scheme_id;	$a_json_row["label"] = $scheme_name;
	$a_json_row["scheme_id"] = $scheme_id;	$a_json_row["scheme_expiry"] = $scheme_expiry;	$a_json_row["scheme_active_status"] = $scheme_active_status;
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>