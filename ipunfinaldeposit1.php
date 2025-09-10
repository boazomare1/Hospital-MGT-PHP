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
if (isset($_REQUEST["acc_id"])) { $acc_id = $_REQUEST["acc_id"]; } else { $acc_id = ""; }
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
				<td colspan="9" bgcolor="#CCC" class="bodytext3" align="left"><strong><?php echo 'Patient deposit details'; ?></strong></td>
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
				if($group == '14' || $group == '32' || $group == '48' || $group == '49' || $group == '50' || $group == '51' || $group == '52' || $group == '53' || $group == '54')
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
									 UNION ALL SELECT sum(openbalanceamount) as assetvalue FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'
									 UNION ALL SELECT sum(subtotal) as assetvalue FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` < '$ADate1'
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
					$querycr1 = "SELECT sum(creditamount) as expensescr FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rescr1 = mysqli_fetch_array($execcr1);
					$expensescr += $rescr1['expensescr'];	
					
					$openingbalance1=$totalamount - $expensescr;
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
						$result = array();
						$querydr1 = "SELECT `subtotal` as assetvalue, itemdescription as td2, entrydate as td3, billnumber as td4,assetcode as td5 FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT debitamount as assetvalue,ledgername as td2, entrydate as td3, docno as td4,ledgerid as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr12".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$colorloopcount = $colorloopcount + 1;
						$scount=$scount+1;
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
						if($scount ==1)
						{
						$ledgertotal += $resdr1['assetvalue']+$openingbalance1;
						}
						else
						{
							$ledgertotal += $resdr1['assetvalue'];
						}
						?>
						<tr <?php echo $colorcode; ?>>
						 <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
						 <td align="left" class="bodytext3"><?php echo $resdr1['td3']; ?></td>
						  <td align="left" class="bodytext3"><?php echo $resdr1['td4']; ?></td>
						  <td align="left" class="bodytext3"><?php echo $resdr1['td5']; ?></td>
						  <td align="left" class="bodytext3"><?php echo $resdr1['td2']; ?></td>
						<td align="right" class="bodytext3"><?php echo number_format($resdr1['assetvalue'],2); ?></td>
                        <td align="left" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
						</tr>
						<?php
						}
						
						$j = 0;
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
                        <td align="right" class="bodytext3">&nbsp;</td>
                        <td align="right" class="bodytext3"><?php echo number_format($expensescr,2); ?></td>
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
						if($id == '01-10071-NHL')
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
				?>
					<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
					</tr>
				<?php
				}
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
				
					
					if($id != '')
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
					if($id != '')
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
									   UNION ALL SELECT (-1*`consultation`) as income, patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2') as tt order by tt.date";
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
									 
									 UNION ALL SELECT (-1*a.`totalcp`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT (-1*a.`totalamount`) as expenses,a.itemcode as code, a.itemname as name, a.billnumber as docno, a.entrydate as date FROM `purchasereturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
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
					UNION ALL SELECT sum(transactionamount) as bankcredit FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'SP-%' AND `recordstatus` = 'allocated'
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
					
					
					$accountbank = 0;
					$i = 0;
					$drresult = array();
					$querydr1bnk = "SELECT bankamount,code,name,docno,date,chequeno FROM (SELECT `fxamount` as bankamount, patientcode as code, CONCAT('Bill - ',patientname) as name, billnumber as docno, transactiondate as date, transactionmode as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
					UNION ALL SELECT `transactionamount` as bankamount, patientcode as code, CONCAT('Bill - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id')  AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'OPC%'
					UNION ALL SELECT `transactionamount` as bankamount, patientcode as code, CONCAT('External bill - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `consultation` as bankamount, patientcode as code, CONCAT('Consult bill - ',patientname) as name, billnumber as docno, billdate as date, paymentstatus as chequeno FROM `billing_consultation` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `totalamountuhx` as bankamount, patientcode as code, CONCAT('IP bill - ',patientname) as name, billno as billno, billdate as date, depositcoa as chequeno FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `fxamount` as bankamount, patientcode as code, CONCAT('IP Credit Approve Bill - ',patientname) as name, billno as docno, billdate as date,auto_number as chequeno FROM `billing_ipcreditapprovedtransaction` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `transactionamount` as bankamount, transactionmode as code, CONCAT(remarks,' - ',accountname,' - By ',transactionmode) as name, docno as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionpaylater` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT `transactionamount` as bankamount,receiptcoa as code, remarks as name, docnumber as docno, transactiondate as date, chequenumber as chequeno FROM `receiptsub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `transactionamount` as bankamount, patientcode as code, CONCAT('Advance deposit - ',patientname) as name, docno as docno, transactiondate as date , chequenumber as chequeno FROM `master_transactionadvancedeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT `transactionamount` as bankamount, patientcode as code, CONCAT('IP deposit - ',patientname) as name, docno as docno, transactiondate as date, chequenumber as chequeno  FROM `master_transactionipdeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT `debitamount` as bankamount, ledgerid as code, CONCAT('By Journal - ',ledgername) as name, docno as docno, entrydate as date, vouchertype as chequeno  FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT amount as bankamount, tobankid as code, CONCAT('Bank Transaction - ',remarks) as name, docnumber as docno,transactiondate as date,chequenumber as chequeno FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('Credit Note - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('IP Credit Note - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT (-1*fxamount) as bankamount,patientcode as code, CONCAT('Phar Credit - ',patientname) as name, docno as docno, transactiondate as date,chequenumber as chequeno FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'			
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, patientcode as code, CONCAT('OP Refund - ',patientname) as name, billnumber as docno, transactiondate as date, chequenumber as chequeno FROM `refund_paynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactionmode as code, CONCAT(remarks,' - By ',transactionmode) as name, docno as docno, transactiondate as date , chequenumber as chequeno FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'SP-%' AND `recordstatus` = 'allocated'
					UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactionmode as code, remarks as name, docnumber as docno, transactiondate as date , chequenumber as chequeno  FROM `expensesub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*`amount`) as bankamount, patientcode as code, CONCAT(remarks,' - ',patientname) as name, docno as docno,recorddate as date , transactionmode as chequeno FROM `deposit_refund` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*`creditamount`) as bankamount, ledgerid as code, narration as name, docno as docno, entrydate as date, vouchertype as chequeno FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*creditamount) as bankamount, frombankid as code, CONCAT('Bank Transaction - ',remarks) as name, docnumber as docno,transactiondate as date,chequenumber as chequeno FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2') as t ORDER BY t.date";
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
						
					$querydr1 = "SELECT sum(transactionamount) as payablesdr FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `docno` LIKE 'SP-%' AND `recordstatus` = 'allocated' AND `transactiondate` < '$ADate1' 
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
						 $querydr1 = "SELECT payables,code,name,docno,date,chequenum FROM (SELECT (-1*`transactionamount`) as payables, suppliercode as code, CONCAT('Payment - ',remarks) as name, docno as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `docno` LIKE 'SP-%' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
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
				
				
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Amount'; ?></strong></td>
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
						$querydr1dp = "SELECT deposit, code, name, docno, date FROM (SELECT (-1*`amount`) as deposit, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `deposit_refund` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where accountname ='$acc_id')
									   UNION ALL SELECT (-1*ABS(`deposit`)) as deposit, patientcode as code, patientname as name, billno as docno, billdate as date FROM `billing_ip` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where accountname ='$acc_id')
									   UNION ALL SELECT (-1*`debitamount`) as deposit, ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where accountname ='$acc_id')
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT' and visitcode in (select visitcode from master_ipvisitentry where accountname ='$acc_id')
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
                       
						<?php if($depositref < 0) { ?>
                        <td align="right" class="bodytext3"><?php echo '-'.number_format(abs($depositref),2); ?></td>
                        
						<?php } else { ?>
					
						<td align="right" class="bodytext3"><?php echo number_format($depositref,2); ?></td>
						<?php } ?>
                       
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
				<!--<tr>
				<td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_ipunfinaldeposit.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
				</tr>-->
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
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
				
				<?php
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
						
						if($id == '01-1023-NHL')
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
