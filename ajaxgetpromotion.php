<?php
//session_start();
include ("db/db_connect.php");
$customercode = trim($_REQUEST['term']);
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
 $query1 = "select auto_number,promotion from master_promotion where promotion LIKE '%$customercode%'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$auto_number=$res1['auto_number'];
$promotion=$res1['promotion'];

   $a_json_row["auto_number"] = $auto_number;

	$a_json_row["promotion"] = $promotion;
	
	$a_json_row["value"] = trim($promotion);

	$a_json_row["label"] = trim($promotion);

	array_push($a_json, $a_json_row);
	}

echo json_encode($a_json);

?>
