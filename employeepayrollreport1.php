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
$companyname = $res81['employername'];

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
}

?>
<?php
$totalbenefit = "0.00";
$nettotalbenefit = "0.00";
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
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
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
	<form action="employeepayrollreport1.php" method="post" name="form1" onSubmit="return from1submit1()">  
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
	<tr>
	<!--<td align="left" class="bodytext3">Search Month</td>
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
	</select></td>-->
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
	if($frmflag1 == 'frmflag1')
	{
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		//$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee";

	 ?>
	<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#ecf0f5">
	<td colspan="35" align="left" class="bodytext3"><strong>Payroll Employee Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="35" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php eval(base64_decode('IGVjaG8gJGNvbXBhbnljb2RlOyA=')); ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="35" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php eval(base64_decode('IGVjaG8gJGNvbXBhbnluYW1lOyA=')); ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="35" align="left" class="bodytext3"><strong>EMPLOYEE'S NAME : <?php eval(base64_decode('IGVjaG8gJHNlYXJjaGVtcGxveWVlOyA=')); ?></strong></td>
	</tr>
	<tr>
	<td width="26" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<!--<td width="101" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="99" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>-->
	<td width="35" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>MONTH</strong></td>
	<?php 
	$totalamount = '0.00';
	$query1 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	 ?>
	<td align="center" bgcolor="#ecf0f5" class="bodytext3" width="26"><strong><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?></strong></td>
	<?php 
	}
	 ?>
	 <td align="center" bgcolor="#ecf0f5" class="bodytext3" width="26"><strong>GROSS PAY</strong></td>
	 <td align="center" bgcolor="#ecf0f5" class="bodytext3" width="26"><strong>DEDUCTION</strong></td>
	 <td align="center" bgcolor="#ecf0f5" class="bodytext3" width="26"><strong>NOTIONAL BENEFIT</strong></td>
	 <td align="center" bgcolor="#ecf0f5" class="bodytext3" width="26"><strong>NET PAY</strong></td>
	</tr>
	<?php 
	$totalamount = '0.00';
	
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
		$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
		$totalgrossper = 0;
		$totaldeduct = 0;
	
	$query2 = "select employeecode, employeename from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename ORDER BY employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
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
	<td align="center" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbG9ybG9vcGNvdW50OyA=')); ?></td>
	<!--<td align="left" class="bodytext3"><?php eval(base64_decode('IC8vZWNobyAkcmVzMmVtcGxveWVlY29kZTsg')); ?></td>
	<td align="left" class="bodytext3"><?php eval(base64_decode('IC8vZWNobyAkcmVzMmVtcGxveWVlbmFtZTsg')); ?></td>-->
	<td align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gZGF0ZSgnRicsc3RydG90aW1lKCRhcnJheW1vbnRoWyRpXSkpOyA=')); ?></td>	
	<?php 
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number']; 

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];

	 ?>
	<td align="right" class="bodytext3" width="26"><?php  if($componentamount > 0) { echo number_format($componentamount,0,'.',','); }  ?></td>	
	<?php
	}
	$query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res12 = mysqli_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		$typecode = $res12['typecode'];
		
		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resgg = mysqli_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		if($typecode == 10){
		$totalgrossper = $totalgrossper + $res12value; }
		else { 
		$totaldeduct = $totaldeduct + $res12value; }
	}
	$res9grosspay = $totalgrossper;
	?>
	<td align="right" class="bodytext3"><?php if($res9grosspay > 0) { echo number_format($res9grosspay,0,'.',','); } ?></td>	
	<?php
	$res91deduction = $totaldeduct;
	?>
	<td align="right" class="bodytext3"><?php if($res91deduction > 0) { echo number_format($res91deduction,0,'.',','); } ?></td>	
	<?php
	$totalbenefit = '0';
	?>
	<td align="right" class="bodytext3"><?php if($totalbenefit > 0) { echo number_format($totalbenefit,0,'.',','); } ?></td>	
	<?php
	$res92nettpay = $res9grosspay - $res91deduction;
	?>
	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,0,'.',','); } ?></td>
	<?php 
	}
	?>
	</tr>
	<?php 
	}
	?>
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

