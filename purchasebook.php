<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
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
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	

}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];


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
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
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

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="purchasebook.php">
                <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Book </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              
 				
              
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="25%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name </strong></div></td>
			  <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td> 
			  <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Doc No</td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Inv.No</td> 
			  <td width="8%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">Inv. Amt</td>
			  
			  <td width="8%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">WHT VAT</td>
			  <td width="8%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">WHT TAX</td>
             
			  <td width="15%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Net.Amt</strong></div></td> 
			  <td width="15%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Payment </strong></div></td>
			  <td width="15%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Balance</strong></td> 
            </tr>
			<?php
			
			
		    if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
		  if ($cbfrmflag1 == 'cbfrmflag1')
		  {
			
		  $query2 = "select * from purchase_details WHERE `suppliername` <> 'OPENINGSTOCK' and `entrydate` between '$ADate1' and '$ADate2' group by billnumber"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $amount3='';
		  $orgamount='';
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  	$suppliername=$res2['suppliername'];
			$invoiceno=$res2['supplierbillnumber'];
			$pono=$res2['ponumber'];
			$amount=$res2['totalamount'];
			$billno=$res2['billnumber'];
			$itemtaxpercentage=$res2['itemtaxpercentage'];
			$amount3='';
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$taxamount21 = '';
			$transactiontype='';
			$orgamount='';
			$wh_tax_value =$res2['wh_tax_value'];
			$wh_vat_value =$res2['wh_vat_value'];
			
		  	$query3 = "select * from purchase_details WHERE billnumber = '$billno' and `entrydate` between '$ADate1' and '$ADate2'"; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		 	while ($res3 = mysqli_fetch_array($exec3))
			{
			  $orgamount=($res3['rate']*$res3['allpackagetotalquantity']) + $orgamount;
			  $amount3=$res3['totalamount']+$amount3;
			
			}
			if($itemtaxpercentage>0){
                 $totaltax = ($orgamount*$itemtaxpercentage)/100;
			  }
			  else
				  $totaltax = 0;

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
			$query4 = "select * from master_transactionpharmacy WHERE billnumber = '$billno' and transactiontype = 'PAYMENT' and `transactiondate` between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated'"; 
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		 	while ($res4 = mysqli_fetch_array($exec4))
			{
					$cashamount1 = $res4['cashamount'];
					$onlineamount1 = $res4['onlineamount'];
					$chequeamount1 = $res4['chequeamount'];
					$cardamount1 = $res4['cardamount'];
					$tdsamount1 = $res4['tdsamount'];
					$writeoffamount1 = $res4['writeoffamount'];
					$taxamount1 = $res4['taxamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;
					$transactiontype=$res4['transactionmode'];
			
			}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $amount3 - $netpayment;
				//$payedamount = $amount3 - $balanceamount;
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $suppliername; ?></div>              </td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $transactiontype; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $invoiceno; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount3,2,'.',','); ?></div></td>

			<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($wh_vat_value,2,'.',','); ?></div></td>
			
			<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($wh_tax_value,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount3-($wh_vat_value+$wh_tax_value),2,'.',','); ?></div></td>


			  <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($netpayment,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($balanceamount-($wh_vat_value+$wh_tax_value),2,'.',','); ?></div></td>
               
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
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td> 
			   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan="3">&nbsp;</td> 
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

