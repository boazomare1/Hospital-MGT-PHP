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

$subtype_ano='';
$exchange_rate=1;
$currency=0;
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
$snocount = "0";
$colorloopcount="";
$range = "";
$total30=0;
$total60=0;
$total90=0;
$total120=0;
$total180=0;
$total210=0;
$res11transactionamount='0';
$res12transactionamount='0';
$res2transactionamount=0;
$res3transactionamount=0;
$res4transactionamount=0;
$res5transactionamount=0;
$res6transactionamount=0;
$restot='0';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $paymentreceiveddatefrom; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $paymentreceiveddateto; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$searchsuppliername=trim($searchsuppliername);
$searchsuppliername=rtrim($searchsuppliername);
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
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name.');
return false;
}
else
{
if((document.getElementById("searchsuppliercode").value == "")||(document.getElementById("searchsuppliercode").value == " "))
{
alert('Please Select Account Name.');
return false;
}
} 
}
</script>
<!--<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>-->
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
   
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
			$("#searchsupplieranum").val(accountanum);
			
			},
    
	});
		
});
</script>
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
		
		
              <form name="cbform1" method="post" action="accountstatement_test.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Account Statement</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
			   <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1090" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="32%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mrd No</strong></div></td>
				<td width="13%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill number </strong></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
				
            </tr>
			<?php
			
			$openingbalance='0';
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
	$totaldebit=0;		
