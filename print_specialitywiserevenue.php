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


$snocount = "";
$colorloopcount="";
$range = "";
$admissiondate = "";
$ipnumber = "";
$patientname = "";
$gender = "";
$admissiondoc = "";
$consultingdoc = "";
$companyname = "";
$bedno = "";
$dischargedate = "";
$wardcode = "";

if (isset($_REQUEST["wardcode"])) { $wardcode = $_REQUEST["wardcode"]; } else { $wardcode = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if (isset($_REQUEST["departmentcode"])) { $departmentcode = $_REQUEST["departmentcode"]; } else { $departmentcode = ""; }
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


$currentdate = date('d/m/Y H:i:s');


function getOpd($ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Dental' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dental' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Ent Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                     SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where  master_services.categoryname = 'Ent Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowpharmacy.fxamount) as amount, master_accountname.misreport from billing_paynowpharmacy JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname where (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterpharmacy.fxamount) as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'General Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'General Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'General Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Dialysis' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dialysis' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Dialysis' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Optical Services' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                       SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Optical Services' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Optical Services' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Neurosurgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Neurosurgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Neurosurgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Physio' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Physio' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

      $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
      $res48 = mysqli_fetch_array($exec48);
      
      return $res48['amount'];
}


function getIpd($ADate1, $ADate2){
    $query48 = "select sum(amount) as amount from (
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dental' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ent Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'General Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dialysis' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Optical Services' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Neurosurgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    UNION ALL
                    select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Physio' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                ) as amount1";

      $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
      $res48 = mysqli_fetch_array($exec48);
      
      return $res48['amount'];
}

?>
<style type="text/css">
<!--
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
		<td class="bodytext31"  valign="middle"  align="left" ><strong>Specialitywise Revenue Report From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
      	<tr>
          <col width="200"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>SPECIALITY</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>OPD</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>IPD</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>TOTAL</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>OPD %</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>IPD %</strong></td>
          <col width="85"><td align="center" valign="center"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>TOTAL %</strong></td>
        </tr>
          
        <?php
        $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
        $totalopd = $totalipd = $overalltotal = 0;
        $sumopd = $sumipd = $sumtotal = 0;

        if($departmentcode == ''){
          $query5 = "select * from mis_specialities";  
        } else {
          $query5 = "select * from mis_specialities where auto_number = '$departmentcode'";
        }

        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res5 = mysqli_fetch_array($exec5)){
          $res5deparmentname = $res5['speciality'];
          $res5auto_number = $res5['auto_number'];

          //ANC CLINICS
          if($res5auto_number == 1){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
          
          //DENTAL 
          } else if ($res5auto_number == 2){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Dental' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dental' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dental' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //DIETITICS
          } else if ($res5auto_number == 3){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
          
          //ENT SURGERY
          } else if ($res5auto_number == 4){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                    select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Ent Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                     SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where  master_services.categoryname = 'Ent Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                        ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ent Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //GENERAL MEDICINE
          } else if ($res5auto_number == 5){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                    select sum(billing_paynowpharmacy.fxamount) as amount, master_accountname.misreport from billing_paynowpharmacy JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname where (billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2')
                    UNION ALL
                    SELECT sum(billing_paylaterpharmacy.fxamount) as amount, A.misreport FROM `billing_paylaterpharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterpharmacy.accountname where (billing_paylaterpharmacy.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(billing_ippharmacy.amountuhx) as amount, A.misreport FROM `billing_ippharmacy` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ippharmacy.accountname where (billing_ippharmacy.billdate BETWEEN '$ADate1' and '$ADate2')";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //GENERAL SURGERY
          } else if ($res5auto_number == 6){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'General Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'General Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'General Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'General Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //NEPHROLOGY (DIALYSIS)
          } else if ($res5auto_number == 7){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Dialysis' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dialysis' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Dialysis' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Dialysis' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };
            
            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //NEURO SURGERY
          } else if ($res5auto_number == 8){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Neurosurgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Neurosurgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Neurosurgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Neurosurgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //NURSING
          } else if ($res5auto_number == 9){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query49 = "select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description = 'Nursing Charges' and (billing_ipbedcharges.recorddate BETWEEN '$ADate1' and '$ADate2')";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //OBS/GYNAE
          } else if ($res5auto_number == 10){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Obs Gynae Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //OPTHALMOLOGY
          } else if ($res5auto_number == 11){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Ophalmology Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //OPTICALS
          } else if ($res5auto_number == 12){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Optical Services' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                       SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Optical Services' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Optical Services' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, master_accountname.misreport from billing_ipservices JOIN master_accountname ON billing_ipservices.accountname = master_accountname.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Optical Services' and (billing_ipservices.billdate between '$ADate1' and '$ADate2')";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //ORTHOPEDICS
          } else if ($res5auto_number == 13){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                      UNION ALL
                      select sum(billing_externalservices.servicesitemrate) as amount, master_accountname.misreport from billing_externalservices JOIN master_accountname ON billing_externalservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_externalservices.servicesitemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_externalservices.billdate between '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;

            $query49 = "select sum(amount) as amount from (
                      select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Orthopedic Surgery' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')
                    ) as count1";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };

            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;
          
          //PEDICATRICIAN
          } else if ($res5auto_number == 14){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            
          
          //PHYSIOTHERAPY
          } else if ($res5auto_number == 15){
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
            $query48 = "select sum(amount) as amount from (
                      select sum(billing_paynowservices.fxamount) as amount, master_accountname.misreport from billing_paynowservices JOIN master_accountname ON billing_paynowservices.accountname = master_accountname.accountname JOIN master_services ON master_services.itemcode = billing_paynowservices.servicesitemcode where master_services.categoryname = 'Physio' and (billing_paynowservices.billdate between '$ADate1' and '$ADate2')
                      UNION ALL
                      SELECT sum(billing_paylaterservices.fxamount) as amount, A.misreport FROM `billing_paylaterservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_paylaterservices.accountname JOIN master_services ON billing_paylaterservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Physio' and (billing_paylaterservices.billdate BETWEEN '$ADate1' and '$ADate2')
                          ) as amount1";

            $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die("Error in query48" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res48 = mysqli_fetch_array($exec48)){
              $opdamount = $res48['amount'];
              $sumopd += $opdamount;
              $totalamount += $opdamount;
            }

            $opdtotal = getOpd($ADate1, $ADate2);
            $opdpercentage =  ( $opdamount / $opdtotal ) * 100;


            $query49 = "select sum(billing_ipservices.servicesitemrateuhx) as amount, A.misreport FROM `billing_ipservices` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipservices.accountname JOIN master_services ON billing_ipservices.servicesitemcode = master_services.itemcode where master_services.categoryname = 'Physio' and (billing_ipservices.billdate BETWEEN '$ADate1' and '$ADate2')";

            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die("Error in query49" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res49 = mysqli_fetch_array($exec49)){
              $ipdamount = $res49['amount'];
              $sumipd += $ipdamount;
              $totalamount += $ipdamount;
            };
            
            $ipdtotal = getIpd($ADate1, $ADate2);
            $ipdpercentage = ( $ipdamount / $ipdtotal ) * 100;

            $fulltotal = $opdtotal + $ipdtotal;
            $totalpercentage = ( $totalamount / $fulltotal ) * 100;

          } else {
            $opdamount = $ipdamount = $totalamount = $opdpercentage = $ipdpercentage = $totalpercentage = 0;
          }

          $sumtotal = $sumopd + $sumipd;

          $snocount = $snocount + 1;


          $colorcode = 'bgcolor="#ffffff"';
        
      ?>
           <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($res5deparmentname); ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($opdamount, 2); ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($ipdamount, 2); ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($totalamount, 2); ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($opdpercentage, 2); ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($ipdpercentage, 2);  ?></td>
            <td class="bodytext31" valign="middle" align="center"><?php echo number_format($totalpercentage, 2); ?></td>
          </tr>  
          <?php 
          }
          ?>
          <tr>
            <td class="bodytext31" valign="middle" align="left" bgcolor="#ffffff"><strong>TOTAL</strong></td>
            <td class="bodytext31" valign="middle" align="center" colspan="" bgcolor="#ffffff"><strong><?php echo number_format($sumopd, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" colspan="" bgcolor="#ffffff"><strong><?php echo number_format($sumipd, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($sumtotal, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
          </tr>    
          <tr>
            <td class="bodytext31" valign="center" align="left" colspan="7" bgcolor="#ecf0f5">&nbsp;</td>
          </tr>
</table>

<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_specialitywiserevenue.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>



