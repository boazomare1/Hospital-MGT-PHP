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


$grandtotal=0;
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

header('Content-Disposition: attachment;filename="Unallocated_Payables.xls"');

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

         



		 <tr> <td colspan="9" align="center"><strong><u><h3>Unallocated Payables</h3></u></strong></td></tr>


   		<tbody>

           

           <tr>

              <td width="3%"  align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="7%" align="left" valign="left"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="8%" align="left" valign="left"     bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>

              <td width="7%" align="left" valign="center"      bgcolor="#ffffff" class="style1">Mode</td>

              <td width="15%" align="left" valign="left"     bgcolor="#ffffff" class="style1"><div align="left"><strong>Inst.Number</strong></div></td>

              <td width="8%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>

                <td width="19%" align="left" valign="center"     bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Code</strong></div></td>

                <td width="6%" align="left" valign="center"        bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Name</strong></div></td>

                <td width="6%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Acc.Number</strong></div></td>
				
				<td width="6%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>


            </tr>

          <?php 
			  $totalamount = 0;
              $query2 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE'  and transactionmode <> 'CREDIT'  group by paymentvoucherno order by suppliercode desc";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2 = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			      $totalamount=0;
			 	  $transactiondate = $res2['transactiondate'];
				  $date = explode(" ",$transactiondate);
				  $docno = $res2['paymentvoucherno'];
				  $mode = $res2['paymentmode'];
				  //$mode = 'CHEQUE';
				  $bankcode=$res2['bankcode'];
				  $bankname=$res2['appvdbank'];
				  $suppliername = $res2['suppliername'];
				$query51="select sum(approved_amount) as transactionamount from master_transactionpharmacy where paymentvoucherno='$docno'";
				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res51 = mysqli_fetch_array($exec51);
				$totalamount = $res51['transactionamount'];  				  				 
				  $number = $res2['appvdcheque'];
				 
				  
			  $query3 = "select accountnumber from master_bank where bankcode = '$bankcode' order by auto_number desc limit 0, 1";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $accnumber = $res3['accountnumber'];
			  
			  $query35 = "select paymentvoucherno from master_purchase where paymentvoucherno = '$docno' and billnumber IN (select billnumber from master_transactionpharmacy where paymentvoucherno='$docno' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT')";
			  $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $row35 = mysqli_num_rows($exec35);
			  if($row35 == 0)
			  {
				  $grandtotal=$grandtotal+$totalamount;
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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

            <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
               
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $date[0]; ?></span></div>
                </div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $mode; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $suppliername; ?> </span> </div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $bankcode; ?> </span> </div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $bankname; ?> </span> </div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $accnumber; ?> </span> </div>
                </div></td>
				
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>
                </div></td>
           
		   		
		

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

                bgcolor="#ecf0f5"><strong></strong></td>

		  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong></strong></td>
				
				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong></strong></td>

				  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>

		

              </tr>
          </tbody>

        </table>


<?php } ?>
</body>

</html>



