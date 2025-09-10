<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = "";

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
	if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
	$locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	$sumcashamount = $sumcardamount = $sumchequeamount = $sumonlineamount = $summpesaamount = $sumtotalamount = $sumfcb02amount = $sumfcb01amount = $sumfcb04amount = $sumnicamount = $sumcashexpenditure = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="print_cashflowsummaryexl.xls"');
header('Cache-Control: max-age=80');

?>
<style><!--
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 10px;padding: 2px;}
table{table-layout:fixed;
width:95%;
display:table;
border-collapse:collapse;} -->

</style>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height:150px; }
#footer .page:after { content: counter(page, upper-roman); }
td{{height: 30px;padding: 2px;}
.page { page-break-after:always; }
</style>

				<?php
				$totalamount = '0.00'; $snocount = 0;
				if($cbfrmflag1 == 'cbfrmflag1')
				{	


			$monthcash= 0; $bforward=0;$banked=0;$expensed=0; $cashamount1=0;$e_amount=0;
			function getOP($locationcode1,$date){
				$sumcashamount = $sumcardamount = $sumchequeamount = $sumonlineamount = $summpesaamount = $sumtotalamount = $sumfcb02amount = $sumfcb01amount = $sumfcb04amount = $sumnicamount = $sumcashexpenditure = 0;
						  $query2 = "select transactiondate, sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  
     	  $res2cashamount1 = $res2['cashamount1'];
		  $res2onlineamount1 = $res2['onlineamount1'];
		  $res2creditamount1 = $res2['creditamount1'];
		  $res2chequeamount1 = $res2['chequeamount1'];
		  $res2cardamount1 = $res2['cardamount1'];
		  
		   
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode1' and DATE(billingdatetime) < '$date'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where locationcode='$locationcode1' and  DATE(recorddate) < '$date'"; 
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res54 = mysqli_fetch_array($exec54))
{

		
			  $res54cashamount1 = $res54['cashamount1'];
		  $res54onlineamount1 = $res54['onlineamount1'];
		  $res54creditamount1 = $res54['creditamount1'];
		  $res54chequeamount1 = $res54['chequeamount1'];
		  $res54cardamount1 = $res54['cardamount1'];
			

			
			}  //refund adv
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];

		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode1' and transactiondate < '$date'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
 $query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount+mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where locationcode='$locationcode1' and docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate < '$date'"; 
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  
     	   $res11cashamount1 = $res11['cashamount1'];
		  $res11onlineamount1 = $res11['onlineamount1'];
		  $res11creditamount1 = $res11['creditamount1'];
		  $res11chequeamount1 = $res11['chequeamount1'];
		  $res11cardamount1 = $res11['cardamount1'];

		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;

		  $sumcashamount += $cashamount1;
		  $sumcardamount += $cardamount1;
		  $sumchequeamount += $chequeamount1;
		  $sumonlineamount += $onlineamount1;
		  $summpesaamount += $creditamount1;
		  $sumtotalamount += $total; 

 			$banked = 0;$monthcash =0;$expensed=0;

				$query540 = "select bankcode  from master_bank"; 
				  $exec540 = mysqli_query($GLOBALS["___mysqli_ston"], $query540) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res540 = mysqli_fetch_array($exec540))
				  { 
				  	 $bankcode = $res540['bankcode'];
					 $query110 = "select sum(amount) as cashamount from bankentryform where transactiontype='DEPOSIT' and tobankid = '$bankcode' and transactiondate < '$date'"; 
					  $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res110 = mysqli_fetch_array($exec110);
					  $_amount = $res110['cashamount'];

				  
					  $banked +=$_amount;
					} 

					 $query111 = "select sum(cashamount) as amount from expensesub_details where bankcode = '07-7701' and transactiondate < '$date'"; 
					  $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res111 = mysqli_fetch_array($exec111);
					  $e_amount = $res111['amount'];

				$monthcash += $cashamount1;
				$expensed +=$e_amount;

				return $monthcash-$banked-$expensed;
			}
				?>	
	<table width="600" border="0" align="center" cellpadding="0" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<thead>
			<tr >
				<td colspan="12" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td colspan="12" align="center" class="bodytext3" ><strong>Cash Flow Summary</strong></td>
			</tr>
			<tr >
				<td colspan="12" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td colspan="12" align="left" class="bodytext3" ><strong>ORAGANISATION : <?php echo $companyname; ?></strong></td>
			</tr>
			<tr >
				<td colspan="12"  align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td colspan="6" align="left" class="bodytext3" ><strong>From :  <?php echo $transactiondatefrom; ?> - To :  <?php echo $transactiondateto; ?></strong></td>
				<td colspan="6"align="right" class="bodytext3" ><strong>REPORT DATE : <?php echo date('d/m/Y'); ?> </strong></td>
			</tr>
				
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>BALANCE B/F<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php 
                if($cbfrmflag1 == 'cbfrmflag1'){$bforward = getOP($locationcode1, $transactiondatefrom);}

                echo number_format($bforward,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" width="5%" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
              <td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Date</strong></div></td>
              <td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cash</strong></div></td>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Card</strong></div></td>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cheque</strong></div></td>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Online</strong></div></td>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>MPESA</strong></div></td>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
                          
             	<?php 
				$query540 = "select bankname from master_bank"; 
				  $exec540 = mysqli_query($GLOBALS["___mysqli_ston"], $query540) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res540 = mysqli_fetch_array($exec540))
				  { ?>
						<td align="left" valign="left"  
						bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $res540['bankname']; ?></strong></div></td>
				 <?php } ?>
				<td align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Expenditure</strong></div></td>
            
            </tr>
		</thead>
		
		<tbody>
			<?php
			
			
			$date = $transactiondatefrom;
			while (strtotime($date) <= strtotime($transactiondateto)) {

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		    
		  $query2 = "select transactiondate, sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  
     	  $res2cashamount1 = $res2['cashamount1'];
		  $res2onlineamount1 = $res2['onlineamount1'];
		  $res2creditamount1 = $res2['creditamount1'];
		  $res2chequeamount1 = $res2['chequeamount1'];
		  $res2cardamount1 = $res2['cardamount1'];
		  
		   
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode1' and DATE(billingdatetime) = '$date'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where locationcode='$locationcode1' and  DATE(recorddate) = '$date'"; 
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res54 = mysqli_fetch_array($exec54))
{

		
			  $res54cashamount1 = $res54['cashamount1'];
		  $res54onlineamount1 = $res54['onlineamount1'];
		  $res54creditamount1 = $res54['creditamount1'];
		  $res54chequeamount1 = $res54['chequeamount1'];
		  $res54cardamount1 = $res54['cardamount1'];
			

			
			}  //refund adv
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];

		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode1' and transactiondate = '$date'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
 $query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount+mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where locationcode='$locationcode1' and docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate = '$date'"; 
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  
     	   $res11cashamount1 = $res11['cashamount1'];
		  $res11onlineamount1 = $res11['onlineamount1'];
		  $res11creditamount1 = $res11['creditamount1'];
		  $res11chequeamount1 = $res11['chequeamount1'];
		  $res11cardamount1 = $res11['cardamount1'];

		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;

		  $sumcashamount += $cashamount1;
		  $sumcardamount += $cardamount1;
		  $sumchequeamount += $chequeamount1;
		  $sumonlineamount += $onlineamount1;
		  $summpesaamount += $creditamount1;
		  $sumtotalamount += $total; 
		  
		  $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $date; ?></div>  </td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($cashamount1,2,'.',','); ?></div>  </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($cardamount1,2,'.',','); ?></div>  </td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>               
             	<?php $query540 = "select bankcode from master_bank"; 
				  $exec540 = mysqli_query($GLOBALS["___mysqli_ston"], $query540) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res540 = mysqli_fetch_array($exec540))
				  { 
				  	 $bankcode = $res540['bankcode'];
					 $query110 = "select sum(amount) as cashamount from bankentryform where transactiontype='DEPOSIT' and tobankid = '$bankcode' and transactiondate = '$date'"; 
					  $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res110 = mysqli_fetch_array($exec110);
					  $_amount = $res110['cashamount'];

					  if($bankcode == '07-7602'){ $sumfcb02amount += $_amount; }
					  else if($bankcode == '07-7601'){ $sumfcb01amount += $_amount; }
					  else if($bankcode == '07-7603'){ $sumfcb04amount += $_amount; }
					  else if($bankcode == '07-7604'){ $sumnicamount += $_amount; }

				?>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($_amount,2,'.',','); ?></div></td>
				 <?php  $banked +=$_amount;} ?>
             	<?php 
					 $query111 = "select sum(transactionamount) as amount from expensesub_details where bankcode = '02-6000-9' and transactiondate = '$date'"; 
					  $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res111 = mysqli_fetch_array($exec111);
					  $e_amount = $res111['amount'];
					  $sumcashexpenditure += $e_amount;
				  
				  ?>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($e_amount,2,'.',','); ?></div></td>
           </tr>
			<?php
				}
				$monthcash += $cashamount1;
				$expensed +=$e_amount;
			    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			}

			?>
			<tr>
				<td colspan="2" class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong>TOTAL</strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumcashamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumcardamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumchequeamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumonlineamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($summpesaamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumtotalamount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumfcb02amount,2,'.',','); ?></strong></td>
				<!--<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumfcb01amount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumfcb04amount,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumnicamount,2,'.',','); ?></strong></td>-->
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($sumcashexpenditure,2,'.',','); ?></strong></td>
               
            </tr>
            <tr>
				<td colspan="13" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>CASH FOR THE MONTH<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php echo  number_format($monthcash,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>TOTAL CASH<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php echo number_format($bforward+$monthcash,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="13" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>BANKED<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php echo number_format($banked,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>CASH EXPENSED<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php echo number_format($expensed,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>BALANCE<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b><?php echo number_format($bforward+$monthcash-$banked-$expensed,2,'.',','); ?></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>CASH AT HAND<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            <tr>
				<td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>EXCESS / DEFICIT<b></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b></b></td>
				<td colspan="7" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
            
            <tr>
				<td colspan="13" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr>
				
			
		</tbody>
	</table>
				<?php
				}
				?>
