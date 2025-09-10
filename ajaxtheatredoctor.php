<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "SELECT doctorcode, doctorname FROM master_doctor WHERE doctorname LIKE '%$term%' AND status <> 'deleted' AND doctorname <> ''";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$docname = $res2['doctorname'];	  
	//$docauto = $res2['auto_number'];
	$docid = $res2['doctorcode'];
	
	$docname = preg_replace('/,/', ' ', $docname); 
	
	$a_json_row["value"] = $docname;
	$a_json_row["label"] = $docname;
	//$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["docid"] = $docid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>