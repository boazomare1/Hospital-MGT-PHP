<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Day-To-Day Flash.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


$snocount = "";
$colorloopcount="";
$totalopcount = $totaldiagnosticcount = $totaloutpatients = $totaladmissioncount = $totalavailablebeds = $totaloccupiedbeds = $totaloccupancyratio = $totalradiologywalkin = $totalradiologyoutpatient = $totalradiologyinpatient = $sumradiology = $totalxraywalkin = $totalxrayoutpatient = $totalxrayinpatient = $sumxray = $totalultrasoundwalkin = $totalultrasoundoutpatient = $totalultrasoundinpatient = $sumultrasound = $totalctscanwalkin = $totalctscanoutpatient = $totalctscaninpatient = $sumctscan = $totallabwalkin = $totallaboutpatient = $totallabinpatient = $sumlab = $totalpharmacywalkin = $totalpharmacyoutpatient = $totalpharmacyinpatient = $sumpharmacy = $sumadmissions = $totaldialysisadmissions = $totalendoscopyadmissions = 0;


if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddateto = $ADate1; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }


$ADate2 = date('Y-m-01', strtotime($ADate1));
$start = strtotime($ADate2.'-1 day');
$end = strtotime($ADate1);
$days_between = ceil(abs($end - $start) / 86400);



function getOPVisitCount($ADate1, $ADate2){
  /*$query1 = "select sum(count) as count from (
    select count(*) as count from master_visitentry where department != '24' and consultationdate between '$ADate1' and '$ADate2' group by visitcode
  ) as cnt1";
  $exec1 = mysql_query($query1) or die("Error in Query1".mysql_error());
  $res1 = mysql_fetch_array($exec1);
  $count = $res1['count']; */
  $fulltotalopvisit=0;

  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1)){
	$totalopd = $totalip = 0;
	$paymentcode = $res1['auto_number'];  
	$paymenttype = $res1['paymenttype']; 
  $query5 = "select count(count) as count, misreport from (

    select count, a.misreport FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, A.misreport FROM `billing_paylater` JOIN (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department != '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$paymentcode' group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res5 = mysqli_fetch_array($exec5)){
	  $opcount = $res5['count'];

	  $opvisit = $opcount;
	  $fulltotalopvisit += $opvisit;
	}

  }

  return $fulltotalopvisit;
}

function getOPDiagnosticCount($ADate1, $ADate2){
  /*$query1 = "select sum(count) as count from (
    select count(*) as count from master_visitentry where department = '24' and consultationdate between '$ADate1' and '$ADate2' group by visitcode
  ) as cnt1";
  $exec1 = mysql_query($query1) or die("Error in Query1".mysql_error());
  $res1 = mysql_fetch_array($exec1);
  $count = $res1['count'];

  return $count; */

  $fulltotalopvisit=0;

  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1)){
	$totalopd = $totalip = 0;
	$paymentcode = $res1['auto_number'];  
	$paymenttype = $res1['paymenttype']; 
  $query5 = "select count(count) as count, misreport from (

    select count, a.misreport FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, A.misreport FROM `billing_paylater` JOIN (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department = '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$paymentcode' group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res5 = mysqli_fetch_array($exec5)){
	  $opcount = $res5['count'];

	  $opvisit = $opcount;
	  $fulltotalopvisit += $opvisit;
	}
	}
   return $fulltotalopvisit;
  
}


function getTotalOutPatients($ADate1, $ADate2){
  $visits = getOPVisitCount($ADate1, $ADate2);
  $diagnostics = getOPDiagnosticCount($ADate1, $ADate2);

  return $visits + $diagnostics;
}

