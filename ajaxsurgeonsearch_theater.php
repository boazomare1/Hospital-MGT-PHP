<?php
//session_start();
include ("db/db_connect.php");
$doctorname = trim($_REQUEST['term']); 
//echo $customersearch;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$stringbuild1 = "";
$query11 = "select * from master_doctor where doctorname like '%$doctorname%' and status <> 'Deleted' order by doctorname";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res11 = mysqli_fetch_array($exec11))
{
	$itemname=$res11['doctorname'];
	$itemcode=$res11['doctorcode'];
	$res11department=$res11['department'];
	$res1doctorfees=$res11['pridoc_charge'];
	
		$query110 = "select * from master_department where auto_number = '$res11department' and recordstatus = '' ";
		$exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in query110".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res110 = mysqli_fetch_array($exec110);
		$department=$res110['department'];
	
	
	
	$a_json_row["itemname"] = $itemname;
	$a_json_row["itemcode"] = $itemcode;
	$a_json_row["res1doctorfees"] = $res1doctorfees;
	$a_json_row["department"] = $department;
	
	$a_json_row["value"] = trim($itemname);
	$a_json_row["itemcode"] = trim($itemcode);
	$a_json_row["res1doctorfees"] = trim($res1doctorfees);
	$a_json_row["department"] = trim($department);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);

?>