<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';
$res2cashamount1 ='';
$res2cardamount1 = '';
$res2chequeamount1 = '';
$res2onlineamount1 ='';
$cashamount2 = '0.00';
$cardamount2 = '0.00';
$chequeamount2 = '0.00';
$onlineamount2 = '0.00';
$total1 = '0.00';
$billnumber = '';
$netcashamount = '0.00';
$netcardamount = '0.00';
$netchequeamount = '0.00';
$netonlineamount = '0.00';

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$cbcustomername = $_REQUEST['cbcustomername'];
	
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
	
	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }
	//$paymenttype = $_REQUEST['paymenttype'];
	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }
	//$billstatus = $_REQUEST['billstatus'];

}
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

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers.js"></script>
<script type="text/javascript">
window.onload = function () 
{
//alert ('hai');
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<body>
<table width="1901" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1134">
		
		
              <form name="cbform1" method="post" action="daybookreportuser.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Day Book Report </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
			  <td bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">               </td>
              </tr>
           
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="867" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31">
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbcustomername = $_REQUEST['cbcustomername'];
					//$patientfirstname =  $cbcustomername;
					
					$customername = $_REQUEST['cbcustomername'];
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}
				?> 			             </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Date </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>
              <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash </strong></td>
              <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Card </strong></td>
              <td width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Cheque </strong></td>
				<td  width="12%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
				<td width="5%"  align="right" valign="center" bgcolor="#ecf0f5">&nbsp;</td>
				<td width="16%"  align="right" valign="center" bgcolor="#ecf0f5">&nbsp;</td>

			  
			  
			<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$cbcustomername=trim($cbcustomername);
		  
			
			$query31 = "select* from master_employee where shift = 'YES' and username like '%$cbcustomername%' and status <>'DELETED'";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res31 = mysqli_fetch_array($exe31))
			{
			$res21username = $res31["username"];
			
			if( $res21username != '')
			{
			?>
            <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo strtoupper ($res21username);?></strong></td>
              </tr>
			  
			  <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];*/
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalcashamount1 = '0.00';
			$totalcardamount1 = '0.00';
			$totalchequeamount1 = '0.00';
			$totalonlineamount1 = '0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query2 = "select * from master_transactionpaynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res2 = mysqli_fetch_array($exec2))
			{
			$res2billnumber = $res2['billnumber'];
			$res2transactiondate = $res2['transactiondate'];
			
			$query3 = "select * from master_transactionpaynow where billnumber = '$res2billnumber'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3cashamount1 = $res3['cashamount'];
			$res3cardamount1 = $res3['cardamount'];
			$res3creditamount1 = $res3['creditamount'];
			$res3chequeamount1 = $res3['chequeamount'];
			$res3onlineamount1 = $res3['onlineamount'];
			$res3transactionamount = $res3['transactionamount'];
			
			$totalcashamount1 = $totalcashamount1 + $res3cashamount1;
			$totalcardamount1 = $totalcardamount1 + $res3cardamount1;
			$totalchequeamount1 = $totalchequeamount1 + $res3chequeamount1;
			$totalonlineamount1 = $totalonlineamount1 + $res3onlineamount1;    

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		if($res3transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			   <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res3cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res3cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res3chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res3onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
              </tr>
			<?php
			}
			}
			?>
			  
			  <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount2 = '0.00';
			$totalcardamount2 = '0.00';
			$totalchequeamount2 = '0.00';
			$totalonlineamount2 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query23 = "select * from master_billing where username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res23 = mysqli_fetch_array($exec23))
			{
			$res23billnumber = $res23['billnumber'];
			$res23billingdatetime = $res23['billingdatetime'];
			
			$query33 = "select * from master_billing where billnumber = '$res23billnumber'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res33 = mysqli_fetch_array($exec33);
			$res33cashamount1 = $res33['cashamount'];
			$res33cardamount1 = $res33['cardamount'];
			$res33creditamount1 = $res33['creditamount'];
			$res33chequeamount1 = $res33['chequeamount'];
			$res33onlineamount1 = $res33['onlineamount']; 
			$res33transactionamount = $res33['totalamount'];
			
			$totalcashamount2 = $totalcashamount2 + $res33cashamount1;
			$totalcardamount2 = $totalcardamount2 + $res33cardamount1;
			$totalchequeamount2 = $totalchequeamount2 + $res33chequeamount1;
			$totalonlineamount2 = $totalonlineamount2 + $res33onlineamount1;  
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res33transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res23billingdatetime; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res23billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res33cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res33cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res33chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res33onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5" align="right">&nbsp;</td>
              </tr>
			  
			<?php
			 }	
			 }
			?>
			
			 <?php 
			/*$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount3 = '0.00';
			$totalcardamount3 = '0.00';
			$totalchequeamount3 = '0.00';
			$totalonlineamount3 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query24 = "select * from master_transactionexternal where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res24 = mysqli_fetch_array($exec24))
			{
			$res24billnumber = $res24['billnumber'];
			$res24transactiondate = $res24['transactiondate'];
			
			$query34 = "select * from master_transactionexternal where billnumber = '$res24billnumber'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res34 = mysqli_fetch_array($exec34);
			$res34cashamount1 = $res34['cashamount'];
			$res34cardamount1 = $res34['cardamount'];
			$res34creditamount1 = $res34['creditamount'];
			$res34chequeamount1 = $res34['chequeamount'];
			$res34onlineamount1 = $res34['onlineamount']; 
			$res34transactionamount = $res34['transactionamount'];
			
			$totalcashamount3 = $totalcashamount3 + $res34cashamount1;
			$totalcardamount3 = $totalcardamount3 + $res34cardamount1; 
			$totalchequeamount3 = $totalchequeamount3 + $res34chequeamount1;
			$totalonlineamount3 = $totalonlineamount3 + $res34onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res34transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res24transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res24billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res34cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res34cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res34chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res34onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount4 = '0.00';
			$totalcardamount4 = '0.00';
			$totalchequeamount4 = '0.00';
			$totalonlineamount4 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query25 = "select * from refund_paynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res25 = mysqli_fetch_array($exec25))
			{
			$res25billnumber = $res25['billnumber'];
			$res25transactiondate = $res25['transactiondate'];
			
			$query35 = "select * from refund_paynow where billnumber = '$res25billnumber'";
			$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res35 = mysqli_fetch_array($exec35);
			$res35cashamount1 = $res35['cashamount'];
			$res35cardamount1 = $res35['cardamount'];
			$res35creditamount1 = $res35['creditamount'];
			$res35chequeamount1 = $res35['chequeamount'];
			$res35onlineamount1 = $res35['onlineamount'];
			$res35transactionamount = $res35['transactionamount'];
			
			$totalcashamount4 = $totalcashamount4 + $res35cashamount1;
			$totalcardamount4 = $totalcardamount4 + $res35cardamount1;
			$totalchequeamount4 = $totalchequeamount4 + $res35chequeamount1;
			$totalonlineamount4 = $totalonlineamount4 + $res35onlineamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res35transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res25transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res25billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(- $res35cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format(- $res35cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format(- $res35chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>
              </tr>
			<?php
			 }	
			 }
			?>
			 <?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount5 = '0.00';
			$totalcardamount5 = '0.00';
			$totalchequeamount5 = '0.00';
			$totalonlineamount5 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query26 = "select * from master_transactionadvancedeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res26 = mysqli_fetch_array($exec26))
			{
			$res26billnumber = $res26['docno'];
			$res26transactiondate = $res26['transactiondate'];
			
			$query36 = "select * from master_transactionadvancedeposit where docno = '$res26billnumber'";
			$exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res36 = mysqli_fetch_array($exec36);
			$res36cashamount1 = $res36['cashamount'];
			$res36cardamount1 = $res36['cardamount'];
			$res36creditamount1 = $res36['creditamount'];
			$res36chequeamount1 = $res36['chequeamount'];
			$res36onlineamount1 = $res36['onlineamount']; 
			$res36transactionamount = $res36['transactionamount'];
			
			$totalcashamount5 = $totalcashamount5 + $res36cashamount1;
			$totalcardamount5 = $totalcardamount5 + $res36cardamount1; 
			$totalchequeamount5 = $totalchequeamount5 + $res36chequeamount1;
			$totalonlineamount5 = $totalonlineamount5 + $res36onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res36transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res26transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res26billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res36cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res36cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res36chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res36onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount6 = '0.00';
			$totalcardamount6 = '0.00';
			$totalchequeamount6 = '0.00';
			$totalonlineamount6 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query27 = "select * from master_transactionipdeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res27 = mysqli_fetch_array($exec27))
			{
			$res27billnumber = $res27['docno'];
			$res27transactiondate = $res27['transactiondate'];
			
			$query37 = "select * from master_transactionipdeposit where docno = '$res27billnumber' and docno <> ''";
			$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res37 = mysqli_fetch_array($exec37)){
			$res37cashamount1 = $res37['cashamount'];
			$res37cardamount1 = $res37['cardamount'];
			$res37creditamount1 = $res37['creditamount'];
			$res37chequeamount1 = $res37['chequeamount'];
			$res37onlineamount1 = $res37['onlineamount']; 
			$res37transactionamount = $res37['transactionamount'];
			
			$totalcashamount6 = $totalcashamount6 + $res37cashamount1;
			$totalcardamount6 = $totalcardamount6 + $res37cardamount1; 
			$totalchequeamount6 = $totalchequeamount6 + $res37chequeamount1;
			$totalonlineamount6 = $totalonlineamount6 + $res37onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res37transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res27transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res27billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res37cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res37cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res37chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res37onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount7 = '0.00';
			$totalcardamount7 = '0.00';
			$totalchequeamount7 = '0.00';
			$totalonlineamount7 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query28 = "select * from master_transactionip where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res28 = mysqli_fetch_array($exec28))
			{
			$res28billnumber = $res28['billnumber'];
			$res28transactiondate = $res28['transactiondate'];
			
			$query38 = "select * from master_transactionip where billnumber = '$res28billnumber'";
			$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res38 = mysqli_fetch_array($exec38);
			$res38cashamount1 = $res38['cashamount'];
			$res38cardamount1 = $res38['cardamount'];
			$res38creditamount1 = $res38['creditamount'];
			$res38chequeamount1 = $res38['chequeamount'];
			$res38onlineamount1 = $res38['onlineamount']; 
			$res38transactionamount = $res38['transactionamount'];
			
			$totalcashamount7 = $totalcashamount7 + $res38cashamount1;
			$totalcardamount7 = $totalcardamount7 + $res38cardamount1; 
			$totalchequeamount7 = $totalchequeamount7 + $res38chequeamount1;
			$totalonlineamount7 = $totalonlineamount7 + $res38onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res38transactionamount != '0.00')
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res28transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res28billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res38cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res38chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount8 = '0.00';
			$totalcardamount8 = '0.00';
			$totalchequeamount8 = '0.00';
			$totalonlineamount8 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query29 = "select * from master_transactionipcreditapproved where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res29 = mysqli_fetch_array($exec29))
			{
			$res29billnumber = $res29['billnumber'];
			$res29transactiondate = $res29['transactiondate'];
			$res2postingaccount = $res29['postingaccount'];
			
			$query39 = "select * from master_transactionipcreditapproved where billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";
			$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39 = mysqli_fetch_array($exec39);
			$res39cashamount1 = $res39['cashamount'];
			$res39cardamount1 = $res39['cardamount'];
			$res39creditamount1 = $res39['creditamount'];
			$res39chequeamount1 = $res39['chequeamount'];
			$res39onlineamount1 = $res39['onlineamount']; 
			$res39transactionamount = $res39['transactionamount'];
			
			$totalcashamount8 = $totalcashamount8 + $res39cashamount1;
			$totalcardamount8 = $totalcardamount8 + $res39cardamount1; 
			$totalchequeamount8 = $totalchequeamount8 + $res39chequeamount1;
			$totalonlineamount8 = $totalonlineamount8 + $res39onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res39cashamount1 != '0.00')||($res39cardamount1 != '0.00')||($res39chequeamount1 != '0.00')||($res39onlineamount1 != '0.00'))
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res29transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res29billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res39cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res39cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res39chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res39onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			/*//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount9 = '0.00';
			$totalcardamount9 = '0.00';
			$totalchequeamount9 = '0.00';
			$totalonlineamount9 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query40 = "select * from receiptsub_details where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res40 = mysqli_fetch_array($exec40))
			{
			$res40billnumber = $res40['docnumber'];
			$res40transactiondate = $res40['transactiondate'];
			//$res40postingaccount = $res40['postingaccount'];
			
			/*$query39 = "select * from receiptsub_details where billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";
			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());
			$res39 = mysql_fetch_array($exec39);*/
			$res40cashamount1 = $res40['cashamount'];
			$res40cardamount1 = $res40['cardamount'];
			$res40creditamount1 = $res40['creditamount'];
			$res40chequeamount1 = $res40['chequeamount'];
			$res40onlineamount1 = $res40['onlineamount']; 
			$res40transactionamount = $res40['transactionamount'];
			
			$totalcashamount9 = $totalcashamount9 + $res40cashamount1;
			$totalcardamount9 = $totalcardamount9 + $res40cardamount1; 
			$totalchequeamount9 = $totalchequeamount9 + $res40chequeamount1;
			$totalonlineamount9 = $totalonlineamount9 + $res40onlineamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res40cashamount1 != '0.00')||($res40cardamount1 != '0.00')||($res40chequeamount1 != '0.00')||($res40onlineamount1 != '0.00'))
		{
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res40transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $res40billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res40cashamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31"><?php echo number_format($res40cardamount1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res40chequeamount1,2,'.',','); ?></div></td>
				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40onlineamount1,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>
              </tr>
			<?php
			 }
			 }
			?>
			
			<?php
			$totalcashamount = $totalcashamount1 + $totalcashamount2 + $totalcashamount3 - $totalcashamount4 + $totalcashamount5 + $totalcashamount6 + $totalcashamount7 + $totalcashamount8 + $totalcashamount9;
			$totalcardamount = $totalcardamount1 + $totalcardamount2 + $totalcardamount3 - $totalcardamount4 + $totalcardamount5 + $totalcardamount6 + $totalcardamount7 + $totalcardamount8 + $totalcardamount9;
			$totalchequeamount = $totalchequeamount1 + $totalchequeamount2 + $totalchequeamount3 - $totalchequeamount4 + $totalchequeamount5 + $totalchequeamount6 + $totalchequeamount7 + $totalchequeamount8 + $totalchequeamount9;
			$totalonlineamount = $totalonlineamount1 + $totalonlineamount2 +$totalonlineamount3 - $totalonlineamount4 + $totalonlineamount5 + $totalonlineamount6 + $totalonlineamount7 + $totalonlineamount8 + $totalonlineamount8; 
			$netcashamount = $netcashamount + $totalcashamount;
			$netcardamount = $netcardamount + $totalcardamount;
			$netchequeamount = $netchequeamount + $totalchequeamount;
			$netonlineamount = $netonlineamount + $totalonlineamount;
			$grandtotal = $totalcashamount + $totalcardamount + $totalchequeamount + $totalonlineamount; 
			
			if(($totalcashamount != '0.00')||($totalcardamount != '0.00')||($totalchequeamount != '0.00')||($totalonlineamount != '0.00'))
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalcashamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalonlineamount,2,'.',',');?></td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_daybookreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $res21username; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
				<td><a href="print_daybookreportxl.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
			 </tr>
			  
			  
			 <!-- <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Grand Total:</strong></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcashamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcardamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netchequeamount,2,'.',','); ?></td>
			    <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php echo number_format($netonlineamount,2,'.',',');?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                 bgcolor="#ecf0f5">&nbsp;</td>
			    </tr>-->
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			
              <td colspan="2" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total for Payment Modes :</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff" style="mso-number-format:'\@'"><?php echo number_format($grandtotal,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php //echo number_format($totalonlineamount,2,'.',',');?></td>
				</tr>
			  <?php 
			  }
			  }
			  	}		  
						  }
			  ?>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

