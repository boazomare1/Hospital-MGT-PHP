<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FullDebtorAnalysisDetailed.xls"');
header('Cache-Control: max-age=80');

//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = '';
$companyanum = '';
$companyname = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$totalamount = "0.00";
$totalamount30 = "0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total210 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount60 = "0.00";
$totalamount601 = "0.00";
$totalamount90 = "0.00";
$totalamount901 = "0.00";
$totalamount120 = "0.00";
$totalamount1201 = "0.00";
$totalamount180 = "0.00";
$totalamount1801 = "0.00";
$totalamount210 = "0.00";
$totalamount2101 = "0.00";
$totalamount240 = "0.00";
$totalamount2401 = "0.00";
$res21accountnameano='';
$closetotalamount1 = '0';
$closetotalamount301 = '0';
$closetotalamount601 = '0';
$closetotalamount901 = '0';
$closetotalamount1201 = '0';
$closetotalamount1801 = '0';
$closetotalamount2101 = '0';
$closetotalamount2401 = '0';
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");
// for Excel Export
if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
//$sno = $sno + 2;
//echo $companyname;
// for print page
if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchaccountnameanum1"])) {  $searchaccountnameanum1 = $_REQUEST["searchaccountnameanum1"]; } else { $searchaccountnameanum1 = ""; }
if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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

<body>
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%"  class="bodytext31">&nbsp;</td>
              <td colspan="14"  class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 			
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. No</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="22%" align="left" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
                <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Member No </strong></td>
                <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Org. Bill </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bal. Amt</strong></div></td>
				<td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>30 days</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days </strong></div></td>
			<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
			  </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
			$query513 = "select auto_number, paymenttype from master_paymenttype where paymenttype = '$type' and recordstatus <> 'deleted'";
			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res513 = mysqli_fetch_array($exec513);
			$type = $res513['paymenttype'];
			$typeanum = $res513['auto_number'];
			
			if($searchsubtypeanum1=='')
			{
				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and paymenttype = '$typeanum' and recordstatus <>'DELETED' group by subtype";
			}
			else if($searchsubtypeanum1!='')
			{
				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where paymenttype = '$typeanum' and subtype='$searchsubtypeanum1' and recordstatus <>'DELETED' group by subtype";
			}
