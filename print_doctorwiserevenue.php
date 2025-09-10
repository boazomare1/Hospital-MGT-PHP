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
		<td colspan="11"><br></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left"><strong><?php echo strtoupper($res1locationname); ?></strong></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left"><strong>Doctorwise Revenue Report From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
      	<tr>
          <col width="30"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>No. </strong></td>
            <col width="110"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>DOCTOR</strong></td>
          <col width="120"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>SPECIALITY</strong></td>
          <col width="70"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>OPD</strong></td>
          <col width="70"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>IPD</strong></td>
          <col width="80"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>TOTAL</strong></td>
          <col width="60"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>IPD VOLUME</strong></td>
          <col width="80"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>AVG. IPD REVENUE</strong></td>
          <col width="80"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>OPD VOLUME</strong></td>
          <col width="80"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>AVG. OPD REVENUE</strong></td>
          <col width="80"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>ADMISSION</strong></td> 
          <col width="90"><td align="center" valign="middle"  
            bgcolor="#ecf0f5" class="bodytext31"><strong>OP to IP CONVERSION</strong></td> 
        </tr>
        <?php
       
          $oprevenue = $totaloprevenue = $iprevenue = $totaliprevenue = $overalltotal = $opcount = $totalopcount = $ipcount = $totalipcount = $totaladmissioncount = 0;
          $query1 = "SELECT `employeename`, `username`, employeecode, jobdescription FROM `master_employee` WHERE `username` != ''";
          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
          while($res1 = mysqli_fetch_array($exec1)){
            $doctorname = $res1['employeename'];
            $username = $res1['username'];
            $employeecode = $res1['employeecode'];
            $speciality = $res1['jobdescription'];

            // $qspeciality = "select doctorname from doctor_mapping where employeecode = '$employeecode' and status <> 'deleted'";
            // $execspecialty = mysql_query($qspeciality) or die("Error in qspeciality".mysql_error());
            // $resspeciality = mysql_fetch_array($execspecialty);
            // $speciality = $resspeciality['doctorname'];


            //LAB CONSULATATION
            $qlabcons = "SELECT SUM(`consultation_lab`.`labitemrate`) AS labrate  FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execlabcons = mysqli_query($GLOBALS["___mysqli_ston"], $qlabcons) or die("Error in qlabcons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $reslabcons = mysqli_fetch_array($execlabcons);
            $labamount = $reslabcons['labrate'];

            $qlabcount = "SELECT count(`consultation_lab`.`labitemrate`) AS labrate  FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execlabcount = mysqli_query($GLOBALS["___mysqli_ston"], $qlabcount) or die("Error in qlabcount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $reslabcount = mysqli_fetch_array($execlabcount);
            $labcount = $reslabcount['labrate'];


            //RADIOLOGY CONSULTATION
            $qradcons = "SELECT SUM(`consultation_radiology`.`radiologyitemrate`) AS amount FROM `consultation_radiology` where `consultation_radiology`.`paymentstatus`='completed' AND `consultation_radiology`.`username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execradcons = mysqli_query($GLOBALS["___mysqli_ston"], $qradcons) or die("Error in qradcons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resradcons = mysqli_fetch_array($execradcons);
            $radamount = $resradcons['amount']; 

            $qradcount = "SELECT count(`consultation_radiology`.`radiologyitemrate`) AS amount FROM `consultation_radiology` where `consultation_radiology`.`paymentstatus`='completed' AND `consultation_radiology`.`username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execradcount = mysqli_query($GLOBALS["___mysqli_ston"], $qradcount) or die("Error in qradcount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resradcount = mysqli_fetch_array($execradcount);
            $radcount = $resradcount['amount']; 


            //SERVICES CONSULTATION
            $qsercons = "SELECT SUM(`consultation_services`.`amount`) AS amount FROM `consultation_services` where `consultation_services`.`paymentstatus`='completed' AND `consultation_services`.`username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execsercons = mysqli_query($GLOBALS["___mysqli_ston"], $qsercons) or die("Error in qsercons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $ressercons = mysqli_fetch_array($execsercons);
            $seramount = $ressercons['amount'];

            $qsercount = "SELECT count(`consultation_services`.`amount`) AS amount FROM `consultation_services` where `consultation_services`.`paymentstatus`='completed' AND `consultation_services`.`username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execsercount = mysqli_query($GLOBALS["___mysqli_ston"], $qsercount) or die("Error in qsercount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $ressercount = mysqli_fetch_array($execsercount);
            $sercount = $ressercount['amount'];


            //PHARMACY CONSULTATION
            $qpharmcons = "SELECT SUM(quantity*rate) AS amount FROM `master_consultationpharm` where `recordstatus`='completed' AND `consultingdoctor`='".$username."' and recorddate between '$ADate1' and '$ADate2'";
            $execpharmcons = mysqli_query($GLOBALS["___mysqli_ston"], $qpharmcons) or die("Error in qpharmcons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $respharmcons = mysqli_fetch_array($execpharmcons);
            $pharmamount = $respharmcons['amount'];

            $qpharmcount = "SELECT count(quantity*rate) AS amount FROM `master_consultationpharm` where `recordstatus`='completed' AND `consultingdoctor`='".$username."' and recorddate between '$ADate1' and '$ADate2'";
            $execpharmcount = mysqli_query($GLOBALS["___mysqli_ston"], $qpharmcount) or die("Error in qpharmcount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $respharmcount = mysqli_fetch_array($execpharmcount);
            $pharmcount = $respharmcount['amount'];


            //IP LAB CONSULTATION
            $qiplabcons = "SELECT SUM(labitemrate) AS amount FROM `ipconsultation_lab` where `resultentry`='completed' AND `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execiplabcons = mysqli_query($GLOBALS["___mysqli_ston"], $qiplabcons) or die("Error in qiplabcons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resiplabcons = mysqli_fetch_array($execiplabcons);
            $iplabamount = $resiplabcons['amount'];

            $qiplabcount = "SELECT count(labitemrate) AS amount FROM `ipconsultation_lab` where `resultentry`='completed' AND `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execiplabcount = mysqli_query($GLOBALS["___mysqli_ston"], $qiplabcount) or die("Error in qiplabcount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resiplabcount = mysqli_fetch_array($execiplabcount);
            $iplabcount = $resiplabcount['amount'];


            //IP RADIOLOGY CONSULTATION
            $qipradcons = "SELECT SUM(radiologyitemrate) AS amount FROM `ipconsultation_radiology` where `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execipradcons = mysqli_query($GLOBALS["___mysqli_ston"], $qipradcons) or die("Error in qipradcons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resipradcons = mysqli_fetch_array($execipradcons);
            $ipradamount = $resipradcons['amount'];

            $qipradcount = "SELECT count(radiologyitemrate) AS amount FROM `ipconsultation_radiology` where `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execipradcount = mysqli_query($GLOBALS["___mysqli_ston"], $qipradcount) or die("Error in qipradcount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resipradcount = mysqli_fetch_array($execipradcount);
            $ipradcount = $resipradcount['amount'];


            //IP SERVICES CONSULTATION
            $qipsercons = "SELECT SUM(amount) AS amount FROM `ipconsultation_services` where `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execipsercons = mysqli_query($GLOBALS["___mysqli_ston"], $qipsercons) or die("Error in qipsercons".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resipsercons = mysqli_fetch_array($execipsercons);
            $ipseramount = $resipsercons['amount'];

            $qipsercount = "SELECT count(amount) AS amount FROM `ipconsultation_services` where `username`='".$username."' and consultationdate between '$ADate1' and '$ADate2'";
            $execipsercount = mysqli_query($GLOBALS["___mysqli_ston"], $qipsercount) or die("Error in qipsercount".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resipsercount = mysqli_fetch_array($execipsercount);
            $ipsercount = $resipsercount['amount'];



            $oprevenue = $labamount + $radamount + $seramount + $pharmamount;
            $iprevenue = $iplabamount + $ipradamount + $ipseramount;
            $rowtotal = $oprevenue + $iprevenue;
            $totaloprevenue += $oprevenue;
            $totaliprevenue += $iprevenue;
            $overalltotal += $rowtotal;
            $opcount = $labcount + $radcount + $sercount + $pharmcount;
            $ipcount = $iplabcount + $ipradcount + $ipsercount;
            $totalopcount += $opcount;
            $totalipcount += $ipcount;

            if($iprevenue != '0' && $ipcount != '0'){
              $avergageipdrevenue = ($iprevenue / $ipcount);
            } else {
              $avergageipdrevenue = 0;
            }

            if($oprevenue != '0' && $opcount != '0'){
              $averageopdrevenue = ($oprevenue / $opcount);
            } else {
              $averageopdrevenue = 0;
            }

            $query22 = "select count(ip_bedallocation.patientcode) as count, ip_bedallocation.visitcode, master_ipvisitentry.opadmissiondoctor FROM `ip_bedallocation` JOIN master_ipvisitentry ON ip_bedallocation.patientcode = master_ipvisitentry.patientcode and ip_bedallocation.visitcode = master_ipvisitentry.visitcode where master_ipvisitentry.opadmissiondoctor = '$doctorname' and (ip_bedallocation.recorddate between '$ADate1' and '$ADate2')";
            $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res22 = mysqli_fetch_array($exec22);

            $admissioncount = $res22['count'];
            // echo $admissioncount;
            $totaladmissioncount += $admissioncount;

            if($oprevenue==0 && $iprevenue == 0 && $rowtotal == 0){ continue;}

            if($admissioncount != '0' && $opcount != '0'){
              $optoippercentage = ($admissioncount / $opcount)*100;
            } else {
              $optoippercentage = 0;
            }

            $snocount = $snocount + 1;
          
            $colorcode = 'bgcolor="#ffffff"';
	      ?>

        <tr <?php echo $colorcode; ?>>
         	<td width="8%" class="bodytext31" valign="middle" align="center"><?php echo $snocount; ?></td>
          <td width="8%" class="bodytext31" valign="middle" align="left"><?php echo wordwrap(strtoupper($doctorname), 25, "<br>\n"); ?></td>
        	<td width="6%" align="left" valign="middle" class="bodytext31"><?php echo wordwrap(strtoupper($speciality), 15 , "<br>\n"); ?></td>
          <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($oprevenue, 2); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($iprevenue, 2); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($rowtotal, 2); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($ipcount); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($avergageipdrevenue, 2); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($opcount); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($averageopdrevenue, 2); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($admissioncount); ?></td>
            <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($optoippercentage, 2)."%"; ?></td>
        </tr>
      <?php
      }
      ?>
      <tr>
        <td class="bodytext31" valign="middle" align="right" colspan="3" bgcolor="#ffffff"><strong>TOTAL</strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($totaloprevenue, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($totaliprevenue, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($overalltotal, 2); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($totalipcount); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($totalopcount); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong><?php echo number_format($totaladmissioncount); ?></strong></td>
            <td class="bodytext31" valign="middle" align="center" bgcolor="#ffffff"><strong>&nbsp;</strong></td>
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
        $html2pdf->Output('print_doctorwiserevenue.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>



