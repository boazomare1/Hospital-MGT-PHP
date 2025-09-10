<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Monthly Cumulative Report.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

if(isset($_REQUEST['locationcode'])){ $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if(isset($_REQUEST['year'])){ $from_year = $_REQUEST['year']; } else { $from_year = ''; }
if(isset($_REQUEST['month'])){ $from_month = $_REQUEST['month']; } else { $from_month = ''; }

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

$totalopcount = $totaldiagnosticcount = $totaloutpatients = $totaladmissioncount = $totalavailablebeds = $totaloccupiedbeds = $totaloccupancyratio = $totalradiologywalkin = $totalradiologyoutpatient = $totalradiologyinpatient = $sumradiology = $totalxraywalkin = $totalxrayoutpatient = $totalxrayinpatient = $sumxray = $totalultrasoundwalkin = $totalultrasoundoutpatient = $totalultrasoundinpatient = $sumultrasound = $totalctscanwalkin = $totalctscanoutpatient = $totalctscaninpatient = $sumctscan = $totallabwalkin = $totallaboutpatient = $totallabinpatient = $sumlab = $totalpharmacywalkin = $totalpharmacyoutpatient = $totalpharmacyinpatient = $sumpharmacy = $sumadmissions = $totaldialysisadmissions = $totalendoscopyadmissions = $totalmonthlyops = $totalaverageops = $totalalos = $totalinpatientincome = $totalaverageincomepobd = $totalaverageincomeadmission = $totaloutpatientincome = $totalaverageopa = $totalcombinedincome = $totaldailygrossincome = 0;


function getOPVisitCount($ADate1, $ADate2){
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
  // $count=0;
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

 $query1 = "select count(*) as count from ip_bedallocation where  recorddate between '$ADate1' and '$ADate2'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getAvailableBeds($days){
  $query1 = "select count(*) as count from master_bed where  recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'] * $days;

  return $count;
}

function getOccupiedBeds($ADate1, $ADate2){
  $startdate = strtotime($ADate1);
  $enddate = strtotime($ADate2);
  $totalpatientdays = 0;

  while($startdate <= $enddate){

    $from_date = date("Y-m-d",$startdate);

    $query31 = "SELECT sum(count) as count from (
         select count(visitcode) as count from ip_bedallocation where  recorddate <= '$from_date'  and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
        ) as amt1";
    // $query31 = "select sum(count) as count from (
    //     select count(visitcode) as count from ip_bedallocation where  recorddate <= '$from_date' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
    //     UNION ALL 
    //     select count(visitcode) as count from ip_bedtransfer where  recorddate <= '$from_date' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date') and recordstatus <> 'transfered'
    //     ) as amt1";

      $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res31 = mysqli_fetch_array($exec31);
      $patientcount = $res31['count'];
      $totalpatientdays += $patientcount;

    $startdate = strtotime('+1 day',strtotime(date("Y-m-d",$startdate)));
  }

  return $totalpatientdays;
}

function getOccupancyRatio($ADate1, $ADate2){
  $occupancy = 0;

  $start = strtotime($ADate1.'-1 day');
  $end = strtotime($ADate2);
  $days_between = ceil(abs($end - $start) / 86400);

  $beddays = getAvailableBeds($days_between);
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
    select count(*) as count from billing_paynowpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department = '24' 
    UNION ALL
    select count(*) as count from billing_paylaterpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department = '24' 
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getPharmacyOutpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from billing_paynowpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department != '24' 
    UNION ALL
    select count(*) as count from billing_paylaterpharmacy as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.billdate between '$ADate1' and '$ADate2' and b.department != '24' 
    ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count;
}

function getPharmacyInpatient($ADate1, $ADate2){
  $query1 = "select sum(count) as count from (
    select count(*) as count from billing_ippharmacy where billdate between '$ADate1' and '$ADate2'
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
  $query1 = "select count(*) as count from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2' ";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['count'];

  return $count; 
}

