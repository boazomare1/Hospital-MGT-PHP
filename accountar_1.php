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
				$sumbalance1 = '0.00';
				
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query221 = "select accountname,auto_number,id,subtype from master_accountname where accountssub = '$parentid' and subtype <> '0' and subtype <> '' group by subtype";
				$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res221 = mysqli_fetch_array($exec221))
				{ 
					$subtype = $res221['subtype'];
					$sumbalance = '0.00';
					
					$query77 = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtype'"));
					$subtypename = $query77['subtype'];
					
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
				
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' and subtype = '$subtype'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$accountname = addslashes ($res267['accountname']);
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					$lid = $lid + 1;
					$opening = 0;
					$i=0;
					$result = array();
					$querydr1 = "SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'
								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
								 UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%AOP%'
								 UNION ALL SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY LATER' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`debitamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($execdr1);
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
					$i = $i+1;
					$result[$i] = $resdr1['paylater'];
					}
					
					/*
					*/
					$j = 0;
					$crresult = array();
					$querycr1 = "SELECT SUM(fxamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(fxamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(`amount`) as paylatercredit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
								 UNION ALL SELECT SUM(`openbalanceamount`) as paylatercredit FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`transactionamount`) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT SUM(`creditamount`) as paylatercredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rescr1 = mysqli_fetch_array($execcr1))
					{
					$j = $j+1;
					$crresult[$j] = $rescr1['paylatercredit'];
					}
					
					
					$accountbank = array_sum($result) - array_sum($crresult);
					
					$sumbalance = $sumbalance + $accountbank;
					$sumbalance1 = $sumbalance1 + $accountbank;
					
				}
				?>
				<tr <?php echo $colorcode; ?>>
				<td colspan="3" align="left" class="bodytext3"><a href="detail_accountarsub.php?group=<?php echo $parentid; ?>&&subtype=<?php echo $subtype; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>" target="_blank"><strong><?php echo $subtypename; ?></strong></a></td>
				<td align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2,'.',','); ?></strong></td>
				</tr>
				<?php
				}
				$subtypename= 'UNLINKED ACCOUNTS';
				$sumbalance = '0.00';
				$query267 =" select accountname,auto_number,id from master_accountname where accountssub = '$parentid' and id NOT IN (select id from master_accountname where accountssub = '$parentid' and subtype <> '0' and subtype <> '')";
				//$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' and subtype = '$subtype'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$accountname = addslashes ($res267['accountname']);
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					$lid = $lid + 1;
					$opening = 0;
					$i=0;
					$result = array();
					$querydr1 = "SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'
								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
								 UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%AOP%'
								 UNION ALL SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY LATER' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`debitamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($execdr1);
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
					$i = $i+1;
					$result[$i] = $resdr1['paylater'];
					}
					
					/*
					*/
					$j = 0;
					$crresult = array();
					$querycr1 = "SELECT SUM(fxamount) as paylatercredit,'cr. n' AS fromtb FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(fxamount) as paylatercredit,'ipcr' AS fromtb FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(`amount`) as paylatercredit,'pharmacr' AS fromtb FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
								 UNION ALL SELECT SUM(`openbalanceamount`) as paylatercredit,'openening' AS fromtb FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`transactionamount`) as paylatercredit,docno AS fromtb FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT SUM(`creditamount`) as paylatercredit,'JV' AS fromtb FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rescr1 = mysqli_fetch_array($execcr1))
					{
					$j = $j+1;
					$crresult[$j] = $rescr1['paylatercredit'];
					if($rescr1['paylatercredit'] > '0.00')
					{
						//echo '<br>'.$id.'_'.$accountname.'_'.$rescr1['fromtb'].'_'.$rescr1['paylatercredit'];
					}
					}
					
					
					$accountbank = array_sum($result) - array_sum($crresult);
					
					$sumbalance = $sumbalance + $accountbank;
					$sumbalance1 = $sumbalance1 + $accountbank;
					
				}
				?>
				<tr <?php echo $colorcode; ?>>
				<td colspan="3" align="left" class="bodytext3" style="color:#0000CC"><strong><?php echo $subtypename; ?></strong></td>
				<td align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2,'.',','); ?></strong></td>
				</tr>
				
				</tbody>
		   <!-- <tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total Opening Balance:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="2" align="left" class="bodytext3" style="color:#000000"><strong>Total Ledger:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumbalance1,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
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
