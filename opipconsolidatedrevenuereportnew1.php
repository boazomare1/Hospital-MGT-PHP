<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('d-m-Y');
$paymentreceiveddateto = date('d-m-Y');

$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$cashamount1='';
$cashamount='';
$sumunfinal='0.00';
$cashamount5='';
$totalopcash='';
$totalipcash='';
$testcashamount='';
$searchsuppliername = "";
$overaltotalrefund='';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom =$_REQUEST["ADate1"];
	$paymentreceiveddateto = $_REQUEST["ADate2"];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = date("Y-m-d", strtotime($_REQUEST["ADate1"])); } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = date("Y-m-d", strtotime($_REQUEST["ADate2"])); } else { $ADate2 = ""; }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="opipconsolidatedrevenuereportnew1.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP/IP Consolidated Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1', 'DDMMYYYY')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2', 'DDMMYYYY')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
	<?php
	$sumpackage=0.00;
	$sumpharmacy=0.00;
	$sumlab=0.00;
	$sumrad=0.00;
	$sumservice=0.00;
	$sumtransaction='';
	$ipfinalizedamount='';
	$refundamount=0.00;
	$sumbed=0.00;
		
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	if ($cbfrmflag1 == 'cbfrmflag1')
	{
		$i = 0;
	$drresult = array();
	
	$j = 0;
	$crresult = array();
	$querycr1 = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`cashamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$j = $j+1;
	//print_r($resdr1);
	$crresult[$j] = $rescr1['income'];
	//$paylater = $result[$i];
	}	
	//echo "total ".array_sum($crresult)." and ".array_sum($drresult);
	$totalopcash = array_sum($crresult) - array_sum($drresult);
	
	$querycr11 = "SELECT SUM(`fxamount`) as income FROM `billing_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
	$execcr11 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr11) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr11 = mysqli_fetch_array($execcr11))
	{
	$j = $j+1;
	//print_r($resdr1);
	$crresult1[$j] = $rescr11['income'];
	//$paylater = $result[$i];
	}	
	//echo "total ".array_sum($crresult)." and ".array_sum($drresult);
	 $totalopcrdt = array_sum($crresult1);

	//$balance = ($paylater + $ippaylater + $nhif + $opening); //- ($credit + $refund + $receipt);
	$cashamount5 = $totalopcrdt;
	
