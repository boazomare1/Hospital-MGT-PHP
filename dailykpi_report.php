<?php
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


if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddateto = $ADate1; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily KPI Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 
<?php 

function getExpenseAmt($ADate1, $ADate2)
{
	    $opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='6')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);

			
			$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$ADate1."' and '".$ADate2."' group by transaction_type ";
			$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
			while($res_transaction = mysqli_fetch_array($exec_transaction)){
				if($res_transaction['transaction_type']=="D"){
					$transaction_dr += $res_transaction['transaction_amount'];
				}else{
					$transaction_cr += $res_transaction['transaction_amount'];
				}
			}

			return $transaction_dr;
}

function getOpFootfall($ADate1, $ADate2){
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

  $query5 = "select count(count) as count, misreport from (

    select count, a.misreport FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname ) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_paynow.visitcode,billing_paynow.billdate
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


function getProjection($amount, $ADate1){
  $date = explode('-', $ADate1);
  $day = $date[2]; 
  $month = $date[1];
  $year = $date[0];

  $monthdays = cal_days_in_month(CAL_GREGORIAN,$month,$year);

  $projection = ($amount/$day)*$monthdays;
  return $projection;
}

function getDaysInMonth($ADate1){
  $date = explode('-', $ADate1);
  $day = $date[2]; 
  $month = $date[1];
  $year = $date[0];

  $monthdays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
  return $monthdays;
}

function getMtdDays($ADate1){
  $ADate2 = date('Y-m-01', strtotime($ADate1));

  $start = strtotime($ADate2.'-1 day');
  $end = strtotime($ADate1);

  $days_between = ceil(abs($end - $start) / 86400);
  return $days_between;
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

function getMidnightOccupancy($ADate2){
  $ADate1 = date('Y-m-01', strtotime($ADate2));
  $startdate = strtotime($ADate1);
  $enddate = strtotime($ADate2);
  $totalpatientdays = 0;

  while($startdate <= $enddate){

      $from_date = date("Y-m-d",$startdate);

      $query31 = "SELECT sum(count) as count from (
        select count(visitcode) as count from ip_bedallocation where  recorddate <= '$from_date'   and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
        ) as amt1";

      // $query31 = "select sum(count) as count from (
      //   select count(visitcode) as count from ip_bedallocation where  recorddate <= '$from_date' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
      //   UNION ALL 
      //   select count(visitcode) as count from ip_bedtransfer where  recorddate <= '$from_date' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date') and recordstatus <> 'transfered'
      //   ) as amt1";
      $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res31 = mysqli_fetch_array($exec31);
      $patientcount = $res31['count'];
      $totalpatientdays += $patientcount;

    $startdate = strtotime('+1 day',strtotime(date("Y-m-d",$startdate)));
  } 

  return $totalpatientdays; 
}


function getTotalBedDays($days){
  $queryipcreditdisc = "select * from master_bed where  recordstatus <> 'deleted'";
  $execipcreditdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcreditdisc) or die("Error in queryipcreditdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcreditdisc = mysqli_fetch_array($execipcreditdisc);
  $numrows = mysqli_num_rows($execipcreditdisc);
  
  $beddays = $numrows * $days;
  return $beddays;
}

function totalopd($miscode, $ADate1, $ADate2){
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
      SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') and billing_consultation.accountname = 'CASH - HOSPITAL'
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
      ) as amount1";
    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res48 = mysqli_fetch_array($exec48)){
      return $res48['amount'];    
    }
}


