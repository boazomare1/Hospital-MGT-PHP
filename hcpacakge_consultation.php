<?php
if($servicescode != '')
{
$qrycheckhc = "select wellnesspkg,itemname from master_services where itemcode like '$servicescode' and status <> 'deleted'";
$execcheckhc = mysqli_query($GLOBALS["___mysqli_ston"], $qrycheckhc) or die("Error in Qrycheckhc ".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescheckhc = mysqli_fetch_array($execcheckhc);
if($rescheckhc['wellnesspkg']=='1')
{
	$sername = $rescheckhc['itemname'];
	//phramcy insert
	
	$qryhcser = "select * from healthcarepackagelinking where servicecode like '$servicescode' and department = 4 and recordstatus <> 'deleted' ";
	$exechcser = mysqli_query($GLOBALS["___mysqli_ston"], $qryhcser) or die("Error in Qryhcser ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resser = mysqli_fetch_array($exechcser))
	{
		$servcode = $resser['itemcode'];
		$servname = $resser['itemname'];
		$servname = addslashes($servname);
				$servicesrate=0;
				
				$res111subtype=trim($_REQUEST['subtype']);
$query13s = "select sertemplate from master_subtype where auto_number = '$res111subtype' order by subtype";
$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13s = mysqli_fetch_array($exec13s);
$tablenames = $res13s['sertemplate'];
if($tablenames == '')
{
  $tablenames = 'master_services';
}
				$query1 = "select * from $tablenames where itemcode ='$servcode' and status <> 'Deleted' AND locationcode = '".$locationcodeget."' AND rateperunit <> 0 order by itemcode";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

	//$res1autonumber = $res1['auto_number'];
	$servicesrate=$res1['rateperunit'];
	

		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,refno,process,consultationtime,username,locationname,locationcode,serviceqty,amount,wellnessitem,mcc)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servcode','".$servname."','$servicesrate','$billingtype','$accountname','$currentdate','pending','$serrefcode','pending','$timestamp','$username','$locationnameget','$locationcodeget','1','$servicesrate','1','$mcc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		
	}
}
}

?>
