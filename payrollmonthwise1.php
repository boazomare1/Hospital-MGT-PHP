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
$errmsg = '';
$bgcolorcode = '';
$colorloopcount = '';
$month = date('M-Y');
$sno = '';

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["assignmonth1"])) { $assignmonth1 = $_REQUEST["assignmonth1"]; } else { $assignmonth1 = date('M-Y'); }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$assignmonth = $_REQUEST['assignmonth'];
	$maxno = $_REQUEST['maxno'];
	
	for($i=1;$i<=$maxno;$i++)
	{
		if(isset($_REQUEST['serialnumbermonth'.$i]))
		{
			$serialnumber = $_REQUEST['serialnumbermonth'.$i];
			
			if($serialnumber != '')
			{
				$employeecode = $_REQUEST['employeecode'.$i];
				$employeename = $_REQUEST['employeename'.$i];
				$componentanum = $_REQUEST['componentanum'.$i];
				$componentname = $_REQUEST['componentname'.$i];
				$componentrate = $_REQUEST['rate'.$i];
				$componentunit = $_REQUEST['unit'.$i];
				$componentamount = $_REQUEST['amount'.$i];
				//$amounttype = $_REQUEST['amounttype'.$i];
				
				$query1 = "select * from master_payrollcomponent where auto_number = '$componentanum'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1typecode = $res1['typecode'];
				$res1componentname = $res1['componentname'];
				$res1type = $res1['type'];
				$res1amounttype = $res1['amounttype'];
				$res1monthly = $res1['monthly'];
				
				$query5 = "select * from payroll_assignmonthwise where employeecode = '$employeecode' and assignmonth = '$assignmonth' and componentanum = '$componentanum' and status <> 'deleted'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res5 = mysqli_fetch_array($exec5);
				$res5employeecode = $res5['employeecode'];
				$res5componentname = $res5['componentname'];
				if($res5componentname == '')
				{
					$query2 = "insert into payroll_assignmonthwise(employeecode, employeename, componentanum, componentname, typecode, type, amounttype, monthly, rate, unit, amount, username, ipaddress, updatetime, assignmonth)
					values('$employeecode', '$employeename', '$componentanum', '$res1componentname', '$res1typecode', '$res1type', '$res1amounttype', '$res1monthly', '$componentrate', '$componentunit', '$componentamount', '$username', '$ipaddress', '$updatedatetime', '$assignmonth')";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$query21 = "update payroll_assignmonthwise set rate = '$componentrate', unit = '$componentunit', amount = '$componentamount' where employeecode = '$employeecode' and assignmonth = '$assignmonth' and componentanum = '$componentanum' and status <> 'deleted'";
					$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}		
		}
	}
	
	for($j=1;$j<1;$j++)
	{
		if(isset($_REQUEST['serialnumberloan'.$j]))
		{
			$serialnumberloan = $_REQUEST['serialnumberloan'.$j];
			
			if($serialnumberloan != '')
			{
				$loanname = $_REQUEST['loanname'.$j];
				$loanamount = $_REQUEST['loanamount'.$j];
				$loanremain = $_REQUEST['loanremain'.$j];
				$interest = $_REQUEST['interest'.$j];
				$installments = $_REQUEST['installments'.$j];
				$interestapplicable = $_REQUEST['interestapplicable'.$j];
				$fringebenefit = $_REQUEST['fringebenefit'.$j];
				if(isset($_REQUEST['hold'.$j]))
				{ 
					$monthamount = '0.00';
					$holdstatus = 'Yes';
				}
				else
				{
					$monthamount = $_REQUEST['monthamount'.$j];
					$holdstatus = 'No';
				}
				$monthinterest = $_REQUEST['monthinterest'.$j];
				$monthpay = $_REQUEST['monthpay'.$j];
				$fringerate = $_REQUEST['fringerate'.$j];
				
				if($holdstatus == 'Yes')
				{
					$query11 = "update loan_assign set holdstatus = 'Yes' where employeecode = '$employeecode' and loanname = '$loanname' and amount = '$loanamount'";
					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$query12 = "update loan_assign set holdstatus = '' where employeecode = '$employeecode' and loanname = '$loanname' and amount = '$loanamount'";
					$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));				
				}	
					
				$query6 = "select * from details_loanpay where employeecode = '$employeecode' and paymonth = '$assignmonth' and status <> 'deleted'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
				$res6employeecode = $res6['employeecode'];
				if($res6employeecode == '')
				{				
					$query3 = "insert into details_loanpay(employeecode, employeename, loanname, installments, interestapplicable, interest, fringebenefit, amount, amountremain, monthamount, monthinterest, installmentamount, fringerate, paymonth, username, ipaddress, updatedatetime)
					values('$employeecode', '$employeename', '$loanname', '$installments', '$interestapplicable', '$interest', '$fringebenefit', '$loanamount', '$loanremain', '$monthamount', '$monthinterest', '$monthpay', '$fringerate', '$assignmonth', '$username', '$ipaddress', '$updatedatetime')";
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$query4 = "update details_loanpay set installmentamount = '$monthpay', monthamount = '$monthamount', monthinterest = '$monthinterest', fringerate = '$fringerate', updatedatetime = '$updatedatetime' where employeecode = '$res6employeecode' and paymonth = '$assignmonth' and status <> 'deleted' and loanname = '$loanname'";
					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}		
		}
	}
	
	header("location:payrollmonthwise1.php?st=success");
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
<script type="text/javascript" src="js/autosuggestemployeesearch13.js"></script>
<script type="text/javascript" src="js/autoemployeeloandetails1.js"></script>
<!--<script type="text/javascript" src="js/autoemployeecodesearch5.js"></script> don't activate-->
<script type="text/javascript" src="js/autoemployeepayroll2.js"></script>

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

