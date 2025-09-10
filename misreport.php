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
$range = "";
$paymentcode = "";
$fulltotalip = 0;
$fulltotalopd = 0;
$fulltotalgrandtotal = 0;
$fulltotalopvisit = 0;
$fulltotaldischargecount = 0;
$fulltotaladmissioncount = 0;
$totalarpopd = 0;
$totalarperip = 0;
$totalipdrefund = 0;
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

function totalipd($miscode, $ADate1, $ADate2){
      $query98 = "select sum(amount) as amount from (
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname where A.misreport = '$miscode' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_iplab.labitemrate) as amount, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname where A.misreport = '$miscode' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2')
      ) as amount1";
    $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die("Error in query98" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res98 = mysqli_fetch_array($exec98)){
      return $res98['amount'];    
    }
}

function totalopd($miscode, $ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
      select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname  where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
      UNION ALL
      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')  
      UNION ALL
      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') and billing_consultation.accountname = 'CASH - HOSPITAL'
      UNION ALL
      SELECT sum(billing_paylaterconsultation.totalamount) as amount, A.misreport FROM `billing_paylaterconsultation` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowpharmacy.fxamount) as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where A.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2') and billing_paynowpharmacy.locationcode = 'LTC-1'
      UNION ALL
      SELECT sum(billing_paylaterpharmacy.amount) as amount, A.misreport FROM `billing_paylaterpharmacy` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterpharmacy.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
      UNION ALL
      SELECT sum(billing_paylaterlab.labitemrate) as amount, A.misreport FROM `billing_paylaterlab` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$miscode'
      UNION ALL
      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
      ) as amount1";

    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res48 = mysqli_fetch_array($exec48)){
      return $res48['amount'];    
    }
}

function getRefund($ADate1, $ADate2){
  $query48 = "select sum(-1*amount) as totalrefund from (select sum(consultation) as amount from refund_consultation where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(fxamount) as amount from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(consultationfxamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' UNION ALL select sum(amount)as amount from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(amount)as amount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' UNION ALL SELECT SUM(`amount`) as amount FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) UNION ALL select sum(pharmacyfxamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' UNION ALL select sum(labitemrate)as amount from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(labitemrate)as amount from refund_paynowlab where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(labfxamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' UNION ALL select sum(fxamount)as amount from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(radiologyitemrate)as amount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(radiologyfxamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' UNION ALL select sum(fxamount)as amount from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(servicetotal)as amount from refund_paynowservices where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(servicesfxamount) as amount from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' UNION ALL select sum(referalrate) as amount from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' UNION ALL select sum(referalrate) as amount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' ) as refund1";
  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
  $res48 = mysqli_fetch_array($exec48);
  return $res48['totalrefund'];    
}

function getIpRefund($ADate1, $ADate2){
  $query48 = "select sum(-1*amount) as amount from deposit_refund where recorddate between '$ADate1' and '$ADate2'";
  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
  $res48 = mysqli_fetch_array($exec48);
  return $res48['amount'];
}

function getDiscount($ADate1, $ADate2){
  $queryipcashdisc = "select sum(-1*rate) as totaldiscount from ip_discount where consultationdate between '$ADate1' and '$ADate2'";
  $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcashdisc = mysqli_fetch_array($execipdisc);
  $ipcashdisc = $resipcashdisc['totaldiscount'];
  return $ipcashdisc; 
}

function getRebate($ADate1, $ADate2){
  $queryrebate = "SELECT sum(-1*amount) as totalrebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'";
  $execrebate = mysqli_query($GLOBALS["___mysqli_ston"], $queryrebate) or die("Error in queryrebate".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resrebate = mysqli_fetch_array($execrebate);
  $rebate = $resrebate['totalrebate'];
  
  return $rebate; 
}


function getadmissions($ADate1){
  $queryipcreditdisc = "select sum(count) as count from (
      select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate = '$ADate1' and ward != '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate = '$ADate1' and ward != '12'
    UNION ALL
    select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge') and ward != '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge') and ward != '12'
    UNION ALL 
    select count(visitcode) as count from ip_bedallocation where recordstatus = 'transfered' and recorddate = '$ADate1' and ward != '12'
    UNION ALL
    select count(visitcode) from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward != '12'
      UNION ALL
    select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward != '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward != '12'
) as count1";
  $execipcreditdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcreditdisc) or die("Error in queryipcreditdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcreditdisc = mysqli_fetch_array($execipcreditdisc);
  $ipcreditdisc = $resipcreditdisc['count'];
  
  return $ipcreditdisc; 
}



function getmorturyadmissions($ADate1){
  $queryipcreditdisc = "select sum(count) as count from (
      select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate = '$ADate1' and ward = '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate = '$ADate1' and ward = '12'
    UNION ALL
    select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge') and ward = '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate1' and req_status = 'discharge') and ward = '12'
    UNION ALL 
    select count(visitcode) as count from ip_bedallocation where recordstatus = 'transfered' and recorddate = '$ADate1' and ward = '12'
    UNION ALL
    select count(visitcode) from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward = '12'
      UNION ALL
    select count(visitcode) as count from ip_bedallocation where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward = '12'
    UNION ALL
    select count(visitcode) as count from ip_bedtransfer where recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward = '12'
) as count1";
  $execipcreditdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcreditdisc) or die("Error in queryipcreditdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcreditdisc = mysqli_fetch_array($execipcreditdisc);
  $ipcreditdisc = $resipcreditdisc['count'];
  
  return $ipcreditdisc; 
}


?>
<style type="text/css">
<!--
body {
  margin-left: 0px;
  margin-top: 0px;
  background-color: #ecf0f5;
}
.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>