//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 
			while($res2212 = mysqli_fetch_array($exec2212))
			{
			$subtypeanum = $res2212['subtype'];
			
			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysqli_fetch_array($query9);
			$subtype = $res9['subtype'];
			?>
			<tr bgcolor="#FFF">
            <td colspan="15"  align="left" valign="center" bgcolor="#FFF" class="bodytext31"><strong><?php echo $subtype; ?> </strong></td>
            </tr> 
			<?php
			if($searchaccountnameanum1=='' && $subtypeanum!='')
			{
				 $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum' and recordstatus <>'DELETED'";
			}
			else if($searchaccountnameanum1!='' && $subtypeanum!='')
			{
				 $query221 = "select accountname,auto_number,id from master_accountname where auto_number = '$searchaccountnameanum1' and subtype='$subtypeanum' and recordstatus <>'DELETED' ";
			}
			//echo $query221;
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec221); 
			while($res221 = mysqli_fetch_array($exec221))
			{
			$res22accountname = $res221['accountname'];
			$res21accountnameano=$res221['auto_number'];
			$res21accountname = $res221['accountname'];
			$res21accountid = $res221['id'];
			
		 	$querydebit1 = "select accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die ("Error in Querydebit1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numdebit1 = mysqli_num_rows($execdebit1);
					
			
			if( $res22accountname != '' && $numdebit1 > 0)
			{
			?>
			<tr >
            <td colspan="15"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname; ?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>) </strong></td>
            </tr> 
			
			<?php
			$openingbalance='0';
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
	$totaldebit=0;		
$debit=0;
$credit1=0;
$credit2=0;
$totalpayment=0;
$totalcredit='0';
$resamount=0;

			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		  
	  $queryunion="select groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'
	  union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$res21accountnameano'  and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'
	   union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount,docno,transactiontype from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'
	   
	    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
	   
	    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')
		
		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars,selecttype as transactionmode,'' as subtypeano,'' as chequenumber,transactionamount as fxamount, docno,vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$transactiontype = $res2['transactiontype'];
	if($transactiontype=='finalize')
			{
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				$res2transactionamount = $res2['fxamount']/$exchange_rate;
			
				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				$totalpayment = 0;
				
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1']/$exchange_rate;
				$totalpayment = $totalpayment + $payment;
				}
									
				$resamount = $res2transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 + $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 + $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 + $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 + $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 + $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater + $resamount;
						
					}
		 			
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
	
			?>
           <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>              
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
              
           </tr>
			<?php
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$total60=0;
			$totalamount60=0;
			$total90=0;
			$totalamount90=0;
			$total120=0;
			$totalamount120=0;
			$total180=0;
			$totalamount180=0;
			$total210=0;
			$totalamountgreater=0;

			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
			
			
			
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
}
	if($transactiontype=='JOURNAL')
			{
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				if($res2['subtype'] == 'Cr')
				{
			$query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr'";
				}
				else
				{
				$query7="SELECT  -1*`debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr'";
				}
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
				$res2transactionamount = $res7['fxamount']/$exchange_rate;				
				$resamount = $res2transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 + $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 + $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 + $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 + $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 + $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater + $resamount;
						
					}
		 			
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
	
			?>
           <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>              
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
              
           </tr>
			<?php
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$total60=0;
			$totalamount60=0;
			$total90=0;
			$totalamount90=0;
			$total120=0;
			$totalamount120=0;
			$total180=0;
			$totalamount180=0;
			$total210=0;
			$totalamountgreater=0;

			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
			
			
			
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
}
	if($transactiontype=='paylatercredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				
				$exchange_rate=1;
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res47 = mysqli_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($respaylatercreditpayment != 0)
				{
					
					
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respaylatercreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respaylatercreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respaylatercreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respaylatercreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respaylatercreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater + $respaylatercreditpayment;
					
					}
				$snocount = $snocount + 1;
			
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
		
				?>
			   <tr >
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $particulars; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($respaylatercreditpayment,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$totalamount1 = $totalamount1 - $res6transactionamount;
				$totalamount301 = $totalamount301 - $respaylatercreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res6transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respaylatercreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
				}
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
	if($transactiontype=='pharmacycredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				
				$exchange_rate=1;
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res47 = mysqli_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($respaylatercreditpayment != 0)
				{
					
					
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respaylatercreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respaylatercreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respaylatercreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respaylatercreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respaylatercreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater + $respaylatercreditpayment;
					
					}
				$snocount = $snocount + 1;
			
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
		
				?>
			   <tr >
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $particulars; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($respaylatercreditpayment,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$totalamount1 = $totalamount1 - $res6transactionamount;
				$totalamount301 = $totalamount301 - $respaylatercreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res6transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respaylatercreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
				}
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
	if($transactiontype=='PAYMENT')
		{
		$billnum=$res2['billnumber'];
$squery="select billnumber from master_transactionpaylater where accountnameano = '$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit') and billnumber='$billnum'";
$exequery=mysqli_query($GLOBALS["___mysqli_ston"], $squery);
$numquery=mysqli_num_rows($exequery);
			if($numquery>0)
			
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res2['groupdate'];
				$res3patientname = $res2['patientname'];
				$res3patientcode = $res2['patientcode'];
				$res3visitcode = $res2['visitcode'];
				$res3billnumber = $res2['billnumber'];
				$res3docno = $res2['auto_number'];
				$res3transactionmode = $res2['subtype'];
				$res3transactionnumber = $res2['accountname'];
				$particulars = $res2['particulars'];

				$exchange_rate=1;

			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	$query67 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where  docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res67 = mysqli_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1']/$exchange_rate;
					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
				}
				 
			 	 $resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
				
				if($resonaccountpayment != 0)
				{
				
				
				
				if($days_between <= 30)
				{
				
				$totalamount30 = $totalamount30 + $resonaccountpayment;
				
				}
				else if(($days_between >30) && ($days_between <=60))
				{
				
				$totalamount60 = $totalamount60 + $resonaccountpayment;
				
				}
				else if(($days_between >60) && ($days_between <=90))
				{
				
				$totalamount90 = $totalamount90 + $resonaccountpayment;
				
				}
				else if(($days_between >90) && ($days_between <=120))
				{
				
				$totalamount120 = $totalamount120 + $resonaccountpayment;
				
				}
				else if(($days_between >120) && ($days_between <=180))
				{
				
				$totalamount180 = $totalamount180 + $resonaccountpayment;
				
				}
				else
				{
				
				$totalamountgreater = $totalamountgreater + $resonaccountpayment;
				
				}
				$snocount = $snocount + 1;
			
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
		
				?>
			   <tr >
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res3docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $particulars; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php //echo number_format($res3transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format(abs($resonaccountpayment),2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				//$totalamount1 = $totalamount1 - $res3transactionamount;
				$totalamount301 = $totalamount301 - $resonaccountpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				//$closetotalamount1 = $closetotalamount1 - $res3transactionamount;
				$closetotalamount301 = $closetotalamount301 - $resonaccountpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
			}
			$res3transactionamount=0;
				$resonaccountpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
			}
			
			}
			}
			
		$closetotalamount1 =$closetotalamount1 +$openingbalance;
		$closetotalamount301=$closetotalamount301 + $openingbalance;
		
		$totalamount1 =$totalamount1+$openingbalance;
		$totalamount301=$totalamount301 + $openingbalance;
			?>
            <tr>
                <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                ><strong>Sub Total:</strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount1,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount301,2,'.',','); ?></strong></td>
                 <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount601,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount901,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount1201,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount1801,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount2101,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($closetotalamount2401,2,'.',','); ?></strong></td>        
            </tr>
            <?php
			$closetotalamount1 = '0';
			$closetotalamount301 = '0';
			$closetotalamount601 = '0';
			$closetotalamount901 = '0';
			$closetotalamount1201 = '0';
			$closetotalamount1801 = '0';
			$closetotalamount2101 = '0';
			$closetotalamount2401 = '0';
			
			
			
			}
			 



			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamount210=0;

		 }
		 }
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                ><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        
            </tr>
		
          </tbody>
        </table>
</body>
</html>