function totalipd($miscode, $ADate1, $ADate2){
      $query98 = "select sum(amount) as amount from (
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (select visitcode as visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipservices.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
    $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die("Error in query98" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res98 = mysqli_fetch_array($exec98)){
      return $res98['amount'];    
    }
}

function getOPRefund($ADate1, $ADate2){
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

function getOPCashRefund($ADate1, $ADate2){
  $query48 = "select sum(-1*amount) as totalrefund from (
  select sum(consultation) as amount from refund_consultation where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(amount)as amount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(labitemrate)as amount from refund_paynowlab where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(radiologyitemrate)as amount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(servicetotal)as amount from refund_paynowservices where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(referalrate) as amount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' ) as refund1";
  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
  $res48 = mysqli_fetch_array($exec48);
  return $res48['totalrefund'];    
}

function getOPCreditRefund($ADate1, $ADate2){
  $query48 = "select sum(-1*amount) as totalrefund from (
  select sum(fxamount) as amount from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'  
  UNION ALL select sum(amount)as amount from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' 
  UNION ALL SELECT SUM(`amount`) as amount FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)  
  UNION ALL select sum(labitemrate)as amount from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(fxamount)as amount from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(fxamount)as amount from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' 
  UNION ALL select sum(referalrate) as amount from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' 
   ) as refund1";
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

function getOPCashDiscount($ADate1, $ADate2){
  $queryipcashdisc = "select sum(-1*amount) as amount from (
  select sum(consultationamount) as amount from billing_patientweivers where accountnameano = '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(pharmacyamount) as amount from billing_patientweivers where accountnameano = '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(labamount) as amount from billing_patientweivers where accountnameano = '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(radiologyamount) as amount from billing_patientweivers where accountnameano = '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(servicesamount) as amount from billing_patientweivers where accountnameano = '47' and entrydate between '$ADate1' and '$ADate2'
  ) as amount1";
  $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcashdisc = mysqli_fetch_array($execipdisc);
  $ipcashdisc = $resipcashdisc['amount'];
  return $ipcashdisc; 
}

function getOPCreditDiscount($ADate1, $ADate2){
  $queryipcashdisc = "select sum(-1*amount) as amount from (
  select sum(consultationamount) as amount from billing_patientweivers where accountnameano != '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(pharmacyamount) as amount from billing_patientweivers where accountnameano != '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(labamount) as amount from billing_patientweivers where accountnameano != '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(radiologyamount) as amount from billing_patientweivers where accountnameano != '47' and entrydate between '$ADate1' and '$ADate2'
  UNION ALL select sum(servicesamount) as amount from billing_patientweivers where accountnameano != '47' and entrydate between '$ADate1' and '$ADate2'
  ) as amount1";
  $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcashdisc = mysqli_fetch_array($execipdisc);
  $ipcashdisc = $resipcashdisc['amount'];
  return $ipcashdisc; 
}

