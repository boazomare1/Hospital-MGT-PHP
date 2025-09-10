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
$opnumber = "";
$ipnumber = "";
$patientname = "";
$dateofadmission = "";
$dateofdischarge = "";
$class = "";
$admissiondoc = "";
$consultingdoc = "";
$revenue = "";
$returns = "";
$discount = "";
$nhif = "";
$netbill = "";
$invoiceno = "";
$dischargedby = "";
$wardcode = "";
$locationcode = "";
$patientcode = "";
$consultationfee = 0;
$labrate = 0;
$pharmamount = 0;
$radrate=0;
$serrate=0;
$bedallocationamount = 0;
$bedtransferamount = 0;
$packageamount = 0;

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

$query2 = "select * from master_ward where auto_number = '$wardcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2wardnamename = $res2['ward'];

$currentdate = date('d/m/Y H:i:s');

?>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #3b3b3c; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #3b3b3c;  text-decoration:none
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
			<td colspan="15"><br></td>
		</tr>
		<tr>
			<td class="bodytext31"  valign="middle"  align="left" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>
		</tr>
		<tr>
			<td class="bodytext31"  valign="middle"  align="left" ><strong>Discharge Register From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  
		</tr>
		<tr>
			<td colspan="15"><br></td>
		</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
		<?php 
			if($wardcode == '0'){
	          $query24 = "select * from master_ward";
        	} else {
	          $query24 = "select * from master_ward where auto_number = '$wardcode'";
	        }
          	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
          	while ($res24 = mysqli_fetch_array($exec24)){
            $wardautonumber = $res24['auto_number'];
            ?>
            <tr>
            <td colspan="15" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res24['ward']; ?></strong></td>
            </tr>
          	<tr>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>OP No.</strong></td><
	          <col width="70"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Ip Number</strong></td>
	          <col width="100"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>D.O.A.</strong></td>
			  <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>D.O.A. Time</strong></td>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>D.O.D</strong></td>
			<col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>D.O.D Time</strong></td>
			<col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>LOS</strong></td>
	          <col width="100"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Class</strong></td>
	          <col width="85"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
	          <col width="80"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Consulting Doctor</strong></td>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Revenue</strong></td>
	          <col width="40"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Returns</strong></td>
	          <col width="40"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Discount</strong></td> 
	          <col width="40"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>NHIF</strong></td> 
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Net Bill</strong></td>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Invoice NO.</strong></td>
	          <col width="60"><td width="7%" align="center" valign="center"  
	            bgcolor="#ffffff" class="bodytext31"><strong>Discharged By</strong></td> 
	        </tr>

	    <?php
          if($wardcode == '0'){
          $query110 = "select * from ip_discharge where ward = '$wardautonumber' and (recorddate between '$ADate1' and '$ADate2')";
          } else {
            $query110 = "select * from ip_discharge where ward = '$wardcode' and (recorddate between '$ADate1' and '$ADate2')";
          }
          $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
          // $res110 = mysql_fetch_array($exec110);

           while ($res110 = mysqli_fetch_array($exec110)){
              $patientcode = $res110['patientcode'];
              $patientname = $res110['patientname'];
              $visitcode = $res110['visitcode'];
              $dateofdischarge = $res110['recorddate'];
			  $dischargetime = $res110['recordtime'];
          
              $query1 = "select * from ip_bedallocation where visitcode = '$visitcode'";
              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
              $res1 = mysqli_fetch_array($exec1);
              $dateofadmission = $res1['recorddate']; 
              $bedallocateddate = $res1['recorddate'];  
              $allocateward = $res1['ward'];
              $packagedate = $res1['recorddate'];
			  $bedallocationtime = $res1['recordtime'];

              $query11 = "select * from master_visitentry where patientcode = '$patientcode'";
              $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res11 = mysqli_fetch_array($exec11);

              $opnumber = $res11['visitcode'];

              $query111 = "select * from master_ipvisitentry where visitcode = '$visitcode'";
              $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res111 = mysqli_fetch_array($exec111);

              $ipnumber = $res111['visitcode'];
              $admissiondoc = $res111['opadmissiondoctor'];
              $consultationfee = $res111['admissionfees'];
			        $billtype = $res111['billtype'];
			        $packagedate1 = $res111['consultationdate'];
              $packageanum = $res111['package'];
              $packageanum1 = $res111['package'];
              $consultingdoc = $res111['consultingdoctorName'];

              $querybill = "select billno, billdate from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";
              $execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
              $resbill = mysqli_fetch_array($execbill);
              $billno = $resbill['billno'];
              $billdate1 = $resbill['billdate'];
              
              $query112 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode' and req_status = 'discharge'";
              $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res112 = mysqli_fetch_array($exec112);

              $class = $res112['accountname'];
              $dischargedby = $res112['username'];

              $query113 = "select sum(rate) as rate, patientcode from ip_discount where patientvisitcode = '$visitcode'";
              $exec113 = mysqli_query($GLOBALS["___mysqli_ston"], $query113) or die("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));
              $res113 = mysqli_fetch_array($exec113);

              $query114 = "select * from ip_nhifprocessing where patientvisitcode = '$visitcode'";
              $exec114 = mysqli_query($GLOBALS["___mysqli_ston"], $query114) or die("Error in Query114".mysqli_error($GLOBALS["___mysqli_ston"]));
              $res114 = mysqli_fetch_array($exec114);
              $nhifqty = $res114['totaldays'];
              $nhifrate = $res114['nhifrebate'];
              $nhif = ($nhifqty * $nhifrate);

              $discount = $res113['rate'];

              $query115 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''";
              $exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
              $res115 = mysqli_fetch_array($exec115);

              $labrate = $res115['labitemrate'];

              $query120 = "select * from pharmacysalesreturn_details where patientcode = '$patientcode' and visitcode = '$visitcode'";
              $exec120 = mysqli_query($GLOBALS["___mysqli_ston"], $query120);
              $res120 = mysqli_fetch_array($exec120);

              $returns = $res120['totalamount'];

          $query116 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
  				$exec116 = mysqli_query($GLOBALS["___mysqli_ston"], $query116) or die ("Error in Query116".mysqli_error($GLOBALS["___mysqli_ston"]));
  				while($res116 = mysqli_fetch_array($exec116))
  				{
  					$phaamount=0;
  					$phaitemcode=$res116['itemcode'];
  				 	
  				 	$query117 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
  					$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in Query117".mysqli_error($GLOBALS["___mysqli_ston"]));
  				    while($res117 = mysqli_fetch_array($exec117))
  					{
  						$pharmamount=$res117['totalamount'];
  					}
  				}

        $totalbedallocationamount = 0;
      
       $requireddate = '';
       $quantity = '';
       $allocatenewquantity = '';
      $totalbedtransferamount=0;

      $ki=1;
      $querya01 = "select * from billing_ipbedcharges where visitcode='$visitcode' and patientcode='$patientcode' and bed <> '0'";
      $execa01 = mysqli_query($GLOBALS["___mysqli_ston"], $querya01) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $numa01 = mysqli_num_rows($execa01);
      while($resca01=mysqli_fetch_array($execa01)){

        $date=$resca01['recorddate'];
        $refno =$visitcode;
        $charge=$resca01['description'];
        $bed=$resca01['bed'];
        $ward=$resca01['ward'];
        $quantity=$resca01['quantity'];
        $rate=$resca01['rate'];
        $amount=$resca01['amount'];
        
        $querybed = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number='$bed'");
        $resbed = mysqli_fetch_array($querybed);
        $bedname = $resbed['bed'];
        
        $queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number='$ward'");
        $resward = mysqli_fetch_array($queryward);
        $wardname = $resward['description'];
        
        $totalbedallocationamount=$totalbedallocationamount+$amount;
      }

      $totalpharm=0;
      $totallab=0;
      $totalrad=0;
      $totalser=0;
      $fxrate = 1;
      
      $query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' and (entrydate between '$ADate1' and '$ADate2') GROUP BY ipdocno,itemcode";
      $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_pharmacy = mysqli_num_rows($exec23);
      
      while($res23 = mysqli_fetch_array($exec23))
      {
      $phaquantity=0;
      $quantity1=0;
      $phaamount=0;
      $phaquantity1=0;
      $totalrefquantity=0;
      $phaamount1=0;
      $phadate=$res23['entrydate'];
      $phaname=$res23['itemname'];
      $phaitemcode=$res23['itemcode'];
      $pharate=$res23['rate'];
      $refno = $res23['ipdocno'];
      $quantity=$res23['quantity'];
      $pharmfree = $res23['freestatus'];
      $amount=$pharate*$quantity;
      $query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
      $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res33 = mysqli_fetch_array($exec33))
      {
      $quantity=$res33['quantity'];
      $phaquantity=$phaquantity+$quantity;
      $amount=$res33['totalamount'];
      $phaamount=$phaamount+$amount;
      }
        $quantity=$phaquantity;
      $amount=$pharate*$quantity;
      $query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
      $exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res331 = mysqli_fetch_array($exec331);
      
      $quantity1=$res331['quantity'];
      //$phaquantity1=$phaquantity1+$quantity1;
      $amount1=$res331['totalamount'];
      //$phaamount1=$phaamount1+$amount1;
      
      $resquantity = $quantity - $quantity1;
      $resamount = $amount - $amount1;
            
      $resamount=($resamount/$fxrate);
      //if($resquantity != 0)
      {
      if(strtoupper($pharmfree) =='NO')
      {
    
      $totalpharm=$totalpharm+$resamount;
      }
      }
      }

      $query21 = "select consultationdate,servicesitemname,servicesitemrate,iptestdocno,freestatus,servicesitemcode,serviceqty from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname, iptestdocno";
      $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res21 = mysqli_fetch_array($exec21))
      {
      $totserrate = 0;
      $serdate=$res21['consultationdate'];
      $sername=$res21['servicesitemname'];
      $serrate=$res21['servicesitemrate'];
      $serref=$res21['iptestdocno'];
      $servicesfree = $res21['freestatus'];
      $sercode=$res21['servicesitemcode'];
      $serqty=$res21['serviceqty'];

      $totserrate=$serrate*$serqty;
      $totalser=$totalser+$totserrate;
      
      }

      $packageamount = 0;
       $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
      $exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $res731 = mysqli_fetch_array($exec731);
      $packageanum1 = $res731['package'];
      $packagedate1 = $res731['consultationdate'];
      $packageamount = $res731['packagecharge'];


      $totalotbillingamount = 0;
      $query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
      $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_ot = mysqli_num_rows($exec61);
      while($res61 = mysqli_fetch_array($exec61))
      {
      $otbillingdate = $res61['consultationdate'];
      $otbillingrefno = $res61['docno'];
      $otbillingname = $res61['surgeryname'];
      $otbillingrate = $res61['rate'];
      $otbillingrate = 1*($otbillingrate/$fxrate);
      $totalotbillingamount = $totalotbillingamount + $otbillingrate;
      }

      $totalprivatedoctoramount = 0;
      $query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
      $exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_pvt = mysqli_num_rows($exec62);
      while($res62 = mysqli_fetch_array($exec62))
      {
      $privatedoctordate = $res62['consultationdate'];
      $privatedoctorrefno = $res62['docno'];
      $privatedoctor = $res62['doctorname'];
      $privatedoctorrate = $res62['rate'];
      $privatedoctoramount = $res62['amount'];
      $privatedoctorunit = $res62['units'];
      $description = $res62['remarks'];
      if($description != '')
      {
      $description = '-'.$description;
      }
      $privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
      $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
      }

      $totalambulanceamount = 0;
      $query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
      $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_rescue = mysqli_num_rows($exec63);
    
      while($res63 = mysqli_fetch_array($exec63))
      {
      $ambulancedate = $res63['consultationdate'];
      $ambulancerefno = $res63['docno'];
      $ambulance = $res63['description'];
      $ambulancerate = $res63['rate'];
      $ambulanceamount = $res63['amount'];
      $ambulanceunit = $res63['units'];
      $ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
      $totalambulanceamount = $totalambulanceamount + $ambulanceamount;
      }

      $totalmiscbillingamount = 0;
      $query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
      $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_misc = mysqli_num_rows($exec69);
      while($res69 = mysqli_fetch_array($exec69))
      {
      $miscbillingdate = $res69['consultationdate'];
      $miscbillingrefno = $res69['docno'];
      $miscbilling = $res69['description'];
      $miscbillingrate = $res69['rate'];
      $miscbillingamount = $res69['amount'];
      $miscbillingunit = $res69['units'];
      $miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
      $totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
      }

      $totallab=0;
      $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No'";
      $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_lab = mysqli_num_rows($exec19);
        
      while($res19 = mysqli_fetch_array($exec19))
      {
      $labdate=$res19['consultationdate'];
      $labname=$res19['labitemname'];
      $labcode=$res19['labitemcode'];
      $labrate=$res19['labitemrate'];
      $labrefno=$res19['iptestdocno'];
      $labfree = $res19['freestatus'];
      
      if(strtoupper($labfree) == 'NO')
      {
      $queryl51 = "select labitemrate as rateperunit from `billing_iplab` where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labcode'";
      $execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $resl51 = mysqli_fetch_array($execl51);
      $labrate = $resl51['rateperunit'];
      
      $totallab=$totallab+$labrate;
      }
      }

      $totalrad=0;
      $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No'";
      $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num_radio = mysqli_num_rows($exec20);
            
      /*if($num_radio>0){
      echo "<tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   
      }*/
      
      while($res20 = mysqli_fetch_array($exec20))
      {
      $raddate=$res20['consultationdate'];
      $radname=$res20['radiologyitemname'];
      $radrate=$res20['radiologyitemrate'];
      $radref=$res20['iptestdocno'];
      $radiologyfree = $res20['freestatus'];
      $radiologyitemcode = $res20['radiologyitemcode'];
      if(strtoupper($radiologyfree) == 'NO')
      {
      $queryr51 = "select radiologyitemrate rateperunit from `billing_ipradiology` where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'";
      $execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $resr51 = mysqli_fetch_array($execr51);
      $radrate = $resr51['rateperunit'];
      $totalrad=$totalrad+$radrate;
      }
      }

		 $overalltotal = $consultationfee + $totallab + $totalbedallocationamount+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
     $netbill = $overalltotal - ($returns + $discount + $nhif);

        $snocount1 = $snocount + 1;
      
        $colorcode = 'bgcolor="#ffffff"';
        
          ?>
	        <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="middle"  align="center"><?php echo $opnumber; ?></td>
             	<td  align="center" valign="middle" class="bodytext31"><?php echo $ipnumber; ?></td>
                <td class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($patientname); ?></td>
                <td class="bodytext31" valign="middle"  align="center"><?php if($dateofadmission != ''){ echo date("d/m/Y", strtotime($dateofadmission)); } ?></td>
				<td class="bodytext31" valign="middle"  align="center"><?php if($bedallocationtime != ''){ echo $bedallocationtime; } ?></td>
           		<td class="bodytext31" valign="middle"  align="center"><?php if($dateofdischarge != ''){ echo date("d/m/Y", strtotime($dateofdischarge)); } ?></td>
				<td class="bodytext31" valign="middle"  align="center"><?php if($dischargetime != ''){ echo $dischargetime; } ?></td>
				<?php
				  $diff = strtotime($dateofdischarge.' '.$dischargetime) - strtotime($dateofadmission.' '.$bedallocationtime);
                  $hours = $diff / ( 60 * 60 );
		          ?>
                <td class="bodytext31" valign="middle"  align="center"><?php if($hours != ''){ echo number_format(($hours/24),2,'.',','); } ?></td>
                <td class="bodytext31" valign="middle"  align="center"><?php echo wordwrap(strtoupper($class),15,"<br>\n"); ?></td>
                <td class="bodytext31" valign="middle"  align="center"><?php $doc = explode(".", $admissiondoc); foreach($doc as $item){ echo ( wordwrap(wordwrap(strtoupper($item)." ", 12, "<br>\n"))); }?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($consultingdoc); ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($overalltotal,2); ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($returns,2); ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php if($discount != ''){ echo number_format($discount,2); } else { echo number_format('0'); }?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php if($nhif != ''){ echo number_format($nhif,2); } else { echo number_format('0'); } ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php echo number_format($netbill,2); ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php echo $billno; ?></td>
		        <td class="bodytext31" valign="middle"  align="center"><?php $parts = explode('.', $dischargedby); foreach($parts as $item){ echo strtoupper($item)." "; } ?></td>
          	</tr>
            <?php
        		}
			}
		?>
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
        $html2pdf->Output('print_discharge.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>



