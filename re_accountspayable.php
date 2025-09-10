<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2016-01-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2016-02-28"; }
if (isset($_REQUEST["frmflag"])) { $frmflag = $_REQUEST["frmflag"]; } else { $frmflag = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
?>
<script type="text/javascript">
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
	//var diff = diff.substr(diff.length - 6);
	document.getElementById("suspenseleft").value = diff;
	document.getElementById("suspenseright").value = "0.00";
	}
	else
	{
	diff = Math.abs(diff);
	credit = parseFloat(credit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	//var diff = diff.substr(diff.length - 6);
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
<td colspan="15" align="center" valign="middle"><strong>NAKASERO HOSPITAL</strong></td>
</tr>
<tr>
<td colspan="15" align="center" valign="middle"><strong>Accounts Payable Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="15" align="center" valign="middle"><strong>From &nbsp; <input type="date" name="ADate1" value="<?= $ADate1; ?>" />&nbsp; To &nbsp; <input type="date" name="ADate2" value="<?= $ADate2; ?>" />&nbsp;</strong>
<input type="hidden" name="frmflag" value="frmflag" />
<input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php
if($frmflag == 'frmflag'){?>
<tr>
<td colspan="15" align="center" valign="middle"><strong>Account Purchases</strong></td>
</tr>
<tr>
<td align="left"><strong>Date</strong></td>
<td align="left"><strong>Bill No</strong></td>
<td align="left"><strong>Acc Sub</strong></td>
<td align="left"><strong>Code</strong></td>
<td align="left"><strong>Ledger</strong></td>
<td align="right"><strong>Amount (Cr)</strong></td>
<td align="right"><strong>Purchases (Dr)</strong></td>
<td align="right"><strong>Assets (Dr)</strong></td>
<td align="center"><strong>Status</strong></td>
</tr>
<?php 
$a=array();
$bill = array();
$query8 = "SELECT a.billnumber as billnumber,a.transactionamount as transactionamount,a.totalfxamount as purchaseamount,a.suppliername as suppliername,a.suppliercode as suppliercode,a.transactiondate as transactiondate,b.accountssub as accountssub FROM `master_transactionpharmacy` AS a JOIN `master_accountname` AS b ON (a.suppliercode = b.id) WHERE a.`billnumber` NOT LIKE 'SUPO%' AND a.`billnumber` NOT LIKE 'SOP%' AND billnumber <> '' AND a.`transactiontype` = 'PURCHASE' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2' order by a.auto_number";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res8 = mysqli_fetch_array($exec8))
{
	$billnumber = $res8['billnumber'];
	$purchaseamount = $res8['transactionamount'];
	$suppliername = $res8['suppliername'];
	$suppliercode = $res8['suppliercode'];
	$transactiondate = $res8['transactiondate'];
	$accountssub = $res8['accountssub'];
	$amount1 = $amount1 + $purchaseamount;
	$stock = 0;
	$asset = 0;
	$st = '';
	$sno = 0;
?>
<tr>
<td align="left" valign="middle"><?= date('d-m-Y',strtotime($transactiondate)); ?></td>
<td align="left" valign="middle"><?= $billnumber; ?></td>
<td align="left" valign="middle"><?= $accountssub; ?></td>
<td align="left" valign="middle"><?= $suppliercode; ?></td>
<td align="left" valign="middle"><?= $suppliername ?></td>
<td align="right" valign="middle"><?= number_format($purchaseamount,2); ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
	$query1 = "SELECT a.`totalfxamount` as totalamount,a.itemname as itemname,a.ledgercode as ledgercode,a.ledgername as ledgername,a.entrydate as entrydate,c.accountssub as accsub FROM `purchase_details` AS a JOIN `master_medicine` AS b JOIN `master_accountname` AS c ON (a.itemcode = b.itemcode AND b.inventoryledgercode = c.id) WHERE a.`billnumber` = '$billnumber' and b.type <> 'assets'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$stock = $stock + $res1['totalamount'];
	$sno = $sno + 1;
	
	//array_push($a,$res1['accsub']);

	if (in_array($res1['accsub'], $a))
	{
	//echo "Match found";
	}
	else
	{
	array_push($a,$res1['accsub']);
	}
	//print_r($a);
?>
<tr>
<td align="left" valign="middle"><?= $sno.'. '.date('d-m-Y',strtotime($res1['entrydate'])); ?></td>
<td align="left" valign="middle"><?= $billnumber; ?></td>
<td align="left" valign="middle"><?= 'Acc->'.$res1['accsub']; ?></td>
<td align="left" valign="middle"><?= $res1['ledgercode']; ?></td>
<td align="left" valign="middle"><?= $res1['ledgername']; ?></td>
<td>&nbsp;</td>
<td align="right" valign="middle"><?= number_format($res1['totalamount'],2); ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}
?>
<?php
	$query11 = "SELECT a.`totalamount` as totalamount,a.itemname as itemname,a.expensecode as expensecode,a.expense as expense,a.entrydate as entrydate,b.accountssub as accsub FROM `purchase_details` AS a JOIN `master_accountname` AS b ON (a.expensecode = b.id) WHERE a.`billnumber` = '$billnumber' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res11 = mysqli_fetch_array($exec11))
	{
	$stock = $stock + $res11['totalamount'];
	if (in_array($res11['accsub'], $a))
	{
	//echo "Match found";
	}
	else
	{
	array_push($a,$res11['accsub']);
	}
?>
<tr>
<td align="left" valign="middle"><?= 'exp->'.date('d-m-Y',strtotime($res11['entrydate'])); ?></td>
<td align="left" valign="middle"><?= $billnumber; ?></td>
<td align="left" valign="middle"><?= 'Acc->'.$res11['accsub']; ?></td>
<td align="left" valign="middle"><?= $res11['expensecode']; ?></td>
<td align="left" valign="middle"><?= $res11['expense']; ?></td>
<td>&nbsp;</td>
<td align="right" valign="middle"><?= number_format($res11['totalamount'],2); ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}
?>
<?php
	$total = $stock;
	$amount2 = $amount2 + $total;
	$purchaseamount = number_format($purchaseamount,2,'.','');
	$total = number_format($total,2,'.','');
	if($purchaseamount == $total)
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
<tr>
<td colspan="4" align="right" valign="middle"><strong>&nbsp;</strong></td>
<td align="right"><strong><?= 'TOTAL : '; ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($purchaseamount,2); ?></strong></td>
<td align="left">&nbsp;</td>
<td align="right" valign="middle"><strong><?= number_format($total,2); ?></strong></td>
<td align="left" style="color:<?= $color; ?>"><strong><?= $st; ?></strong></td>
</tr>
<?php
}
foreach($a as $b){
//echo '<br>'.$b;
}
?>
<tr>
<td colspan="4" align="right" valign="middle">&nbsp;</td>
<td align="right"><strong><?= 'TOTAL : '; ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount1,2); ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount2,2); ?></strong></td>
<td align="left">&nbsp;</td>
<td align="left">&nbsp;</td>
</tr>
<tr>
<td colspan="15" align="center" valign="middle"><strong>&nbsp;</strong></td>
</tr>
<?php
}
?>
</table>
<table width="100%" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<tr>
			<td>
