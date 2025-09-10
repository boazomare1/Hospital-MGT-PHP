<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2018-09-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2018-09-01"; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
?>
<script>
function totalsum()
{
	var debit = document.getElementById("debit").value;
	var credit = document.getElementById("credit").value;
	
	var diff = parseFloat(credit) - parseFloat(debit);
	var diff = parseFloat(diff);
	if(diff > 0)
	{
	debit = parseFloat(debit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("suspenseleft").value = diff;
	document.getElementById("suspenseright").value = "0.00";
	}
	else
	{
	diff = Math.abs(diff);
	credit = parseFloat(credit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("suspenseright").value = diff;
	document.getElementById("suspenseleft").value = "0.00";
	}
	debit = parseFloat(debit).toFixed(2);
	debit = debit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	credit = parseFloat(credit).toFixed(2);
	credit = credit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	document.getElementById("debit").value = debit;
	document.getElementById("credit").value = credit;
}
</script>
<table border="1" width="100%" style="border-collapse:collapse;">
<tr>
<td colspan="12" align="center" valign="middle"><strong>MED 360</strong></td>
</tr>
<tr>
<td colspan="12" align="center" valign="middle"><strong>IP Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="12" align="center" valign="middle"><strong>From &nbsp; <input type="date" name="ADate1" value="<?= $ADate1; ?>" />&nbsp; To &nbsp; <input type="date" name="ADate2" value="<?= $ADate2; ?>" />&nbsp;</strong>
<input type="hidden" name="cbfrmflag1" id="cbfrmflag1" value="cbfrmflag1" />
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php if($cbfrmflag1 == 'cbfrmflag1') { 

$tot = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,);
?>
<tr>
<td align="left"><strong>Date</strong></td>
<td align="left"><strong>Bill No</strong></td>
<td align="left"><strong>Visitcode</strong></td>
<td align="left"><strong>Billtype</strong></td>
<td align="left"><strong>Account</strong></td>
<td align="left"><strong>Account Code</strong></td>
<td align="right"><strong>Amount (Dr)</strong></td>
<td align="right"><strong>Admission (Cr)</strong></td>
<td align="right"><strong>Amb (Cr)</strong></td>
<td align="right"><strong>Bed Chrg (Cr)</strong></td>
<td align="right"><strong>Lab (Cr)</strong></td>
<td align="right"><strong>Misc (Cr)</strong></td>
<td align="right"><strong>Home (Cr)</strong></td>
<td align="right"><strong>Phar (Cr)</strong></td>
<td align="right"><strong>Dr (Cr)</strong></td>
<td align="right"><strong>Rad (Cr)</strong></td>
<td align="right"><strong>Ser (Cr)</strong></td>
<td align="right"><strong>Adv Deposit</strong></td>
<td align="right"><strong>Deposit</strong></td>
<td align="right"><strong>Discount</strong></td>
<td align="right"><strong>NHIF</strong></td>
<td align="right"><strong>Dep Refund</strong></td>
<td align="right"><strong>Total</strong></td>
<td align="right"><strong>Diff</strong></td>
<td align="center"><strong>Status</strong></td>
</tr>
<?php 
$query8 = "SELECT a.visitcode as visitcode,a.billnumber as billnumber,a.transactionamount as transactionamount, a.totalamountuhx as totalamountuhx,a.cashamount as cashamount,a.onlineamount as onlineamount,a.chequeamount as chequeamount,a.creditamount as creditamount,a.mpesaamount as mpesaamount,a.cardamount as cardamount,a.returnbalance as returnbalance,a.transactiondate as transactiondate,a.accountname as accountname,a.accountnameid as accountnameid,b.billtype as billtype FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res8 = mysqli_fetch_array($exec8))
{
$docno = $res8['billnumber'];
$visitcode = $res8['visitcode'];
$billtype = $res8['billtype'];
$cashamount = $res8['cashamount'];
$creditamount = $res8['creditamount'];
$chequeamount = $res8['chequeamount'];
$mpesaamount = $res8['mpesaamount'];
$cardamount = $res8['cardamount'];
$onlineamount = $res8['onlineamount'];
$returnbalance = $res8['returnbalance'];
if($returnbalance > 0) { $returnbalance = 0; }
if($billtype == 'PAY NOW')
{
$transactionamount = $cashamount+$creditamount+$chequeamount+$mpesaamount+$cardamount+$onlineamount+$returnbalance;
} else {
$transactionamount = $res8['totalamountuhx'];
}
$transactiondate = $res8['transactiondate'];
$accountname = $res8['accountname'];
$accountcode = $res8['accountnameid'];
$amount1 = $amount1 + $transactionamount;
?>
<tr>
<td align="left" valign="middle"><?= date('d-m-Y',strtotime($transactiondate)); ?></td>
<td align="left" valign="middle"><?= $docno; ?></td>
<td align="left" valign="middle"><?= $visitcode; ?></td>
<td align="left" valign="middle"><?= $billtype; ?></td>
<td align="left" valign="middle"><?= $accountname; ?></td>
<td align="left" valign="middle"><?= $accountcode; ?></td>
<td align="right" valign="middle"><?= number_format($transactionamount,2); ?></td>
<?php	
$i = 0;
$drresult = array();
$querydr1bnk = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE docno = '$docno'
UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE docno = '$docno'
UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE docno = '$docno'
UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billnumber = '$docno'
UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE docno = '$docno'
UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE docno = '$docno'
UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billnumber = '$docno'
UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE docno = '$docno'
UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billnumber = '$docno'
UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billnumber = '$docno' and wellnessitem <> '1'
UNION ALL SELECT SUM(-1*`transactionamount`) as income FROM `master_transactionadvancedeposit` WHERE visitcode = '$visitcode'
UNION ALL SELECT SUM(-1*`transactionamount`) as income FROM `master_transactionipdeposit` WHERE visitcode = '$visitcode'
UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode = '$visitcode'
UNION ALL SELECT SUM(-1*ABS(amountuhx)) as income FROM `billing_ipnhif` WHERE visitcode = '$visitcode'
UNION ALL SELECT SUM(amount) as income FROM `deposit_refund` WHERE visitcode = '$visitcode'";
$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resdr1 = mysqli_fetch_array($execdr1))
{
$i = $i+1;
$drresult[$i] = $resdr1['income'];
$tot[$i] = $tot[$i] + $resdr1['income'];
?>
<td align="right" valign="middle"><?= number_format($drresult[$i],2); ?></td>
<?php	
}
$total = array_sum($drresult);
$total = round($total);
$amount2 = $amount2 + $total;

$transactionamount = number_format($transactionamount,2,'.','');
$total = number_format($total,2,'.','');
$diff = $transactionamount - $total;

if($transactionamount == $total)
{
$color = '#009900';
$st = 'Match';
}
else
{
$color = '#FF0000';
$st = 'Mismatch';
}
?>
<td align="right" valign="middle"><?= number_format($total,2); ?></td>
<td align="right" valign="middle"><?= number_format($diff,2); ?></td>
<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><?= $st; ?></strong></td>
</tr>
<?php
}
?>
<tr>
<td colspan="3" align="right" valign="middle"><strong><?= 'TOTAL : '; ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount1,2); ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount2,2); ?></strong></td>
<td></td>
<?php
foreach ($tot as $tt)
{
?>
<td align="right" valign="middle"><strong><?= number_format($tt,2); ?></strong></td>
<?php	
}
?>
</tr>
<tr>
<td align="left"><strong>Date</strong></td>
<td align="left"><strong>Bill No</strong></td>
<td align="left"><strong>Visitcode</strong></td>
<td align="left"><strong>Billtype</strong></td>
<td align="left"><strong>Account</strong></td>
<td align="left"><strong>Account Code</strong></td>
<td align="right"><strong>Amount (Dr)</strong></td>
<td align="right"><strong>Admission (Cr)</strong></td>
<td align="right"><strong>Amb (Cr)</strong></td>
<td align="right"><strong>Bed Chrg (Cr)</strong></td>
<td align="right"><strong>Lab (Cr)</strong></td>
<td align="right"><strong>Misc (Cr)</strong></td>
<td align="right"><strong>Home (Cr)</strong></td>
<td align="right"><strong>Phar (Cr)</strong></td>
<td align="right"><strong>Dr (Cr)</strong></td>
<td align="right"><strong>Rad (Cr)</strong></td>
<td align="right"><strong>Ser (Cr)</strong></td>
<td align="right"><strong>Adv Deposit</strong></td>
<td align="right"><strong>Deposit</strong></td>
<td align="right"><strong>Discount</strong></td>
<td align="right"><strong>NHIF</strong></td>
<td align="right"><strong>Dep Refund</strong></td>
<td align="right"><strong>Total</strong></td>
<td align="right"><strong>Diff</strong></td>
<td align="center"><strong>Status</strong></td>
</tr>
</table>
<table>
 <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td valign="top"><table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
			function subgroup1($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = "0.00";
				$ledgeramountsum = "0.00";
				$ledgeramountsum1 = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview from master_accountssub where auto_number IN ('46','47','48','49') AND accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</strong></a>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong>
					<?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); $GLOBALS['$ledgeramountsumtotal'] = $ledgeramountsum; + $GLOBALS['$ledgeramountsumtotal'];?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				
				groupleft($ledgeramountsum);
			}
			function groupleft($a)
			{
			static $ledgeramountsumtotal1='0';
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $ledgeramountsumtotal1;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('A','E') order by section, accountsmain";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			//$orderid = $res1['orderid'];
			$type = substr($accountsmain,0,1);
	
			?>
			<tr bgcolor="#0033FF">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid.'10000';?>')" class="bodytext44" style="color:#FFFFFF"><!--<span id="arrmain<?php echo $parentid.'10000';?>">&#9658;</span>--></a>&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup1($parentid,$orderid,$parentid.'10000',$section); }
			//$ledgeramountsum = subgroup1();
			?>
			<!--<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ttlamt,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<?php
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseleft" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupleft12 = groupleft('0'); //echo number_format($groupleft12,2,'.',','); ?></strong>
			<input type="text" id="debit" value="<?php echo number_format($groupleft12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
</table>
</td>
 <td width="54%" valign="top"><table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
            <?php
			function subgroup12($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = '0.00';
				$ledgeramountsum = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview from master_accountssub where auto_number IN ('1','21','32','33','64') and accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong><?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
					
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				groupright($ledgeramountsum);
			}
			?>
			<?php
			function groupright($b)
			{
				static $ledgeramountsumtotal5 = '0';
				$ledgeramountsumtotal5 = $ledgeramountsumtotal5 + $b;
				return $ledgeramountsumtotal5;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('I','L') order by section, auto_number desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			$type = substr($accountsmain,'0','1');
			//$orderid = $res1['orderid'];
			?>
			<tr bgcolor="#009900">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup12($parentid,$orderid,$parentid.'10000',$section); }
			
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseright" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupright12 = groupright(0); //echo number_format($groupright12,2,'.',','); ?></strong>
			<input type="text" id="credit" value="<?php echo number_format($groupright12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			
			<script type="text/javascript">
			totalsum();
			</script>
			<?php
			}
			?>
