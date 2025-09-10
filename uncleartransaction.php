<?php

session_start();

error_reporting(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = '';

$transactiondateto = date('Y-m-d');

$errmsg = "";

$bgcolorcode = "";

 if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; }
	  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

	  if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $ADate1 = date('Y-m-d'); }

	  if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $ADate1 = date('Y-m-d'); }



?>
<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->


.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

</style>
<script>
function valid()
{
	if(document.getElementById('bankname').value =='')

	{

		alert("Please Select The Bank");

		return false;

	}

	if(document.getElementById('ADate2').value =='')

	{

		alert("Please Select The Date");

		return false;

	}
return true;
}
</script>
<script src="js/datetimepicker_css.js"></script>

</head>



<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

	    <tr>

	 <td width="890">

              <form name="cbform1" method="post" action="" onSubmit="return valid();">
              	 

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

				   

                    <tr>

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31">

                <div align="left"><strong>Bank Transaction </strong></div></td>

			    </tr>

				<tr>

                        <td colspan="10" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

					<tr>

					

                         <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Bank </td>

                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" colspan="2" ><!--<input type="text" name="chequebank" id="chequebank">-->

						<select name="bankname" id="bankname">

					<option value="">Select Bank</option>

						<?php 
						
						$querybankname = "select * from master_bank where bankstatus <> 'deleted'";

						$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($resbankname = mysqli_fetch_array($execbankname))

						{

						?>

							

							<option value="<?php echo $resbankname['bankcode']; ?>" <?php if($bankname == $resbankname['bankcode']) echo 'selected'; ?>><?php echo $resbankname['bankname'];?></option>

						<?php }

						?>

					</select></td>
					
					<td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="left"><strong></strong></div></td>

                      </tr>

                      
                       <tr>

                     <!--  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td> -->

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2"   size="10"  readonly="readonly" value="<?= $ADate2;?>" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                        <td colspan="2" bgcolor="#FFFFFF"></td>
                    </tr>

			 		

				<tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

                    </tr>

                  </tbody>

                </table>

              </form>		</td>

	 </tr>  

	  <tr><td>&nbsp;</td></tr>		        

	  <?php 
	 

			if($cbfrmflag1 == 'cbfrmflag1'){ 

				$query1 = "select bankname from master_bank where bankcode='$bankname'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $bank = $res1["bankname"];
				?>
 <tr>
   <td>
    <table width="" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse">
    
	<tr>

	  <td width="30" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>No</strong></td>

	   <td width="50" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Account</strong></td>

	  <td width="50" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Ref No</strong></td>

	  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Inst.No</strong></td>

	  <td width="90" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Amt. Posting Date</strong></td>

	  <td width="60" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Cheque Date</strong></td>

	  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Posted By</strong></td>

	  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="right" valign="middle"><strong>Remarks</strong></td>

	  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="right" valign="middle"><strong>Amount</strong></td>

	</tr>
	<tr>
	  <td Colspan='9'><strong>Uncleared Amount</strong></td>
	</tr>
<?php
    $totaldramount = '0.00';
	$colorloopcount=0;
	$apno =0;
	$query1 = "select * from(select docno as docnumber,accountname  as transactiontype,transactiondate as transactiondate,username,remarks as remarks,chequenumber as chequeno,transactiondate as chequedate,sum(fxamount) as trn_amount from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docnumber 
	union all
	select docno as docnumber,vouchertype as transactiontype,entrydate as transactiondate,username,narration as remarks,'Dr' as chequeno,entrydate as chequedate,sum(transactionamount) as trn_amount from master_journalentries where entrydate <= '$ADate2' and ledgerid like '%$bankname%' and selecttype='Dr' group by docnumber,selecttype 
	union all
	select docnumber,transactiontype,transactiondate,personname as username,remarks,'Dr' as chequeno,transactiondate as chequedate,sum(amount) as trn_amount from bankentryform where tobankid = '$bankname' and amount>0 and transactiondate <='$ADate2' group by docnumber) as unclear order by transactiondate ";

    $excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res1 = mysqli_fetch_array($excebankstatements))
    {

		    $apaccountname = strtoupper($res1['transactiontype']);
			$apdocno = $res1['docnumber'];
			$aptransactiondate =$res1['transactiondate'];
			$aptransactionamount1 = $res1['trn_amount'];

			$query_bankcharges = "select bank_charge from master_transactiononaccount where docno = '$apdocno'";
			$exec_bankcharges = mysqli_query($GLOBALS["___mysqli_ston"], $query_bankcharges) or die ("Error in Query_bankcharges".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post_bankcharges = mysqli_num_rows($exec_bankcharges);
			if($post_bankcharges>0){
				$res1_bc = mysqli_fetch_array($exec_bankcharges);
				$bankchagesss = $res1_bc['bank_charge'];
				$aptransactionamount=$aptransactionamount1-$bankchagesss;
			}else{
				$aptransactionamount=$aptransactionamount1;
			}

            $appostedby = $res1['username'];
			$apremarks = $res1['remarks'];
			$apchequeno = $res1['chequeno'];
			$apchequedate = $res1['chequedate'];
			if($apchequedate  == ''){
			$apchequedate = $aptransactiondate;
			}
            $needle   = "BE";
			if( strpos( $apdocno, $needle ) !== false) {
				$query21 = "select * from bank_record where docno = '$apdocno' and bankcode='$bankname' ";

			}else{
			$query21 = "select amount from bank_record where docno = '$apdocno' and instno = '$apchequeno'";
			}


			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post21 = mysqli_num_rows($exec21);
			if(($post21 == 0 || $post21 == '') && $aptransactionamount!='0.00'){

			$apno = $apno + 1;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)
				$colorcode = 'bgcolor="#CBDBFA"';
			else
				$colorcode = 'bgcolor="#ecf0f5"';

			$totaldramount =$totaldramount +$aptransactionamount;

            ?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apaccountname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apdocno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apchequeno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $aptransactiondate; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apchequedate; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $appostedby; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apremarks; ?></td>
			   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($aptransactionamount,2,'.',','); ?></td>

			</tr>
			<?php

			}
			
	}
	?>

            <tr>
			  <td colspan='8' align='right'><strong>Total Uncleared Amount :</strong></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totaldramount,2,'.',','); ?></td>

			</tr>
			<tr>
			  <td Colspan='9'><strong>Unpresented Amount</strong></td>
			</tr>
			<?php
			
    $totalcramount = '0.00';
	$colorloopcount=0;
	$apno =0;

	

	$query1 = "select * from(	
	
	SELECT res.* from ((select docno AS docnumber,suppliername AS transactiontype,transactiondate AS transactiondate,'' as username,remarks AS remarks,chequenumber AS chequeno,IF(chequedate='',transactiondate,chequedate) AS chequedate,sum(transactionamount) as trn_amount from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)  
			UNION ALL
			(select docno AS docnumber, doctorname AS transactiontype,transactiondate AS transactiondate,'' as username,remarks AS remarks,chequenumber AS chequeno, IF(chequedate='',transactiondate,chequedate) AS chequedate ,sum(netpayable) as trn_amount from master_transactiondoctor where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)
			UNION ALL
			(select docno AS docnumber, ledger_name AS transactiontype,transactiondate AS transactiondate, username as username,remarks AS remarks,chequenumber AS chequeno,(transactiondate) AS chequedate ,sum(bank_amount-bankcharges) as trn_amount from advance_payment_entry where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deleted' and transactiondate <= '$ADate2' group by docno)

		) res  where res.chequedate <='$ADate2'  
	union all
	select docno as docnumber,vouchertype as transactiontype,entrydate as transactiondate,username,narration as remarks,'Cr' as chequeno,entrydate as chequedate,sum(transactionamount) as trn_amount from master_journalentries where entrydate <= '$ADate2' and ledgerid like '%$bankname%' and selecttype='Cr' group by docnumber,selecttype 
	union all
	select docnumber,transactiontype,transactiondate,personname as username,remarks,'Cr' as chequeno,transactiondate as chequedate,sum(creditamount) as trn_amount from bankentryform where frombankid = '$bankname' and creditamount>0 and transactiondate <='$ADate2' group by docnumber
	) as unclear order by transactiondate ";


    $excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res1 = mysqli_fetch_array($excebankstatements))
    {

		    $apaccountname = strtoupper($res1['transactiontype']);
			$apdocno = $res1['docnumber'];
			$aptransactiondate =$res1['transactiondate'];
			$aptransactionamount = $res1['trn_amount'];

			

            $appostedby = $res1['username'];
			if($arpostedby==''){
			$query11 = "select * from paymentmodecredit where billnumber = '$apdocno'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$arpostedby = $res11['username'];
			}

			$apremarks = $res1['remarks'];
			$apchequeno = $res1['chequeno'];
			$apchequedate = $res1['chequedate'];
			if($apchequedate  == ''){
			$apchequedate = $aptransactiondate;
			}
            $needle   = "BE";
			if( strpos( $apdocno, $needle ) !== false) {
				$query21 = "select * from bank_record where docno = '$apdocno' and bankcode='$bankname' ";

			}else{
			  $query21 = "select amount from bank_record where docno = '$apdocno' and instno = '$apchequeno'";
			}

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post21 = mysqli_num_rows($exec21);
			if(($post21 == 0 || $post21 == '') && $aptransactionamount!='0.00'){

			$apno = $apno + 1;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)
				$colorcode = 'bgcolor="#CBDBFA"';
			else
				$colorcode = 'bgcolor="#ecf0f5"';

			$totalcramount =$totalcramount +$aptransactionamount;

            ?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apaccountname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apdocno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apchequeno; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $aptransactiondate; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apchequedate; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $appostedby; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $apremarks; ?></td>
			   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($aptransactionamount,2,'.',','); ?></td>

			</tr>
			<?php

			}
			
	}
	?>

            <tr>
			  <td colspan='8' align='right'><strong>Total Unpresented Amount :</strong></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalcramount,2,'.',','); ?></td>

			</tr>
			<tr>
			  <td colspan='9' align='right'><a href="uncleartransaction_xl.php?bankname=<?php echo $bankname;?>&ADate2=<?php echo $ADate2; ?>&cbfrmflag2=cbfrmflag2" target='_blank'><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>

			</tr>

			
			<?php
}
?>
   </table>
    </td>
   </tr>
  </table>
 </td>
</tr>
</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>