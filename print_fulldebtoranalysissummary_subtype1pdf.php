<?php
session_start();
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
ob_start();
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

$grandtotalamount1 = "0.00";
$grandtotalamount301 = "0.00";
$grandtotalamount601 = "0.00";
$grandtotalamount901 = "0.00";
$grandtotalamount1201 = "0.00";
$grandtotalamount1801 = "0.00";
$grandtotalamount2101 = "0.00";
$grandtotalamount2401 = "0.00";

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

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$resfaxnumber1 = $res1['faxnumber1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$phonenumber1 = $res1['phonenumber1'];
$locationname = $res1['locationname'];
$locationcode = $res1['locationcode'];

//include ("autocompletebuild_account3.php");

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }


if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C;
}
-->
</style>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; text-decoration:none
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
<?php  include("print_header1.php"); ?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="center" border="1">
          
            <tr>
              <td colspan="9"  class="bodytext31">
             <strong>Full Debtor Analysis Subtype Summary - <?= $type?></strong></td>
            </tr>
            <tr>
              <td width="20" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="210" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="80" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>
              <td width="80" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>
              <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>
				<td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>
              <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
            </tr>
			
			
			<?php
			
			
				
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
			$searchsuppliername = trim($searchsuppliername);

			$selectedType=$type;
			if($type!='') {
				$paymentTypes = array($type);
			}
			else{
			  $query51 = "select auto_number from master_paymenttype where recordstatus <> 'deleted' and paymenttype!='CASH'";
			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $j=0;
			  while($res51 = mysqli_fetch_array($exec51))
			  {
				$paymentTypes[$j]=$res51['auto_number'];
				$j=$j+1;
				
			  }

			}

            foreach ($paymentTypes as $k=>$v) {

			$type = $v;
		 
			$query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";
			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res513 = mysqli_fetch_array($exec513);
			$type = $res513['paymenttype'];
			$typeanum = $res513['auto_number'];
			
			if($searchsubtypeanum1=='')
			{
			 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and recordstatus <>'DELETED' group by subtype";
			}
			else if($searchsubtypeanum1!='')
			{
				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype='$searchsubtypeanum1' and recordstatus <>'DELETED' group by subtype";
			}
			//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 
			while($res2212 = mysqli_fetch_array($exec2212))
			{
			$subtypeanum = $res2212['subtype'];
			$sno=1;
			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysqli_fetch_array($query9);
			$subtype = $res9['subtype'];
			?>
			<tr bgcolor="#FFF">
            <td colspan="9"  align="left" valign="center" bgcolor="#FFF" class="bodytext31"><strong><?php echo $subtype; ?> </strong></td>
            </tr> 
			
			<?php
			if( $subtypeanum!='')
			{
				 $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum' and recordstatus <>'DELETED'";
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
			
		 	$querydebit1 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die ("Error in Querydebit1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numdebit1 = mysqli_num_rows($execdebit1);
					
			//echo $cashamount;
			
		
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

			
				
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		  
	 $query1 = "select a.transactiondate as transactiondate,b.billbalanceamount as billamount from master_transactionpaylater as a join master_transactionpaylater as b on (a.billnumber = b.billnumber and a.visitcode = b.visitcode and a.transactiontype like 'finalize') where a.accountnameano='$res21accountnameano' and  a.accountnameid='$res21accountid' and a.transactiondate between '$ADate1' and '$ADate2' and b.acc_flag='0'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res2['transactiondate'];				
				$res2transactionamount = $res2['billamount'];
				
				$resamount = $res2transactionamount ;
				
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
$query2 = "SELECT b.`docno` as docno, b.`transactionamount` as fxamount, b.`transactiondate` as transactiondate  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec2))
		  {
		 		$resamount=0;
				$res3transactionamount=0;
				
				$res3transactiondate = $res3['transactiondate'];
				$res3docno = $res3['docno'];
				$exchange_rate=1;
				
				 $res3transactionamount = $res3['fxamount']/$exchange_rate;
			
				$totalpayment = 0;
				$query98 = "select sum(transactionamount) as pharmamount from master_transactionpaylater where docno='$res3docno' and transactiontype like 'pharmacycredit' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['pharmamount']/$exchange_rate;
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res3transactionamount = $res3transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res3transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res3transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 - $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 - $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 - $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 - $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 - $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater - $resamount;
						
					}
		 			
			$totalamount1 = $totalamount1 - $res3transactionamount;
			$totalamount301 = $totalamount301 - $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 - $res3transactionamount;
			$closetotalamount301 = $closetotalamount301 - $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res3transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res3transactionamount=0;
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
 $query3 = "SELECT `docno` as docno, `fxamount` as fxamount, `transactiondate` as transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'";
 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec3))
		  {
		 		$resamount=0;
				$res4transactionamount=0;
				
				$res4transactiondate = $res4['transactiondate'];
				$res4docno = $res4['docno'];
				$exchange_rate=1;
				
				 $res4transactionamount = $res4['fxamount']/$exchange_rate;
			
				$totalpayment = 0;
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res4docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1']/$exchange_rate;
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res4transactionamount = $res4transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res4transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res4transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 - $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 - $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 - $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 - $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 - $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater - $resamount;
						
					}
		 			
			$totalamount1 = $totalamount1 - $res4transactionamount;
			$totalamount301 = $totalamount301 - $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 - $res4transactionamount;
			$closetotalamount301 = $closetotalamount301 - $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res4transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res4transactionamount=0;
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

$query4 = "SELECT `docno` as docno, `fxamount` as fxamount, `transactiondate` as transactiondate  FROM `master_transactionpaylater` WHERE accountnameid='$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'";
 $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec4))
		  {
		 		$resamount=0;
				$res5transactionamount=0;
				
				$res5transactiondate = $res5['transactiondate'];
				$res5docno = $res5['docno'];
				$exchange_rate=1;
				
				 $res5transactionamount = $res5['fxamount']/$exchange_rate;
			
				$totalpayment = 0;
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res5docno' and transactiontype like 'PAYMENT' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1']/$exchange_rate;
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res5transactionamount = $res5transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res5transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res5transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 - $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 - $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 - $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 - $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 - $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater - $resamount;
						
					}
		 			
			$totalamount1 = $totalamount1 - $res5transactionamount;
			$totalamount301 = $totalamount301 - $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 - $res5transactionamount;
			$closetotalamount301 = $closetotalamount301 - $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res5transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res5transactionamount=0;
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
$query5 = "SELECT `docno` as docno, `transactionamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
 $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res6 = mysqli_fetch_array($exec5))
		  {
		 		$resamount=0;
				$res6transactionamount=0;
				
				$res6transactiondate = $res6['transactiondate'];
				$res6docno = $res6['docno'];
				$exchange_rate=1;
				
				
			
				$totalpayment = 0;
				if($res6['type'] == 'Cr')
				{
			$query="SELECT `docno` as docno, -1*`creditamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res6docno' and selecttype = 'Cr'";
				}
				else
				{
				$query="SELECT `docno` as docno, -1*`debitamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res6docno' and selecttype = 'Dr'";
				}
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res = mysqli_fetch_array($exec);
		   $res6transactionamount = $res['fxamount']/$exchange_rate;
				$resamount = $res6transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res6transactiondate);
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
		 			
			$totalamount1 = $totalamount1 + $res6transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 + $res6transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res6transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res6transactionamount=0;
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
			
			
				$res6transactionamount=0;
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
		
		$closetotalamount1 =$closetotalamount1 +$openingbalance;
		$closetotalamount301=$closetotalamount301 + $openingbalance;
		
		$totalamount1 =$totalamount1+$openingbalance;
		$totalamount301=$totalamount301 + $openingbalance;
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
           
           <tr>
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>
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
			$grandtotalamount1 += $totalamount1;
$grandtotalamount301 += $totalamount301;
$grandtotalamount601 += $totalamount601;
$grandtotalamount901 += $totalamount901;
$grandtotalamount1201 += $totalamount1201;
$grandtotalamount1801 += $totalamount1801;
$grandtotalamount2101 += $totalamount2101;
$grandtotalamount2401 += $totalamount2401;
			$totalamount1 = "0.00";
			$totalamount301 = "0.00";
			$totalamount601 = "0.00";
			$totalamount901 = "0.00";
			$totalamount1201 = "0.00";
			$totalamount1801 = "0.00";
			$totalamount2101 = "0.00";
			$totalamount2401 = "0.00";
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$type&&searchsubtypeanum1=$searchsubtypeanum1";	
				
			?>
			    
			   <?php
			   }
			}
			   ?>
			   <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#fff"><strong>Grand Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount601,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount901,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount1201,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount1801,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount2101,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"><strong><?php echo number_format($grandtotalamount2401,2,'.',','); ?></strong></td>        
            </tr>
          
        </table>			
<?php
require_once('html2pdf/html2pdf.class.php');

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_fulldebtor.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>