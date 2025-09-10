<?php
header('Content-Type: application/json');
include ("db/db_connect.php");

function getOPVisitCount($ADate1, $ADate2){
   

  $query5 = "select sum(count) as count, billdate from (
      select count(count) as count, billdate from (
    select count, a.billdate FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department = '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, billing_paylater.billdate FROM `billing_paylater` JOIN (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department = '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1 group by billdate
  union all
  select count(count) as count, billdate from (
    select count, a.billdate FROM (
  select billing_paynow.accountname as count, A.misreport,C.visitcode,billing_paynow.billdate as billdate FROM `billing_paynow` join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname join  `master_visitentry` as C on billing_paynow.visitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_paynow.visitcode,billing_paynow.billdate
  UNION ALL
  select billing_consultation.accountname as count, A.misreport,C.visitcode,billing_consultation.billdate as billdate FROM billing_consultation join (SELECT master_accountname.accountname, master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname join  `master_visitentry` as C on billing_consultation.patientvisitcode=C.visitcode and C.department != '24' and C.billtype='PAY NOW' where billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_consultation.patientvisitcode,billing_consultation.billdate ) as a group by a.visitcode,a.billdate

   UNION ALL 
  select billing_paylater.accountnameid as count, billing_paylater.billdate FROM `billing_paylater` JOIN (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid join `master_visitentry` as C  on billing_paylater.visitcode=C.visitcode and C.department != '24' where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport in (select auto_number from master_paymenttype where recordstatus <> 'deleted') group by billing_paylater.patientcode,billing_paylater.billdate
  ) as count1 group by billdate
  
  ) as a group by billdate
  ";
  
   //$query5 = "select consultationdate as billdate,count(auto_number) as count from master_visitentry where consultationdate between '$ADate1' and '$ADate2' group by consultationdate";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	$k=0;
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[] = $result;
	}

  return $data;
}

function getMidnightOccupancy($ADate1, $ADate2){

   	$data = array();
    $k=0;
   continueloop:
    /* $query5 = "select sum(count) as count from (
	   select recorddate as billdate,count(visitcode) as count from ip_bedallocation where recorddate <= '$ADate1' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1') and recordstatus <> 'transfered'
	   union all
	   select  recorddate as billdate,count(visitcode) as count from ip_bedtransfer where recorddate <= '$ADate1' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1') and recordstatus <> 'transfered') as a
	
	";*/

	$query5 = "SELECT sum(count) as count from (
    select count(visitcode) as count from ip_bedallocation where  recorddate <= '$ADate1' and  visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1')
    ) as amt1";


    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[$k]['billdate'] = $ADate1;
		$data[$k]['count'] = $result['count'];
		$k++;
	}
    $ADate1 =date('Y-m-d', strtotime("$ADate1 +1 day"));

   if($ADate1<=$ADate2)
    	goto continueloop;


  return $data;
}

function getIPadmissionCount($ADate1, $ADate2){
 
	/*$query5 = "select billdate,sum(count) as count from (select recorddate as billdate,count(visitcode) as count from ip_bedallocation where recorddate between '$ADate1' and '$ADate2' and recordstatus in ('discharged','') group by billdate
     
	 union all select a.recorddate as billdate,count(a.visitcode) as count  from ip_bedallocation as a join ip_bedtransfer as b on( a.patientcode = b.patientcode and a.visitcode = b.visitcode) where  a.recorddate between '$ADate1' and '$ADate2' and a.recordstatus not in ('discharged','') and b.recordstatus in ('discharged','') group by a.recorddate) as a group by billdate";*/

	$query5 = "select count(*) as count,recorddate as billdate from ip_bedallocation where recorddate BETWEEN '$ADate1' AND '$ADate2' group by billdate ";

    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	$k=0;
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[] = $result;
	}

  return $data;
}

