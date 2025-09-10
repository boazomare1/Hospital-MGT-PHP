<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "select id,accountname from master_accountname where accountname like '%$term%' and accountssub='19' and recordstatus <> 'Deleted' limit 0,10";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{	  
	$accountname = $res2['accountname'];  
	$suppliercode = $res2['id'];
		
	$a_json_row["value"] = $accountname;
	$a_json_row["label"] = $accountname;
	$a_json_row["suppliercode"] = $suppliercode;
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>
