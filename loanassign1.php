<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companycode = $_SESSION['companycode'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$employeecode=$_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$employeename = strtoupper($employeename);
	$employeename = trim($employeename);
	$loancode = $_REQUEST['loancode'];
	$loanname = $_REQUEST['loanname'];
	$loanname = strtoupper($loanname);
	$totalloanamt = $_REQUEST['totalloanamt'];
	$annualinterest = $_REQUEST['annualinterest'];
	$loanterm = $_REQUEST['loanterm'];
	$firstpayment = $_REQUEST['firstpayment'];
	$payfrequency = $_REQUEST['payfrequency'];
	$noofinstallment = $_REQUEST['noofinstallment'];
	$installpermonth = $_REQUEST['installpermonth'];
	$interestratepermonth = $_REQUEST['interestratepermonth'];
	$totaldue = $_REQUEST['totaldue'];
	$totalinterest = $_REQUEST['totalinterest'];
	$firstpaymentmonth = $_REQUEST['firstpaymentmonth'];
	
	//$query5 = "delete from loan_assign where employeecode = '$employeecode' and employeename = '$employeename' and companycode = '$companycode'";
	//$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	
	$query5 = "select * from loan_assign where employeecode = '$employeecode' order by installments desc limit 0,1";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$res5loanpaidstatus = $res5['loanpaidstatus'];
	$res5employeecode = $res5['employeecode'];
	if($res5employeecode == '')
	{
		$res5loanpaidstatus = 'paid';
	}
	else
	{
		$res5loanpaidstatus = $res5loanpaidstatus;
	}
	if($res5loanpaidstatus == 'paid')
	{
		for($i=1;$i<=150;$i++)
		{	
			if(isset($_REQUEST['serialnumber'.$i]))
			{
				$serialnumber = $_REQUEST['serialnumber'.$i];
				
				if($serialnumber != '')
				{	
					$payment = $_REQUEST['payment'.$i];
					$principle = $_REQUEST['principle'.$i];
					$interest = $_REQUEST['interest'.$i];
					$balance = $_REQUEST['balance'.$i];
					if($i==1){
					$firstpaymentmonth = date('M-Y',strtotime($firstpaymentmonth));
					} else {
					$firstpaymentmonth = date('M-Y',strtotime('+1 month', strtotime($firstpaymentmonth))); 
					}
					
					$query2 = "insert into loan_assign(employeecode, employeename,loancode, loanname, loandate, installments,totalinstallment, interestapplicable, interest, amount, installmentamount, monthpay, ipaddress, username, updatedatetime, fringebenefit, interestratepermonth, principle, interestamount, balance, fringerate,totaldue,totalinterest, companyanum,paymonth) 
					values('$employeecode', '$employeename','$loancode', '$loanname','$firstpayment','$serialnumber', '$noofinstallment', 'Yes', '$annualinterest', '$totalloanamt', '$payment','$installpermonth', '$ipaddress', '$username', '$updatedatetime', '', '$interestratepermonth', '$principle','$interest','$balance','','$totaldue','$totalinterest','$companyanum','$firstpaymentmonth')";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
			}
		}
	}
	
	header("location:loanassign1.php?st=success");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
}

$query5 = "select * from master_fringebenefit where status <> 'deleted'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$res5fringebenefit = $res5['percent'];

$query1 = "select * from loan_assign order by auto_number desc limit 0, 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0)
{
	$companycode = 'LON00000001';
}
else
{
	$res1 = mysqli_fetch_array($exec1);
	$res1companycode = $res1["loancode"];
	$companycode = substr($res1companycode, 3, 8);
	$companycode = intval($companycode);
	$companycode = $companycode + 1;

	$maxanum = $companycode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$companycode = 'LON'.$maxanum1;

	//echo $companycode;
}
//echo $res1companycode;

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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestemployeesearch12.js"></script>
<script type="text/javascript" src="js/autoemployeecodesearch3.js"></script>
<!--<script type="text/javascript" src="js/autoemployeeloanedit1.js"></script>-->
<script type="text/javascript" src="js/insertloanname1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  	
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

function process1backkeypress1() 
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

	if (document.form1.employeename.value == "")
	{
		alert ("Employee Name Cannot Be Empty.");
		document.form1.employeename.focus();
		return false;
	}
	if (document.form1.loanname.value == "")
	{
		alert ("Enter Loan Name");
		document.form1.loanname.focus();
		return false;
	}
	if (document.form1.totalloanamt.value == "")
	{
		alert ("Enter Loan Amount");
		document.form1.totalloanamt.focus();
		return false;
	}
	if (document.form1.annualinterest.value == "")
	{
		alert ("Enter Annual Interest");
		document.form1.annualinterest.focus();
		return false;
	}
	if (document.form1.loanterm.value == "")
	{
		alert ("Enter Loan Term");
		document.form1.loanterm.focus();
		return false;
	}
	if (document.form1.installpermonth.value == "")
	{
		alert ("Click Calculate to continue");
		document.form1.installpermonth.focus();
		return false;
	}
}

