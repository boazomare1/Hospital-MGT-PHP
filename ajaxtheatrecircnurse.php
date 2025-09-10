<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "SELECT employeename, employeecode from master_employee ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$circnursename = $res2['employeename'];	  
	//$docauto = $res2['auto_number'];
	$circnurseid = $res2['employeecode'];
	
	$circnursename = preg_replace('/,/', ' ', $circnursename); 
	
	$a_json_row["value"] = $circnursename;
	$a_json_row["label"] = $circnursename;
	//$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["docid"] = $circnurseid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>