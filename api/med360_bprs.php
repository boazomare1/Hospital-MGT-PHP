<?php

header("Content-Type: application/json; charset=UTF-8");

$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '@spyc3@1ct@2019';
$databasename = 'premier';


$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));

$a_json = array();
$a_json_row = array();

$query1 = "SELECT `logo_url`, `login_api_url`, `patient_details_api_url`, `register_url`, `opvisit_url`, `ipvisit_url` FROM `med360_bprs`";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$logo_url = $res1['logo_url'];
	$login_api_url = $res1['login_api_url'];
	$patient_details_api_url = $res1['patient_details_api_url'];
	$register_url = $res1['register_url'];
	$opvisit_url = $res1['opvisit_url'];
	$ipvisit_url = $res1['ipvisit_url'];
	
	$a_json_row["companyLogo"] = trim($logo_url);
	$a_json_row["loginAPIURL"] = trim($login_api_url);
	$a_json_row["patientDetailsAPIURL"] = trim($patient_details_api_url);
	$a_json_row["newPatientRegistrationURL"] = trim($register_url);
	$a_json_row["oPVisitURL"] = trim($opvisit_url);
	$a_json_row["iPVisitURL"] = trim($ipvisit_url);
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
?>