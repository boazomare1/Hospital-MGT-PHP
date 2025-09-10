<?php session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
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
} ?>
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
<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
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
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
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

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
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
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<form name="form1" id="form1" method="post" action="progressive_pensionreport1.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php eval(base64_decode('IGVjaG8gJHNlYXJjaGVtcGxveWVlOyA=')); ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr hidden="hidden">
	<td align="left" class="bodytext3">Search Month</td>
	<td width="63" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
	<?php  if($searchmonth != '') {  ?>
	<option value="<?php eval(base64_decode('IGVjaG8gJHNlYXJjaG1vbnRoOyA=')); ?>"><?php eval(base64_decode('IGVjaG8gJHNlYXJjaG1vbnRoOyA=')); ?></option>
	<?php  }  ?>
	<?php 
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	 ?>
	<option value="<?php eval(base64_decode('IGVjaG8gJGFycmF5bW9udGhbJGldOyA=')); ?>"><?php eval(base64_decode('IGVjaG8gJGFycmF5bW9udGhbJGldOyA=')); ?></option>
	<?php 
	}
	 ?>
	</select></td>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php  if($searchyear != '') {  ?>
	<option value="<?php eval(base64_decode('IGVjaG8gJHNlYXJjaHllYXI7IA==')); ?>"><?php eval(base64_decode('IGVjaG8gJHNlYXJjaHllYXI7IA==')); ?></option>
	<?php  }  ?>
	<?php 
	for($j=2010;$j<=date('Y');$j++)
	{
	 ?>
	<option value="<?php eval(base64_decode('IGVjaG8gJGo7IA==')); ?>"><?php eval(base64_decode('IGVjaG8gJGo7IA==')); ?></option>
	<?php 
	}
	 ?>
	</select></td>
	</tr>
	<tr><td></td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	<tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php 
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1' && $searchemployee != "")
	{	
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
		if (isset($_SESSION['companyanum'])) { $companyanum = $_SESSION['companyanum']; } else { $companyanum = ''; }
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&companyanum=$companyanum&&searchemployee=$searchemployee";

	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.status <> 'deleted'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	}

	$query6 = "select passportnumber,nssf,payrollno,employeecode,employeename from master_employeeinfo where employeecode = '$res2employeecode' ORDER BY employeecode";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$nssf = $res6['nssf'];
	$payrollno = $res6['payrollno'];

	 ?>	
	<table width="902" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="center" class="bodytext3"><strong>HISTORICAL PENSION CONTRIBUTION</strong></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td colspan="8" align="left" class="bodytext3"><strong>Historical Pension Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php eval(base64_decode('IGVjaG8gJGNvbXBhbnluYW1lOyA=')); ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>EMPLOYEE CODE : <?php echo $res2employeecode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>EMPLOYEE NAME : <?php echo $res2employeename; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>PENSION NUMBER : <?php echo $nssf; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>PAYROLL NUMBER : <?php echo $payrollno; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="8" align="left" class="bodytext3"><strong>REPORT DATE : <?php echo date('d/m/Y'); ?></strong></td>
	</tr>
	<tr>
	<td width="82" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Period</strong></td>
	<td width="75" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Basic Pay</strong></td>
	<td width="82" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Employee Amount</strong></td>
	<td width="82" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Voluntary Amount</strong></td>
	<td width="82" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Employee Total Contribution</strong></td>
	<td width="87" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Contribution By Employer</strong></td>
	<td width="106" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Monthly Total Contribution</strong></td>
	<td width="106" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>Cummulative Total</strong></td>
	</tr>	 
	<?php 
	$totalnssf = '0.00';
	$totalamount = '0.00';
	$totalstdamount = '0.00';
	$totalvolamount = '0.00';
	$query2 = "select a.employeecode as employeecode, paymonth, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.status <> 'deleted' ORDER BY auto_number ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	$paymonth = $res2['paymonth'];
	
	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row778 = mysqli_num_rows($query778);
	if($row778 > 0)
	{
	
	$query6 = "select passportnumber,nssf,payrollno,pension_type from master_employeeinfo where employeecode = '$res2employeecode' ORDER BY employeecode";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$nssf = $res6['nssf'];
	$payrollno = $res6['payrollno'];
	$pension_type = $res6['pension_type'];
	
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
	  
	 ?>
	<tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
	<td align="center" class="bodytext3"><?php echo $paymonth; ?></td>
	<?php 
	$totalgrossper = 0;
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '25' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `23`,`$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$voluntary = $res3['23'];

	
	$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res12 = mysqli_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		
		$querygg = "select `1`,`$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and status <> 'deleted' AND paymonth = '$paymonth'";
		$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resgg = mysqli_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		$totalgrossper = $resgg['1'];;

	}
	$grosspay = $totalgrossper;
	
	$stdamount = 1 * $componentamount;
	$empamount = 3 * $componentamount;
	$totamount = $stdamount + $empamount+$voluntary;
	
	
	$totalstdamount = $totalstdamount + $stdamount+$voluntary;
	$totalvolamount = $totalvolamount + $empamount;
	
	$totalnssf = $totalnssf + $totamount;
	 ?>
	<td align="right" class="bodytext3"><?php echo number_format($grosspay,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($stdamount,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($voluntary,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($stdamount+$voluntary,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($empamount,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($totamount,3,'.',','); ?></td>
	<?php 
	$totalstdamount += $stdamount+$voluntary; $totalvolamount += $empamount; $totalnssf +=$totamount;?>
	<td align="right" class="bodytext3"><?php echo number_format($totalnssf,3,'.',','); ?></td>
	<?php 
	}
	}
	}
	 ?>
	</tr>
	<tr>
	<td colspan="4" bgcolor="#ecf0f5" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalstdamount,3,'.',','); ?></strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalvolamount,3,'.',','); ?></strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalnssf,3,'.',','); ?></strong></td>
	</tr>
	<tr>
	<td colspan="10" align="left" class="bodytext3"><a href="print_progressive_pensionreport1.php?<?php eval(base64_decode('IGVjaG8gJHVybDsg')); ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a>
	&nbsp;&nbsp;&nbsp;<a href="print_progressive_pensionreportxl.php?<?php eval(base64_decode('IGVjaG8gJHVybDsg')); ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>
	</tr>
	</tbody>
	</table> 
	<?php 
	}
	 ?>
	</td>
  	</tr>
    </table>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