$debit=0;
$credit1=0;
$credit2=0;
$totalpayment=0;
$totalcredit='0';
$resamount=0;
$totalamount30 = 0;
					$totalamount60 = 0;
					$totalamount90 = 0;
					$totalamount120 = 0;
					$totalamount180 = 0;
					$totalamountgreater = 0;
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			//$searchsuppliername1 = trim($searchsuppliername1);
		  
	  $queryunion="select groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum' and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'
	  union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'  and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'
	   union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount,docno,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'
	   
	    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
	   
	    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')
		
		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars,selecttype as transactionmode,'' as subtypeano,'' as chequenumber,transactionamount as fxamount, docno,vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$transactiontype = $res2['transactiontype'];
	if($transactiontype=='finalize')
			{
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				$res2transactionamount = $res2['fxamount']/$exchange_rate;
				$snocount = $snocount + 1;
				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				$totalpayment = 0;
				
				
									
				$res2transactionamount = $res2transactionamount - $totalpayment;
				
				if($res2transactionamount != '0')
				{
					$t1 = strtotime($ADate2);
						$t2 = strtotime($res2transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
						$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$resmrdno1 = mysqli_fetch_array($execmrdno1);
						$res1mrdno = $resmrdno1['mrdno'];
						if($snocount == 1)
						{
							$total = $openingbalance + $res2transactionamount;
						}
						else
						{
							$total = $total + $res2transactionamount;
						}
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 + $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 + $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 + $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 + $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 + $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater + $res2transactionamount;
							}
						}
						
						
		 			
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
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>) <?php echo $particulars ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
                            
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
              
           </tr>
			<?php
				
			$res2transactionamount=0;
			$resamount=0;
			
			}
			$res2transactionamount=0;
			$resamount=0;
			
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
			
			}
			
			if($transactiontype=='JOURNAL')
			{
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$exchange_rate=1;
				if($res2['subtype'] == 'Cr')
				{
			$query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr'";
				}
				else
				{
				$query7="SELECT  -1*`debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr'";
				}
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
				$res2transactionamount = $res7['fxamount']/$exchange_rate;				
				$res2transactionamount = $res2transactionamount - $totalpayment;
				
				if($res2transactionamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					if($snocount == 1)
						{
							$total = $openingbalance + $res2transactionamount;
						}
						else
						{
							$total = $total + $res2transactionamount;
						}
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 + $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 + $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 + $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 + $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 + $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater + $res2transactionamount;
							}
						}
						
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
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td> 
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <?php if($res2transactionamount > 0)
			  {
			  ?>     
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
			<?php
			}
			else
			{
				?>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format(-1*$res2transactionamount,2,'.',','); ?></div></td>
				<?php
				}
				?>
               <td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
              
           </tr>
			<?php
						
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
}
	if($transactiontype=='paylatercredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				$exchange_rate=1;
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
						
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
							$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num57 = mysqli_num_rows($exec57);							
							if($num57 != 0)
							{
								$lab = "Lab";
							}
							else
							{
								$lab = "";
							}
							
				$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
							$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num58 = mysqli_num_rows($exec58);							
							if($num58 != 0)
							{
								$rad = "Rad";
							}
							else
							{
								$rad = "";
							}
							
				$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
							$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num59 = mysqli_num_rows($exec59);							
							if($num59 != 0)
							{
								$ser = "Services";
							}
							else
							{
								$ser = "";
							}
						
				if($res6transactionamount != 0)
				{
					
					if($days_between <= 30)
							{
								$totalamount30 = $totalamount30 - $res6transactionamount;							
							}
							else if(($days_between >30) && ($days_between <=60))
							{						
								$totalamount60 = $totalamount60 - $res6transactionamount;
							}
							else if(($days_between >60) && ($days_between <=90))
							{							
								$totalamount90 = $totalamount90 - $res6transactionamount;							
							}
							else if(($days_between >90) && ($days_between <=120))
							{							
								$totalamount120 = $totalamount120 - $res6transactionamount;							
							}
							else if(($days_between >120) && ($days_between <=180))
							{							
								$totalamount180 = $totalamount180 - $res6transactionamount;							
							}
							else
							{							
								$totalamountgreater = $totalamountgreater - $res6transactionamount;							
							}
							
							$snocount = $snocount + 1;
					if($snocount == 1)
						{
							$total = $openingbalance - $res6transactionamount;
						}
						else
						{
							$total = $total - $res6transactionamount;
						}		
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
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
                                <div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6docno; ?>)- Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?> <?php echo $particulars ?></div></td>		
                    <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>	
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="center">
                            <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				
				}
		}
	if($transactiontype=='pharmacycredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				//$docno  = $res2['docno'];
				$exchange_rate=1;
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
					if($snocount == 1)
						{
							$total = $openingbalance - $res6transactionamount;
						}
						else
						{
							$total = $total - $res6transactionamount;
						}
					
					
					if($days_between <= 30)
							{
								$totalamount30 = $totalamount30 - $res6transactionamount;							
							}
							else if(($days_between >30) && ($days_between <=60))
							{						
								$totalamount60 = $totalamount60 - $res6transactionamount;
							}
							else if(($days_between >60) && ($days_between <=90))
							{							
								$totalamount90 = $totalamount90 - $res6transactionamount;							
							}
							else if(($days_between >90) && ($days_between <=120))
							{							
								$totalamount120 = $totalamount120 - $res6transactionamount;							
							}
							else if(($days_between >120) && ($days_between <=180))
							{							
								$totalamount180 = $totalamount180 - $res6transactionamount;							
							}
							else
							{							
								$totalamountgreater = $totalamountgreater - $res6transactionamount;							
							}
							
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
				   <td width="6%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
							<td width="32%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6billnumber; ?>)- Cr.Note : Pharma <?php echo $particulars ?></div></td> 
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   
				  <td class="bodytext31" valign="center"  align="center">
                            <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				}
				}
	if($transactiontype=='PAYMENT')
		{
		$billnum=$res2['billnumber'];
$squery="select billnumber from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit') and billnumber='$billnum'";
$exequery=mysqli_query($GLOBALS["___mysqli_ston"], $squery);
$numquery=mysqli_num_rows($exequery);
			if($numquery>0)
			
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res2['groupdate'];
				$res3patientname = $res2['patientname'];
				$res3patientcode = $res2['patientcode'];
				$res3visitcode = $res2['visitcode'];
				$res3billnumber = $res2['billnumber'];
				$res3docno = $res2['auto_number'];
				$res3transactionmode = $res2['subtype'];
				$res3transactionnumber = $res2['accountname'];
				$particulars = $res2['particulars'];
				if($res2patientname=='')
						{
							$res2patientname='On Account';
						}
				$exchange_rate=1;

			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	 
			 	 $res3transactionamount = $res3transactionamount - $totalonaccountpayment;
				if($snocount == 1)
						{
							$total = $openingbalance - $res3transactionamount;
						}
						else
						{
							$total = $total - $res3transactionamount;
						}
				if($res3transactionamount != 0)
				{
								
				if($days_between <= 30)
				{
				
				$totalamount30 = $totalamount30 - $res3transactionamount;
				
				}
				else if(($days_between >30) && ($days_between <=60))
				{
				
				$totalamount60 = $totalamount60 - $res3transactionamount;
				
				}
				else if(($days_between >60) && ($days_between <=90))
				{
				
				$totalamount90 = $totalamount90 - $res3transactionamount;
				
				}
				else if(($days_between >90) && ($days_between <=120))
				{
				
				$totalamount120 = $totalamount120 - $res3transactionamount;
				
				}
				else if(($days_between >120) && ($days_between <=180))
				{
				
				$totalamount180 = $totalamount180 - $res3transactionamount;
				
				}
				else
				{
				
				$totalamountgreater = $totalamountgreater - $res3transactionamount;
				
				}
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
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res3patientname; ?> (<?php echo $res3patientcode; ?>, <?php echo $res3visitcode; ?>, <?php echo $res3billnumber; ?>) <?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php //echo number_format($res3transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format(abs($res3transactionamount),2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
			}
			}
			}
			
			}
			
			?>
               <tr>
        <td>&nbsp;</td>
      </tr>
            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
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
         	<?php
			
	
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsupplieranum=$searchsupplieranum&&searchsuppliercode=$searchsuppliercode";
			
			?>
		    <td class="bodytext31" valign="center"  align="right"><a href="print_accountstatement.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			            
               </tr>
			  </table>
            <?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
