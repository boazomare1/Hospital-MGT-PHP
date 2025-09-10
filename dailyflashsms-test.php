<?php
include ("db/db_connect.php");
$today=date('Y-m-d');
// $today='2019-07-31';
$currentdates =strtotime("$today -1 day");
$enddate =date('Y-m-d',$currentdates);
$startdate =date('Y-m-01',$currentdates);

$nettotal = 0;
$fulltotalopvisit = 0;
$fulltotaladmissioncount = 0;
$fulltotaldischargecount = 0;
$occupancy = 0;

if(isset($_REQUEST['date'])){$date = $_REQUEST['date'];} else {$date = $enddate;}

$day_fromdate = $enddate;
$day_todate = $enddate;
$mtd_fromdate = $startdate;
$mtd_todate = $enddate;

function totalipd($miscode, $ADate1, $ADate2){
      $query98 = "select sum(amount) as amount from (
      
      SELECT -1*sum(billing_ipprivatedoctor.sharingamount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (select distinct(visitcode) as visitcode, accountnameano from billing_ip where billdate between '$ADate1' and '$ADate2' UNION ALL select distinct(visitcode) as visitcode, accountnameano from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2') as b ON billing_ipprivatedoctor.visitcode = b.visitcode JOIN master_accountname as A ON A.auto_number = b.accountnameano where  (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipprivatedoctor.visitcode

      ) as amount1";
    $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die("Error in query98" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res98 = mysqli_fetch_array($exec98)){
      return $res98['amount'];    
    }
}

function totalopd($miscode, $ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
      select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname  where   (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where   (billing_paynowservices.billdate between '$ADate1' and '$ADate2')  
      UNION ALL
      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where  (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_paylaterconsultation.totalamount) as amount, A.misreport FROM `billing_paylaterconsultation` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowpharmacy.fxamount) as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2') and billing_paynowpharmacy.locationcode = 'LTC-1'
      UNION ALL
      SELECT sum(billing_paylaterpharmacy.amount) as amount, A.misreport FROM `billing_paylaterpharmacy` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterpharmacy.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where  (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
      UNION ALL
      SELECT sum(billing_paylaterlab.labitemrate) as amount, A.misreport FROM `billing_paylaterlab` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where  (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_paylaterreferal.referalrate) as amount, master_accountname.misreport from billing_paylaterreferal JOIN master_accountname ON billing_paylaterreferal.accountname = master_accountname.accountname where  (billing_paylaterreferal.billdate between '$ADate1' and '$ADate2')
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

function getDeposit($ADate1, $ADate2){
  $query150 = "select sum(-1*abs(a.deposit)) as amount FROM billing_ipcreditapproved as a JOIN master_ipvisitentry as b ON a.visitcode = b.visitcode WHERE b.accountname != '427' and a.billdate between '$ADate1' and '$ADate2'";
  $exec150 = mysqli_query($GLOBALS["___mysqli_ston"], $query150) or die ("Error in Query150".mysqli_error($GLOBALS["___mysqli_ston"]));
  $num150=mysqli_num_rows($exec150);
  $res150 = mysqli_fetch_array($exec150);
  $ipdepositamount=$res150['amount'];

  return $ipdepositamount; 
}

function getadmissions($ADate1){
//   $queryipcreditdisc = "select sum(count) as count from (
//       select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate = '$ADate1'
//     UNION ALL
//     select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate = '$ADate1'
//     UNION ALL
//     select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge')
//     UNION ALL
//     select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge')
//     UNION ALL 
//     select count(visitcode) as count from ip_bedallocation where recordstatus = 'transfered' and recorddate = '$ADate1'
//     UNION ALL
//     select count(visitcode) from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')
//       UNION ALL
//     select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')
//     UNION ALL
//     select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')
// ) as count1";

  $queryipcreditdisc = "SELECT count(*) as count from ip_bedallocation where recorddate = '$ADate1' and ward NOT IN ('1','2','3','8','17')";
  $execipcreditdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcreditdisc) or die("Error in queryipcreditdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcreditdisc = mysqli_fetch_array($execipcreditdisc);
  $ipcreditdisc = $resipcreditdisc['count'];

  return $ipcreditdisc; 
}

function getMidnightOccupancy($ADate2){
  $query150 = "select sum(count) as amount from (
    select count(visitcode) as count from ip_bedallocation where ward NOT IN ('1','2','3','8','17') and recorddate <= '$ADate2' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2')
         ) as amt1";

  // $query150 = "select sum(count) as amount from (
  //   select count(visitcode) as count from ip_bedallocation where ward NOT IN ('1','2','3','8','17') and recorddate <= '$ADate2' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2')
  //   UNION ALL 
  //   select count(visitcode) as count from ip_bedtransfer where ward NOT IN ('1','2','3','8','17') and recorddate <= '$ADate2' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate2') and recordstatus <> 'transfered'
  //   ) as amt1";
  $exec150 = mysqli_query($GLOBALS["___mysqli_ston"], $query150) or die ("Error in Query150".mysqli_error($GLOBALS["___mysqli_ston"]));
  $num150=mysqli_num_rows($exec150);
  $res150 = mysqli_fetch_array($exec150);
  $occupancy=$res150['amount'];

  return $occupancy; 
}

function getDays($ADate1, $ADate2){
  $startTimeStamp = strtotime($ADate1);
  $endTimeStamp = strtotime($ADate2 . '+1 day');

  $timeDiff = abs($endTimeStamp - $startTimeStamp);

  $numberDays = $timeDiff/86400; 

  return $numberDays;
}



function getData($ADate1, $ADate2){

$fulltotalip = 0;
$fulltotalopd = 0;
$fulltotalgrandtotal = 0;
$fulltotalopvisit = 0;
$fulltotaldischargecount = 0;
$fulltotaladmissioncount = 0;
$totalarpopd = 0;
$totalarperip = 0;
$totalipdrefund = 0;
$totalopd = $totalip = 0;

//$totalopd = totalopd('', $ADate1, $ADate2);
$totalopd = $totalopd;
$fulltotalopd += $totalopd;

$totalip = totalipd('', $ADate1, $ADate2);
//$totalip =0;
$totalip = $totalip;
$fulltotalip += $totalip;

$query1 = "select * from master_paymenttype where recordstatus <> 'deleted'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1)){

$paymentcode = $res1['auto_number'];  
$paymenttype = $res1['paymenttype'];  



$query5 = "select count(count) as count, misreport from (

    select count, a.misreport FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, A.misreport FROM `billing_paylater` JOIN (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department != '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$paymentcode' group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5)){
  $opcount = $res5['count'];

  $opvisit = $opcount;
  $fulltotalopvisit += $opvisit;
}

$query5 = "select count(count) as count, misreport from (

    select count, a.misreport FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, A.misreport FROM `billing_paylater` JOIN (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department = '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$paymentcode' group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5)){
  $opcount = $res5['count'];

  $opvisit = $opcount;
  $fulltotalopvisit += $opvisit;
}

// $query6 = "select count(ip_bedallocation.accountname) as count, A.misreport from ip_bedallocation join (select distinct(accountname), misreport from master_accountname) as A ON ip_bedallocation.accountname = A.accountname where (ip_bedallocation.recorddate BETWEEN '$ADate1' AND '$ADate2') and A.misreport = '$paymentcode' and ip_bedallocation.ward NOT IN ('1','2','3','8','17')";
// $exec6 = mysql_query($query6) or die(mysql_error());
// while($res6 = mysql_fetch_array($exec6)){
//   $admissioncount0 = $res6['count'];
//   $admissionpaymentcode = $res6['misreport'];

//   if($admissionpaymentcode == $paymentcode){
//     $admissioncount = $admissioncount0;
//     $fulltotaladmissioncount += $admissioncount;
//   } else {
//     $admissioncount = 0;
//   }
// }


 $query6 = "select count(*) as count from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2' and ward NOT IN ('1','2','3','8','17') ";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res6 = mysqli_fetch_array($exec6);
  $fulltotaladmissioncount = $res6['count'];



$query7 = "select sum(count) as count from (
select count(a.visitcode) as count, c.misreport as misreport FROM billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and c.misreport = '$paymentcode' and b.ward NOT IN ('1','2','3','8','17')
UNION ALL 
select count(a.visitcode) as count, c.misreport as misreport FROM billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and c.misreport = '$paymentcode' and b.ward NOT IN ('1','2','3','8','17')
) as count1";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res7 = mysqli_fetch_array($exec7)){
  $dischargecount0 = $res7['count'];

  if($dischargecount0 != ''){
    $dischargecount = $dischargecount0;
    $fulltotaldischargecount += $dischargecount;
  } else {
    $dischargecount = 0;
  }
}

}
/*
$totalopdrefund = getRefund($ADate1, $ADate2);
$ipdiscount = getDiscount($ADate1, $ADate2);
$opdiscount = getOPDiscount($ADate1, $ADate2);
$nhifrebate = getRebate($ADate1, $ADate2);
$dailyoccupancy = getMidnightOccupancy($ADate2);
*/
$totalopdrefund =0;
$ipdiscount = 0;
$opdiscount = 0;
$nhifrebate = 0;
$dailyoccupancy = 0;

