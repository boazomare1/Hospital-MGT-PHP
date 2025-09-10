<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = '';
$pagename = "";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["frmflag12"])) { $frmflag12 = $_REQUEST["frmflag12"]; } else { $frmflag12 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if ($frmflag12 == 'frmflag12')
{
	$employeecode = $_REQUEST['searchemployeecode'];
	$employeename = $_REQUEST['searchemployee'];
	$employeename = strtoupper($employeename);
	$insurancename = $_REQUEST['insurancename'];
	$premium = $_REQUEST['premium'];
	$taxpercent = $_REQUEST['taxpercent'];
	$includepaye = $_REQUEST['includepaye'];
	$includededuction = $_REQUEST['includededuction'];
	$editanum = $_REQUEST['editanum'];
	
	$query10 = "select * from insurance_relief where employeecode = '$employeecode'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"],$query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$res10employeecode = $res10['employeecode']; 
	if($res10employeecode != '')
	{	
		$query4 = "update insurance_relief set  insurancename = '$insurancename', premium = '$premium', taxpercent = '$taxpercent', ipaddress = '$ipaddress', 
		username = '$username', updatedatetime = '$updatedatetime', includepaye = '$includepaye', includededuction = '$includededuction' where auto_number = '$editanum'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"],$query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		header("location:insurancerelief.php?st=success");
	}
	else
	{
		header("location:insurancerelief.php?st=failed");
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. Insurance Relief Updated.";
}
else if ($st == 'failed')
{
	$errmsg = "Failed. Insurance Relief Not Updated.";
}

else if($st == 'edit')
{
$editanum = $_REQUEST['anum'];
$query7 = "select * from insurance_relief where auto_number = '$editanum'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"],$query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$employeecode7 = $res7['employeecode'];
	$employeename7 = $res7['employeename'];
	$employeename7 = strtoupper($employeename7);
	$insurancename7 = $res7['insurancename'];
	$premium7 = $res7['premium'];
	$taxpercent7 = $res7['taxpercent'];
	$includepaye7 = $res7['includepaye'];
	$includededuction7 = $res7['includededuction']; 
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script language="javascript">

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
}

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

function WindowRedirect()
{
	window.location = "editemployeeinfo1.php";
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function process1()
{
	if(document.getElementById("employeename").value == "")
	{
		alert("Please Enter Employeename");
		document.getElementById("employeename").focus();
		return false;
	}
	if(document.getElementById("employeecode").value == "")
	{
		alert("Please Select Employeename");
		//document.getElementById("employeename").focus();
		return false;
	}
}

function from1submit1()
{
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
	if(document.getElementById("searchemployeecode").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
	if(document.getElementById("insurancename").value == "")
	{
		alert("Please Enter Insurance Name");
		document.getElementById("insurancename").focus();
		return false;		
	}
	if(document.getElementById("premium").value == "")
	{
		alert("Please Enter Premium");
		document.getElementById("premium").focus();
		return false;		
	}
	if(isNaN(document.getElementById("premium").value))
	{
		alert("Please Enter Number");
		document.getElementById("premium").focus();
		return false;		
	}
	if(isNaN(document.getElementById("taxpercent").value))
	{
		alert("Please Enter Number");
		document.getElementById("taxpercent").focus();
		return false;		
	}
	if(document.getElementById("taxpercent").value == "")
	{
		alert("Please Enter Taxpercent");
		document.getElementById("taxpercent").focus();
		return false;		
	}
}


</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		 <form name="form2" id="form2" method="post" onKeyDown="return disableEnterKey()" action="editinsurancerelief.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="5" align="left" class="bodytext3"><strong>Insurance Relief - Edit</strong></td>
	</tr>
	<?php if($errmsg != '') { ?>
	<tr bgcolor="#00FF66">
	<td colspan="5" align="left" class="bodytext3"><strong><?php echo $errmsg; ?></strong></td>
	</tr>
	<?php } ?>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $employeename7; ?>" readonly size="40" style="border:solid 1px #001E6A;">
	<input type="text" name="searchemployeecode" id="searchemployeecode" size="20" value="<?php echo $employeecode7; ?>" readonly style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Insurance Name</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="text" name="insurancename" id="insurancename" value="<?php echo $insurancename7; ?>" size="40" style="border:solid 1px #001E6A;">
	</td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Premium Per Month</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="text" name="premium" id="premium" value="<?php echo $premium7; ?>" size="20" style="border:solid 1px #001E6A;">
	</td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Tax Percent</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="text" name="taxpercent" id="taxpercent" value="<?php echo $taxpercent7; ?>" size="20" style="border:solid 1px #001E6A;">
	</td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Include in PAYE</td>
	<td colspan="4" align="left" class="bodytext3">
	<select name="includepaye" id="includepaye" style="border:solid 1px #001E6A;">
	<?php if($includepaye7 != '') { ?>
	<option value="<?php echo $includepaye7; ?>"><?php echo $includepaye7; ?></option>
	<?php } ?>
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select>
	</td>
	</tr>
    <tr>
	<td width="95" align="left" class="bodytext3">Include in Deduction</td>
	<td colspan="4" align="left" class="bodytext3">
	<select name="includededuction" id="includededuction" style="border:solid 1px #001E6A;">
	<?php if($includededuction7 != '') { ?>
	<option value="<?php echo $includededuction7; ?>"><?php echo $includededuction7; ?></option>
	<?php } ?>
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select>
	</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag12" id="frmflag12" value="frmflag12">
    <input type="hidden" name="editanum" id="editanum" value="<?php echo $editanum; ?>">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

