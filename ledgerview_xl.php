<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="ledgerview.xls"');

header('Cache-Control: max-age=80');



$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$fromdate_actual=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate_actual=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";

$todaydate = date("Y-m-d");

//echo $fromdate.'<br/>'.$todate;
//echo $_REQUEST['ADate1'];
// set ledger_id request
$ledger_id =isset($_REQUEST['ledgerid'])?$_REQUEST['ledgerid']:"";
$ledger_name =isset($_REQUEST['ledgername'])?$_REQUEST['ledgername']:"";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}


?>
 <?php
              	$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where id ='$ledger_id' and recordstatus <> 'deleted'";
        		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln = mysqli_fetch_array($exec_ln);
                $ledger_name = $res_ln['accountname'];
                $account_main = $res_ln['accountsmain'];
                $account_sub = $res_ln['accountssub'];

                // account main
                $query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
        		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln1 = mysqli_fetch_array($exec_ln1);
                $acc_main_name = $res_ln1['accountsmain'];
                $tb_group = $res_ln1['tb_group'];

                 // account sub
                $query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
        		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln2 = mysqli_fetch_array($exec_ln2);
                $acc_sub_name = $res_ln2['accountssub'];
              ?>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>

          		<tr>
                <td colspan="10" bgcolor="#ffffff" class="bodytext31">
                    <div align="left">
                    	
                   			 Ledger View Report
                		
                	</div>
                </td>
            </tr>
          	<tr>
                <td colspan="10" bgcolor="#ffffff" class="bodytext31">
                    <div align="left">
                    	
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name;
	                    	?>	
                		
                	</div>
                </td>
            </tr>
          		 <tr>
               
                
                <td colspan="10"  align="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>&nbsp;<?php echo $ledger_name?></strong></div></td>
				</tr>
				
            <tr>
                <td colspan="10" align="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left">Date From <?php echo $fromdate_actual;?>  to <?php echo $todate_actual;?></div></td>
				  
				 </tr>
          	</tbody>
          </table>


		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
               <tr>
            	<td colspan="6" bgcolor="#ffffff" class="bodytext31">
                   
                </td>
                <td  bgcolor="#ffffff" class="bodytext31">
                	<?php
                		   if($tb_group == 'I')
                		   {
                			$from_date = $fromdate;
                			$fromdate = getfromdate($fromdate);
                			$todate   = gettodate($from_date);
                			
	                		// debit tot bal
					        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and transaction_date between  '$fromdate' and '$todate' group by transaction_type";
					       
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
	                        $d_amount = $res3['damount'];


	                       

	                        // debit tot bal
					        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and transaction_date between  '$fromdate' and '$todate' group by transaction_type";
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
	                        $c_amount = $res3['camount'];
	                        $t_amount = $d_amount - $c_amount;
	                        $opening_bal_d = ($t_amount>=0)?$t_amount:0;
	                        $opening_bal_c = ($t_amount<0)?$t_amount:0;

	                        $opening_bal = $t_amount;
                		}
                		else{
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
                    }
                	?>
                    <div align="center"><strong>Opening Balance:</strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong><?php echo number_format((float)ABS($opening_bal_d), 2, '.', ',');?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong><?php echo number_format((float)ABS($opening_bal_c), 2, '.', ',');?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"></div>
                </td>
            </tr>
             <tr>
			 <td  colspan="1" width="1%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.no</strong></div></td>
			 <td width="8%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
			 <td width="8%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Transaction No.</strong></div></td>
			  <td width="8%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Reference No.</strong></div></td>
			   <td width="25%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Transaction Ledgers</strong></div></td>
			  <td width="25%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>
			  <td width="8%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Running Balance</strong></div></td>
            </tr>
			   <?php
            $colorloopcount ='';
            
			 $query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate_actual' and '$todate_actual' order by transaction_date asc";
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
			$reference_no = $res2['refno'];
			$patientcode  = trim($res2['patientcode']);
			$patientname  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['patientname']));
			$visitcode    = trim($res2['visitcode']);
			$itemcode     = trim($res2['itemcode']);
			$itemname     = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['itemname']));
			$narration    = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['narration']));

			$from_table   = $res2['from_table'];

			$username     = $res2['user_name'];
			$description = "";

			$description .= "".$patientcode."";

			if($patientname!="")
				$description .= " , ".$patientname;

			if($visitcode!="")
				$description .= " , ".$visitcode;


			if($itemcode!="" && $visitcode!="")
				$description .= " , ".$itemcode;
			elseif($itemcode!="" && $visitcode=="")
				$description .= $itemcode;
			if($itemname!="")
				$description .= " , ".$itemname;
			if($narration!="")
				$description .= " , ".$narration;

			$accountname = "";
			$bankname    = "";
			$transactionmode = "";
			$chequenumber   = "";
			$remarkss    ="";
			if($from_table == "master_transactiononaccount")
			{
				
				$query_ar = "select accountname,transactionmode,bankname from master_transactiononaccount where docno='$transaction_number'";
			    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ar = mysqli_fetch_array($exec_ar);
				$transactionmode = $res_ar["transactionmode"]; 
				$accountname     = $res_ar["accountname"];
				$bankname        = $res_ar["bankname"];
				$transactionmode = $res_ar["transactionmode"]; 
				//if($transactionmode == "CHEQUE")
				//{
					$query_ar = "select chequenumber,remarks from master_transactionpaylater where docno='$transaction_number'";
				    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res_ar = mysqli_fetch_array($exec_ar);
					$chequenumber = $res_ar["chequenumber"];
					$remarkss   = $res_ar["remarks"];
				//}
				
				$description     = $accountname." , ".$transactionmode;

				if($chequenumber!="")
				{
					$description .= " , ".$chequenumber;
				}
				if($bankname!="")
				{
					$description .= " , ".$bankname;
				}
				if($remarkss!="")
				{
					$description .= " , ".$remarkss;
				}

			}

			if($from_table == "paymententry_details")
			{
				$accountname = "";
			$bankname    = "";
			$transactionmode = "";
			$chequenumber   = "";
			$chequedate   = "";
			$remarkss    ="";
				$query_ar = "select transactionmode,chequenumber,chequedate,bankname,remarks from master_transactionpharmacy where docno='$transaction_number'";
			    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			    $numrows = mysqli_num_rows($exec_ar);
			    if($numrows)
			    {	
					$res_ar = mysqli_fetch_array($exec_ar);
					$transactionmode = $res_ar["transactionmode"]; 
					$chequenumber = $res_ar["chequenumber"];
					$chequedate = $res_ar["chequedate"];
					$bankname        = $res_ar["bankname"];
					$remarkss   = $res_ar["remarks"];
					
			    }
				
				$description     = $transactionmode;

				if($chequenumber!="")
				{
					$description .= " , ".$chequenumber;
				}
				if($chequedate!="")
				{
					$description .= " , ".$chequedate;
				}
				if($bankname!="")
				{
					$description .= " , ".$bankname;
				}
				if($remarkss!="")
				{
					$description .= " , ".$remarkss;
				}
			}
			
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
              <tr >
                <td class="bodytext31" valign="top"  align="left"><?php echo $sno; ?></td>
               
                    <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo date('d-m-Y',strtotime($transaction_date)); ?></span></div>
                </div></td>
				  <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $transaction_number; ?></span></div>
                </div></td>
				  <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $reference_no; ?></span></div>
                </div></td>
                	<td  colspan="1"  align="left" valign="center" class="bodytext31">


					<?php 

					$queryledger = "SELECT tb.`transaction_type`,tb.`ledger_id`,master_accountname.accountname, sum(transaction_amount) ledgersum FROM `tb` inner join master_accountname on master_accountname.id = tb.ledger_id WHERE doc_number='$transaction_number' group by ledger_id,transaction_type order by transaction_type desc";
					$execledger = mysqli_query($GLOBALS["___mysqli_ston"], $queryledger) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$numledger=mysqli_num_rows($execledger);
					
					$ledgersno = 0;
					while($resledger = mysqli_fetch_array($execledger))
					{
					   
					   $ledger_transaction_type = $resledger["transaction_type"];
					   $ledgeridd = $resledger["ledger_id"];
					   $ledgernamee = $resledger["accountname"];
					   $ledgersum = $resledger["ledgersum"];
					   if($ledgersum > 0)
					   {
					   	$ledgersno += 1;
					   echo $ledgersno.'.'.' '.$ledger_transaction_type.' - '.$ledgernamee.' - '.number_format($ledgersum, 2, '.', ',').'<br>';
						}
					   

				    }

					?>
				
			</td>
					  <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $description; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="top"  align="left">
				  <div align="left"><?php echo $username; ?></div></td>
           
               <td  align="right" valign="top" class="bodytext31">
					<?php
					   $amt_d = number_format((float)$debit_amount, 2, '.', ','); echo $amt_d;
					   $total_d = (float)$total_d + (float)$debit_amount;
					 ?>
				</td>
				<td  align="right" valign="top" class="bodytext31">
					<?php 
					  $amt_c = number_format((float)$credit_amount, 2, '.', ','); echo $amt_c;
					  $total_c = (float)$total_c + (float)$credit_amount;
					  //echo $total_c
				    ?>
				</td>
					<td  align="right" valign="top" class="bodytext31">
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
                <td colspan="6"  class="bodytext31">
                    <div align="right"><strong>Total Transactions:</strong></div>
                </td>
                <td  class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                <td  class="bodytext31">
                    <div align="right"><strong><?php $amt = number_format((float)$total_d, 2, '.', ','); echo $amt;?></strong></div>
                </td>
                <td  class="bodytext31">
                    <div align="right"><strong><?php $amt = number_format((float)$total_c, 2, '.', ','); echo $amt;?></strong></div>
                </td>
                 <td  class="bodytext31">
                    <div align="right"><strong></strong></div>
                </td>
               
            </tr>
            <tr>
                <td colspan="6" bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong>Closing Balance:</strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong><?php if($closing_bal >=0) { $amt = number_format((float)$closing_bal, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong><?php if($closing_bal <0) { $val = ((float)$closing_bal * -1);$amt = number_format((float)$val, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
                 <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong></strong></div>
                </td>
                
            </tr>
		  </tbody>
		  </table>


<?php 

function getfromdate($fromdate){
	$timestamp = strtotime($fromdate);
	$year = date("Y", $timestamp);
	$fromdate = "$year-01-01";
	return $fromdate;
}
function gettodate($fromdate){
	$enddate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
	return $enddate;
}
?>