function getIPDiscount($ADate1, $ADate2){
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

function getIPCashDiscount($ADate1, $ADate2){
  $totaldiscount = 0;
  $queryx = "select patientcode,visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' UNION ALL select patientcode,visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode";
  $execx = mysqli_query($GLOBALS["___mysqli_ston"], $queryx);
  while($resx = mysqli_fetch_array($execx)){
    $patientcode = $resx['patientcode'];
    $visitcode = $resx['visitcode'];

    $queryipcashdisc = "select sum(-1*rate) as totaldiscount from ip_discount where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and consultationdate between '$ADate1' and '$ADate2' and billtype = 'PAY NOW'";
    $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
    $resipcashdisc = mysqli_fetch_array($execipdisc);
    $ipcashdisc = $resipcashdisc['totaldiscount'];
    $totaldiscount += $ipcashdisc;
  }
  
  return $totaldiscount;
}

function getIPCreditDiscount($ADate1, $ADate2){
  $totaldiscount = 0;
  $queryx = "select patientcode,visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' UNION ALL select patientcode,visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode";
  $execx = mysqli_query($GLOBALS["___mysqli_ston"], $queryx);
  while($resx = mysqli_fetch_array($execx)){
    $patientcode = $resx['patientcode'];
    $visitcode = $resx['visitcode'];

    $queryipcashdisc = "select sum(-1*rate) as totaldiscount from ip_discount where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and consultationdate between '$ADate1' and '$ADate2' and billtype = 'PAY LATER'";
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

function getCashRebate($ADate1, $ADate2){
  $queryrebate = "SELECT sum(-1*amount) as totalrebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountcode = '02-4500-1'";
  $execrebate = mysqli_query($GLOBALS["___mysqli_ston"], $queryrebate) or die("Error in queryrebate".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resrebate = mysqli_fetch_array($execrebate);
  $rebate = $resrebate['totalrebate'];
  
  return $rebate; 
}

function getCreditRebate($ADate1, $ADate2){
  $queryrebate = "SELECT sum(-1*amount) as totalrebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountcode != '02-4500-1'";
  $execrebate = mysqli_query($GLOBALS["___mysqli_ston"], $queryrebate) or die("Error in queryrebate".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resrebate = mysqli_fetch_array($execrebate);
  $rebate = $resrebate['totalrebate'];
  
  return $rebate; 
}

function getTotalOP($ADate1, $ADate2){
  $totaloprevenue = $totalopdiscount = $totaloprefund = 0;

  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $code = $res1['auto_number']; 
    $opdamount = totalopd($code, $ADate1, $ADate2);
    $totaloprevenue += $opdamount;
  }

  $totalopdiscount = getOPDiscount($ADate1, $ADate2);
  $totaloprefund = getOPRefund($ADate1, $ADate2);

  return $totaloprevenue + $totalopdiscount + $totaloprefund;
}

function getTotalIP($ADate1, $ADate2){
  $totaliprevenue = $totalipdiscount = $totalrebate = 0;

  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $code = $res1['auto_number']; 
    $ipdamount = totalipd($code, $ADate1, $ADate2);
    $totaliprevenue += $ipdamount;
  }

  $totalipdiscount = getIPDiscount($ADate1, $ADate2);
  $totalrebate = getRebate($ADate1, $ADate2);

  return $totaliprevenue + $totalipdiscount + $totalrebate;
}

function getTotalCashRevenue($miscode, $ADate1, $ADate2){
  $query1 = "select sum(amount) as amount from (
    select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname  where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')  
      UNION ALL
      select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') and billing_consultation.accountname = 'CASH - HOSPITAL'
      UNION ALL
      select sum(billing_paynowpharmacy.fxamount) as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where A.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2') and billing_paynowpharmacy.locationcode = 'LTC-1'
      UNION ALL
      select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
      UNION ALL
      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipservices.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      select sum(billing_iplab.labitemrate) as amount, A.misreport FROM `billing_iplab` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_iplab.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname where A.misreport = '$miscode' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipbedcharges.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      SELECT sum(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47' group by billing_ipprivatedoctor.visitcode
	   UNION ALL
      SELECT -1*sum(billing_ipprivatedoctor.sharingamount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47' group by billing_ipprivatedoctor.visitcode
      UNION ALL
      SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
      UNION ALL
      select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number = '47'
  ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $cashrevenue = $res1['amount'];

  return $cashrevenue;

}

function getTotalCreditRevenue($miscode, $ADate1, $ADate2){
  $query1 = "select sum(amount) as amount from (
    SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_paylaterconsultation.totalamount) as amount, A.misreport FROM `billing_paylaterconsultation` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_paylaterpharmacy.amount) as amount, A.misreport FROM `billing_paylaterpharmacy` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterpharmacy.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_paylaterlab.labitemrate) as amount, A.misreport FROM `billing_paylaterlab` JOIN  billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT master_accountname.id, master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipservices.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      select sum(billing_iplab.labitemrate) as amount, A.misreport FROM `billing_iplab` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_iplab.patientvisitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname where A.misreport = '$miscode' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipbedcharges.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      SELECT sum(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47' group by billing_ipprivatedoctor.visitcode
	  UNION ALL
      SELECT -1*sum(billing_ipprivatedoctor.sharingamount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select  visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL select  visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode) as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47' group by billing_ipprivatedoctor.visitcode
      UNION ALL
      SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
      UNION ALL
      select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT master_accountname.accountname, master_accountname.auto_number, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2') and A.auto_number != '47'
  ) as amt1";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res1 = mysqli_fetch_array($exec1);
  $cashrevenue = $res1['amount'];

  return $cashrevenue;

}

function getTotalCashRevenue1($ADate1, $ADate2){
  $totalcashrevenue = 0;
  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $code = $res1['auto_number']; 
    $ipdamount = getTotalCashRevenue($code, $ADate1, $ADate2);
    $totalcashrevenue += $ipdamount;
  }

  $ipcashdiscount = getIPCashDiscount($ADate1, $ADate2);
  $ipcashrebate = getCashRebate($ADate1, $ADate2);
  $opcashdiscount = getOPCashDiscount($ADate1, $ADate2);
  $opcashrefund = getOPCashRefund($ADate1, $ADate2);

  return $totalcashrevenue + $ipcashdiscount + $ipcashrebate + $opcashdiscount + $opcashrefund;
}

function getTotalCreditRevenue1($ADate1, $ADate2){
  $totalcreditrevenue = 0;
  $query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $code = $res1['auto_number']; 
    $ipdamount = getTotalCreditRevenue($code, $ADate1, $ADate2);
    $totalcreditrevenue += $ipdamount;
  }

  $ipcreditdiscount = getIPCreditDiscount($ADate1, $ADate2);
  $ipcreditrebate = getCreditRebate($ADate1, $ADate2);
  $opcreditdiscount = getOPCreditDiscount($ADate1, $ADate2);
  $opcreditrefund = getOPCreditRefund($ADate1, $ADate2);

  return $totalcreditrevenue + $ipcreditdiscount + $ipcreditrebate + $opcreditdiscount + $opcreditrefund;
}

