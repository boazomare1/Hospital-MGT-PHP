<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
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
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }
if (isset($_REQUEST["ledgerid"])) { $ledgerid = $_REQUEST["ledgerid"]; } else { $ledgerid = ""; }
if (isset($_REQUEST["ledgeranum"])) { $ledgeranum = $_REQUEST["ledgeranum"]; } else { $ledgeranum = ""; }
if (isset($_REQUEST["ledger"])) { $ledger = $_REQUEST["ledger"]; } else { $ledger = ""; }
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
        <td valign="top"><table width="1300" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
				$query2 = "select accountssub from master_accountssub where auto_number = '$ledgeranum' and recordstatus <> 'deleted'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 = mysqli_fetch_array($exec2);
				$accountsmain2 = $res2['accountssub'];
				$accarr = array();
				?>
				<tbody>
				<tr>
				<td colspan="15" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountsmain2.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="50" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Patient Code'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Visit Code'; ?></strong></td>
				<td width="250" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="160" align="right" class="bodytext3"><strong><?php echo 'Service Amount'; ?></strong></td>
				<?php
				$query21 = "select id,accountname from master_accountname where accountssub = '$ledgeranum'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res21 = mysqli_fetch_array($exec21))
				{
					array_push($accarr,$res21['id']);
				?>
				<td width="160" align="right" class="bodytext3"><strong><?php echo $res21['accountname']; ?></strong></td>
				<?php
				}
				?>
                <td width="140" align="right" class="bodytext3"><strong><?php echo 'Profi/Loss'; ?></strong></td>
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
				$openingbalance1=0;
				$ledgertotal=0;
				$totalprofitloss =0;
				$scount=0;
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query267 = "select id,accountssub,auto_number from master_accountssub where auto_number = '$ledgeranum'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{
				$id = $res267['id'];
				$ledgeranum = $res267['auto_number'];
				$accountsmain2 = $res267['accountssub'];
				
				$i = 0;
	
		$crresult1 = array();
		$querycr1in = "SELECT a.`fxamount` as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1'
						UNION ALL SELECT (a.`servicesitemrate`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT (a.`fxamount`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1'
						UNION ALL SELECT (a.`servicesitemrateuhx`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
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
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $rescr1['income']+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $rescr1['income'];
						}
						$serviceitemamount = 0;
						$profitloss=0;
		?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php  foreach($accarr as $accid) {
							
							$i = 0;
							$crresult1 = array();
							$querycr11in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'"; 
						$execcr11 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr11in) or die ("Error in querycr11in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr11 = mysqli_fetch_array($execcr11))
						{
							$i = $i+1;
							$crresult1[$i] = $rescr11['income'];
						}
							$rescr11income=array_sum($crresult1);
						$serviceitemamount = $serviceitemamount + $rescr11income;
						?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr11income),2); ?></td>
						<?php } 
						$profitloss = $rescr1['income']-$serviceitemamount;
						
		$totalprofitloss = $totalprofitloss+$profitloss;
						?>
                        <td align="right" class="bodytext3"><?= number_format($profitloss,2);?></td>
                        </tr>
						<?php
		}
				
				$balance = array_sum($crresult1); 
				$journal=0;
		$query2671 = "select id,accountssub,auto_number from master_accountssub where parentid = '$id'";
				$exec2671 = mysqli_query($GLOBALS["___mysqli_ston"], $query2671) or die ("Error in Query2671".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2671 = mysqli_fetch_array($exec2671))
				{
					$id1 = $res2671['id'];
		$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal += $jncredit - $jndebit;
				}	
				//$balance=$balance+$totalamount3;
									
					$sumbalance = $sumbalance + $balance + $journal;
					
					?>
					<tr bgcolor="#CCC">
					<td colspan="5" align="left" class="bodytext3"><strong>Total: </strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2,'.',','); ?></strong></td>
					<?php  foreach($accarr as $accid) {?>
					<td align="right" class="bodytext3"><strong></strong></td>
					<?php }?>
					<td align="right" class="bodytext3"><strong><?php echo number_format($totalprofitloss,2,'.',','); ?></strong></td>
					</tr>
				
				</tbody>
				<?php
			}
			?>
		   <!-- <tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total Opening Balance:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			
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