window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  	
}

function LoanHold(k)
{
	var k = k;
	//alert(k);
	var MonthInterest = document.getElementById("monthinterest"+k).value;
	var MonthAmount = document.getElementById("monthamount"+k).value;
	var MonthPay = document.getElementById("monthpay"+k).value;
	if(document.getElementById("hold"+k).checked == true)
	{
		document.getElementById("monthpay"+k).value = MonthInterest;
	}
	if(document.getElementById("hold"+k).checked == false)
	{
		var MonthNett = parseFloat(MonthAmount) + parseFloat(MonthInterest);
		var MonthNett = MonthNett.toFixed(2);
		document.getElementById("monthpay"+k).value = MonthNett;
	}
}

</script>

<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
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

}

function Amtcalc(id)
{
	var Rate = document.getElementById("rate"+id).value;

	if(isNaN(document.getElementById("unit"+id).value))
	{
		alert("Enter Numbers");
		document.getElementById("unit"+id).focus();
		return false;
	}
	else
	{
		var Unit = document.getElementById("unit"+id).value;
		if(Unit.length > 0)
		{
		var Amount = parseFloat(Rate) * parseFloat(Unit);
		document.getElementById("amount"+id).value = Amount.toFixed(2);
		document.getElementById("serialnumbermonth"+id).checked = true;
		}
		else
		{
		document.getElementById("amount"+id).value = "0.00";
		document.getElementById("serialnumbermonth"+id).checked = false;
		}
	}
}
</script>
<script src="js/datetimepicker1_css.js"></script>
<body> <!--onkeydown="escapekeypressed(event)"-->
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php eval(base64_decode('IA0KCQ0KCQlpbmNsdWRlICgiaW5jbHVkZXMvbWVudTEucGhwIik7IA0KCQ0KCS8vCWluY2x1ZGUgKCJpbmNsdWRlcy9tZW51Mi5waHAiKTsgDQoJDQoJ')); ?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
<form name="form1" id="form1" method="post" action="payrollmonthwise1.php">
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="80%" valign="top">
	<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FF9900">
	<td colspan="2" align="left" class="bodytext3"><strong>Payroll Monthwise Assign</strong></td>
	</tr>
	<tr>
	<td width="432" align="left" valign="top" class="bodytext3">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td colspan="3" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>Employee List</strong>
	<input type="hidden" name="searchdescription" id="searchdescription">
	<input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
	</td>
	</tr>
	<tr>
	<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>Select Month &nbsp;&nbsp;</strong>
	<input name="searchsuppliername" id="searchsuppliername" autocomplete="off" type="hidden" size="50" />	
	<input type="text" name="assignmonth1" id="assignmonth1" readonly value="<?php echo $assignmonth1; ?>" size="10">
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth1','MMMYYYY')" style="cursor:pointer"/>
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" readonly>&nbsp;&nbsp;
	<input type="hidden" name="frmflag34" id="frmflag34" value="frmflag34">
	<input type="submit" name="frmsubmit" value="Submit"></td>
  	</tr>
 	</thead>
	<tbody id="tblrowinsert">

	</tbody>	
	</table>
	</td>
	</tr>
	</form>
	<?php if($frmflag34 == 'frmflag34') { ?>
	<form name="form1" id="form1" method="post" action="payrollmonthwise1.php">
	<tr>
	<td width="452" align="left" valign="top" class="bodytext3">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td colspan="7" class="bodytext3" align="left" bgcolor="#33CCCC"><strong>Payroll Components Monthwise</strong></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td align="left" class="bodytext3"><strong>Emp Code</strong></td>
	<td align="left" class="bodytext3"><strong>Emp Name</strong></td>
	<td align="left" class="bodytext3"><strong>Component</strong></td>
	<td align="center" class="bodytext3"><strong>Rate</strong></td>
	<td align="center" class="bodytext3"><strong>Unit</strong></td>
	<td align="center" class="bodytext3"><strong>Amount</strong></td>
	<td align="right" class="bodytext3"><strong>Select</strong></td>
	<input type="hidden" name="assignmonth" id="assignmonth" value="<?php echo $assignmonth1; ?>"> 
	</tr>
	<?php
	$query8 = "select * from payroll_assign where status <> 'deleted' group by employeecode order by employeename";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res8 = mysqli_fetch_array($exec8))
	{
	$res8employeecode = $res8['employeecode'];

	$query88 = "select employeecode, employeename from master_employee where payrollstatus <> 'Inactive' and employeecode = '$res8employeecode'";
	$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row88 = mysqli_num_rows($exec88);
	$res88 = mysqli_fetch_array($exec88);
	if($row88 > 0)
	{
	
	$query9 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and monthly = 'Yes'";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res9 = mysqli_fetch_array($exec9))
	{
	$res9employeecode = $res88['employeecode'];
	$res9employeename = $res88['employeename'];
	$componentanum = $res9['auto_number'];
	$componentname = $res9['componentname'];
	$amounttype = $res9['amounttype'];
	$formula = $res9['formula'];
	
	$query48 = "select `$componentanum` as componentamount from payroll_assign where employeecode = '$res9employeecode' and status <> 'deleted'";
	$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query48".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res48 = mysqli_fetch_array($exec48);
	$componentamount = $res48['componentamount'];
	
	if($amounttype == 'Percent')
	{
		$formulafrom = $res9['formula'];
		if($formulafrom == '1')
		{
			$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$res9employeecode' and status <> 'deleted'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$value = $res6['componentvalue'];
			
			$calc1 = $value * ($componentamount/100);
			$calc1 = ceil($calc1);
			$calc1 = number_format($calc1,3,'.','');
			//$calc1 = round_calc($calc1);
			
			$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$notexceed = $res7['notexceed'];
			if($notexceed != '0.00')
			{
				if($calc1 > $notexceed)
				{
					$resamount = $notexceed;
				}
				else
				{
					$resamount = $calc1;
				}
			}
			else
			{
				$resamount = $calc1;
			}
			
			$componentamount = $resamount;
			
		}
		
		else if($formulafrom == 'Gross')
		{
			$totalgrossper = 0;
			$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and auto_number <> '$componentanum' and recordstatus <> 'deleted'";
			$exec12 = mysqli_query($query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res12 = mysqli_fetch_array($exec12))
			{
				$ganum = $res12['ganum'];
				
				$querygg = "select `$ganum` as res12value from payroll_assign where employeecode = '$res9employeecode' and status <> 'deleted'";
				$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resgg = mysqli_fetch_array($execgg);
				$res12value = $resgg['res12value'];
				$totalgrossper = $totalgrossper + $res12value;
			}
			$calc3 = $totalgrossper * ($componentvalue / 100);
			$calc3 = ceil($calc3);
			$calc3 = number_format($calc3,3,'.','');
			//$calc3 = round_calc($calc3);
			
			$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$notexceed = $res13['notexceed'];
			if($notexceed != '0.00')
			{
				if($calc3 > $notexceed)
				{
					$resamount = $notexceed;
				}
				else
				{
					$resamount = $calc3;
				}
			}
			else
			{
				$resamount = $calc3;
			}	
			
			$componentamount = $resamount;
		}
		else
		{
			
		}
	}	
	else
	{
		$componentamount = $componentamount;
	}
	
	if($componentamount > 0)
	{
	
	$query18 = "select * from payroll_assignmonthwise where employeecode = '$res9employeecode' and assignmonth = '$assignmonth1' and componentanum = '$componentanum' and status <> 'deleted'";
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res18 = mysqli_fetch_array($exec18);
	$unit = $res18['unit'];
	$amount = $res18['amount'];
	
	$sno = $sno + 1;
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#CBDBFA"';
	}
	else
	{
		$colorcode = 'bgcolor="#ecf0f5"';
	} 
	
	if($amount!='' && $amount!=$componentamount){
		$colorcode = 'bgcolor="#FF99CC"';
	}
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="left" class="bodytext3"><?php echo $res9employeecode; ?>
	<input type="hidden" name="employeecode<?php echo $sno; ?>" id="employeecode<?php echo $sno; ?>" value="<?php echo $res9employeecode; ?>"></td>
	<td align="left" class="bodytext3"><?php echo $res9employeename; ?>
	<input type="hidden" name="employeename<?php echo $sno; ?>" id="employeename<?php echo $sno; ?>" value="<?php echo $res9employeename; ?>"></td>
	<td align="left" class="bodytext3"><?php echo $componentname; ?>
	<input type="hidden" name="componentanum<?php echo $sno; ?>" id="componentanum<?php echo $sno; ?>" value="<?php echo $componentanum; ?>">
	<input type="hidden" name="componentname<?php echo $sno; ?>" id="componentname<?php echo $sno; ?>" value="<?php echo $componentname; ?>"></td>
	<td align="center" class="bodytext3">
	<input type="text" name="rate<?php echo $sno; ?>" id="rate<?php echo $sno; ?>" readonly value="<?php echo $componentamount; ?>" size="6"></td>
	<td align="center" class="bodytext3"><input type="text" name="unit<?php echo $sno; ?>" id="unit<?php echo $sno; ?>" value="<?php echo $unit; ?>" size="6" style="border:solid 1px #0000CC;" onKeyUp="return Amtcalc('<?php echo $sno;?>');"></td>
	<td align="center" class="bodytext3"><input type="text" name="amount<?php echo $sno; ?>" readonly id="amount<?php echo $sno; ?>" value="<?php echo $amount; ?>" size="6"></td>
	<td align="right" class="bodytext3"><input type="checkbox" name="serialnumbermonth<?php echo $sno; ?>" id="serialnumbermonth<?php echo $sno; ?>" value="<?php echo $res9employeecode; ?>"></td>
	</tr>
	<?php
	}
	}
	}
	}
	?>
	<input type="hidden" name="maxno" id="maxno" value="<?php echo $sno; ?>">
	</thead>
	<tbody id="tblrowinsert1">
	
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td width="452" align="left" valign="top" class="bodytext3">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<!--<tr bgcolor="#33CCCC">
	<td colspan="18" align="left" class="bodytext3"><strong>Loan Details</strong></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td colspan="2" align="left" class="bodytext3"><strong>Loan Name</strong></td>
	<td align="left" class="bodytext3"><strong>Loan Amount</strong></td>
	<td align="left" class="bodytext3"><strong>Interest For</strong></td>
	<td align="left" class="bodytext3"><strong>Interest</strong></td>
	<td align="left" class="bodytext3"><strong>Installments</strong></td>
	<td align="left" class="bodytext3"><strong>Interest App</strong></td>
	<td align="left" class="bodytext3"><strong>Fringe %</strong></td>
	<td align="left" class="bodytext3"><strong>Mth Principle</strong></td>
	<td align="left" class="bodytext3"><strong>Mth Interest</strong></td>
	<td align="left" class="bodytext3"><strong>Mth Pay</strong></td>
	<td align="left" class="bodytext3"><strong>Fringe Rate</strong></td>
	<td align="left" class="bodytext3"><strong>Hold</strong></td>
	</tr>-->
	</thead>
	<tbody id="tblrowinsert2">
	
	</tbody>
	</table>
	</td>
	</tr>
	
	<tr>
	<td colspan="2" align="left">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="submit" value="Submit">
	</tbody>
	</table> 
	</td>
  	</tr>
	</form>
	<?php } ?>
    </table>

<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

