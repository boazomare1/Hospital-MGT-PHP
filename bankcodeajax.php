<?php
//session_start();
include ("db/db_connect.php");




$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "select bankname,bankcode from master_bank where bankname like '%$term%' and bankstatus <> 'Deleted' limit 0,10";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{

	  
	$bankname = $res2['bankname'];	  
	$bankcode = $res2['bankcode'];
	
	
	$bankname = preg_replace('/,/', ' ', $bankname); 
	
	$a_json_row["value"] = $bankname;
	$a_json_row["label"] = $bankname;
	$a_json_row["bankcode"] = $bankcode;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>