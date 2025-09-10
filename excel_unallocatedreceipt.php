<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$accountname = '';

$amount = 0;



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Unallocated_receipts.xls"');

header('Cache-Control: max-age=80');





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			



?>

<style type="text/css">

<!--



.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>



<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>



</head>



<body>
<?php 
if ($cbfrmflag1 == 'cbfrmflag1')

{
?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666" cellspacing="0" cellpadding="4" width="100%" 

            align="left" border="1">

         



		 <tr> <td colspan="9" align="center"><strong><u><h3>Unallocated Receipts</h3></u></strong></td></tr>


   		<tbody>

           

           <tr>

              <td width="3%"  align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="7%" align="left" valign="left"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>

              <td width="8%" align="left" valign="left"     bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>

              <td width="7%" align="left" valign="center"      bgcolor="#ffffff" class="style1">Doc Date</td>

              <td width="15%" align="left" valign="left"     bgcolor="#ffffff" class="style1"><div align="left"><strong>Mode</strong></div></td>

              <td width="8%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>

                <td width="19%" align="left" valign="center"     bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>

                <td width="6%" align="left" valign="center"        bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Adj Amount</strong></div></td>

                <td width="6%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Balance</strong></div></td>


            </tr>

            <?php

			$colorloopcount = '';

			$sno = '';

			$totaltransactionamount = 0;

			$totaladjustedamount = 0;

			$totalbalance = 0;

			

			$query1 = "select * from master_transactionpaylater where transactionstatus='onaccount' group by docno";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			while($res1=mysqli_fetch_array($exec1))

			{

			$accountname=$res1['accountname'];

			$docno = $res1['docno'];

			$docdate = $res1['transactiondate'];

			$transactionmode = $res1['transactionmode'];

			if(($transactionmode == 'CHEQUE')||($transactionmode == 'ONLINE'))

			{

			$number = $res1['chequenumber'];

			}

			else

			{

			$number = '';

			}

			$transactionamount = $res1['transactionamount'];

			

			$query2 = "select sum(transactionamount) as adjustedamount from master_transactionpaylater where docno='$docno' and transactiontype = 'PAYMENT' and transactionstatus = '' and recordstatus <> 'deallocated'";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$res2 = mysqli_fetch_array($exec2);

			$adjustedamount = $res2['adjustedamount'];

			$usernam = $res1['username'];

			$balance = $transactionamount - $adjustedamount;

		if($adjustedamount == '')

		{

		$adjustedamount = '-';

		}

		

		if($balance != '0.00')

			{

			

			$totaltransactionamount = $totaltransactionamount + $transactionamount;

			$totaladjustedamount = $totaladjustedamount + $adjustedamount;

			$totalbalance = $totalbalance + $balance;

			

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

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $docno; ?></div></td>

		        <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="center"><?php echo $docdate; ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="left"><?php echo $transactionmode; ?> <?php echo $number; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="right"><?php echo $usernam ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="right"><?php echo $transactionamount; ?></div></td>

					      <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="right"><?php echo $adjustedamount; ?></div></td>

			 	<td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="right"><?php echo number_format($balance,2,'.','.'); ?></div></td>

			  

		

                </tr>

			  <?php

			}

			}
?>
 <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			   <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totaltransactionamount,2,'.',','); ?></strong></td>

		  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totaladjustedamount,2,'.',','); ?></strong></td>

				  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalbalance,2,'.',','); ?></strong></td>

		

              </tr>
          </tbody>

        </table>


<?php } ?>
</body>

</html>