function getAdmissions($ADate1, $ADate2){
 $count=0;
// $fulltotaladmissioncount=0;
// $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
// 	$exec1 = mysql_query($query1) or die(mysql_error());
// 	while($res1 = mysql_fetch_array($exec1)){
// 	$totalopd = $totalip = 0;
// 	$paymentcode = $res1['auto_number'];  
// 	$paymenttype = $res1['paymenttype'];

//   $query1 = "select count(ip_bedallocation.accountname) as count, A.misreport from ip_bedallocation join (select distinct(accountname), misreport from master_accountname) as A ON ip_bedallocation.accountname = A.accountname where (ip_bedallocation.recorddate BETWEEN '$ADate1' AND '$ADate2') and A.misreport = '$paymentcode' and ip_bedallocation.ward NOT IN ('1','2','3','8','17')";
  
//   $exec6 = mysql_query($query1) or die(mysql_error());
// 	while($res6 = mysql_fetch_array($exec6)){
// 	  $admissioncount0 = $res6['count'];
// 	  $admissionpaymentcode = $res6['misreport'];

// 	  if($admissionpaymentcode == $paymentcode){
// 		$admissioncount = $admissioncount0;
// 		$fulltotaladmissioncount += $admissioncount;
// 	  } else {
// 		$admissioncount = 0;
// 	  }
// 	}

//   $count = $fulltotaladmissioncount;
//  }

 $query1 = "select count(*) as count from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2'  ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];
  return $count;
}

function getAvailableBeds(){

  $get_latesttemp='SELECT bedtemplate FROM `master_subtype` where subtype="CASH"';
  $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $get_latesttemp) or die("Error in get_latesttemp".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res12 = mysqli_fetch_array($exec12);

  $get_latesttemp2='SELECT referencetable FROM master_testtemplate where templatename="'.$res12['bedtemplate'].'"';
  $exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $get_latesttemp2) or die("Error in get_latesttemp2".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res122 = mysqli_fetch_array($exec122);
  $bedtable=$res122['referencetable'];

  if($bedtable=='')
	  $bedtable='master_bed';

  $query1 = "select count(*) as count from $bedtable where  recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getOccupiedBeds($ADate1, $ADate2){
 $query1 = "SELECT sum(count) as count from (
    select count(visitcode) as count from ip_bedallocation where  recorddate <= '$ADate2' and  visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2')
    ) as amt1";
  
   // $query1 = "select sum(count) as count from (
   //  select count(visitcode) as count from ip_bedallocation where  recorddate <= '$ADate2' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2')
   //  UNION ALL 
   //  select count(visitcode) as count from ip_bedtransfer where  recorddate <= '$ADate2' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2') and recordstatus <> 'transfered'
   //  ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getOccupancyRatio($ADate1, $ADate2){
  $occupancy = 0;
  $beddays = getAvailableBeds($ADate1, $ADate2);
  $patientdays = getOccupiedBeds($ADate1, $ADate2);

  if($beddays!='0' && $patientdays!='0'){ $occupancy = ($patientdays/$beddays)*100; }
  return $occupancy;
}

function getRadiologyWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getRadiologyOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getRadiologyInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from ipconsultation_radiology where consultationdate between '$ADate1' and '$ADate2'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalRadiology($ADate1, $ADate2){
  $walkin = getRadiologyWalkin($ADate1, $ADate2);
  $outpatient = getRadiologyOutpatient($ADate1, $ADate2);
  $inpatient = getRadiologyInpatient($ADate1, $ADate2);

  $totalradiology = $walkin + $outpatient + $inpatient;
  return $totalradiology;
}

function getXrayWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24' and c.categoryname = 'X-RAY'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getXrayOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24' and c.categoryname = 'X-RAY'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getXrayInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from ipconsultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode = b.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.categoryname = 'X-RAY'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalXray($ADate1, $ADate2){
  $walkin = getXrayWalkin($ADate1, $ADate2);
  $outpatient = getXrayOutpatient($ADate1, $ADate2);
  $inpatient = getXrayInpatient($ADate1, $ADate2);

  $totalxray = $walkin + $outpatient + $inpatient;
  return $totalxray;
}

function getUltrasoundWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24' and c.categoryname = 'ULTRASOUND'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getUltrasoundOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24' and c.categoryname = 'ULTRASOUND'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getUltrasoundInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from ipconsultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode = b.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.categoryname = 'ULTRASOUND'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalUltrasound($ADate1, $ADate2){
  $walkin = getUltrasoundWalkin($ADate1, $ADate2);
  $outpatient = getUltrasoundOutpatient($ADate1, $ADate2);
  $inpatient = getUltrasoundInpatient($ADate1, $ADate2);

  $totalultrasound = $walkin + $outpatient + $inpatient;
  return $totalultrasound;
}

function getCtScanWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24' and c.categoryname = 'CT SCAN'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getCtScanOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode JOIN master_radiology as c ON a.radiologyitemcode = c.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24' and c.categoryname = 'CT SCAN'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getCtScanInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from ipconsultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode = b.itemcode where a.consultationdate between '$ADate1' and '$ADate2' and b.categoryname = 'CT SCAN'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalCtScan($ADate1, $ADate2){
  $walkin = getCtScanWalkin($ADate1, $ADate2);
  $outpatient = getCtScanOutpatient($ADate1, $ADate2);
  $inpatient = getCtScanInpatient($ADate1, $ADate2);

  $totalctscan = $walkin + $outpatient + $inpatient;
  return $totalctscan;
}

function getLabWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_lab as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getLabOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from consultation_lab as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getLabInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from ipconsultation_lab as a where a.consultationdate between '$ADate1' and '$ADate2'
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalLab($ADate1, $ADate2){
  $walkin = getLabWalkin($ADate1, $ADate2);
  $outpatient = getLabOutpatient($ADate1, $ADate2);
  $inpatient = getLabInpatient($ADate1, $ADate2);

  $totallab = $walkin + $outpatient + $inpatient;
  return $totallab;
}

function getPharmacyWalkin($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(distinct billnumber) as count from billing_paynowpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department = '24' 
    UNION ALL
    select count(distinct billnumber) as count from billing_paylaterpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department = '24' 
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getPharmacyOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(distinct billnumber) as count from billing_paynowpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department != '24' 
    UNION ALL
    select count(distinct billnumber) as count from billing_paylaterpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department != '24' 
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getPharmacyInpatient($ADate1, $ADate2){
 /* $query1 = "select sum(count) as count from (
    select count(distinct billnumber) as count from billing_ippharmacy where billdate between '$ADate1' and '$ADate2'
    ) as amt1"; */
  
  $query1 = "select count(count) as count from (
    select docno as count from ipmedicine_prescription where date between '$ADate1' and '$ADate2' group by docno
    ) as amt1";

  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalPharmacy($ADate1, $ADate2){
  $walkin = getPharmacyWalkin($ADate1, $ADate2);
  $outpatient = getPharmacyOutpatient($ADate1, $ADate2);
  $inpatient = getPharmacyInpatient($ADate1, $ADate2);

  $totalpharmacy = $walkin + $outpatient + $inpatient;
  return $totalpharmacy;
}

function getWardAdmissions($wardcode, $ADate1, $ADate2){
  $query1 = "select count(*) as count from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2' and ward = '$wardcode'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getTotalWardAdmissions($ADate1, $ADate2){
  $query1 = "select count(*) as count from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2'  ";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count; 
}

?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="<?php echo ($days_between+4)*50; ?>" align="left" border="1">
<tbody>
  <tr>
    <td align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31" colspan="<?php echo $days_between+2; ?>"><strong>DAY TO DAY FLASH</strong></td>
  </tr>
  <tr>
    <td align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31" colspan="<?php echo $days_between+2; ?>"><strong><?php echo date('M', strtotime($ADate1)).' '.date('Y', strtotime($ADate1)); ?></strong></td>
  </tr>
  <tr>
    <td width="150" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Indicator/Date</strong></td>
    <?php for($i = 1; $i <= $days_between; $i++){ ?>
    <td width="40" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $i; ?></strong></td>
    <?php } ?>
    <td width="50" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>TOTAL</strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Out Patient - Visits & Revisits</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $opcount = getOPVisitCount($ADate11, $ADate11);
      $totalopcount += $opcount;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($opcount); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalopcount); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Out Patient - Diagnostics</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $diagnosticcount = getOPDiagnosticCount($ADate11, $ADate11);
      $totaldiagnosticcount += $diagnosticcount;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($diagnosticcount); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldiagnosticcount); ?></td>
  </tr>

  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Outpatients</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $outpatients = getTotalOutPatients($ADate11, $ADate11);
      $totaloutpatients += $outpatients;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($outpatients); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaloutpatients); ?></strong></td>
  </tr>
  <tr>
    <td bgcolor="#ecf0f5" colspan="<?php echo $days_between+2; ?>"></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Admissions</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $admissioncount = getAdmissions($ADate11, $ADate11);
      $totaladmissioncount += $admissioncount;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($admissioncount); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaladmissioncount); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Available Beds</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $availablebeds = getAvailableBeds();
      $totalavailablebeds += $availablebeds;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($availablebeds); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalavailablebeds); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Occupied Beds</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $occupiedbeds = getOccupiedBeds($ADate11, $ADate11);
      $totaloccupiedbeds += $occupiedbeds;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($occupiedbeds); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaloccupiedbeds); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Occupancy Ratio</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $occupancyratio = getOccupancyRatio($ADate11, $ADate11);
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($occupancyratio).'%'; ?></td>
    <?php } if($totaloccupiedbeds!='0' && $totalavailablebeds!='0'){ $totaloccupancyratio = ($totaloccupiedbeds/$totalavailablebeds)*100; } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaloccupancyratio).'%'; ?></td>
  </tr>
  <tr>
    <td bgcolor="#ecf0f5" colspan="<?php echo $days_between+2; ?>"></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Radiology Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $radiologywalkin = getRadiologyWalkin($ADate11, $ADate11);
      $totalradiologywalkin += $radiologywalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($radiologywalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalradiologywalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Radiology Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $radiologyoutpatient = getRadiologyOutpatient($ADate11, $ADate11);
      $totalradiologyoutpatient += $radiologyoutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($radiologyoutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalradiologyoutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Radiology Inpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $radiologyinpatient = getRadiologyInpatient($ADate11, $ADate11);
      $totalradiologyinpatient += $radiologyinpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($radiologyinpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalradiologyinpatient); ?></td>
  </tr>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Radiology</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalradiology = getTotalRadiology($ADate11, $ADate11);
      $sumradiology += $totalradiology;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalradiology); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumradiology); ?></strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">X-Ray Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $xraywalkin = getXrayWalkin($ADate11, $ADate11);
      $totalxraywalkin += $xraywalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($xraywalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalxraywalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">X-Ray Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $xrayoutpatient = getXrayOutpatient($ADate11, $ADate11);
      $totalxrayoutpatient += $xrayoutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($xrayoutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalxrayoutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">X-Ray Inpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $xrayinpatient = getXrayInpatient($ADate11, $ADate11);
      $totalxrayinpatient += $xrayinpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($xrayinpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalxrayinpatient); ?></td>
  </tr>
   <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total X-Ray</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalxray = getTotalXray($ADate11, $ADate11);
      $sumxray += $totalxray;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalxray); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumxray); ?></strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Ultrasound Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ultrasoundwalkin = getUltrasoundWalkin($ADate11, $ADate11);
      $totalultrasoundwalkin += $ultrasoundwalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ultrasoundwalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalultrasoundwalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Ultrasound Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ultrasoundoutpatient = getUltrasoundOutpatient($ADate11, $ADate11);
      $totalultrasoundoutpatient += $ultrasoundoutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ultrasoundoutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalultrasoundoutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Ultrasound Inpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ultrasoundinpatient = getUltrasoundInpatient($ADate11, $ADate11);
      $totalultrasoundinpatient += $ultrasoundinpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ultrasoundinpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalultrasoundinpatient); ?></td>
  </tr>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Ultrasound</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalultrasound = getTotalUltrasound($ADate11, $ADate11);
      $sumultrasound += $totalultrasound;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalultrasound); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumultrasound); ?></strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">CT Scan Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ctscanwalkin = getCtScanWalkin($ADate11, $ADate11);
      $totalctscanwalkin += $ctscanwalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ctscanwalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalctscanwalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">CT Scan Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ctscanoutpatient = getCtScanOutpatient($ADate11, $ADate11);
      $totalctscanoutpatient += $ctscanoutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ctscanoutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalctscanoutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">CT Scan Inpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $ctscaninpatient = getCtScanInpatient($ADate11, $ADate11);
      $totalctscaninpatient += $ctscaninpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ctscaninpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalctscaninpatient); ?></td>
  </tr>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total CT Scan</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalctscan = getTotalCtScan($ADate11, $ADate11);
      $sumctscan += $totalctscan;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalctscan); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumctscan); ?></strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Laboratory Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $labwalkin = getLabWalkin($ADate11, $ADate11);
      $totallabwalkin += $labwalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($labwalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totallabwalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Laboratory Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $laboutpatient = getLabOutpatient($ADate11, $ADate11);
      $totallaboutpatient += $laboutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($laboutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totallaboutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Laboratory Inpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $labinpatient = getLabInpatient($ADate11, $ADate11);
      $totallabinpatient += $labinpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($labinpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totallabinpatient); ?></td>
  </tr>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Laboratory</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totallab = getTotalLab($ADate11, $ADate11);
      $sumlab += $totallab;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totallab); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumlab); ?></strong></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">OP Prescriptions Walkin</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $pharmacywalkin = getPharmacyWalkin($ADate11, $ADate11);
      $totalpharmacywalkin += $pharmacywalkin;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($pharmacywalkin); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalpharmacywalkin); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">OP Prescriptions Outpatient</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $pharmacyoutpatient = getPharmacyOutpatient($ADate11, $ADate11);
      $totalpharmacyoutpatient += $pharmacyoutpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($pharmacyoutpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalpharmacyoutpatient); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">IP Prescriptions</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $pharmacyinpatient = getPharmacyInpatient($ADate11, $ADate11);
      $totalpharmacyinpatient += $pharmacyinpatient;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($pharmacyinpatient); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalpharmacyinpatient); ?></td>
  </tr>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Prescriptions</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalpharmacy = getTotalPharmacy($ADate11, $ADate11);
      $sumpharmacy += $totalpharmacy;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalpharmacy); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumpharmacy); ?></strong></td>
  </tr>
  <tr>
    <td bgcolor="#ecf0f5" colspan="<?php echo $days_between+2; ?>"></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Renal/Dialysis</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $dialysisadmissions = getWardAdmissions(2, $ADate11, $ADate11);
      $totaldialysisadmissions += $dialysisadmissions;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($dialysisadmissions); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldialysisadmissions); ?></td>
  </tr>
  <?php
    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Endoscopy</td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $endoscopyadmissions = getWardAdmissions(3, $ADate11, $ADate11);
      $totalendoscopyadmissions += $endoscopyadmissions;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($endoscopyadmissions); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalendoscopyadmissions); ?></td>
  </tr>
  <tr>
    <td bgcolor="#ecf0f5" colspan="<?php echo $days_between+2; ?>"></td>
  </tr>
  <?php
  $query3 = "select * from master_ward where auto_number NOT IN ('1','2','3','8','17')";
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res3=mysqli_fetch_array($exec3)){
    $wardname = $res3['ward'];
    $wardcode = $res3['auto_number'];
    $totaldayadmissions = 0;

    $snocount = $snocount + 1;
    $colorloopcount = $colorloopcount + 1;
    $showcolor = ($colorloopcount & 1); 
    
    if ($showcolor == 0)
    {
      $colorcode = 'bgcolor="#ffffff"';
    }
    else
    {
      $colorcode = 'bgcolor="#ffffff"';
    } 
  ?>
  <tr>
    <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo $wardname; ?></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totaladmissions = getWardAdmissions($wardcode, $ADate11, $ADate11);
      $totaldayadmissions += $totaladmissions;
    ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaladmissions); ?></td>
    <?php } ?>
    <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldayadmissions); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Admissions</strong></td>
    <?php 
    for($i=1; $i<=$days_between; $i++){ 
      if($i < 10){ $i = '0'.$i; }
      $ADate11 = date('Y-m-'.$i, strtotime($ADate1));
      $totalwardadmissions = getTotalWardAdmissions($ADate11, $ADate11);
      $sumadmissions += $totalwardadmissions;
    ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalwardadmissions); ?></strong></td>
    <?php } ?>
    <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumadmissions); ?></strong></td>
  </tr>
</tbody>  
</table>