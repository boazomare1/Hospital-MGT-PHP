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
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$totalcredit = "0.00";
$overalldebit= "0.00";
$overallcredit= "0.00";
$overallbalance= "0.00";
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");
include ("autocompletebuild_accounts.php");

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["location"])) { $locationcode1 = $_REQUEST["location"]; } else { $locationcode1 = ""; }
//echo $locationcode1;
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
<script type="text/javascript" src="js/autocomplete_subtype.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
   $('#searchsuppliername1').autocomplete({
	source:"ajaxaccountsub_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode1").val(accountid);
			$("#searchsupplieranum1").val(accountanum);
			
			},
    
	});
	$('#searchsuppliername').autocomplete({
	source:"ajaxaccount_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			//$("#searchsupplieranum").val(accountanum);
			
			},
    
	});
		
});
</script>

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
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
		
              <form name="cbform1" method="post" action="monthlyinvoicereport.php">
		<table width="660" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Monthly Invoice Report</strong></td>
              </tr>
            
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Search Subtype </span></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext32">
                <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">
                <input name="searchsuppliercode1" id="searchsuppliercode1" type="hidden" value="">
                <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="" type="hidden">
              </span></td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Search Account </span></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext32">
                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              <td width="13%" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location</span></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext32">
                <?php
                $query90 = "select * from master_location";
                $exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res90 = mysqli_fetch_array($exec90)){
                  $locationname = $res90['locationname'];
                  $locationcode = $res90['locationcode'];
                ?>
                <select name='location' id="location">
                  <option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>
                </select>
              </span></td>
              <?php } ?>
              <td align="left" valign="top">&nbsp;</td>
          </tr>
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="27%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="12%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="31%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                      <td width="13%" align="left" valign="center">&nbsp;</td>
			  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
              <td align="left" valign="top">
			  <a target="_blank" href="print_monthlyinvoicereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&subtype=<?php echo $searchsuppliername1; ?>&&account=<?php echo $searchsuppliername; ?>&&locationcode=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
			  <a download="download" href="print_monthlyinvoicereportpdf.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&subtype=<?php echo $searchsuppliername1; ?>&&account=<?php echo $searchsuppliername; ?>&&locationcode=<?php echo $locationcode1; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="style2">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="right"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td align="left" valign="right"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="style2">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="style2">Date</td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="24%" align="left" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td>
                <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit</strong></div></td>
				<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="style2"><div align="right">Credit</div></td>
				<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bal. Amt</strong></div></td>
				</tr>
			<?php
			// if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			// //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			// if ($cbfrmflag1 == 'cbfrmflag1' && ($searchsuppliername1 != '') || ($searchsuppliername != ''))
			// {
			$searchsuppliername = trim($searchsuppliername);
			$searchsuppliername1 = trim($searchsuppliername1);
			if(($searchsuppliername != '')&&($searchsuppliername1 != ''))
		  {
			   $query21 = "select * from master_transactionpaylater where subtype = '$searchsuppliername1' and accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			}
			else if(($searchsuppliername != '')&&($searchsuppliername1 == ''))
			{
			   $query21 = "select * from master_transactionpaylater where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			}
			else if(($searchsuppliername == '')&&($searchsuppliername1 != ''))
			{
			   $query21 = "select * from master_transactionpaylater where subtype = '$searchsuppliername1' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			} else {
          $query21 = "select * from master_transactionpaylater where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
      }
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			$res1subtype = $res21['subtype'];
			$res1transactiondate  = $res21['transactiondate'];
			$res1billnumber  = $res21['billnumber'];
			$res1patientcode = $res21['patientcode'];
			$res1patientname = $res21['patientname'];
			$res1visitcode = $res21['visitcode'];
			
			$query_c = mysqli_query($GLOBALS["___mysqli_ston"], "select memberno from master_customer where customercode = '$res1patientcode' and locationcode = '$locationcode1'") or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_c = mysqli_fetch_array($query_c);
			$memberno = $res_c['memberno'];
		  
		  $query2 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode' and billnumber = '$res1billnumber'  and transactiontype = 'finalize' and locationcode = '$locationcode1'";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  $res2transactionamount = $res2['transactionamount'];
		  $overalldebit=$overalldebit + $res2transactionamount;
		  
		  $query3 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and locationcode = '$locationcode1'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3transactionamount = $res3['transactionamount'];
		  // $res3transactionamount = 0;
		  
		  $query4 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and locationcode = '$locationcode1'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4transactionamount = $res4['transactionamount'];
		  // $res4transactionamount = 0;
		  
		  $query5 = "select sum(a.transactionamount) as transactionamount from master_transactionpaylater as a JOIN master_transactionpaylater as b ON (a.`visitcode` = b.`visitcode`) where b.`transactiontype` = 'finalize' and b.locationcode = '$locationcode1' and a.accountname = '$res21accountname' and a.patientcode = '$res1patientcode' and a.visitcode = '$res1visitcode'  and a.transactiontype = 'pharmacycredit' and a.recordstatus <> 'deallocated' and a.`auto_number` > b.`auto_number`";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5transactionamount = $res5['transactionamount'];
		  // $res5transactionamount = 0;
          $totalcredit=  $res3transactionamount + $res4transactionamount + $res5transactionamount;
		  $overallcredit = $overallcredit  + $totalcredit;
		  $invoicevalue = $res2transactionamount - ($res3transactionamount + $res4transactionamount + $res5transactionamount);
          $overallbalance = $overallbalance + $invoicevalue;
		  if($invoicevalue != 0)
		  {
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
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1transactiondate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res1patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res1visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res1patientname; ?></div></td>
                <td class="bodytext31" valign="middle" align="left"><?php echo $memberno; ?></td>
                <td class="bodytext31" valign="middle" align="left"><?php echo $res21accountname; ?></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalcredit,2,'.',','); ?></td>
               <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($invoicevalue,2,'.',','); ?></div></td>
				</tr>
			<?php
			}
			}
			// }
			?>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>  
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td  align="center" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($overalldebit,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($overallcredit,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($overallbalance,2,'.',','); ?></strong></td>
			    </tr>
			<tr>
			 <td colspan="9"></td>
		   	 </tr>    
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
