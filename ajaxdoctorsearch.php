<?php
//session_start();
include ("db/db_connect.php");




$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "select employeecode,employeename,username from master_employee where employeename like '%$term%' and  status <> 'Deleted' order by employeename limit 0,10";
 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{

	  
	$itemname = $res2['employeename'];
	$itemcode = $res2['employeecode'];
	$username = $res2['username'];
	
	
	
	$itemname = preg_replace('/,/', ' ', $itemname); 
	
	$a_json_row["value"] = $itemname;
	$a_json_row["label"] = $itemname;
	$a_json_row["auto_number"] = $itemcode;
	$a_json_row["username"] = $username;
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>