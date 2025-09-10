<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

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
$totalamount = "0.00";
$totalamount30 = "0.00";
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$total30="0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total240 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount601 = "0.00";
$totalamount901 = "0.00";
$totalamount1201 = "0.00";
$totalamount1801 = "0.00";
$totalamount2101 = "0.00";

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

$total301='0';
$total601='0';
$total901='0';
$total1201='0';
$total1801='0';
$total2401='0';

$total3012='0';
$total6012='0';
$total9012='0';
$total12012='0';
$total18012='0';
$total24012='0';

$total3013='0';
$total6013='0';
$total9013='0';
$total12013='0';
$total18013='0';
$total24013='0';

$sno=1;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FullDebtorAnalysisSummary.xls"');
header('Cache-Control: max-age=80');

// for Excel Export
if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
//$sno = $sno + 2;
if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchaccountnameanum1"])) {  $searchaccountnameanum1 = $_REQUEST["searchaccountnameanum1"]; } else { $searchaccountnameanum1 = ""; }

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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1101" 
            align="left" border="1">
          <tbody>
            <tr>
              <td align="center" colspan="9" bgcolor="#ffffff" class="bodytext31"><strong>Full Debtor Analysis Summary</strong></td>  
            </tr>
			<tr>
              <td align="center" colspan="9" bgcolor="#ffffff" class="bodytext31"><strong>Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
            </tr>
			
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
			$searchsuppliername = trim($searchsuppliername);
		 
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
            <td colspan="9"  align="left" valign="center" bgcolor="#FFF" class="bodytext31"><strong><?php echo $subtype; ?> </strong></td>
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
	
		
			if( $res22accountname != '' && $numdebit1>0)
			{
			
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

				$query2 = "select transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars,auto_number,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate < '$ADate1'  and transactiontype = 'finalize' order by accountname desc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res2 = mysqli_fetch_array($exec2))
				{
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2transactionamount = $res2['transactionamount'];
				$res2patientcode = $res2['patientcode'];
				$anum = $res2['auto_number'];
				
				$totalpayment=0;
				$resamount=0;
				$query98 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1'];
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount=0;
				$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysqli_fetch_array($exec7))
				{
					$res7sumtransactionamount += $res7['sumtransactionamount'];
				}
				
				$res8sumtransactionamount=0;
				$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate > '$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysqli_fetch_array($exec8))
				{
					$res8sumtransactionamount += $res8['sumtransactionamount'];
				}
				
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				$resamount = $res2transactionamount - $totalpayment;
			
				$credit1=0;
				$query5 = "select visitcode,docno,transactionamount,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res5 = mysqli_fetch_array($exec5))
				{
					$totalpharmacreditpayment = 0;
					
					$res5visitcode = $res5['visitcode'];
					$res5docno = $res5['docno'];
					$res5transactionamount = $res5['transactionamount'];
					
					$totalpharmacreditpayment=0;
					$query77 = "select sum(transactionamount) as pharmamount from master_transactionpaylater where docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
					$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res77 = mysqli_fetch_array($exec77))
					{
					$pharmacreditpayment = $res77['pharmamount'];
					
					$totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
					}
					
					$respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
					
				$credit1 +=$respharmacreditpayment;
				}
				
				$credit2=0;
				$query6 = "select visitcode,transactionamount,docno,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate>'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res6 = mysqli_fetch_array($exec6))
				{
					$totalpaylatercreditpayment = 0;
					$res6visitcode = $res6['visitcode'];
					$res6transactionamount = $res6['transactionamount'];
					$res6docno = $res6['docno'];
					
					$totalpaylatercreditpayment=0;
					$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
					$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res47 = mysqli_fetch_array($exec47))
					{
						$paylatercreditpayment = $res47['transactionamount1'];					
						$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
					}
					
					$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
					$credit2 +=$respaylatercreditpayment;
				}
				
				$totaldebit +=$resamount -$credit1-$credit2;		
}
$credit3='0';
$query3 = "select docno,transactionamount,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate < '$ADate1' and transactionstatus in ( 'onaccount','paylatercredit') order by accountname desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo $num3 = mysql_num_rows($exec3);
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$res3transactionamount = $res3['transactionamount'];
				$res3docno = $res3['docno'];
			 	
				$totalonaccountpayment = 0;
			 	$query67 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res67 = mysqli_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1'];
					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
				}
				 
				$resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
				$credit3 +=$resonaccountpayment;
			
			} 
			
	$credit4='0';
