<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Receiptcontrolview.xls"');

header('Cache-Control: max-age=80');



$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y/m/d H:i");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y/m/d H:i");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y/m/d H:i");
$fromdate=date('Y-m-d H:i:s', strtotime($fromdate));
$todate=date('Y-m-d H:i:s', strtotime($todate));
$fromdate_actual=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate_actual=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$fromdate_actual=date('Y-m-d H:i:s', strtotime($fromdate_actual));
$todate_actual=date('Y-m-d H:i:s', strtotime($todate_actual));
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";

$todaydate = date("Y-m-d");

$ledger_id =isset($_REQUEST['ledgerid'])?$_REQUEST['ledgerid']:"";
$ledger_name =isset($_REQUEST['ledgername'])?$_REQUEST['ledgername']:"";

//get location for sort by location purpose
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if($locationcode=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode'";
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
                    	
                   			 Receipt Control View Report
                		
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
                bgcolor="#ffffff" class="bodytext31"><div align="left">Date From <?php echo date('d-m-Y',strtotime($fromdate_actual));?>  to <?php echo date('d-m-Y',strtotime($todate_actual));?></div></td>
				  
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
                			$from_date = date('Y-m-d H:i:s', strtotime($fromdate));
                			$fromdate = getfromdate($fromdate);
                			$todate   = gettodate($from_date);
                			
	                		// debit tot bal
					        $query3 = "select auto_number,created_at,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and created_at between  '$fromdate' and '$todate' and $pass_location group by transaction_type";
					       
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
	                        $d_amount = $res3['damount'];


	                       

	                        // debit tot bal
					        $query3 = "select auto_number,created_at,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and created_at between  '$fromdate' and '$todate' and $pass_location group by transaction_type";
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
				        $query3 = "select auto_number,created_at,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and created_at < '$fromdate' and $pass_location group by transaction_type";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $d_amount = $res3['damount'];

                        // debit tot bal
				        $query3 = "select auto_number,created_at,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and created_at < '$fromdate' and $pass_location group by transaction_type";
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
			   <td width="25%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
			  <td width="25%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>
			  <td width="8%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Running Balance</strong></div></td>
            </tr>
			   <?php
            $colorloopcount ='';
            
			 $query2 = "select * from tb where ledger_id='$ledger_id' and created_at between '$fromdate_actual' and '$todate_actual' and $pass_location order by created_at asc";
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
			$created_at = $res2["created_at"];
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
/* if($from_table=='deposit_refund'){
$query_ar1 = "select patientcode from $from_table where docno='$transaction_number'";		
}elseif($from_table=='other_sales_billing'){
$query_ar1 = "select ledgercode as patientcode from $from_table where billno='$transaction_number'";		
}else{
$query_ar1 = "select patientcode from $from_table where billnumber='$transaction_number'";
} */

if($from_table=='deposit_refund'){
$query_ar1 = "select patientcode from $from_table where docno='$transaction_number'";		
}elseif($from_table=='other_sales_billing'){
$query_ar1 = "select ledgercode as patientcode from $from_table where billno='$transaction_number'";		
}elseif($from_table=='master_journalentries'){
 $query_ar1 = "select vouchertype as patientcode from $from_table where docno='$transaction_number'";		
}else{
$query_ar1 = "select patientcode from $from_table where billnumber='$transaction_number'";
}
	
$exec_ar1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar1) or die ("Error in Queryar1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_ar1 = mysqli_fetch_array($exec_ar1);
$patientcode = $res_ar1["patientcode"]; 

if($from_table == "billing_consultation")
{
$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from billing_consultation where billnumber='$transaction_number'";
}
else if($from_table == "master_transactionip")
{
	$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from master_transactionip where billnumber='$transaction_number'";
}
else if($from_table == "master_transactionipdeposit")
{
	$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from master_transactionipdeposit where docno='$transaction_number'";
}
else if($from_table == "master_transactionpaynow")
{
	$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from master_transactionpaynow where billnumber='$transaction_number'";
}
else if($from_table == "master_transactionip")
{
	$query_1 = "select mpesanumber,onlinenumber,creditcardnumber,chequenumber,patientcode from master_transactionpaynow where billnumber='$transaction_number'";
}
else if($from_table == "refund_paynow")
{
	$query_1 = "select mpesanumber,collectionnumber as onlinenumber,creditcardnumber,chequenumber,patientcode from refund_paynow where billnumber='$transaction_number'";
}
else if($from_table == "other_sales_billing")
{
	$query_1 = "select txnno as mpesanumber,'' as onlinenumber,'' as creditcardnumber,'' as chequenumber,ledgercode as patientcode from other_sales_billing where billno='$transaction_number'";
}
else if($from_table == "master_journalentries")
{
	$query_1 = "select remarks as mpesanumber,'' as onlinenumber,'' as creditcardnumber,'' as chequenumber,docno as patientcode from master_journalentries where docno='$transaction_number'";
}
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$mpesanumber = $res_1["mpesanumber"]; 
$onlinenumber = $res_1["onlinenumber"];
$creditcardnumber = $res_1["creditcardnumber"];
$chequenumber = $res_1["chequenumber"];
$patientcode = $res_1["patientcode"]; 

if($mpesanumber!='' && $mpesanumber!='0')
{
	$reference_no=$mpesanumber;
}
if($onlinenumber!='' && $onlinenumber!='0')
{
	$reference_no=$onlinenumber;
}
if($creditcardnumber!='' && $creditcardnumber!='0')
{
	$reference_no=$creditcardnumber;
}
if($chequenumber!='' && $chequenumber!='0')
{
	$reference_no=$chequenumber;
}


if($from_table == "billing_ip")
{
$query_1 = "select preauthcode,patientcode from billing_consultation where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1088".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
}

if($from_table == "billing_paylater")
{
$query_1 = "select preauthcode,patientcode from billing_paylater where billno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1188".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
}

if($from_table == "billing_ipadmissioncharge")
{
$query_1 = "select preauthcode,patientcode from billing_ipadmissioncharge where docno='$transaction_number'";
$exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1180".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_1 = mysqli_fetch_array($exec_1);
$preauthcode = $res_1["preauthcode"]; 
$patientcode = $res_1["patientcode"]; 
if($preauthcode!='')
{
	$reference_no=$mpesanumber;
}
}		
	
			if($from_table == "master_transactiononaccount")
			{
				
				$query_ar = "select accountname,transactionmode,bankname,patientcode from master_transactiononaccount where docno='$transaction_number'";
			    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ar = mysqli_fetch_array($exec_ar);
				$transactionmode = $res_ar["transactionmode"]; 
				$accountname     = $res_ar["accountname"];
				$bankname        = $res_ar["bankname"];
				$transactionmode = $res_ar["transactionmode"]; 
				$patientcode = $res_ar["patientcode"]; 
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
				$query_ar = "select transactionmode,chequenumber,chequedate,bankname,remarks,patientcode from master_transactionpharmacy where docno='$transaction_number'";
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
					$patientcode = $res_ar["patientcode"]; 
					
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
			
$query_ar18 = "select customerfullname from master_customer where customercode='$patientcode'";
$exec_ar18 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar18) or die ("Error in Queryar18".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_ar18 = mysqli_fetch_array($exec_ar18);
$customerfullname = $res_ar18["customerfullname"]; 
			?>
              <tr >
                <td class="bodytext31" valign="top"  align="left"><?php echo $sno; ?></td>
               
                    <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo date('d-m-Y',strtotime($created_at)); ?></span></div>
                </div></td>
				  <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $transaction_number; ?></span></div>
                </div></td>
				  <td  align="left" valign="top" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $reference_no; ?></span></div>
                </div></td>
                	<td  colspan="1"  align="left" valign="center" class="bodytext31"><?php echo $customerfullname; ?></div>

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