$sumrefund = $totalopdrefund + $totalipdrefund;

$fulltotalip = $fulltotalip + $ipdiscount + $nhifrebate;
$fulltotalopd = $fulltotalopd + $totalopdrefund + $opdiscount;
$nettotal = $fulltotalip + $fulltotalopd;


$bedcapacity = $totalbedday = $totalpatientdays = $avgstay = $arpob = $occupancy = 0;
  
$query15 = "select * from master_bed where ward NOT IN ('1','2','3','8','17') and recordstatus <> 'deleted'";
$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res15 = mysqli_num_rows($exec15);

if($res15 != ''){
  $bedcapacity = $res15;
} else {
  $bedcapacity = 0;
}

$startdate = strtotime($ADate1);
$enddate = strtotime($ADate2);
$enddate1 = strtotime($ADate2 . '+1 day');

$daysdifference = ($enddate1 - $startdate)/60/60/24;
$daysdifference + 1;

$totalbedday = $bedcapacity * $daysdifference;

$period = new DatePeriod(
   new DateTime($ADate1),
   new DateInterval('P1D'),
   new DateTime($ADate2)
);

$dischargedpatients = $currentadmission = $totaladmissions = 0;
while($startdate <= $enddate){

    $from_date = date("Y-m-d",$startdate);
    $currentadmission = getadmissions($from_date);
    $totaladmissions += $currentadmission;

    $query31 = "select sum(count) as count from (
        select count(visitcode) as count from ip_bedallocation where ward NOT IN ('1','2','3','8','17') and recorddate <= '$from_date'  and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
        ) as amt1";

    // $query31 = "select sum(count) as count from (
    //     select count(visitcode) as count from ip_bedallocation where ward NOT IN ('1','2','3','8','17') and recorddate <= '$from_date' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date')
    //     UNION ALL 
    //     select count(visitcode) as count from ip_bedtransfer where ward NOT IN ('1','2','3','8','17') and recorddate <= '$from_date' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$from_date') and recordstatus <> 'transfered'
    //     ) as amt1";
      $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res31 = mysqli_fetch_array($exec31);
      $patientcount = $res31['count'];
      $totalpatientdays += $patientcount;

    $startdate = strtotime('+1 day',strtotime(date("Y-m-d",$startdate)));
}


