<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

$a_json = array();
$a_json_row = array();
$query1 = "select doctorcode,doctorname from master_doctor where doctorname like '%$term%' and status <> 'Deleted'  order by auto_number limit 50";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$doctorcode = $res1['doctorcode'];
	$doctorname=$res1['doctorname'];
	
	$doctorcode = addslashes($doctorcode);

	$doctorname = strtoupper($doctorname);
	
	$doctorcode = trim($doctorcode);
	
	
	$doctorcode = preg_replace('/,/', ' ', $doctorcode);
	$doctorname = preg_replace('/,/', ' ', $doctorname);
	
	$a_json_row["doctorcode"] = $doctorcode;
	$a_json_row["doctorname"] = $doctorname;
	$a_json_row["value"] = trim($doctorname);
	$a_json_row["label"] = trim($doctorname);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>