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
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";
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
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$deptreferalamount = '';
$grandtotal3 = "0.00";
$totalexpense = "0.00";
$totalexpensecreditamount = "0.00";
$grandtotalcreditamount = "0.00";
$pharmacyamount = "";
$radiologyamount = "";
$servicesamount = "";
$referalamount = "";
$labamount = "";
$consultationamount = "";
$totalexpensecreditamount10 = "";
$grandtotalcreditamount10 = "";
$totaladvancedepositamount8 = "";
$totaladvanceipdepositamount81 = "";
//This include updatation takes too long to load for hunge items database.

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="trialbalance.xls"');
header('Cache-Control: max-age=80');

// for Excel Export
if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
if (isset($_REQUEST["sno"])) { $sno = $_REQUEST["sno"]; } else { $sno = ""; }
$sno = $sno + 2;
//echo $companyname;
// for print page
if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
//echo $companyname;

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) {  $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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

<script src="js/datetimepicker_css.js"></script>

<body>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="1">
          <tbody>
            		<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
		  $query48 = "select * from paymentmodecredit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num48 = mysqli_num_rows($exec48);
		  
	      $query49 = "select * from paymentmodedebit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num49 = mysqli_num_rows($exec49);
	
		
		  
		  if($num48 > $num49)
		  {
		  $rowspancount = $num48;
		  }
		  else
		  {
		  $rowspancount = $num49;
		  }
		  $rowspancount;
		  }
		  
		  ?>
		  	<tr>
			<td align="center" colspan="7"><strong>Trial Balance</strong></td>
			</tr>
			
			<tr>
			<td align="center" colspan="7"><strong>Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>
			</tr>
            <tr>
              <td colspan="2" width="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                  <td colspan="2" width="225" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td colspan="2" width="284" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
		      <td width="284" rowspan="7" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><table width="616" id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:-3px;" 
            bordercolor="" cellspacing="0" cellpadding="4" 
            align="left" border="1">
                <tr>
                  <td colspan="2" width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                  <td colspan="2" width="45%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                  <td colspan="2" width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
                </tr>
                <?php
			$totalexpensecreditamount10 = '';