if($fulltotaldischargecount != '' && $totalpatientdays != ''){
    $avgstay = $totalpatientdays / $fulltotaldischargecount;
} else {
    $avgstay = 0;
}

if($fulltotalip != 0 && $totalpatientdays != 0){
    $arpob = $fulltotalip/$totalpatientdays;
} else {
    $arpob = 0;
}

if($totalpatientdays != 0 && $totalbedday != 0){
    $occupancy = ($totalpatientdays / $totalbedday) * 100;
} else {
    $occupancy = 0;
}

return array($nettotal, $fulltotalopvisit, $fulltotaladmissioncount, $fulltotaldischargecount, $occupancy, $dailyoccupancy);
}
 
$day_data = getData($day_fromdate, $day_todate);
$nettotal = $day_data[0];
$fulltotalopvisit = $day_data[1];
$fulltotaladmissioncount = $day_data[2];
$fulltotaldischargecount = $day_data[3];
$occupancy = $day_data[4];
$dailyoccupancy = $day_data[5];

$smsTxt = "";
$smsTxt .= date('M j,Y',strtotime($enddate));
$smsTxt .= "\nDAY";
$smsTxt .= "\nTOTAL REVENUE = ".number_format($nettotal,2);
$smsTxt .= "\nOPD COUNT = ".number_format($fulltotalopvisit);	
$smsTxt .= "\nADMISSION = ".number_format($fulltotaladmissioncount);	
$smsTxt .= "\nDISCHARGE = ".number_format($fulltotaldischargecount);	
$smsTxt .= "\nOCC.BEDS = ".number_format($dailyoccupancy);  
$smsTxt .= "\nOCCUPANCY = ".number_format($occupancy,2).'%';	


$mtd_data = getData($mtd_fromdate, $mtd_todate);
$nettotal = $mtd_data[0];
$fulltotalopvisit = $mtd_data[1];
$fulltotaladmissioncount = $mtd_data[2];
$fulltotaldischargecount = $mtd_data[3];
$occupancy = $mtd_data[4];
$days = getDays($mtd_fromdate, $mtd_todate);

if($days != '0' && $nettotal != '0'){
  $avgrpd = ($nettotal/$days);
} else {
  $avgrpd = 0;
}

$smsTxt .= "\nMTD";
$smsTxt .= "\nTOTAL REVENUE = ".number_format($nettotal,2);
$smsTxt .= "\nAVG.RPD = ".number_format($avgrpd,2);
$smsTxt .= "\nOPD COUNT = ".number_format($fulltotalopvisit);	
$smsTxt .= "\nADMISSION = ".number_format($fulltotaladmissioncount);	
$smsTxt .= "\nDISCHARGE = ".number_format($fulltotaldischargecount);	
echo $smsTxt .= "\nOCCUPANCY = ".number_format($occupancy,2).'%';	



?> 