function getOPcash($ADate1, $ADate2){

	 $query5 = "select transactiondate as billdate,sum(cashamount1) as count from(
	 
	 select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionpaynow where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate
	            union all
				select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionexternal where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate
				union all
				select sum(cashamount) as cashamount1,billingdatetime as transactiondate from master_billing where  billingdatetime between '$ADate1' and '$ADate2' group by billingdatetime
				union all
				select sum(-1*cashamount) as cashamount1,transactiondate as transactiondate from refund_paynow where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate ) as a group by transactiondate
				
	 "; 

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	while (	$result = mysqli_fetch_array($exec5)) {
		$data['op'][] = $result;
	}


	$query5 = "select transactiondate as billdate,sum(cashamount1) as count from(
	 
	 select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionipdeposit where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate
	            union all
				select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionip where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate
				union all
				select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionipcreditapproved where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate
				union all
				select sum(-1*cashamount) as cashamount1,recorddate as transactiondate  from deposit_refund where recorddate between '$ADate1' and '$ADate2' group by transactiondate
				union all
				select sum(cashamount) as cashamount1,transactiondate as transactiondate from master_transactionadvancedeposit where  transactiondate between '$ADate1' and '$ADate2' group by transactiondate ) as a group by transactiondate
				
	 "; 

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while (	$result = mysqli_fetch_array($exec5)) {
		$data['ip'][] = $result;
	}

    return $data;


}

function getRadiology($ADate1, $ADate2){

	$query5 = "select sum(count) as count,billdate from (
	
	select count(*) as count,a.consultationdate as billdate from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24' group by a.consultationdate   
	union all
    select count(*) as count,a.consultationdate as billdate from consultation_radiology as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24' group by a.consultationdate  
	union all
	 select count(*) as count,consultationdate as billdate from ipconsultation_radiology where consultationdate between '$ADate1' and '$ADate2' group by consultationdate 
    ) as amt2 group by billdate
	
	";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	$k=0;
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[] = $result;
	}
    return $data;
}

function getLab($ADate1, $ADate2){

	$query5 = "select sum(count) as count,billdate from (
	
	select count(*) as count,a.consultationdate as billdate from consultation_lab as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department = '24' group by a.consultationdate   
	union all
    select count(*) as count,a.consultationdate as billdate from consultation_lab as a JOIN master_visitentry as b ON a.patientvisitcode = b.visitcode where a.consultationdate between '$ADate1' and '$ADate2' and b.department != '24' group by a.consultationdate  
	union all
	 select count(*) as count,consultationdate as billdate from ipconsultation_lab where consultationdate between '$ADate1' and '$ADate2' group by consultationdate 
    ) as amt2 group by billdate
	
	";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	$k=0;
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[] = $result;
	}
    return $data;
}

function getPharma($ADate1, $ADate2){

	$query5 = "select sum(count) as count,billdate from (
	
	 select count(distinct billnumber) as count,billdate from billing_paynowpharmacy where billdate between '$ADate1' and '$ADate2' group by billdate
    UNION ALL
    select count(distinct billnumber) as count,billdate from billing_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' group by billdate
	union all
	 select count(distinct docno) as count,date from ipmedicine_prescription where date between '$ADate1' and '$ADate2' group by docno 
    ) as amt2 group by billdate
	
	";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = array();
	$k=0;
	while (	$result = mysqli_fetch_array($exec5)) {
		$data[] = $result;
	}
    return $data;
}

$ADate1=date('Y-m-d');
$ADate2 = date('Y-m-d', strtotime('-1 month'));
$rslt=array();
if(isset($_REQUEST['from']) && $_REQUEST['from']=='opvisit'){
	$rslt = getOPVisitCount($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='opcash'){
	$rslt = getOPcash($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='ipvisit'){
	$rslt = getIPadmissionCount($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='bedocc'){
	$rslt = getMidnightOccupancy($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='radiology'){
	$rslt = getRadiology($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='lab'){
	$rslt = getLab($ADate2, $ADate1);
}elseif(isset($_REQUEST['from']) && $_REQUEST['from']=='pharma'){
	$rslt = getPharma($ADate2, $ADate1);
}

echo json_encode($rslt);


?>