<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ledgerview.xls"');
header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');


	

	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	if (isset($_REQUEST["todate"])) { $todate = $_REQUEST["todate"]; } else { $todate = ""; }
	if (isset($_REQUEST["fromdate"])) { $fromdate = $_REQUEST["fromdate"]; } else { $fromdate = ""; }
	if (isset($_REQUEST["ledger_id"])) { $ledger_id = $_REQUEST["ledger_id"]; } else { $ledger_id = ""; }
	if (isset($_REQUEST["ledger_name"])) { $ledger_name = $_REQUEST["ledger_name"]; } else { $ledger_name = ""; }





?>

<style type="text/css">

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}


</style>

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1000" border="0" cellspacing="0" cellpadding="2">
  <tr >
    <td width="80%" valign="top" >

      <table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td >

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" align="left" border="1">

          <tbody>
            <tr>

             <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong>Ledger View Report</strong></td>

              </tr >
			  
			   <tr>
               <td colspan="6" bgcolor="#ffffff" class="bodytext31"> <div align="left"><strong style="color:red;">Date From: </strong><?php echo date('d-m-Y',strtotime($fromdate));?>&nbsp;<strong style="color:red;">Date To: </strong><?php echo date('d-m-Y',strtotime($todate));?> </div>
               </td>
			   </tr>
				
				<tr>
            	<td colspan="2" bgcolor="#ffffff" class="bodytext31"> <div align="left"><strong style="color:red;">	<?php echo $ledger_name;?></strong> </div> </td>
                <td  bgcolor="#ffffff" class="bodytext31">
                	<?php
                	    // debit tot bal
				        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $d_amount = $res3['damount'];

                        // debit tot bal
				        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $c_amount = $res3['camount'];
                        $t_amount = $d_amount - $c_amount;
                        $opening_bal_d = ($t_amount>=0)?$t_amount:0;
                        $opening_bal_c = ($t_amount<0)?$t_amount:0;

                        $opening_bal = $t_amount;
                	?>
                    <div align="center"><strong>Opening Balance:</strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31" align="right"><div ><strong><?php echo number_format((float)ABS($opening_bal_d), 2, '.', ',');?></strong></div></td>
                <td bgcolor="#ffffff" class="bodytext31" align="right"><div ><strong><?php echo number_format((float)ABS($opening_bal_c), 2, '.', ',');?></strong></div></td>
             
            </tr>
            <tr>
                <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><div align="center">&nbsp;</div></td>
            </tr>
			
			
			 <tr>
			 <td  width="1%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.no</strong></div></td>
			 <td   align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
			 <td width="20%" colspan=""  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Transaction No.</strong></div></td>
			 <td width="20%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Running Balance</strong></div></td>
            </tr>
			
           <?php
		        $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1location = $res1["locationname"]; 
				$res1locationcode = $res1["locationcode"];
				// var_dump($res1location);		
		     ?>
		     <?php
            $colorloopcount ='';
            
			$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate' and '$todate' order by transaction_date asc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			$sno = 0;
			//run previous
			$previous_type = '';
			$previous_amt = '';
			$closing_bal = 0;
			$total_c = 0;
			$total_d = 0;
			
			while($res2 = mysqli_fetch_array($exec2))
			{
			//var_dump($res2);
			$transaction_date = $res2["transaction_date"];
			$transaction_type = $res2['transaction_type'];
			$transaction_number = $res2['doc_number'];

			if($transaction_type == 'C'){
				$credit_amount = $res2['transaction_amount'];
			}else{
				$credit_amount = '0.00';
			}

			if($transaction_type == 'D'){
				$debit_amount = $res2['transaction_amount'];
			}else{
				$debit_amount = '0.00';
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
			$sno = $sno + 1;
			$transaction_amount = $res2['transaction_amount'];
			
			?>
          <tr>
             
			    <td  colspan="" align="left" valign="center" class="bodytext31"> <?php echo $sno; ?> </td>
				<td  colspan=""  align="center" valign="center" class="bodytext31"><?php echo date('d-m-Y',strtotime($transaction_date)); ?></td>
				<td  colspan=""  align="right" valign="center" class="bodytext31"><?php echo $transaction_number; ?></td>
				<td  align="right" valign="center" class="bodytext31">
					<?php
					   $amt_d = number_format((float)$debit_amount, 2, '.', ','); echo $amt_d;
					   $total_d = (float)$total_d + (float)$debit_amount;
					 ?>
				</td>
				<td  width="9%"  width="10%" align="right" valign="center" class="bodytext31">
					<?php 
					  $amt_c = number_format((float)$credit_amount, 2, '.', ','); echo $amt_c;
					  $total_c = (float)$total_c + (float)$credit_amount;
					  //echo $total_c
				    ?>
				</td>
				<td  width="10%" align="right" valign="center" class="bodytext31">
					<?php 
					  //calc running bal
						if($sno == 1){
							if($transaction_type == 'C'){
								$running_bal = $opening_bal - $credit_amount;
							}else{
								$running_bal = $opening_bal + $debit_amount;
							}
							$previous_type = $transaction_type;
			                $previous_amt = $running_bal;
						}else{
							//echo $transaction_type.'<br>';
							if($transaction_type == 'C'){
								$running_bal = ((float)$previous_amt - (float)$credit_amount);
							}
							if($transaction_type == 'D'){
								$running_bal = ((float)$previous_amt + (float)$debit_amount);
							}
							// put var
							$previous_type = $transaction_type;
			                $previous_amt = $running_bal;
						}
						$closing_bal = $running_bal;
						echo number_format((float)$running_bal, 2, '.', ',');
					?>		
				</td>
			   </tr>
		   <?php 
		   } 
		  
		   ?>

			 <tr>
                <td colspan="3" bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong>Total Transactions:</strong></div>
                </td>
                
                <td bgcolor="#ffffff" class="bodytext31" align="right">
                    <div ><strong><?php $amt = number_format((float)$total_d, 2, '.', ','); echo $amt;?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31" align="right">
                    <div ><strong><?php $amt = number_format((float)$total_c, 2, '.', ','); echo $amt;?></strong></div>
                </td>
				<td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong>Closing Balance:</strong></div>
                </td>
               
                <td bgcolor="#ffffff" class="bodytext31"  align="right">
                    <div><strong><?php if($closing_bal >=0) { $amt = number_format((float)$closing_bal, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31" align="right">
                    <div ><strong><?php if($closing_bal <0) { $val = ((float)$closing_bal * -1);$amt = number_format((float)$val, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
				 <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                
            </tr>
            <tr>
             	<td colspan="5" align="left" valign="center" bordercolor="" 
                bgcolor="#ffffff" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="" align="left" 
                bgcolor="#ffffff">&nbsp;</td>
            
             	
             	</tr>	    	  

		   

          </tbody>

        </table>

       </td >

      </tr >

    </table>

   </td>

  </tr> 

</table>


</body>

</html>



