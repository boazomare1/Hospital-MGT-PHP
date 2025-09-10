<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
$docno = $_SESSION["docno"];

$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
$sampleid = $_REQUEST['sampleid'];	
$amacid = $_REQUEST['amacid'];	

$query61 = "select auto_number from opipsampleid_lab where docnumber = '$docnumber' order by auto_number desc ";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
$res61 = mysqli_fetch_array($exec61);
 $auto_number=$res61['auto_number'];

$query7 = "select * from ipsamplecollection_lab where sampleid = '$sampleid'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
$res7 = mysqli_fetch_array($exec7);
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];

$query1 = "select * from master_interfacemachine where machinecode = '$amacid'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1autonumber = $res1['auto_number'];
$res1machine = $res1['machine'];
$res1machineip = $res1['machineip'];
$machinecode = $res1['machinecode'];
$machineport = $res1['machineport'];		 
				  
  if($patientcode == 'DIRECT')
  {
  $patientcode = 'walkin';
  }
  if($visitcode == 'DIRECT')
  {
  $visitcode = 'walkinvis';
  }
  
$query31="INSERT INTO `samplecollection_laban`(`patientname`, `patientcode`, `patientvisitcode`, `recorddate`, `recordtime`, `itemcode`, `itemname`, `sampleid`, `sample`, `acknowledge`, `refund`, `resultentry`, `billnumber`, `docnumber`, `locationcode`, `locationname`) 
SELECT `patientname`, `patientcode`, `patientvisitcode`, `recorddate`, `recordtime`, `itemcode`, `itemname`, `sampleid`, `sample`, `acknowledge`, `refund`, `resultentry`, `billnumber`, `docnumber`, `locationcode`, `locationname` FROM `ipsamplecollection_lab` WHERE patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid = '$sampleid' and acknowledge = 'completed' and docnumber='$docnumber'";
$exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

$query32 = "update samplecollection_laban set analyseranum = '$res1autonumber', analysercode = '$machinecode', analysername = '$res1machine', analyserport = '$machineport' , samplenum='$auto_number' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid = '$sampleid' and acknowledge = 'completed' and docnumber='$docnumber'";
$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

$query76 = "update ipsamplecollection_lab set resultentry='completed' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid = '$sampleid' and docnumber='$docnumber'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 
 $query29="update ipconsultation_lab set resultentry='completed' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$docnumber'";
 $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29);
 
 header('location:samplecollection.php');

?>
	  