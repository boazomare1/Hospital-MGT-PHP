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

ob_start();

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;

$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;
		  
$totalamount302 = 0;
$totalamount602 = 0;
$totalamount902 = 0;
$totalamount1202 = 0;
$totalamount1802 = 0;
$totalamountgreater2 = 0;
$returnamount451=0;
$exchange_rate=1;

//include ("autocompletebuild_supplier1.php");

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-1 month')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
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
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Supplier.');
return false;
}
}
</script>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 
<script type="text/javascript">
/*window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}*/

$(document).ready(function(e) {
	$('#searchsuppliername').autocomplete({
		
	source:"ajaxsupplieraccount_nm.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			$("#searchsuppliercode").val(accountid);
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
		
		
              <form name="cbform1" method="post" action="reportsupplier21_jeet.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Statement - By Supplier</strong></td>
              </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></span></td>
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="16" bgcolor="#ecf0f5" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
			$arraysuppliername = $_REQUEST['searchsuppliername'];
			$arraysuppliername = trim($arraysuppliername);
			$arraysuppliercode = $_REQUEST['searchsuppliercode'];
		
					
			}
				?>
 				
            </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="24%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Cheque No </strong></td>
              <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Supplier Invoice no.</strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>System Invoice no.</strong></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
            </tr>
			<?php
		
			// $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
			//$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			//$res1 = mysql_fetch_array($exec1);
			//$openingbalance = $res1['openingbalance'];	
			$openingbalance =0;
			$id = $arraysuppliercode;
			$query_acc = "select * from master_accountname where id = '$id'";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res1 = mysqli_fetch_array($exec1);
				  $currency = $res1['currency'];
				  $cur_qry = "select * from master_currency where currency like '$currency'";
				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res21 = mysqli_fetch_array($exec21);
				  $exchange_rate = $res21['rate'];
				  if($exchange_rate == 0.00)
				  {
					  $exchange_rate=1;
				  }
				  //$exchange_rate;
				$querycr1op = "SELECT sum(-1*`transactionamount`) as payables, suppliercode as code, CONCAT('Payment - ',remarks) as name, docno as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `transactiondate` < '$ADate1'
						 
						 UNION ALL SELECT sum(-1*`totalamount`) as payables,suppliercode as code, CONCAT('Return - ',suppliername) as name, billnumber as docno, entrydate as date,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber NOT LIKE 'SPCA%' AND `entrydate` < '$ADate1'
						 
						 UNION ALL SELECT sum(-1*`debitamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'
						 
						 UNION ALL SELECT sum(-1*`transactionamount`) as payables,expensecoa as code, remarks as name, docnumber as docno, transactiondate as date, chequenumber as chequenum FROM `expensesub_details` WHERE `expensecoa` = '$id' AND transactionmode <> 'ADJUSTMENT' AND transactiondate < '$ADate1'
						
						 UNION ALL SELECT sum(-1*`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date, 'Opening Balance' as chequenum FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'
						
						UNION ALL SELECT sum(`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date, 'Opening Balance' as chequenum FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1' and payablestatus ='1'
						
						 UNION ALL SELECT sum(`transactionamount`) as payables, suppliercode as code, CONCAT('Purchase - ',suppliername) as name, billnumber as docno, transactiondate as date,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` < '$ADate1'
						 UNION ALL SELECT sum(`creditamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'
						 UNION ALL SELECT sum(-1*`totalamount`) as payables,suppliercode as code, CONCAT('Payable Credit - ',suppliername) as name, billnumber as docno, entrydate as date,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber LIKE 'SPCA%' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
							$payables = $rescr1['payables'];
							$payables = $payables / $exchange_rate;
						    $openingbalance += $payables;
						}
		 
			
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
				
              <td width="6%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="24%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="12%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="6%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="10%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>
			
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
$totalamount451=0;
$res85supplierbillnumber='';
		   	 $query21 = "select * from master_supplier where suppliercode = '$arraysuppliercode' and   status <>'DELETED' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			  $res21accountname = $res21['suppliername'];
			$supplieranum = $res21['auto_number'];
			 ?>
         
			<tr bgcolor="#ffffff">
            <td colspan="17"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr>
		
		    <?php		
		
		 $query45 = "select transactiondate as groupdate,suppliername,suppliercode,sum(transactionamount) as totalfxamount,billnumber, auto_number from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber ";
		$query45 .= " union all select a.billdate as groupdate,a.patientname,a.patientcode,a.transactionamount as totalfxamount,a.billnumber,a.auto_number from paymentmodecredit as a join master_transactionpharmacy as b on (a.billnumber = b.docno) where a.source = 'supplierpaymententry' and b.suppliercode = '$arraysuppliercode' and a.billdate between '$ADate1' and '$ADate2'  group by a.billnumber";
		  $query45 .= " union all select entrydate as groupdate,suppliername,suppliercode,sum(subtotal) as totalfxamount,billnumber,grnbillnumber from purchasereturn_details where suppliercode = '$arraysuppliercode' and entrydate between '$ADate1' and '$ADate2' and billnumber not like 'SPCA%' group by billnumber,grnbillnumber";
		  $query45 .= " UNION ALL SELECT entrydate as groupdate,username,locationcode,sum(`openbalanceamount`) as totalfxamount, docno as billnumber,auto_number FROM `openingbalanceaccount` WHERE `accountcode` = '$arraysuppliercode' AND `entrydate` between '$ADate1' and '$ADate2'";
		    $query45 .= " union all select entrydate as groupdate,username,locationcode,sum(creditamount-debitamount) as totalfxamount,docno as billnumber,auto_number from master_journalentries where ledgerid = '$arraysuppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno order by groupdate asc";

//		echo $query45;
		   
		  $exec4512 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
		//  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysqli_fetch_array($exec4512))
		  {
     	  $res45billnumber = $res45['billnumber'];
		  $res45autonum = $res45['auto_number'];
		  $res45transactiondate=$res45['groupdate'];
		  $res45transactionamount=$res45['totalfxamount'];
		  
		
		   $query451= "select transactiondate,sum(transactionamount) as transactionamount,billnumber from master_transactionpharmacy where auto_number='$res45autonum' and  billnumber='$res45billnumber' and  suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber";
		  
		  $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res451=mysqli_fetch_array($exec451))
		{  
		  $num451 = mysqli_num_rows($exec451);
		  if($num451>0)
		  {
		  
	  $res451transactiondate = $res451['transactiondate'];
		$res451transactionamount = $res451['transactionamount'];
		  $res451billnumber=$res451['billnumber'];
		  
		  $query452= "select sum(transactionamount) as transactionamount from master_transactionpharmacy where  billnumber='$res451billnumber' and  suppliercode = '$arraysuppliercode'  and transactiontype = 'PAYMENT' and recordstatus='allocated' group by billnumber";
		  $exe452=mysqli_query($GLOBALS["___mysqli_ston"], $query452);
		  $res452=mysqli_fetch_array($exe452);
		  
		 $totalpayment=$res452['transactionamount'];
		  
		  $returnamount = 0;
		  $query652 = "select sum(totalamount) as totalfxamount from purchasereturn_details where suppliercode = '$arraysuppliercode' and  grnbillnumber='$res451billnumber'
		  UNION ALL select sum(subtotal) as totalfxamount from purchasereturn_details where suppliercode = '$arraysuppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res451billnumber' and transactiontype = 'PURCHASE')";
		  $exe652=mysqli_query($GLOBALS["___mysqli_ston"], $query652) or die("Error in query652".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res652=mysqli_fetch_array($exe652))
		  {
		  $returnamount+=$res652['totalfxamount'];
		  }
		if($snocount==0)
		{
			$totalamount420 =$res451transactionamount-($totalpayment + $returnamount)+$openingbalance;
}
else
{
$totalamount420 =$res451transactionamount-($totalpayment + $returnamount);
}
			$totalamount451 =$totalamount420;	
			$totalamount451 = $totalamount451 / $exchange_rate;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res451transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		  
		  if($days_between <= 30)
		  {
		
		  $totalamount302 = $totalamount302 + $totalamount451;
		
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount602 = $totalamount602 + $totalamount451;
		
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount902 = $totalamount902 + $totalamount451;
		
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		
		  $totalamount1202 = $totalamount1202 + $totalamount451;
		
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		
		  $totalamount1802 = $totalamount1802 + $totalamount451;
		
		  }
		  else
		  {
		
		  $totalamountgreater2 = $totalamountgreater2 + $totalamount451;
		  }
	
		   }
		
		}
		  
		  
		   $query4511= "select auto_number from master_transactionpharmacy where auto_number='$res45autonum' and  billnumber='$res45billnumber' and  suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE'";
		  
		  $exec4511 = mysqli_query($GLOBALS["___mysqli_ston"], $query4511) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num4511 = mysqli_num_rows($exec4511);
		  if($num4511>0)
		  {
		  
		  $res45transactiondate = $res45['groupdate'];
	      $res45patientname = $res45['suppliername'];
		  $res45patientcode = $res45['suppliercode'];
		  $res45transactionamount = $res45['totalfxamount'];
		  $res45transactionamount = $res45transactionamount / $exchange_rate;
		  
		  $query85 = "select deliverybillno from purchase_details where billnumber = '$res45billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		  $exec85 = mysqli_query($GLOBALS["___mysqli_ston"], $query85) or die ("Error in Query85".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  $res85 = mysqli_fetch_array($exec85);
		
		  //$res85supplierbillnumber = $res85['deliverybillno'];
		  
		  $query852 = "select supplierbillnumber from master_purchase where billnumber = '$res45billnumber' ";
		  $exec852 = mysqli_query($GLOBALS["___mysqli_ston"], $query852) or die ("Error in Query852".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  $res852 = mysqli_fetch_array($exec852);
		  
		  $res85supplierbillnumber = $res852['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		   $snocount = $snocount + 1;
		   
		   if($snocount == 1)
		  {
		   $total = $openingbalance +$res45transactionamount ;
		  }
		  else
		  {
		  $total = $total + $res45transactionamount;
		  }
		  if ($res45transactionamount == '')
		  {
		  $res45transactionamount = '0.00';
		  }
		  else
		  {
		  $res45transactionamount = $res45['totalfxamount'];
		  $res45transactionamount = $res45transactionamount / $exchange_rate;
		  }
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $res45transactionamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $res45transactionamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $res45transactionamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $res45transactionamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $res45transactionamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $res45transactionamount;
		  }
		  }
		  if($snocount==1)
		  {
		 $totalat = $totalat + $res45transactionamount + $openingbalance;
	}
	else
	{
	$totalat = $totalat + $res45transactionamount;
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
	       
			?>
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res45transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Purchase'; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo ''; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res85supplierbillnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res45billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res45transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }
		   ?>
			
			<?php
		  $query51 = "select auto_number from paymentmodecredit where billnumber='$res45billnumber'";
		  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num = mysqli_num_rows($exec51);
//$num=0;
		//  while ($res51 = mysql_fetch_array($exec51))
		if($num>0)
		  {
		  $paymentdocno = $res45['billnumber'];
		  $res5transactionamount = $res45['totalfxamount'];
		  $res5transactiondate = $res45['groupdate'];
		  
		   $query5 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysqli_fetch_array($exec5))
		  {
     	  
	      $res5patientname = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  $res5transactionamount = $res5['transactionamount'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  
		  $query15 = "select * from master_purchase where billnumber = '$res5billnumber' ";
		  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		   $res15 = mysqli_fetch_array($exec15);
		  
		  $res15supplierbillnumber = $res15['supplierbillnumber'];
		   $snocount = $snocount + 1;
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		  
		  $res5transactionamount = $res5transactionamount / $exchange_rate;
		  
		  	  if($days_between <= 30)
		  {
		  $totalamount30 = $totalamount30 - $res5transactionamount;
		  
		 //echo $totalamount30;
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  $totalamount60 = $totalamount60 - $res5transactionamount;
		 
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  $totalamount90 = $totalamount90 - $res5transactionamount;
		  
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $res5transactionamount;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $res5transactionamount;
		 
		  }
		  else
		  {
		  
		  $totalamountgreater = $totalamountgreater - $res5transactionamount;
		  
		  }
		  
		
		 
		  $total = $res5transactionamount + $res5openingbalance;
		 if($snocount=='1')
		 {
		  $totalat = $totalat + $openingbalance - $total;
	}
	else
	{
	 $totalat = $totalat - $total;
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Payment ('.$res5transactionmode.','.$res5remarks; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res5chequenumber; ?></td>
			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res5docnumber;?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res5transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }
		   }
		   }
		   ?>
           
           <?php
		      
		  $query65 = "select auto_number from openingbalanceaccount where docno='$res45billnumber'";
		  $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die ("Error in Query65".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num65 = mysqli_num_rows($exec65);
		//  while ($res65 = mysql_fetch_array($exec65))
		//$num=0;
		if($num65>0)
		  {
     	  $res65transactiondate = $res45['groupdate'];
	      $res65patientname = $res45['suppliername']; 
		  $res65patientcode = $res45['suppliercode'];
		  $res65subtotal= $res45['totalfxamount'];
		  $res65billnumber = '';
		  $res65grnnumber = $res45['billnumber'];
		  $res65subtotal = $res65subtotal / $exchange_rate;
		  $totalatret = $totalat - $res65subtotal ;
		  
		  
		  $snocount = $snocount + 1;
		    $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res65transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		    
			if($snocount=='1')
			{
			$totalat = $totalat + $openingbalance - $res65subtotal; 
			}
			
			else
			{
			$totalat = $totalat - $res65subtotal; 
			}
		  
		  if($days_between <= 30)
		  {
		  $totalamount30 = $totalamount30 - $res65subtotal;
		  
		 //echo $totalamount30;
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  $totalamount60 = $totalamount60 - $res65subtotal;
		 
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  $totalamount90 = $totalamount90 - $res65subtotal;
		  
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $res65subtotal;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $res65subtotal;
		 
		  }
		  else
		  {
		  
		  $totalamountgreater = $totalamountgreater - $res65subtotal;
		  
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res65transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Opening Debit' ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res65billnumber;?></td>
			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res65grnnumber;?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res65subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  
		   ?>
		   
		   <?php
		      
		  $query65 = "select auto_number from purchasereturn_details where billnumber='$res45billnumber'";
		  $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die ("Error in Query65".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num65 = mysqli_num_rows($exec65);
		//  while ($res65 = mysql_fetch_array($exec65))
		//$num=0;
		if($num65>0)
		  {
     	  $res65transactiondate = $res45['groupdate'];
	      $res65patientname = $res45['suppliername']; 
		  $res65patientcode = $res45['suppliercode'];
		  $res65subtotal= $res45['totalfxamount'];
		  $res65billnumber = $res45['billnumber'];
		  $res65grnnumber = $res45['auto_number'];
		  $res65subtotal = $res65subtotal / $exchange_rate;
		  $totalatret = $totalat - $res65subtotal ;
		  
		  
		  $snocount = $snocount + 1;
		     $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res65transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		    
			if($snocount=='1')
			{
			$totalat = $totalat + $openingbalance - $res65subtotal; 
			}
			
			else
			{
			$totalat = $totalat - $res65subtotal; 
			}
		  
		  if($days_between <= 30)
		  {
		  $totalamount30 = $totalamount30 - $res65subtotal;
		  
		 //echo $totalamount30;
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  $totalamount60 = $totalamount60 - $res65subtotal;
		 
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  $totalamount90 = $totalamount90 - $res65subtotal;
		  
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $res65subtotal;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $res65subtotal;
		 
		  }
		  else
		  {
		  
		  $totalamountgreater = $totalamountgreater - $res65subtotal;
		  
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res65transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Towards Return' ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res65billnumber;?></td>
			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res65grnnumber;?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res65subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   }  
		   ?>
		  
			<?php
			$resjournalcreditpayment = 0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query69 = "select auto_number from master_journalentries where docno='$res45billnumber'";
		  $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die ("Error in Query69".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num69 = mysqli_num_rows($exec69);
		//  while ($res69 = mysql_fetch_array($exec69))
		if($num69>0)
		  {
     	  $journalcredit = $res45['totalfxamount'];
		  $journaldate = $res45['groupdate'];
		  $jusername = $res45['suppliername'];
		  $jdocno = $res45['billnumber'];
		  
		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$journaldate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $days_between = intval($days_between);
		  
		  $resjournalcreditpayment = $journalcredit;
		  $resjournalcreditpayment = $resjournalcreditpayment / $exchange_rate;
		
		  if($resjournalcreditpayment != 0)
		  {
		  $totalat = $totalat + $resjournalcreditpayment;
		 
		 	  
		  if($days_between <= 30)
		  {
		 
		  $totalamount302 = $totalamount302 + $resjournalcreditpayment;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		 
		  $totalamount602 = $totalamount602 + $resjournalcreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount902 = $totalamount902 + $resjournalcreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount1202 = $totalamount1202 + $resjournalcreditpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount1802 = $totalamount1802 + $resjournalcreditpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater2 = $totalamountgreater2 + $resjournalcreditpayment;
		  
		  }
		   $snocount = $snocount + 1;
			if($snocount=='1')
			{
			$totalat=$totalat+$openingbalance;
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
                <div class="bodytext31"><?php echo $journaldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'Journal Entry Credit'.' - '.ucfirst($jusername); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $jdocno;?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php if($journalcredit<0){ echo number_format(abs($journalcredit),2,'.',','); } ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php if($journalcredit>=0){ echo number_format(abs($journalcredit),2,'.','');}?></div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="center"><?php echo $days_between;?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalat,2,'.',','); ?></div></td>
           </tr>
			
		  <?php
		  }
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
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
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
			$grandtotal = $totalat;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount302,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount602,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount902,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount1202,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount1802,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater2,2,'.',','); ?></td>
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalat,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right"> 
                 <a target="_blank" href="print_supplierreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&name=<?php echo $arraysuppliername; ?>&&code=<?php echo $arraysuppliercode; ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>
                </td> 
				<td class="bodytext31" valign="center"  align="right"> 
                 <a target="_blank" href="print_supplierreportpdf.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&code=<?php echo $arraysuppliercode; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a>
                </td> 
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
           
		   	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
           
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