</table>
</td>
</tr>
</table>
<?php } ?>
<?php
function ledgervalue($parentid,$ADate1,$ADate2,$tbinclude)
{
	$orderid1 = 0;
	$lid = 0;
	$sumbalance = 0;
	$allid = '';
	
	if($parentid != '')
	{
		if($parentid == '47' || $parentid == '48' || $parentid == '49')
		{
			$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
			$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res267 = mysqli_fetch_array($exec267))
			{  
				$accountsmain2 = $res267['accountname'];
				$parentid2 = $res267['auto_number'];
				$ledgeranum = $parentid2;
				$id = $res267['id'];
				$accountbank = 0;
					$i = 0;
				
				$drresult = array();
				$querydr1bnk = "SELECT SUM(a.`cashamount`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`cashcode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`mpesaamount`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`mpesacode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`chequeamount`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`bankcode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`cardamount`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`bankcode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`onlineamount`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`bankcode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`returnbalance`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`cashcode` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
								
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnkaa".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resdr1 = mysqli_fetch_array($execdr1))
				{
				$i = $i+1;
				$drresult[$i] = $resdr1['paylater'];
				}
				
				$accountbank = array_sum($drresult);
				
				$sumbalance = $sumbalance + $accountbank;
			}
			return $sumbalance;
		}
		else if($parentid == '46')
		{
			$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
			$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res267 = mysqli_fetch_array($exec267))
			{  
				$accountsmain2 = $res267['accountname'];
				$parentid2 = $res267['auto_number'];
				$ledgeranum = $parentid2;
				$id = $res267['id'];
				$accountbank = 0;
					$i = 0;
				
				$drresult = array();
				$querydr1bnk = "SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY LATER' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnkaa".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resdr1 = mysqli_fetch_array($execdr1))
				{
				$i = $i+1;
				$drresult[$i] = $resdr1['paylater'];
				}
				
				$accountbank = array_sum($drresult);
				
				$sumbalance = $sumbalance + $accountbank;
			}
			return $sumbalance;
		}
		else if($parentid == '1')
		{
			$i = 0;
			$crresult = array();
			$querycr1bnk = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billnumber LIKE '%IPF-%' AND billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billnumber LIKE '%IPF-%' AND billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE docno LIKE '%IPF-%' AND recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billnumber LIKE '%IPF-%' AND billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billnumber LIKE '%IPF-%' AND billdate BETWEEN '$ADate1' AND '$ADate2'";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult[$i] = $rescr1['income'];
			}
			
			$sumbalance = array_sum($crresult);
			return $sumbalance;
		}
		else if($parentid == '21')
		{
			$i = 0;
			$crresult = array();
			$querycr1bnk = "SELECT (-1*sum(`transactionamount`)) as income FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
							UNION ALL SELECT (-1*sum(`transactionamount`)) as income FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
							UNION ALL SELECT SUM(amount) as income FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2')";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult[$i] = $rescr1['income'];
			}
			
			$sumbalance = array_sum($crresult);
			return $sumbalance;
		}
		else if($parentid == '64')
		{
			$i = 0;
			$crresult = array();
			$querycr1bnk = "SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult[$i] = $rescr1['income'];
			}
			
			$sumbalance = array_sum($crresult);
			return $sumbalance;
		}
		else if($parentid == '330')
		{
			$i = 0;
			$crresult = array();
			$querycr1bnk = "SELECT SUM(-1*ABS(amountuhx)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult[$i] = $rescr1['income'];
			}
			
			$sumbalance = array_sum($crresult);
			return $sumbalance;
		}
		else
		{
			return $sumbalance;
		}	
	}
	else
	{
		return $sumbalance;
	}
}
?>