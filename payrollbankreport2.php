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
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
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
    <td  valign="top">
	<form name="form1" id="form1" method="post" action="payrollbankreport2.php" onSubmit="return from1submit1()">
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
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Bank</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="text" name="searchbank" id="searchbank" autocomplete="off" value="<?php echo $searchbank; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Search Month</td>
	<td width="63" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
	<?php if($searchmonth != '') { ?>
	<option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
	<?php } ?>
	<?php
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	?>
	<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
	<?php
	}
	?>
	</select></td>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php if($searchyear != '') { ?>
	<option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
	<?php } ?>
	<?php
	for($j=2010;$j<=date('Y');$j++)
	{
	?>
	<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
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
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
		if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }

		$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchbank=$searchbank";

	?>	
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#ecf0f5">
	<td colspan="9" align="left" class="bodytext3"><strong>PAYMENT REGISTER </strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>EMPLOYER'S PIN : <?php echo $companycode; ?></strong></td>
		<td rowspan="3" align="right" class="bodytext3"> 
			<a href="print_bankreportpdf.php?<?php echo $url; ?>" target="_blank" ><img src="images/pdfdownload.jpg" width="40" height="40"></a>
			
		</td>
		<td rowspan="3" align="left" class="bodytext3">
			<a href="print_bankreportexl.php?<?php echo $url; ?>" target="_blank" ><img src="images/excel-xls-icon.png" height="40" width="40"></a>
			
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td colspan="7" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr>
	<td colspan="9" align="right" class="bodytext3"></td>
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>BR</strong></td>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>DPT</strong></td>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>NUMBER</strong></td>
	<td width="280" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="305" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>BRANCH NAME</strong></td>
	<td width="25" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ACCOUNT NO</strong></td>
	<td width="77" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>NET PAY</strong></td>
	<td width="47" align="left" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by employeecode,bankname";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"],$query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res9 = mysqli_fetch_array($exec9))
	{
	$res9bankname = $res9['bankname'];
		
	?>
	<!--
	<tr>
	<td colspan="9" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $res9bankname; ?></strong></td>
	</tr> 
	-->
	<?php
	
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a JOIN master_employee b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' and (b.payrollstatus = 'Active' or b.payrollstatus = 'Prorata') group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	
	$bankname = $res6['bankname'];
	$bankbranch = $res6['bankbranch'];
	$accountnumber = $res6['accountnumber'];
	$payrollno = $res6['payrollno'];
	$departmentname = $res6['departmentname'];
	
	
	if($accountnumber != '')
	{ 

	$query61 = "select auto_number from master_payrolldepartment where department = '$departmentname'";
	$exec61 = mysqli_query($GLOBALS["___mysqli_ston"],$query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resnum61 = mysqli_num_rows($exec61);
	if($resnum61 > 0){
		$res61 = mysqli_fetch_array($exec61);
		$departmentautono = $res61['auto_number'];
	
	}else{
		$departmentautono = '';
	}

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
	<tr <?php echo $colorcode; ?>>
	<td width="25" align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td width="25" align="center" class="bodytext3"><?php echo '1'; ?></td>
	<td width="25" align="left" class="bodytext3"><?php echo $departmentautono; ?></td>
	<td width="25" align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td width="280" align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td width="305" align="left" class="bodytext3"><?php echo $bankname." - ".$bankbranch; ?></td>
	<td width="25" align="left" class="bodytext3"><?php echo $accountnumber; ?></td>
	<?php
	$totaldeduct = 0;
	$totalgrossper = 0;
	$query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res12 = mysqli_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		$typecode = $res12['typecode'];
		
		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$execgg = mysqli_query($GLOBALS["___mysqli_ston"],$querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resgg = mysqli_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		if($typecode == 10){
		$totalgrossper = $totalgrossper + $res12value; }
		else { 
		$totaldeduct = $totaldeduct + $res12value; }
	}
	$componentamount = $totalgrossper - $totaldeduct;
	$totalamount = $totalamount + $componentamount;
	?>
	<td width="77" align="right" class="bodytext3"><?php echo number_format($componentamount,0,'.',','); ?></td>
	<td width="47" align="right" class="bodytext3">&nbsp;</td>	
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="7" bgcolor="#ecf0f5" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3" width="47">&nbsp;</td>
	</tr>

	</tbody>
	</table> 
	<?php
	}
	?>
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

