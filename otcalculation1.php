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
	$rate1 = $_REQUEST['rate1'];
	$rate2 = $_REQUEST['rate2'];
	$calculationanum = $_REQUEST['calculationanum'];
	$totalhours = $_REQUEST['totalhours'];
	$basedon = $_REQUEST['basedon'];
	$totalmonth = $_REQUEST['totalmonth'];
	$totaldays = $_REQUEST['totaldays'];
	$query7 = "select * from master_otcalculation where componentanum = '3'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows = mysqli_num_rows($exec7);
	if($rows == 0)
	{
		$query1 = "insert into master_otcalculation(componentname, componentanum, rate, calculationanum, totalhours, ipaddress, username, updatedatetime, basedon, totalmonth, totaldays)
		values('OT 1', '3', '$rate1', '$calculationanum', '$totalhours', '$ipaddress', '$username', '$updatedatetime', '$basedon', '$totalmonth', '$totaldays')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$query2 = "update master_otcalculation set rate = '$rate1', calculationanum = '$calculationanum', totalhours = '$totalhours', ipaddress = '$ipaddress', username = '$username', 
		updatedatetime = '$updatedatetime', basedon = '$basedon', totalmonth = '$totalmonth', totaldays = '$totaldays' where componentanum = '3'"; 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query8 = "select * from master_otcalculation where componentanum = '4'";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows8 = mysqli_num_rows($exec8);
	if($rows8 == 0)
	{
		$query11 = "insert into master_otcalculation(componentname, componentanum, rate, calculationanum, totalhours, ipaddress, username, updatedatetime, basedon, totalmonth, totaldays)
		values('OT 2', '4', '$rate2', '$calculationanum', '$totalhours', '$ipaddress', '$username', '$updatedatetime', '$basedon', '$totalmonth', '$totaldays')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$query21 = "update master_otcalculation set rate = '$rate2', calculationanum = '$calculationanum', totalhours = '$totalhours', ipaddress = '$ipaddress', username = '$username', 
		updatedatetime = '$updatedatetime', basedon = '$basedon', totalmonth = '$totalmonth', totaldays = '$totaldays' where componentanum = '4'"; 
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	header("location:otcalculation1.php?st=success");
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
	if(document.getElementById("rate1").value != "")
	{
		if(isNaN(document.getElementById("rate1").value))
		{
			alert("Please Enter Numbers");
			document.getElementById("rate1").focus();
			return false;
		}
	}
	else
	{
		alert("Please Enter Rate 1");
		document.getElementById("rate1").focus();
		return false;
	}
	if(document.getElementById("rate2").value != "")
	{
		if(isNaN(document.getElementById("rate2").value))
		{
			alert("Please Enter Numbers");
			document.getElementById("rate2").focus();
			return false;
		}
	}
	else
	{
		alert("Please Enter Rate 2");
		document.getElementById("rate2").focus();
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
<form name="form1" id="form1" method="post" action="otcalculation1.php" onSubmit="return from1submit1()">
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
	<td colspan="3" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>Master for OT Calculation</strong></td>
	</tr>
 	</thead>
	<tbody>
	<tr>
	<td width="42%" align="left" class="bodytext3">Rate for Weekdays (OT 1)</td>
	<td width="58%" align="left" class="bodytext3"><input type="text" name="rate1" id="rate1" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Rate for Weekends (OT 2)</td>
	<td align="left" class="bodytext3"><input type="text" name="rate2" id="rate2" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Overtime Calculated on</td>
	<td align="left" class="bodytext3">
	<select name="calculationanum" id="calculationanum">
	<option value="">Select</option>
	<option value="1"><?php echo 'BASIC PAY'; ?></option>
	<option value="2"><?php echo 'GROSS PAY'; ?></option>
	</select>
	</td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">OT Based on</td>
	<td align="left" class="bodytext3"><select name="basedon" id="basedon">
	<option value="Hours">Hours</option>
	</select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Work Hours</td>
	<td align="left" class="bodytext3"><input type="text" name="totalhours" id="totalhours" size="5"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Work Days</td>
	<td align="left" class="bodytext3"><input type="text" name="totaldays" id="totaldays" size="5">
	<input type="hidden" name="totalmonth" id="totalmonth" size="5"></td>
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
	<table width="60%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr bgcolor="#ecf0f5">
	<td align="left" colspan="9" class="bodytext3"><strong>OT Calculation - Existing</strong></td>
	</tr>
	<tr>
	<td width="17%" align="left" class="bodytext3"><strong>Component</strong></td>
	<td width="11%" align="left" class="bodytext3"><strong>Rate</strong></td>
	<td width="22%" align="left" class="bodytext3"><strong>Calculation On</strong></td>
	<td width="22%" align="left" class="bodytext3"><strong>Total Hours</strong></td>
	<td width="16%" align="left" class="bodytext3"><strong>Based On</strong></td>
	<!--<td width="22%" align="left" class="bodytext3"><strong>Total Month</strong></td>-->
	<td width="22%" align="left" class="bodytext3"><strong>Total Days</strong></td>
	<td width="9%" align="left" class="bodytext3"><strong>Edit</strong></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$query5 = "select * from master_otcalculation where status <> 'deleted' order by componentname";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res5 = mysqli_fetch_array($exec5))
	{
	$auto_number = $res5['auto_number'];
	$rate = $res5['rate'];
	$componentname = $res5['componentname'];
	$totalhours = $res5['totalhours'];
	$calculationanum = $res5['calculationanum'];
	if($calculationanum == '2')
	{
		$build = 'GROSS PAY';
	}
	else if($calculationanum == '1')
	{
		$build = 'BASIC PAY';
	}
	$basedon = $res5['basedon'];
	$totalmonth = $res5['totalmonth'];
	$totaldays = $res5['totaldays'];
	
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
	<td align="left" class="bodytext3"><?php echo $componentname; ?></td>
	<td align="left" class="bodytext3"><?php echo $rate; ?></td>
	<td align="left" class="bodytext3"><?php echo $build; ?></td>
	<td align="left" class="bodytext3"><?php echo $totalhours; ?></td>
	<td align="left" class="bodytext3"><?php echo $basedon;?></td>
	<!--<td align="left" class="bodytext3"><?php echo $totalmonth; ?></td>-->
	<td align="left" class="bodytext3"><?php echo $totaldays; ?></td>
	<td align="left" class="bodytext3">
	<a href="editot1.php?st=edit&&anum=<?php echo $auto_number; ?>">Edit</a></td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	</tbody>
	</table> 
	</td>
  	</tr>
    </table>
	</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