function getCostOfSales($ADate1, $ADate2){

  $selfconsumption = $costofsales = 0;

  $query1 = "select * from master_store";
  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($res1 = mysqli_fetch_array($exec1)){
    $storecode = $res1['storecode'];  

  $query2 = "SELECT a.docno as docno, a.fromstore as storecode, a.itemcode as itemcode, a.itemname as itemname, a.categoryname as categoryname, sum(amount) as consumption, a.entrydate as entrydate from master_stock_transfer as a where a.entrydate between '$ADate1' and '$ADate2' and a.fromstore = '$storecode' and a.typetransfer = 'Consumable' group by a.fromstore";
  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res2 = mysqli_fetch_array($exec2);
  $selfconsumption += $res2['consumption'];

  $query3 = "SELECT (IF(a.ipdocno = '', a.docnumber, a.ipdocno)) as docno, a.patientcode as patientcode, a.patientname as patientname, a.visitcode as visitcode, a.store as storecode, a.itemcode as itemcode, a.itemname as itemname, a.categoryname as categoryname, sum(a.totalcp) as costprice, sum(a.totalamount) as saleprice, a.entrydate as entrydate from pharmacysales_details as a where a.entrydate between '$ADate1' and '$ADate2' and a.store = '$storecode' group by a.store";
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res3 = mysqli_fetch_array($exec3);
  $costofsales += $res3['costprice'];

  $query4 = "SELECT a.docnumber as docno, a.store as storecode, a.itemcode as itemcode, a.itemname as itemname, a.patientcode as patientcode,  a.visitcode as visitcode, a.categoryname as categoryname, sum(-1*a.totalcp) as costprice, sum(-1*a.totalamount) as saleprice, a.entrydate as entrydate from pharmacysalesreturn_details as a where a.entrydate between '$ADate1' and '$ADate2' and a.store = '$storecode' group by a.store";
  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res4 = mysqli_fetch_array($exec4);
  $costofsales += $res4['costprice'];
  }

  return $selfconsumption + $costofsales;
}

?>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>

</head>