$totalbedcharges='0.00';
$labtotal = "0.00";
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

						$j = 0;
	$crresultphar = array();
	$querycr1phar = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE  a.billdate BETWEEN '$ADate1' AND '$ADate2'";
	$execcrphar1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1phar) or die ("Error in querycr1phar".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescrphar1 = mysqli_fetch_array($execcrphar1))
	{
	$j = $j+1;
	$crresultphar[$j] = $rescrphar1['income'];
	}
	$totalpharmacysaleamount = array_sum($crresultphar);
						$j = 0;
						$crresultlab = array();
						$querycr1lab = "SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
									   //UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
						$execcrlab1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1lab) or die ("Error in querycr1lab".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrlab1 = mysqli_fetch_array($execcrlab1))
						{
						$j = $j+1;
						$crresultlab[$j] = $rescrlab1['income'];
						}	
						$labtotal = array_sum($crresultlab);
			  $j = 0;
						$crresultrad = array();
						$querycr1rad = "SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
									   //UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
						$execcrrad1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1rad) or die ("Error in querycr1rad".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrrad1 = mysqli_fetch_array($execcrrad1))
						{
						$j = $j+1;
						$crresultrad[$j] = $rescrrad1['income'];
						}	
						$totalradiologyitemrate = array_sum($crresultrad);
			  					
					$j = 0;
						$crresultser = array();
						$querycr1ser = "SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' ";
									   //UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
						$execcrser1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1ser) or die ("Error in querycr1ser".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrser1 = mysqli_fetch_array($execcrser1))
						{
						$j = $j+1;
						$crresultser[$j] = $rescrser1['income'];
						}
						$totalservicesitemrate = array_sum($crresultser);
		
		$j = 0;
						$crresultin = array();
						$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'";
						$execcrin1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrin1 = mysqli_fetch_array($execcrin1))
						{
						$j = $j+1;
						$crresultin[$j] = $rescrin1['income'];
						}
						$incomeother = array_sum($crresultin);
			$crresultdis = array();
		$querycr1dis = "SELECT SUM(`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";
		$execcrdis1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dis) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescrdis1 = mysqli_fetch_array($execcrdis1))
		{
		$i = $i+1;
		$crresultdis[$i] = $rescrdis1['income'];
		}
		  
		$balance = array_sum($crresultdis);
		$totaldiscountrate = $totaldiscountrate + $balance;		  
		
		
			$ipunfinalizeamount=$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalpharmacysaleamount-$totaldiscountrate+$incomeother;
		
	 $sumtransaction = $ipunfinalizeamount;
	
					//include ('ipunfinalizedrevenue.php');
		include ('ipunfinalizedrevenuejoin.php');
												//echo $ipunfinalizeamount;
		$sumunfinal=$ipunfinalizeamount;
		$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
		include("opunfinalizedreport.php");			
		$totalamount1;

			$group='21';
	$ledgerid='08-9301-NHL';
					$totalamount=0;
					$openingbalance1=0;
					
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					$id = $res267['id'];
				
						if($id != '')
					{		
						/* */			 
						$depositref = 0;
						
						$querydr1dp = "SELECT sum(amount) as depositref FROM `deposit_refund` WHERE `recorddate` < '$ADate1' 
									   UNION ALL SELECT sum(deposit) as depositref FROM `billing_ip` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(debitamount) as depositref FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						
						 $depositref += $resdr1['depositref'];
						// $ledgertotal = $ledgertotal - $depositref;
						}		
					
						$deposit = 0;
						
						$querycr1dp = "SELECT sum(transactionamount) as deposit FROM `master_transactionadvancedeposit` WHERE `transactiondate` < '$ADate1' 
									   UNION ALL SELECT sum(transactionamount) as deposit FROM `master_transactionipdeposit` WHERE `transactiondate` < '$ADate1'  AND `transactionmodule` = 'PAYMENT'
									   UNION ALL SELECT sum(creditamount) as deposit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dp) or die ("Error in querycr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						 $deposit += $rescr1['deposit'];
						// $ledgertotal = $ledgertotal + $deposit;
						}
						
					$totalamount +=$deposit-$depositref;	
					}
						
					}
					
				$openingbalance1 =$totalamount;
				//echo $openingbalance1;
				$deposit=0;
				$depositref=0;
				$openingbalance1=0;
				?>
					 
					<?php
						
					$scount3=0;
				$ledgertotal = 0;
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					
						if($id != '')
					{		
						/* */			 
						$i = 0;
						$drresult = array();
						$querydr1dp = "SELECT deposit, code, name, docno, date FROM (SELECT (-1*`amount`) as deposit, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `deposit_refund` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*ABS(`deposit`)) as deposit, patientcode as code, patientname as name, billno as docno, billdate as date FROM `billing_ip` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`debitamount`) as deposit, ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									   UNION ALL SELECT `creditamount` as deposit,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as de order by de.date";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						 $depositref = $resdr1['deposit'];
						 $code = $resdr1['code'];
						 $name = $resdr1['name'];
						 $docno = $resdr1['docno'];
						 $date = $resdr1['date'];
						 $scount3=$scount3+1;
						 if($scount3==1)
						 {
						 $ledgertotal = $ledgertotal + $depositref+$openingbalance1;
						 }
						 else
						 {
							 $ledgertotal = $ledgertotal + $depositref;
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
					
                        <?php
						}		
						$sumunfinal=$sumunfinal+$ledgertotal;				
					}
					else
					{
						//$balance = 0;
					}
							
					}
				
					?>
				
				<?php	
				
				
		
					
			?>
            <tr>
              <td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><a target="_blank" href="viewoprevenuereportdetails.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">OP Cash</a> </strong></td>
              <td width="22%" align="right" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalopcash,2,'.',','); ?></td>
              <td width="10%" align="left" valign="center" bgcolor="#ecf0f5"  
                 class="style1"></td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>
                <a target="_blank" href="linkipfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">
                IP Finalized </a></strong></td>
              <td width="21%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($sumtransaction,2,'.',','); ?></td>
            </tr>
            <tr>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">
                <a target="_blank" href="viewopcredit.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">
                OP Credit</a> </td>
              <td align="right" valign="left"  
                bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($cashamount5,2,'.',','); ?></td>
              <td align="left" valign="center"  
                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">
                <span class="style1">
                <a target="_blank" href="linkipunfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">
                IP Un<strong>finalized </strong></a></span></td>
              <td align="right" valign="center"  
                bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($sumunfinal,2,'.',','); ?></td>
            </tr>
			<?php 
			$totalop='';
			$totalip='';
			$totalopandip = "";
			
			$totalop=$totalopcash + $cashamount5 + $totalamount1;
			$totalip=$sumtransaction + $sumunfinal;
			$totalopandip = $totalop + $totalip;
			?>
			 <tr>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">
 <a target="_blank" href="viewopunfinalizedreportdetails.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">
              OP Unfinalized</a> </td>
              <td align="right" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalamount1,2,'.',','); ?></td>
              <td align="left" valign="center"  
                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><span class="style1">Total IP</span></td>
              <td align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalip,2,'.',','); ?></strong></td>
            </tr>
			
            <tr>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1"><span class="style1">Total OP</span></td>
              <td  align="right" valign="center" 
                bgcolor="#CBDBFA" class="style1"><?php echo number_format($totalop,2,'.',','); ?></td>
              <td align="left" valign="center"  
                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><span class="style1">Total OP + IP</span></td>
              <td align="right" valign="center"  
                bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format($totalopandip,2,'.',','); ?></strong></td>
            </tr>
			<?php
		    
		  //$query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where transactiondate between '$ADate1' and '$ADate2' "; 
		 
					if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = date("Y-m-d", strtotime($_REQUEST["ADate1"])); } else { $transactiondatefrom = ""; }

