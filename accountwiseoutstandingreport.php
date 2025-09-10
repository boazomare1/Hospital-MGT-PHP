<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$daysafterbilldate = "";
$totalsum = "0.00";
$searchsuppliername='';

include ("autocompletebuild_account2.php");
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
function funcAccount()
{
	if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
	{
		alert('Please Select Account Name');
		return false;
	}
}
</script>
<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
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
		
		
              <form name="cbform1" method="post" action="accountwiseoutstandingreport.php">
		<table width="656" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Account Wise Outstanding Report</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Search Account</strong> </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   
			 <!-- <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
        <td>
		
<?php
	
		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
?>
		<table 
            cellspacing="0" cellpadding="4" width="656" 
            align="left" border="0">
          <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>S.No.</strong></td>
				  <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Account</strong></td>
                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Outstanding</strong></div></td>
                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>30 Days </strong></div></td>
                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>60 Days </strong></div></td>
                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>90 Days </strong></div></td>
                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>120 Days </strong></div></td>
	     </tr>
		 
            <?php
			$colorloopcount1=0;
	        $sno1=0;
			$totalbalance = 0.00;

			$cashamount21 = 0.00;
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
		    $totalrefundedamount=0;
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			 
			$query222 = "select * from master_accountname where accountname like'%$searchsuppliername%' and recordstatus <> 'DELETED' order by accountname ";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res222 = mysqli_fetch_array($exec222))
			{
			$res222accountname=$res222['accountname'];
			$res222accountssub=$res222['accountssub'];
			
			$query2 = "select * from master_accountssub where auto_number = '$res222accountssub' and recordstatus <> 'DELETED' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res2 = mysqli_fetch_array($exec2);
			$res2accountssub=$res2['auto_number'];
			$res2accountssub1=$res2['accountssub'];
			$nameofsupplier = $res222accountname;
			
			$query222ip = "select * from master_ipvisitentry where accountfullname ='$nameofsupplier' and discharge = 'completed' and billtype = 'PAY LATER'";
			$exec222ip = mysqli_query($GLOBALS["___mysqli_ston"], $query222ip) or die ("Error in Query222ip".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res222ip = mysqli_fetch_array($exec222ip))
			{
			$res222ipaccountname=$res222ip['accountfullname'];
			$res222ipvisitcode=$res222ip['visitcode'];
			$ipbilldate = $res222ip['registrationdate']; 
			$visitcode = $res222ipvisitcode;
			
			include('accountwiseoutstandingreport1.php');
			}
			
			$query2 = "select * from billing_paylater where accountname = '$nameofsupplier' ";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
			    $res2accountname = $res2['accountname'];
		
				$query67="select * from master_customer where customercode='$patientcode'";
				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);
				$res67=mysqli_fetch_array($exec67);
				$firstname=$res67['customername'];
				$lastname=$res67['customerlastname'];
				$name=$firstname.$lastname;
				$billnumber = $res2['billno'];
				$billdate = $res2['billdate'];
				$billtotalamount = $res2['totalamount'];
				
				$query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and transactionstatus <> 'onaccount' and transactionmodule = 'PAYMENT' and recordstatus <>'deallocated'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numbr=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))
				{
				    $cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$cashamount21 = $cashamount21 + $cashamount1;
					
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				$balanceamount = $billtotalamount - $netpayment;
				
				$query75="select * from refund_paylater where finalizationbillno='$billnumber' and billstatus='paid'";
			$exec75=mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows1=mysqli_num_rows($exec75);
			if($rows1 > 0)
			{
			$res75=mysqli_fetch_array($exec75);
			
			$refundedamount=$res75['totalamount'];
			
			
			$balanceamount=$balanceamount+$refundedamount;
			
			}
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			//$date2 = date("2014-10-10");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			//$daysafterbilldate = 32;
			//$ipdaysafterbilldate = 61;
			if($daysafterbilldate < $ipdaysafterbilldate){ $daysafterbilldate = 
			$daysafterbilldate; }else{ $daysafterbilldate = $ipdaysafterbilldate; }
			
			$query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and transactionmodule = 'PAYMENT' and transactionstatus <> 'onaccount' and recordstatus <>'deallocated' order by auto_number desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			 $numb=mysqli_num_rows($exec3);
			 $totalnumb=$totalnumb+$numb;
			 
			$lastpaymentdate = $res3['transactiondate'];
			$lastpaymentdate = substr($lastpaymentdate, 0, 10);
			
			if ($lastpaymentdate != '')
			{
				$date1 = $lastpaymentdate;
				$date2 = date("Y-m-d");  
				$diff = abs(strtotime($date2) - strtotime($date1));  
				$days = floor($diff / (60*60*24));  
				$daysafterpaymentdate = $days;
				
				$dotarray = explode("-", $lastpaymentdate);
				$dotyear = $dotarray[0];
				$dotmonth = $dotarray[1];
				$dotday = $dotarray[2];
				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
				
			}
			else
			{
				$daysafterpaymentdate = '';
				$lastpaymentdate = '';
			}			

			//echo $balanceamount;
			if ($balanceamount != '0.00')
			{
			//$colorloopcount = $colorloopcount + 1;
			//$showcolor = ($colorloopcount & 1); 
			//if ($showcolor == 0)
			//{
				//echo "if";
				//$colorcode = 'bgcolor="#CBDBFA"';
			//}
			//else
			//{
				//echo "else";
				//$colorcode = 'bgcolor="#ecf0f5"';
			//}
			?>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
			}
			}
			
			$query5 = "select * from master_transactionpaylater where accountname = '$nameofsupplier' and transactionstatus = 'onaccount' and transactiontype = 'PAYMENT' ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res5 = mysqli_fetch_array($exec5)){
			$totalbalance = $totalbalance - $res5['transactionamount'];
			}
				//echo $daysafterbilldate;	
				if($totalbalance != '' && ($res2accountssub1 == 'ACCOUNTS RECEIVABLE')) { 	
				$colorloopcount1 = $colorloopcount1 + 1;
				$showcolor1 = ($colorloopcount1 & 1); 
				if ($showcolor1 == 0)
				{
					$colorcode1 = 'bgcolor="#CBDBFA"';
				}
				else
				{
					$colorcode1 = 'bgcolor="#ecf0f5"';
				}
		?>
		         <?php   ?>
                 <tr <?php echo $colorcode1; ?>>
					<td class="bodytext311" valign="center"  align="left"><?php echo $sno1 = $sno1 + 1 ; ?></td> 
					<td class="bodytext311" valign="center"  align="left"	><?php echo $res222accountname; ?></td> 
					<td class="bodytext311" valign="center"  align="right"><?php echo number_format($totalbalance,2,'.',','); ?></td> 
					<td class="bodytext311" valign="center"  align="right"><?php if(($daysafterbilldate >= 0 || $daysafterbilldate == 0) && ($daysafterbilldate < 30)) { echo number_format($totalbalance,2,'.',','); } ?></td>
					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 30 && ($daysafterbilldate < 60)) { echo number_format($totalbalance,2,'.',','); } ?></td>
					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 60 && ($daysafterbilldate < 90)) { echo number_format($totalbalance,2,'.',','); } ?></td>
					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 90 && ($daysafterbilldate < 120)) { echo number_format($totalbalance,2,'.',','); } ?></td>
				</tr>
		         <?php  } ?>
        <?php
		}
		}
		?>
		<tr>
		<?php
			
				$urlpath = "searchsuppliername=$searchsuppliername";
			
			?>
			<td colspan="7" class="bodytext31" valign="center"  align="right"><a href="print_accountwiseoutstandingreport.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
		</tr>
        </table>
		
		<tr>
			<td>&nbsp;</td>
		</tr>
</table>	  
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