</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Daily KPI Report</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newdashboard.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>New Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="dailykpi_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Daily KPI Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daytodayflash.php" class="nav-link">
                            <i class="fas fa-bolt"></i>
                            <span>Day to Day Flash</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentsalesreport.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentstatistics.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Department Statistics</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Daily KPI Report</h2>
                    <p>Comprehensive daily key performance indicators and analytics dashboard for hospital operations.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Filter Form Section -->
            <div class="filter-form-section">
                <div class="filter-form-header">
                    <i class="fas fa-filter filter-form-icon"></i>
                    <h3 class="filter-form-title">KPI Report Filters</h3>
                </div>
                
                <form id="kpiReportForm" name="cbform1" method="post" action="dailykpi_report.php" class="filter-form">
                    <div class="form-group">
                        <label for="locationcode" class="form-label">Location</label>
                        <select name="locationcode" id="locationcode" class="form-input">
                            <?php
                            $query20 = "select * FROM master_location";
                            $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res20 = mysqli_fetch_array($exec20)){
                                $selected = ($locationcode1 == $res20['locationcode']) ? 'selected' : '';
                                echo "<option value='".$res20['locationcode']."' $selected>" .htmlspecialchars($res20['locationname']). "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ADate1" class="form-label">Report Date</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo $paymentreceiveddateto; ?>" 
                                   readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <button type="button" class="date-picker-btn" onClick="javascript:NewCssCal('ADate1')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" name="Submit" class="submit-btn">
                            <i class="fas fa-chart-bar"></i>
                            Generate KPI Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
            <?php if(isset($_POST['Submit'])){ ?>
                <!-- Export Actions -->
                <div class="export-actions">
                    <a target="_blank" href="xl_dailykpireport.php?ADate1=<?php echo $ADate1; ?>" class="btn btn-outline">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="500" align="left" border="1">
          <tbody>
            <?php
            $thousand = 1000;
            $prevopcount = $mtdopcount = $projectionopcount = 0;
            $prevavgopcount = $mtdavgopcount = $projectionavgopcount = 0;
            $prevadmissions = $mtdadmissions = $projectionadmissions = 0;
            $prevavgadmissions = $mtdavgadmissions = $projectionavgadmissions = 0;
            $prevoccupiedbeds = $mtdoccupiedbeds = $projectionoccupiedbeds = 0;
            $prevoccupancyperc = $mtdoccupancyperc = $projectionoccupancyperc = 0;
            $prevbeddays = $mtdbeddays = $projectionbeddays = 0;
            $prevtotalop = $mtdtotalop = $projectiontotalop = 0;
            $prevtotalip = $mtdtotalip = $projectiontotalip = 0;
            $prevtotalincome = $mtdtotalincome = $projectiontotalincome = 0;
            $prevaveragerevenue = $mtdaveragerevenue = $projectionaveragerevenue = 0;
            $prevcashrevenue = $mtdcashrevenue = $projectioncashrevenue = 0;
            $prevcreditrevenue = $mtdcreditrevenue = $projectioncreditrevenue = 0;
            $prevtotalincome2 = $mtdtotalincome2 = $projectiontotalincome2 = 0;
            $prevcashperc = $mtdcashperc = $projectioncashperc = 0;
            $prevcreditperc = $mtdcreditperc = $projectioncreditperc = 0;
            $prevcostofsales = $mtdcostofsales = $projectioncostofsales = 0;
            $prevgrossprofit = $mtdgrossprofit = $projectiongrossprofit = 0;
            $prevgrossprofitperc = $mtdgrossprofitperc = $projectiongrossprofitperc = 0;
            $prevoperatingexpense = $mtdoperatingexpense = $projectionoperatingexpense = 0;
            $prevebitda = $mtdebitda = $projectionebitda = 0;
            $prevebitdaperc = $mtdebitdaperc = $projectionebitdaperc = 0;
            $prevavgexpenses = $mtdavgexpenses = $projectionavgexpenses = 0;
            $prevsurplus = $mtdsurplus = $projectionsurplus = 0;
            ?>
            <tr>
              <td align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31" colspan="4"><strong>DAILY KPI SNAPSHOT</strong></td>
            </tr>
            <?php
            //PREV MONTH
            $ADate2 = date('Y-m-01', strtotime($ADate1.'-1 months'));
            $ADate11 = date('Y-m-d', strtotime('last day of '.$ADate2));
            $prevopcount = getOpFootfall($ADate2, $ADate11);
            $days = getDaysInMonth($ADate2);
            $prevavgopcount = ($prevopcount/$days);
            $prevadmissions = getAdmissions($ADate2, $ADate11);
            $prevavgadmissions = ($prevadmissions/$days);
            $prevoccupiedbeds = getMidnightOccupancy($ADate11);
            $prevbeddays = getTotalBedDays($days);
            if($prevoccupiedbeds != '0' && $prevbeddays != '0'){ $prevoccupancyperc = ($prevoccupiedbeds/$prevbeddays)*100; }
            $prevtotalop = getTotalOP($ADate2, $ADate11);
            $prevtotalop = $prevtotalop/$thousand;
            $prevtotalip = getTotalIP($ADate2, $ADate11);
            $prevtotalip = $prevtotalip/$thousand;
            $prevtotalincome = $prevtotalop + $prevtotalip;
            $prevaveragerevenue = $prevtotalincome/$days;
            $prevcashrevenue = getTotalCashRevenue1($ADate2, $ADate11);
            $prevcashrevenue = $prevcashrevenue/$thousand;
            $prevcreditrevenue = getTotalCreditRevenue1($ADate2, $ADate11);
            $prevcreditrevenue = $prevcreditrevenue/$thousand;
            $prevtotalincome2 = $prevcashrevenue + $prevcreditrevenue;
            if($prevcashrevenue != '0' && $prevtotalincome2 != '0'){ $prevcashperc = ($prevcashrevenue/$prevtotalincome2)*100; }
            if($prevcreditrevenue != '0' && $prevtotalincome2 != '0'){ $prevcreditperc = ($prevcreditrevenue/$prevtotalincome2)*100; }
            $prevcostofsales = getCostOfSales($ADate2, $ADate11);
            $prevcostofsales = $prevcostofsales/$thousand;
            $prevgrossprofit = $prevtotalincome2 - $prevcostofsales;
            if($prevgrossprofit != '0' && $prevtotalincome2 != '0'){ $prevgrossprofitperc = ($prevgrossprofit/$prevtotalincome2)*100; }

			$prevoperatingexpense=getExpenseAmt($ADate2, $ADate11);
			$prevoperatingexpense = $prevoperatingexpense/$thousand;

            $prevebitda = $prevgrossprofit - $prevoperatingexpense;
            if($prevebitda != '0' && $prevtotalincome2 != '0'){ $prevebitdaperc = ($prevebitda/$prevtotalincome2)*100; }
            $prevavgexpenses = ($prevcostofsales + $prevoperatingexpense)/$days;
            $prevsurplus = $prevaveragerevenue - $prevavgexpenses;

            //MTD
            $ADate2 = date('Y-m-01', strtotime($ADate1));
            $mtdopcount = getOpFootfall($ADate2, $ADate1);
            $days = getMtdDays($ADate1);
            $mtdavgopcount = ($mtdopcount/$days);
            $mtdadmissions = getAdmissions($ADate2, $ADate1);
            $mtdavgadmissions = ($mtdadmissions/$days);
            $mtdoccupiedbeds = getMidnightOccupancy($ADate1);
            $mtdbeddays = getTotalBedDays($days);
            if($mtdoccupiedbeds != '0' && $mtdbeddays != '0'){ $mtdoccupancyperc = ($mtdoccupiedbeds/$mtdbeddays)*100; }
            $mtdtotalop = getTotalOP($ADate2, $ADate1);
            $mtdtotalop = $mtdtotalop/$thousand;
            $mtdtotalip = getTotalIP($ADate2, $ADate1);
            $mtdtotalip = $mtdtotalip/$thousand;
            $mtdtotalincome = $mtdtotalop + $mtdtotalip;
            $mtdaveragerevenue = $mtdtotalincome/$days;
            $mtdcashrevenue = getTotalCashRevenue1($ADate2, $ADate1);
            $mtdcashrevenue = $mtdcashrevenue/$thousand;
            $mtdcreditrevenue = getTotalCreditRevenue1($ADate2, $ADate1);
            $mtdcreditrevenue = $mtdcreditrevenue/$thousand;
            $mtdtotalincome2 = $mtdcashrevenue + $mtdcreditrevenue;
            if($mtdcashrevenue != '0' && $mtdtotalincome2 != '0'){ $mtdcashperc = ($mtdcashrevenue/$mtdtotalincome2)*100; }
            if($mtdcreditrevenue != '0' && $mtdtotalincome2 != '0'){ $mtdcreditperc = ($mtdcreditrevenue/$mtdtotalincome2)*100; }
            $mtdcostofsales = getCostOfSales($ADate2, $ADate1);
            $mtdcostofsales = $mtdcostofsales/$thousand;
            $mtdgrossprofit = $mtdtotalincome2 - $mtdcostofsales;
            if($mtdgrossprofit != '0' && $mtdtotalincome2 != '0'){ $mtdgrossprofitperc = ($mtdgrossprofit/$mtdtotalincome2)*100; }

			$mtdoperatingexpense=getExpenseAmt($ADate2, $ADate1);
			$mtdoperatingexpense = $mtdoperatingexpense/$thousand;

            $mtdebitda = $mtdgrossprofit - $mtdoperatingexpense;
            if($mtdebitda != '0' && $mtdtotalincome2 != '0'){ $mtdebitdaperc = ($mtdebitda/$mtdtotalincome2)*100; }
            $mtdavgexpenses = ($mtdcostofsales + $mtdoperatingexpense)/$days;
            $mtdsurplus = $mtdaveragerevenue - $mtdavgexpenses;

            //PROJECTION
            $projectionopcount = getProjection($mtdopcount, $ADate1);
            $days = getDaysInMonth($ADate1);
            $projectionavgopcount = ($projectionopcount/$days);
            $projectionadmissions = getProjection($mtdadmissions, $ADate1);
            $projectionavgadmissions = ($projectionadmissions/$days);
            $projectionoccupiedbeds = getProjection($mtdoccupiedbeds, $ADate1);
            $projectionbeddays = getTotalBedDays($days);
            if($projectionoccupiedbeds != '0' && $projectionbeddays != '0'){ $projectionoccupancyperc = ($projectionoccupiedbeds/$projectionbeddays)*100; }
            $projectiontotalop = getProjection($mtdtotalop, $ADate1);
            $projectiontotalop = $projectiontotalop;
            $projectiontotalip = getProjection($mtdtotalip, $ADate1);
            $projectiontotalip = $projectiontotalip;
            $projectiontotalincome = $projectiontotalop + $projectiontotalip;
            $projectionaveragerevenue = $projectiontotalincome/$days;
            $projectioncashrevenue = getProjection($mtdcashrevenue, $ADate1);
            $projectioncreditrevenue = getProjection($mtdcreditrevenue, $ADate1);
            $projectiontotalincome2 = $projectioncashrevenue + $projectioncreditrevenue;
            if($projectioncashrevenue != '0' && $projectiontotalincome2 != '0'){ $projectioncashperc = ($projectioncashrevenue/$projectiontotalincome2)*100; }
            if($projectioncreditrevenue != '0' && $projectiontotalincome2 != '0'){ $projectioncreditperc = ($projectioncreditrevenue/$projectiontotalincome2)*100; }
            $projectioncostofsales = getProjection($mtdcostofsales, $ADate1);
            $projectiongrossprofit = $projectiontotalincome2 - $projectioncostofsales;
            if($projectiongrossprofit != '0' && $projectiontotalincome2 != '0'){ $projectiongrossprofitperc = ($projectiongrossprofit/$projectiontotalincome2)*100; }

			$projectionoperatingexpense = getProjection($mtdoperatingexpense, $ADate1);

            $projectionebitda = $projectiongrossprofit - $projectionoperatingexpense;
            if($projectionebitda != '0' && $projectiontotalincome2 != '0'){ $projectionebitdaperc = ($projectionebitda/$projectiontotalincome2)*100; }
            $projectionavgexpenses = ($projectioncostofsales + $projectionoperatingexpense)/$days;
            $projectionsurplus = $projectionaveragerevenue - $projectionavgexpenses;

            ?>
            <tr>
              <td width="25%" align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Details</strong></td>
              <td width="15%" align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Previous Month - <?php echo strtoupper(date('M', strtotime($ADate1.'-1 months')))." ".date('Y', strtotime($ADate1)); ?></strong></td>
              <td width="15%" align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>MTD - <?php echo strtoupper(date('M', strtotime($ADate1)))." ".date('Y', strtotime($ADate1)); ?></strong></td>
              <td width="15%" align="center" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Month Projection - <?php echo strtoupper(date('M', strtotime($ADate1)))." ".date('Y', strtotime($ADate1)); ?></strong></td>
            </tr>
            <tr>
              <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="4"><strong>KPI's</strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">OPA's - Cumulative</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevopcount); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdopcount); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionopcount); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Average OPAs Per Day</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevavgopcount); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdavgopcount); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionavgopcount); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Admissions - Cumulative</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevadmissions); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdadmissions); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionadmissions); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Average Admissions Per Day</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevavgadmissions); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdavgadmissions); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionavgadmissions); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Occupied Beds</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevoccupiedbeds); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdoccupiedbeds); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionoccupiedbeds); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Occupancy Rate</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevoccupancyperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdoccupancyperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionoccupancyperc).'%'; ?></td>
            </tr>
            <tr>
              <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Income Statement</strong></td>
              <td align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>000'</strong></td>
              <td align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>000'</strong></td>
              <td align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>000'</strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">OP Income</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevtotalop); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdtotalop); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectiontotalop); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">IP Income</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevtotalip); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdtotalip); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectiontotalip); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>Total Income</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevtotalincome); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdtotalincome); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectiontotalincome); ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Cost of Sales</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevcostofsales); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdcostofsales); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectioncostofsales); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>Gross Profit</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevgrossprofit); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdgrossprofit); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectiongrossprofit); ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>% Gross Profit</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevgrossprofitperc).'%'; ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdgrossprofitperc).'%'; ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectiongrossprofitperc).'%'; ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Operating Expenses</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevoperatingexpense); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdoperatingexpense); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionoperatingexpense); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>EBITDA</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevebitda); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdebitda); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectionebitda); ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>% EBITDA</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevebitdaperc).'%'; ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdebitdaperc).'%'; ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectionebitdaperc).'%'; ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Average Daily Income</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevaveragerevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdaveragerevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionaveragerevenue); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Average Daily Expenses</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevavgexpenses); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdavgexpenses); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionavgexpenses); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Average Daily Surplus/Deficit</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevsurplus); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdsurplus); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectionsurplus); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Cash Income (Cash, Card & Mpesa)</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevcashrevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdcashrevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectioncashrevenue); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">Credit Income (Insurance & Corporate)</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevcreditrevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdcreditrevenue); ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectioncreditrevenue); ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>Total Income</strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($prevtotalincome2); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($mtdtotalincome2); ?></strong></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong><?php echo number_format($projectiontotalincome2); ?></strong></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">% Cash Income</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevcashperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdcashperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectioncashperc).'%'; ?></td>
            </tr>
            <?php
              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              
              if ($showcolor == 0)
              {
                $colorcode = 'bgcolor="#CBDBFA"';
              }
              else
              {
                $colorcode = 'bgcolor="#ecf0f5"';
              } 
            ?>
            <tr>
              <td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">% Credit Income</td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($prevcreditperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($mtdcreditperc).'%'; ?></td>
              <td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php echo number_format($projectioncreditperc).'%'; ?></td>
            </tr>
          <?php } ?>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/dailykpi-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
