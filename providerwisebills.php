<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-01');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$subtype_ano='';
$res1mrdno ='';
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
alert('Please Select Provider Name.');
return false;
}
else
{
if((document.getElementById("searchsuppliercode").value == "")||(document.getElementById("searchsuppliercode").value == " "))
{
alert('Please Select Provider Name.');
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
		
		
              <form name="cbform1" method="post" action="providerwisebills.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Provider Statement</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Provider </td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="85%" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"> </span></td>  
            </tr>
		    <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr>
				<td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<?php
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsupplieranum=$searchsupplieranum&&searchsuppliercode=$searchsuppliercode";
				?>
				<td class="bodytext31" valign="center"  align="right"><a href="print_providerwisebiils.php?<?php echo $urlpath; ?>" target="_blank" ><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> Patient Name </strong></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.No</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Provider</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Scheme</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No.</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Claim No.</strong></div></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> Bill number </strong></td>
				<td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
			</tr>
			<?php
			
			$openingbalance='0';
			
			$id =$searchsuppliercode;
				
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
		  
		$queryunion="SELECT groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum' and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'
		
		union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'  and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'
		
		union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylaterdebit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'

		union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')


		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars, selecttype as transactionmode, selecttype as subtypeano, '' as chequenumber, transactionamount as fxamount, auto_number, vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 	$resamount=0;
			$res2transactionamount=0;
			$transactiontype = $res2['transactiontype'];
			$vit_code = $res2['visitcode'];
	
			
			$query3 = "select memberno,accountfullname from master_visitentry where visitcode = '$vit_code'
			UNION ALL select memberno,accountfullname from master_ipvisitentry where visitcode = '$vit_code'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$memberno = $res3['memberno'];
			$schemefromvisit=$res3['accountfullname'];
			
			$query31 = "select preauthcode from billing_ip where visitcode = '$vit_code'
			UNION ALL select preauthcode from billing_paylater where visitcode = '$vit_code'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$preauthcode = $res31['preauthcode'];
			
			
			
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
			$total = $total + $res2transactionamount;
					
						
		 			
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
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>   
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
				$totalpayment = 0;
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

				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				if($res2['subtypeano'] == 'Cr')
				{
				$query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr' and auto_number  = '".$res2['auto_number']."'";
				}
				else
				{
				$query7="SELECT  `debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr' and auto_number  = '".$res2['auto_number']."'";
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
					
					$total = $total + $res2transactionamount;
					
						
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
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2transactiondate; ?></div></td> 
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2billnumber; ?></div></td>   
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
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

////////////////// CREDIT AND DEBIT ////////////////////

		if($transactiontype=='paylaterdebit')
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
        $ref_no = $res2['accountname'];


        $querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
        $execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resmrdno1 = mysqli_fetch_array($execmrdno1);
        $res1mrdno = $resmrdno1['mrdno'];
        $res2mrdno='';
        
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
		$res6transactionamount = $res6transactionamount + $totalpaylatercreditpayment;
        
        if($res6transactionamount != 0)
        {
        $snocount = $snocount + 1;

		  $total = $total + $res6transactionamount;
	
          
        
              
              //$snocount = $snocount + 1;
              
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
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?></div></td>    
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>  
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
			
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>	
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
			<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
		</tr>
        <?php
        
        $res6transactionamount=0;
        $respaylatercreditpayment=0;
        
        }
    }


////////////////// CREDIT AND DEBIT ////////////////////

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

			$res6docno1 = explode("-", $res6docno);
			$res6docno2 = $res6docno1[0];
			if($res6docno2=='CRN'){
			$display_head='Credit Notes';
			}else{
			$display_head='Cr.Note :';
			}
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;


			$querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
			$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmrdno1 = mysqli_fetch_array($execmrdno1);
			$res1mrdno = $resmrdno1['mrdno'];
			$res2mrdno='';
						
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
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
				$snocount = $snocount + 1;
				$total = $total + $res6transactionamount;
							
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
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?> </div></td>		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>	
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>	
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
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

        
				$querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
				$snocount = $snocount + 1;


				$total = $total + $res6transactionamount;
						
					
							
				//$snocount = $snocount + 1;
							
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
					<td width="6%"class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td width="32%"class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?> </div></td> 
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
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
				if($res3patientname=='')
				{
					$res3patientname='On Account';
				}
				
			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	 $snocount = $snocount + 1;

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
								
				
				//$snocount = $snocount + 1;
			
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
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientname; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3docno; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format(abs($res3transactionamount),2,'.',','); ?></div></td>
			</tr>
				<?php
			}
			}
			}
			
			}
			
			?>
              
            

		<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total</strong></td>
			<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
			
		</tr>
            <?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
