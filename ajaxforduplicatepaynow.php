<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$patientcode = $_POST['patientcode'];
$visitcode = $_POST['visitcode'];
$form_flag = $_POST['form_flag'];

$date = date("Y-m-d");
if($form_flag=='paynow'){
$tempData = html_entity_decode($_POST['arr']);

$content = json_decode($tempData, true);
$ref_count=0;
$pending_count=0;
foreach($content as $key => $value) {
	$refno = $value['refno'];
	$query19 = "select auto_number from consultation_lab where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' 
	UNION ALL select auto_number from consultation_radiology where refno='$refno' and  patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0'
	UNION ALL select auto_number from consultation_services where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0'
	UNION ALL select auto_number from consultation_referal where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'
	UNION ALL select auto_number from op_ambulance where docno='$refno' and patientvisitcode='$visitcode' and billtype='PAY NOW' and patientcode='$patientcode' and paymentstatus='pending'
	UNION ALL select auto_number from homecare where docno='$refno' and patientvisitcode='$visitcode' and billtype='PAY NOW' and patientcode='$patientcode' and paymentstatus='pending'
	UNION ALL select auto_number from consultation_departmentreferal where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'
	UNION ALL select auto_number from master_consultationpharm where refno='$refno' and patientvisitcode='$visitcode' and patientcode='$patientcode' and pharmacybill='pending' and medicineissue='pending' and billing='' and approvalstatus !='0' and (amendstatus='1' OR amendstatus=2)
	";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$labrec = mysqli_num_rows($exec19);
	if($labrec>0)
	{
		$pending_count++;
	}
	
	$ref_count++;
}
if($pending_count==$ref_count)
{
	echo 'yes';
}else
{
	echo 'no';
}
}		


if($form_flag=='consultation'){
	
	   $query1 = "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode' and  paymentstatus = ''";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows = mysqli_num_rows($exec1);
	if($rows>0)
	{
		echo'yes';
	}else
	{
		echo 'no';
	}
}
if($form_flag=='deposit'){
	
	 $query51 = "select * from master_ipvisitentry where deposit='' and patientcode='$patientcode' and visitcode='$visitcode' and billtype='PAY NOW' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows = mysqli_num_rows($exec51);
	if($rows>0)
	{
		echo 'yes';
	}else
	{
		echo 'no';
	}
}
if($form_flag=='copay'){
	
	$querymch1 = "select auto_number from consultation_lab where paymentstatus!='pending' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes'  and patientvisitcode='$visitcode' and  approvalstatus='1'
UNION ALL select auto_number from master_consultationpharm where paymentstatus!='pending' and billing <> 'completed' and billtype='PAY LATER' and patientvisitcode='$visitcode'	
UNION ALL select auto_number from consultation_radiology where paymentstatus!='pending' and billtype='PAY LATER' and patientvisitcode='$visitcode'  and approvalstatus='1'	
UNION ALL select auto_number from consultation_services where paymentstatus!='pending'  and billtype='PAY LATER' and patientvisitcode='$visitcode' and approvalstatus='1' 	
UNION ALL select auto_number from consultation_departmentreferal where paymentstatus!='pending' and billtype='PAY LATER' and patientvisitcode='$visitcode' 
UNION ALL select auto_number from consultation_referal where paymentstatus!='pending' and billtype='PAY LATER' and patientvisitcode='$visitcode' 
UNION ALL select auto_number from consultation_services where paymentstatus!='pending' and billtype='PAY LATER' and patientvisitcode='$visitcode' and approvalstatus='1'
	";
$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Querymch1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numsmch1 = mysqli_num_rows($execmch1);	
	if($numsmch1>0)
	{
		echo 'yes';
	}else
	{
		echo 'no';
	}
	 
}
?>