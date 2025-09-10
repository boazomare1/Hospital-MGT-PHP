<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";   
$ttlamt = '0.00';
$banum = "1";
$gran =0;
$totalnum2 = 0 ;
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$totalamount3 = "0.00";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$totalamount12 = "0.00";
//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d',strtotime('-1 month')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["groupid"])) { $parentid = $_REQUEST["groupid"]; } else { $parentid = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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
    <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td valign="top"><table width="701" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
				$query2 = "select accountssub from master_accountssub where auto_number = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 = mysqli_fetch_array($exec2);
				
				$accountsmain2 = $res2['accountssub'];
				?>
				<tbody>
				<tr>
				<td colspan="5" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountsmain2.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<?php
				$colorloopcount = '';
				$orderid1 = '';
				$lid = '';
				$openingbalance = "0.00";
				$sumopeningbalance = "0.00";
				$totalamount2 = '0.00';
				$totalamount12 = '0.00';
				$balance = '0.00';
				$sumbalance = '0.00';
				$totalconsultation = 0;
				
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$balance=0;
					$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal = $jncredit - $jndebit;
					
					$queryops = "SELECT SUM(`openbalanceamount`) as debit FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execops = mysqli_query($GLOBALS["___mysqli_ston"], $queryops) or die ("Error in queryops".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resops = mysqli_fetch_array($execops);
					$ops = $resops['debit'];
					$queryopa = "SELECT SUM(`openbalanceamount`) as credit FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execopa = mysqli_query($GLOBALS["___mysqli_ston"], $queryopa) or die ("Error in queryopa".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resopa = mysqli_fetch_array($execopa);
					$opa = $resopa['credit'];
					
					$opamount = $ops-$opa;
					
					if($id == '03-3002-NHL')
					{
						$i = 0;
						$drresult = array();
						$querydr1in = "SELECT SUM(`consultation`) as incomedebit FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
										UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
										UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
										UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['incomedebit'];
						}
						
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_opambulancepaylater` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_homecarepaylater` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`openbalanceamount`) as income FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					    		       UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
										UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
										UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
										UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['income'];
						}
						$incomeother = array_sum($crresult) - array_sum($drresult);
						
						$query2 = "select * from master_visitentry where billtype='PAY LATER' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) order by accountfullname desc ";
						  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						  while ($res2 = mysqli_fetch_array($exec2))
						  {
						  $res2patientcode = $res2['patientcode'];
						  $res2visitcode = $res2['visitcode'];
						  $res2patientfullname = $res2['patientfullname'];
						  $res2registrationdate = $res2['consultationdate'];
						  $res2accountname = $res2['accountfullname'];
						  $subtype = $res2['subtype'];
						  $plannumber = $res2['planname'];
						  
						  $queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
							$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resplanname = mysqli_fetch_array($execplanname);
							$planforall = $resplanname['forall'];
							$planpercentage=$res2['planpercentage'];
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
		  			  $totalconsultation = $totalconsultation + $consultation;

					    $res6referalrate = '0.00';
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
					  else
					  {
					    $res6referalrate = $res6['referalrate1'] * $fxrate;
					  }
					  $totalconsultation = $totalconsultation + $res6referalrate;

					  }
					  
					  $balance = $totalconsultation + $incomeother;
						
					}
					
					//unfinal
					else if($id == '03-3002-OI')
					{
					$sno = 0;
					$totalpharmacysalesreturn=0;
	   $totalconsult=0;   
	   $totalconsult=0;    
	   $totalamount1 = 0;
		  $totalamount2 = 0;
		  $totalamount3 = 0;
		  $totalamount4 = 0;
		  $totalamount5 = 0;
		  $totalamount6 = 0;
		  $totalamount7 = 0;
		  $overaltotalrefund =0;
		  $snocount =0; 
		  $labtotal =0;
		  $totalradiologyitemrate = "0.00";
$totalservicesitemrate = "0.00";
$totalprivatedoctoramount = "0.00";
$totalpharmacysaleamount = "0.00";
$totalpharmacysalereturnamount = "0.00";
$totalambulanceamount = "0.00";
$totalipmis = "0.00";
$totaldiscountrate = "0.00";
$totalnhifamount = "0.00";
$totalipdepositamount = "0.00";
$totalbedcharges = "0.00";
$totalbedtransfercharges = "0.00";
$totalpackage = "0.00";
$totaladmncharges = "0.00";
$ipunfinalizeamount='';
$ipfinalizedamount='';

					$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			
			$querymenu = "select * from master_customer where customercode='$patientcode'";
			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$nummenu=mysqli_num_rows($execmenu);
			$resmenu = mysqli_fetch_array($execmenu);
			$menusub=$resmenu['subtype'];
			
			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$menusub'");
			$execsubtype=mysqli_fetch_array($querysubtype);
			$patientsubtype1=$execsubtype['subtype'];
			$bedtemplate=$execsubtype['bedtemplate'];
			$labtemplate=$execsubtype['labtemplate'];
			$radtemplate=$execsubtype['radtemplate'];
			$sertemplate=$execsubtype['sertemplate'];
			$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtt32 = mysqli_num_rows($exectt32);
			$exectt=mysqli_fetch_array($exectt32);
			$bedtable=$exectt['referencetable'];
			if($bedtable=='')
			{
				$bedtable='master_bed';
			}
			$bedchargetable=$exectt['templatename'];
			if($bedchargetable=='')
			{
				$bedchargetable='master_bedcharge';
			}
			$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
			$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtl32 = mysqli_num_rows($exectl32);
			$exectl=mysqli_fetch_array($exectl32);		
			$labtable=$exectl['templatename'];
			if($labtable=='')
			{
				$labtable='master_lab';
			}
			
			$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtt32 = mysqli_num_rows($exectt32);
			$exectt=mysqli_fetch_array($exectt32);		
			$radtable=$exectt['templatename'];
			if($radtable=='')
			{
				$radtable='master_radiology';
			}
			
			$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtt32 = mysqli_num_rows($exectt32);
			$exectt=mysqli_fetch_array($exectt32);
			$sertable=$exectt['templatename'];
			if($sertable=='')
			{
				$sertable='master_services';
			}
			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mastervalue = mysqli_fetch_array($exec32);
			$currency=$mastervalue['currency'];
			$fxrate=$mastervalue['fxrate'];
			$subtype=$mastervalue['subtype'];
		
		$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			$totaladmncharges = $totaladmncharges + $consultationfee;
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
					  $packageamount = 0;
					  $packageamountuhx=0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			$packageamountuhx=$packageamount*$fxrate;
			$totalpackage = $totalpackage + $packageamountuhx;
			 
			$totalbedallocationamount = 0;
			$totalbedallocationamountuhx=0;
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];
			
			
			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			$type = $res73['type'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from `$bedtable` where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			
			  
			   $totalbedallocationamount=0;
			   $totalbedallocationamountuhx=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								$colorloopcount = $sno + 1;
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
								$totalbedallocationamount=$totalbedallocationamount+($amount);
								$amountuhx = $rate*$quantity;
								$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);
								$totalbedcharges = $totalbedcharges + ($amountuhx*$fxrate);
					  
							}
						}
					}
				}
				$totalbedtransferamount=0;
				$totalbedtransferamountuhx=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$bedcharge='0';
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						//echo $quantity;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						//echo $bedcharge;
						if($bedcharge=='0')
						{
							//$quantity;
							if($quantity>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
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
									$totalbedtransferamount=$totalbedtransferamount+($amount);
									$amountuhx = $rate*$quantity;
									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);
									$totalbedtransfercharges = $totalbedtransfercharges + ($amountuhx*$fxrate);
						  
								}
							}
							else
							{
								if($charge=='Bed Charges')
								{
									//$bedcharge='1';
								}
							}
						}
					}
				}
			 
			$totalpharm=0;
			$totalpharmuhx=0;
			  $totallab=0;
			    $totallabuhx=0;
	
				$totalrad=0;
				$totalraduhx=0;
			  $totalser=0;
					$totalseruhx=0;
		    
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res63 = mysqli_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
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
			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;
			 $totalambulanceamount = $totalambulanceamount + $ambulanceamountuhx;
		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;
			
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$totalmiscbillingamountuhx=0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
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
			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			
			 $miscbillingamountuhx = $miscbillingrate*$miscbillingunit;
			 $totalipmis = $totalipmis + $miscbillingamountuhx;
		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;
			
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$totaldiscountamountuhx=0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = $discountrate;
			$authorizedby = $res64['authorizedby'];
			
						
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
			$discountrate = 1*($discountrate1/$fxrate);
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			
			 $discountrateuhx = $discountrate1;
			 $totaldiscountrate = $totaldiscountrate + $discountrateuhx;
		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;
			
				}			  
		} 
		
			$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage;
		
		$balance = $ipunfinalizeamount;
						
					}
					
					$sumbalance = $sumbalance + $balance + $journal+$opamount;
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
					<tr <?php echo $colorcode; ?> style="display" id="<?php echo $lid; ?>">
					<td colspan="3" align="left" class="bodytext3"><strong><?= $id; ?>
					<a href="ledgerreport.php?group=<?= $parentid; ?>&&ledgerid=<?= $id; ?>&&ledgeranum=<?= $ledgeranum; ?>&&location=<?= $location; ?>&&ADate1=<?= $ADate1; ?>&&ADate2=<?= $ADate2; ?>&&ledger=<?= $accountsmain2; ?>&&cbfrmflag1=cbfrmflag1" target="_blank"><?php echo $colorloopcount; ?>. <?php echo $accountsmain2; ?></a></strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($balance,2,'.',','); ?></strong></td>
					</tr>
				
				<?php
				}
			?>
		   <!-- <tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total Opening Balance:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="2" align="left" class="bodytext3" style="color:#000000"><strong>Total Ledger:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<!--<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($totalamount12+$sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
</table>
</td>
</tr>

</table>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>