//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $transactiondateto = date("Y-m-d", strtotime($_REQUEST["ADate2"])); } else { $transactiondateto = ""; }
					
				//	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';
					
		//   echo "hii".$locationcode1;
		     $query23 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res23 = mysqli_fetch_array($exec23);
		  
     	 $res2cashamount1 = $res23['cashamount1'];
		  $res2onlineamount1 = $res23['onlineamount1'];
		  $res2creditamount1 = $res23['creditamount1'];
		  $res2chequeamount1 = $res23['chequeamount1'];
		  $res2cardamount1 = $res23['cardamount1'];
		  
		  // echo  "hi".$res23['creditamount1'];
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where  billingdatetime between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where   recorddate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res54 = mysqli_fetch_array($exec54))
{

		
			  $res54cashamount1 = $res54['cashamount1'];
		  $res54onlineamount1 = $res54['onlineamount1'];
		  $res54creditamount1 = $res54['creditamount1'];
		  $res54chequeamount1 = $res54['chequeamount1'];
		  $res54cardamount1 = $res54['cardamount1'];
			

			

			}  //refund adv
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];

		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
$query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  
     	   $res11cashamount1 = $res11['cashamount1'];
		  $res11onlineamount1 = $res11['onlineamount1'];
		  $res11creditamount1 = $res11['creditamount1'];
		  $res11chequeamount1 = $res11['chequeamount1'];
		  $res11cardamount1 = $res11['cardamount1'];

		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
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
			<tr>
			<td colspan="5" align="left">&nbsp;</td>
			</tr>
			<tr>
			<td bgcolor="#ecf0f5" colspan="6" align="left" class="bodytext31"><strong>Collection Summary</strong></td>
			</tr>
			 <tr>
              
              <td width="21%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cash</strong></div></td>
				<td width="18%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Card</strong></div></td>
				<td width="17%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cheque</strong></div></td>
				<td width="17%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Online</strong></div></td>
				<td width="17%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Mpesa</strong></div></td>
				<td width="19%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
               
            </tr>
           <tr <?php echo $colorcode; ?>>
             
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($cashamount1,2,'.',','); ?></div>  </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($cardamount1,2,'.',','); ?></div>  </td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
				<td width="2%"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">
			    <div align="right">&nbsp;</div></td>
				
               
           </tr>
		   <?php
		   
	
		   
		   ?>
			<tr>
			<td bgcolor="#ecf0f5" colspan="6" align="left">&nbsp;</td>
			</tr>
			
          </tbody>
        </table></td>
      </tr>
	 <?php } ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

