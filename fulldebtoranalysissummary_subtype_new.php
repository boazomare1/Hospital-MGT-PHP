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
$totalamount = "0.00";
$totalamount30 = "0.00";
$optotalamount30 = "0.00";
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$snocount = "";
$colorloopcount2="";
$range = "";
$total30="0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total240 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount601 = "0.00";
$totalamount901 = "0.00";
$totalamount1201 = "0.00";
$totalamount1801 = "0.00";
$totalamount2101 = "0.00";
$grandtotalamount1 = "0.00";
$grandtotalamount301 = "0.00";
$grandtotalamount601 = "0.00";
$grandtotalamount901 = "0.00";
$grandtotalamount1201 = "0.00";
$grandtotalamount1801 = "0.00";
$grandtotalamount2101 = "0.00";
$grandtotalamount2401 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount60 = "0.00";
$optotalamount60 = "0.00";
$totalamount601 = "0.00";
$totalamount90 = "0.00";
$optotalamount90 = "0.00";
$totalamount901 = "0.00";
$totalamount120 = "0.00";
$optotalamount120 = "0.00";
$totalamount1201 = "0.00";
$totalamount180 = "0.00";
$optotalamount180 = "0.00";
$optotalamountgreater = "0.00";

$totalamount1801 = "0.00";
$totalamount210 = "0.00";
$totalamount2101 = "0.00";
$totalamount240 = "0.00";
$totalamount2401 = "0.00";
$res21accountnameano='';
$closetotalamount1 = '0';
$closetotalamount301 = '0';
$closetotalamount601 = '0';
$closetotalamount901 = '0';
$closetotalamount1201 = '0';
$closetotalamount1801 = '0';
$closetotalamount2101 = '0';
$closetotalamount2401 = '0';
$total301='0';
$total601='0';
$total901='0';
$total1201='0';
$total1801='0';
$total2401='0';
$total3012='0';
$total6012='0';
$total9012='0';
$total12012='0';
$total18012='0';
$total24012='0';
$total3013='0';
$total6013='0';
$total9013='0';
$total12013='0';
$total18013='0';
$total24013='0';
			 $grandtotoptotalamount30 = 0;
			$grandtotoptotalamount60 = 0;
			$grandtotoptotalamount90 = 0;	
			$grandtotoptotalamount120 = 0;
			$grandtotoptotalamount180 = 0;
			$grandtotalopbal  = 0;
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");
//include ("autocompletebuild_account3.php");
if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }
if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = ""; }
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
<!--<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />-->
<!--<script type="text/javascript" src="js/adddate.js"></script>-->
<!--<script type="text/javascript" src="js/adddate2.js"></script>-->
<script type="text/javascript" src="js/autocomplete_subtype.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
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
<script language="javascript">
function checkfun()
{
/*if(document.getElementById("type").value=='')
{
alert("Please Select a Type");
return false;
} */
return true;
}
function showsub(subtypeano)
{
if(document.getElementById(subtypeano) != null)
{
if(document.getElementById(subtypeano).style.display == 'none')
{
document.getElementById(subtypeano).style.display = '';
}
else
{
document.getElementById(subtypeano).style.display = 'none';
}
}
}
function showaccount(accountano)
{
var accLines =document.getElementsByClassName('acc'+accountano);
for (var i = 0; i < accLines.length; i ++) {
if(accLines[i].style.display == 'none')
{
accLines[i].style.display = '';
}
else
{
accLines[i].style.display = 'none';
}
}
}
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
		
		
              <form name="cbform1" method="post" action="" >
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Full Debtor Analysis Summary</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
			  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="type" id="type">
			  <option value="">Select</option>
			  <?php
			  $query51 = "select * from master_paymenttype where recordstatus <> 'deleted' and paymenttype!='CASH'";
			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res51 = mysqli_fetch_array($exec51))
			  {
			  $paymenttype = $res51['paymenttype'];
			  $manum = $res51['auto_number'];
			  ?>
			  <option value="<?php echo $manum; ?>" <?php if($manum == $type){ echo "selected"; }?>><?php echo $paymenttype; ?></option>
			  <?php
			  }
			  ?>
			  </select>
			  </span></td>
           </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">
              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
			  </span></td>
           </tr>
		 
            
		   
			  <tr>
                      <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                    <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                    	<input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td> -->
                          <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="2000-01-01" type="hidden"  size="10" />
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" onClick="return checkfun();"/>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1300" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Disp. Date</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
                <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
                <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td>
				<td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Pre Auth Code</strong></div></td>

				 <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
            </tr>
			
			<?php
			$selectedType ='';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$grandtotalopbal = 0;
				$grandtotoptotalamount30 = 0;
				$grandtotoptotalamount60  = 0;
				$grandtotoptotalamount90  = 0;
				$grandtotoptotalamount120  = 0;
				$grandtotoptotalamount180   = 0;
				
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
			$searchsuppliername = trim($searchsuppliername);
            
            $selectedType=$type;
			if($type!='') {
				$paymentTypes = array($type);
			}
			else{
			  $query51 = "select auto_number from master_paymenttype where recordstatus <> 'deleted' and paymenttype!='CASH'";
			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $j=0;
			  while($res51 = mysqli_fetch_array($exec51))
			  {
				$paymentTypes[$j]=$res51['auto_number'];
				$j=$j+1;
				
			  }
			}
            foreach ($paymentTypes as $k=>$v) {
			$type = $v;
		 
			$query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";
			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res513 = mysqli_fetch_array($exec513);
			$type = $res513['paymenttype'];
			$typeanum = $res513['auto_number'];
			
			if($searchsubtypeanum1=='')
			{
				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and paymenttype = '$typeanum' and recordstatus <>'DELETED' group by subtype";
			}
			else if($searchsubtypeanum1!='')
			{
				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where paymenttype = '$typeanum' and subtype='$searchsubtypeanum1' and recordstatus <>'DELETED' group by subtype";
			}
			//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 
			$grandopbal = 0;
			$grandopbal30 = 0;
			$grandopbal60 = 0;
			$grandopbal90 = 0;
			$grandopbal120 = 0;
			$grandopbal180 = 0;
			$grandopbal180g = 0;
			
			while($res2212 = mysqli_fetch_array($exec2212))
			{
			$subtypeanum = $res2212['subtype'];
			$sno=1;
			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysqli_fetch_array($query9);
			$subtype = $res9['subtype'];
		 $totoptotalamount30 = 0;
		  $totoptotalamount60 = 0;
		  $totoptotalamount90 = 0;
		  $totoptotalamount120 = 0;
		  $totoptotalamount180 = 0;
		  $totoptotalamountgreater = 0;
		  $subtypeopbal = 0;
			if( $subtypeanum!='')
			{	
			
				$query2211 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";
			}
						//echo $query221;
			$exec2211 = mysqli_query($GLOBALS["___mysqli_ston"], $query2211) or die ("Error in query2211".mysqli_error($GLOBALS["___mysqli_ston"]));
 			 $resnum=mysqli_num_rows($exec2211); 
			while($res2211 = mysqli_fetch_array($exec2211))
			{
			 $res22accountname = $res2211['accountname'];
			$res21accountnameano=$res2211['auto_number'];
			$res21accountname = $res2211['accountname'];
			$res21accountid = $res2211['id'];
			
		 	$querydebit12 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit12 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit12) or die ("Error in querydebit12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numdebit12 = mysqli_num_rows($execdebit12);
					
			//echo $cashamount;
			
			if( $res22accountname != '' && $numdebit12>0)
			{

			$openingbalance='0';





		  $optotalamount30 = 0;
		  $optotalamount60 = 0;
		  $optotalamount90 = 0;
		  $optotalamount120 = 0;
		  $optotalamount180 = 0;
		  $optotalamountgreater = 0;

		//   $opquery = "select fxamount AS fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1' and fxamount <>'0' and billnumber not like 'AOP%'

		//   UNION ALL select transactionamount as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1'  and billnumber like 'AOP%'

		//   UNION ALL SELECT (-1*b.`transactionamount`) as fxamount,b.transactiondate AS transactiondate  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` < '$ADate1'  and b.billnumber!=''

		//   UNION ALL SELECT (-1*`fxamount`) as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano'   and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate < '$ADate1' 
		  
		//   UNION ALL SELECT  (-1*`fxamount`) as fxamount,transactiondate AS transactiondate   FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
		  
		//   UNION ALL SELECT sum(1*`amount`) as fxamount,consultationdate AS transactiondate  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` < '$ADate1'  group by docno
		  
		//   UNION ALL SELECT  (debitamount-creditamount) as fxamount,entrydate AS transactiondate   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` < '$ADate1'  group by docno

		//   UNION ALL SELECT  (-1*discount) as fxamount, `transactiondate` as transactiondate  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1' AND `docno` LIKE 'AR-%' AND transactiontype = 'PAYMENT' AND discount>0 and billnumber!='' and recordstatus='allocated'
		  
		//   ";
		//   //  
		// $opexec = mysql_query($opquery) or die ("Error in OPQuery".mysql_error());
		// while($opres= mysql_fetch_array($opexec)){
		// $opbalance = $opres['fxamount'];
		//  $openingbalance = $openingbalance + $opbalance;
		// $openingtransactiondate = $opres['transactiondate'];
		
		// 			if($opbalance != '0')
		// 			{
		// 			$snocount = $snocount + 1;
		// 			$t1 = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $ADate1) ) ));
		// 			$t1 = strtotime($t1);
		// 			$t2 = strtotime($openingtransactiondate);
		// 			$days_between = ceil(abs($t1 - $t2) / 86400);

		// 			if($days_between <= 30)
		// 			{

		// 					$optotalamount30 = $optotalamount30 + $opbalance;						
							
						
		// 			}
		// 			else if(($days_between >30) && ($days_between <=60))
		// 			{
				
		// 					$optotalamount60 = $optotalamount60 + $opbalance;

						
		// 			}
		// 			else if(($days_between >60) && ($days_between <=90))
		// 			{
			
		// 					$optotalamount90 = $optotalamount90 + $opbalance;
						
		// 			}
		// 			else if(($days_between >90) && ($days_between <=120))
		// 			{
			
		// 					$optotalamount120 = $optotalamount120 + $opbalance;
						
		// 			}
		// 			else if(($days_between >120) && ($days_between <=180))
		// 			{
				
		// 					$optotalamount180 = $optotalamount180 + $opbalance;
							
						
		// 			}
		// 			else
		// 			{

		// 					$optotalamountgreater = $optotalamountgreater + $opbalance;
						
		// 			}

					
		// }
	


		// }

			 $subtypeopbal = $subtypeopbal+ $openingbalance;			
			$totoptotalamount30 = $totoptotalamount30 + $optotalamount30;
			$totoptotalamount60 = $totoptotalamount60 + $optotalamount60;
			$totoptotalamount90 = $totoptotalamount90 + $optotalamount90;	
			$totoptotalamount120 = $totoptotalamount120 + $optotalamount120;
			$totoptotalamount180 = $totoptotalamount180 + $optotalamount180;
			$totoptotalamountgreater = $totoptotalamountgreater + $optotalamountgreater;


			}

			}	

			?>
			<tr bgcolor="#cbdbfa" onClick="showsub(<?=$subtypeanum?>)">
            <td colspan="5"  align="left" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo $subtype; ?> </strong></td>
               <td colspan="3"  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong>Opening Balance Total:</td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($subtypeopbal,2,'.',','); ?></strong></td>
                 <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount30,2,'.',','); ?></strong></td>
               <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount60,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount90,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount120,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount180,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamountgreater,2,'.',','); ?></strong></td>        
            </tr> 						
			
			
			
			<tbody id="<?=$subtypeanum?>" style="display:none">
			<?php
			if( $subtypeanum!='')
			{
				 $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";
			}
			//echo $query221;
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			 $resnum=mysqli_num_rows($exec221); 
			while($res221 = mysqli_fetch_array($exec221))
			{
			
			 $res22accountname = $res221['accountname'];
			$res21accountnameano=$res221['auto_number'];
			$res21accountname = $res221['accountname'];
			$res21accountid = $res221['id'];
			
		 	$querydebit1 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die ("Error in Querydebit1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numdebit1 = mysqli_num_rows($execdebit1);
					
			//echo $cashamount;
			

			if( $res22accountname != '' && $numdebit1>0)
			{
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
			
				
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		  $snoln=1;
/*
		  $optotalamount30 = 0;
		  $optotalamount60 = 0;
		  $optotalamount90 = 0;
		  $optotalamount120 = 0;
		  $optotalamount180 = 0;
		  $optotalamountgreater = 0;
		 $subtypeopbal = 0;

		  $opquery = "select fxamount AS fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1' and fxamount <>'0' and billnumber not like 'AOP%'

		  UNION ALL select transactionamount as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1'  and billnumber like 'AOP%'

		  UNION ALL SELECT (-1*b.`transactionamount`) as fxamount,b.transactiondate AS transactiondate  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` < '$ADate1'  and b.billnumber!=''

		  UNION ALL SELECT (-1*`fxamount`) as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano'   and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate < '$ADate1' 
		  
		  UNION ALL SELECT  (-1*`fxamount`) as fxamount,transactiondate AS transactiondate   FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
		  
		  UNION ALL SELECT (1*`amount`) as fxamount,consultationdate AS transactiondate  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` < '$ADate1'  group by docno
		  
		  UNION ALL SELECT  (debitamount-creditamount) as fxamount,entrydate AS transactiondate   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` < '$ADate1'  group by docno";
		$opexec = mysql_query($opquery) or die ("Error in OPQuery".mysql_error());
		while($opres= mysql_fetch_array($opexec)){


	


		}

			 $totoptotalamount30 = $totoptotalamount30 + $optotalamount30;
			$totoptotalamount60 = $totoptotalamount60 + $optotalamount60;
			$totoptotalamount90 = $totoptotalamount90 + $optotalamount90;	
			$totoptotalamount120 = $totoptotalamount120 + $optotalamount120;
			$totoptotalamount180 = $totoptotalamount180 + $optotalamount180;
*/
			?>
	
			
			<?php
			
			
		 $query42 = "SELECT docno,fxamount,transactiondate,patientcode,patientname,visitcode,particulars from (select billnumber AS docno,fxamount,transactiondate,patientcode,patientname,visitcode,'Invoice NO' as particulars FROM master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'

		  UNION ALL select billnumber AS docno,transactionamount as fxamount,transactiondate,patientcode,patientname,visitcode,'Opening Balance'particulars FROM master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'

		  -- UNION ALL SELECT b.`docno` as docno,  (-1*b.`transactionamount`) as fxamount, b.`transactiondate` as transactiondate,b.patientcode,b.patientname,b.visitcode,b.particulars  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2' and b.billnumber!=''

		  -- UNION ALL SELECT docno as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,patientcode,patientname,visitcode,particulars FROM master_transactionpaylater where accountnameano='$res21accountnameano'   and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2' 
		  
		  UNION ALL SELECT `docno` as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,accountnameid as patientcode, accountname as patientname,'' as visitcode,particulars  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
		  
		  UNION ALL SELECT `docno` as docno, sum(1*`amount`) as fxamount, `consultationdate` as transactiondate, patientcode as patientcode, patientname as patientname, patientvisitcode as visitcode, '' as particulars  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2' group by docno
		  
		  UNION ALL SELECT `docno` as docno, sum(debitamount-creditamount) as fxamount, `entrydate` as transactiondate ,ledgerid as patientcode, ledgername as patientname,'' as visitcode,narration as particulars   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' group by docno
		  
		  -- UNION ALL SELECT `docno` as docno, (-1*discount) as fxamount, `transactiondate` as transactiondate,accountnameid as patientcode, accountname as patientname,'' as visitcode,'Discount' as particulars  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND transactiontype = 'PAYMENT' AND discount>0 and billnumber!='' and recordstatus='allocated'
		  ) as t order by t.transactiondate ASC
		  
		  ";

		   $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		   /*
		   if(mysql_num_rows($exec42)==0)
		   {
		   continue;
		   }
		   */
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
				
	//ACCOUNT WISE OPENING BALANCE 
		$accountopeningbalance = 0;
		$accoptotal30 = 0;
		$accoptotal60 = 0;
		$accoptotal90 = 0;
		$accoptotal120 = 0;
		$accoptotal180 = 0;
		$accoptotal180g = 0;
		$accountopeningbalance = 0;

		//   $opquery2 = "SELECT fxamount AS fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1' and fxamount <>'0' and billnumber not like 'AOP%'

		//   UNION ALL select transactionamount as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1'  and billnumber like 'AOP%'

		//   UNION ALL SELECT (-1*b.`transactionamount`) as fxamount,b.transactiondate AS transactiondate  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` < '$ADate1'  and b.billnumber!=''

		//   UNION ALL SELECT (-1*`fxamount`) as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano'   and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate < '$ADate1' 
		  
		//   UNION ALL SELECT  (-1*`fxamount`) as fxamount,transactiondate AS transactiondate   FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
		  
		//   UNION ALL SELECT sum(1*`amount`) as fxamount,consultationdate AS transactiondate  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` < '$ADate1'  group by docno
		  
		//   UNION ALL SELECT  (debitamount-creditamount) as fxamount,entrydate AS transactiondate   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` < '$ADate1'  group by docno
		  
		//   UNION ALL SELECT  (-1*discount) as fxamount, `transactiondate` as transactiondate  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1' AND `docno` LIKE 'AR-%' AND transactiontype = 'PAYMENT' AND discount>0 and billnumber!='' and recordstatus='allocated' "
		  
		//   ;
		// $opexec2 = mysql_query($opquery2) or die ("Error in OPQuery2".mysql_error());
		// while($opres2= mysql_fetch_array($opexec2)){
			
	
		//  $opbalance2 = $opres2['fxamount'];
		// $accountopeningbalance = $accountopeningbalance + $opbalance2;
		// $openingtransactiondate2 = $opres2['transactiondate'];



		
		// 			if($opbalance != '0')
		// 			{
		// 			$snocount = $snocount + 1;
		// 			$t1 = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $ADate1) ) ));
		// 			$t1 = strtotime($t1);
		// 			$t2 = strtotime($openingtransactiondate2);
		// 			$days_between = ceil(abs($t1 - $t2) / 86400);

		// 			if($days_between <= 30)
		// 			{

		// 					$accoptotal30 = $accoptotal30 +	$opbalance2;				
							
						
		// 			}
		// 			else if(($days_between >30) && ($days_between <=60))
		// 			{
				
		// 					$accoptotal60 = $accoptotal60 +	$opbalance2;	

						
		// 			}
		// 			else if(($days_between >60) && ($days_between <=90))
		// 			{
			
		// 				$accoptotal90 = $accoptotal90 +	$opbalance2;	
						
		// 			}
		// 			else if(($days_between >90) && ($days_between <=120))
		// 			{
			
		// 					$accoptotal120 = $accoptotal120 +	$opbalance2;	
						
		// 			}
		// 			else if(($days_between >120) && ($days_between <=180))
		// 			{
		// 				$accoptotal180 = $accoptotal180 +	$opbalance2;	

		// 			}
		// 			else
		// 			{
		
		// 					$accoptotal180g = $accoptotal180g +	$opbalance2;	
						
		// 			}

					
		// }

	
		// }
//ACCOUNT WISE OPENING BALANCE END		

		   ?>
		    <tr <?php echo $colorcode; ?> onClick="showaccount(<?=$res21accountnameano?>)">
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>
                <td class="bodytext31" valign="center" colspan="4" align="left"><?php echo $res22accountname; ?></td>
                <td class="bodytext31" valign="center" colspan="3" align="right">Opening Balance</td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accountopeningbalance,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal30,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal60,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal90,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal120,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal180,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal180g,2); ?></td>
                       
            </tr>
		
		   <?php
		  while($res42 = mysqli_fetch_array($exec42))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res42['transactiondate'];
				$res2visitcode = $res42['visitcode'];
				 $res2billnumber = $res42['docno'];
				$particulars = $res42['particulars'];
				$res2patientcode = $res42['patientcode'];
				$res2transactionamount = $res42['fxamount'];
				
				
				$query981 = "select docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT'  and recordstatus = 'allocated'
				UNION ALL select docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'paylatercredit'  and recordstatus = ''";
				$exec981 = mysqli_query($GLOBALS["___mysqli_ston"], $query981) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num981 = mysqli_num_rows($exec981);
				while($res981 = mysqli_fetch_array($exec981))
				{  
				  $res2billnumber1 = $res981['docno'];
				}
				
				
				// $totalpayment = 0;
				// //and accountnameid in (select id from master_accountname where subtype='$subtypeanum')
				// $query98 = "select sum(fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and accountnameid='$res21accountid' and billnumber='$res2billnumber' and recordstatus = 'allocated' ";
				// $exec98 = mysql_query($query98) or die(mysql_error());
				// $num98 = mysql_num_rows($exec98);
				// while($res98 = mysql_fetch_array($exec98))
				// {
				//   $payment = $res98['transactionamount1'];

				//   $totalpayment = $totalpayment + $payment;
				// }

        $totalpayment = 0;
        $discount11 = 0;
        //and accountnameid in (select id from master_accountname where subtype='$subtypeanum')
        $query98 = "select sum(fxamount) as transactionamount1, sum(discount) as discount1,docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and accountnameid='$res21accountid' and billnumber='$res2billnumber' and recordstatus = 'allocated' ";
        $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $num98 = mysqli_num_rows($exec98);
        while($res98 = mysqli_fetch_array($exec98))
        {
          $payment = $res98['transactionamount1'];
          $discount11=$res98['discount1'];

          $totalpayment = $totalpayment + $payment+$discount11;
        }
									
				//$resamount = $res2transactionamount - $totalpayment;
				// $resamount = $res2transactionamount ;

				$resamount = $res2transactionamount - $totalpayment;
				
				$query90 = "select customerfullname, memberno from master_customer where customercode = '$res2patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];
				if($customerfullname==''){
				$customerfullname = $res42['patientname'];
				}
				
				

					////////////// FOR AR DOCS PENDING AMOUNT //////////////

					$dotarray = explode("-", $res2billnumber);
					$dot_ar_doc = $dotarray[0];
					if($dot_ar_doc=='AR'){

						if($particulars=='Discount'){
							$resamount =  $res2transactionamount;

						}else{

							 $query2 = "SELECT * from master_transactionpaylater where  docno='$res2billnumber' AND transactionmodule = 'PAYMENT' AND transactionstatus = 'onaccount' order by auto_number desc LIMIT 1";
							  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
							  // $num2 = mysql_num_rows($exec2);
							  while ($res2 = mysqli_fetch_array($exec2))
							  {
								   // $totalamount_AR =  -1 * $res2['receivableamount'];
								   $totalamount_AR =  1 * $res2['receivableamount'];
								}

					 $query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$res2billnumber'";
					$exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_allocated = mysqli_num_rows($exec_allocated_amount);
					while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
								$allocated_amount=$res_allocated_amount['amount'];
									}
									if($num_allocated>0){
										 $pendig_final_value = $totalamount_AR-$allocated_amount;
										 // $pendig_final_value = $totalamount_AR;
										 $resamount=$pendig_final_value;
										 $resamount =  -1 * $pendig_final_value;
									}

								}
					}
					/////////////////////////////////////////////////////////////////

					if($resamount != '0')
					{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);

					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 + $resamount;
							
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 + $resamount;	
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 + $resamount;	
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 + $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 + $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater + $resamount;
						
					}
		 			
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			 $colorloopcount2 = $colorloopcount2 + 1;
			$showcolor2 = ($colorloopcount2 & 1); 
			if ($showcolor2 == 0)
			{
				//echo "if";
				$colorcode2 = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode2 = 'bgcolor="#cbdbfa"';
			}
			#cbdbfa
			////////// FOR DBI BILLS ///////////
			$split1 = $res2billnumber;
				$split1 = explode('-',$split1);
				$split2 = $split1['0'];
			  if($split2=='DBI'){ 
			  		$query552 = "select billnumber,patientcode,patientname,patientvisitcode from crdradjustment_detail where debtor_billnum='$res2billnumber'";
				$exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res552 = mysqli_fetch_array($exec552);
				$ref_patientcode = $res552['patientcode'];
				$dbiref_no = $res552['billnumber'];
				$res2visitcode = $res552['patientvisitcode'];


				$query90 = "select customerfullname, memberno from master_customer where customercode = '$ref_patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];
				if($customerfullname==''){
				$customerfullname = $res552['patientname'];
				}
			  }
			  ////////// FOR DBI BILLS ///////////
			?>
			<!-- <tr <?php echo $colorcode2; ?> class="acc<?=$res21accountnameano?>" style="">
				<td class="bodytext31" valign="center"  align="left"><?=$snoln++;?></td>
				<td class="bodytext31" valign="center"  align="left" 
				>
				<?php 
                $preauthno='';

				if($split2=='CB'){
                    $bill_fetch_auth="SELECT preauthcode from billing_paylater where billno='$res2billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];
				}elseif($split2=='IPF'){

					$bill_fetch_auth="SELECT preauthcode from billing_ip where billno='$res2billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];

				}elseif(strpos($split2, 'IPFCA') !== false){
					$bill_fetch_auth="SELECT preauthcode from billing_ipcreditapproved where billno='$res2billnumber' ";
			        $exec_bill_auth = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch_auth) or die ("Error in bill_fetch_auth".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2_auth = mysqli_fetch_array($exec_bill_auth);
                    $preauthno=$res2_auth["preauthcode"];
				}

				if($split2=='DBI'){ 
						echo $res2billnumber.'('.$dbiref_no.')';
				}else{
						if($res2billnumber!=''){echo $particulars.' - '.$res2billnumber;} else {echo $res2billnumber1;} 
					}

				?>
				</td>
				<?php 

					

			        $bill_fetch="SELECT updatedate from completed_billingpaylater where billno='$res2billnumber' ";
			        $exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2 = mysqli_fetch_array($exec_bill);
    			?>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
				<?php 
					if(isset($res2['updatedate'])){
					echo date("Y-m-d", strtotime($res2['updatedate']));
					}else{ echo "<p style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----</p>";
					}
				?>
				</div></td>
				<td align="left" class="bodytext31"><?php echo $customerfullname; ?></td>
				<td align="left" class="bodytext31"><?php echo $res2visitcode; ?></td>
				<td align="left" class="bodytext31"><?php echo $mrdno; ?></td>
				<td align="left" class="bodytext31"><?php echo $preauthno; ?></td>
				<td class="bodytext31" valign="center"  align="left" 
				><?php echo $res2transactiondate; ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($resamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamount30,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamount60,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamount180,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
				><?php echo number_format($totalamountgreater,2,'.',','); ?></td>        
            </tr> -->
			<?php
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$total60=0;
			$totalamount60=0;
			$total90=0;
			$totalamount90=0;
			$total120=0;
			$totalamount120=0;
			$total180=0;
			$totalamount180=0;
			$total210=0;
			$totalamountgreater=0;
			
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
}
				
		$closetotalamount1 =$closetotalamount1 +$openingbalance;
		//$closetotalamount301=$closetotalamount301 + $openingbalance;
		$closetotalamount301=$closetotalamount301+$accountopeningbalance ;
		$totalamount1 =$totalamount1+$openingbalance;

		
		
	
			?>
           
        <!--   <tr <?php echo $colorcode; ?> onClick="showaccount(<?=$res21accountnameano?>)">
		   <td class="bodytext31" valign="center"  align="left" colspan="5" ></td>
                <td class="bodytext31" valign="center"  align="right" colspan="2" 
                >Opening Balance Total:</td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount30+$optotalamount60+$optotalamount90+$optotalamount120+$optotalamount180+$optotalamountgreater,2,'.',','); ?></td>
                 <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount30,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount60,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount90,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount120,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamount180,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($optotalamountgreater,2,'.',','); ?></td>        
            </tr>   -->

			<tr <?php echo $colorcode; ?> onClick="showaccount(<?=$res21accountnameano?>)">
		   <td class="bodytext31" valign="center"  align="left"></td>
                <td class="bodytext31" valign="center" colspan="7"  align="right" 
                >Total:</td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount301,2,'.',','); ?></td>
                 <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount601+$accoptotal30,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount901+$accoptotal60,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount1201+$accoptotal90,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount1801+$accoptotal120,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount2101+$accoptotal180,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($closetotalamount2401+$accoptotal180g,2,'.',','); ?></td>        
            </tr>
            <?php
			$closetotalamount1 = '0';
			$closetotalamount301 = '0';
			$closetotalamount601 = '0';
			$closetotalamount901 = '0';
			$closetotalamount1201 = '0';
			$closetotalamount1801 = '0';
			$closetotalamount2101 = '0';
			$closetotalamount2401 = '0';
			
			
			
			}
			 
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamount210=0;
			}

			}
			$totalamount301=$totalamount301 + $subtypeopbal;	
			
			?>
			</tbody>
            <!--<tr onClick="showsub(<?=$subtypeanum?>)">
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
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><strong>Opening Balance Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount30+$totoptotalamount60+$totoptotalamount90+$totoptotalamount120+$totoptotalamount180+$totoptotalamountgreater,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount30,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount60,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount90,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount120,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamount180,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totoptotalamountgreater,2,'.',','); ?></strong></td>        
            </tr>-->
            <tr onClick="showsub(<?=$subtypeanum?>)">
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
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount601+$totoptotalamount30,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount901+$totoptotalamount60,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1201+$totoptotalamount90,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1801+$totoptotalamount120,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2101+$totoptotalamount180,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2401+$totoptotalamountgreater,2,'.',','); ?></strong></td>        
            </tr>
			<tr>
			<?php

					
		
			?>
			 <td colspan="8"></td>
		   	
			</tr>     
			   <?php
				$grandopbal = $grandopbal + $subtypeopbal;
			   $grandopbal30 = $grandopbal30 + $totoptotalamount30;
			   $grandopbal60 = $grandopbal60 + $totoptotalamount60;
			    $grandopbal90 = $grandopbal90 + $totoptotalamount90;
			   $grandopbal120 = $grandopbal120 + $totoptotalamount120;
			   $grandopbal180 = $grandopbal180 + $totoptotalamount180;
			   $grandopbal180g = $grandopbal180g + $totoptotalamountgreater;
			   
			   
			   
