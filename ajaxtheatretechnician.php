<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "SELECT employeename, employeecode from master_employee where employeename like '%$term%'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$technicianname = $res2['employeename'];	  
	//$docauto = $res2['auto_number'];
	$technicianid = $res2['employeecode'];
	
	$technicianname = preg_replace('/,/', ' ', $technicianname); 
	
	$a_json_row["value"] = $technicianname;
	$a_json_row["label"] = $technicianname;
	//$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["docid"] = $technicianid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>