function calculateMe(){
var principle=document.getElementById('totalloanamt').value;
var rate=document.getElementById('annualinterest').value;
var term=document.getElementById('loanterm').value;
//var term12=document.getElementById('noofinstallment').value;

//var output=document.getElementById('calculatorOutput');
if(isNaN(principle)||isNaN(term))
{alert('Please enter only numbers for the principle and term');
return}
if(principle.length<=0||rate.length<=0||term.length<=0){alert('Please enter information for the Loan Amount, Interest, and Installment.');
return}
if(principle.length<=0||rate.length<=0||term.length<=0){principle = 0;rate=0;term=0;}
if(principle<=0||rate<=0||term<=0){//alert('Please enter only positive numbers for the Loan Amount, Interest, and Installment.');
//return
}
var term12 = term/12;
var term11 = term*12;
var PF=12;
var I=rate/100;
var i;
var n=PF*term;i=Math.pow((1+I/PF),(12/PF))-1;
var afSub=Math.pow((1/(1+i)),n);
var AF=(1-afSub)/i;

if(I==0){
var payment=principle/term11;
} else {var payment=principle/AF;}

var roundedPayment=parseInt(payment);
var decimal=Math.abs(Math.round(payment*100)-roundedPayment*100);
var monthlyPayment;
if(decimal<10){monthlyPayment=roundedPayment+".0"+decimal
}else if(decimal>=10){monthlyPayment=roundedPayment+"."+decimal}
else{monthlyPayment=roundedPayment}
var outputString=monthlyPayment;
//alert('outputString');
//alert(outputString);
var outputString = parseFloat(outputString);
var principle = parseFloat(principle);
var rate = parseFloat(rate);
document.getElementById("installpermonth").value = outputString.toFixed(2);
document.getElementById("totalloanamt").value = principle.toFixed(2);
var Intpermonth = parseFloat(rate)/parseFloat(12);
document.getElementById("interestratepermonth").value = Intpermonth.toFixed(4);
var TotalDue = parseFloat(outputString)*parseFloat(term11);
document.getElementById("totaldue").value = TotalDue.toFixed(2);
var Totalint = parseFloat(TotalDue) - parseFloat(principle);
document.getElementById("totalinterest").value = Totalint.toFixed(2);
var term11 = parseFloat(term11);
document.getElementById("noofinstallment").value = term11.toFixed(2);

InsertRow(); //create loan details

}

