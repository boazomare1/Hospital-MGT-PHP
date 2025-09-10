<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$grandtotal='';
$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '';
$nettotal = '0.00';
$totallab = '0.00';
$totalservices = '0.00';
$totalpharmacy = '0.00';
$totalradiology = '0.00';
$totalreferrel = '0.00';
$totalconsultation = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$res3labitemratereturn = '';
$accountname = '';
$radiologyitemrate1  = '';
$totalamount1 = 0;

ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="opipreport.xls"');
header('Cache-Control: max-age=80');

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<body>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="1">
          <tbody>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></td>
              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Username</strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#FFF" class="bodytext31"><div align="right"></div></td>
            </tr>
			<?php
			
			
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			
			$searchsuppliername='';
			 $totlab='';
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
			<?php
			$query21 = "select accountname from master_visitentry where billtype='PAY LATER' and overallpayment='completed' and consultationdate between '$ADate1' and '$ADate2' group by accountname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select accountname,id,auto_number from master_accountname where auto_number = '$res21accountname' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res22accountnameid = $res22['id'];
			$res22accountanum = $res22['auto_number'];
			
			if( $res22accountname != '')
			{
			?>
			<tr bgcolor="#fff">
            <td colspan="17"  align="left" valign="center" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		  $query1 = "select auto_number,accountname,id from master_accountname where id = '$res22accountnameid'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res1 = mysqli_fetch_array($exec1);
		  $res1auto_number = $res1['auto_number'];
		  $res1accountname = $res1['accountname'];
		  $res1accountnameid = $res1['id'];
			
		  $totalpharmacysalesreturn=0;
	       
		   $res2billno = '';
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='completed' and accountname = '$res1auto_number' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientname = $res2['patientfullname'];
		  $res2registrationdate = $res2['consultationdate'];
		  $res2billdate = $res2['consultationdate'];
		  $res2accountname = $res2['accountfullname'];
		  $subtype = $res2['subtype'];
		  $plannumber = $res2['planname'];
			$res11paymenttype1 = $res2['paymenttype'];
			$res12username = $res2['username'];
			
			$querypaymentt = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "select paymenttype from master_paymenttype where auto_number = '$res11paymenttype1'"));
			$res11paymenttype = $querypaymentt['paymenttype'];
			
			$querypaymentt2 = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "select billno from billing_paylater where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'"));
			$res2billno = $querypaymentt2['billno'];
			
			$queryplanname = "select forall,planname from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$planpercentage=$res2['planpercentage'];
			$res4planname = $resplanname['planname'];
			//$copay=($consultationfee/100)*$planpercentage;
			
		  
		  $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$res2patientcode'");
			$execlab=mysqli_fetch_array($Querylab);
			$patientsubtype=$execlab['subtype'];
			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
			$execsubtype=mysqli_fetch_array($querysubtype);
			$patientsubtype1=$execsubtype['subtype'];
			$patientsubtypeano=$execsubtype['auto_number'];
			$patientplan=$execlab['planname'];
			$currency=$execsubtype['currency'];
			$fxrate=$execsubtype['fxrate'];
			if($currency=='')
			{
				$currency='UGX';
			}
			$labtemplate = $execsubtype['labtemplate'];
			if($labtemplate == '') { $labtemplate = 'master_lab'; }
			$radtemplate = $execsubtype['radtemplate'];
			if($radtemplate == '') { $radtemplate = 'master_radiology'; }
			$sertemplate = $execsubtype['sertemplate'];
			if($sertemplate == '') { $sertemplate = 'master_services'; }
		  
		  $res3labitemrate = 0;
		  $query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec3))
		  {
		  		$labcode = $res3['labitemcode']; 
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'] * $fxrate;
				if(($planpercentage!=0.00)&&($planforall=='yes'))
			  	{ 
					$labrate = $labrate - ($labrate/100)*$planpercentage;
				}
				$res3labitemrate = $res3labitemrate + $labrate;
		  }
		  
		  $res4servicesitemrate = 0;
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' and paymentstatus = 'completed' and wellnessitem <> '1' and approvalstatus <> '2' and approvalstatus = '1' ";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
		  {
		  	 $sercode=$res4['servicesitemcode'];
			 $serqty=$res4['serviceqty'];
			 $serrefqty=$res4['refundquantity'];
			
			 $serqty = $serqty-$serrefqty;
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'] * $fxrate;
			$serrate = $serrate * $serqty;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$serrate = $serrate - ($serrate/100)*$planpercentage;
			}
			$res4servicesitemrate = $res4servicesitemrate + $serrate;
		  }
		  
		  $res5radiologyitemrate = 0;
		  $query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		  	$radcode=$res5['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'] * $fxrate;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$radrate = $radrate - ($radrate/100)*$planpercentage;
			}
			$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
		  }
		  
		  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6referalrate = $res6['referalrate1'];
		  if ($res6referalrate =='')
		  {
		  $res6referalrate = '0.00';
		  }
		  else 
		  {
		    $res6referalrate = $res6['referalrate1'] * $fxrate;
		  }
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
		  }
		  
		  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  $res7consultationfees = $res7['consultationfees1'] * $fxrate;
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $copay=($res7consultationfees/100)*$planpercentage;
		  }
		  else
		  {
		  $copay = 0;
		  }
		  $res7consultationfees = $res7consultationfees - $copay;
		  
		  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $res8copayfixedamount = $res8['copayfixedamount1'];
		  $res8copayfixedamount = 0;
		  
		  $consultation = $res7consultationfees - $res8copayfixedamount;
		  
		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9pharmacyrate = $res9['totalamount1'];
		  
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res9['totalamount1'];
		  }
		  
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
		  }
		  
			$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numpharmacysalereturn=mysqli_num_rows($exec321);
		  $totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
		  //echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
		    $res321 = mysqli_fetch_array($exec321);

		  $res9pharmacyreturnrate = $res321['totalamount2'];
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
		  }
		  $res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;
		  $overaltotalrefund = 0;
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		   $overaltotalrefund = 0;
		  
		 
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		
	//$balance = ($paylater + $ippaylater + $nhif + $opening); //- ($credit + $refund + $receipt);
		  //$total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;
		  
		  $total = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totallab=$totallab+$res3labitemrate;
		  $totalservices=$totalservices + $res4servicesitemrate;
		  $totalpharmacy=$totalpharmacy + $res9pharmacyrate;
		  $totalradiology=$totalradiology + $res5radiologyitemrate;
		  $totalreferrel = $totalreferrel +$res6referalrate;
		  $totalconsultation=$totalconsultation + $consultation;
		  
		  
		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res4planname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res4servicesitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9pharmacyrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($consultation,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6referalrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res12username); ?></td>
              <td class="bodytext31" valign="center"  align="left">&nbsp; </td>
           </tr>
			<?php
			$res21accountname ='';
			
			}
			}
			$res22accountname ='';
	        }
			
			//$totalrevenue= $totlab+$res6servicesitemrate1+$res7pharmacyitemrate1+$res8radiologyitemrate1+$res9referalitemrate1+$res10consultationitemrate;
			
			?>
             <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><!--Total--></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totalservices,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totalpharmacy,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totalradiology,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totalconsultation,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><div align="right"><strong><?php echo number_format($totalreferrel,2);?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" bgcolor="#fff" class="bodytext31">&nbsp;</td>
			
			</tr>
			
          </tbody>
        </table>