/*			$query6 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec6 = mysql_query($query6) or die(mysql_error());
			while($res6 = mysql_fetch_array($exec6))
			{
			$accountsubid = $res6['id'];
			$accountsubanum = $res6['auto_number'];
			$accountsubname = $res6['accountssub'];
			$query7 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec7 = mysql_query($query7) or die(mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			{
			$accountcoa = $res7['id'];
			
			if($accountcoa != '')
			{
			$query8 = "select * from expensesub_details where expensecoa='$accountcoa' and transactiondate between '$ADate1' and '$ADate2'";
			$exec8 = mysql_query($query8) or die(mysql_error());
			while($res8 = mysql_fetch_array($exec8))
			{
			$expensedocno = $res8['docnumber'];
		
			if($expensedocno != '')
			{
			$query9 = "select sum(transactionamount) as creditamount1 from paymentmodecredit where billnumber='$expensedocno' and billdate between '$ADate1' and '$ADate2'";
			$exec9 = mysql_query($query9) or die(mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$expensecreditamount = $res9['creditamount1'];
			$totalexpensecreditamount = $totalexpensecreditamount + $expensecreditamount;
			}
			}
			}
			}
			if($totalexpensecreditamount != '0.00')
			{
			
			$totalexpensecreditamount10 = $totalexpensecreditamount10 + $totalexpensecreditamount;
			 $snocount = $snocount + 1;	
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
			
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountsubname; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalexpensecreditamount,2,'.',','); ?></td>
           
           </tr>
			<?php
			$totalexpensecreditamount = 0.00;
			}
			}*/
			
	?>
                <?php
			$grandtotalcreditamount10 = '';
			$ipfinaldiscountcreditapproved = '';
			
			$query61 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res61 = mysqli_fetch_array($exec61))
			{
			$accountsubid = $res61['id'];
			$accountsubanum = $res61['auto_number'];
			$accountsubname = $res61['accountssub'];
			$query71 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res71 = mysqli_fetch_array($exec71))
			{
			 $accountcoa = $res71['id'];
			
			if($accountcoa != '')
			{
			
			$query81 = "select sum(labitemrate) as labamount from billing_paynowlab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res81 = mysqli_fetch_array($exec81);
			$labamount = $res81['labamount'];
			
			$query87 = "select sum(labitemrate) as labamount from billing_paylaterlab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res87 = mysqli_fetch_array($exec87);
			$labamountpaylater = $res87['labamount'];
			if($labamount == '')
			{
			$query82 = "select sum(amount) as pharmacyamount from billing_paynowpharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res82 = mysqli_fetch_array($exec82);
		    $pharmacyamount = $res82['pharmacyamount'];
			}	
			if($labamountpaylater == '')
			{
			$query88 = "select sum(amount) as pharmacyamount from billing_paylaterpharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$pharmacyamountpaylater = $res88['pharmacyamount'];
			}		
			if(($labamount == '')&&($pharmacyamount == ''))
			{
			$query83 = "select sum(radiologyitemrate) as radiologyamount from billing_paynowradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res83 = mysqli_fetch_array($exec83);
			$radiologyamount = $res83['radiologyamount'];
			}		
					if(($labamountpaylater == '')&&($pharmacyamountpaylater == ''))
			{
			$query89 = "select sum(radiologyitemrate) as radiologyamount from billing_paylaterradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res89 = mysqli_fetch_array($exec89);
			$radiologyamountpaylater = $res89['radiologyamount'];
			}
			if(($labamount == '')&&($pharmacyamount == '')&&($radiologyamount == ''))
			{
			$query84 = "select sum(servicesitemrate) as servicesamount from billing_paynowservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec84 = mysqli_query($GLOBALS["___mysqli_ston"], $query84) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res84 = mysqli_fetch_array($exec84);
			$servicesamount = $res84['servicesamount'];
			}	
			if(($labamountpaylater == '')&&($pharmacyamountpaylater == '')&&($radiologyamountpaylater == ''))
			{
			$query90 = "select sum(servicesitemrate) as servicesamount from billing_paylaterservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res90 = mysqli_fetch_array($exec90);
			$servicesamountpaylater = $res90['servicesamount'];
			}	
			
			
			
		    $queryreferal = "select sum(referalrate) as referalamount from billing_paynowreferal where referalcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$execreferal = mysqli_query($GLOBALS["___mysqli_ston"], $queryreferal) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resreferal = mysqli_fetch_array($execreferal);
			$referalamount = $resreferal['referalamount'];
			
			if(($labamountpaylater == '')&&($pharmacyamountpaylater == '')&&($radiologyamountpaylater == '')&&($servicesamountpaylater == ''))
			{
			$query91 = "select sum(referalrate) as referalamount from billing_paylaterreferal where referalcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res91 = mysqli_fetch_array($exec91);
			$referalamountpaylater = $res91['referalamount'];
			}	
			
			$query86 = "select sum(consultation) as consultationamount from billing_consultation where consultationcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res86 = mysqli_fetch_array($exec86);
			$consultationamount = $res86['consultationamount'];
			
		  $query92 = "select sum(totalamount) as consultationamount from billing_paylaterconsultation where consultationcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec92= mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res92 = mysqli_fetch_array($exec92);
		  $consultationamountpaylater = $res92['consultationamount'];
		  
		  $query93 = "select sum(consultation) as consultationrefundamount from refund_consultation where consultationcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec93= mysqli_query($GLOBALS["___mysqli_ston"], $query93) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res93 = mysqli_fetch_array($exec93);
		  $consultationrefundamount = $res93['consultationrefundamount'];

		  $query18 = "select sum(labitemrate) as paynowlabrefundamount from refund_paynowlab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res18 = mysqli_fetch_array($exec18);
		  $paynowlabrefundamount = $res18['paynowlabrefundamount'];
		  
   	      $query19 = "select sum(radiologyitemrate) as paynowradiologyrefundamount from refund_paynowradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res19 = mysqli_fetch_array($exec19);
		  $paynowradiologyrefundamount = $res19['paynowradiologyrefundamount'];
		  
		  $query20 = "select sum(servicesitemrate) as paynowservicesrefundamount from refund_paynowservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res20 = mysqli_fetch_array($exec20);
		  $paynowservicesrefundamount = $res20['paynowservicesrefundamount'];
		  
    	  $query20 = "select sum(amount) as paynowpharmacyrefundamount from refund_paynowpharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res20 = mysqli_fetch_array($exec20);
		  $paynowpharmacyrefundamount = $res20['paynowpharmacyrefundamount'];
		  
		  $query21 = "select sum(referalrate) as paynowreferalrefundamount from refund_paynowreferal where referalcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res21 = mysqli_fetch_array($exec21);
		  $paynowreferalrefundamount = $res21['paynowreferalrefundamount'];
		  
		  

		  $totalrefundpaynow = $paynowlabrefundamount + $paynowradiologyrefundamount + $paynowservicesrefundamount + $paynowpharmacyrefundamount + $paynowreferalrefundamount;

			$ipfinaldiscount = 0;
			$ipfinaldeposit = 0;
		  $query22 = "select sum(labitemrate) as paylaterlabrefundamount from refund_paylaterlab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res22 = mysqli_fetch_array($exec22);
		  $paylaterlabrefundamount = $res22['paylaterlabrefundamount'];
		  
   	      $query23 = "select sum(radiologyitemrate) as paylaterradiologyrefundamount from refund_paylaterradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res23 = mysqli_fetch_array($exec23);
		  $paylaterradiologyrefundamount = $res23['paylaterradiologyrefundamount'];
		  
		  $query24 = "select sum(servicesitemrate) as paylaterservicesrefundamount from refund_paylaterservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res24 = mysqli_fetch_array($exec24);
		  $paylaterservicesrefundamount = $res24['paylaterservicesrefundamount'];
		  
    	  $query25 = "select sum(amount) as paylaterpharmacyrefundamount from refund_paylaterpharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res25 = mysqli_fetch_array($exec25);
		  $paylaterpharmacyrefundamount = $res25['paylaterpharmacyrefundamount'];
		  
		  $query26 = "select sum(referalrate) as paylaterreferalrefundamount from refund_paylaterreferal where referalcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res26 = mysqli_fetch_array($exec26);
		  $paylaterreferalrefundamount = $res26['paylaterreferalrefundamount'];
		  
		    $totalrefundpaylater = $paylaterlabrefundamount + $paylaterradiologyrefundamount + $paylaterservicesrefundamount + $paylaterpharmacyrefundamount + $paylaterreferalrefundamount;
			$totalpaylaterpharmrefundamount1 = 0;
		  $query237 = "select * from pharmacysalesreturn_details where pharmacycoa = '$accountcoa' and billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec237 = mysqli_query($GLOBALS["___mysqli_ston"], $query237) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num237 = mysqli_num_rows($exec237);
		  while($res237 = mysqli_fetch_array($exec237))
		  {
		  $paylaterpharmrefundpatientcode1 = $res237['patientcode'];
		  if($paylaterpharmrefundpatientcode1 != '')
		  {
		 
		  $query2371 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode1'";
		  $exec2371 = mysqli_query($GLOBALS["___mysqli_ston"], $query2371) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2371 = mysqli_fetch_array($exec2371);
		  $patientrefundtype1 = $res2371['billtype'];
		  
		  if($patientrefundtype1 == 'PAY LATER')
		  {
		  $paylaterpharmrefundamount1 = $res237['totalamount'];
		  $totalpaylaterpharmrefundamount1 = $totalpaylaterpharmrefundamount1 + $paylaterpharmrefundamount1;
		  }
		  }
		  }
		  
		  $query32 = "select sum(labitemrate) as ipfinallabamount from billing_iplab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res32 = mysqli_fetch_array($exec32);
		  $ipfinallabamount = $res32['ipfinallabamount'];
		  
		  $query52 = "select sum(labitemrate) as externallabamount from billing_externallab where labcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res52 = mysqli_fetch_array($exec52);
		  $externallabamount = $res52['externallabamount'];

		  
   	      $query33 = "select sum(radiologyitemrate) as ipfinalradiologyamount from billing_ipradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res33 = mysqli_fetch_array($exec33);
		  $ipfinalradiologyamount = $res33['ipfinalradiologyamount'];
		  
   	      $query53 = "select sum(radiologyitemrate) as externalradiologyamount from billing_externalradiology where radiologycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res53 = mysqli_fetch_array($exec53);
		  $externalradiologyamount = $res53['externalradiologyamount'];

		  
		  $query34 = "select sum(servicesitemrate) as ipfinalservicesamount from billing_ipservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res34 = mysqli_fetch_array($exec34);
		  $ipfinalservicesamount = $res34['ipfinalservicesamount'];
		  
		  $query54 = "select sum(servicesitemrate) as externalservicesamount from billing_externalservices where servicecoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res54 = mysqli_fetch_array($exec54);
		  $externalservicesamount = $res54['externalservicesamount'];

		  
    	  $query35 = "select sum(amount) as ipfinalpharmacyamount from billing_ippharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res35 = mysqli_fetch_array($exec35);
		  $ipfinalpharmacyamount = $res35['ipfinalpharmacyamount'];
		  
		  $query55 = "select sum(amount) as externalpharmacyamount from billing_externalpharmacy where pharmacycoa='$accountcoa' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res55 = mysqli_fetch_array($exec55);
		  $externalpharmacyamount = $res55['externalpharmacyamount'];

		  $query36 = "select sum(amount) as ipfinalprivatedoctoramount from billing_ipprivatedoctor where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query36".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res36 = mysqli_fetch_array($exec36);
		  $ipfinalprivatedoctoramount = $res36['ipfinalprivatedoctoramount'];
		  
		  $query37 = "select sum(amount) as ipfinalotbillingamount from billing_ipotbilling where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query37".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res37 = mysqli_fetch_array($exec37);
		  $ipfinalotbillingamount = $res37['ipfinalotbillingamount'];


		  $query38 = "select sum(amount) as ipfinalmiscbilling from billing_ipmiscbilling where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res38 = mysqli_fetch_array($exec38);
		  $ipfinalmiscbilling = $res38['ipfinalmiscbilling'];

  		  $query39 = "select sum(amount) as ipfinalbedcharges from billing_ipbedcharges where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die ("Error in Query39".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res39 = mysqli_fetch_array($exec39);
		 $ipfinalbedcharges = $res39['ipfinalbedcharges'];

 		  $query40 = "select sum(amount) as ipfinalambulance from billing_ipambulance where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec40= mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res40 = mysqli_fetch_array($exec40);
		 $ipfinalambulance = $res40['ipfinalambulance'];
		  
		  $query41 = "select sum(amount) as ipfinalnhif from billing_ipnhif where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec41= mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res41 = mysqli_fetch_array($exec41);
		  $ipfinalnhif = $res41['ipfinalnhif'];


		  $query43 = "select sum(amount) as ipfinaladmissioncharge from billing_ipadmissioncharge where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec43= mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die ("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res43 = mysqli_fetch_array($exec43);
		 $ipfinaladmissioncharge = $res43['ipfinaladmissioncharge'];
		  
		  if($ipfinaladmissioncharge != '')
		  {
		  
		  $query42 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ip where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec42= mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res42 = mysqli_fetch_array($exec42);
		  $ipfinaldiscount = $res42['ipfinaldiscount'];
		  $ipfinaldeposit = $res42['ipfinaldeposit'];
		  
		  $query421 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec421= mysqli_query($GLOBALS["___mysqli_ston"], $query421) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res421 = mysqli_fetch_array($exec421);
		  $ipfinaldiscountcreditapproved = $res421['ipfinaldiscount'];
		  $ipfinaldepositcreditapproved = $res421['ipfinaldeposit'];

		  
		  }
		  
		  $query120 = "select sum(amount) as openbalance from openingbalanceaccount where coa='$accountcoa' and entrydate between '$ADate1' and '$ADate2'";
		  $exec120 = mysqli_query($GLOBALS["___mysqli_ston"], $query120) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res120 = mysqli_fetch_array($exec120);
		  $openbalance = $res120['openbalance'];

			}
			
			
			
			
			$totalipamount = $ipfinallabamount  + $ipfinaladmissioncharge  + $ipfinalambulance + $ipfinalbedcharges + $ipfinalmiscbilling + $ipfinalotbillingamount + $ipfinalprivatedoctoramount + $ipfinalpharmacyamount + $ipfinalservicesamount +  $ipfinalradiologyamount - $ipfinaldiscount - $ipfinaldiscountcreditapproved;
			
			$totalamountcredit = $labamount + $pharmacyamount + $radiologyamount + $servicesamount + $referalamount + $consultationamount + $labamountpaylater + $pharmacyamountpaylater + $radiologyamountpaylater + $servicesamountpaylater + $referalamountpaylater + $consultationamountpaylater - $consultationrefundamount - $totalrefundpaynow - $totalrefundpaylater - $totalpaylaterpharmrefundamount1 + $openbalance;
			
			$totalexternalamount = $externallabamount + $externalradiologyamount + $externalservicesamount + $externalpharmacyamount;
			
			$grandtotalcreditamount = $grandtotalcreditamount + $totalamountcredit + $totalipamount + $totalexternalamount;
			
				  
		 
	        
			$pharmacyamount = "";
			$radiologyamount = "";
			$servicesamount = "";
			$referalamount = "";
			$labamount = "";
			$consultationamount = "";
			$labamountpaylater = "";
			$pharmacyamountpaylater = "";
			$radiologyamountpaylater = "";
			$servicesamountpaylater = "";
			$referalamountpaylater = "";
			$consultationamountpaylater = "";
			$consultationrefundamount = "";
			$paylaterpharmrefundpatientcode = '';
			$ipfinallabamount = "";
			$ipfinaladmissioncharge = "";
			$ipfinalnhif = "";
			$ipfinalambulance = "";
			$ipfinalbedcharges = "";
			$ipfinalmiscbilling = "";
			$ipfinalotbillingamount = "";
			$ipfinalprivatedoctoramount= "";
			$ipfinalpharmacyamount= "";
			$ipfinalservicesamount = "";
			$ipfinalradiologyamount = "";
			$ipfinaldiscount = "";
			$ipfinaldiscountcreditapproved = "";
			$externallabamount  = "";
			$externalradiologyamount  = "";
			$externalservicesamount  = "";
			$externalpharmacyamount  = "";
			}
			if($grandtotalcreditamount != '0.00')
			{
		if($grandtotalcreditamount > 0)
		{
		
			$grandtotalcreditamount10 = $grandtotalcreditamount10 + $grandtotalcreditamount;
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
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $accountsubname; ?></div></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($grandtotalcreditamount,2,'.',','); ?></td>
                </tr>
                <?php
			$grandtotalcreditamount = 0.00;
			}
			}
			}
			$totalreceiptcreditamount811 = '';
						$query341 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res341 = mysqli_fetch_array($exec341))
			{
			
			$accountsubid = $res341['id'];
			$accountsubanum = $res341['auto_number'];
			$accountsubname = $res341['accountssub'];
			$query441 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec441 = mysqli_query($GLOBALS["___mysqli_ston"], $query441) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res441 = mysqli_fetch_array($exec441))
			{
			$accountcoa = $res441['id'];
			$totalreceiptcreditamount81 = '0.00';
			
			$query881 = "select * from receiptsub_details where receiptcoa='$accountcoa' and transactiondate between '$ADate1' and '$ADate2'";
			$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res881 = mysqli_fetch_array($exec881))
			{
			$receiptdocno = $res881['docnumber'];
			$receiptamountdetail = $res881['transactionamount'];
		
			$totalreceiptcreditamount81 = $totalreceiptcreditamount81 + $receiptamountdetail;
			
			}
			if($totalreceiptcreditamount81 != '0.00')
			{
			$totalreceiptcreditamount811 = $totalreceiptcreditamount811 + $totalreceiptcreditamount81;
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
                <tr >
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $accountsubname; ?></div></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalreceiptcreditamount81,2,'.',','); ?></td>
                </tr>
                <?php
		   }
		   }
		  
		   }
	?>
                <?php
	$balanceamount1 = '';
	$grandbalanceamount = '0.00';
	$totalgrandbalanceamount = '0.00';
			$query341 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res341 = mysqli_fetch_array($exec341))
			{
			
			$accountsubid = $res341['id'];
			$accountsubanum = $res341['auto_number'];
			$accountsubname = $res341['accountssub'];
			$totalpayments = 0;
			
			$query11 = "select sum(transactionamount) as totalgrnamount from master_transactionpharmacy where supplieranum='$accountsubid' and transactionmode='CREDIT' and transactiondate between '$ADate1' and '$ADate2'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
		    $totalgrnamount = $res11['totalgrnamount'];
			
			$query12 = "select * from master_transactionpharmacy where supplieranum='$accountsubid' and transactionmodule='PAYMENT' and transactiondate between '$ADate1' and '$ADate2' group by docno";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res12 = mysqli_fetch_array($exec12))
			{
			$transdocno = $res12['docno'];
			
				$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$transdocno'";
				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res51 = mysqli_fetch_array($exec51);
				$totalamount = $res51['transactionamount'];  
				
				$totalpayments = $totalpayments + $totalamount;

			}
			
			$totalpaymentamount = $totalpayments;
			
			$query13 = "select sum(totalamount) as totalreturnamount from purchasereturn_details where accountssubcode='$accountsubid' and entrydate between '$ADate1' and '$ADate2'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$totalreturnamount = $res13['totalreturnamount'];
			