function getIpdAmount($miscode, $ADate1, $ADate2){
  $query1 = "select sum(amount) as amount from (
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipservices.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_iplab.labitemrate) as amount, A.misreport FROM `billing_iplab` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_iplab.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname where A.misreport = '$miscode' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipbedcharges.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipprivatedoctor.visitcode
	  UNION ALL
      SELECT -1*sum(billing_ipprivatedoctor.sharingamount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipprivatedoctor.visitcode
      UNION ALL
      SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2')
      ) as amount1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $count = $res1['amount'];

  return $count; 
}

function getDiscount($ADate1, $ADate2){
  $totaldiscount = 0;
  $queryx = "select patientcode,visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' UNION ALL select patientcode,visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode";
  $execx = mysqli_query($GLOBALS["___mysqli_ston"], $queryx);
  while($resx = mysqli_fetch_array($execx)){
    $patientcode = $resx['patientcode'];
    $visitcode = $resx['visitcode'];

    $queryipcashdisc = "select sum(-1*rate) as totaldiscount from ip_discount where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and consultationdate between '$ADate1' and '$ADate2'";
    $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
    $resipcashdisc = mysqli_fetch_array($execipdisc);
    $ipcashdisc = $resipcashdisc['totaldiscount'];
    $totaldiscount += $ipcashdisc;
  }
  
  return $totaldiscount;
}

function getRebate($ADate1, $ADate2){
  $queryrebate = "SELECT sum(-1*amount) as totalrebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'";
  $execrebate = mysqli_query($GLOBALS["___mysqli_ston"], $queryrebate) or die("Error in queryrebate".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resrebate = mysqli_fetch_array($execrebate);
  $rebate = $resrebate['totalrebate'];
  
  return $rebate; 
}

function getTotalInpatientIncome($ADate1, $ADate2){
  $ipdamount = $inpatientamount = 0;
  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $paymentcode = $res1['auto_number']; 
    $ipdamount += getIpdAmount($paymentcode, $ADate1, $ADate2);
  }

  $ipdiscount = getDiscount($ADate1, $ADate2);
  $nhifrebate = getRebate($ADate1, $ADate2);

  $inpatientamount = $ipdamount + $ipdiscount + $nhifrebate;

  return $inpatientamount;
}

function getOpdAmount($miscode, $ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
      select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname  where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')  
      UNION ALL
      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_paylaterconsultation.totalamount) as amount, A.misreport FROM `billing_paylaterconsultation` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowpharmacy.fxamount) as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where A.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2') and billing_paynowpharmacy.locationcode = 'LTC-1'
      UNION ALL
      SELECT sum(billing_paylaterpharmacy.amount) as amount, A.misreport FROM `billing_paylaterpharmacy` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterpharmacy.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
      UNION ALL
      SELECT sum(billing_paylaterlab.labitemrate) as amount, A.misreport FROM `billing_paylaterlab` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_paylaterreferal.referalrate) as amount, master_accountname.misreport from billing_paylaterreferal JOIN master_accountname ON billing_paylaterreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paylaterreferal.billdate between '$ADate1' and '$ADate2')
      ) as amount1";

    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res48 = mysqli_fetch_array($exec48)){
      return $res48['amount'];    
    }
}

function getRefund($ADate1, $ADate2){
  $query48 = "select sum(-1*amount) as totalrefund from (
  select sum(consultation) as amount from refund_consultation where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(fxamount) as amount from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(amount)as amount from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(amount)as amount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' 
  UNION ALL SELECT SUM(`amount`) as amount FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)  
  UNION ALL select sum(labitemrate)as amount from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(labitemrate)as amount from refund_paynowlab where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(fxamount)as amount from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(radiologyitemrate)as amount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(fxamount)as amount from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(servicetotal)as amount from refund_paynowservices where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(referalrate) as amount from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(referalrate) as amount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' ) as refund1";
  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
  $res48 = mysqli_fetch_array($exec48);
  return $res48['totalrefund'];    
}

