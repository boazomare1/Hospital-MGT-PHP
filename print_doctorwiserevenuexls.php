<?php

/*header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="report_doctorwiserevenue.xls"');

header('Cache-Control: max-age=80');*/



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

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

function clean($string) {
   $string = str_replace("'", "", $string); // Replaces all spaces with hyphens.

   return $string; // Removes special chars.
}


$query18 = "select * from master_location";

$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));

$row = array();

while($row[] = mysqli_fetch_array($exec18)){

$res1locationname = $row[0]['locationname'];

}





$currentdate = date('d/m/Y H:i:s');



?>

<style type="text/css">

<!--

.bodytext3 {

}

.bodytext31 {

}

.bodytext311 {

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

		<td colspan="11"><br></td>

	</tr>

	<tr>

		<td class="bodytext31"  valign="middle"  align="left" colspan="5" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>

	</tr>

	<tr>

		<td class="bodytext31"  valign="middle"  align="left" colspan="5" ><strong>Doctorwise Revenue Report From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  

	</tr>

	<tr>

		<td colspan="10"><br></td>

	</tr>

	</tbody>

</table>

<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">

      	 <tr>

            <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>

            <?php 

              $query451 = "select * from `master_location`";

              $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

              $row2 = array();

              while ($row2[] = mysqli_fetch_assoc($exec451)){

                $locationcode = $row2[0]['auto_number'];

                echo "Location: " . $row2[0]['locationname'];

              }

            ?></strong></span></td>

            <td colspan="10" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

          </tr>

          <tr>

          <td width="2%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>NO.</strong></div></td>

          <td width="15%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>DOCTOR</strong></div></td>

          <td width="15%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>SPECIALITY</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OPD</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IPD</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>TOTAL</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OPD VOLUME</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>AVG. OPD REVENUE</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IPD VOLUME</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>AVG. IPD REVENUE</strong></div></td>

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>ADMISSION</strong></div></td> 

          <td width="6%" align="left" valign="center"  

            bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP to IP CONVERSION</strong></div></td> 

        </tr>

          

       <?php

        $usernames = [];

        $employeecodes = [];

        $sumopdamount = $sumipdamount = $rowtot = $sumrowtot = $sumopdvolume = $sumvagopdrevenue = $sumipdvolume = $sumavdipdrevenue = $sumadmission = $sumopipconversion = $totalrefund = 0;



      /*  $query3 = "select employeename, employeecode, username, jobdescription from master_employee";

        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

        while($res3 = mysqli_fetch_array($exec3)){

          $employeecode = $res3['employeecode'];

          $username = $res3['username'];*/



           $query4 = "select doctorname, doctorcode from master_doctor where status <> 'deleted'";

          $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res4 = mysqli_fetch_array($exec4)){

          $employeename1 = $res4['doctorname'];
		  $employeename=clean($employeename1);

          $doctorcode = $res4['doctorcode'];



          $query30 = "select department from master_doctor where doctorcode = '$doctorcode'";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res30 = mysqli_fetch_array($exec30);

          $departmentid = $res30['department'];



          $query31 = "select department from master_department where auto_number = '$departmentid'";

          $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res31 = mysqli_fetch_array($exec31);

          $speciality = $res31['department'];

          



          $opdamount = $consultation = $pharmacy = $lab = $radiology = $service = $referal = $rescue = $homecare = 0;

          $ipdamount = $billingip = $opdvolume = $avgopdrevenue = $ipdvolume = $ipdrevenue = $avgipdrevenue = $admission = $opipconversion = 0;

          

          //CONSULTATION

          $query1 = "SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res1 = mysqli_fetch_array($exec1)){

              $consultation = $res1['consultation'];

              $opdamount += $consultation;

          }



          $query2 = "SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res2 = mysqli_fetch_array($exec2)){

              $consultation = $res2['consultation'];

              $opdamount += $consultation;

          }



          //CONSULTATION REFUND

          $query24a = "SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') ";

          $exec24a = mysqli_query($GLOBALS["___mysqli_ston"], $query24a) or die ("Error in Query24a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24a = mysqli_fetch_array($exec24a);

          $r24a = $res24a['consultation1'];



          $query24b = "SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec24b = mysqli_query($GLOBALS["___mysqli_ston"], $query24b) or die ("Error in Query24b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24b = mysqli_fetch_array($exec24b);

          $r24b = $res24b['consultation1'];



          $query24c = "SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec24c = mysqli_query($GLOBALS["___mysqli_ston"], $query24c) or die ("Error in Query24c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24c = mysqli_fetch_array($exec24c);

          $r24c = $res24c['consultation1'];



          $totalrefund = $r24a + $r24b + $r24c;

          $opdamount = $opdamount - $totalrefund;







          //PHARMACY

          $query5 = "SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res5 = mysqli_fetch_array($exec5)){

              $pharmacy = $res5['pharmacy'];

              $opdamount += $pharmacy;

          }



          $query6 = "SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res6 = mysqli_fetch_array($exec6)){

              $pharmacy = $res6['pharmacy'];

              $opdamount += $pharmacy;

          }



          //PHARMACY REFUND

          $query25a = "SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25a = mysqli_query($GLOBALS["___mysqli_ston"], $query25a) or die ("Error in Query25a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25a = mysqli_fetch_array($exec25a) ;

          $r25a = $res25a['amount1'];



          $query25b = "SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25b = mysqli_query($GLOBALS["___mysqli_ston"], $query25b) or die ("Error in Query25b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25b = mysqli_fetch_array($exec25b) ;

          $r25b = $res25b['amount1'];



          $query25c = "SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25c = mysqli_query($GLOBALS["___mysqli_ston"], $query25c) or die ("Error in Query25c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25c = mysqli_fetch_array($exec25c) ;

          $r25c = $res25c['amount1'];



          $query25d = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25d = mysqli_query($GLOBALS["___mysqli_ston"], $query25d) or die ("Error in Query25d".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25d = mysqli_fetch_array($exec25d) ;

          $r25d = $res25d['amount1'];



          $totalrefund = $r25a + $r25b + $r25c + $r25d;

          $opdamount = $opdamount - $totalrefund;







          //LABORATORY

          $query7 = "SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res7 = mysqli_fetch_array($exec7)){

              $lab = $res7['lab'];

              $opdamount += $lab;

          }



          $query8 = "SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res8 = mysqli_fetch_array($exec8)){

              $lab = $res8['lab'];

              $opdamount += $lab;

          }



          //LABORATORY REFUND

          $query26a = "SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26a = mysqli_query($GLOBALS["___mysqli_ston"], $query26a) or die ("Error in Query26a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26a = mysqli_fetch_array($exec26a) ;

          $r26a = $res26a['labitemrate1'];



          $query26b = "SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26b = mysqli_query($GLOBALS["___mysqli_ston"], $query26b) or die ("Error in Query26b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26b = mysqli_fetch_array($exec26b) ;

          $r26b = $res26b['labitemrate1'];



          $query26c = "SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26c = mysqli_query($GLOBALS["___mysqli_ston"], $query26c) or die ("Error in Query26c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26c = mysqli_fetch_array($exec26c) ;

          $r26c = $res26c['amount1'];



          $totalrefund = $r26a + $r26b + $r26c; 

          $opdamount = $opdamount - $totalrefund;







          //RADIOLOGY

          $query9 = "SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res9 = mysqli_fetch_array($exec9)){

              $radiology = $res9['radiology'];

              $opdamount += $radiology;

          }



          $query10 = "SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res10 = mysqli_fetch_array($exec10)){

              $radiology = $res10['radiology'];

              $opdamount += $radiology;

          }



          //RADIOLOGY REFUND

          $query27a = "SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27a = mysqli_query($GLOBALS["___mysqli_ston"], $query27a) or die ("Error in Query27a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27a = mysqli_fetch_array($exec27a) ;

          $r27a = $res27a['radiologyitemrate1'];



          $query27b = "SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in Query27b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27b = mysqli_fetch_array($exec27b) ;

          $r27b = $res27b['radiologyitemrate1'];



          $query27c = "SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27c = mysqli_query($GLOBALS["___mysqli_ston"], $query27c) or die ("Error in Query27c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27c = mysqli_fetch_array($exec27c) ;

          $r27c = $res27c['amount1'];



          $totalrefund = $r27a + $r27b + $r27c; 

          $opdamount = $opdamount - $totalrefund;







          //SERVICES

          $query11 = "SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res11 = mysqli_fetch_array($exec11)){

              $service = $res11['service'];

              $opdamount += $service;

          }



          $query12 = "SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res12 = mysqli_fetch_array($exec12)){

              $service = $res12['service'];

              $opdamount += $service;

          }



          //SERVICES REFUND

          $query28a = "SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28a= mysqli_query($GLOBALS["___mysqli_ston"], $query28a) or die ("Error in Query28a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28a = mysqli_fetch_array($exec28a) ;

          $r28a = $res28a['servicesitemrate1'];



          $query28b = "SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28b = mysqli_query($GLOBALS["___mysqli_ston"], $query28b) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28b = mysqli_fetch_array($exec28b) ;

          $r28b = $res28b['servicesitemrate1'];



          $query28c = "SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28c = mysqli_query($GLOBALS["___mysqli_ston"], $query28c) or die ("Error in Query28c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28c = mysqli_fetch_array($exec28c) ;

          $r28c = $res28c['amount1'];



          $totalrefund = $r28a + $r28b + $r28c; 

          $opdamount = $opdamount - $totalrefund;







          //REFERAL

          $query13 = "SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res13 = mysqli_fetch_array($exec13)){

              $referal = $res13['referal'];

              $opdamount += $referal;

          }



          $query14 = "SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res14 = mysqli_fetch_array($exec14)){

              $referal = $res14['referal'];

              $opdamount += $referal;

          }



          //REFERAL REFUND

          $query29a = "SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec29a= mysqli_query($GLOBALS["___mysqli_ston"], $query29a) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29a = mysqli_fetch_array($exec29a) ;

          $r29a = $res29a['referalrate1'];



          $query29b = "SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec29b = mysqli_query($GLOBALS["___mysqli_ston"], $query29b) or die ("Error in Query29b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29b = mysqli_fetch_array($exec29b) ;

          $r29b = $res29b['referalrate1'];



          $totalrefund = $r29a + $r29b; 

          $opdamount = $opdamount - $totalrefund; 







          //AMBULANCE

          $query15 = "SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res15 = mysqli_fetch_array($exec15)){

              $rescue = $res15['rescue'];

              $opdamount += $rescue;

          }



          $query16 = "SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res16 = mysqli_fetch_array($exec16)){

              $rescue = $res16['rescue'];

              $opdamount += $rescue;

          }







          //HOMECARE

          $query17 = "SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res17 = mysqli_fetch_array($exec17)){

              $homecare = $res17['homecare'];

              $opdamount += $homecare;

          }



          $query18 = "SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die("Error in query18".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res18 = mysqli_fetch_array($exec18)){

              $homecare = $res18['homecare'];

              $opdamount += $homecare;

          }



          $sumopdamount += $opdamount;





          //BILLING IP

          $query19 = "SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res19 = mysqli_fetch_array($exec19)){

              $billingip = $res19['billingip'];

              $ipdamount += $billingip;

          }





          //IP CREDIT APPROVED

          $query20 = "SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in query20".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res20 = mysqli_fetch_array($exec20)){

              $billingip = $res20['billingip'];

              $ipdamount += $billingip;

          }



          //IP DISCOUNT 

          $query30 = "SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num30 = mysqli_num_rows($exec30);

          $res30 = mysqli_fetch_array($exec30);

          $ipdiscamount = $res30['amount'];



          $ipdamount = $ipdamount - $ipdiscamount;



          //REBATE

          $query16 = "SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode') ";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num16=mysqli_num_rows($exec16);

          $res16 = mysqli_fetch_array($exec16);

          $rebateamount = $res16['rebate'];



          $ipdamount = $ipdamount - $rebateamount;



          $sumipdamount += $ipdamount;

          $rowtot = $opdamount + $ipdamount;







          //OPD VOLUME

          $query21 = "SELECT sum(count) as count from (SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') ) as count1";

          $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res21 = mysqli_fetch_array($exec21)){

              $opdvolume = $res21['count'];

              $sumopdvolume += $opdvolume;

          }



          //IPD VOLUME

          $query22 = "SELECT sum(count) as count from (SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')) as count1";

          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res22 = mysqli_fetch_array($exec22)){

              $ipdvolume = $res22['count'];

              $sumipdvolume += $ipdvolume;

          }



          //ADMISSION COUNT

          $query23 = "SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res23 = mysqli_fetch_array($exec23)){

              $admission = $res23['admission'];

              $sumadmission += $admission;

          }



          if($opdvolume != 0 and $opdamount != 0){

            $avgopdrevenue = $opdamount / $opdvolume;

          } else {

            $avgopdrevenue = 0;

          }



          if($ipdvolume != 0 and $ipdamount != 0){

            $avgipdrevenue = $ipdamount / $ipdvolume;

          } else {

            $avgipdrevenue = 0;

          }



          if($admission != 0 and $opdvolume != 0){

            $opipconversion = ($admission / $opdvolume)*100;

          } else {

            $opipconversion = 0;

          }



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



          array_push($usernames, $employeename);



          array_push($employeecodes, $doctorcode);



        ?>



        <tr <?php echo $colorcode; ?>>

          <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>

          <td class="bodytext31" valign="center" align="left"><?php echo $employeename; ?></td>

          <td class="bodytext31" valign="center" align="left"><?php echo $speciality; ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opdamount,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($ipdamount,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($rowtot,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opdvolume); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($avgopdrevenue,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($ipdvolume); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($avgipdrevenue,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($admission); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opipconversion,2)."%"; ?></td>

        </tr>



        <?php

        }

               

        ?>



        <?php

          array_push($usernames, '');

          array_push($employeecodes, '');



          $used_usernames = implode("','" ,$usernames);

          $used_employeecodes = implode("','" ,$employeecodes);



          $opdamount = $consultation = $pharmacy = $lab = $radiology = $service = $referal = $rescue = $homecare = 0;

          $ipdamount = $billingip = $opdvolume = $avgopdrevenue = $ipdvolume = $ipdrevenue = $avgipdrevenue = $admission = $opipconversion = 0;

          

          //CONSULTATION

          $query1 = "SELECT sum(consultation) as consultation from (SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL 

            SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username != '' ) ) as consultation1;";

          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res1 = mysqli_fetch_array($exec1)){

              $consultation = $res1['consultation'];

              $opdamount += $consultation;

          }



         $query2 = "SELECT sum(consultation) as consultation from (SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username != '') ) as consultation1";

          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res2 = mysqli_fetch_array($exec2)){

              $consultation = $res2['consultation'];

              $opdamount += $consultation;

          }



          //CONSULTATION REFUND

          $query24a = "SELECT sum(consultation1) as consultation1 from (SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as consultation";

          $exec24a = mysqli_query($GLOBALS["___mysqli_ston"], $query24a) or die ("Error in Query24a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24a = mysqli_fetch_array($exec24a);

          $r24a = $res24a['consultation1'];



          $query24b = "SELECT sum(consultation1) as consultation1 from (SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) UNION ALL SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as consultation";

          $exec24b = mysqli_query($GLOBALS["___mysqli_ston"], $query24b) or die ("Error in Query24b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24b = mysqli_fetch_array($exec24b);

          $r24b = $res24b['consultation1'];



          $query24c = "SELECT sum(consultation1) as consultation1 from (SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as consultation";

          $exec24c = mysqli_query($GLOBALS["___mysqli_ston"], $query24c) or die ("Error in Query24c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24c = mysqli_fetch_array($exec24c);

          $r24c = $res24c['consultation1'];



          $totalrefund = $r24a + $r24b + $r24c;

          $opdamount = $opdamount - $totalrefund;







          //PHARMACY

          $query5 = "SELECT sum(pharmacy) as pharmacy from (SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL 

            SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

          ) as pharmacy1";

          $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res5 = mysqli_fetch_array($exec5)){

              $pharmacy = $res5['pharmacy'];

              $opdamount += $pharmacy;

          }



          $query6 = "SELECT sum(pharmacy) as pharmacy from (SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as pharmacy1";

          $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res6 = mysqli_fetch_array($exec6)){

              $pharmacy = $res6['pharmacy'];

              $opdamount += $pharmacy;

          }



          //PHARMACY REFUND

          $query25a = "SELECT sum(amount1) as amount1 from (SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25a = mysqli_query($GLOBALS["___mysqli_ston"], $query25a) or die ("Error in Query25a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25a = mysqli_fetch_array($exec25a) ;

          $r25a = $res25a['amount1'];



          $query25b = "SELECT sum(amount1) as amount1 from (SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25b = mysqli_query($GLOBALS["___mysqli_ston"], $query25b) or die ("Error in Query25b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25b = mysqli_fetch_array($exec25b) ;

          $r25b = $res25b['amount1'];



          $query25c = "SELECT sum(amount1) as amount1 from (SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))  UNION ALL SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25c = mysqli_query($GLOBALS["___mysqli_ston"], $query25c) or die ("Error in Query25c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25c = mysqli_fetch_array($exec25c) ;

          $r25c = $res25c['amount1'];



          $query25d = "SELECT sum(amount1) as amount1 from (SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')  ) as amount";

          $exec25d = mysqli_query($GLOBALS["___mysqli_ston"], $query25d) or die ("Error in Query25d".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25d = mysqli_fetch_array($exec25d) ;

          $r25d = $res25d['amount1'];



          $totalrefund = $r25a + $r25b + $r25c + $r25d;

          $opdamount = $opdamount - $totalrefund;







          //LABORATORY

          $query7 = "SELECT sum(lab) as lab from (SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) 

            UNION ALL

            SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) AS lab1";

          $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res7 = mysqli_fetch_array($exec7)){

              $lab = $res7['lab'];

              $opdamount += $lab;

          }



          $query8 = "SELECT sum(lab) as lab from (SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') )

            as lab1";

          $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res8 = mysqli_fetch_array($exec8)){

              $lab = $res8['lab'];

              $opdamount += $lab;

          }



           //LABORATORY REFUND

          $query26a = "SELECT sum(labitemrate1) as labitemrate1 from (SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as labitem1";

          $exec26a = mysqli_query($GLOBALS["___mysqli_ston"], $query26a) or die ("Error in Query26a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26a = mysqli_fetch_array($exec26a) ;

          $r26a = $res26a['labitemrate1'];



          $query26b = "SELECT sum(labitemrate1) as labitemrate1 from (SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')  ) as labitem1";

          $exec26b = mysqli_query($GLOBALS["___mysqli_ston"], $query26b) or die ("Error in Query26b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26b = mysqli_fetch_array($exec26b) ;

          $r26b = $res26b['labitemrate1'];



          $query26c = "SELECT sum(amount1) as amount1 from (SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec26c = mysqli_query($GLOBALS["___mysqli_ston"], $query26c) or die ("Error in Query26c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26c = mysqli_fetch_array($exec26c) ;

          $r26c = $res26c['amount1'];



          $totalrefund = $r26a + $r26b + $r26c; 

          $opdamount = $opdamount - $totalrefund;







          //RADIOLOGY

          $query9 = "SELECT sum(radiology) as radiology from (SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as radiology1";

          $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res9 = mysqli_fetch_array($exec9)){

              $radiology = $res9['radiology'];

              $opdamount += $radiology;

          }



          $query10 = "SELECT sum(radiology) as radiology from (SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

          ) as radiology1";

          $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res10 = mysqli_fetch_array($exec10)){

              $radiology = $res10['radiology'];

              $opdamount += $radiology;

          }



          //RADIOLOGY REFUND

          $query27a = "SELECT sum(radiologyitemrate1) as radiologyitemrate1 from (SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as rad1";

          $exec27a = mysqli_query($GLOBALS["___mysqli_ston"], $query27a) or die ("Error in Query27a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27a = mysqli_fetch_array($exec27a) ;

          $r27a = $res27a['radiologyitemrate1'];



          $query27b = "SELECT sum(radiologyitemrate1) as radiologyitemrate1 from (SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as rad1";

          $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in Query27b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27b = mysqli_fetch_array($exec27b) ;

          $r27b = $res27b['radiologyitemrate1'];



          $query27c = "SELECT sum(amount1) as amount1 from (SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec27c = mysqli_query($GLOBALS["___mysqli_ston"], $query27c) or die ("Error in Query27c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27c = mysqli_fetch_array($exec27c) ;

          $r27c = $res27c['amount1'];



          $totalrefund = $r27a + $r27b + $r27c; 

          $opdamount = $opdamount - $totalrefund;







          //SERVICES

          $query11 = "SELECT sum(service) as service from (SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) 

            UNION ALL

            SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as services1";

          $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res11 = mysqli_fetch_array($exec11)){

              $service = $res11['service'];

              $opdamount += $service;

          }



          $query12 = "SELECT sum(service) as service from (SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames'))

            UNION ALL 

            SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as services";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res12 = mysqli_fetch_array($exec12)){

              $service = $res12['service'];

              $opdamount += $service;

          }



          //SERVICES REFUND

          $query28a = "SELECT sum(servicesitemrate1) as servicesitemrate1 from (SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as service1";

          $exec28a= mysqli_query($GLOBALS["___mysqli_ston"], $query28a) or die ("Error in Query28a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28a = mysqli_fetch_array($exec28a) ;

          $r28a = $res28a['servicesitemrate1'];



          $query28b = "SELECT sum(servicesitemrate1) as servicesitemrate1 from (SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amoount1";

          $exec28b = mysqli_query($GLOBALS["___mysqli_ston"], $query28b) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28b = mysqli_fetch_array($exec28b) ;

          $r28b = $res28b['servicesitemrate1'];



          $query28c = "SELECT sum(amount1) as amount1 from (SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec28c = mysqli_query($GLOBALS["___mysqli_ston"], $query28c) or die ("Error in Query28c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28c = mysqli_fetch_array($exec28c) ;

          $r28c = $res28c['amount1'];



          $totalrefund = $r28a + $r28b + $r28c; 

          $opdamount = $opdamount - $totalrefund;







          //REFERAL

          $query13 = "SELECT sum(referal) as referal from (SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as referal1";

          $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res13 = mysqli_fetch_array($exec13)){

              $referal = $res13['referal'];

              $opdamount += $referal;

          }



          $query14 = "SELECT sum(referal) as referal from (SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as referal1";

          $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res14 = mysqli_fetch_array($exec14)){

              $referal = $res14['referal'];

              $opdamount += $referal;

          }



          //REFERAL REFUND

          $query29a = "SELECT sum(referalrate1) as referalrate1 from (SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec29a= mysqli_query($GLOBALS["___mysqli_ston"], $query29a) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29a = mysqli_fetch_array($exec29a) ;

          $r29a = $res29a['referalrate1'];



          $query29b = "SELECT sum(referalrate1) as referalrate1 from (SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as referal";

          $exec29b = mysqli_query($GLOBALS["___mysqli_ston"], $query29b) or die ("Error in Query29b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29b = mysqli_fetch_array($exec29b) ;

          $r29b = $res29b['referalrate1'];



          $totalrefund = $r29a + $r29b; 

          $opdamount = $opdamount - $totalrefund; 







          //AMBULANCE

          $query15 = "SELECT sum(rescue) as rescue from (SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as rescue1";

          $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res15 = mysqli_fetch_array($exec15)){

              $rescue = $res15['rescue'];

              $opdamount += $rescue;

          }



          $query16 = "SELECT sum(rescue) as rescue from (SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as rescue1";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res16 = mysqli_fetch_array($exec16)){

              $rescue = $res16['rescue'];

              $opdamount += $rescue;

          }







          //HOMECARE

          $query17 = "SELECT sum(homecare) as homecare from (SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as homecare1";

          $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res17 = mysqli_fetch_array($exec17)){

              $homecare = $res17['homecare'];

              $opdamount += $homecare;

          }



          $query18 = "SELECT sum(homecare) as homecare from (SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as homecare1";

          $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die("Error in query18".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res18 = mysqli_fetch_array($exec18)){

              $homecare = $res18['homecare'];

              $opdamount += $homecare;

          }



          $sumopdamount += $opdamount;





          //BILLING IP

          $query19 = "SELECT sum(billingip) as billingip from (SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '')

          ) as billingip1";

          $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res19 = mysqli_fetch_array($exec19)){

              $billingip = $res19['billingip'];

              $ipdamount += $billingip;

          }



          //IP CREDIT APPROVED

          $query20 = "SELECT SUM(billingip) as billingip from (SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') 

          ) as billingip1";

          $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in query20".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res20 = mysqli_fetch_array($exec20)){

              $billingip = $res20['billingip'];

              $ipdamount += $billingip;

          }



          //IP DISCOUNT 

          $query30 = "SELECT sum(amount) as amount from (SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') 

          ) as amount1";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num30 = mysqli_num_rows($exec30);

          $res30 = mysqli_fetch_array($exec30);

          $ipdiscamount = $res30['amount'];



          $ipdamount = $ipdamount - $ipdiscamount;



          //REBATE

          $query16 = "SELECT SUM(rebate) as rebate from (SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '')

          ) as rebate1";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num16=mysqli_num_rows($exec16);

          $res16 = mysqli_fetch_array($exec16);

          $rebateamount = $res16['rebate'];



          $ipdamount = $ipdamount - $rebateamount;





          

          //COUNT OPD VOLUME

          $query21 = "SELECT sum(count) as count from (SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '' ) ) as count1";

          $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res21 = mysqli_fetch_array($exec21)){

              $opdvolume = $res21['count'];

              $sumopdvolume += $opdvolume;

          }



          //COUNT IPD VOLUME

          $query22 = "SELECT sum(count) as count from (SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes'))) as count1";

          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res22 = mysqli_fetch_array($exec22)){

              $ipdvolume = $res22['count'];

              $sumipdvolume += $ipdvolume;

          }



          //COUNT ADMISSIONS

          $query23 = "SELECT sum(admission) as admission from (SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) UNION ALL SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode not in (select visitcode from master_ipvisitentry where opdoctorcode <> '' ) ) as admission1";

          $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res23 = mysqli_fetch_array($exec23)){

              $admission = $res23['admission'];

              $sumadmission += $admission;

          }



          $sumipdamount += $ipdamount;

          $rowtot = $opdamount + $ipdamount;



          if($opdvolume != 0 and $opdamount != 0){

            $avgopdrevenue = $opdamount / $opdvolume;

          } else {

            $avgopdrevenue = 0;

          }



          if($ipdvolume != 0 and $ipdamount != 0){

            $avgipdrevenue = $ipdamount / $ipdvolume;

          } else {

            $avgipdrevenue = 0;

          }



          if($admission != 0 and $opdvolume != 0){

            $opipconversion = ($admission / $opdvolume)*100;

          } else {

            $opipconversion = 0;

          }



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



        <tr <?php echo $colorcode; ?>>

          <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>

          <td class="bodytext31" valign="center" align="left">WALKINS</td>

          <td class="bodytext31" valign="center" align="left">WALKINS</td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opdamount,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($ipdamount,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($rowtot,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opdvolume); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($avgopdrevenue,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($ipdvolume); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($avgipdrevenue,2); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($admission); ?></td>

          <td class="bodytext31" valign="center" align="right"><?php echo number_format($opipconversion,2)."%"; ?></td>

        </tr>

        <?php 

        $sumrowtot = $sumopdamount + $sumipdamount;



        if($sumopdvolume != 0 and $sumopdamount != 0){

          $sumvagopdrevenue = $sumopdamount / $sumopdvolume;

        } else {

          $sumvagopdrevenue = 0;

        }



        if($sumipdvolume != 0 and $sumipdamount != 0){

          $sumavdipdrevenue = $sumipdamount / $sumipdvolume;

        } else {

          $sumavdipdrevenue = 0;

        }



        if($sumadmission != 0 and $sumopdvolume != 0){

          $sumopipconversion = ($sumadmission / $sumopdvolume)*100;

        } else {

          $sumopipconversion = 0;

        }



        ?>

        <tr bgcolor="#ecf0f5">

          <td class="bodytext31" valign="center" align="left">&nbsp;</td>

          <td class="bodytext31" valign="center" align="left">&nbsp;</td>

          <td class="bodytext31" valign="center" align="left">&nbsp;</td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumopdamount,2); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumipdamount,2); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumrowtot,2); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumopdvolume); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumvagopdrevenue,2); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumipdvolume); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumavdipdrevenue,2); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumadmission); ?></strong></td>

          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($sumopipconversion,2)."%"; ?></strong></td>

        </tr>

        </tbody>

        </table></td>

      </tr>

</table>