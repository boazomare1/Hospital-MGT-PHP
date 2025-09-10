<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$patientcode = $_POST['patientcode'];
$visitcode = $_POST['visitcode'];

$date = date("Y-m-d");

$tempData = html_entity_decode($_POST['arr']);

$content = json_decode($tempData, true);
$texxt='';
$ref_count=0;
$pending_count=0;
foreach($content as $key => $value) {
	$refno = $value['refno'];
	$query19 = "select auto_number from consultation_lab where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' 
	UNION ALL select auto_number from consultation_radiology where refno='$refno' and  patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0'
	";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$labrec = mysqli_num_rows($exec19);
	if($labrec>0)
	{
		$pending_count++;
	}
	
	$texxt=$texxt.$refno;
	$ref_count++;
}
if($pending_count==$ref_count)
{
	echo 'yes';
}else
{
	echo 'no';
}
			
?>