function getOPDiscount($ADate1, $ADate2){
  $queryipcashdisc = "select sum(-1*amount) as amount from (
  select sum(consultationamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(pharmacyamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(labamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(radiologyamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(servicesamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
  ) as amount1";
  $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcashdisc = mysqli_fetch_array($execipdisc);
  $ipcashdisc = $resipcashdisc['amount'];
  return $ipcashdisc; 
}


function getTotalOutpatientIncome($ADate1, $ADate2){
  $opdamount = $outpatientincome = 0;
  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $paymentcode = $res1['auto_number']; 
    $opdamount += getOpdAmount($paymentcode, $ADate1, $ADate2);
  }

  $totalopdrefund = getRefund($ADate1, $ADate2);
  $opdiscount = getOPDiscount($ADate1, $ADate2);

  $outpatientincome = $opdamount + $totalopdrefund + $opdiscount;
  return $outpatientincome;
}

?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="<?php echo ($from_month+3)*90; ?>" align="left" border="1">
  <tbody>
    <tr>
      <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+2; ?>" class="bodytext31" align="center"><strong>MONTHLY CUMULATIVE REPORT</strong></td>
    </tr>
    <?php
      $year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
      $year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
    ?>
    <tr>
      <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+2; ?>" class="bodytext31" align="center"><strong>REPORT FROM <?php echo $year_start.' TO '.$year_end; ?></strong></td>
    </tr>
    <tr>
      <td bgcolor="#ecf0f5" class="bodytext31" align="center" width="100"><strong>Indicator/Date</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
           $month = $months[$i];
           $s_name = $months[0];
           $e_name = $months[$from_month-1];
    ?>
      <td bgcolor="#ecf0f5" class="bodytext31" align="center" width="70"><strong><?php echo $month; ?></strong></td>
    <?php } ?>
    <td bgcolor="#ecf0f5" class="bodytext31" align="center" width="140"><strong><?php echo $s_name.' To '.$e_name; ?></strong></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Out Patient - Visits & Revisits</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $opcount = getOPVisitCount($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Out Patient - Diagnostics</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $diagnosticcount = getOPDiagnosticCount($start_month, $end_month);
        $totaldiagnosticcount += $diagnosticcount;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($diagnosticcount); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldiagnosticcount); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total Outpatients</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $outpatients = getTotalOutPatients($start_month, $end_month);
        $totaloutpatients += $outpatients;
      ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($outpatients); ?></strong></td>
      <?php } ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaloutpatients); ?></strong></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average OPs per day</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        
        $start = strtotime($start_month.'-1 day');
        $end = strtotime($end_month);
        $days_between = ceil(abs($end - $start) / 86400);

        $monthlyops = getTotalOutPatients($start_month, $end_month);
        $totalmonthlyops += $monthlyops;

        if($monthlyops != '0'){ $averageops = $monthlyops/$days_between; $totalaverageops += $averageops; } else { $averageops = 0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averageops); ?></td>
      <?php } if($totalaverageops != '0'){ $monthlyaverageop = $totalaverageops/$from_month; } else { $monthlyaverageop = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($monthlyaverageop); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Admissions</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $admissioncount = getAdmissions($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Available Beds Days</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

        $start = strtotime($start_month.'-1 day');
        $end = strtotime($end_month);
        $days_between = ceil(abs($end - $start) / 86400);

        $availablebeds = getAvailableBeds($days_between);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Occupied Beds Days</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $occupiedbeds = getOccupiedBeds($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Occupancy Ratio</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $occupancyratio = getOccupancyRatio($start_month, $end_month);
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($occupancyratio).'%'; ?></td>
      <?php } if($totaloccupiedbeds!='0' && $totalavailablebeds!='0'){ $totaloccupancyratio = ($totaloccupiedbeds/$totalavailablebeds)*100; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaloccupancyratio).'%'; ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Length of Stay (ALOS)</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

        $occupiedbeds = getOccupiedBeds($start_month, $end_month);
        $admissioncount = getAdmissions($start_month, $end_month);

        if($occupiedbeds != '0' && $admissioncount != '0'){ $alos = $occupiedbeds/$admissioncount; } else { $alos = 0; }
        
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($alos); ?></td>
      <?php } if($totaloccupiedbeds != '0' && $totaladmissioncount != '0'){ $totalalos = $totaloccupiedbeds/$totaladmissioncount; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalalos); ?></td>
    </tr>
    <tr>
      <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+2; ?>"></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Radiology Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $radiologywalkin = getRadiologyWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Radiology Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $radiologyoutpatient = getRadiologyOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Radiology Inpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $radiologyinpatient = getRadiologyInpatient($start_month, $end_month);
        $totalradiologyinpatient += $radiologyinpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($radiologyinpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalradiologyinpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total Radiology</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totalradiology = getTotalRadiology($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">X-Ray Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $xraywalkin = getXrayWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">X-Ray Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $xrayoutpatient = getXrayOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">X-Ray Inpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $xrayinpatient = getXrayInpatient($start_month, $end_month);
        $totalxrayinpatient += $xrayinpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($xrayinpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalxrayinpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total X-Ray</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totalxray = getTotalXray($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Ultrasound Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ultrasoundwalkin = getUltrasoundWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Ultrasound Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ultrasoundoutpatient = getUltrasoundOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Ultrasound Inpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ultrasoundinpatient = getUltrasoundInpatient($start_month, $end_month);
        $totalultrasoundinpatient += $ultrasoundinpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ultrasoundinpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalultrasoundinpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total Ultrasound</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totalultrasound = getTotalUltrasound($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">CT Scan Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ctscanwalkin = getCtScanWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">CT Scan Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ctscanoutpatient = getCtScanOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">CT Scan Inpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ctscaninpatient = getCtScanInpatient($start_month, $end_month);
        $totalctscaninpatient += $ctscaninpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($ctscaninpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalctscaninpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total CT Scan</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totalctscan = getTotalCtScan($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Laboratory Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $labwalkin = getLabWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Laboratory Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $laboutpatient = getLabOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Laboratory Inpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $labinpatient = getLabInpatient($start_month, $end_month);
        $totallabinpatient += $labinpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($labinpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totallabinpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total Laboratory</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totallab = getTotalLab($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">OP Prescriptions Walkin</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $pharmacywalkin = getPharmacyWalkin($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">OP Prescriptions Outpatient</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $pharmacyoutpatient = getPharmacyOutpatient($start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">IP Prescriptions</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $pharmacyinpatient = getPharmacyInpatient($start_month, $end_month);
        $totalpharmacyinpatient += $pharmacyinpatient;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($pharmacyinpatient); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalpharmacyinpatient); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Total Prescriptions</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $totalpharmacy = getTotalPharmacy($start_month, $end_month);
        $sumpharmacy += $totalpharmacy;          
      ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalpharmacy); ?></strong></td>
      <?php } ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($sumpharmacy); ?></strong></td>
    </tr>
    <tr>
      <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+2; ?>"></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Renal/Dialysis</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $dialysisadmissions = getWardAdmissions(2, $start_month, $end_month);
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Endoscopy</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $endoscopyadmissions = getWardAdmissions(3, $start_month, $end_month);
        $totalendoscopyadmissions += $endoscopyadmissions;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($endoscopyadmissions); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalendoscopyadmissions); ?></td>
    </tr>
    <tr>
      <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+2; ?>"></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Total Inpatient Income</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $inpatientincome = getTotalInpatientIncome($start_month, $end_month);
        $totalinpatientincome += $inpatientincome;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($inpatientincome); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalinpatientincome); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Income Per OBD</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $inpatientincome = getTotalInpatientIncome($start_month, $end_month);
        $occupiedbeds = getOccupiedBeds($start_month, $end_month);

        if($inpatientincome != '0' && $occupiedbeds != '0'){ $averageincomepobd = $inpatientincome/$occupiedbeds; } else { $averageincomepobd = 0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averageincomepobd); ?></td>
      <?php } if($totalinpatientincome != '0' && $totaloccupiedbeds != '0'){ $totalaverageincomepobd = $totalinpatientincome/$totaloccupiedbeds; } else { $totalaverageincomepobd = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalaverageincomepobd); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Income Per Admission</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $inpatientincome = getTotalInpatientIncome($start_month, $end_month);
        $admission = getAdmissions($start_month, $end_month);

        if($inpatientincome != '0' && $admission != '0'){ $averageincomeadmission = $inpatientincome/$admission; } else { $averageincomeadmission = 0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averageincomeadmission); ?></td>
      <?php } if($totalinpatientincome != '0' && $totaladmissioncount != '0'){ $totalaverageincomeadmission = $totalinpatientincome/$totaladmissioncount; } else { $totalaverageincomeadmission = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalaverageincomeadmission); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Out-Patient Income</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $outpatientincome = getTotalOutpatientIncome($start_month, $end_month);
        $totaloutpatientincome += $outpatientincome;
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($outpatientincome); ?></td>
      <?php } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaloutpatientincome); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Cost Per OPA</td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $outpatientincome = getTotalOutpatientIncome($start_month, $end_month);
        $outpatientcount = getTotalOutPatients($start_month, $end_month);

        if($outpatientincome != '0' && $outpatientcount != '0'){ $averageopa = $outpatientincome/$outpatientcount; } else { $averageopa = 0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averageopa); ?></td>
      <?php } if($totaloutpatientincome != '0' && $totaloutpatients != '0'){ $totalaverageopa = $totaloutpatientincome/$totaloutpatients; } else { $totalaverageopa = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totalaverageopa); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Combined Income IPOP</strong></td>
    <?php
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $outpatientincome1 = getTotalOutpatientIncome($start_month, $end_month);
        $inpatientincome1 = getTotalInpatientIncome($start_month, $end_month);
        $combinedincome = $outpatientincome1 + $inpatientincome1;
        $totalcombinedincome += $combinedincome;
      ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($combinedincome); ?></strong></td>
      <?php } ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalcombinedincome); ?></strong></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Daily OP Income</td>
    <?php
      $totaldays = 0;
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $opincome = getTotalOutpatientIncome($start_month, $end_month);

        $start = strtotime($start_month.'-1 day');
        $end = strtotime($end_month);
        $days_between = ceil(abs($end - $start) / 86400);
        $totaldays += $days_between;

        if($opincome != '0' && $days_between != '0'){ $averagedailyopincome = $opincome/$days_between; } else { $averagedailyopincome =0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averagedailyopincome); ?></td>
      <?php } if($totaldays != '0' && $totaloutpatientincome != '0'){ $totaldailyopincome = $totaloutpatientincome/$totaldays; } else { $totaldailyopincome = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldailyopincome); ?></td>
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
    <td <?php echo $colorcode; ?> class="bodytext31" align="left">Average Daily IP Income</td>
    <?php
      $totaldays = 0;
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $ipincome = getTotalInpatientIncome($start_month, $end_month);

        $start = strtotime($start_month.'-1 day');
        $end = strtotime($end_month);
        $days_between = ceil(abs($end - $start) / 86400);
        $totaldays += $days_between;

        if($ipincome != '0' && $days_between != '0'){ $averagedailyipincome = $ipincome/$days_between; } else { $averagedailyipincome =0; }
      ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($averagedailyipincome); ?></td>
      <?php } if($totaldays != '0' && $totalinpatientincome != '0'){ $totaldailyipincome = $totalinpatientincome/$totaldays; } else { $totaldailyipincome = 0; } ?>
      <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($totaldailyipincome); ?></td>
    </tr>
    <tr>
    <td bgcolor="#ecf0f5" class="bodytext31" align="left"><strong>Average Daily Gross Income</strong></td>
    <?php
      $totaldays = 0;
      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      for($i = 0; $i < $from_month; $i++){
        $month = $months[$i];
        $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
        $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));
        $outpatientincome1 = getTotalOutpatientIncome($start_month, $end_month);
        $inpatientincome1 = getTotalInpatientIncome($start_month, $end_month);
        $combinedincome = $outpatientincome1 + $inpatientincome1;

        $start = strtotime($start_month.'-1 day');
        $end = strtotime($end_month);
        $days_between = ceil(abs($end - $start) / 86400);
        $totaldays += $days_between;

        if($combinedincome != '0' && $days_between != '0'){ $dailygrossincome = $combinedincome/$days_between; } else { $dailygrossincome = 0; }
      ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($dailygrossincome); ?></strong></td>
      <?php } if($totaldays != '0' && $combinedincome != '0'){ $totaldailygrossincome = $combinedincome/$totaldays; } else { $totaldailygrossincome = 0; } ?>
      <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaldailygrossincome); ?></strong></td>
    </tr>


  </tbody>  
</table>