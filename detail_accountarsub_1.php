<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$ADate1 = date('Y-m-d', strtotime('01-01-2016'));
$ADate2 = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$type1 = '';
$acccoa = '';
$errmsg = "";
$banum = "1";
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
$grandtotal1 = "0.00";
$openingbalancecredit = "0.00";
$openingbalancedebit = "0.00";
$totalamount2 = '0.00';
$totalamount21 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_ledger.php");

if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = '2016-01-01'; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["ledger"])) { $ledger = $_REQUEST["ledger"]; } else { $ledger = ""; }
//echo $ledger = str_replace('&',' ',$ledger);
if (isset($_REQUEST["ledgeranum"])) { $ledgeranum = $_REQUEST["ledgeranum"]; } else { $ledgeranum = ""; }
//$ledger = trim($ledger);
if (isset($_REQUEST["ledgerid"])) { $ledgerid = $_REQUEST["ledgerid"]; } else { $ledgerid = ""; }
//$ledgerid = trim($ledgerid);
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }

?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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
<script type="text/javascript">
window.onload = function(){

}
</script>
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tbody>
				
       <tr>
        <td><table width="80%" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			 <tr>
				<td colspan="9" bgcolor="#CCC" class="bodytext3" align="left"><strong><?php echo 'Ledger Report'; ?></strong></td>
			</tr>
			<?php
			if(true)
			{
				$query= "select accountssub from master_accountssub where auto_number='$group'";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
				$res = mysqli_fetch_array($exec);
				$accountssub = $res['accountssub'];
			?>
            <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountssub.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
			</tr>
			<?php } 
				$ledgertotal = 0;
				
				if(true)
				{
				?>
				<tr bgcolor="#CCC">
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="98" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="288" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="92" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="106" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="78" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
				$totalamount=0;
				$openingbalance1=0;
				
				$sumbalance1 = '0.00';
				$colorloopcount = 0;
				
				$scount=0;
				$ledgertotal = 0;
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and subtype = '$subtype'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$accountname = addslashes ($res267['accountname']);
					$parentid2 = $res267['auto_number'];
					$sumbalance = '0.00';
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$opening = 0;
					$i=0;
					$result = array();
					$querydr1 = "SELECT (`fxamount`) as paylater, patientname as name, patientcode as code, billnumber as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'
								 UNION ALL SELECT (`transactionamount`) as paylater, patientname as name, patientcode as code, billnumber as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'AOP-%'
								 UNION ALL SELECT (`fxamount`) as paylater, patientname as name, patientcode as code, billnumber as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
					   			 UNION ALL SELECT (`totalamountuhx`) as paylater, patientname as name, patientcode as code, billnumber as billno, transactiondate as date FROM `master_transactionip` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`fxamount`) as paylater, patientname as name, patientcode as code, billno as billno, billdate as date FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`debitamount`) as paylater, ledgername as name, ledgerid as code, docno as billno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 
								 UNION ALL SELECT (-1 * b.transactionamount) as paylater, b.patientname as name, b.patientcode as code, b.docno as billno, b.transactiondate as date FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (-1 * fxamount) as paylater, patientname as name, patientcode as code, billnumber as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1 * fxamount) as paylater, patientname as name, patientcode as code, docno as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1 * transactionamount) as paylater, accountname as name, accountnameid as code, docno as billno, transactiondate as date FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT (-1 * creditamount) as paylater, ledgername as name, ledgerid as code, docno as billno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$numdr1 = mysqli_num_rows($execdr1);
					if($numdr1 > 0)
					{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountname; ?></strong></td>
				</tr>
				<?php	
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
						$paylater = $resdr1['paylater'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$billno = $resdr1['billno'];
						$date = $resdr1['date'];
						
						$sumbalance = $sumbalance + $paylater;
						$sumbalance1 = $sumbalance1 + $paylater;
						
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
						<tr <?php echo $colorcode; ?>>
						<td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
						<td align="left" class="bodytext3"><?php echo $date; ?></td>
						<td align="left" class="bodytext3"><?php echo $billno; ?></td>
						<td align="left" class="bodytext3"><?php echo $code; ?></td>
						<td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($paylater > 0) { ?>
						<td align="right" class="bodytext3"><?php echo number_format($paylater,2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="right" class="bodytext3">&nbsp;</td>
						<td width="17" align="right" class="bodytext3"><?php echo number_format(abs($paylater),2); ?></td>
						<?php } ?>
						<td width="17" align="right" class="bodytext3"><?php echo number_format($sumbalance1,2); ?></td>
						</tr>
						<?php
					}
					
					?>
				<tr bgcolor="#ecf0f5">
				<td colspan="8" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
				</tr>
				<?php
				}
				}
				
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td colspan="8" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance1,2); ?></strong></td>
				</tr>
                </table>
                </td>
                </tr>
                </tbody>
                
                
          
         
</table>

</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