$query6 = "select docno,transactionamount,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate < '$ADate1'  and transactiontype = 'paylatercredit' and patientname='' order by transactiondate desc";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $num = mysql_num_rows($exec3);
			while ($res6 = mysqli_fetch_array($exec6))
			{
				
			
				$res6transactionamount = $res6['transactionamount'];
			
				$res6docno = $res6['docno'];
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res47 = mysqli_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1'];
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
			$credit4 +=$respaylatercreditpayment;	
				
			}
	$openingbalance = $totaldebit -$credit3 -$credit4;	
	$openingbalance = 0;
			}
			
				
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		  
		  $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number,fxamount from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' order by accountname desc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res2['transactiondate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				$subtype_ano='';
				$subtype_ano=$res2['subtypeano'];
				$querya1="select subtype from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}
				$querya1="select subtype from master_ipvisitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}						

		$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subtype_ano'");
			if($execsubtype=mysqli_fetch_array($querysubtype)){
				$currency=$execsubtype['currency'];
				$exchange_rate=$execsubtype['fxrate'];
			}
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
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				if(substr($res2billnumber,0,4)!="IPDr"){

			 	$query7 = "select sum(fxamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and auto_number < '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysqli_fetch_array($exec7))
				{
					 $res7sumtransactionamount += $res7['sumtransactionamount']/$exchange_rate;
				}
				$query8 = "select sum(fxamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and transactiondate < '$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysqli_fetch_array($exec8))
				{
					$res8sumtransactionamount += $res8['sumtransactionamount']/$exchange_rate;
				}
				}
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
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
			$query6 = "select transactiondate,patientname,patientcode,visitcode,billnumber,fxamount,transactionmode,docno,particulars,fxamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and paymenttype like '%$type%' and auto_number>'$anum' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res6 = mysqli_fetch_array($exec6))
				{
					$respaylatercreditpayment=0;
					$res6transactiondate = $res6['transactiondate'];
					$res6patientname = $res6['patientname'];
					$res6patientcode = $res6['patientcode'];
					$res6visitcode = $res6['visitcode'];
					$res6billnumber = $res6['billnumber'];
					$res6transactionamount = $res6['fxamount']/$exchange_rate;
					$res6transactionmode = $res6['transactionmode'];
					$res6docno = $res6['docno'];
					$particulars = $res6['particulars'];
					
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
					$query56 = "select billno from billing_paylater where visitcode='$res6visitcode'";
					$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res56 = mysqli_fetch_array($exec56);
					$billnos = $res56['billno'];
					
					$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
					$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num57 = mysqli_num_rows($exec57);
					
					if($num57 != 0)
					{
					$lab = "Lab";
					}
					else
					{
					$lab = "";
					}
					
					$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
					$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num58 = mysqli_num_rows($exec58);
					
					if($num58 != 0)
					{
					$rad = "Rad";
					}
					else
					{
					$rad = "";
					}
					
					$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
					$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num59 = mysqli_num_rows($exec59);
					
					if($num59 != 0)
					{
					$ser = "Services";
					}
					else
					{
					$ser = "";
					}
					
					$t1 = strtotime("$ADate2");
					$t2 = strtotime("$res6transactiondate");
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					
					
					
					
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
			
			$query5 = "select transactiondate,patientname,patientcode,visitcode,docno,particulars,billnumber,fxamount,transactionmode,fxamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' and paymenttype like '%$type%' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $num = mysql_num_rows($exec3);
				while ($res5 = mysqli_fetch_array($exec5))
				{
					$respharmacreditpayment=0;
					
					$res5transactiondate = $res5['transactiondate'];
					$res5patientname = $res5['patientname'];
					$res5patientcode = $res5['patientcode'];
					$res5visitcode = $res5['visitcode'];
					$res5docno = $res5['docno'];
					$particulars = $res5['particulars'];
					
					$query78 = "select billno from billing_paylater where visitcode='$res5visitcode'";
					$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78);
					$res78 = mysqli_fetch_array($exec78);
					$finalizedbillno = $res78['billno'];
					$res5billnumber = $res5['billnumber'];
					$res5transactionamount = $res5['fxamount']/$exchange_rate;
					$res5transactionmode = $res5['transactionmode'];
					
					
					$t1 = strtotime("$ADate2");
					$t2 = strtotime("$res5transactiondate");
					$days_between = ceil(abs($t1 - $t2) / 86400);
					$totalpharmacreditpayment = 0;
					$totalpharmacreditpayment=0;
					$query77 = "select fxamount from master_transactionpaylater where docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
					$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res77 = mysqli_fetch_array($exec77))
					{
					$pharmacreditpayment = $res77['fxamount']/$exchange_rate;
					
					$totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
					}
					
					$respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
					
					if($respharmacreditpayment != 0)
					{
				
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respharmacreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respharmacreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respharmacreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respharmacreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respharmacreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater - $respharmacreditpayment;
					
					}
				
				$snocount = $snocount + 1;
				
				$totalamount1 = $totalamount1 - $res5transactionamount;
				$totalamount301 = $totalamount301 - $respharmacreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res5transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respharmacreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				
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
				$totalamountgreater=0;}
		
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
			
			
			$querycredit4 = "select subtypeano,fxamount,docno,transactiondate,particulars,transactionmode,patientname,patientcode,visitcode,billnumber,fxamount from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and patientname = ''  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'";
			$execcredit4 = mysqli_query($GLOBALS["___mysqli_ston"], $querycredit4) or die ("Error in Querycredit4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res6 = mysqli_fetch_array($execcredit4))
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res6['transactiondate'];
				$res6patientname = $res6['patientname'];
				$res6patientcode = $res6['patientcode'];
				$res6visitcode = $res6['visitcode'];
				$res6billnumber = $res6['billnumber'];
				$res6transactionmode = $res6['transactionmode'];
				$res6docno = $res6['docno'];
				$particulars = $res6['particulars'];
				
				$exchange_rate=1;
				$subtype_ano='';
				$subtype_ano=$res6['subtypeano'];
				$querya1="select subtype from master_visitentry where visitcode='$res6visitcode' and patientcode='$res6patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}
				$querya1="select subtype from master_ipvisitentry where visitcode='$res6visitcode' and patientcode='$res6patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}						

		$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subtype_ano'");
			if($execsubtype=mysqli_fetch_array($querysubtype)){
				$currency=$execsubtype['currency'];
				$exchange_rate=$execsubtype['fxrate'];
			}

				$res6transactionamount = $res6['fxamount']/$exchange_rate;
								
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
			
		
			
			    $query3 = "select subtypeano,transactiondate,patientname,patientcode,visitcode,billnumber,docno,fxamount,transactionmode,chequenumber,particulars,fxamount from master_transactionpaylater where accountnameano = '$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')  order by accountname desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo $num3 = mysql_num_rows($exec3);
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res3['transactiondate'];
				$res3patientname = $res3['patientname'];
				$res3patientcode = $res3['patientcode'];
				$res3visitcode = $res3['visitcode'];
				$res3billnumber = $res3['billnumber'];
				$res3docno = $res3['docno'];
				$res3transactionmode = $res3['transactionmode'];
				$res3transactionnumber = $res3['chequenumber'];
				$particulars = $res3['particulars'];

				$exchange_rate=1;
				$subtype_ano='';
				$subtype_ano=$res3['subtypeano'];
				$querya1="select subtype from master_visitentry where visitcode='$res3visitcode' and patientcode='$res3patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}
				$querya1="select subtype from master_ipvisitentry where visitcode='$res3visitcode' and patientcode='$res3patientcode' ";
				$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if ($resa1 = mysqli_fetch_array($execa1))
				{
					$subtype_ano=$resa1['subtype'];
				}						

			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subtype_ano'");
			if($execsubtype=mysqli_fetch_array($querysubtype)){
				$currency=$execsubtype['currency'];
				$exchange_rate=$execsubtype['fxrate'];
			}

			 	$res3transactionamount = $res3['fxamount']/$exchange_rate;
				
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
			
		$closetotalamount1 =$closetotalamount1 +$openingbalance;
		$closetotalamount301=$closetotalamount301 + $openingbalance;
		
		$totalamount1 =$totalamount1+$openingbalance;
		$totalamount301=$totalamount301 + $openingbalance;
			?>
           
           <tr>
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++?></td>
                <td class="bodytext31" valign="center"  align="left" 
                ><?php echo $res22accountname; ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount301,2,'.',','); ?></td>
                 <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount601,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount901,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount1201,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount1801,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount2101,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount2401,2,'.',','); ?></td>        
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
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#fff"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        
            </tr>
			<?php
			   }
			   ?>
          </tbody>
</table>
</body>
</html>
