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
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchstatus"])) { $searchstatus = $_REQUEST["searchstatus"]; } else { $searchstatus = "Active"; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag2 == 'frmflag2')
{	
     $updatestatus = $_REQUEST['updatestatus'];
     $anumarray = $_REQUEST['anum'];	
	foreach($anumarray as $anum)
	{
		//echo $anum;
		$query12 = "update master_employee set payrollstatus = '$updatestatus' where auto_number = '$anum'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"],$query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	header("location:employeelist1.php?st=success");
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
	if(document.getElementById("updatestatus").value == "")
	{
		alert("Select Status");
		document.getElementById("updatestatus").focus();
		return false;
	}  
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
	<form name="form1" id="form1" method="post" action="employeelist1.php">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Employee</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Status</td>
	<td width="63" align="left" class="bodytext3"><select name="searchstatus" id="searchstatus">
	<?php if($searchstatus != '') { ?>
	<option value="<?php echo $searchstatus; ?>"><?php echo $searchstatus; ?></option>
	<?php } ?>
	<option value="Active">Active</option>
	<option value="Inactive">Inactive</option>
	<option value="Prorata">Prorata</option>
	</select></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td width="56" align="left" class="bodytext3">&nbsp;</td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Search" style="border:solid 1px #001E6A;"></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
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
	<form name="form2" id="form2" method="post" action="employeelist1.php" onSubmit="return from1submit1()">
	<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Employee List</strong></td>
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>Select</strong></td>
			<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>PAYROLL NUMBER</strong></td>

	<td width="105" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="217" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>STATUS</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query2 = "select * from master_employee where employeename like '%$searchemployee%' and payrollstatus = '$searchstatus' order by employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$anum = $res2['auto_number'];
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	$res2status = $res2['payrollstatus'];
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' ";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);

	$payrollno = $res6['payrollno'];
	
	$query22 = "select employeecode from payroll_assign where employeecode = '$res2employeecode' group by employeecode";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"],$query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res22 = mysqli_num_rows($exec22);
	if($res22 > 0)
	{
	
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
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>

	<td align="center" class="bodytext3"><input type="checkbox" name="anum[]" id="anum[]" value="<?php echo $anum; ?>"></td>
					<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>

	<td align="left" class="bodytext3"><?php echo $res2employeecode; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2status; ?></td>	
	</tr>
	<?php
	}
	}
	?>
	<tr>
	<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="2" align="left" class="bodytext3"><strong>Status</strong></td>
	<td align="left" class="bodytext3"><strong><select name="updatestatus" id="updatestatus">
	<option value="">Select</option>
	<option value="Active">Active</option>
	<option value="Inactive">Inactive</option>
	<option value="Prorata">Prorata</option>	
	</select></strong></td>
	<td colspan="2" align="left"><input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
	<input type="submit" name="submit111" value="Submit"></td>
	</tr>
	</tbody>
	</table> 
	</form>
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

