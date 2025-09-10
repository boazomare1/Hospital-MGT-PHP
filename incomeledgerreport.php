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
//if (isset($_REQUEST["parentid"])) { $parentid = $_REQUEST["parentid"]; } else { $parentid = ""; }

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
			<?php
						$scount= 1;
   		$ledgertotal = 0;

					$colorloopcount = '';
				$orderid1 = '';
				$lid = '';
				$openingbalance = "0.00";
				$sumopeningbalance = "0.00";
				$totalamount2 = '0.00';
				$totalamount12 = '0.00';
				$balance = '0.00';
				$sumbalance = '0.00';
				
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				 $query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and id='$ledgerid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					$lid = $lid + 1;
					$opening = 0;
					$journal = 0;
					 $i = 0;
					 $balance=0;
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
	$i = 0;
		$crresult1 = array();
		
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
		$querycr1in = "SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT a.`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT `amount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT a.`servicesitemrate`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT a.`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT `amountuhx`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT a.`servicesitemrateuhx`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						union all select (a.`amountuhx`) as income, a.patientcode as code, a.description as name, a.docno as docno, a.recorddate as date  FROM `billing_ipbedcharges` as a join master_ipvisitentry as b on (a.visitcode = b.visitcode and a.ward = '0') join master_ippackage as c on (b.package = c.auto_number) join master_services as d on (c.servicescode = d.itemcode) WHERE a.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Accommodation Charges','Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review','Intensivist Review') and d.ledgerid = '$id' and a.recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT `transactionamount`  as income , receiptcoa as code, remarks as name, docnumber as docno, transactiondate as date  FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2' and receiptcoa = '$id'
						UNION ALL SELECT `creditamount`  as income,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT -1*`amount`  as income , patientcode as code, patientname as name,billnumber as docno, billdate as datedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT `serviceamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as datedebit FROM `refund_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT -1*`amount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as datedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT -1*`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as datedebit FROM `refund_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT -1*`amount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as datedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
		
		UNION ALL SELECT -1*`debitamount`  as income  ,ledgerid as code, ledgername as name, docno as docno, entrydate as datedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		if($id == '01-1007-01')
		{
		$querydr1in .= " UNION ALL SELECT -1*`pharmacyfxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as datedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
		}
		
		if($id == '01-1008')
		{
		$querydr1in .= " UNION ALL SELECT -1*`servicesfxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as datedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT -1*`fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as datedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as datedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = -1*$resdr1['income'];
		$paylater = $resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['datedebit'];
			$chequenum='';
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
			<td align="right" class="bodytext3"><?php echo number_format(abs($paylater),2); ?></td>
			<?php } ?>
			<td align="right" class="bodytext3"><?= number_format($ledgertotal,2);?></td>
			
			</tr>
			<?php
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
		switch($id)
		{
	case '01-1015-01':
		$consdepartment = "IN('1')";
		break;	
	case '01-1015-02':
		$consdepartment = "IN('2')";
		break;
	case '01-1015-03':
		$consdepartment = "IN('3')";
		break;
	case '01-1015-04':
		$consdepartment = "IN('4')";
		break;	
	case '01-1015-05':
		$consdepartment = "IN('5')";
		break;
	case '01-1015-06':
		$consdepartment = "IN('6')";
		break;
	case '01-1015-07':
		$consdepartment = "IN('7')";
		break;	
	case '01-1015-08':
		$consdepartment = "IN('8')";
		break;
	case '01-1015-09':
		$consdepartment = "IN('9')";
		break;
	case '01-1015-10':
		$consdepartment = "IN('10')";
		break;	
	case '01-1015-11':
		$consdepartment = "IN('11')";
		break;
	case '01-1015-12':
		$consdepartment = "IN('12')";
		break;
	case '01-1015-11':
		$consdepartment = "IN('13')";
		break;	
	case '01-1015-14':
		$consdepartment = "IN('14')";
		break;
	case '01-1015-15':
		$consdepartment = "IN('15')";
		break;
	case '01-1015-16':
		$consdepartment = "IN('16')";
		break;	
	case '01-1015-17':
		$consdepartment = "IN('17')";
		break;
	case '01-1015-18':
		$consdepartment = "IN('18')";
		break;
	case '01-1015-19':
		$consdepartment = "IN('19')";
		break;	
	case '01-1015-20':
		$consdepartment = "IN('20')";
		break;
	case '01-1015-21':
		$consdepartment = "IN('21')";
		break;
	case '01-1015-22':
		$consdepartment = "IN('22')";
		break;	
	case '01-1015-23':
		$consdepartment = "IN('23')";
		break;
	case '01-1015-24':
		$consdepartment = "IN('24')";
		break;
	case '01-1015-25':
		$consdepartment = "IN('25')";
		break;	
	case '01-1015-26':
		$consdepartment = "IN('26')";
		break;
	case '01-1015-27':
		$consdepartment = "IN('27')";
		break;
	case '01-1015-28':
		$consdepartment = "IN('28')";
		break;	
	case '01-1015-29':
		$consdepartment = "IN('29')";
		break;
	case '01-1015-30':
		$consdepartment = "IN('30')";
		break;
	case '01-1015-31':
		$consdepartment = "IN('31')";
		break;	
	case '01-1015-32':
		$consdepartment = "IN('32')";
		break;
	case '01-1015-33':
		$consdepartment = "IN('33')";
		break;
	case '01-1015-34':
		$consdepartment = "IN('34')";
		break;	
	case '01-1015-35':
		$consdepartment = "IN('35')";
		break;
	case '01-1015-36':
		$consdepartment = "IN('36')";
		break;
	case '01-1015-37':
		$consdepartment = "IN('37')";
		break;	
	case '01-1015-38':
		$consdepartment = "IN('38')";
		break;
	case '01-1015-39':
		$consdepartment = "IN('39')";
		break;
	case '01-1015-40':
		$consdepartment = "IN('40')";
		break;
	default:
		$consdepartment = "IN('0')";
		break;		
	}
	
	    $i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT a.`consultation`  as income , a.patientcode as code, a.patientname as name, a.billnumber as docno, a.billdate as date FROM `billing_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT a.`fxamount`  as income , a.patientcode as code, a.patientname as name, a.billno as docno, a.billdate as date FROM `billing_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.visitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT -1*a.`consultation`  as income , a.patientcode as code, a.patientname as name, a.billnumber as docno, a.billdate as date FROM `refund_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT -1*a.`consultation`  as income , a.patientcode as code, a.patientname as name, a.billnumber as docno, a.billdate as date FROM `refund_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr12in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
	
		$j = 0;
		$drresult1 = array();
				
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
	if($id=='01-1009')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT a.`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT `labitemrate`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_externallab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT `rateuhx`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_iplab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr13in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT `labitemrate`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				
		$querydr1in .= " UNION ALL SELECT `labfxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as date FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr12in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$crresult1[$i] = -1*$resdr1['income'];
		$paylater = -1*$resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT a.`fxamount`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT `radiologyitemrate`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_externalradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT `fxamount`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT `radiologyitemrateuhx`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `billing_ipradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr14in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT `radiologyitemrate`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `refund_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'
		UNION ALL SELECT `fxamount`  as income , radiologyitemcode as code, radiologyitemname as name, billdate as date, billnumber as docno FROM `refund_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'";
		
		if($id == '01-1014-08')
		{
		$querydr1in .= " UNION ALL SELECT `radiologyfxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as datedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT -1*`fxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as datedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billno as docno, entrydate as datedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr13in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$crresult1[$i] = -1*$resdr1['income'];
		$paylater = -1*$resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	/* 
	*/
	if($id == '01-1001')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT `amountuhx`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT `amountuhx`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr16in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT `fxamount`  as income, patientcode as code, patientname as name, docno as docno, consultationdate as date  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'
		union all SELECT -1*`fxamount`  as income, patientcode as code, patientname as name, docno as docno, consultationdate as date  FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr14in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$crresult1[$i] = -1*$resdr1['income'];
		$paylater = $resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1024-IN')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select `amountuhx`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Bed Charges')
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT -1*`fxamount`  as income , patientcode as code, CONCAT(patientname,' - ',description) as name, docno as docno, consultationdate as date FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr15in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$crresult1[$i] = $resdr1['income'];
		$paylater = $resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1019')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select `amountuhx`  as income , patientcode as code, CONCAT(patientname,' - ',description) as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Nursing Charges')
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Nursing Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT -1*`fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date  FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Nursing Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr16in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$crresult1[$i] = $resdr1['income'];
		$paylater = $resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1020')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select `amountuhx`  as income , patientcode as code, CONCAT(patientname,' - ',description) as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('RMO Charges')
		UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('RMO Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr19in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT -1*`fxamount`  as income , patientcode as code, patientname as name, docno as docno, consultationdate as date  FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('RMO Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr17in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		$paylater = $resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	
	if($id == '01-1022')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select `amountuhx`  as income , patientcode as code, CONCAT(patientname,' - ',description) as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Accommodation Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr19in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}if($id == '01-1012')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select `amountuhx`  as income , patientcode as code, CONCAT(patientname,' - ',description) as name, docno as docno, recorddate as date FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr19in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		$j = 0;
		$drresult1 = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}

	if($id == '01-1008')
	{
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT `fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT `amountuhx`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr110in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT `referalrate`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT `referalrate`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr18in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = -1*$resdr1['incomedebit'];
		$paylater = -1*$resdr1['income'];
			$code = $resdr1['code'];
			$name = $resdr1['name'];
			$docno = $resdr1['docno'];
			$date = $resdr1['date'];
			$chequenum='';
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
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	
	}
	//UNION ALL 
	if($id == '01-1028-IN')
	{
	$i = 0;
		$crresult1 = array();
	$querycr1in = "SELECT a.`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2' and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where parentid in ('62','63') or auto_number in ('62','63'))
						UNION ALL SELECT a.`fxamount`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2' and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where parentid in ('62','63') or auto_number in ('62','63'))
						UNION ALL SELECT a.`servicesitemrateuhx`  as income , patientcode as code, patientname as name, billnumber as docno, billdate as date FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2' and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where parentid in ('62','63') or auto_number in ('62','63'))"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
	if($id == '01-1002')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT `amountuhx`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
		
						UNION ALL SELECT `amount`  as income , patientcode as code, patientname as name, docno as docno, recorddate as date FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr111in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		$j = 0;
		$drresult = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
		$balance = $balance + array_sum($crresult) - array_sum($drresult);
	}	if($id == '01-1029-IN')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT (`fxtotamount`) as income, accountcode as code, itemname as name, billnumber as docno, entrydate as date  FROM `debtors_invoice` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr111in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		$paylater = $rescr1['income'];
			$code = $rescr1['code'];
			$name = $rescr1['name'];
			$docno = $rescr1['docno'];
			$date = $rescr1['date'];
			$chequenum='';
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
		
		$j = 0;
		$drresult = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
		$balance = $balance + array_sum($crresult) - array_sum($drresult);
	}	

		//$balance = $balance + $journal;			
				
			}
			?>
			
				<tr bgcolor="#ecf0f5">
				    <td colspan="9" align="right" class="bodytext3"><strong><?php  echo number_format($ledgertotal,2); ?></strong></td>
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