if(($totalgrnamount != '')||($totalpaymentamount != '')||($totalreturnamount != ''))
{

			$grandbalanceamount = $totalgrnamount - $totalpaymentamount - $totalreturnamount;
			}
			
				 if($grandbalanceamount != '0.00')
				 { 
				 $totalgrandbalanceamount = $totalgrandbalanceamount + $grandbalanceamount;
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
                <tr >
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $accountsubname; ?></div></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($grandbalanceamount,2,'.',','); ?></td>
                </tr>
                <?php
		 
		  }
		  $grandbalanceamount = '0.00';
				}
				?>
                <?php
					$totalipdepositamount81 = '';
					
			$query343 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec343 = mysqli_query($GLOBALS["___mysqli_ston"], $query343) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res343 = mysqli_fetch_array($exec343))
			{
			
			$accountsubid = $res343['id'];
			$accountsubanum = $res343['auto_number'];
			$accountsubname = $res343['accountssub'];
			$query443 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec443 = mysqli_query($GLOBALS["___mysqli_ston"], $query443) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res443 = mysqli_fetch_array($exec443))
			{
			$accountcoa = $res443['id'];
			$totalipdepositamount8 = '0.00';
			$totaldepositamount = 0;
			$totaldeposit1 = 0;	
			$totaladvancedepositamount8 = 0;
			$query8831 = "select * from master_transactionipdeposit where coa='$accountcoa' and transactionmodule <> 'Adjustment' and transactiondate between '$ADate1' and '$ADate2' group by docno";
			$exec8831 = mysqli_query($GLOBALS["___mysqli_ston"], $query8831) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res8831 = mysqli_fetch_array($exec8831))
			{
			$ipdepositdocno = $res8831['docno'];
			$ipdepositamountdetail = $res8831['transactionamount'];
		
			$totalipdepositamount8 = $totalipdepositamount8 + $ipdepositamountdetail;
			
			}
			
			$query8832 = "select * from master_transactionadvancedeposit where coa='$accountcoa' and transactiondate between '$ADate1' and '$ADate2' group by docno";
			$exec8832 = mysqli_query($GLOBALS["___mysqli_ston"], $query8832) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num8832 = mysqli_num_rows($exec8832);
			while($res8832 = mysqli_fetch_array($exec8832))
			{
			$advancedepositdocno = $res8832['docno'];
			$advancedepositamountdetail = $res8832['transactionamount'];
		
			$totaladvancedepositamount8 = $totaladvancedepositamount8 + $advancedepositamountdetail;
			
			}
			
			$query51 = "select sum(amount) as totaldepositrefund from deposit_refund where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2'";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res51 = mysqli_fetch_array($exec51);
			$totaldepositrefund = $res51['totaldepositrefund'];
			
		  $totaldepositamount = $totalipdepositamount8 + $totaladvancedepositamount8 - $totaldepositrefund;
			
			
				$query893 = "select sum(deposit) as totaldeposit from billing_ip where depositcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec893 = mysqli_query($GLOBALS["___mysqli_ston"], $query893) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res893 = mysqli_fetch_array($exec893))
			{
			
			 $totaldeposit = $res893['totaldeposit'];
		
			}
			$query8931 = "select sum(deposit) as totaldeposit from billing_ipcreditapproved where depositcoa='$accountcoa' and billdate between '$ADate1' and '$ADate2'";
			$exec8931 = mysqli_query($GLOBALS["___mysqli_ston"], $query8931) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res8931 = mysqli_fetch_array($exec8931))
			{
			
			 $totalcreditdeposit = $res8931['totaldeposit'];
		
			}
		  $totaldeposit1 =  $totalcreditdeposit +  $totaldeposit;
		  if($totaldeposit1 != 0)
		  {
		 $totaldeposit1 = $totaldeposit1;
		  }
			
			 $totaldepositamount = $totaldepositamount - $totaldeposit1;
			
			if($totaldepositamount != '0.00')
			{
			
			$totalipdepositamount81 = $totalipdepositamount81 + $totaldepositamount;
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
                <tr >
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $accountsubname; ?></div></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totaldepositamount,2,'.',','); ?></td>
                </tr>
                <?php
		   }
		   }
		  
		   }
				?>
                <?php
	
	$grandtotalcredit = $grandtotalcreditamount10 + $totalexpensecreditamount10 + $totalreceiptcreditamount811 + $totalgrandbalanceamount + $totalipdepositamount81 + $totaladvanceipdepositamount81;
	?>
                <tr>
                  <td colspan="2" class="bodytext31" valign="center"  align="left"></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
                  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($grandtotalcredit,2,'.',','); ?></td>
                </tr>
              </table></td>
            </tr>
			
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			 $snocount = '';
			 $totalexpense10 = '';
			 $accountssubname = '';
			 $grandtotal1 = '';
		  $query2 = "select * from paymentmodedebit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];
		  $query21 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res21 = mysqli_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res212 = mysqli_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		  
		   $totalamount3 = $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		   $grandtotal3 = $grandtotal3 + $totalamount3;
		  
		  }
		  
		   $query28 = "select * from paymentmodecredit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res28= mysqli_fetch_array($exec28))
		  {
     	  $res2transactiondate8 = $res28['billdate'];
		  $res2billnumber8 = $res28['billnumber'];
		  $res2accountname = $res28['accountname'];
		  $cashamount28 = $res28['cash']; 
		  $cardamount28 = $res28['card'];
		  $chequeamount28 = $res28['cheque'];
		  $onlineamount28 = $res28['online'];
		  $mpesaamount28 = $res28['mpesa'];
		   $totalamount38 = $cashamount28 + $cardamount28 + $chequeamount28 + $onlineamount28 + $mpesaamount28;
		
			$grandtotal1 = $grandtotal1 + $totalamount38;
			
			}
			
		  $grandtotal31 = $grandtotal3 - $grandtotal1;
			
			//echo $cashamount;
			if($grandtotal31 != 0)
			{
			
			 $snocount = $snocount + 1;	
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
			
           <tr >
              <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td colspan="2" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountssubname; ?></div></td>
              <td colspan="2" class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandtotal31,2,'.',','); ?> </td>
            </tr>
			<?php
			}
			$totalexpense10 = 0;
			$query3 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$accountsubid = $res3['id'];
			$accountsubanum = $res3['auto_number'];
			$accountsubname = $res3['accountssub'];
			$query4 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res4 = mysqli_fetch_array($exec4))
			{
			$accountcoa = $res4['id'];
			$accountname = $res4['accountname'];
			
			
			$totalbalanceamount = 0;
			
			
			
			$query2 = "select * from master_transactionpaylater where accountname = '$accountname' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			$totalnum2 = $totalnum2 + $num2;
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$cashamount21 = 0.00;
			$billnumber = $res2['billnumber'];
		    $billtotalamount = $res2['transactionamount'];
			$gran =  $gran + $billtotalamount;
			
			    $query31 = "select * from master_transactionpaylater where billnumber = '$billnumber' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numbr=mysqli_num_rows($exec31);
				//echo $numbr;
				while ($res31 = mysqli_fetch_array($exec31))
				{
					//echo $res3['auto_number'];
				    $cashamount1 = $res31['cashamount'];
					$onlineamount1 = $res31['onlineamount'];
					$chequeamount1 = $res31['chequeamount'];
					$cardamount1 = $res31['cardamount'];
					$tdsamount1 = $res31['tdsamount'];
					$writeoffamount1 = $res31['writeoffamount'];
					//echo $cashamount1;
					$cashamount21 = $cashamount21 + $cashamount1;
					
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
			    $netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				$totalbalanceamount = $totalbalanceamount + $balanceamount;
			}
			
		 
		
				$totalexpense = $totalexpense + $totalbalanceamount;
			}
			if($totalexpense != '0.00')
			{
			
		  $query22 = "select sum(totalamount) as paylaterrefundamount from refund_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res22 = mysqli_fetch_array($exec22);
		  $paylaterrefundamount = $res22['paylaterrefundamount'];
		  
		 $totalexpense = $totalexpense + $paylaterrefundamount;
		 
		  $query72 = "select sum(transactionamount) as onaccountamount from master_transactionpaylater where transactionstatus = 'onaccount' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res72 = mysqli_fetch_array($exec72);
		  $onaccountamount = $res72['onaccountamount'];
		  
		 $totalexpense = $totalexpense - $onaccountamount;

		  
		  $totalpaylaterpharmrefundamount = 0;
		  $query23 = "select * from pharmacysalesreturn_details where billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res23 = mysqli_fetch_array($exec23))
		  {
		  $paylaterpharmrefundpatientcode = $res23['patientcode'];
		  
		  $query231 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode'";
		  $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res231 = mysqli_fetch_array($exec231);
		  $patientrefundtype = $res231['billtype'];
		  
		  if($patientrefundtype == 'PAY LATER')
		  {
		  $paylaterpharmrefundamount = $res23['totalamount'];
		  $totalpaylaterpharmrefundamount = $totalpaylaterpharmrefundamount + $paylaterpharmrefundamount;
		  }
		  }
		  
		  
		  
		  
	$totalexpense = $totalexpense - $totalpaylaterpharmrefundamount;

			$totalexpense10 = $totalexpense10 + $totalexpense;
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
			
           <tr >
              <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td colspan="2" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountsubname; ?></div></td>
              <td colspan="2" class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalexpense,2,'.',','); ?> </td>
            </tr>
			<?php
			$totalexpense = 0.00;
			$totalbalanceamount = 0.00;
			$expenseamount = 0.00;
			
		
			}
			}
			$totalexpensecreditamount81 = '';
			$query34 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res34 = mysqli_fetch_array($exec34))
			{
			
			$accountsubid = $res34['id'];
			$accountsubanum = $res34['auto_number'];
			$accountsubname = $res34['accountssub'];
			$query44 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res44 = mysqli_fetch_array($exec44))
			{
			$accountcoa = $res44['id'];
			$totalexpensecreditamount8 = '0.00';
			
			$query88 = "select * from expensesub_details where expensecoa='$accountcoa' and transactiondate between '$ADate1' and '$ADate2'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res88 = mysqli_fetch_array($exec88))
			{
			$expensedocno = $res88['docnumber'];
			$expenseamountdetail = $res88['transactionamount'];
		
			$totalexpensecreditamount8 = $totalexpensecreditamount8 + $expenseamountdetail;
			
			}
			if($totalexpensecreditamount8 != '0.00')
			{
			$totalexpensecreditamount81 = $totalexpensecreditamount81 + $totalexpensecreditamount8;
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
			
           <tr >
              <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td colspan="2" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountsubname; ?></div></td>
              <td colspan="2" class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalexpensecreditamount8,2,'.',','); ?></td>
            </tr>
		   <?php
		   }
		   }
		  
		   }
		   
		  
		   	$totalgrnamount81 = '';
			$query343 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec343 = mysqli_query($GLOBALS["___mysqli_ston"], $query343) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res343 = mysqli_fetch_array($exec343))
			{
			
			$accountsubid = $res343['id'];
			$accountsubanum = $res343['auto_number'];
			$accountsubname = $res343['accountssub'];
			$query443 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec443 = mysqli_query($GLOBALS["___mysqli_ston"], $query443) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res443 = mysqli_fetch_array($exec443))
			{
			$accountcoa = $res443['id'];
			$totalgrnamount8 = '0.00';
			
			$query883 = "select * from purchase_details where coa='$accountcoa' and suppliername <> 'OPENINGSTOCK' and entrydate between '$ADate1' and '$ADate2'";
			$exec883 = mysqli_query($GLOBALS["___mysqli_ston"], $query883) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res883 = mysqli_fetch_array($exec883))
			{
			$grndocno = $res883['billnumber'];
			$grnamountdetail = $res883['totalamount'];
		
			$totalgrnamount8 = $totalgrnamount8 + $grnamountdetail;
			
			}
			 $query1201 = "select sum(amount) as openbalancesupplier from openingbalancesupplier where coa='$accountcoa' and entrydate between '$ADate1' and '$ADate2'";
		  $exec1201 = mysqli_query($GLOBALS["___mysqli_ston"], $query1201) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res1201 = mysqli_fetch_array($exec1201);
		  $openbalancesupplier = $res1201['openbalancesupplier'];

			$totalgrnamount8 = $totalgrnamount8 + $openbalancesupplier;
						
			

			if($totalgrnamount8 != '0.00')
			{
			
			$query13 = "select sum(totalamount) as totalreturnamount from purchasereturn_details where entrydate between '$ADate1' and '$ADate2'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$totalreturnamount = $res13['totalreturnamount'];
			
			$totalgrnamount8 = $totalgrnamount8 - $totalreturnamount;

			$totalgrnamount81 = $totalgrnamount81 + $totalgrnamount8;
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
			
           <tr >
              <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td colspan="2" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountsubname; ?></div></td>
              <td colspan="2" class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalgrnamount8,2,'.',','); ?></td>
            </tr>
		    <?php
		   }
		   }
		  
		   }
			
	?>	     
						
					<?php
					$grandtotalnhif =0;
			$query343 = "select * from master_accountssub where recordstatus <> 'deleted'";
			$exec343 = mysqli_query($GLOBALS["___mysqli_ston"], $query343) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res343 = mysqli_fetch_array($exec343))
			{
			
			$accountsubid = $res343['id'];
			$accountsubanum = $res343['auto_number'];
			$accountsubname = $res343['accountssub'];
			$query443 = "select * from master_accountname where accountssub = '$accountsubanum'";
			$exec443 = mysqli_query($GLOBALS["___mysqli_ston"], $query443) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res443 = mysqli_fetch_array($exec443))
			{
			$accountcoa = $res443['id'];
			$accountname = $res443['accountname'];
			
			
			$query894 = "select sum(amount) as totalnhif from billing_ipnhif where coa='$accountcoa' and recorddate between '$ADate1' and '$ADate2'";
			$exec894 = mysqli_query($GLOBALS["___mysqli_ston"], $query894) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res894 = mysqli_fetch_array($exec894))
			{
			
			 $totalnhif = $res894['totalnhif'];
			 $totalnhif = -($totalnhif);
		
			}
			
			
			
			$grandtotalreceivable = $totalnhif;
			
			if($grandtotalreceivable != '')
			{
			$grandtotalnhif = $grandtotalnhif + $grandtotalreceivable;
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
              <td colspan="2" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td colspan="2" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountsubname; ?></div></td>
              <td colspan="2" class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandtotalreceivable,2,'.',','); ?></td>
            </tr>
		   <?php
		   }
		   }
		  
		   }
				?>
	<?php
	
	$grandtotaldebit = $totalexpense10 + $grandtotal31 + $totalexpensecreditamount81 + $totalgrnamount81 + $grandtotalnhif;
	?>
	         <tr>
			 <td colspan="2" class="bodytext31" valign="center"  align="left"></td>
			  <td colspan="2" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($grandtotaldebit,2,'.',','); ?></td>
		     </tr>
			  </tbody>
        </table>
		</td>
      </tr>
			<?php
			}
			?>
         
</table>
</table>
</body>
</html>