$grandtotalamount1 += $totalamount1;
$grandtotalamount301 = $grandtotalamount301 + $totalamount301;
 $grandtotalamount601 =$grandtotalamount601+$totalamount601+$totoptotalamount30;
$grandtotalamount901 = $grandtotalamount901+$totalamount901+$totoptotalamount60;
$grandtotalamount1201 =$grandtotalamount1201+ $totalamount1201+$totoptotalamount90;
$grandtotalamount1801 = $grandtotalamount1801+$totalamount1801+$totoptotalamount120;
$grandtotalamount2101 =$grandtotalamount2101+ $totalamount2101+$totoptotalamount180;
$grandtotalamount2401 = $grandtotalamount2401+$totalamount2401+$totoptotalamountgreater;

			$totalamount1 = "0.00";
			$totalamount301 = "0.00";
			$totalamount601 = "0.00";
			$totalamount901 = "0.00";
			$totalamount1201 = "0.00";
			$totalamount1801 = "0.00";
			$totalamount2101 = "0.00";
			$totalamount2401 = "0.00";			   
		   
			   
			   }
			   
			   }
			   
				}
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$selectedType&&searchsubtypeanum1=$searchsubtypeanum1";
			   ?>
			  <!-- <tr >
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><strong>Opening Balance Grand Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalopbal,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotoptotalamount30,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotoptotalamount60,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotoptotalamount90,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotoptotalamount120,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotoptotalamount180,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount2401,2,'.',','); ?></strong></td> 
				<td class="bodytext31" valign="center"  align="right">
                </td>       
            </tr>-->	
			<tr >
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"> </td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"> </td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount601,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount901,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount1201,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount1801,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount2101,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount2401,2,'.',','); ?></strong></td> 
				      
            </tr>

            <tr>
        <td colspan="3"></td>
        <td colspan="2" class="bodytext31" valign="center"  align="right"><strong>Subtype Wise: </strong><a href="print_fulldebtoranalysissummary_subtype_new.php?<?php echo $urlpath; ?>" target='_blank'><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

        </td>
        <td colspan="2"></td>
        <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Account Wise: </strong><a href="print_fulldebtoranalysissummary_subtype_account_new.php?<?php echo $urlpath; ?>" target='_blank'><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

        </td>   
      </tr>

          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
