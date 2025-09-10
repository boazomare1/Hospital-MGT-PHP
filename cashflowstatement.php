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
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
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
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="cashflowstatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank and Cash Ledger</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0" width="85%">
          <tbody>
            		<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
		  $query48 = "select * from paymentmodecredit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num48 = mysqli_num_rows($exec48);
		  
	      $query49 = "select * from paymentmodedebit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num49 = mysqli_num_rows($exec49);
	
		
		  
		  if($num48 > $num49)
		  {
		  $rowspancount = $num48;
		  }
		  else
		  {
		  $rowspancount = $num49;
		  }
		  $rowspancount;
		  }
		  ?>
            <tr>
              <td width="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="86" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="120" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Remarks </strong></td>
              <td width="93" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
				<td width="55%" rowspan="1000"  align="left" valign="top" bgcolor="#ecf0f5" >
			
				  <table width="90%" id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:-3px;" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
				  <tr>
				  <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="18%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="40%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>      				<td width="45%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Remarks </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
				</tr>
				<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
		  $query28 = "select * from paymentmodecredit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res28= mysqli_fetch_array($exec28))
		  {
     	  $res2transactiondate8 = $res28['billdate'];
		  $res2billnumber8 = $res28['billnumber'];
		  $res2accountname = $res28['accountname'];
		  $cashamount28 = $res28['cash']; 
		  $cardamount28 = $res28['card'];
		  $chequeamount28 = $res28['cheque'];
		  $onlineamount28 = $res28['online'];
		  $mpesaamount28 = $res28['mpesa'];
		  $cashcoa =  $res28['cashcoa'];
		  $cardcoa =  $res28['cardcoa'];
		  $chequecoa =  $res28['chequecoa'];
		  $onlinecoa =  $res28['onlinecoa'];
		  $mpesacoa =  $res28['mpesacoa'];		  $billnumber = explode('-',$res2billnumber8);		  $billprefix = $billnumber[0];		  		  if($billprefix == 'DP'){			  			  $remquery = "SELECT remarks FROM master_transactiondoctor WHERE docno = '$res2billnumber8'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];		  }		  elseif($billprefix == 'OPR' || $billprefix == 'OPR'){			  $remquery = "SELECT remarks FROM refund_paynow WHERE billnumber = '$res2billnumber8'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];			  		  }			  elseif($billprefix == 'PDP'){			   $remquery = "SELECT remarks FROM  deposit_refund WHERE docno = '$res2billnumber8'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];			  		  }				  elseif($billprefix == 'GRN'){			   $remquery = "SELECT suppliername,supplierbillnumber FROM  purchase_details WHERE billnumber = '$res2billnumber8'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $suppliername = $remres['suppliername'];			  $supplierbillnumber = $remres['supplierbillnumber'];			  $remarks = $suppliername.'-'.$supplierbillnumber;			  		  }			  elseif($billprefix == 'EN'){			   $remquery = "SELECT remarks FROM  expensesub_details WHERE docnumber = '$res2billnumber8'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];			  		  }				
		  if($res2accountname == '')
		  {
		  $query213 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res213 = mysqli_fetch_array($exec213);
		  $accountssub = $res213['accountssub'];
		  
		  $query214 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res214 = mysqli_fetch_array($exec214);
		  $accountssubname = $res214['accountssub'];
		  $res2accountname = $accountssubname;
		  }
		   $totalamount38 = $cashamount28 + $cardamount28 + $chequeamount28 + $onlineamount28 + $mpesaamount28;
		  $sno = $sno + 1;
		  
		  $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			$grandtotal1 = $grandtotal1 + $totalamount38;
		  ?>
		  <tr <?php echo $colorcode1; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate8; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2accountname; ?>(<?php echo $res2billnumber8; ?>)</div></td>      				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $remarks  ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount38,2,'.',','); ?></td>
           
           </tr>
		   <?php
			}
			
			?>
				  <tr>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($grandtotal1,2,'.',','); ?></strong></td>
			</tr>
			<?php
			}
			?>
				  </table>
				</td>
       
                </tr>
				
				<?php
				$query1 = "select sum(cash) as cash,sum(cheque) as cheque,sum(card) as card,sum(online) as online,sum(mpesa) as mpesa from paymentmodedebit where billdate < '$ADate1'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res1 = mysqli_fetch_array($exec1);
		  $num1 = mysqli_num_rows($exec1);
		  $cashamount = $res1['cash'];
		  $cardamount = $res1['card'];
		  $chequeamount = $res1['cheque'];
		  $onlineamount = $res1['online'];
		  $mpesaamount = $res1['mpesa'];
		  $totalamount = $cashamount + $cardamount + $chequeamount + $onlineamount + $mpesaamount;
		  
		  $query4 = "select sum(cash) as cash,sum(cheque) as cheque,sum(card) as card,sum(online) as online,sum(mpesa) as mpesa from paymentmodecredit where billdate < '$ADate1'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $num4 = mysqli_num_rows($exec4);
		  $cashamount1 = $res4['cash'];
		  $cardamount1 = $res4['card'];
		  $chequeamount1 = $res4['cheque'];
		  $onlineamount1 = $res4['online'];
		  $mpesaamount1 = $res4['mpesa'];
		  $totalamount1 = $cashamount1 + $cardamount1 + $chequeamount1 + $onlineamount1 + $mpesaamount1;
		  
		  $openingbalance = $totalamount;
				?>
	
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
				
              <td width="86" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31" colspan="2" ><strong> Opening Balance </strong></td>
       			  <td width="93" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
		  $query2 = "select * from paymentmodedebit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];		  		  		  $billnumber = explode('-',$res2billnumber);		  $billprefix = $billnumber[0];		  		  if($billprefix == 'AR'){			  			  $remquery = "SELECT remarks FROM master_transactionpaylater WHERE docno = '$res2billnumber' AND transactionmodule = 'PAYMENT' AND transactionstatus = 'onaccount'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];		  }		  elseif($billprefix == 'CF'){			  $remquery = "SELECT patientname FROM billing_consultation WHERE billnumber = '$res2billnumber'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['patientname'];			  		  }			  elseif($billprefix == 'OPC'){			   $remquery = "SELECT patientname FROM  billing_paynow WHERE billno = '$res2billnumber'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['patientname'];			  		  }				  elseif($billprefix == 'IPDF'){			   $remquery = "SELECT remarks FROM  master_transactionipdeposit WHERE docno = '$res2billnumber'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['remarks'];			  		  }				  elseif($billprefix == 'ADV'){			   $remquery = "SELECT patientname FROM  master_transactionipdeposit WHERE docno = '$res2billnumber'";			  $remexec = mysqli_query($GLOBALS["___mysqli_ston"], $remquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			  $remres = mysqli_fetch_array($remexec);			  $remarks = $remres['patientname'];			  		  }		 
		  $query21 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res21 = mysqli_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res212 = mysqli_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		  
		   $totalamount3 = $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		
		  $snocount = $snocount + 1;
		  
		  
				
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
			$grandtotal = $grandtotal + $totalamount3;
	
			?>
			
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $accountssubname; ?>(<?php echo $res2billnumber; ?>)</div></td>				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $remarks ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount3,2,'.',','); ?></td>
           
           </tr>
			<?php
			}
			$grandtotal = $grandtotal + $openingbalance
			?>
			<tr>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
			</tr>
   
				            
			  </tbody>
        </table></td>
      </tr>
	  <?php
	  $grandtot = $grandtotal - $grandtotal1;
	  ?>
   
			<tr>
        <td class="bodytext31" valign="center"  align="left"><strong>Balance&nbsp;&nbsp;
		 <?php echo number_format($grandtot,2,'.',','); ?></strong></td>
      </tr>
			<?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
