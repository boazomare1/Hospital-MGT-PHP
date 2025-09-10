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

$sno=1;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Revenue Report Summary.xls"');
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
              <td align="center" colspan="3" bgcolor="#ffffff" class="bodytext31"><strong>Revenue Summary</strong></td>  
            </tr>
			<tr>
              <td align="center" colspan="3" bgcolor="#ffffff" class="bodytext31"><strong>Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>  
            </tr>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Revenue </strong></td>
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
		 	if($type != '')
			{
			$query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";
			}
			else
			{
			$query513 = "select auto_number, paymenttype from master_paymenttype where paymenttype <> 'cash' and recordstatus <> 'deleted'";
			}
			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res513 = mysqli_fetch_array($exec513))
			{
			$type = $res513['paymenttype'];
			$typeanum = $res513['auto_number'];
			?>
			<tr bgcolor="#CCC">
            <td colspan="3" align="left" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo $type; ?> </strong></td>
            </tr>
			<tr>
			<td colspan="3"></td>
			</tr> 
			<?php
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
			$sno=1;
			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysqli_fetch_array($query9);
			$subtype = $res9['subtype'];
			?>
			<tr >
            <td colspan="3"  align="left" valign="center" bgcolor="#FFF" class="bodytext31"><strong><?php echo $subtype; ?> </strong></td>
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
		  
		  $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' order by auto_number desc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				
				$res2transactionamount = $res2['fxamount']/$exchange_rate;
			
				$totalpayment = 0;
				
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res2transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					
		 			
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				
}

 $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,transactionamount as fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano'  and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%' order by auto_number desc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				
				$res2transactionamount = $res2['fxamount']/$exchange_rate;
			
				$totalpayment = 0;
				
				
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res2transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					
		 			
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				
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
								
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res3transactionamount = $res3transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res3transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					
			$totalamount1 = $totalamount1 - $res3transactionamount;
			$totalamount301 = $totalamount301 - $resamount;
			
			$closetotalamount1 = $closetotalamount1 - $res3transactionamount;
			$closetotalamount301 = $closetotalamount301 - $resamount;
			
			$res3transactionamount=0;
			$resamount=0;
			}
			$res3transactionamount=0;
			$resamount=0;
			
			
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				
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
						
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				$res4transactionamount = $res4transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res4transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					
			$totalamount1 = $totalamount1 - $res4transactionamount;
			$totalamount301 = $totalamount301 - $resamount;
			
			$closetotalamount1 = $closetotalamount1 - $res4transactionamount;
			$closetotalamount301 = $closetotalamount301 - $resamount;
			
			$res4transactionamount=0;
			$resamount=0;
			}
			$res4transactionamount=0;
			$resamount=0;
			
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				
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
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
	
			?>
           
           <tr <?php echo $colorcode; ?>>
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>
           <td class="bodytext31" valign="center"  align="left"><?php echo $res22accountname; ?></td>
           <td class="bodytext31" valign="center"  align="right"><?php echo number_format($closetotalamount301,2,'.',','); ?></td>
            </tr>
            <?php
			$closetotalamount1 = '0';
			$closetotalamount301 = '0';
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
			<tr onClick="showsub(<?=$subtypeanum?>)">
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#FFF"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFF"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
            </tr>
			<tr>
			<?php
			$grandtotalamount1 += $totalamount1;
$grandtotalamount301 += $totalamount301;
			$totalamount1 = "0.00";
			$totalamount301 = "0.00";
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$type&&searchsubtypeanum1=$searchsubtypeanum1";	
				
			?>
			 <td colspan="32ytext31" valign="center"  align="right"></td>
			</tr>     
			   <?php
			   }}}
			   ?>
			   <tr >
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#FFF"><strong>Grand Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFF"><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>
            </tr>
          </tbody>
</table>
</body>
</html>
