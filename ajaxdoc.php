<?php
include ("db/db_connect.php");
$doc = trim($_REQUEST['term']);
$a_json = array();
$a_json_row = array();
$qrydoc = "select * from master_doctor where doctorname like '%".$doc."%'";
$excdoc= mysqli_query($GLOBALS["___mysqli_ston"], $qrydoc) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resdoc = mysqli_fetch_array($excdoc))
{
	$doctorname=$resdoc['doctorname'];
	$doctorcode=$resdoc['doctorcode'];
	$a_json_row["id"] = $doctorcode;
	$a_json_row["value"] = trim($doctorname);
	$a_json_row["label"] = '#'.trim($doctorcode).' || '.trim($doctorname);
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
?>