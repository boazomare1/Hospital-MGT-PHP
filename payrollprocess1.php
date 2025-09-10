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
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }

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
$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Process - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payrollprocess1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script>
<script type="text/javascript" src="js/autosuggestemployeepayrollprocess1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autoemployeepayroll1.js"></script>
<script type="text/javascript" src="js/autoemployeeloan1.js"></script>
<script type="text/javascript" src="js/autoemployeecheckpayrollprocess1.js"></script>
<script type="text/javascript" src="js/autoemployeepayrollprocess1.js"></script>
<script type="text/javascript" src="js/autoemployeeloandetails2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autoemployeepayrollprocessall1.js"></script>
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

function TrSelect(TRid)
{	
	//alert(TRid);
	var TRid = TRid;
	var TRidsplit = TRid.split('||');
	var varEmployeecode = TRidsplit[1];
	var varActiveElementNumber = TRidsplit[0];
	//var varActiveNumber = TRid;
	//alert(TRid);
	var varEmployeeCodeCatch =  document.getElementById("employeecode"+varActiveElementNumber).value;
	//alert (varCustomerCodeCatch);
	var varEmployeeNameCatch =  document.getElementById("employeename"+varActiveElementNumber).value;
	//alert (varCustomerNameCatch);
	
	document.getElementById("employeecode").value = varEmployeeCodeCatch;
	document.getElementById("employeename").value = varEmployeeNameCatch;
	document.getElementById("searchemployeecode").value = varEmployeeCodeCatch;
	document.getElementById("searchemployeename").value = varEmployeeNameCatch;
	
	for(i=1;i<200;i++)
	{
		if(i==varActiveElementNumber)
		{
			if(document.getElementById("idTD1"+i) != null)
			{
			document.getElementById("empserialnumber"+i).checked = "checked";
			document.getElementById("idTD1"+i).style.backgroundColor="#99FF00";
			document.getElementById("idTD2"+i).style.backgroundColor="#99FF00";
			document.getElementById("idTD3"+i).style.backgroundColor="#99FF00";
			document.getElementById("empserialnumber"+i).style.backgroundColor="#99FF00";
			document.getElementById("employeecode"+i).style.backgroundColor="#99FF00";
			document.getElementById("employeename"+i).style.backgroundColor="#99FF00";
			}
		}
		else
		{
			if(document.getElementById("idTD1"+i) != null)
			{
			//document.getElementById("empserialnumber"+i).checked = "";
			document.getElementById("idTD1"+i).style.backgroundColor="#FFFFFF";
			document.getElementById("idTD2"+i).style.backgroundColor="#FFFFFF";
			document.getElementById("idTD3"+i).style.backgroundColor="#FFFFFF";
			document.getElementById("empserialnumber"+i).style.backgroundColor="#FFFFFF";
			document.getElementById("employeecode"+i).style.backgroundColor="#FFFFFF";
			document.getElementById("employeename"+i).style.backgroundColor="#FFFFFF";
			}
		}
	}
	
	EmployeeLoanmonthwise2();
}

</script>
<script type="text/javascript">

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  	//employeesearch6();
}


</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
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
}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Processing <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
<form name="form1" id="form1" method="post" action="payrollprocess1.php" onSubmit="return from1submit1()">
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php include ("includes/menu1.php"); ?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="80%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FF9900">
	<td colspan="3" align="left" class="bodytext3"><strong>Payroll Process</strong>
	<td colspan="3" align="right" class="bodytext3"><strong><?php echo 'Location : '.$locationname; ?></strong>
	<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>">
	<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>"></td>
	</tr>
	<tr>
	<td colspan="3" width="432" align="left" valign="top" class="bodytext3">
	<div style="height:350px;overflow:auto;border:solid 1px #ecf0f5;">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td colspan="4" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>Employee</strong>
	<input type="hidden" name="employeecode" id="employeecode">
	<input type="hidden" name="employeename" id="employeename">
	<input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
	</td>
	</tr>
	<tr>
	<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
	<input name="searchsuppliername" id="searchsuppliername" accesskey="s" autocomplete="off" type="text" size="30" />
	<input type="text" name="assignmonth" id="assignmonth" readonly value="<?php echo $month; ?>" size="10">
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth','MMMYYYY')" style="cursor:pointer"/></td>
  	</tr>
 	</thead>
	<tbody id="tblrowinsert">

	</tbody>	
	</table>
	</div>
	</td>
	<td colspan="3" width="452" align="left" valign="top" class="bodytext3">
	<div style="height:350px;overflow:auto;border:solid 1px #ecf0f5;">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr>
	<td colspan="6" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>Payroll Components</strong>
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" readonly>
	<input type="hidden" name="searchemployeename" id="searchemployeename" readonly></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td align="left" class="bodytext3"><strong>Type</strong></td>
	<td align="left" class="bodytext3"><strong>Component</strong></td>
	<td align="right" class="bodytext3"><strong>&nbsp;</strong></td>
	<td align="right" class="bodytext3"><strong>&nbsp;</strong></td>
	<td align="right" class="bodytext3"><strong>Amount</strong></td>
	<td align="right" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr>
	<td>
	<input type="hidden" name="serialno" id="serialno" value="1" size="1">
	</thead>
	<tbody id="tblrowinsert1">

	</tbody>	
	</table>
	</div>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="left" class="bodytext3"><input type="button" value="Process Selected" onClick="return CheckPayrollProcess('selected')"></td>
	<td colspan="4" align="left" class="bodytext3"><input type="button" value="Process All" onClick="return CheckPayrollProcess('all')"></td>
	</tr>
	<tr>
	<td align="right" class="bodytext3"><strong>Gross Pay :</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="grosspay" id="grosspay" size="10" readonly style="text-align:right;"></td>
	<td align="right" class="bodytext3"><strong>Total Deductions :</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="totaldeductions" id="totaldeductions" size="10" readonly style="text-align:right;"></td>
	<td align="right" class="bodytext3"><strong>Nett Pay :</strong></td>
	<td align="left" class="bodytext3"><input type="text" name="nettpay" id="nettpay" size="10" readonly style="text-align:right;"></td>
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