<table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
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
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong>
					<?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
				}
				if($parentid == '6')
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
					$unrealized =0;
					//include 'tb_unrealized.php';
					$ledgeramountsum = $ledgeramountsum + $unrealized;
				?>
				
				<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
				<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;99';?><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong><strong style="color:#0000CC; font-size:11px">UNREALIZED REVENUE</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($unrealized,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
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
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('A','E') order by section, auto_number, accountsmain";
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
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
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
<?php
function ledgervalue($parentid,$ADate1,$ADate2,$tbinclude,$tbclosing)
{
	$orderid1 = 0;
	$lid = 0;
	$sumbalance = 0;
	$allid = '';
	
	if($parentid != '' && $tbinclude != '')
	{
		if($parentid == '53' || $parentid == '54' || $parentid == '55' || $parentid == '57' || $parentid == '58')
		{
			$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
			$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res267 = mysqli_fetch_array($exec267))
			{  
				$accountsmain2 = $res267['accountname'];
				$parentid2 = $res267['auto_number'];
				$ledgeranum = $parentid2;
				$id = $res267['id'];
				
				$j = 0;
				$crresult = array();
				$querycr1 = "SELECT SUM(`transactionamount`) as payables FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `billnumber` NOT LIKE 'SOP%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescr1 = mysqli_fetch_array($execcr1))
				{
				$j = $j+1;
				$crresult[$j] = $rescr1['payables'];
				}
				
				$accountbank = array_sum($crresult);
				$sumbalance = $sumbalance + $accountbank;
			}
			
			return $sumbalance;
		}
		else
		{
			$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
			$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res267 = mysqli_fetch_array($exec267))
			{  
				$accountsmain2 = $res267['accountname'];
				$parentid2 = $res267['auto_number'];
				$ledgeranum = $parentid2;
				$id = $res267['id'];
				
				$i = 0;
				$result = array();

		$querydr1 = "SELECT SUM(`totalamount`) as expenses FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
						UNION ALL SELECT SUM(`totalamount`) as expenses FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
						UNION ALL SELECT SUM(`totalamount`) as expenses FROM `otherpurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
						UNION ALL SELECT SUM(`totalamount`) as expenses FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
						UNION ALL SELECT SUM(a.`totalamount`) as expenses FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SUPO%' AND a.`billnumber` NOT LIKE 'SOP%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted' and b.type <> 'assets' ";
				$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resdr1 = mysqli_fetch_array($execdr1))
				{
				$i = $i+1;
					$result[$i] = $resdr1['expenses'];
				}
				$purchase = array_sum($result);
				$sumbalance = $sumbalance + $purchase;
			}	
			
			return $sumbalance;
		}	
	}
	else
	{
		return $sumbalance;
	}
}
?>