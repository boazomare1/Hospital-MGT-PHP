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

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{	
	$anum = $_REQUEST['anum'];
	$rate = $_REQUEST['rate'];
	//$rate2 = $_REQUEST['rate2'];
	$calculationanum = $_REQUEST['calculationanum'];
	$totalhours = $_REQUEST['totalhours'];
	$basedon = $_REQUEST['basedon'];
	$totalmonth = $_REQUEST['totalmonth'];
	$totaldays = $_REQUEST['totaldays'];
	
	$query21 = "update master_otcalculation set rate = '$rate', calculationanum = '$calculationanum', totalhours = '$totalhours', ipaddress = '$ipaddress', username = '$username', 
	updatedatetime = '$updatedatetime', basedon = '$basedon', totalmonth = '$totalmonth', totaldays = '$totaldays' where auto_number = '$anum'"; 
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

	header("location:otcalculation1.php");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
//$st = $_REQUEST['st'];
if ($st == 'edit')
{	
	$editanum = $_REQUEST['anum'];
	$query5 = "select * from master_otcalculation where auto_number = '$editanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$rate1 = $res5['rate'];
	$totalhours1 = $res5['totalhours'];
	$basedon1 = $res5['basedon'];
	$totalmonth1 = $res5['totalmonth'];
	$totaldays1 = $res5['totaldays'];
	$calculationanum1 = $res5['calculationanum'];
	if($calculationanum1 == '1')
	{
		$foranum = '1';
		$forname = 'BASIC PAY';
	}
	else
	{
		$foranum = '2';
		$forname = 'GROSS PAY';
	}
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
	if(document.getElementById("rate").value != "")
	{
		if(isNaN(document.getElementById("rate").value))
		{
			alert("Please Enter Numbers");
			document.getElementById("rate").focus();
			return false;
		}
	}
	else
	{
		alert("Please Enter Rate ");
		document.getElementById("rate").focus();
		return false;
	}
	if(document.getElementById("calculationanum").value == "")
	{
		alert("Please Select Based on");
		document.getElementById("calculationanum").focus();
		return false;
	}
	if(document.getElementById("totalhours").value == "")
	{
		alert("Please Enter Totalhours");
		document.getElementById("totalhours").focus();
		return false;
	}
	if(isNaN(document.getElementById("totalhours").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("totalhours").focus();
		return false;
	}	
	
}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body onLoad="return bodyonload1()"> <!--onkeydown="escapekeypressed(event)"-->
<form name="form1" id="form1" method="post" action="editot1.php" onSubmit="return from1submit1()">
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
	<td width="432" align="left" valign="top" class="bodytext3">
	<table width="50%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td colspan="3" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>Master for OT Calculation - Edit</strong></td>
	</tr>
 	</thead>
	<tbody>
	<tr>
	<td width="42%" align="left" class="bodytext3">Rate for OT</td>
	<td width="58%" align="left" class="bodytext3">
	<input type="hidden" name="anum" id="anum" value="<?php echo $anum;?>">
	<input type="text" name="rate" id="rate" value="<?php echo $rate1; ?>" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Overtime Calculated on</td>
	<td align="left" class="bodytext3">
	<select name="calculationanum" id="calculationanum">
	<?php if($calculationanum1 != '') { ?>
	<option value="<?php echo $foranum; ?>"><?php echo $forname; ?></option>
	<?php } ?>
	<option value="">Select</option>
	<option value="1">BASIC PAY</option>
	<option value="2">GROSS PAY</option>
	</select>
	</td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">OT Based on</td>
	<td align="left" class="bodytext3"><select name="basedon" id="basedon">
	<?php if($basedon1 != '') { ?>
	<option value="<?php echo $basedon1; ?>"><?php echo $basedon1; ?></option>
	<?php } ?>
	<option value="Hours">Hours</option>
	</select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Work Hours</td>
	<td align="left" class="bodytext3"><input type="text" name="totalhours" id="totalhours" value="<?php echo $totalhours1; ?>" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Work Days</td>
	<td align="left" class="bodytext3"><input type="text" name="totaldays" id="totaldays" value="<?php echo $totaldays1; ?>" size="5">
	<input type="hidden" name="totalmonth" id="totalmonth" value="<?php echo $totalmonth1; ?>" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">&nbsp;</td>
	<td align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="submit" value="Submit">
	</td>
	</tr>
	</tbody>	
	</table>
	</td>
	</tr>
	<tr>
	<td width="432" align="left" valign="top" class="bodytext3">
	</td>
	</tr>
	</tbody>
	</table> 
	</td>
  	</tr>
    </table>
	</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