<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->
<script type="text/javascript">
window.onload = function () 
{
  var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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



<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
    
    
              <form name="cbform1" method="post" action="misreport.php">
    <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>MIS Report</strong></td>
            </tr>
       
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
              <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
            </tr> 
            <tr>
              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                <input type="submit" value="Search" name="Submit" />
                <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
    </form>   </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <?php 
            if (isset($_POST["Submit"])) {
            ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"> 
               <!-- <a target="_blank" href="print_misreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?> "><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->
               <a target="_blank" href="print_misreportxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?> "><img src="images/excel-xls-icon.png" width="30" height="30"></a>
              </td>
            </tr>
            <tr>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="right"></td> 
            </tr>
            <tr>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IPD</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OPD</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Grand Total</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP Visit</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>AR OPD</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discharge</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>AR per IP</strong></div></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Admission</strong></div></td> 
            </tr>
            <?php 
             
              $query1 = "select * from mis_types where recordstatus <> 'deleted'";
              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res1 = mysqli_fetch_array($exec1)){
                $totalopd = $totalip = 0;
                $paymentcode = $res1['auto_number'];  
                $paymenttype = $res1['type'];  

                $totalopd = totalopd($paymentcode, $ADate1, $ADate2);
                $totalopd = $totalopd;
                $fulltotalopd += $totalopd;

                $totalip = totalipd($paymentcode, $ADate1, $ADate2);
                $totalip = $totalip;
                $fulltotalip += $totalip;

                $grandtotal = $totalip + $totalopd;
                $fulltotalgrandtotal += $grandtotal; 

                $query5 = "select sum(count) as count, misreport from (select count(billing_paynow.accountname) as count, A.misreport FROM `billing_paynow` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynow.accountname where billing_paynow.billdate BETWEEN '$ADate1' and '$ADate2' and A.misreport = '$paymentcode' UNION ALL select count(billing_paylater.accountnameid) as count, A.misreport FROM `billing_paylater` JOIN (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on A.id = billing_paylater.accountnameid where (billing_paylater.billdate BETWEEN '$ADate1' and '$ADate2') and A.misreport = '$paymentcode') as count1";
                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res5 = mysqli_fetch_array($exec5)){
                  $opcount = $res5['count'];

                  $opvisit = $opcount;
                  $fulltotalopvisit += $opvisit;
                }

                $query6 = "select count(ip_bedallocation.accountname) as count, A.misreport from ip_bedallocation join (select distinct(accountname), misreport from master_accountname) as A ON ip_bedallocation.accountname = A.accountname where (ip_bedallocation.recorddate BETWEEN '$ADate1' AND '$ADate2') and A.misreport = '$paymentcode' and ip_bedallocation.ward != '12'";
                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res6 = mysqli_fetch_array($exec6)){
                  $admissioncount0 = $res6['count'];
                  $admissionpaymentcode = $res6['misreport'];

                  if($admissionpaymentcode == $paymentcode){
                    $admissioncount = $admissioncount0;
                    $fulltotaladmissioncount += $admissioncount;
                  } else {
                    $admissioncount = 0;
                  }
                }

              $query7 = "select sum(count) as count from (
                select count(a.visitcode) as count, c.misreport as misreport FROM billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and b.ward != '12' and c.misreport = '$paymentcode'
                UNION ALL 
                select count(a.visitcode) as count, c.misreport as misreport FROM billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and b.ward != '12' and c.misreport = '$paymentcode'
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
 
                if($totalopd != '0' && $opvisit != '0'){
                  $arpopd = $totalopd / $opvisit;
                  if($fulltotalopd != '0' && $fulltotalopvisit != '0'){
                    $totalarpopd = $fulltotalopd / $fulltotalopvisit;
                  } else {
                    $totalarpopd = 0  ;
                  }
                } else {
                  $arpopd = 0;
                }
                
                
                if($totalip != '0' && $dischargecount != '0'){
                  $arperip = $totalip / $dischargecount;
                  if($fulltotalip != '0' && $fulltotaldischargecount != '0'){
                    $totalarperip = $fulltotalip / $fulltotaldischargecount;
                  } else {
                    $totalarperip = 0;
                  }  
                } else {
                  $arperip = 0;
                }


                $colorloopcount = $colorloopcount + 1;
                $showcolor = ($colorloopcount & 1); 
                if ($showcolor == 0)
                {
                  //echo "if";
                  $colorcode = 'bgcolor="#CBDBFA"';
                }
                else
                {
                  //echo "else";
                  $colorcode = 'bgcolor="#ecf0f5"';
                }
            ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $paymenttype; ?></td>
                <td  align="right" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalip, 2); ?></div></td> 
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($totalopd, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($grandtotal, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($opvisit); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php echo number_format($arpopd,2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php echo number_format($dischargecount); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php echo number_format($arperip); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php echo number_format($admissioncount); ?></div></td>
              </tr>
            <?php
              } 
            ?>
              <tr>
              <td class="bodytext31" valign="center" bgcolor="#ffffff" align="left"><strong><?php echo "GROSS TOTAL" ?></strong></td>
              <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo number_format($fulltotalip, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalopd, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalgrandtotal, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalopvisit); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php echo number_format($totalarpopd,2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php echo number_format($fulltotaldischargecount); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php echo number_format($totalarperip); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php echo number_format($fulltotaladmissioncount); ?></strong></div></td>
            </tr> 
            <?php
                  $sumrefund = 0;
                  $totalopdrefund = getRefund($ADate1, $ADate2);
                  $ipdiscount = getDiscount($ADate1, $ADate2);
                  $nhifrebate = getRebate($ADate1, $ADate2);
                  // $totalipdrefund = getIpRefund($ADate1, $ADate2);

                  $sumrefund = $totalopdrefund + $totalipdrefund;

                  $fulltotalip = $fulltotalip + $ipdiscount + $nhifrebate /*+ $totalipdrefund*/;
                  $fulltotalopd = $fulltotalopd + $totalopdrefund;
                  $fulltotalgrandtotal = $fulltotalip + $fulltotalopd;

                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    //echo "if";
                    $colorcode = 'bgcolor="#CBDBFA"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ecf0f5"';
                  }
              ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left">REFUNDS</td>
                <td  align="right" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipdrefund, 2); ?></div></td> 
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php  echo number_format($totalopdrefund, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($sumrefund, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
              </tr>
              <?php
                $colorloopcount = $colorloopcount + 1;
                $showcolor = ($colorloopcount & 1); 
                if ($showcolor == 0)
                {
                  //echo "if";
                  $colorcode = 'bgcolor="#CBDBFA"';
                }
                else
                {
                  //echo "else";
                  $colorcode = 'bgcolor="#ecf0f5"';
                }
              ?>
                <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left">DISCOUNTS</td>
                <td  align="right" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipdiscount, 2);  ?></div></td> 
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format(0, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($ipdiscount, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
              </tr>
              <?php
                $colorloopcount = $colorloopcount + 1;
                $showcolor = ($colorloopcount & 1); 
                if ($showcolor == 0)
                {
                  //echo "if";
                  $colorcode = 'bgcolor="#CBDBFA"';
                }
                else
                {
                  //echo "else";
                  $colorcode = 'bgcolor="#ecf0f5"';
                }
            ?>
            <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left">NHIF REBATE</td>
                <td  align="right" valign="center" class="bodytext31"><div align="right"><?php echo number_format($nhifrebate, 2); ?></div></td> 
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format(0, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php echo number_format($nhifrebate, 2); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div class="bodytext31"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                  <div align="right"><?php ?></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center" bgcolor="#ffffff" align="left"><strong><?php echo "NET TOTAL" ?></strong></td>
              <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo number_format($fulltotalip, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalopd, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalgrandtotal, 2); ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div class="bodytext31"><strong><?php ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php ?></strong></div></td>
              <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="right">
                <div align="right"><strong><?php ?></strong></div></td>
            </tr> 
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
              <td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
              <td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
            </tr>
          </tbody>
        </table>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
          bordercolor="#666666" cellspacing="0" cellpadding="4" width="200" 
          align="left" border="0">
          <tbody>
              <tr>
              <td class="bodytext31" valign="center" align="left" width="40" height="38"> </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="left"></td> 
              </tr>
              <tr>
                <td></td>
                <td width="50" align="left" valign="center"  
                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>HEADING</strong></div></td>
                <td width="50" align="left" valign="center"  
                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>VALUE</strong></div></td>
              </tr>
              <tr>
                <td></td>
                <?php
                  $bedcapacity = $totalbedday = $totalpatientdays = $avgstay = $arpob = $occupancy = 0;

                  $query15 = "select * from master_bed where recordstatus <> 'deleted' and ward <> '12'";
                  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res15 = mysqli_num_rows($exec15);

                  // if($res15 != ''){
                  //   $bedcapacity = $res15;
                  // } else {
                  //   $bedcapacity = 0;
                  // }
                  $bedcapacity = 60;

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

                        $query31 = "select visitcode, billdate from billing_ip where billdate = '$from_date' UNION ALL select visitcode, billdate from billing_ipcreditapproved where billdate = '$from_date'";
                        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($res31 = mysqli_fetch_array($exec31)){
                          $res31visitcode = $res31['visitcode'];
                          $dischargedate = $res31['billdate'];

                          $query32 = "select recorddate from ip_bedallocation where visitcode = '$res31visitcode' and ward <> '12'";
                          $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die("Error in query32".mysqli_error($GLOBALS["___mysqli_ston"]));
                          $res32 = mysqli_fetch_array($exec32);
                          $admisisondate = $res32['recorddate'];

                          if($dischargedate != '' and $admisisondate != ''){
                              $admdate = strtotime($admisisondate);
                              $disdate = strtotime($dischargedate);

                              $daysdifference = ($disdate - $admdate)/60/60/24;
                              $totalpatientdays += $daysdifference;
                          }
                        }

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

                ?>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">BED CAPACITY</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($bedcapacity); ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">BED DAYS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo $totalbedday;  ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">PATIENT DAYS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo $totalpatientdays;  ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">ALOS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo number_format($avgstay, 2); ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">A.R.P.O.B</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($arpob, 2); ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">OCCUPANCY</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo number_format($occupancy, 2)."%";  ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5" colspan="2">&nbsp;</td>
              </tr>
              <tr><td><br></td></tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><strong>NHIF REBATE</strong></td>
                <?php
                $nhifrebate1 = 0;
                $query40 = "select sum(amount) as amount from (
                    select sum(fxamount) as amount from billing_ipcreditapprovedtransaction where billdate between '$ADate1' and '$ADate2' and accountnameid = '07-702919-TD'
                    UNION ALL
                    select sum(totalrevenue) from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameid = '07-702919-TD'
                  ) as amount1";
                $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res40 = mysqli_fetch_array($exec40);
                $nhifrebate1 = $res40['amount'];
                ?>
                <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($nhifrebate1,2); ?></strong></td>
              </tr>
            </tbody>
          </table>

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
          bordercolor="#666666" cellspacing="0" cellpadding="4" width="200" 
          align="left" border="0">
          <tbody>
              <tr>
              <td class="bodytext31" valign="center" align="left" width="40" height="38"> </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="left"></td> 
              </tr>
              <tr>
                <td></td>
                <td width="50" align="left" valign="center"  
                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>MORTURY</strong></div></td>
                <td width="50" align="left" valign="center"  
                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>VALUE</strong></div></td>
              </tr>
              <tr>
                <td></td>
                <?php
                  $bedcapacity = $totalbedday = $totalpatientdays = $avgstay = $arpob = $occupancy = 0;
                  $discharge = 0.00;

                  $query15 = "select * from master_bed where recordstatus <> 'deleted' and ward = '12'";
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
                        $currentadmission = getmorturyadmissions($from_date);
                        $totaladmissions += $currentadmission;

                        $query31 = "select visitcode, billdate from billing_ip where billdate = '$from_date' UNION ALL select visitcode, billdate from billing_ipcreditapproved where billdate = '$from_date'";
                        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($res31 = mysqli_fetch_array($exec31)){
                          $res31visitcode = $res31['visitcode'];
                          $dischargedate = $res31['billdate'];

                          $query32 = "select recorddate from ip_bedallocation where visitcode = '$res31visitcode' and ward = '12'";
                          $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die("Error in query32".mysqli_error($GLOBALS["___mysqli_ston"]));
                          $res32 = mysqli_fetch_array($exec32);
                          $admisisondate = $res32['recorddate'];

                          if($dischargedate != '' and $admisisondate != ''){
                              $admdate = strtotime($admisisondate);
                              $disdate = strtotime($dischargedate);

                              $daysdifference = ($disdate - $admdate)/60/60/24;
                              $totalpatientdays += $daysdifference;
                          }
                        }

                        $startdate = strtotime('+1 day',strtotime(date("Y-m-d",$startdate)));
                  }

                  $query36 = "select count(visitcode) as count from (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from ip_bedallocation where ward = '12') UNION ALL select visitcode from billing_ipcreditapproved where billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select visitcode from ip_bedallocation where ward = '12') ) as visitcode";
                  $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die("Error in query36".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res36 = mysqli_fetch_array($exec36);
                  $totmorturypatients = $res36['count'];

                  $query31 = "select sum(totalrevenue) as amount from (select totalrevenue from billing_ip where billdate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from ip_bedallocation where ward = '12') UNION ALL select totalrevenue from billing_ipcreditapproved where billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select visitcode from ip_bedallocation where ward = '12') ) as visitcode";
                  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res31 = mysqli_fetch_array($exec31);
                  $mrevenue = $res31['amount'];

                  if($totmorturypatients != '' && $totalpatientdays != ''){
                        $avgstay = $totalpatientdays / $totmorturypatients ;
                  } else {
                        $avgstay = 0;
                  }

                  if($fulltotalip != 0 && $totalpatientdays != 0){
                        $arpob = $fulltotalip/$totalpatientdays;
                  } else {
                        $arpob = 0;
                  }

                  if($avgstay != 0 && $totalpatientdays != 0){
                        $discharge = $totalpatientdays/$avgstay;
                  } else {
                        $discharge = 0;
                  }

                  if($totalpatientdays != 0 && $totalbedday != 0){
                        $occupancy = ($totalpatientdays / $totalbedday) * 100;
                  } else {
                        $occupancy = 0;
                  }

                ?>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">BED CAPACITY</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($bedcapacity); ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">BED DAYS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo $totalbedday;  ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">PATIENT DAYS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo $totalpatientdays;  ?></td>
              </tr>

              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">ALOS</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo number_format($avgstay, 2); ?></td>
              </tr>

              <!-- <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">A.R.P.O.B</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($arpob, 2); ?></td>
              </tr>
 -->
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">DISCHARGE</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($discharge, 2);  ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">OCCUPANCY</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><?php echo number_format($occupancy, 2)."%";  ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA">REVENUE</td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#CBDBFA"><?php echo number_format($mrevenue, 2);  ?></td>
              </tr>
              <tr>
                <td></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan="2">&nbsp;</td>

              </tr>
            </tbody>
          </table>

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" align="left" border="0">
            <td><br></td>
            <td><br></td>
          </table>
          <tr>
            <td><br></td>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="2300" align="left" border="1">

            <tbody>
              <tr bgcolor="#ffffff">
                <td width="8%" class="bodytext31" valign="center" align="center" rowspan="3"><strong>Account Name</strong></td>
                <?php 
                  $query1 = "select * from mis_types where recordstatus <> 'deleted'";
                  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res1 = mysqli_fetch_array($exec1)){
                    $paymentcode = $res1['auto_number'];  
                    $paymenttype = $res1['type'];  
                ?>
                <td class="bodytext31" valign="center" align="center" colspan="4"><strong><?php echo $paymenttype; ?></strong></td> 
                <?php } ?> 
                <td class="bodytext31" valign="center" align="center" colspan="4"><strong>TOTAL</strong></td> 
              </tr>
              <tr bgcolor="#ffffff">
                <?php 
                  $query1 = "select * from mis_types where recordstatus <> 'deleted'";
                  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $numrows = mysqli_num_rows($exec1);
                  for($i=0; $i<=  $numrows; $i++){
                ?>
                <td width="3%" class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
                <td width="3%" class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
                <?php } ?>
              </tr>

              <tr bgcolor="#ffffff">
                <?php 
                  $query1 = "select * from mis_types where recordstatus <> 'deleted'";
                  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $numrows = mysqli_num_rows($exec1);
                  for($i=0; $i<=  $numrows; $i++){
                ?>
                <td width="2%" class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
                <td width="3%" class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
                <td width="2%" class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
                <td width="3%" class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
                <?php } ?>
              </tr>

              <?php
                $miscode = '';  

                $aoncapopdnos = $aoncapopdrevenue = $aoncapipdnos = $aoncapipdrevenue = 0;
                $nhifcapopdnos = $nhifcapopdrevenue = $nhifcapipdnos = $nhifcapipdrevenue = 0;
                $cashopdnos = $cashopdrevenue = $cashipdnos = $cashipdrevenue = 0;
                $nhifopdnos = $nhifopdrevenue = $nhifipdnos = $nhifipdrevenue = 0;
                $ffsopdnos = $ffsopdrevenue = $ffsipdnos = $ffsipdrevenue = 0;
                $blissopdnos = $blissopdrevenue = $blissipdnos = $blissipdrevenue = 0;
                $nemisopdnos = $nemisopdrevenue = $nemisipdnos = $nemisipdrevenue = 0;
                $npsopdnos = $npsopdrevenue = $npsipdnos = $npsipdrevenue = 0;
                $sumaoncapopdnos = $sumaoncapopdrevenue = $sumaoncapipdnos = $sumaoncapipdrevenue = 0;
                $sumnhifcapopdnos = $sumnhifcapopsrevenue = $sumnhifcapipdnos = $sumnhifcapipdrevenue = 0;
                $sumcashopdnos = $sumcashopdrevenue = $sumcashipdnos = $sumcashiprevenue = 0;
                $sumnhifopdnos = $sumnhifopdrevenue = $sumnhifipdnos = $sumnhifipdrevenue = 0;
                $sumffsopdnos = $sumffsopdrevenue = $sumffsipdnos = $sumffsipdrevenue = 0;
                $sumblissopdnos = $sumblissopdrevenue = $sumblissipdnos = $sumblissipdrevenue = 0;
                $sumnemisopdnos = $sumnemisopdrevenue = $sumnemisipdnos = $sumnemisipdrevenue = 0;
                $sumnpsopdnos = $sumnpsopdrevenue = $sumnpsipdnos = $sumnpsipdrevenue = 0;
                $sumtotalopdnos = $sumtotalopdrevenue = $sumtotalipdnos = $sumtotalipdrevenue = 0;

                $query41 = "select * from mis_accountname";
                $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res41 = mysqli_fetch_array($exec41)){
                  $account = $res41['accountname'];
                  $misautono = $res41['auto_number'];
                

                $query42= "select * from mis_types where recordstatus <> 'deleted'";
                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $rows = mysqli_num_rows($exec42);
                while($res42 = mysqli_fetch_array($exec42)){
                  $miscode = $res42['auto_number'];

                  //AMBULANCE SERVICES INCOME
                if($misautono == 1){
                  $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;

                  $query47 = "select sum(amount) as count from (
                  select count(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipambulance.visitcode
                  UNION ALL
                  select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                  select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
                  UNION ALL
                  select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(count) as count from (
                  select count(billing_opambulance.amount) as count, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') group by billing_opambulance.visitcode
                  UNION ALL
                  select count(billing_paynowservices.fxamount) as count, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                  UNION ALL
                  select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                  ) as count1";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                  select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
                  UNION ALL
                  select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                  UNION ALL
                  select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                    ) as amount1";

                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }

                  //BED CHARGES INCOME
                } else if($misautono == 2){

                  $query44 = "select sum(count) as count from (
                  select count(DISTINCT(billing_ipbedcharges.visitcode)) as count FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipbedcharges.ward != '12' group by billing_ipbedcharges.visitcode
                  ) as count1";

                  $exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die("Error in query44" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res44 = mysqli_fetch_array($exec44)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res44['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res44['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res44['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res44['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res44['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res44['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res44['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res44['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }


                  $query43 = "select sum(amount) as amount from (
                  select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipbedcharges.ward != '12'
                  UNION ALL 
                  select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') ) as amount1";
                  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("Error in query43" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res43 = mysqli_fetch_array($exec43)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res43['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res43['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res43['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res43['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res43['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res43['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res43['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res43['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                    UNION ALL
                    select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                        ) as amount1";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }
                  
                //CT SCAN INCOME
                } else if($misautono == 3) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }
                  
                //DENTAL INCOME
                } else if($misautono == 4) {
                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                    UNION ALL
                    select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                        ) as amount1";
                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res50 = mysqli_fetch_array($exec50)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                        ) as amount1";

                  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res51 = mysqli_fetch_array($exec51)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }


                $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";

                  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res49 = mysqli_fetch_array($exec49)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res49['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res49['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res49['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res49['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res49['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res49['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res49['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res49['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }


                  $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  //DIALYSIS INCOME
                } else if($misautono == 5) {

                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                    UNION ALL
                    select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                        ) as amount1";
                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res50 = mysqli_fetch_array($exec50)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res51 = mysqli_fetch_array($exec51)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }


                  $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";
                  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res49 = mysqli_fetch_array($exec49)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res49['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res49['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res49['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res49['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res49['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res49['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res49['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res49['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }


                  $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                //DOCTOR CONSULTATION FEES
                } else if($misautono == 6) {
                  $query50 = "select sum(count) as count from ( 
                   SELECT count(billing_consultation.consultation) as count, master_accountname.misreport FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_consultation.patientvisitcode
                   UNION ALL
                   SELECT count(billing_paylaterconsultation.totalamount) as count, A.misreport FROM `billing_paylaterconsultation` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where A.misreport = '$miscode' and (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterconsultation.visitcode
                  ) as amount1";
                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res50 = mysqli_fetch_array($exec50)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from ( 
                   SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') and billing_consultation.accountname = 'CASH - HOSPITAL'
                   UNION ALL
                   SELECT sum(billing_paylaterconsultation.totalamount) as amount, A.misreport FROM `billing_paylaterconsultation` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterconsultation.visitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where A.misreport = '$miscode' and (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                 
                  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res51 = mysqli_fetch_array($exec51)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }

                  $query49 = "select sum(count) as count from (
                  select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Consultant Fee' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode
                  UNION ALL 
                  select count(billing_ipservices.servicesitemrateuhx) as count, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate between '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode ) as count1";

                  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res49 = mysqli_fetch_array($exec49)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res49['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res49['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res49['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res49['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res49['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res49['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res49['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res49['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }

                 $query48 = "select sum(amount) as amount from (
                  select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Consultant Fee' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipbedcharges.ward != '12'
                  UNION ALL
                  select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                   ) as amount1";

                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  //ECHO SERVICES INCOME
                 } else if($misautono == 7) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }
                  

                  //ENDOSCOPY INCOME
                  } else if($misautono == 8) {
                    $query47 = "select sum(amount) as count from (
                    select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode
                    UNION ALL
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL 
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  $query46 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                      UNION ALL 
                      select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                      UNION ALL
                      SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }
                  

                  //LABORATORY INCOME
                 } else if($misautono == 9) {

                  $query50 = "select sum(amount) as count from (
                    select count(DISTINCT(billing_paynowlab.patientvisitcode)) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL' group by billing_paynowlab.patientvisitcode
                    UNION ALL
                    SELECT count(DISTINCT(billing_paylaterlab.patientvisitcode)) as amount, A.misreport FROM `billing_paylaterlab` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where A.misreport = '$miscode' and (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterlab.patientvisitcode
                        ) as amount1";
                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res50 = mysqli_fetch_array($exec50)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
                    UNION ALL
                    SELECT sum(billing_paylaterlab.labitemrate) as amount, A.misreport FROM `billing_paylaterlab` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterlab.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where A.misreport = '$miscode' and (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res51 = mysqli_fetch_array($exec51)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }


                  $query49 = "select count(DISTINCT(billing_iplab.patientvisitcode)) as count, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')";

                  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res49 = mysqli_fetch_array($exec49)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res49['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res49['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res49['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res49['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res49['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res49['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res49['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res49['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(billing_iplab.labitemrate) as amount, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  //MEDICAL GASES INCOME
                } else if($misautono == 10) {
                    $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                    $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = $blissopdnos = $nemisopdnos = $npsopdnos = 0;
                    $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = $blissopdrevenue = $nemisopdrevenue = $npsopdrevenue = 0;

                    $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }

                    $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }


                //MEDICINE INCOME
                } else if($misautono == 11) {
                  $query47 = "select sum(count) as count from (
                  select count(DISTINCT(a.visitcode)) as count, c.misreport as misreport FROM billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and b.ward != '12' and c.misreport = '$miscode' 
                  UNION ALL 
                  select count(DISTINCT(a.visitcode)) as count, c.misreport as misreport FROM billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode JOIN master_accountname as c ON a.accountnameid = c.id where a.billdate between '$ADate1' and '$ADate2' and b.ward != '12' and c.misreport = '$miscode'
                ) as count1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                 

                  $query48 = "select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')";

                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  $query46 = "select sum(amount) as count from (
                    select sum(amount) as amount from (select '1' as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where A.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2') and billing_paynowpharmacy.locationcode = 'LTC-1' GROUP BY billing_paynowpharmacy.patientvisitcode) as amount2
                    UNION ALL
                    select sum(amount) as amount from (SELECT '1' as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where A.misreport = '$miscode' and (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2') and billing_paylaterpharmacy.locationcode = 'LTC-1' group by billing_paylaterpharmacy.patientvisitcode) as amount2
                        ) as amount1";

                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;  
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowpharmacy.fxamount) as amount, A.misreport from billing_paynowpharmacy JOIN (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A ON billing_paynowpharmacy.accountname = A.accountname where A.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterpharmacy.amount) as amount, A.misreport FROM `billing_paylaterpharmacy` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterpharmacy.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id where A.misreport = '$miscode' and (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }

                //MINOR PROCEDURE INCOME
                } else if($misautono == 12) {
                  $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                          ) as amount1";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res50 = mysqli_fetch_array($exec50)){
                      if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res51 = mysqli_fetch_array($exec51)){
                      if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                    }


                    $query49 = "select sum(amount) as count from (
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode
                      ) as amount1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }

                    $query48 =  "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      ) as amount1";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }

                //MORTURY INCOME
                } else if($misautono == 13) {

                  $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2') group by billing_externalservices.patientvisitcode
                          ) as amount1";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res50 = mysqli_fetch_array($exec50)){
                      if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res51 = mysqli_fetch_array($exec51)){
                      if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                    }

                    $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }


                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                        $aoncapipdrevenue = $res48['amount'];
                        $sumaoncapipdrevenue += $aoncapipdrevenue;
                      } elseif($miscode == '2'){
                        $nhifcapipdrevenue = $res48['amount'];
                        $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                      }elseif($miscode == '3'){
                        $cashipdrevenue = $res48['amount'];
                        $sumcashiprevenue += $cashipdrevenue;
                      }elseif($miscode == '4'){
                        $nhifipdrevenue = $res48['amount'];
                        $sumnhifipdrevenue += $nhifipdrevenue;
                      }elseif($miscode == '5'){
                        $ffsipdrevenue = $res48['amount'];
                        $sumffsipdrevenue += $ffsipdrevenue;
                      }elseif($miscode == '6'){
                        $blissipdrevenue = $res48['amount'];
                        $sumblissipdrevenue += $blissipdrevenue;
                      }elseif($miscode == '7'){
                        $nemisipdrevenue = $res48['amount'];
                        $sumnemisipdrevenue += $nemisipdrevenue;
                      }elseif($miscode == '8'){
                        $npsipdrevenue = $res48['amount'];
                        $sumnpsipdrevenue += $npsipdrevenue;
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }
                
                //MRI INCOME
                } else if($misautono == 14) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }
                  
                //NURSING CARE INCOME
                } else if($misautono == 15) {
              $totalopdnos = $totalopdrevenue = 0;
              $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
              $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

              $query52 = "select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode";

              $exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die("Error in query52" . mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res52 = mysqli_fetch_array($exec52)){
                if($miscode == '1'){
                      $aoncapipdnos = $res52['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res52['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res52['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res52['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res52['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res52['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res52['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res52['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
              }
             

              $query53 = "select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";
              $exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die("Error in query53" . mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res53 = mysqli_fetch_array($exec53)){
                if($miscode == '1'){
                      $aoncapipdrevenue = $res53['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res53['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res53['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res53['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res53['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res53['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res53['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res53['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
              }


            // //OPD REGISTRATION FEE  
            } else if($misautono == 16) {
                $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
                $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

                $query49 = "select count(billing_ipadmissioncharge.amountuhx) as count, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipadmissioncharge.visitcode in (select visitcode from ip_bedallocation where ward != '12' )";
                $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res49 = mysqli_fetch_array($exec49)){
                  if($miscode == '1'){
                      $aoncapipdnos = $res49['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res49['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res49['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res49['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res49['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res49['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res49['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res49['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                }
               

                $query48 = "select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipadmissioncharge.visitcode in (select visitcode from ip_bedallocation where ward != '12' )";
                $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res48 = mysqli_fetch_array($exec48)){
                  if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                }

              //OPTICAL REVENUE
            } else if($misautono == 17) {
                $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2') group by billing_externalservices.patientvisitcode
                          ) as amount1";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res50 = mysqli_fetch_array($exec50)){
                      if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res51 = mysqli_fetch_array($exec51)){
                      if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                    }


                    $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }


                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }

                 //OT SERVICES REVENUE
                } else if($misautono == 18) {
                    $query50 = "select sum(amount) as count from (
                       select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2') group by billing_externalservices.patientvisitcode
                          ) as amount1";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res50 = mysqli_fetch_array($exec50)){
                      if($miscode == '1'){
                      $aoncapopdnos = $res50['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res50['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res50['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res50['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res50['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res50['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res50['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res50['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res51 = mysqli_fetch_array($exec51)){
                      if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                    }


                    $query49 = "select sum(amount) as count from (
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode
                    ) as count1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }

                    $query48 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                        $aoncapipdrevenue = $res48['amount'];
                        $sumaoncapipdrevenue += $aoncapipdrevenue;
                      } elseif($miscode == '2'){
                        $nhifcapipdrevenue = $res48['amount'];
                        $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                      }elseif($miscode == '3'){
                        $cashipdrevenue = $res48['amount'];
                        $sumcashiprevenue += $cashipdrevenue;
                      }elseif($miscode == '4'){
                        $nhifipdrevenue = $res48['amount'];
                        $sumnhifipdrevenue += $nhifipdrevenue;
                      }elseif($miscode == '5'){
                        $ffsipdrevenue = $res48['amount'];
                        $sumffsipdrevenue += $ffsipdrevenue;
                      }elseif($miscode == '6'){
                        $blissipdrevenue = $res48['amount'];
                        $sumblissipdrevenue += $blissipdrevenue;
                      }elseif($miscode == '7'){
                        $nemisipdrevenue = $res48['amount'];
                        $sumnemisipdrevenue += $nemisipdrevenue;
                      }elseif($miscode == '8'){
                        $npsipdrevenue = $res48['amount'];
                        $sumnpsipdrevenue += $npsipdrevenue;
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }

               //PHYSIOTHERAPY INCOME
              } else if($misautono == 19) {
                $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                          ) as amount1";
                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die("Error in query50" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res50 = mysqli_fetch_array($exec50)){
                        if($miscode == '1'){
                          $aoncapopdnos = $res50['count'];
                          $sumaoncapopdnos += $aoncapopdnos;
                        } elseif($miscode == '2'){
                          $nhifcapopdnos = $res50['count'];
                          $sumnhifcapopdnos += $nhifcapopdnos;
                        }elseif($miscode == '3'){
                          $cashopdnos = $res50['count'];
                          $sumcashopdnos += $cashopdnos;
                        }elseif($miscode == '4'){
                          $nhifopdnos = $res50['count'];
                          $sumnhifopdnos += $nhifopdnos;
                        }elseif($miscode == '5'){
                          $ffsopdnos = $res50['count'];
                          $sumffsopdnos += $ffsopdnos;
                        }elseif($miscode == '6'){
                          $blissopdnos = $res50['count'];
                          $sumblissopdnos += $blissopdnos;
                        }elseif($miscode == '7'){
                          $nemisopdnos = $res50['count'];
                          $sumnemisopdnos += $nemisopdnos;
                        }elseif($miscode == '8'){
                          $npsopdnos = $res50['count'];
                          $sumnpsopdnos += $npsopdnos;
                        }
                        $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                        $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";
                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res51 = mysqli_fetch_array($exec51)){
                     if($miscode == '1'){
                      $aoncapopdrevenue = $res51['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res51['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res51['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res51['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res51['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res51['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res51['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res51['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                    }


                    $query49 = "select sum(count) as count from (select count(DISTINCT(billing_ipservices.patientvisitcode)) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode) as count1";

                    $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res49 = mysqli_fetch_array($exec49)){
                      if($miscode == '1'){
                        $aoncapipdnos = $res49['count'];
                        $sumaoncapipdnos += $aoncapipdnos;
                      } elseif($miscode == '2'){
                        $nhifcapipdnos = $res49['count'];
                        $sumnhifcapipdnos += $nhifcapipdnos;
                      }elseif($miscode == '3'){
                        $cashipdnos = $res49['count'];
                        $sumcashipdnos += $cashipdnos;
                      }elseif($miscode == '4'){
                        $nhifipdnos = $res49['count'];
                        $sumnhifipdnos += $nhifipdnos;
                      }elseif($miscode == '5'){
                        $ffsipdnos = $res49['count'];
                        $sumffsipdnos += $ffsipdnos;
                      }elseif($miscode == '6'){
                        $blissipdnos = $res49['count'];
                        $sumblissipdnos += $blissipdnos;
                      }elseif($miscode == '7'){
                        $nemisipdnos = $res49['count'];
                        $sumnemisipdnos += $nemisipdnos;
                      }elseif($miscode == '8'){
                        $npsipdnos = $res49['count'];
                        $sumnpsipdnos += $npsipdnos;
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

                    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res48 = mysqli_fetch_array($exec48)){
                      if($miscode == '1'){
                        $aoncapipdrevenue = $res48['amount'];
                        $sumaoncapipdrevenue += $aoncapipdrevenue;
                      } elseif($miscode == '2'){
                        $nhifcapipdrevenue = $res48['amount'];
                        $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                      }elseif($miscode == '3'){
                        $cashipdrevenue = $res48['amount'];
                        $sumcashiprevenue += $cashipdrevenue;
                      }elseif($miscode == '4'){
                        $nhifipdrevenue = $res48['amount'];
                        $sumnhifipdrevenue += $nhifipdrevenue;
                      }elseif($miscode == '5'){
                        $ffsipdrevenue = $res48['amount'];
                        $sumffsipdrevenue += $ffsipdrevenue;
                      }elseif($miscode == '6'){
                        $blissipdrevenue = $res48['amount'];
                        $sumblissipdrevenue += $blissipdrevenue;
                      }elseif($miscode == '7'){
                        $nemisipdrevenue = $res48['amount'];
                        $sumnemisipdrevenue += $nemisipdrevenue;
                      }elseif($miscode == '8'){
                        $npsipdrevenue = $res48['amount'];
                        $sumnpsipdrevenue += $npsipdrevenue;
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                    }



                //ULTRA SOUND INCOME
                } else if($misautono == 20) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                        ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";
                    
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }

                //X RAY INCOME
                } else if($misautono == 21) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                    ) as amount1 ";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;

                  } 

                  //OTHER INCOMES
                  } else if($misautono == 22) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipradiology.patientvisitcode
                    UNION ALL
                    SELECT count(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_iphomecare.visitcode
                    UNION ALL
                    SELECT count(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipprivatedoctor.visitcode
                    UNION ALL
                    SELECT count(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipmiscbilling.visitcode
                    UNION ALL
                    select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_ipservices.patientvisitcode
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Resident Doctor Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode
                    UNION ALL 
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'RMO Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Daily Review charge' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') group by billing_ipbedcharges.visitcode
                  ) as amount1";
                  $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in query47" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res47 = mysqli_fetch_array($exec47)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res47['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res47['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res47['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res47['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res47['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res47['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res47['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res47['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipprivatedoctor.amount) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Resident Doctor Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL 
                    select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'RMO Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Daily Review charge' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                  ) as amount1";
                  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res48 = mysqli_fetch_array($exec48)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res48['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res48['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res48['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res48['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res48['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res48['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res48['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res48['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                      UNION ALL 
                      select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                      UNION ALL
                      select count(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2') group by billing_paynowreferal.patientvisitcode
                      UNION ALL
                      SELECT count(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paylaterradiology.patientvisitcode
                      UNION ALL
                      SELECT count(billing_paynowradiology.fxamount) as amount, A.misreport FROM `billing_paynowradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynowradiology.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate BETWEEN '$ADate1' and '$ADate2') group by billing_paynowradiology.patientvisitcode
                        ) as amount1";

                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterradiology.radiologyitemrate) as amount, A.misreport FROM `billing_paylaterradiology` JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterradiology.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paynowradiology.fxamount) as amount, A.misreport FROM `billing_paynowradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paynowradiology.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.groupid = '$misautono' and (billing_paynowradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  }

                //MORTURY BED CHARGES INCOME
                } else if($misautono == 23){
                  $query44 = "select sum(count) as count from (
                  select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipbedcharges.ward = '12' group by billing_ipbedcharges.visitcode
                  
                ) as count1";
                  $exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die("Error in query44" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res44 = mysqli_fetch_array($exec44)){
                    if($miscode == '1'){
                      $aoncapipdnos = $res44['count'];
                      $sumaoncapipdnos += $aoncapipdnos;
                    } elseif($miscode == '2'){
                      $nhifcapipdnos = $res44['count'];
                      $sumnhifcapipdnos += $nhifcapipdnos;
                    }elseif($miscode == '3'){
                      $cashipdnos = $res44['count'];
                      $sumcashipdnos += $cashipdnos;
                    }elseif($miscode == '4'){
                      $nhifipdnos = $res44['count'];
                      $sumnhifipdnos += $nhifipdnos;
                    }elseif($miscode == '5'){
                      $ffsipdnos = $res44['count'];
                      $sumffsipdnos += $ffsipdnos;
                    }elseif($miscode == '6'){
                      $blissipdnos = $res44['count'];
                      $sumblissipdnos += $blissipdnos;
                    }elseif($miscode == '7'){
                      $nemisipdnos = $res44['count'];
                      $sumnemisipdnos += $nemisipdnos;
                    }elseif($miscode == '8'){
                      $npsipdnos = $res44['count'];
                      $sumnpsipdnos += $npsipdnos;
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos + $blissipdnos + $nemisipdnos + $npsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos + $sumblissipdnos + $sumnemisipdnos + $sumnpsipdnos;
                  }


                  $query43 = "select sum(amount) as amount from (
                  select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipbedcharges.ward = '12'
                  UNION ALL 
                  select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2') and billing_ipadmissioncharge.visitcode in (select visitcode from ip_bedallocation where ward = '12' ) 
                  ) as amount1";
                  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("Error in query43" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res43 = mysqli_fetch_array($exec43)){
                    if($miscode == '1'){
                      $aoncapipdrevenue = $res43['amount'];
                      $sumaoncapipdrevenue += $aoncapipdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapipdrevenue = $res43['amount'];
                      $sumnhifcapipdrevenue += $nhifcapipdrevenue;
                    }elseif($miscode == '3'){
                      $cashipdrevenue = $res43['amount'];
                      $sumcashiprevenue += $cashipdrevenue;
                    }elseif($miscode == '4'){
                      $nhifipdrevenue = $res43['amount'];
                      $sumnhifipdrevenue += $nhifipdrevenue;
                    }elseif($miscode == '5'){
                      $ffsipdrevenue = $res43['amount'];
                      $sumffsipdrevenue += $ffsipdrevenue;
                    }elseif($miscode == '6'){
                      $blissipdrevenue = $res43['amount'];
                      $sumblissipdrevenue += $blissipdrevenue;
                    }elseif($miscode == '7'){
                      $nemisipdrevenue = $res43['amount'];
                      $sumnemisipdrevenue += $nemisipdrevenue;
                    }elseif($miscode == '8'){
                      $npsipdrevenue = $res43['amount'];
                      $sumnpsipdrevenue += $npsipdrevenue;
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue + $blissipdrevenue + $nemisipdrevenue + $npsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue + $sumblissipdrevenue + $sumnemisipdrevenue + $sumnpsipdrevenue;
                  }

                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2') group by billing_paynowservices.patientvisitcode
                    UNION ALL
                    select count(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2') group by billing_paylaterservices.patientvisitcode
                        ) as amount1";
                  $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in query46" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res46 = mysqli_fetch_array($exec46)){
                    if($miscode == '1'){
                      $aoncapopdnos = $res46['count'];
                      $sumaoncapopdnos += $aoncapopdnos;
                    } elseif($miscode == '2'){
                      $nhifcapopdnos = $res46['count'];
                      $sumnhifcapopdnos += $nhifcapopdnos;
                    }elseif($miscode == '3'){
                      $cashopdnos = $res46['count'];
                      $sumcashopdnos += $cashopdnos;
                    }elseif($miscode == '4'){
                      $nhifopdnos = $res46['count'];
                      $sumnhifopdnos += $nhifopdnos;
                    }elseif($miscode == '5'){
                      $ffsopdnos = $res46['count'];
                      $sumffsopdnos += $ffsopdnos;
                    }elseif($miscode == '6'){
                      $blissopdnos = $res46['count'];
                      $sumblissopdnos += $blissopdnos;
                    }elseif($miscode == '7'){
                      $nemisopdnos = $res46['count'];
                      $sumnemisopdnos += $nemisopdnos;
                    }elseif($miscode == '8'){
                      $npsopdnos = $res46['count'];
                      $sumnpsopdnos += $npsopdnos;
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos + $blissopdnos + $nemisopdnos + $npsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos + $sumblissopdnos + $sumnemisopdnos + $sumnpsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.groupid = '$misautono' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paylaterservices.fxamount) as amount, A.misreport from billing_paylaterservices JOIN (SELECT DISTINCT(visitcode), accountnameid from billing_paylater) as billing_paylater ON billing_paylater.visitcode = billing_paylaterservices.patientvisitcode join (SELECT DISTINCT(master_accountname.id), master_accountname.misreport FROM master_accountname) AS A on billing_paylater.accountnameid = A.id JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.groupid = '$misautono' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                        ) as amount1";
                  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("Error in query45" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res45 = mysqli_fetch_array($exec45)){
                    if($miscode == '1'){
                      $aoncapopdrevenue = $res45['amount'];
                      $sumaoncapopdrevenue += $aoncapopdrevenue;
                    } elseif($miscode == '2'){
                      $nhifcapopdrevenue = $res45['amount'];
                      $sumnhifcapopsrevenue += $nhifcapopdrevenue;
                    }elseif($miscode == '3'){
                      $cashopdrevenue = $res45['amount'];
                      $sumcashopdrevenue += $cashopdrevenue;
                    }elseif($miscode == '4'){
                      $nhifopdrevenue = $res45['amount'];
                      $sumnhifopdrevenue += $nhifopdrevenue; 
                    }elseif($miscode == '5'){
                      $ffsopdrevenue = $res45['amount'];
                      $sumffsopdrevenue += $ffsopdrevenue;
                    }elseif($miscode == '6'){
                      $blissopdrevenue = $res45['amount'];
                      $sumblissopdrevenue += $blissopdrevenue;
                    }elseif($miscode == '7'){
                      $nemisopdrevenue = $res45['amount'];
                      $sumnemisopdrevenue += $nemisopdrevenue;
                    }elseif($miscode == '8'){
                      $npsopdrevenue = $res45['amount'];
                      $sumnpsopdrevenue += $npsopdrevenue;
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue + $blissopdrevenue + $nemisopdrevenue + $npsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue + $sumblissopdrevenue + $sumnemisopdrevenue + $sumnpsopdrevenue;
                  } 
                } else {
                  $aoncapopdnos = $aoncapopdrevenue = $aoncapipdnos = $aoncapipdrevenue = 0;
                  $nhifcapopdnos = $nhifcapopdrevenue = $nhifcapipdnos = $nhifcapipdrevenue = 0;
                  $cashopdnos = $cashopdrevenue = $cashipdnos = $cashipdrevenue = 0;
                  $nhifopdnos = $nhifopdrevenue = $nhifipdnos = $nhifipdrevenue = 0;
                  $ffsopdnos = $ffsopdrevenue = $ffsipdnos = $ffsipdrevenue = 0;
                  $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                }

                } 


                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    //echo "if";
                    $colorcode = 'bgcolor="#CBDBFA"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ecf0f5"';
                  }

                    
              ?>
              <tr <?php echo $colorcode ?> >
                <td class="bodytext31" valign="center" align="left"><?php echo strtoupper($account); ?></td>
                <!-- <td class="bodytext31" valign="center" align="center"><?php echo number_format($aoncapopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($aoncapopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($aoncapipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($aoncapipdrevenue); ?></td> -->
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifcapopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifcapopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifcapipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifcapipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($cashopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($cashopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($cashipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($cashipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nhifipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($ffsopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($ffsopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($ffsipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($ffsipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($blissopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($blissopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($blissipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($blissipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nemisopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nemisopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nemisipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($nemisipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($npsopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($npsopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($npsipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($npsipdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($totalopdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($totalopdrevenue); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($totalipdnos); ?></td>
                <td class="bodytext31" valign="center" align="center"><?php echo number_format($totalipdrevenue); ?></td>
              </tr>
              <?php
                  
                  // $totalopdrefund = getRefund($ADate1, $ADate2);

                  // $ipcashdisc = getIpCashDiscount($ADate1, $ADate2);
                  // $ipcreditdisc = getIpCreditDiscount($ADate1, $ADate2);

               }
              ?>


              <tr bgcolor="#ffffff" >
                <td class="bodytext31" valign="center" align="left"><strong>TOTAL</strong></td>
                <!-- <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumaoncapopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumaoncapopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumaoncapipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumaoncapipdrevenue); ?></strong></td> -->
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifcapopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifcapopsrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifcapipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifcapipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumcashopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumcashopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumcashipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumcashiprevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnhifipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumffsopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumffsopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumffsipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumffsipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumblissipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumblissopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumblissipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumblissipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnemisopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnemisopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnemisipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnemisipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnpsopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnpsopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnpsipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumnpsipdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumtotalopdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumtotalopdrevenue); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumtotalipdnos); ?></strong></td>
                <td class="bodytext31" valign="center" align="center"><strong><?php echo number_format($sumtotalipdrevenue); ?></strong></td>
              </tr>
            </tbody>
          </table>
          </tr>
        </tr>
      <?php
      }
      ?>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>
