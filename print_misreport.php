<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("db/db_connect.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date('d/m/Y H:i:s');

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


if (isset($_REQUEST["wardcode"])) { $wardcode = $_REQUEST["wardcode"]; } else { $wardcode = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

$query18 = "select * from master_location";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
$row = array();
while($row[] = mysqli_fetch_array($exec18)){
$res1locationname = $row[0]['locationname'];
}


function totalipd($miscode, $ADate1, $ADate2){
  $query98 = "select sum(amount) as amount from (
      select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Consultant Fee' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Echo' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Endoscopy' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_iplab.rateuhx) as amount, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Gases Administration' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obsgyne Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'MORTUARY' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obs Gynae Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'COMPUTERIZED TOMOGRAPHY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipprivatedoctor.amountuhx) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and billing_ipprivatedoctor.billtype <> '' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Resident Doctor Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL 
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'RMO Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Daily Review charge' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      UNION ALL
      select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
      ) as amount1";
    $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die("Error in query98" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res98 = mysqli_fetch_array($exec98)){
      return $res98['amount'];    
    }
}

function totalopd($miscode, $ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
        select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dental' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dialysis' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dialysis' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterconsultation.fxamount) as amount, A.misreport FROM `billing_paylaterconsultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterconsultation.accountname where A.misreport = '$miscode' and (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
        UNION ALL
        SELECT sum(billing_paylaterlab.fxamount) as amount, A.misreport FROM `billing_paylaterlab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterlab.accountname where A.misreport = '$miscode' and (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Gases Administration' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Gases Administration' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Gases Administration' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowpharmacy.fxamount) as amount, master_accountname.misreport from billing_paynowpharmacy JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterpharmacy.fxamount) as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where A.misreport = '$miscode' and (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
         SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Physio' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL 
        select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
        UNION ALL 
        select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        UNION ALL
        SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
        ) as amount1";

    $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res48 = mysqli_fetch_array($exec48)){
      return $res48['amount'];    
    }
}

function getRefund($ADate1, $ADate2){
  $query48 = "select sum(refund) as refund from (
    select sum(consultation) as refund from refund_consultation where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(fxamount) as refund from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(consultationfxamount) as refund from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(amount)as refund from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(amount)as refund from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(pharmacyfxamount) as refund from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
    UNION ALL
    SELECT SUM(`amount`) as refund FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
    UNION ALL
    select sum(labitemrate)as refund from refund_paylaterlab where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(labitemrate) as refund from refund_paynowlab where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(labfxamount) as refund from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(fxamount)as refund from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(radiologyitemrate)as refund from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(radiologyfxamount) as refund from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(fxamount)as refund from refund_paylaterservices where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(servicetotal)as refund from refund_paynowservices where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(servicesfxamount) as refund from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(referalrate)as refund from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2'
    UNION ALL
    select sum(referalrate)as refund from refund_paynowreferal where billdate between '$ADate1' and '$ADate2'
    ) as refund1";
  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
  $res48 = mysqli_fetch_array($exec48);
  return $res48['refund'];    
}

function getIpCashDiscount($ADate1, $ADate2){
  $queryipcashdisc = "select sum(ip_discount.rate) as amount, A.misreport from ip_discount JOIN (select DISTINCT(accountname), misreport from master_accountname) as A ON A.accountname = ip_discount.accountname where A.misreport = '3' and consultationdate between '$ADate1' and '$ADate2'";
  $execipdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcashdisc) or die("Error in queryipcashdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcashdisc = mysqli_fetch_array($execipdisc);
  $ipcashdisc = $resipcashdisc['amount'];
  
  return $ipcashdisc; 
}

function getIpCreditDiscount($ADate1, $ADate2){
  $queryipcreditdisc = "select sum(ip_discount.rate) as amount, A.misreport from ip_discount JOIN (select DISTINCT(accountname), misreport from master_accountname) as A ON A.accountname = ip_discount.accountname where A.misreport != '3' and consultationdate between '$ADate1' and '$ADate2'";
  $execipcreditdisc = mysqli_query($GLOBALS["___mysqli_ston"], $queryipcreditdisc) or die("Error in queryipcreditdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resipcreditdisc = mysqli_fetch_array($execipcreditdisc);
  $ipcreditdisc = $resipcreditdisc['amount'];
  
  return $ipcreditdisc; 
}




?>
<style type="text/css">
<!--
.bodytext4 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c; text-decoration:none
}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c;  text-decoration:none
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

.border3hide {
  border-left: none;  
  border-bottom: none;
  border-top: none;
  border-right: 1px solid #000000;
}

.border2hide {
  border-left: none;  
  border-bottom: 1px solid #000000;
  border-top: none;
  border-right: none;
}

.borderhide {
  border-bottom: none;
  border-top: none;
  border-left:none;
  border-right: none;    
}

</style>

<table cellspacing="3" cellpadding="0" align="left" border="0" style="border-collapse:collapse;" width="100%">
	<tbody>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left" ><strong>MIS Report From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  
	</tr>
 
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
	<tr>
	  	<col width="100"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>Type</strong></td>
	  	<col width="90"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>IPD</strong></td>
	  	<col width="90"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>OPD</strong></td>
	  	<col width="90"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>Grand Total</strong></td>
	  	<col width="60"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>OP Visit</strong></td>
	  	<col width="60"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>ARD OPD</strong></td>
	  	<col width="60"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge</strong></td>
	  	<col width="70"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>AR Per IP</strong></td>
	  	<col width="60"><td align="center" valign="center"  
	    	bgcolor="#ecf0f5" class="bodytext31"><strong>Admission</strong></td>

      <td class="borderhide" rowspan="9">
        <table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
        <tr>
          <col width="50"><td class="border3hide"></td>
          <col width="100"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>HEADING</strong></td>
          <col width="100"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>VALUE</strong></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <?php
          $query15 = "select * from master_bed where recordstatus <> 'deleted' and ward <> '12'";
                  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res15 = mysqli_num_rows($exec15);

                  if($res15 != ''){
                    $bedcapacity = $res15;
                  } else {
                    $bedcapacity = 0;
                  }
                ?>
                <?php 
                  $totaldays = 0;
                  $totalday = 0;
                  $totalbeddays = 0;
                  $totalbedday = 0;
                  $totalwarddays = 0;
                  $totalwardbeddays = 0;
                  $totalpatients = 0;

                  $query112 = "select * from master_location";
                  $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res112 = mysqli_fetch_array($exec112);

                  $locationcode1 = $res112['locationcode'];


                  $ward = '';
                  if($ward == ''){
                  $query56 = "select auto_number, ward from master_ward where locationcode = '$locationcode1' and recordstatus <> 'deleted' and auto_number <> '12'";
                  } else {
                  $query56 = "select auto_number, ward from master_ward where auto_number = '$ward' and locationcode = '$locationcode1' and recordstatus <> 'deleted' and auto_number <> '12'";
                  }
                  $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($res56 = mysqli_fetch_array($exec56))
                  {
                  $ward = $res56['auto_number'];
                  $wardname = $res56['ward'];
                  
                  $totalwarddays = 0;
                  $totalwardbeddays = 0;
                  $patients = 0;
                  
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
                      <?php 
                  if($ward == ''){
                    $querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  } else {
                  $querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw1=mysqli_num_rows($execnw1);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw=mysqli_fetch_array($execnw1))
                  { 
                    $patientcode=$getmw['patientcode'];
                    $visitcode=$getmw['visitcode'];
                    $res2consultationdate=$getmw['recorddate'];
                    $admissiondate = $getmw['recorddate'];
                    
                  $query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                  $res02=mysqli_fetch_array($exec02);
                  
                  $patientname=$res02['patientfullname'];
                   $gender=$res02['gender'];
                
                      $query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res751 = mysqli_fetch_array($exec751);
                $dob = $res751['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num3=mysqli_num_rows($exec3);
                  $res3 = mysqli_fetch_array($exec3);
                  
                  $res3recorddate=$res3['recorddate'];
                  $dischargedate = $res3['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num3 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($admissiondate);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  
                  }
                  
                  if($ward == ''){
                    $querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  } else {
                  $querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw1=mysqli_num_rows($execnw1);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw=mysqli_fetch_array($execnw1))
                  { 
                    $patientcode=$getmw['patientcode'];
                    $visitcode=$getmw['visitcode'];
                    
                    $query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode' and ward <> '12'");
                    $getrd=mysqli_fetch_array($query1);
                    
                    $res2consultationdate=$getrd['recorddate'];
                    $admissiondate = $getrd['recorddate'];
                    
                  $query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                  $res02=mysqli_fetch_array($exec02);
                  
                  $patientname=$res02['patientfullname'];
                   $gender=$res02['gender'];
                
                      $query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res751 = mysqli_fetch_array($exec751);
                $dob = $res751['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num3=mysqli_num_rows($exec3);
                  $res3 = mysqli_fetch_array($exec3);
                  
                  $res3recorddate=$res3['recorddate'];
                  $dischargedate = $res3['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num3 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($admissiondate);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  }
                  
                     if($ward == ''){
                    $querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge') and ward <> '12'";
                  } else {
                  $querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge') and ward <> '12'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw2=mysqli_num_rows($execnw2);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw2=mysqli_fetch_array($execnw2))
                  { 
                    $patientcode=$getmw2['patientcode'];
                    $visitcode=$getmw2['visitcode'];
                    $res2consultationdate=$getmw2['recorddate'];
                    $admissiondate = $getmw2['recorddate'];
                    
                
                  $query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec021=mysqli_query($GLOBALS["___mysqli_ston"], $query021);
                  $res021=mysqli_fetch_array($exec021);
                  
                  $patientname=$res021['patientfullname'];
                   $gender=$res021['gender'];
                
                      $query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec752 = mysqli_query($GLOBALS["___mysqli_ston"], $query752) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res752 = mysqli_fetch_array($exec752);
                $dob = $res752['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num31=mysqli_num_rows($exec31);
                  $res31 = mysqli_fetch_array($exec31);
                  
                  $res31recorddate=$res31['recorddate'];
                  $dischargedate = $res31['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num31 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($ADate1);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  }
                  
                  if($ward == ''){
                    $querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";
                  } else {
                  $querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw2=mysqli_num_rows($execnw2);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw2=mysqli_fetch_array($execnw2))
                  { 
                    $patientcode=$getmw2['patientcode'];
                    $visitcode=$getmw2['visitcode'];
                    
                    $query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
                    $getrd=mysqli_fetch_array($query1);
                    
                    $res2consultationdate=$getrd['recorddate'];
                    $admissiondate = $getrd['recorddate'];
                    
                    
                  $query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec021=mysqli_query($GLOBALS["___mysqli_ston"], $query021);
                  $res021=mysqli_fetch_array($exec021);
                  
                  $patientname=$res021['patientfullname'];
                   $gender=$res021['gender'];
                
                      $query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec752 = mysqli_query($GLOBALS["___mysqli_ston"], $query752) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res752 = mysqli_fetch_array($exec752);
                $dob = $res752['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num31=mysqli_num_rows($exec31);
                  $res31 = mysqli_fetch_array($exec31);
                  
                  $res31recorddate=$res31['recorddate'];
                  $dischargedate = $res31['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num31 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($ADate1);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  }
                  
                  if($ward == ''){
                    $querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge') and ward <> '12'";
                  } else {
                  $querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge') and ward <> '12'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw8=mysqli_num_rows($execnw8);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw8=mysqli_fetch_array($execnw8))
                  { 
                    $patientcode=$getmw8['patientcode'];
                    $visitcode=$getmw8['visitcode'];
                    $res2consultationdate=$getmw8['recorddate'];
                    $admissiondate = $getmw8['recorddate'];
                    
                
                  $query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec081=mysqli_query($GLOBALS["___mysqli_ston"], $query081);
                  $res081=mysqli_fetch_array($exec081);
                  
                  $patientname=$res081['patientfullname'];
                   $gender=$res081['gender'];
                
                      $query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec758 = mysqli_query($GLOBALS["___mysqli_ston"], $query758) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res758 = mysqli_fetch_array($exec758);
                $dob = $res758['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num33=mysqli_num_rows($exec33);
                  $res33 = mysqli_fetch_array($exec33);
                  
                  $res33recorddate=$res33['recorddate'];
                  $dischargedate = $res33['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num33 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($admissiondate);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                   }
                  
                  if($ward == ''){
                    $querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";
                  } else {
                  $querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw8=mysqli_num_rows($execnw8);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw8=mysqli_fetch_array($execnw8))
                  { 
                    $patientcode=$getmw8['patientcode'];
                    $visitcode=$getmw8['visitcode'];
                    
                    $query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
                    $getrd=mysqli_fetch_array($query1);
                    
                    $res2consultationdate=$getrd['recorddate'];
                    $admissiondate = $getrd['recorddate'];
                    
                    
                  $query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec081=mysqli_query($GLOBALS["___mysqli_ston"], $query081);
                  $res081=mysqli_fetch_array($exec081);
                  
                  $patientname=$res081['patientfullname'];
                  $gender=$res081['gender'];
                      
                  $query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                  $exec758 = mysqli_query($GLOBALS["___mysqli_ston"], $query758) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res758 = mysqli_fetch_array($exec758);
                  $dob = $res758['dateofbirth'];
                  
                  $today = new DateTime();
                  $diff = $today->diff(new DateTime($dob));
                    
                  if ($diff->y)
                  {
                  $age= $diff->y . ' Years';
                  }
                  elseif ($diff->m)
                  {
                  $age =$diff->m . ' Months';
                  }
                  else
                  {
                  $age =$diff->d . ' Days';
                  }
                
                  $query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num33=mysqli_num_rows($exec33);
                  $res33 = mysqli_fetch_array($exec33);
                  
                  $res33recorddate=$res33['recorddate'];
                  $dischargedate = $res33['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num33 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($admissiondate);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                   }
                  
                  if($ward == ''){
                    $querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward <> '12'";
                  } else {
                  $querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge') and ward <> '12'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw3=mysqli_num_rows($execnw3);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw3=mysqli_fetch_array($execnw3))
                  {
                    $patientcode=$getmw3['patientcode'];
                    $visitcode=$getmw3['visitcode'];
                    $res2consultationdate=$getmw3['recorddate'];
                    $admissiondate = $getmw3['recorddate'];
                    
                
                  $query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
                  $res022=mysqli_fetch_array($exec022);
                  
                  $patientname=$res022['patientfullname'];
                   $gender=$res022['gender'];
                
                      $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res753 = mysqli_fetch_array($exec753);
                $dob = $res753['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num311=mysqli_num_rows($exec311);
                  $res311 = mysqli_fetch_array($exec311);
                  
                  $res311recorddate=$res311['recorddate'];
                  $dischargedate = $res311['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num311 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($ADate1);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  }
                  
                  if($ward == ''){
                    $querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
                  } else {
                  $querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
                  }
                  $execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $resnw3=mysqli_num_rows($execnw3);
                    
                  $formvar='';
                  $i1=0;      
                  while($getmw3=mysqli_fetch_array($execnw3))
                  {
                    $patientcode=$getmw3['patientcode'];
                    $visitcode=$getmw3['visitcode'];
                    
                    $query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
                    $getrd=mysqli_fetch_array($query1);
                    
                    $res2consultationdate=$getrd['recorddate'];
                    $admissiondate = $getrd['recorddate'];
                    
                    
                  $query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
                  $res022=mysqli_fetch_array($exec022);
                  
                  $patientname=$res022['patientfullname'];
                   $gender=$res022['gender'];
                

                      $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
                $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res753 = mysqli_fetch_array($exec753);
                $dob = $res753['dateofbirth'];
                  
                    $today = new DateTime();
                    $diff = $today->diff(new DateTime($dob));
                    
                    if ($diff->y)
                    {
                    $age= $diff->y . ' Years';
                    }
                    elseif ($diff->m)
                    {
                    $age =$diff->m . ' Months';
                    }
                    else
                    {
                    $age =$diff->d . ' Days';
                    }
                
                  $query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num311=mysqli_num_rows($exec311);
                  $res311 = mysqli_fetch_array($exec311);
                  
                  $res311recorddate=$res311['recorddate'];
                  $dischargedate = $res311['recorddate'];
                  $ll = 0;
                  if(strtotime($dischargedate)>strtotime($ADate2))
                  { 
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                  if($num311 == 0)
                  {
                    $ll = 1;
                    $dischargedate= $ADate2;
                  }
                        
                  $registrationdate   = strtotime($ADate1);
                  $dischargedate1 = strtotime($dischargedate);
                  $today = date('Y-m-d');
                  $today1 = strtotime($today);
                  $totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
                  $totaldays = ceil(($today1 - $registrationdate) / 86400);
                  if($totaldays == 0)
                  {
                  $totaldays = 1;
                  }
                  else
                  {
                  $totaldays = $totaldays + 1;
                  }
                  if($totalbeddays == 0)
                  {
                  $totalbeddays = 1;
                  }
                  else
                  {
                  $totalbeddays = $totalbeddays + 1;
                  }
                  $totalday +=$totaldays;
                  $totalbedday +=$totalbeddays;
                  $totalwarddays += $totaldays;
                  $totalwardbeddays += $totalbeddays;
                  $patients += 1;
                  $totalpatients += 1;
                  }
                }

                if($totalpatients > 0) { $avgstay= $totalbedday/$totalpatients ; } else { $avgstay = '0.00'; } 
              ?>
          <td class="bodytext31" valign="center" align="left">BED CAPACITY</td>
          <td class="bodytext31" valign="center" align="center"><?php echo number_format($bedcapacity); ?></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <td class="bodytext31" valign="center" align="left">BED DAYS</td>
          <td class="bodytext31" valign="center" align="center"><?php echo $totalbedday; ?></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <td class="bodytext31" valign="center" align="left">PATIENT DAYS</td>
          <td class="bodytext31" valign="center" align="center"><?php echo $totalday; ?></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <td class="bodytext31" valign="center" align="left">ALOS</td>
          <td class="bodytext31" valign="center" align="center"><?php echo number_format($avgstay); ?></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <td class="bodytext31" valign="center" align="left">A.R.P.O.B</td>
          <td class="bodytext31" valign="center" align="center"><?php  ?></td>
        </tr>
        <tr>
          <td class="border3hide"></td>
          <td class="bodytext31" valign="center" align="left">OCCUPANCY</td>
          <td class="bodytext31" valign="center" align="center"><?php  ?></td>
        </tr>
        </table>
      </td>
	</tr>

	<?php
	 
              $query1 = "select misreport from master_accountname where recordstatus <> 'deleted' group by misreport";
              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res1 = mysqli_fetch_array($exec1)){
                $totalopd = $totalip = 0;
                $paymentcode = $res1['misreport'];  
                if($paymentcode == '0'){
                  continue;
                } else if ($paymentcode == '1'){
                  $paymenttype = "NHIF CAPITATION";
                  $totalip = totalipd($paymentcode, $ADate1, $ADate2);
                  $fulltotalip += $totalip;
                } else if ($paymentcode == '2'){
                  $paymenttype = "AON CAPITATION";
                  $totalip = totalipd($paymentcode, $ADate1, $ADate2);
                  $fulltotalip += $totalip;
                } else if ($paymentcode == '3'){
                  $paymenttype = "CASH";
                  $ipcashdiscount = getIpCashDiscount($ADate1, $ADate2);
                  $totalip = totalipd($paymentcode, $ADate1, $ADate2) - $ipcashdiscount;
                  $fulltotalip += $totalip;
                } else if ($paymentcode == '4'){
                  $paymenttype = "NHIF";
                  $totalip = totalipd($paymentcode, $ADate1, $ADate2);
                  $fulltotalip += $totalip;
                } else if ($paymentcode == '5'){
                  $paymenttype = "OTHER FFS";
                  $totalip = totalipd($paymentcode, $ADate1, $ADate2);
                  $fulltotalip += $totalip;
                }
                $totalopd = totalopd($paymentcode, $ADate1, $ADate2);
                $totalopdrefund = getRefund($ADate1, $ADate2);
                $fulltotalopd += $totalopd;

                $ipcreditdiscount = getIpCreditDiscount($ADate1, $ADate2);

                $grandtotal = $totalip + $totalopd;
                $fulltotalgrandtotal += $grandtotal; 


                $query5 = "select count(master_visitentry.accountname) as count, A.misreport FROM `master_visitentry` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = master_visitentry.accountfullname where A.misreport = '$paymentcode' and (master_visitentry.consultationdate BETWEEN '$ADate1' and '$ADate2')";
                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res5 = mysqli_fetch_array($exec5)){
                  $opcount = $res5['count'];
                  $oppaymentcode1 = $res5['misreport'];

                  if($oppaymentcode1 == $paymentcode){
                    $opvisit = $opcount;
                    $fulltotalopvisit += $opvisit;
                  } else {
                    $opvisit = 0;
                  }
                }

                $query6 = "select count(ip_bedallocation.accountname) as count, master_accountname.misreport from ip_bedallocation join master_accountname ON ip_bedallocation.accountname = master_accountname.accountname where (ip_bedallocation.recorddate BETWEEN '$ADate1' AND '$ADate2') and master_accountname.misreport = '$paymentcode' and ip_bedallocation.ward != '12'";
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

                $query7 = "select count(ip_discharge.accountname) as count, master_accountname.misreport from ip_discharge join master_accountname ON ip_discharge.accountname = master_accountname.accountname where (ip_discharge.recorddate BETWEEN '$ADate1' AND '$ADate2') and master_accountname.misreport = '$paymentcode'";
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res7 = mysqli_fetch_array($exec7)){
                  $dischargecount0 = $res7['count'];
                  $dischargepaymentcode = $res7['misreport'];

                  if($dischargepaymentcode == $paymentcode){
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
                  if($fulltotalip != '0' && $fulltotaladmissioncount != '0'){
                    $totalarperip = $fulltotalip / $fulltotaladmissioncount;
                  } else {
                    $totalarperip = 0;
                  }  
                } else {
                  $arperip = 0;
                }

        $colorcode = 'bgcolor="#ffffff"';
    ?>
    <tr <?php echo $colorcode; ?>>
	    <td class="bodytext31" valign="center"  align="left"><?php echo $paymenttype; ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($totalip, 2); ?></td> 
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($totalopd, 2); ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($grandtotal, 2); ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($opvisit); ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($arpopd); ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($dischargecount); ?></td>
	    <td class="bodytext31" valign="center"  align="center"><?php echo number_format($arperip); ?></td>
      <td class="bodytext31" valign="center"  align="center"><?php echo number_format($admissioncount); ?></td>
	  </tr>

	<?php
	  } 
	?>	
  <tr>
    <td class="bodytext31" valign="center" bgcolor="#ffffff" align="left"><strong><?php echo "TOTAL" ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff" align="center"><strong><?php echo number_format($fulltotalip - $ipcreditdiscount, 2); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($fulltotalopd - $totalopdrefund, 2); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($fulltotalgrandtotal - ($ipcreditdiscount + $totalopdrefund), 2); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($fulltotalopvisit); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($totalarpopd); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($fulltotaldischargecount); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($totalarperip); ?></strong></td>
    <td class="bodytext31" valign="center" bgcolor="#ffffff"  align="center"><strong><?php echo number_format($fulltotaladmissioncount); ?></strong></td>
  </tr> 
</table>

<table style="border-collapse:collapse;" align="left" border="1">
  <tr><td class="border2hide" colspan="25"><br></td></tr>
  <tr bgcolor="#ecf0f5">
    <col  width="90"><td class="bodytext31" valign="middle" align="center" rowspan="3"><strong>Account Name</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>NHIF CAPITATION</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>AON CAPITATION</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>CASH</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>NHIF</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>FREE FOR SERVICE</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="4"><strong>TOTAL</strong></td> 
  </tr>
  <tr bgcolor="#ecf0f5">
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>OPD</strong></td> 
    <td class="bodytext31" valign="center" align="center" colspan="2"><strong>IPD</strong></td>
  </tr>

  <tr bgcolor="#ecf0f5">
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="45"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="50"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
    <col width="23"><td class="bodytext31" valign="center" align="center"><strong>Nos</strong></td> 
    <col width="50"><td class="bodytext31" valign="center" align="center"><strong>Revenue</strong></td> 
  </tr>

                <?php
                $miscode = '';

                $aoncapopdnos = $aoncapopdrevenue = $aoncapipdnos = $aoncapipdrevenue = 0;
                $nhifcapopdnos = $nhifcapopdrevenue = $nhifcapipdnos = $nhifcapipdrevenue = 0;
                $cashopdnos = $cashopdrevenue = $cashipdnos = $cashipdrevenue = 0;
                $nhifopdnos = $nhifopdrevenue = $nhifipdnos = $nhifipdrevenue = 0;
                $ffsopdnos = $ffsopdrevenue = $ffsipdnos = $ffsipdrevenue = 0;
                $sumaoncapopdnos = $sumaoncapopdrevenue = $sumaoncapipdnos = $sumaoncapipdrevenue = 0;
                $sumnhifcapopdnos = $sumnhifcapopsrevenue = $sumnhifcapipdnos = $sumnhifcapipdrevenue = 0;
                $sumcashopdnos = $sumcashopdrevenue = $sumcashipdnos = $sumcashiprevenue = 0;
                $sumnhifopdnos = $sumnhifopdrevenue = $sumnhifipdnos = $sumnhifipdrevenue = 0;
                $sumffsopdnos = $sumffsopdrevenue = $sumffsipdnos = $sumffsipdrevenue = 0;
                $sumtotalopdnos = $sumtotalopdrevenue = $sumtotalipdnos = $sumtotalipdrevenue = 0;

                $query41 = "select * from mis_accountname";
                $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res41 = mysqli_fetch_array($exec41)){
                  $account = $res41['accountname'];
                  $misautono = $res41['auto_number'];
                

                $query42= "select misreport from master_accountname where recordstatus <> 'deleted' group by misreport";
                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res42 = mysqli_fetch_array($exec42)){
                  $miscode = $res42['misreport'];

                  //AMBULANCE SERVICES INCOME
                if($misautono == 1){
                  $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;

                  $query47 = "select sum(amount) as count from (
                  select count(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
                  UNION ALL
                  select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                  select sum(billing_ipambulance.amountuhx) as amount, A.misreport FROM `billing_ipambulance` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipambulance.accountname where A.misreport = '$miscode' and (billing_ipambulance.recorddate BETWEEN '$ADate1' and '$ADate2')
                  UNION ALL
                  select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(count) as count from (
                  select count(billing_opambulance.amount) as count, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2')
                  UNION ALL
                  select count(billing_paynowservices.fxamount) as count, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                  select sum(billing_opambulance.amount) as amount, master_accountname.misreport from billing_opambulance JOIN master_accountname ON billing_opambulance.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_opambulance.recorddate between '$ADate1' and '$ADate2') 
                  UNION ALL
                  select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'AMBULANCE' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }

                  //BED CHARGES INCOME
                } else if($misautono == 2){
                  $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                  $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
                  $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

                  $query44 = "select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }


                  $query43 = "select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'bed charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }
                  
                //CT SCAN INCOME
                } else if($misautono == 3) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'CT SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }
                  
                //DENTAL INCOME
                } else if($misautono == 4) {
                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dental' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dental' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }


                  $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }

                  $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Dental' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }

                  //DIALYSIS INCOME
                } else if($misautono == 5) {
                  $totalipdnos = $aoncapipdnos = $nhifcapipdnos = $cashipdnos = $nhifipdnos = $ffsipdnos = 0;
                  $sumtotalipdnos = $sumaoncapipdnos = $sumnhifcapipdnos = $sumcashipdnos = $sumnhifipdnos = $sumffsipdnos = 0;

                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dialysis' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                     SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dialysis' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Dialysis' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                     SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Dialysis' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }

                //DOCTOR CONSULTATION FEES
                } else if($misautono == 6) {
                  $query50 = "select sum(count) as count from ( 
                   SELECT count(billing_consultation.consultation) as count, master_accountname.misreport FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2') 
                   UNION ALL
                   SELECT count(billing_paylaterconsultation.fxamount) as count, A.misreport FROM `billing_paylaterconsultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterconsultation.accountname where A.misreport = '$miscode' and (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from ( 
                   SELECT sum(billing_consultation.consultation) as amount, A.misreport FROM `billing_consultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_consultation.accountname where A.misreport = '$miscode' and (billing_consultation.billdate BETWEEN '$ADate1' and '$ADate2')
                   UNION ALL
                   SELECT sum(billing_paylaterconsultation.fxamount) as amount, A.misreport FROM `billing_paylaterconsultation` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterconsultation.accountname where A.misreport = '$miscode' and (billing_paylaterconsultation.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }

                    $query12 = "select sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2'";
                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res12 = mysqli_fetch_array($exec12);
                    $res12refundconsultation = $res12['consultation1'];

                    $query12c = "select sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'  ";
                    $exec12c = mysqli_query($GLOBALS["___mysqli_ston"], $query12c) or die ("Error in Query12c".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res12c = mysqli_fetch_array($exec12c);
                    $res12crefundconsultation = $res12c['consultation1'];

                    $query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' ";
                    $exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res121 = mysqli_fetch_array($exec121);
                    $res12refundconsultation1 = $res121['consultation1'];

                    $res12refundconsultation = $res12refundconsultation + $res12crefundconsultation + $res12refundconsultation1;

                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue - $res12refundconsultation;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }

                  $query49 = "select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Consultant Fee' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }

                  $query48 = "select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Consultant Fee' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }

                  //ECHO SERVICES INCOME
                 } else if($misautono == 7) {
                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Echo' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }


                  $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Echo' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }

                  $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Echo' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }

                  //ENDOSCOPY INCOME
                  } else if($misautono == 8) {
                    $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Endoscopy' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Endoscopy' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Endoscopy' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }


                  //LABORATORY INCOME
                 } else if($misautono == 9) {

                  $query50 = "select sum(amount) as count from (
                    select count(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
                    UNION ALL
                    SELECT count(billing_paylaterlab.fxamount) as amount, A.misreport FROM `billing_paylaterlab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterlab.accountname where A.misreport = '$miscode' and (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                  }

                  $query51 = "select sum(amount) as amount from (
                    select sum(billing_paynowlab.fxamount) as amount, master_accountname.misreport from billing_paynowlab JOIN master_accountname ON billing_paynowlab.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowlab.billdate between '$ADate1' and '$ADate2') and billing_paynowlab.accountname = 'CASH - HOSPITAL'
                    UNION ALL
                    SELECT sum(billing_paylaterlab.fxamount) as amount, A.misreport FROM `billing_paylaterlab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterlab.accountname where A.misreport = '$miscode' and (billing_paylaterlab.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }

                    $query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2'";
                    $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res19 = mysqli_fetch_array($exec19) ;
                    $res19refundlabitemrate = $res19['labitemrate1'];
                    $query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2'";
                    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res20 = mysqli_fetch_array($exec20) ;
                    $res20refundlabitemrate = $res20['labitemrate1'];

                    $query222 = "select sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
                    $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res222 = mysqli_fetch_array($exec222) ;
                    $res20refundlabitemrate1 = $res222['amount1'];

                    $totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate+$res20refundlabitemrate1;

                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue - $totalrefundlab;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }


                  $query49 = "select count(billing_iplab.rateuhx) as count, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')";
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(billing_iplab.rateuhx) as amount, A.misreport FROM `billing_iplab` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iplab.accountname where A.misreport = '$miscode' and (billing_iplab.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }

                  //MEDICAL GASES INCOME
                } else if($misautono == 10) {
                    $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                    $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
                    $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

                    $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Gases Administration' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Gases Administration' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }


                //MEDICINE INCOME
                } else if($misautono == 11) {
                  $query47 = "select count(billing_ippharmacy.amountuhx) as count, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where A.misreport = '$miscode' and (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowpharmacy.fxamount) as amount, master_accountname.misreport from billing_paynowpharmacy JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterpharmacy.fxamount) as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where A.misreport = '$miscode' and (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowpharmacy.fxamount) as amount, master_accountname.misreport from billing_paynowpharmacy JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname where master_accountname.misreport='$miscode' and (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterpharmacy.fxamount) as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where A.misreport = '$miscode' and (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }

                    $query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2'";
                    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res21 = mysqli_fetch_array($exec21) ;
                    $res21refundlabitemrate = $res21['amount1'];
                    $query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2'";
                    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res22 = mysqli_fetch_array($exec22) ;
                    $res22refundlabitemrate = $res22['amount1'];

                    $query221 = "select sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
                    $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res221 = mysqli_fetch_array($exec221) ;
                    $res22refundlabitemrate1 = $res221['amount1'];

                    $query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
                    $exec21p = mysqli_query($GLOBALS["___mysqli_ston"], $query21p) or die ("Error in Query21p".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res21p = mysqli_fetch_array($exec21p) ;
                      $res21prefundlabitemrate = $res21p['amount1'];

                    $totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate + $res22refundlabitemrate1 + $res21prefundlabitemrate;

                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue - $totalrefundpharmacy;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }

                //MINOR PROCEDURE INCOME
                } else if($misautono == 12) {
                  $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Ent Minor Procedure' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select sum(amount) as count from (
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obsgyne Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 =  "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obsgyne Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Minor Procedure' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }

                //MORTURY INCOME
                } else if($misautono == 13) {
                  $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paylaterservices.fxamount) as amount, master_accountname.misreport from billing_paylaterservices JOIN master_accountname ON billing_paylaterservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paylaterservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_paylaterservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Mortury' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'MORTUARY' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'MORTUARY' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }
                
                //MRI INCOME
                } else if($misautono == 14) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MRI SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'MAGNETIC RESONANCE IMAGING' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }
                  
                //NURSING CARE INCOME
                } else if($misautono == 15) {
              $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
              $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
              $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

              $query52 = "select count(billing_ipbedcharges.amountuhx) as count, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";

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
                    }
                $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
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
                    }
                $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
              }


            // //OPD REGISTRATION FEE  
            } else if($misautono == 16) {
                $totalopdnos = $totalopdrevenue = $totalipdnos = $totalipdrevenue = 0;
                $aoncapopdnos = $nhifcapopdnos = $cashopdnos = $nhifopdnos = $ffsopdnos = 0;
                $aoncapopdrevenue = $nhifcapopdrevenue = $cashopdrevenue = $nhifopdrevenue = $ffsopdrevenue = 0;

                $query49 = "select count(billing_ipadmissioncharge.amountuhx) as count, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2')";
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
                    }
                  $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                  $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                }
               

                $query48 = "select sum(billing_ipadmissioncharge.amountuhx) as amount, A.misreport FROM `billing_ipadmissioncharge` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipadmissioncharge.accountname where A.misreport = '$miscode' and (billing_ipadmissioncharge.recorddate BETWEEN '$ADate1' and '$ADate2')";
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
                    }
                  $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                  $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                }

              //OPTICAL REVENUE
            } else if($misautono == 17) {
                $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                       SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                       SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Optical Services' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Optical Services' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }

                 //OT SERVICES REVENUE
                } else if($misautono == 18) {
                    $query50 = "select sum(amount) as count from (
                       select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'General Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
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
                      }
                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select sum(amount) as count from (
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obs Gynae Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'General Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Obs Gynae Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Orthopedic Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }

               //PHYSIOTHERAPY INCOME
              } else if($misautono == 19) {
                $query50 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Physio' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }
                      $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                      $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;
                    }

                    $query51 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_accountname.misreport='$miscode' and master_services.categoryname = 'Physio' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                      }

                      $query24 = "select sum(fxamount)as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2'";
                      $exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
                      $res24 = mysqli_fetch_array($exec24) ;
                      $res24refundserviceitemrate = $res24['servicesitemrate1'];
                      $query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2'";
                      $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
                      $res25 = mysqli_fetch_array($exec25) ;
                      $res25refundserviceitemrate = $res25['servicesitemrate1'];

                      $query225 = "select sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
                      $exec225 = mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die ("Error in Query225".mysqli_error($GLOBALS["___mysqli_ston"]));
                      $res225 = mysqli_fetch_array($exec225) ;
                      $res25refundserviceitemrate1 = $res225['amount1'];

                      $totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate + $res25refundserviceitemrate1;

                      $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue - $totalrefundservice;
                      $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                    }


                    $query49 = "select count(billing_ipservices.servicesitemrateuhx) as count, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                      $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                    }

                    $query48 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Physio' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

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
                      }
                      $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                      $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                    }



                //ULTRA SOUND INCOME
                } else if($misautono == 20) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'ULTRA SOUND SCAN' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }

                    $query22 = "select sum(fxamount)as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2'";
                    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res22 = mysqli_fetch_array($exec22) ;
                    $res22refundradioitemrate = $res22['radiologyitemrate1'];
                    $query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'";
                    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res23 = mysqli_fetch_array($exec23) ;
                    $res23refundradioitemrate = $res23['radiologyitemrate1'];

                    $query223 = "select sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
                    $exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res223 = mysqli_fetch_array($exec223) ;
                    $res23refundradioitemrate1 = $res223['amount1'];

                    $totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate+$res23refundradioitemrate1;

                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue - $totalrefundradio;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
                  }

                //X RAY INCOME
                } else if($misautono == 21) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                    select count(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                    select sum(billing_paynowradiology.fxamount) as amount, master_accountname.misreport from billing_paynowradiology JOIN master_accountname ON billing_paynowradiology.accountname = master_accountname.accountname JOIN master_radiology ON billing_paynowradiology.radiologyitemcode = master_radiology.itemcode where master_accountname.misreport='$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paynowradiology.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'XRAY' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;

                  } 

                  //OTHER INCOMES
                  } else if($misautono == 22) {
                  $query47 = "select sum(amount) as count from (
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'COMPUTERIZED TOMOGRAPHY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_ipprivatedoctor.amountuhx) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT count(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Resident Doctor Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL 
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'RMO Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where A.misreport = '$miscode' and billing_ipbedcharges.description = 'Daily Review charge' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select count(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport = '$miscode' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdnos = $aoncapipdnos + $nhifcapipdnos + $cashipdnos + $nhifipdnos + $ffsipdnos;
                    $sumtotalipdnos = $sumaoncapipdnos + $sumnhifcapipdnos + $sumcashipdnos + $sumnhifipdnos + $sumffsipdnos;
                  }
                

                  $query48 = "select sum(amount) as amount from (
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipradiology.radiologyitemrateuhx) as amount, A.misreport FROM `billing_ipradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipradiology.accountname JOIN master_radiology ON billing_ipradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'COMPUTERIZED TOMOGRAPHY' and (billing_ipradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_iphomecare.amount) as amount, A.misreport FROM `billing_iphomecare` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_iphomecare.accountname where A.misreport = '$miscode' and (billing_iphomecare.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipprivatedoctor.amountuhx) as amount, A.misreport FROM `billing_ipprivatedoctor` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipprivatedoctor.accountname where A.misreport = '$miscode' and billing_ipprivatedoctor.billtype <> '' and (billing_ipprivatedoctor.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_ipmiscbilling.amount) as amount, A.misreport FROM `billing_ipmiscbilling` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipmiscbilling.accountname where A.misreport = '$miscode' and (billing_ipmiscbilling.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalipdrevenue = $aoncapipdrevenue + $nhifcapipdrevenue + $cashipdrevenue + $nhifipdrevenue + $ffsipdrevenue;
                    $sumtotalipdrevenue = $sumaoncapipdrevenue + $sumnhifcapipdrevenue + $sumcashiprevenue + $sumnhifipdrevenue + $sumffsipdrevenue;
                  }


                  $query46 = "select sum(amount) as count from (
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select count(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select count(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                       UNION ALL
                       SELECT count(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdnos = $aoncapopdnos + $nhifcapopdnos + $cashopdnos + $nhifopdnos + $ffsopdnos;
                    $sumtotalopdnos = $sumaoncapopdnos + $sumnhifcapopdnos + $sumcashopdnos + $sumnhifopdnos + $sumffsopdnos;

                  }

                  $query45 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'IP SERVICES' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON billing_paynowservices.servicesitemcode = master_services.itemcode where master_accountname.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL 
                      select sum(billing_paynowreferal.fxamount) as amount, master_accountname.misreport from billing_paynowreferal JOIN master_accountname ON billing_paynowreferal.accountname = master_accountname.accountname where master_accountname.misreport = '$miscode' and (billing_paynowreferal.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterradiology.fxamount) as amount, A.misreport FROM `billing_paylaterradiology` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterradiology.accountname JOIN master_radiology ON billing_paylaterradiology.radiologyitemcode = master_radiology.itemcode where A.misreport = '$miscode' and master_radiology.categoryname = 'RAD-OTHERS' and (billing_paylaterradiology.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Mo Pocedures' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where A.misreport = '$miscode' and master_services.categoryname = 'Last Office' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
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
                    }
                    $totalopdrevenue = $aoncapopdrevenue + $nhifcapopdrevenue + $cashopdrevenue + $nhifopdrevenue + $ffsopdrevenue;
                    $sumtotalopdrevenue = $sumaoncapopdrevenue + $sumnhifcapopsrevenue + $sumcashopdrevenue + $sumnhifopdrevenue + $sumffsopdrevenue;
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

                  
                    $colorcode = 'bgcolor="#ffffff"';

                    
              ?>
  <tr <?php echo $colorcode ?> >
    <td class="bodytext4" valign="middle" align="left"><?php echo strtoupper($account); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($aoncapopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($aoncapopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($aoncapipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($aoncapipdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifcapopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifcapopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifcapipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifcapipdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($cashopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($cashopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($cashipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($cashipdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($nhifipdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($ffsopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($ffsopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($ffsipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($ffsipdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($totalopdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($totalopdrevenue); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($totalipdnos); ?></td>
    <td class="bodytext4" valign="middle" align="center"><?php echo number_format($totalipdrevenue); ?></td>
  </tr>
  <?php
      
      $totalopdrefund = getRefund($ADate1, $ADate2);

      $ipcashdisc = getIpCashDiscount($ADate1, $ADate2);
      $ipcreditdisc = getIpCreditDiscount($ADate1, $ADate2);

   }
  ?>

  <tr bgcolor="#ffffff" >
    <td class="bodytext31" valign="center" align="left"><strong>TOTAL</strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumaoncapopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumaoncapopdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumaoncapipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumaoncapipdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifcapopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifcapopsrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifcapipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifcapipdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumcashopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumcashopdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumcashipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumcashiprevenue - $ipcashdisc); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifopdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumnhifipdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumffsopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumffsopdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumffsipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumffsipdrevenue); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumtotalopdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumtotalopdrevenue - $totalopdrefund); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumtotalipdnos); ?></strong></td>
    <td class="bodytext4" valign="center" align="center"><strong><?php echo number_format($sumtotalipdrevenue - $ipcashdisc - $ipcreditdisc); ?></strong></td>
  </tr>
</table>

<?php

$content = ob_get_clean();

// convert in PDF
try
{
    $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('print_misreport.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
