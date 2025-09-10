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
$balance =0 ;
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
$creditdisplay= '0.00';
$debitdisplay= '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_ledger.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = '2016-01-01'; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

if (isset($_REQUEST["module"])) { $module = $_REQUEST["module"]; } else { $module = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
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
<script type="text/javascript" src="js/autocomplete_ledger.js"></script>
<script type="text/javascript" src="js/autosuggestledger.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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

var oTextbox = new AutoSuggestControlledger(document.getElementById("ledger"), new StateSuggestions()); 
	//alert(oTextbox1); 
}

function modulecheck()
{
	if(document.getElementById("group").value == '')
	{
		alert("Please select Group");
		document.getElementById("group").focus();
		return false;
	}
	if(document.getElementById("ledgerid").value == '')
	{
		alert("Please select ledger");
		document.getElementById("ledger").focus();
		return false;
	}
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
			?>
            <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
			</tr>
            <?php //if($group != '15' && $group != '19') {?>
            <!--<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="90" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="90" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="90" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>-->
			<?php }//} ?>	
                <?php
				
				$query= "select  tbinclude from master_accountssub where auto_number='$group'";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
				$res = mysqli_fetch_array($exec);
				$tbledgerview = $res['tbinclude'];
				
				$ledgertotal = 0;
				if($group == '14' || $group == '32' || $group == '48' || $group == '49' || $group == '50' || $group == '51' || $group == '52' || $group == '53' || $group == '54' || $group == '44' || $group == '42' || $group == '18' || $group == '43' || $group == '60' || $group == '4' || $group == '47' || $group == '20' || $group == '24')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					$query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
					$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res267 = mysqli_fetch_array($exec267))
					{  
						$id = $res267['id'];
						$i = 0;
						$result = array();
						$ledgertotal12=0;
						 $querydr1 = "SELECT sum(assetvalue) as assetvalue FROM `master_fixedassets` where `fixedassetcode` = '$id'
									 UNION ALL SELECT sum(openbalanceamount) as assetvalue FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT sum(subtotal) as assetvalue FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` < '$ADate2'
									 UNION ALL SELECT sum(debitamount) as assetvalue FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'";
						 
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr12".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
							
						$ledgertotal12 += $resdr1['assetvalue'];
						}
						$totalamount +=$ledgertotal12;
					}
					
					$expensescr=0;
					$i = 0;
					$querycr1 = "SELECT sum(creditamount) as expensescr FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'
								 UNION ALL SELECT SUM(`openbalanceamount`) as expensescr FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus ='1'
								 UNION ALL SELECT SUM(`openbalanceamount`) as expensescr FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus ='0'";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rescr1 = mysqli_fetch_array($execcr1))
					{
					$expensescr += $rescr1['expensescr'];	
					
					$openingbalance1=$totalamount - $expensescr;
					if($openingbalance1>0)
					{
					$debitdisplay=$openingbalance1;
					}
					else
					{
					$creditdisplay=$openingbalance1;
					}
					}
					//$openingbalance1=0;

					?>
                    <tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance as at 1st May 2017</td>
                    <td  colspan="3" align="right" class="bodytext3"><?php echo number_format($debitdisplay,2);?></td>
                    <td  align="right" class="bodytext3"><?php echo number_format($creditdisplay,2);?></td>
                    <td  colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>
                    <?php
					
					$scount=0;
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
					$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res267 = mysqli_fetch_array($exec267))
					{ 
 
						$accountsmain2 = $res267['accountname'];
						$parentid2 = $res267['auto_number'];
						$ledgeranum = $parentid2;
						//$id2 = $res2['id'];
						$id = $res267['id'];
						//$id2 = trim($id2);
						
						$i = 0;
						$querydr1 = "SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `otherpurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,itemcode as code, itemname as name, billnumber as docno, entrydate as date FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								     UNION ALL SELECT a.`totalamount` as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SUPO%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
								     UNION ALL SELECT `transactionamount` as expenses,expensecoa as code, expenseaccount as name, docnumber as docno, transactiondate as date FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT a.`amount` as expenses,a.itemcode as code, a.itemname as name, a.docno as docno, a.entrydate as date FROM `master_stock_transfer` AS a WHERE a.tostore = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
									 
									 UNION ALL SELECT (-1*a.`totalcp`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT (-1*a.`totalamount`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `purchasereturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
									 UNION ALL SELECT (-1*a.`amount`) as expenses,a.itemcode as code, a.itemname as name, a.docno as docno, a.entrydate as date FROM `master_stock_transfer` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.tostore not like 'STO%'
									 UNION ALL SELECT (-1*`totalamount`) as expenses,itemcode as code, itemname as name, billnumber as docno, entrydate as date FROM `purchasereturn_details` WHERE expensecode = '$id' AND entrydate BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT (-1*`creditamount`) as expenses,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr13".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{

						$i = $i+1;
						$expenses = $resdr1['expenses'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						$scount =$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $expenses +$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $expenses;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($expenses >= 0) { ?>
						<td align="right" class="bodytext3"><?php echo number_format($expenses,2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format(abs($expenses),2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}		

					}
					?>
					<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
					</tr>
					<?php
				}
				
				else if($group == '1')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$scount=0;
					 $totalamount=0;
					$openingbalance1=0;
					$query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$id = $res267['id'];
					$ledgertotal = 0;
					if($id != '')
					{
						$income = 0;
						
						$querycr1in = "SELECT  sum(fxamount) as income FROM `billing_paylaterpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'CB%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT  sum(fxamount) as income FROM `billing_paynowpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'OPC%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT  sum(amount) as income FROM `billing_externalpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'EB%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT  sum(amountuhx) as income FROM `billing_ippharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'IPF-%' AND `billdate` < '$ADate2' 
									   UNION ALL SELECT  sum(amountuhx) as income FROM `billing_ippharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'IPFCA%' AND `billdate` < '$ADate2' 
									   UNION ALL SELECT  sum(creditamount) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						 $income += $rescr1['income'];
						
						}
						$incomedebit = 0;
						
					 	$querydr1in = "SELECT sum(amount) as incomedebit FROM `refund_paynowpharmacy` WHERE ledgercode = '$id' AND `billdate` < '$ADate1'
									   UNION ALL SELECT sum(amount) as incomedebit FROM `paylaterpharmareturns` WHERE ledgercode = '$id' AND `billdate` < '$ADate1' AND `patientvisitcode` NOT IN (SELECT `patientvisitcode` FROM refund_paynowpharmacy) 
									   UNION ALL SELECT  sum(debitamount) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$incomedebit += $resdr1['incomedebit'];
						}
						
						$totalamount +=$income-$incomedebit;		
				}
				}
					
					$openingbalance1=$totalamount;
					$income=0;
					$incomedebit=0;
					$openingbalance1=0;
					?>
					<!--  <tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2,'.',',');?></td>
                    </tr>-->
					<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					
					/*UNION ALL SELECT `amount` as incomedebit, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `refund_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
					  UNION ALL select transactionamount as incomedebit, patientcode as code, patientname as name, docno as docno, transactiondate as date from master_transactionpaylater where `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit' AND `accountname` <> '' AND `accountname` <> 'CASH COLLECTIONS'*/	
					
					$ledgertotal = 0;
					if($id != '')
					{
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,code,name,docno,date FROM (SELECT  fxamount as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `billing_paylaterpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT  fxamount as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `billing_paynowpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'OPC%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' 
									   UNION ALL SELECT  amount as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `billing_externalpharmacy` WHERE ledgercode = '$id' AND `billnumber` LIKE 'EB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT  amountuhx as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `billing_ippharmacy` WHERE ledgercode = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `creditamount` as income, ledgerid as code, ledgername as name,docno as docno,entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`amount`) as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `refund_paynowpharmacy` WHERE ledgercode = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`amount`) as income, medicinecode as code, medicinename as name, billnumber as docno, billdate as date FROM `paylaterpharmareturns` WHERE ledgercode = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' AND `patientvisitcode` NOT IN (SELECT `patientvisitcode` FROM refund_paynowpharmacy)
									   UNION ALL SELECT (-1*`debitamount`) as income, ledgerid as code, ledgername as name,docno as docno,entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as i ORDER BY i.date";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
							$scount =$scount+1;
						 $income = $rescr1['income'];
						 $code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						if($scount ==1)
						{
						$ledgertotal = $ledgertotal + $income + $openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
                        <?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>

                        </tr>
                        <?php
						}					
				}
						if($id == '04-6010-PI')
						{
						$querycr1in = "SELECT (-1*`pharmacyfxamount`) as income, patientcode as code, patientname as name, billno as docno, entrydate as date FROM `billing_patientweivers` WHERE pharmacyfxamount > '0' and `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
							$scount =$scount+1;
						 $income = $rescr1['income'];
						 $code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						if($scount ==1)
						{
						$ledgertotal = $ledgertotal + $income + $openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
                        <?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>

                        </tr>
                        <?php
						}	
				}
				
				if($id == '04-6009-PI')    {
				//unfinal
							$phatotal=0;
			$netamount='';
			$sno=0;
			$totalradiologyitemrate =0;
			$totalpharmacysaleamount=0;
			$totalquantity = 0;
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
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
			$fxrate = $execsubtype['fxrate'];
		
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			 $phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$quantity=$res23['quantity'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$amount=$pharate*$quantity;
			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			
			$resquantity = $quantity;
			$resamount = $amount;
						
			$resamount=number_format($resamount,2,'.','');
			//if($resquantity != 0)
			
			if($pharmfree =='No')
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
			
			$resamount=$resquantity*($pharate/$fxrate);
			$totalpharm=$totalpharm+$resamount;
			
			 $resamountuhx = $pharate*$resquantity;
			 $resamountreturnuhx = $pharate*$quantity1;
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			$totalpharmacysaleamount = $totalpharmacysaleamount + $resamountuhx;
		   $phatotal = $phatotal + $resamountuhx;
			$balance=$phatotal;
		$ledgertotal=$ledgertotal+$resamountuhx;
	
			//$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			 ?>
			 	<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phadate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $refno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phaitemcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phaname; ?></td>
						<?php if($resamountuhx>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($resamountuhx,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($resamountuhx,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
			 
         
	<?php
		
		
		}
		}
		}
		          //ip income lab end
			  
			  
			  //op income lab
			  $totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
			 $query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'  group by accountfullname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountnameano = $res21['accountname'];
			$phdocnum='nan';
			$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res21accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			
			
		
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
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
		  $query4 = "select servicesitemcode,serviceqty,refundquantity,servicesitemname,docnumber from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
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
		  
		  $query91 = "select sum(totalamount) as totalamount1,itemcode,itemname,docnumber from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
		  $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res91 = mysqli_fetch_array($exec91))
		  {
		  
		  $res9pharmacyrate = $res91['totalamount1'];
		  	 $phcode=$res91['itemcode'];
			 $phname= $res91['itemname'];
$phdocnum= $res91['docnumber'];
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res91['totalamount1'];
		  }
		  
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
		  }
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
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
		
			$ledgertotal=$ledgertotal+$res9pharmacyrate;
			//echo "hi".$totalamount4;
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
	}
			if($res9pharmacyrate!=0){
			?><tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $res2registrationdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phdocnum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $phname; ?></td>
						<?php if($res9pharmacyrate>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($res9pharmacyrate,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($res9pharmacyrate,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
          
			<?php
			}//nan
			}
			}
			
			}    //op income lab end
				
				//echo $totalamount5;
				//echo "   hi".$totalamount3 ."bal".$balance;
			//	$balance=$balance+$totalamount3;
				}
				
				
				
				//unfinal
				?>
					<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
					</tr>
				<?php
				
				}
				
				else if($group == '46')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$scount=0;
					$totalamount=0;
					$openingbalance1=0;
				$query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
				
					$id = $res267['id'];
				
					
					if($id == '01-10041-NHL')
					{
						$incomedebit=0;
						$querycr1in = "SELECT sum(radiologyitemrate) as incomedebit FROM `refund_paynowradiology` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(radiologyitemrate) as incomedebit FROM `refund_paylaterradiology` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(rate) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Radiology' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`debitamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						 $incomedebit += $rescr1['incomedebit'];
						}
					
						$income=0;
						$querydr1in = "SELECT sum(fxamount) as income FROM `billing_paylaterradiology` WHERE `billnumber` LIKE 'CB%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT sum(fxamount) as income FROM `billing_paynowradiology` WHERE `billnumber` LIKE 'OPC%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(radiologyitemrate) as income FROM `billing_externalradiology` WHERE `billnumber` LIKE 'EB%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(radiologyitemrateuhx) as income FROM `billing_ipradiology` WHERE `billnumber` LIKE 'IPF-%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT sum(radiologyitemrateuhx) as income FROM `billing_ipradiology` WHERE `billnumber` LIKE 'IPFCA%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT sum(rate) as income FROM `ip_debitnotebrief` WHERE `description` = 'Radiology' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$income += $resdr1['income'];
						}
						
						$totalamount +=$income-$incomedebit;
		
				}
				}
				$openingbalance1 =$totalamount;
				$income=0;
				$incomedebit=0;
				$openingbalance1=0;
				?>
					 <!-- <tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
				
					
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					
					$ledgertotal = 0;
					if($id == '01-10041-NHL')
					{	
						$i = 0;
						$drresult = array();
						$querydr1in = "SELECT `fxamount` as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_paylaterradiology` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_paynowradiology` WHERE `billnumber` LIKE 'OPC%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' 
									   UNION ALL SELECT `radiologyitemrate` as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_externalradiology` WHERE `billnumber` LIKE 'EB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `radiologyitemrateuhx` as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_ipradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, consultationdate as date, docno as docno FROM `ip_debitnotebrief` WHERE `description` = 'Radiology' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `creditamount` as income, ledgerid as code, ledgername as name, entrydate as date, docno as docno FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`radiologyfxamount`) as income, patientcode as code, patientname as name, entrydate as date, billno as docno FROM `billing_patientweivers` WHERE radiologyfxamount > '0' and entrydate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`radiologyitemrate`) as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `refund_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`fxamount`) as income, radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `refund_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, consultationdate as date, docno as docno FROM `ip_creditnotebrief` WHERE `description` = 'Radiology' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`debitamount`) as income, ledgerid as code, ledgername as name, entrydate as date, docno as docno FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$income = $resdr1['income'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						
						$ledgertotal = $ledgertotal + $income;
						
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
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}		
				    }
					
					
					//unfinal
								if($id == '01-10042-RAD')                 //rad unfinal
					{     //ip income rad
					$colorloopcount = $colorloopcount + 1;
					$radtotal=0;
					$totalradiologyitemrate=0;
		$sno=0;
	$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
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
			$fxrate = $execsubtype['fxrate'];
			
			$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtt32 = mysqli_num_rows($exectt32);
			$exectt=mysqli_fetch_array($exectt32);		
			$radtable=$exectt['templatename'];
			if($radtable=='')
			{
				$radtable='master_radiology';
			}
			
	
				$totalrad=0;
				$totalraduhx=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			$radiologyitemcode = $res20['radiologyitemcode'];
			if($radiologyfree == 'No')
			{
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resr51 = mysqli_fetch_array($execr51);
			$radrate = $resr51['rateperunit'];
			
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
			$totalrad=$totalrad+$radrate;
			
			 $radrateuhx = $radrate*$fxrate;
		   $totalraduhx = $totalraduhx + $radrateuhx;
		   $totalradiologyitemrate = $totalradiologyitemrate + $radrateuhx;
		   $radtotal = $radtotal + $radrateuhx;
		   $ledgertotal=$ledgertotal+$radrateuhx;
			$balance=$radtotal;
		//	echo $balance;
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
                        <td align="left" class="bodytext3"><?php echo $raddate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $radref; ?></td>
                        <td align="left" class="bodytext3"><?php echo $radcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $radname; ?></td>
						<?php if($radrateuhx>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($radrateuhx,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($radrateuhx,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
						<?php
						$colorloopcount = $colorloopcount + 1;
		}
		}
		}            //ip income lab end
			  
			  
			  //op income lab
			  $totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
			 $query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'  group by accountfullname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountnameano = $res21['accountname'];
			$raddocnum='nan';
			$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res21accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			
			
	
			$res3labitemrate = "0.00";
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
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
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
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
		  $query5 = "select radiologyitemcode,radiologyitemname,docnumber from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		  	$radcode=$res5['radiologyitemcode'];
			 
				$radname= $res5['radiologyitemname'];
				$raddocnum= $res5['docnumber'];
			
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
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
		$ledgertotal=$ledgertotal+$res5radiologyitemrate;
			
			
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
	
		if($raddocnum!='nan'){
			?><tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $res2registrationdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $raddocnum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $radcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $radname; ?></td>
						<?php if($res5radiologyitemrate>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($res5radiologyitemrate,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($res5radiologyitemrate,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
          
			<?php
			}
			
			
			}
			}
			
			}    //op income lab end
				
				//echo $totalamount5;
				//echo "   hi".$totalamount5 ."bal".$balance;
				$balance=$balance+$totalamount5;
					} 
					
					//end unfinal
				}
				?>
					<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
					</tr>
				<?php
				
				}
				
				else if($group == '2' || $group == '55' || $group == '56' || $group == '59' || $group == '60')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					 $query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{
					 $id = $res267['id'];
					
					if($id != '')
					{
						$incomedebit=0;
						$querydr1in = "SELECT sum(totalamount) as stock FROM `purchase_details` WHERE `entrydate` < '$ADate1'  AND (`ledgercode` = '$id' or `expensecode` = '$id')  AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `recordstatus` <> 'deleted'
										UNION ALL SELECT sum(transactionamount) as stock FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` < '$ADate1'
										UNION ALL SELECT sum(debitamount) as stock FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in3".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$incomedebit += $resdr1['stock'];
						
						//$ledgertotal = $ledgertotal + $incomedebit;
						
						}
						
						$income=0;
						$querycr1in = "SELECT sum(totalamount) as stockcredit FROM `purchasereturn_details` WHERE `entrydate` < '$ADate1' 
										UNION ALL SELECT sum(creditamount) as stockcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$income += $rescr1['stockcredit'];
						
						//$ledgertotal = $ledgertotal - $income;
						}	
						$totalamount +=$incomedebit-$income;		
				}
				}
				$openingbalance1 =$totalamount;
				$income=0;
				$incomedebit=0;
				?>
					  
					<?php
					
				 $query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
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
						$i = 0;
						$scount=0;
						$drresult = array();
						
						$querydr1in = "SELECT a.`totalcp` as stock, a.itemcode as code, a.itemname as name,a.visitcode as docno,a.entrydate as date FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
										 UNION ALL SELECT a.`amount` as stock,a.itemcode as code, a.itemname as name, a.docno as docno, a.entrydate as date FROM `master_stock_transfer` AS a WHERE a.tostore = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
									   UNION ALL SELECT a.`totalcp` as stock, a.itemcode as code, a.itemname as name,a.visitcode as docno,a.entrydate as date FROM `pharmacysalesreturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in3".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$incomedebit = $resdr1['stock'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						$scount =$scount+1;
						if($scount ==1)
						{
						$ledgertotal = $ledgertotal + $incomedebit +$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $incomedebit;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($incomedebit >= 0) { ?>
                        <td align="right" class="bodytext3"><?php echo number_format($incomedebit,2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format(abs($incomedebit),2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						
						}	
				}
				}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php
				}
				
				else if($group == '3')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
						$totalamount=0;
					$openingbalance1=0;
					
					 $query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					 $id = $res267['id'];
					//$id2 = trim($id2);
					
					$querydr1op = "SELECT SUM(`debitamount`) as incomedebit FROM `master_journalentries`  WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'";
					$execdrop = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1op) or die ("Error in querydr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resdrop = mysqli_fetch_array($execdrop);
					$debitop = $resdrop['incomedebit'];
					
					$querycr1op = "SELECT SUM(`creditamount`) as income FROM `master_journalentries`  WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'";
					$execcrop = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rescrop = mysqli_fetch_array($execcrop);
					$creditop = $rescrop['income'];
					
					$open1 = $creditop - $debitop;
						
						
					if($id == '03-3002-NHL')
					{
						/*UNION ALL SELECT SUM(`totalamount`) as incomedebit FROM `ip_creditnote` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'*/
						$incomedebit=0;
						$querydr1in = "SELECT SUM(`consultation`) as incomedebit FROM `refund_consultation` WHERE `billdate` < '$ADate1'  and billnumber NOT LIKE 'Cr.N%'
									   UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`referalrate`) as incomedebit from refund_paylaterreferal WHERE `billdate` < '$ADate1'
									  
									   UNION ALL SELECT SUM(`rate`) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Bed Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Nursing Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'RMO Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Others' AND `consultationdate` < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						
						$incomedebit += $resdr1['incomedebit'];
						
						//$ledgertotal = $ledgertotal - $incomedebit;
					
						}
						
						
						$income=0;
						$querycr1in = "SELECT SUM(`subtotal`) as income FROM `billing_referal` WHERE `billdate` < '$ADate1' AND `billnumber` LIKE 'CB%'
									   UNION ALL SELECT SUM(`referalrate`) as income FROM `billing_paylaterreferal` WHERE `referalcode` LIKE '08-%' AND `billnumber` LIKE 'CB%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`totalamount`) as income FROM `billing_paylaterconsultation` WHERE `billno` LIKE 'CB%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`subtotal`) as income FROM `billing_referal` WHERE `billdate` < '$ADate1' AND `billnumber` LIKE 'OPC%' AND `billnumber` 
									   UNION ALL SELECT SUM(`referalrate`) as income FROM `billing_paynowreferal` WHERE `referalcode` LIKE '08-%' AND `billnumber` LIKE 'OPC%'   AND `billdate` < '$ADate1' 
									   UNION ALL SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipadmissioncharge` WHERE `docno` LIKE 'IPF-%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipambulance` WHERE `docno` LIKE 'IPF-%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipbedcharges` WHERE `docno` LIKE 'IPF-%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE `docno` LIKE 'IPF-%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipmiscbilling` WHERE `docno` LIKE 'IPF-%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipadmissioncharge` WHERE `docno` LIKE 'IPFCA%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipambulance` WHERE `docno` LIKE 'IPFCA%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipbedcharges` WHERE `docno` LIKE 'IPFCA%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE `docno` LIKE 'IPFCA%' AND `recorddate` < '$ADate1' 
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipmiscbilling` WHERE `docno` LIKE 'IPFCA%' AND `recorddate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as income FROM `ip_debitnotebrief` WHERE `description` = 'Bed Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as income FROM `ip_debitnotebrief` WHERE `description` = 'Nursing Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as income FROM `ip_debitnotebrief` WHERE `description` = 'RMO Charges' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as income FROM `ip_debitnotebrief` WHERE `description` = 'Others' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE `transactionmode` <> 'ADJUSTMENT' AND `transactiondate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$income += $rescr1['income'];
						
						//$ledgertotal = $ledgertotal - $income;
						}
						$totalamount +=$income - $incomedebit;				
				}
				}
				$openingbalance1 =$totalamount + $open1;
				$income=0;
				$incomedebit=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
				$scount=0;
				 $query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					 $id = $res267['id'];
					//$id2 = trim($id2);
					
						$i = 0;
						$crresult = array();
						$querydr1 = "SELECT debitamount as expenses,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$expensescr = $resdr1['expenses'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						$scount =$scount+1;
						if($scount ==1)
						{
						$ledgertotal = $ledgertotal - $expensescr +$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal - $expensescr;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
                        <td align="right" class="bodytext3"><?php echo number_format($expensescr,2); ?></td>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}
						
						$i = 0;
						$crresult = array();
						$querycr1 = "SELECT creditamount as expensescr,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$expensescr = $rescr1['expensescr'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount =$scount+1;
						if($scount ==1)
						{
						$ledgertotal = $ledgertotal + $expensescr +$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $expensescr;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($expensescr,2); ?></td>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}
					
					if($id == '03-3003-NHL')	
					{	
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,code,name,docno,date FROM (SELECT `fxamount` as income, patientcode as code, patientname as name, billno as docno, billdate as date FROM `billing_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `consultation` as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`consultation`) as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2') as tt order by tt.date";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$income = $rescr1['income'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				
					}
					if($id == '03-3004-OI')	
					{	
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,code,name,docno,date FROM (SELECT `fxamount` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_opambulancepaylater` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2') as cc";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$income = $rescr1['income'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				
					}
					
					else if($id == '01-1010-NHL-2')	
					{	
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT `amountuhx` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$income = $rescr1['income'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				
					}
					
					else if($id == '03-3002-NHL')
					{
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,code,name,docno,date FROM (SELECT `fxamount` as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `amountuhx` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `amountuhx` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `amountuhx` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `amount` as income, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `transactionamount` as income, receiptcoa as code, remarks as name, docnumber as docno, transactiondate as date FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
										UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
										UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
										UNION ALL SELECT `fxamount` as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'
										
										UNION ALL SELECT (-1*`referalrate`) as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									    UNION ALL SELECT (-1*`referalrate`) as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									    UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
										UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
										UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
										UNION ALL SELECT (-1*`fxamount`) as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others') as tt order by tt.date";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$income = $rescr1['income'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				}
				else if($id == '03-3002-OI')
				{
				
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,code,name,docno,date FROM (SELECT admissionfees as income, patientcode as code,  patientfullname as name,CONCAT( visitcode,'- Admissionfee') as docno, consultationdate as date from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'
						UNION ALL SELECT consultationfees -(consultationfees*planpercentage/100)-planfixedamount as income, patientcode as code, patientfullname as name, CONCAT(visitcode,'- Consultationfees') as docno, consultationdate as date from master_visitentry where overallpayment <> 'completed' and consultationdate between '$ADate1' and '$ADate2'
						UNION ALL SELECT `amount` as income, patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ipmisc_billing` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT 'bed' as income, patientcode as code, patientname as name,docno as docno, recorddate as date FROM `ip_bedallocation` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL select 'package' as income, patientcode as code, patientfullname as name, visitcode as docno, consultationdate as date from master_ipvisitentry where visitcode not in (select visitcode from `billing_ip`) and consultationdate between '$ADate1' and '$ADate2' and package <> 0
						) as tt order by tt.date";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$income = $rescr1['income'];
						$code = $rescr1['code'];
						$name = $rescr1['name'];
						$docno = $rescr1['docno'];
						$date = $rescr1['date'];
						$scount=$scount+1;
						if($income == 'bed')
						{
						$qrybed = "select ward,bed,visitcode,recorddate,leavingdate from ip_bedallocation where docno = '$docno'";
						$execbed = mysqli_query($GLOBALS["___mysqli_ston"], $qrybed) or die ("Error in qrybed".mysqli_error($GLOBALS["___mysqli_ston"]));
						$resbed=mysqli_fetch_array($execbed);
						$viscode = $resbed['visitcode'];
						 $bedanum = $resbed['bed'];
						 $recorddate = $resbed['recorddate'];
						 $leavingdate = $resbed['leavingdate'];
						 if($leavingdate != '0000-00-00')
						 {
						 $date1=date_create($recorddate);
						$date2=date_create($leavingdate);
						$diff=date_diff($date1,$date2);
						$days = $diff->format("%R%a days");
						 }
						 else
						 {
						 $date1=date_create($recorddate);
						$date2=date_create($ADate2);
						$diff=date_diff($date1,$date2);
						$days = $diff->format("%a");
						 }
						$qrybedtemp = "select bedtemplate,fxrate from master_subtype where auto_number in (select subtype from master_ipvisitentry where visitcode = '$viscode')";
						$exebedtemp = mysqli_query($GLOBALS["___mysqli_ston"], $qrybedtemp) or die ("Error in qrybedtemp".mysqli_error($GLOBALS["___mysqli_ston"]));
						$resbedtemp=mysqli_fetch_array($exebedtemp);
						 $bedtemp = $resbedtemp['bedtemplate'];
						$fxrate = $resbedtemp['fxrate'];
						$qrybedrate = "select rate from $bedtemp where charge = 'Accommodation Charges' and bedanum = $bedanum";
						$execbedrate = mysqli_query($GLOBALS["___mysqli_ston"], $qrybedrate);
						$resbedrate = mysqli_fetch_assoc($execbedrate);
						 $income = $resbedrate['rate']*$fxrate*$days;
						 if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno.' - Accommodation Charges'; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						$qrybedrate = "select rate from $bedtemp where charge = 'Nursing Charges' and bedanum = $bedanum";
						$execbedrate = mysqli_query($GLOBALS["___mysqli_ston"], $qrybedrate);
						$resbedrate = mysqli_fetch_assoc($execbedrate);
						 $income = $resbedrate['rate']*$fxrate*$days;
						 if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno.' - Nursing Charges'; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}
						else
						{ if($income == 'package')
						{
						$qrypackage = "select package,subtype from master_ipvisitentry where patientcode = '$code' and $visitcode = '$docno'";
						$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$respackage = mysqli_fetch_array($execpackage);
						$packageanum = $respackage['package'];
						$subtype = $respackage['subtype'];
						$qrypkgtemp = "select fxrate,ippactemplate from master_subtype where auto_number = $subtype ";
						$execpkgtmp = mysqli_query($GLOBALS["___mysqli_ston"], $qrypkgtemp) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
						$respkgtemp = mysqli_fetch_array($execpkgtmp);
							$pkgtmp = $respkgtemp['rate'];
							$fxrate = $respkgtemp['fxrate'];
							$query74 = "select rate from $pkgtmp where auto_number='$packageanum'";
							$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$res74 = mysqli_fetch_array($exec74);
							$income = $res74['rate']*$fxrate;
						}
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $income+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $income;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($income >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($income,2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($income),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				}
				}
				}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php
				}
				
				//here2
				else if($group == '4' || $group == '5' || $group == '6' || $group == '7' || $group == '8' || $group == '9' || $group == '10' || $group == '11' || $group == '12' || $group == '13' 
						|| $group == '27' || $group == '31' || $group == '37' || $group == '38' || $group == '39' || $group == '42' || $group == '43' || $group == '44')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
				$query267 = "select id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					  $id = $res267['id'];
				
					if($id != '')
					{
						$expenses=0;
						 $querydr1 = "SELECT sum(totalamount) as expenses FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` < '$ADate1'  and recordstatus <> 'deleted'
									 UNION ALL SELECT sum(totalamount) as expenses FROM `otherpurchase_details` WHERE `expensecode` = '$id' AND `entrydate` < '$ADate1' and recordstatus <> 'deleted'
									 UNION ALL SELECT sum(totalamount) as expenses FROM `purchase_details` WHERE (`expensecode` = '$id' or `ledgercode` = '$id') AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` < '$ADate1'  and recordstatus <> 'deleted'
									 UNION ALL SELECT sum(transactionamount) as expenses FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` < '$ADate1' 
									 UNION ALL SELECT sum(debitamount) as expenses FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'
									 UNION ALL SELECT SUM(depreciation) as expenses FROM depreciation_information WHERE depreciationcode = '$id' AND recorddate < '$ADate1'
									 UNION ALL SELECT SUM(depreciation) as expenses FROM depreciation_information WHERE accumulateddepreciationcode = '$id' AND recorddate < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr13".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
					
						$expenses += $resdr1['expenses'];
						//$ledgertotal = $ledgertotal + $expenses;
						}
					$expensescr=0;
					$i = 0;
						$querycr1 = "SELECT sum(creditamount) as expensescr FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$i = $i+1;
						$expensescr += $rescr1['expensescr'];
					
						//$ledgertotal = $ledgertotal - $expensescr;
						
						}
						
						
					$totalamount +=$expenses-$expensescr;
				//end here	
				
				}
					
				}
				$openingbalance1 =$totalamount;
				$expensescr=0;
				$expenses=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
				$scount=0;
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					  $id = $res267['id'];
					//$id2 = trim($id2);
					
					$ledgertotal = 0;
					//include('include_ledgervalue.php');
					//$balance = 0;
					if($id != '')
					{
						$i = 0;
						$result = array();
						$querydr1 = "SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,locationcode as code, itemname as name, billnumber as docno, entrydate as date FROM `otherpurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT `totalamount` as expenses,itemcode as code, itemname as name, billnumber as docno, entrydate as date FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								     UNION ALL SELECT a.`totalamount` as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SUPO%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
								     UNION ALL SELECT `transactionamount` as expenses,expensecoa as code, expenseaccount as name, docnumber as docno, transactiondate as date FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT a.`amount` as expenses,a.itemcode as code, a.itemname as name, a.docno as docno, a.entrydate as date FROM `master_stock_transfer` AS a WHERE a.tostore = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
									 
									 UNION ALL SELECT (-1*a.`totalcp`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT (-1*a.`totalamount`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `purchasereturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
									 UNION ALL SELECT (-1*a.`amount`) as expenses,a.itemcode as code, a.itemname as name, a.docno as docno, a.entrydate as date FROM `master_stock_transfer` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.tostore not like 'STO%'
									 UNION ALL SELECT (-1*`totalamount`) as expenses,itemcode as code, itemname as name, billnumber as docno, entrydate as date FROM `purchasereturn_details` WHERE expensecode = '$id' AND entrydate BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT (-1*`creditamount`) as expenses,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr13".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$expenses = $resdr1['expenses'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						$scount =$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $expenses +$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $expenses;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($expenses >= 0) { ?>
						<td align="right" class="bodytext3"><?php echo number_format($expenses,2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format(abs($expenses),2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}				
				}
					
				}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php
				}
				
				//Accounts Receivable-15
				else if($group == '15' || $group == '41')
				{
					$totalamount=0;
					$openingbalance1=0;
					?>
                     <tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Cheque No'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
                    <?php
					
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					 $id = $res267['id'];
					
					if($id != '')
					{
						$paylater=0;
					 $querydr1 = "SELECT sum(transactionamount) as paylater FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
								 UNION ALL SELECT sum(totalrevenue) as paylater FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` < '$ADate1' 
								 UNION ALL SELECT sum(`totalamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `visitcode` = '$id' AND `billdate` < '$ADate1' 
					             UNION ALL SELECT sum(transactionamount) as paylater  FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%' AND `accountname` <> 'CASH COLLECTIONS'
								 UNION ALL SELECT sum(debitamount) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' 
								 UNION ALL SELECT sum(openbalanceamount) as paylater FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1' ";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr14".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($execdr1);
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
						$paylater += $resdr1['paylater'];
					//	$ledgertotal = $ledgertotal + $paylater;
						}
					$paylatercredit=0;
					 $querycr1 = "SELECT sum(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT sum(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT sum(transactionamount) as paylatercredit  FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'pharmacycredit' AND `accountname` <> '' AND `accountname` <> 'CASH COLLECTIONS'
								 UNION ALL SELECT sum(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `accountname` <> 'CASH COLLECTIONS' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT sum(deposit) as paylatercredit  FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` < '$ADate1' 
								 UNION ALL SELECT sum(creditamount) as paylatercredit  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rescr1 = mysqli_fetch_array($execcr1))
					{
					
						$paylatercredit += $rescr1['paylatercredit'];
						
					}
					
					$totalamount +=$paylater-$paylatercredit;
						
					}

				
				}
					$openingbalance1 =$totalamount;
				$paylater=0;
				$paylatercredit=0;
				$openingbalance1 = 0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
					$scount=0;
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
					
					$ledgertotal = 0;
					//include('include_ledgervalue.php');
					//$balance = 0;
					
					
					if($id != '')
					{
						$i = 0;
					
					
					$result = array();
					 $querydr1 = "SELECT paylater,code,name,docno,date,chequenum FROM (SELECT `fxamount` as paylater, patientcode as code, CONCAT('Paylater Bill - ',patientname) as name, billnumber as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
								 UNION ALL SELECT `totalamountuhx` as paylater, patientcode as code, CONCAT('IP Bill - ',patientname) as name, billno as billno, billdate as billdate,depositcoa as chequenum  FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT `fxamount` as paylater, patientcode as code, CONCAT('IP Credit Approve Bill - ',patientname) as name, billno as docno, billdate as date,auto_number as chequenum FROM `billing_ipcreditapprovedtransaction` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					             UNION ALL SELECT `fxamount` as paylater,patientcode as code, CONCAT('IP Debit - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequenum  FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
								 UNION ALL SELECT `debitamount` as paylater, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 
								 UNION ALL SELECT (-1*fxamount) as paylater, patientcode as code, CONCAT('IP Credit - ',patientname) as name, docno as docno, transactiondate as date ,chequenumber as chequenum FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*fxamount) as paylater, patientcode as code, CONCAT('OP Credit - ',patientname) as name, docno as docno, transactiondate as date ,chequenumber as chequenum FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*fxamount) as paylater, patientcode as code, CONCAT('Pharmacy Credit - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequenum  FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'
								 UNION ALL SELECT (-1*`transactionamount`) as paylater, accountcode as code, CONCAT(remarks,' - ',accountname,' By ',transactionmode) as name, docno as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT (-1*ABS(`deposit`)) as paylater, patientcode as code, CONCAT('IP Deposit Credit - ',patientname) as name, billno as billno, billdate as date,depositcoa as chequenum  FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (-1*`creditamount`) as paylater, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as p ORDER BY p.date";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr14".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($execdr1);
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
						$i = $i+1;
						$paylater = $resdr1['paylater'];
						$code = $resdr1['code'];
						$name = $resdr1['name'];
						$docno = $resdr1['docno'];
						$date = $resdr1['date'];
						$chequenum=$resdr1['chequenum'];
						$scount= $scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $paylater +$openingbalance1;
						}
						else
						{
						$ledgertotal = $ledgertotal + $paylater;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
						<td align="left" class="bodytext3"><?php echo $chequenum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($paylater >= 0) { ?>
                        <td align="right" class="bodytext3"><?php echo number_format($paylater,2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format($paylater,2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        
                        </tr>
                        <?php
						}
					}				
				}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php
				}
				
				//Bank & Cash Account-16
				else if($group == '16' || $group == '17' || $group == '18')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Cheque No'; ?></strong></td>
				<!--<td width="105" align="left" class="bodytext3"><strong><?php echo 'Trans Mode/Code'; ?></strong></td>-->
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					
					$query267 = "select id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					$id = $res267['id'];
					
					$bankamount = 0;
					$querydr1bnk = "SELECT sum(transactionamount) as bankamount  FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` < '$ADate1'  AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
					UNION ALL SELECT sum(transactionamount) as bankamount  FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id')  AND `transactiondate` < '$ADate1'  AND `billnumber` LIKE 'OPC%'
					UNION ALL SELECT sum(transactionamount) as bankamount  FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1' 
					UNION ALL SELECT sum(consultation) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `billdate` < '$ADate1' 
					UNION ALL SELECT sum(totalrevenue) as bankamount FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` < '$ADate1' 
					UNION ALL SELECT sum(transactionamount) as bankamount FROM `master_transactionpaylater` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `accountname` <> 'CASH COLLECTIONS' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT sum(transactionamount) as bankamount FROM `receiptsub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1' 
					UNION ALL SELECT sum(transactionamount) as bankamount  FROM `master_transactionadvancedeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1' 
					UNION ALL SELECT sum(transactionamount) as bankamount  FROM `master_transactionipdeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1'  AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT sum(debitamount) as bankamount  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'
					UNION ALL SELECT sum(openbalanceamount) as bankamount FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'
					UNION ALL SELECT SUM(amount) as bankamount FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` < '$ADate1'";
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1)){
		
	
						$bankamount += $resdr1['bankamount'];
					//	 $ledgertotal = $ledgertotal + $bankamount;
						}
						
	$bankcredit=0;
	$querycr1bnk = "SELECT sum(transactionamount) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1' 
					UNION ALL SELECT sum(transactionamount) as bankcredit FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` < '$ADate1'  AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `recordstatus` = 'allocated'
					UNION ALL SELECT sum(transactionamount) as bankcredit FROM `expensesub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` < '$ADate1' 
					UNION ALL SELECT sum(amount) as bankcredit FROM `deposit_refund` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `recorddate` < '$ADate1' 
					UNION ALL SELECT sum(deposit) as bankcredit FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` < '$ADate1' 
					UNION ALL SELECT sum(creditamount) as bankcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' 
					UNION ALL SELECT SUM(creditamount) as bankcredit FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` < '$ADate1'";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{

					
						 $bankcredit += $rescr1['bankcredit'];
						
						}
						
						$totalamount +=$bankamount- $bankcredit;
						}		
					
					$openingbalance1 =$totalamount;
				$bankamount=0;
				$bankcredit=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="2" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="10" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
					$scount=0;
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
					$type=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT transactionmode FROM financialaccount WHERE ledgercode = '".$id."'"))[0];
			
			switch($type){
			case 'CREDITCARD':
				$col= 'cardamount';
				break;
			case 'MPESA':
				$col= 'creditamount';
				break;
			case 'CHEQUE':
				$col= 'chequeamount';
				break;
			case 'ONLINE':
				$col= 'onlineamount';
				break;
			case 'CASH':
				$col= 'cashamount';
				break;
			default :
				$col = 'transactionamount';
				break;	
			}
					
					$accountbank = 0;
					$i = 0;
					$drresult = array();
					$querydr1bnk = "SELECT bankamount,code,name,docno,date,chequeno FROM (SELECT `openbalanceamount` as bankamount, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date, 'Opening Balance' as chequeno FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' 
					UNION ALL SELECT `fxamount` as bankamount, patientcode as code, CONCAT('Bill - ',patientname) as name, billnumber as docno, transactiondate as date, transactionmode as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
					UNION ALL SELECT `$col` as bankamount, patientcode as code, CONCAT('Bill - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id' or `transactionmode` = 'SPLIT') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'OPC%' AND '$id' in (select ledgercode from financialaccount)
					UNION ALL SELECT `transactionamount` as bankamount, patientcode as code, CONCAT('External bill - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `consultation` as bankamount, patientcode as code, CONCAT('Consult bill - ',patientname) as name, billnumber as docno, billdate as date, paymentstatus as chequeno FROM `billing_consultation` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT a.`totalamountuhx` as bankamount,a.patientcode as code, CONCAT('IP bill - ',a.patientname) as name, a.billnumber as billno, a.transactiondate as date, a.chequenumber as chequeno FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT `fxamount` as bankamount, patientcode as code, CONCAT('IP Credit Approve Bill - ',patientname) as name, billno as docno, billdate as date,auto_number as chequeno FROM `billing_ipcreditapprovedtransaction` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT `transactionamount` as bankamount, transactionmode as code, CONCAT(remarks,' - ',accountname,' - By ',transactionmode) as name, docno as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionpaylater` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
					
					UNION ALL SELECT `transactionamount` as bankamount,receiptcoa as code, remarks as name, docnumber as docno, transactiondate as date, chequenumber as chequeno FROM `receiptsub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `$col` as bankamount, patientcode as code, CONCAT('Advance deposit - ',patientname) as name, docno as docno, transactiondate as date , chequenumber as chequeno FROM `master_transactionadvancedeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `$col` as bankamount, patientcode as code, CONCAT('IP deposit - ',patientname) as name, docno as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionipdeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					
					UNION ALL SELECT `debitamount` as bankamount, ledgerid as code, CONCAT('By Journal - ',ledgername) as name, docno as docno, entrydate as date, vouchertype as chequeno  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT amount as bankamount, tobankid as code, CONCAT('Bank Transaction - ',remarks) as name, docnumber as docno,transactiondate as date,chequenumber as chequeno FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT totalamount as bankamount, grnbillnumber as code, CONCAT('Payment Cancelation - ',itemname) as name, billnumber as docno,entrydate as date,remarks as chequeno FROM `purchasereturn_details` WHERE `bankcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('Credit Note - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('IP Credit Note - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('Phar Credit - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'			
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, patientcode as code, CONCAT('OP Refund - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno FROM `refund_paynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactionmode as code, CONCAT(remarks,' - By ',transactionmode) as name, docno as docno, transactiondate as date , chequenumber as chequeno FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND (`docno` LIKE 'SP-%' or `docno` LIKE 'SPE-%')
					
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactionmode as code, remarks as name, docnumber as docno, transactiondate as date , chequenumber as chequeno  FROM `expensesub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					
					UNION ALL SELECT (-1*`creditamount`) as bankamount, ledgerid as code, narration as name, docno as docno, entrydate as date, vouchertype as chequeno FROM `master_journalentries` WHERE `ledgerid` = '$id' AND creditamount <> '0.00' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT (-1*creditamount) as bankamount, frombankid as code, CONCAT('Bank Transaction - ',remarks) as name, docnumber as docno,transactiondate as date,chequenumber as chequeno FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT (-1*`openbalanceamount`) as bankamount, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date, 'Opening Balance' as chequeno FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus ='0') as t ORDER BY t.date";
					/*UNION ALL SELECT (-1*`amount`) as bankamount, patientcode as code, CONCAT(remarks,' - ',patientname) as name, docno as docno,recorddate as date , transactionmode as chequeno FROM `deposit_refund` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
					
					*/
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1)){
	$i = $i+1;
						$bankamount = $resdr1['bankamount'];
						 $code = $resdr1['code'];
						 $name = $resdr1['name'];
						 $docno = $resdr1['docno'];
						 $date = $resdr1['date'];
						 $chequeno = $resdr1['chequeno'];
						 $scount=$scount+1;
						 if($scount==1)
						 {
						 $ledgertotal = $ledgertotal + $bankamount+$openingbalance1;
						 }
						 else
						 {
							 $ledgertotal = $ledgertotal + $bankamount;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo date('d-m-Y',strtotime($date)); ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
						<td align="left" class="bodytext3"><?php echo $chequeno; ?></td>
                        <!--<td align="left" class="bodytext3"><?php echo $code; ?></td>-->
                        <td align="left" class="bodytext3"><?php echo ucfirst($name); ?></td>
						<?php if($bankamount >= 0) { ?>
						<td align="right" class="bodytext3"><?php echo number_format($bankamount,2); ?></td>
						<td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
                        <td width="17" align="right" class="bodytext3"><?php echo number_format(abs($bankamount),2); ?></td>
						<?php } ?>
                        <td width="17" align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}
	
				}		
					?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php	
					}
				
				
				
				//ACCOUNTS PAYABLE-19
				else if($group == '19' || $group == '20' || $group == '23' || $group == '24' || $group == '30' || $group == '40' || $group == '47' || $group == '57' || $group == '58')
				{
					$totalamount=0;
					$openingbalance1=0;?>
                     <tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Cheque No'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
                    <?php 
					
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub= '$group' and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
			
					$id = $res267['id'];
					
					
					if($id != '')
					{
						$payablesdr = 0;
						
					$querydr1 = "SELECT sum(transactionamount) as payablesdr FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SP%') AND `recordstatus` = 'allocated' AND `transactiondate` < '$ADate1' 
				 UNION ALL SELECT sum(totalamount) as payablesdr FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` < '$ADate1' 
				 UNION ALL SELECT sum(debitamount) as payablesdr FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
				$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr15".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resdr1 = mysqli_fetch_array($execdr1))
				{
					
						 $payablesdr += $resdr1['payablesdr'];
						// $ledgertotal = $ledgertotal - $payablesdr;
						}		
				}
 
					$payables = 0;
				
				$querycr1 = "SELECT sum(transactionamount) as payables FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` < '$ADate1' 
							 UNION ALL SELECT sum(creditamount) as payables FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'
							 UNION ALL SELECT sum(openbalanceamount) as payables FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'";
				$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescr1 = mysqli_fetch_array($execcr1))
				{
				
						 $payables += $rescr1['payables'];
						
						 
						  //$ledgertotal = $ledgertotal + $payables;
						}
						
						$totalamount +=$payables-$payablesdr;
						
					}
					
				$openingbalance1 =$totalamount;
				$payables=0;
				$payablesdr=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
					$scount=0;
					$ledgertotal = 0;
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub= '$group' and id like '%$ledgerid%'";
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
						$i = 0;
						$result = array();
						 $querydr1 = "SELECT payables,code,name,docno,date,chequenum FROM (SELECT (-1*`transactionamount`) as payables, suppliercode as code, CONCAT('Payment - ',remarks) as name, docno as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
						 UNION ALL SELECT (-1*`totalamount`) as payables,suppliercode as code, CONCAT('Return - ',suppliername) as name, billnumber as docno, entrydate as date,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						 UNION ALL SELECT (-1*`debitamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						 UNION ALL SELECT (-1*`transactionamount`) as payables,expensecoa as code, remarks as name, docnumber as docno, transactiondate as date, chequenumber as chequenum FROM `expensesub_details` WHERE `expensecoa` = '$id' AND transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'
						 
						 UNION ALL SELECT `transactionamount` as payables, suppliercode as code, CONCAT('Purchase - ',suppliername) as name, billnumber as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
						 UNION ALL SELECT `creditamount` as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as ap order by ap.date";
						 $execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr15".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
							$i = $i+1;
						 $payablesdr = $resdr1['payables'];
						 $code = $resdr1['code'];
						 $name = $resdr1['name'];
						 $docno = $resdr1['docno'];
						 $date = $resdr1['date'];
						 $chequenum= $resdr1['chequenum'];
						 $scount=$scount+1;
						 if($scount==1)
						 {
						 $ledgertotal = $ledgertotal + $payablesdr +$openingbalance1;
						 }
						 else
						 {
							 $ledgertotal = $ledgertotal + $payablesdr;
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
						<td align="left" class="bodytext3"><?php echo $chequenum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($payablesdr < 0) { ?>
                        <td align="right" class="bodytext3"><?php echo number_format(abs($payablesdr),2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format($payablesdr,2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}		
					}
				}
				
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php	
				}
								
				//PATIENT DEPOSITS-21
				else if($group == '21')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
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
				$deposit=0;
				$depositref=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
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
						 $scount=$scount+1;
						 if($scount==1)
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
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                        <td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($depositref < 0) { ?>
                        <td align="right" class="bodytext3"><?php echo number_format(abs($depositref),2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="left" class="bodytext3">&nbsp;</td>
						<td align="right" class="bodytext3"><?php echo number_format($depositref,2); ?></td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
                        <?php
						}		
										
					}
					else
					{
						$balance = 0;
					}	
					}
					?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				<?php	
				}
				
				else if($group == '45')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
						
						$query267 = "select id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					$id = $res267['id'];
					
					
					if($id == '01-10031-NHL')
					{
						
					$income=0;
						$querycr1in = "SELECT sum(labitemrate) as income FROM `billing_paylaterlab` WHERE `billnumber` LIKE 'CB%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(labitemrate) as income FROM `billing_paynowlab` WHERE `billnumber` LIKE 'OPC%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(labitemrate) as income FROM `billing_externallab` WHERE `billnumber` LIKE 'EB%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(rateuhx) as income FROM `billing_iplab` WHERE `billnumber` LIKE 'IPF-%' AND `billdate` < '$ADate2' 
									   UNION ALL SELECT sum(rateuhx) as income FROM `billing_iplab` WHERE `billnumber` LIKE 'IPFCA%' AND `billdate` < '$ADate2' 
									   UNION ALL SELECT sum(rate) as income FROM `ip_debitnotebrief` WHERE `description` = 'Lab' AND `consultationdate` < '$ADate1' 
									   UNION ALL SELECT sum(creditamount) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$income +=$rescr1['income'];
					//	$ledgertotal = $ledgertotal + $rescr1['income'];
						}	
						
					$incomedb=0;
					 	$querydr1in = "SELECT sum(labitemrate) as incomedebit FROM `refund_paynowlab` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(labitemrate) as incomedebit FROM `refund_paylaterlab` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(rate) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Lab' AND `consultationdate` < '$ADate1' 
									   UNION ALL SELECT sum(debitamount) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
							$incomedb +=$resdr1['incomedebit'];
						
						}
					$totalamount=$income-$incomedb;	
					}	
					}
					$openingbalance1 =$totalamount;
				$income=0;
				$incomedb=0;
				$openingbalance1=0;
				?>
					 <!-- <tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
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
					
					if($id == '01-10031-NHL')
					{
						
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT income,td2,td3,td4,td5 FROM (SELECT `fxamount` as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `labitemrate` as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `billing_externallab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `rateuhx` as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `billing_iplab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `fxamount` as income,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE `description` = 'Lab' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `creditamount` as income, entrydate as td2, docno as td3, ledgerid as td4, ledgername as td5  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`labfxamount`) as income, entrydate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_patientweivers` WHERE labfxamount > '0' and entrydate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`labitemrate`) as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `refund_paynowlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`fxamount`) as income,billdate as td2, billnumber as td3, labitemcode as td4, labitemname as td5 FROM `refund_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`fxamount`) as income,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE `description` = 'Lab' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`debitamount`) as income, entrydate as td2, docno as td3, ledgerid as td4, ledgername as td5  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as lab ORDER BY lab.td2";
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
						<?php if($rescr1['income']>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
						<?php
						}	
					}	
					}
				?>
				
				
				<?php
				
				
				
				//unfinal lab
					if($id == '01-10032-LAB')
					{     //ip income lab
				$labtotal=0;
		$sno=0;
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
			
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
			$fxrate = $execsubtype['fxrate'];
			
			$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
			$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtl32 = mysqli_num_rows($exectl32);
			$exectl=mysqli_fetch_array($exectl32);		
			$labtable=$exectl['templatename'];
			if($labtable=='')
			{
				$labtable='master_lab';
			}
			
		 $totallab=0;
			    $totallabuhx=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if($labfree == 'No')
			{
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resl51 = mysqli_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];
		//	$labdesc1 = $resl51['itemname'];
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
			$totallab=$totallab+$labrate;
			
			 $labrateuhx = $labrate*$fxrate;
		   $totallabuhx = $totallabuhx + $labrateuhx;
		   $labtotal = $labtotal + $labrateuhx;
			$ledgertotal=$ledgertotal+$labrateuhx;
			 ?>
			 	<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labrefno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labname; ?></td>
						<?php if($labrateuhx>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($labrateuhx,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($labrateuhx,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
			 
         
	<?php
		}
		}
			  }
				}
				//ipunfinal
				
				//opunfinal
					  $totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';

					$query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'  group by accountfullname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountnameano = $res21['accountname'];
			$labdocnum='nan';
			$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res21accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
		
			
			
			$res3labitemrate = "0.00";
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
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
			$labtemplate = $execsubtype['labtemplate'];
			if($labtemplate == '') { $labtemplate = 'master_lab'; }
			$radtemplate = $execsubtype['radtemplate'];
			if($radtemplate == '') { $radtemplate = 'master_radiology'; }
			$sertemplate = $execsubtype['sertemplate'];
			if($sertemplate == '') { $sertemplate = 'master_services'; }
		  
		  $res3labitemrate = 0;
		  $query3 = "select labitemcode,labitemname,docnumber from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec3))
		  {
		  		$labcode = $res3['labitemcode']; 
				$labname= $res3['labitemname'];
				$labdocnum= $res3['docnumber'];
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				//$labname= $resfx['itemname'];
				$labrate=$resfx['rateperunit'] * $fxrate;
				if(($planpercentage!=0.00)&&($planforall=='yes'))
			  	{ 
					$labrate = $labrate - ($labrate/100)*$planpercentage;
				}
				$res3labitemrate = $res3labitemrate + $labrate;
		  }
		  
		  $res4servicesitemrate = 0;
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
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
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
		  $snocount = $snocount + 1;
				$ledgertotal=$ledgertotal+$res3labitemrate;
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
	
			if($labdocnum!='nan'){
			?><tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $res2registrationdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labdocnum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labcode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $labname; ?></td>
						<?php if($res3labitemrate>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($res3labitemrate,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($res3labitemrate,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
          
			<?php
			}//nan
			
			
			}
			}
			}   //opunfinal
				//unfinal lab end
				
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr> <?php
				}
				
				else if($group == '36')
				{
					
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
						
						$query267 = "select id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					$id = $res267['id'];
					
					
					if($id == '01-1015-NHL')
					{
						
					$income=0;
						$querycr1in = "SELECT SUM(`amount`) as income FROM `billing_paylaterservices` WHERE `billnumber` LIKE 'CB%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE `billnumber` LIKE 'OPC%' AND `billdate` < '$ADate1' 
									   UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE `billnumber` LIKE 'EB%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE `billnumber` LIKE 'IPF-%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE `billnumber` LIKE 'IPFCA%' AND `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as income FROM `ip_debitnotebrief` WHERE `description` = 'Service' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$income +=$rescr1['income'];
					//	$ledgertotal = $ledgertotal + $rescr1['income'];
						}	
						
					$incomedb=0;
					 	$querydr1in = "SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` WHERE `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterservices` WHERE `billdate` < '$ADate1'
									   UNION ALL SELECT SUM(`rate`) as incomedebit FROM `ip_creditnotebrief` WHERE `description` = 'Service' AND `consultationdate` < '$ADate1'
									   UNION ALL SELECT SUM(`debitamount`) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
							$incomedb +=$resdr1['incomedebit'];
						
						}
					$totalamount=$income-$incomedb;	
					}	
					}
					$openingbalance1 =$totalamount;
				$income=0;
				$incomedb=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
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
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT `fxamount` as income ,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `billing_paylaterservices` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT `fxamount` as income,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `billing_paynowservices` WHERE `billnumber` LIKE 'OPC%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT `servicesitemrate` as income,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `billing_externalservices` WHERE `billnumber` LIKE 'EB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT `servicesitemrateuhx` as income,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `billing_ipservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT `fxamount` as income,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE `description` = 'Service' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `creditamount` as income, entrydate as td2, docno as td3, ledgerid as td4, ledgername as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`serviceamount`) as income,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `refund_paynowservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT (-1*`fxamount`) as income,billdate as td2, billnumber as td3, servicesitemcode as td4, servicesitemname as td5 FROM `refund_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and `servicesitemcode` in (SELECT `itemcode` FROM `master_services` where ledgerid='$id')
									   UNION ALL SELECT (-1*`fxamount`) as income,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE `description` = 'Service' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`debitamount`) as income, entrydate as td2, docno as td3, ledgerid as td4, ledgername as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
						<?php if($rescr1['income'] >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
						<?php
						}
						
						if($id == '01-1014-SI')
						{
						$querycr1in = "SELECT (-1*`servicesfxamount`) as income ,entrydate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_patientweivers` WHERE servicesfxamount > 0 and `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
						<?php if($rescr1['income'] >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
						<?php
						}
						}	
						
												if($id == '01-1013-SI')                 //ser unfinal
					{     //ip income rad
			       $colorloopcount ='';
			$netamount='';
			$sno=0;
			$totalradiologyitemrate =0;
			
			$totalservicesitemrate =0;
			$totalquantity = 0;
			
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
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
			$fxrate = $execsubtype['fxrate'];
			
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
		
			$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$servicesdoctorname = $res21['doctorname'];
			$sercode=$res21['servicesitemcode'];
			$serviceledgercode=$res21['incomeledgercode'];
			$serviceledgername=$res21['incomeledgername'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$res211 = mysqli_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			if($servicesfree == 'No')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			/*$totserrate=$serrate*$numrow2111;*/
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
				$totserrate=($serqty*$serrate);
			$totalser=$totalser+$totserrate;
			
			 $totserrateuhx = ($serrate*$fxrate)*$serqty;
		   $totalseruhx = $totalseruhx + $totserrateuhx;
		   $totalservicesitemrate = $totalservicesitemrate + $totserrateuhx;
			$balance=$totalservicesitemrate;
			$ledgertotal=$ledgertotal+$totserrateuhx;
			//$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			 ?>
			 	<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $serdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $serref; ?></td>
                        <td align="left" class="bodytext3"><?php echo $sercode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $sername; ?></td>
						<?php if($totserrateuhx>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($totserrateuhx,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($totserrateuhx,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
			 
         
	<?php
		
		
		
		}
		}
		}           //ip income lab end
			  
			  
			  //op income lab
			  $totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
			 $query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'  group by accountfullname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountnameano = $res21['accountname'];
			$serdocnum='nan';
			$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res21accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			
			
		
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
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
		  $query4 = "select servicesitemcode,serviceqty,refundquantity,servicesitemname,docnumber from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
		  {
		  	 $sercode=$res4['servicesitemcode'];
			 $sername= $res4['servicesitemname'];
$serdocnum= $res4['docnumber'];

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
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
		
			$ledgertotal=$ledgertotal+$res4servicesitemrate;
			//echo "hi".$totalamount4;
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
	
			if($serdocnum!='nan'){
			?><tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $res2registrationdate; ?></td>
                        <td align="left" class="bodytext3"><?php echo $serdocnum; ?></td>
                        <td align="left" class="bodytext3"><?php echo $sercode; ?></td>
                        <td align="left" class="bodytext3"><?php echo $sername; ?></td>
						<?php if($res4servicesitemrate>=0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($res4servicesitemrate,2,'.',',');  ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format($res4servicesitemrate,2,'.',',');  ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?php echo number_format($ledgertotal,2,'.',','); ?></td>
                        </tr>
          
			<?php
			}//nan
			}
			}
			
			}    //op income lab end
				
				//echo $totalamount5;
				//echo "   hi".$totalamount3 ."bal".$balance;
				$balance=$balance+$totalamount3;
				
					} 
						
					}	
					}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				
				<?php
				}
				
				else if($group == '61')
				{
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					
				$income=0;
				$incomedb=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
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
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT `fxamount` as income, transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE docno LIKE '%IPDr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT (-1*`fxamount`) as income, transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE docno LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
						<?php if($rescr1['income'] <= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
						<?php
						}
					}	
					}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				
				<?php
				}
				
				else if($group == '64')
				{	
				?>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="105" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="190" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="141" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					
				$income=0;
				$incomedb=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
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
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
										UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
										UNION ALL SELECT (`creditamount`) as income,entrydate as td2,docno as td3,ledgerid as td4, ledgername as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT (-1*`debitamount`) as income,entrydate as td2,docno as td3,ledgerid as td4, ledgername as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
						<?php if($rescr1['income'] >= 0) { ?>
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php } else { ?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr1['income']),2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } ?>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
                        </tr>
						<?php
						}
					}	
					}
				?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				
				<?php
				
				}
				
				if($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
				<!--<tr bgcolor="#ecf0f5">
				<td colspan="9" align="right" class="bodytext3">	
				<a target="_blank" href="ledger_excelreport.php?location=<?php echo $res1locationcode; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&group=<?php echo $group; ?>&&ledgerid=<?php echo $ledgerid; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>&nbsp;	
				</td>
				</tr>-->
				<?php
				}
				?>
                </table>
                </td>
                </tr>
                </tbody>
                
                
          
         
</table>

</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