</script>
<!--<script type="text/javascript" src="http://www.loanamortizationschedule.org/calculators/loan-calculator.js" ></script>
--><script src="js/datetimepicker1_css.js"></script>
<body>
<form name="form1" id="form1" method="post" action="loanassign1.php" onSubmit="return from1submit1()">
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr>
	<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Search Employee </strong></td>
	<td width="87%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	<input name="searchsuppliername" type="text" id="searchsuppliername" value="" size="40" autocomplete="off">
	<input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
	<input type="hidden" name="searchdescription" id="searchdescription">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	</td>
	</tr>
	</tbody>
	</table> 
	</td>
  </tr> 
  <tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="900" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody id="employeetr">
	<tr>
	<td width="118" align="left" class="bodytext3"><strong>Employee Name</strong></td>
	<td width="266" align="left" class="bodytext3"><input type="text" name="employeename" id="employeename" value="" size="30" readonly="readonly" class="bodytext3" style="border:none;background-color:#ecf0f5;">
	<td width="120" align="left" class="bodytext3"><strong>Employee Code</strong></td>
	<td width="364" align="left" class="bodytext3"><input type="text" name="employeecode" id="employeecode" value="" size="20" readonly="readonly" class="bodytext3" style="border:none;background-color:#ecf0f5;">
	</tr>
	</tbody>
	</table>
	</td>
  </tr>
  <tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody id="assigntr">
	<tr bgcolor="#ecf0f5">
	<td align="left" class="bodytext3"><strong>Loan Calculator</strong></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td width="203" align="left" class="bodytext3"><strong>Loan Name</strong></td>
	<td width="675" align="left" class="bodytext3"><input type="text" name="loanname" id="loanname" size="35" style="border:solid 1px #001E6A;text-align:left;">
	<input type="hidden" name="loancode" id="loancode" value="<?php echo $companycode; ?>" size="15" style="border:solid 1px #001E6A;text-align:left;"></td>
	</tr>
	<tr>
	<td width="203" align="left" class="bodytext3"><strong>Total Amount Disbursed</strong></td>
	<td width="675" align="left" class="bodytext3"><input type="text" name="totalloanamt" id="totalloanamt" size="15" style="border:solid 1px #001E6A;text-align:right;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Annual Interest Rate</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="annualinterest" id="annualinterest" size="15" style="border:solid 1px #001E6A;text-align:right;">
	<span class="bodytext3"><strong>%</strong></span></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Terms of Loan in Years</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="loanterm" id="loanterm" size="15" style="border:solid 1px #001E6A;text-align:right;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Loan Date</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="firstpayment" id="firstpayment" size="10" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" style="border:solid 1px #001E6A;">
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('firstpayment')" style="cursor:pointer"/></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Payment Frequency</strong></td>
	<td align="left" class="bodytext3"><select name="payfrequency" id="payfrequency" style="border:solid 1px #001E6A;">
	<option value="Monthly">Monthly</option>
	</select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Payment Start Month</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="firstpaymentmonth" id="firstpaymentmonth" size="10" value="<?php echo date('M-Y'); ?>" readonly="readonly" style="border:solid 1px #001E6A;">
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('firstpaymentmonth','MMMYYYY')" style="cursor:pointer"/></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Total No. of Installments</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="noofinstallment" id="noofinstallment" size="15" readonly="readonly" style="border:solid 1px #001E6A;text-align:right;background-color:#ecf0f5;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Installment Per Month</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="installpermonth" id="installpermonth" size="15" readonly="readonly" style="border:solid 1px #001E6A;background-color:#ecf0f5;text-align:right;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Interest Rate Per Month</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="interestratepermonth" id="interestratepermonth" size="15" readonly="readonly" style="border:solid 1px #001E6A; background-color:#ecf0f5; text-align:right;">
	<span class="bodytext3"><strong>%</strong></span></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Total Amount Due</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="totaldue" id="totaldue" size="15" readonly="readonly" style="border:solid 1px #001E6A; background-color:#ecf0f5;text-align:right;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>Total Interest</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="totalinterest" id="totalinterest" readonly="readonly" size="15" style="border:solid 1px #001E6A; background-color:#ecf0f5; text-align:right;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	<td align="left" class="bodytext3"><input type="button" value="Calculate" onClick="return calculateMe();"></td>
	</tr>
	</thead>
	<tbody>
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td valign="top">
	<table width="550" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr>
	<td colspan="5" bgcolor="#ecf0f5" align="left" class="bodytext3"><strong>Loan Calculation Details</strong></td>
	</tr>
	<tr>
	<td width="20" align="left" class="bodytext3"><strong>Installment</strong></td>
	<td width="10" align="right" class="bodytext3"><strong>Payment</strong></td>
	<td width="72" align="right" class="bodytext3"><strong>Principal</strong></td>
	<td width="73" align="right" class="bodytext3"><strong>Interest</strong></td>
	<td width="86" align="right" class="bodytext3"><strong>Balance</strong></td>
	</tr>
	<input type="hidden" name="serialnumber" id="serialnumber" value="1">
	<tbody id="loanrowinsert">
	
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Submit" value="Submit">
	</tbody>
	</table>
	</td>
	</tr>
    </table>
	</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

