<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2016-01-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2016-02-28"; }
if (isset($_REQUEST["frmflag"])) { $frmflag = $_REQUEST["frmflag"]; } else { $frmflag = ""; }
?>
<table border="1" width="100%" style="border-collapse:collapse;">
<tr>
<td colspan="12" align="center" valign="middle"><strong>NAKASERO HOSPITAL</strong></td>
</tr>
<tr>
<td colspan="12" align="center" valign="middle"><strong>IP Credit Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="12" align="center" valign="middle"><strong>From &nbsp; <input type="date" name="ADate1" value="<?= $ADate1; ?>" />&nbsp; To &nbsp; <input type="date" name="ADate2" value="<?= $ADate2; ?>" />&nbsp;</strong>
<input type="hidden" name="frmflag" value="frmflag" />
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php if($frmflag == 'frmflag') { ?>
<tr>
<td align="left"><strong>Date</strong></td>
<td align="left"><strong>Bill No</strong></td>
<td align="left"><strong>Account</strong></td>
<td align="right"><strong>Amount (Cr)</strong></td>
<td align="right"><strong>Bed (Dr)</strong></td>
<td align="right"><strong>Nursing (Dr)</strong></td>
<td align="right"><strong>RMO (Dr)</strong></td>
<td align="right"><strong>Lab (Dr)</strong></td>
<td align="right"><strong>Radiology (Dr)</strong></td>
<td align="right"><strong>Service (Dr)</strong></td>
<td align="right"><strong>Others (Dr)</strong></td>
<td align="right"><strong>Account (Dr)</strong></td>
<td align="right"><strong>Total</strong></td>
<td align="right"><strong>Diff</strong></td>
<td align="center"><strong>Status</strong></td>
</tr>
<?php 
$query8 = "SELECT visitcode,billnumber as docno,fxamount,transactiondate,accountname,transactionamount FROM `master_transactionpaylater` WHERE `billnumber` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit' order by auto_number";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res8 = mysqli_fetch_array($exec8))
{
$docno = $res8['docno'];
$visitcode = $res8['visitcode'];
$transactionamount = $res8['fxamount'];
$transactiondate = $res8['transactiondate'];
$accountname = $res8['accountname'];
?>
<tr>
<td align="left" valign="middle"><?= date('d-m-Y',strtotime($transactiondate)); ?></td>
<td align="left" valign="middle"><?= $docno; ?></td>
<td align="left" valign="middle"><?= $accountname; ?></td>
<td align="right" valign="middle"><?= number_format($transactionamount,2); ?></td>
<?php	
$i = 0;
$drresult = array();
$querydr1bnk = "SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Bed Charges'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Nursing Charges'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'RMO Charges'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Lab'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Radiology'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Service'
UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_creditnotebrief` WHERE docno = '$docno' and `description` = 'Others'
UNION ALL SELECT SUM(`fxamount`) as income FROM master_transactionpaylater WHERE `billnumber` = '$docno' and billnumber = patientcode";
$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resdr1 = mysqli_fetch_array($execdr1))
{
$i = $i+1;
$drresult[$i] = $resdr1['income'];
?>
<td align="right" valign="middle"><?= number_format($drresult[$i],2); ?></td>
<?php	
}
$total = array_sum($drresult);
$transactionamount = round($transactionamount);
$total = round($total);

$amount1 = $amount1 + $transactionamount;
$amount2 = $amount2 + $total;

$transactionamount = number_format($transactionamount,2,'.','');
$total = number_format($total,2,'.','');
$diff = $transactionamount - $total;
$diff = round($diff);
?>
<td align="right" valign="middle"><?= number_format($total,2); ?></td>
<td align="right" valign="middle"><?= number_format($diff,2); ?></td>
<?php
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
<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><?= $st; ?></strong></td>
</tr>
<?php   
}
?>
<tr>
<td colspan="3" align="right" valign="middle"><strong><?= 'TOTAL : '; ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount1,2); ?></strong></td>
<td align="right" valign="middle"><strong><?= number_format($amount2,2); ?></strong></td>
<td colspan="7" align="left">&nbsp;</td>
</tr>
<?php
}
?>
</table>