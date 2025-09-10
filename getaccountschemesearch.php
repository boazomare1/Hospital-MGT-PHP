<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = $_REQUEST['term']; 
$subtype = $_REQUEST['searchsubtypeanum']; 
$a_json = array();
$a_json_row = array();

$query2 = "select auto_number,scheme_id,scheme_name from master_planname where scheme_name like '%$term%' and subtype='$subtype'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{  
	$saccountauto = $res2['auto_number'];
	$saccountid = $res2['scheme_id'];
	$scheme_name = $res2['scheme_name'];
	
	$scheme_name = preg_replace('/,/', ' ', $scheme_name); 
	
	$a_json_row["value"] = $scheme_name;
	$a_json_row["label"] = $scheme_name;
	$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["saccountid"] = $saccountid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>