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
				
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
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
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` as a join master_ipvisitentry as b on (a.visitcode = b.visitcode and a.ward = '0') join master_ippackage as c on (b.package = c.auto_number) join master_services as d on (c.servicescode = d.itemcode) WHERE a.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Accommodation Charges','Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review','Intensivist Review') and d.ledgerid = '$id' and a.recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2' and receiptcoa = '$id'
						UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
		
		UNION ALL SELECT SUM(`debitamount`) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		if($id == '01-1007-01')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`pharmacyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
		}
		
		if($id == '01-1008')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`servicesfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
		switch($id)
		{
	case '01-1015-01':
		$consdepartment = "IN('11')";
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
		$consdepartment = "IN('1')";
		break;
	case '01-1015-12':
		$consdepartment = "IN('12')";
		break;
	case '01-1015-13':
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
		$querycr1in = "SELECT SUM(a.`consultation`) as income FROM `billing_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.visitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(-1*a.`consultation`) as income FROM `refund_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(-1*a.`consultation`) as income FROM `refund_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
	
		$j = 0;
		$drresult1 = array();
				
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
	if($id=='01-1009')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`labitemrate`) as incomedebit FROM `refund_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				
		$querydr1in .= " UNION ALL SELECT SUM(`labfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
						UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`radiologyitemrate`) as incomedebit FROM `refund_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'";
		
		if($id == '01-1014-08')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`radiologyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	/* 
	*/
	if($id == '01-1001')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1024-IN')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Bed Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges')
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1019')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Nursing Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Nursing Charges')
		union all SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Nursing Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1020')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('RMO Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(-1*`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('RMO Charges')
		union all SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('RMO Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}

	if($id == '01-1008')
	{
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	
	}
	if($id == '01-1028-IN')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select sum(fxamount)as income from billing_paynowservices as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2' and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where parentid in ('62','63') or auto_number in ('62','63'))
		UNION ALL select sum(fxamount)as income from billing_paylaterservices as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2'  and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where  parentid in ('62','63') or auto_number in ('62','63'))
		UNION ALL select sum(servicesitemrateuhx)as income from billing_ipservices as a join master_services as b on (a.servicesitemcode = b.itemcode) join master_accountname as c on (b.ledgerid = c.id) join master_accountssub as d on (c.accountssub = d.auto_number) where a.wellnessitem <> '1' and a.billdate BETWEEN '$ADate1' AND '$ADate2'  and (d.parentid in ('62','63') or d.auto_number in ('62','63')) and b.`ledgerid` not in (SELECT id from master_accountssub where  parentid in ('62','63') or auto_number in ('62','63'))"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
	}
	if($id == '01-1022')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Accommodation Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1012')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		/* $querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Others')";
		
		$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
		while($resdr1 = mysql_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		} */
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
	}
	/* if($id == '01-1027-IN')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Accommodation Charges','Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review','Intensivist Review')"; 
		$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
		while($rescr1 = mysql_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
		
	} */
	//UNION ALL 
	if($id == '01-1018')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Intensivist Review')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		$balance = $balance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1002')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
		
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
		$balance = $balance + array_sum($crresult) - array_sum($drresult);
	}if($id == '01-1029-IN')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT SUM(`fxtotamount`) as income FROM `debtors_invoice` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".__LINE__.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
		$balance = $balance + array_sum($crresult) - array_sum($drresult);
	}	

		//$balance = $balance + $journal;			
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
					<tr <?php echo $colorcode; ?> style="display" id="<?php echo $lid; ?>">
					<td colspan="3" align="left" class="bodytext3"><strong><?= $id; ?>
					<a href="incomeledgerreport.php?group=<?= $parentid; ?>&&ledgerid=<?= $id; ?>&&ledgeranum=<?= $ledgeranum; ?>&&location=<?= $location; ?>&&ADate1=<?= $ADate1; ?>&&ADate2=<?= $ADate2; ?>&&ledger=<?= $accountsmain2; ?>&&cbfrmflag1=cbfrmflag1" target="_blank"><?php echo $colorloopcount; ?>. <?php echo $accountsmain2; ?></a></strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($balance,2,'.',','); ?></strong></td>
					</tr>
				<?php
			}
			
			
			
			
			
			?>
		   <!-- <tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total Opening Balance:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php //echo number_format($sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
				
				</tbody>
			<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="2" align="left" class="bodytext3" style="color:#000000"><strong>Total Ledger:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
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
