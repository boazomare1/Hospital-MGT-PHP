<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = $_REQUEST['term']; 
$main_account_name = $_REQUEST['main_account_name']; 
$first_four_letters = substr($main_account_name, 0, 4);
$a_json = array();
$a_json_row = array();

$query2 = "select auto_number,subtype from master_subtype where subtype like '%$term%' and subtype like '%$first_four_letters%'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{  
	$saccountauto = $res2['auto_number'];
	$scheme_name = $res2['subtype'];
	
	$scheme_name = preg_replace('/,/', ' ', $scheme_name); 
	
	$a_json_row["value"] = $scheme_name;
	$a_json_row["label"] = $scheme_name;
	$a_json_row["saccountauto"] = $saccountauto;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>