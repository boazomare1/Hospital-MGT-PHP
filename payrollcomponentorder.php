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
	$orderno = $_REQUEST['orderno'];
	foreach($orderno as $key => $value)
	{
		$query88 = "UPDATE master_payrollcomponent SET order_no = '$value' WHERE auto_number = '$key'";
		mysqli_query($GLOBALS["___mysqli_ston"],$query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	header("location:payrollcomponentorder.php?st=success");
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
<script type="text/javascript" src="js/autosuggestemployeesearch12.js"></script>
<script type="text/javascript" src="js/autoemployeecodesearch4.js"></script>
<script type="text/javascript" src="js/autoemployeepayrolledit1.js"></script>
<!--<script type="text/javascript" src="js/deductioncalculation1.js"></script>-->
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
{}

function EarningAllow(i)
{}

function DeductionAllow(j)
{}

</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<form name="form1" id="form1" method="post" action="payrollcomponentorder.php">
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
    <td width="99%" valign="top">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody id="assigntr">
	<tr bgcolor="#ecf0f5">
	<td colspan="2" align="left" class="bodytext3"><strong>Payroll Components</strong></td>
	</tr>
    <tr bgcolor="#FFF">
	<td align="left" class="bodytext3"><strong>Earnings</strong></td>
	<td align="left" class="bodytext3"><strong>Deduction</strong></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="400" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr>
	<td colspan="3" align="left" class="bodytext3"><strong>Component</strong></td>
	<td align="left" class="bodytext3"><strong>Order No</strong></td>
	</tr>
	<?php 
	$eno = '';
	$query5 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and type = 'Earning' order by auto_number, componentname";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"],$query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res5 = mysqli_fetch_array($exec5))
	{
	$eno = $eno + 1;
	$res5anum = $res5['auto_number'];
	$res5componentname = $res5['componentname'];
	if($res5['order_no'] > 0){
	$order_no5 = $res5['order_no'];
	} else {
	$order_no5 = ''; 
	}
	?>
	<tr>
	<td colspan="3" width="65" align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHJlczVjb21wb25lbnRuYW1lOyA=')); ?></td>
	<td width="28" align="left" class="bodytext3"><input type="text" name="orderno[<?php echo $res5anum; ?>]" id="orderno<?php echo $res5anum; ?>" value="<?php echo $order_no5; ?>" size="10"></td>
	</tr>
	<?php 
	}
	 ?>
	</table>
	</td>
	<td valign="top">
	<table width="400" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr>
	<td colspan="3" align="left" class="bodytext3"><strong>Component</strong></td>
	<td align="left" class="bodytext3"><strong>Order No</strong></td>
	</tr>
	<?php 
	$dno = '';
	$query6 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and type = 'Deduction' order by auto_number, componentname";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res6 = mysqli_fetch_array($exec6))
	{
	$dno = $dno + 1;
	$res6anum = $res6['auto_number'];
	$res6componentname = $res6['componentname'];
	if($res6['order_no'] > 0){
	$order_no6 = $res6['order_no'];
	} else {
	$order_no6 = ''; 
	}
	?>
	<tr>
	<td colspan="3" width="142" align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHJlczZjb21wb25lbnRuYW1lOyA=')); ?></td>
	<td width="81" align="left" class="bodytext3"><input name="orderno[<?php echo $res6anum ?>]" id="orderno<?php echo $res6anum ?>" value="<?php echo $order_no6; ?>" size="10"></td>
	</tr>
	<?php 
	}
	 ?>
	</table>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Submit" value="Submit">
	</tbody>
	</table>
	</td>
	</tr>
    </table>
	</form>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

