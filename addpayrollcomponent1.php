<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$componentname = $_REQUEST["componentname"];
	$componentname = strtoupper($componentname);
	$componentname = trim($componentname);
	$typeexplode = $_REQUEST['type'];
	$typesplit = explode('||',$typeexplode);
	$typecode = $typesplit[0];
	$type = $typesplit[1];
	$amounttype = $_REQUEST['amounttype'];
	if(isset($_REQUEST['monthly']))
	{
		$monthly = $_REQUEST['monthly'];
	}
	else
	{
		$monthly = 'No';
	}
	if(isset($_REQUEST['notional']))
	{
		$notional = $_REQUEST['notional'];
	}
	else
	{
		$notional = 'No';
	}
	$deductearning = $_REQUEST['deductearning'];
	$maxvalue = $_REQUEST['maxvalue'];
	if(isset($_REQUEST['formula'])) { $formula = $_REQUEST['formula']; } else{ $formula = ''; }
	if($amounttype != 'Percent')
	{
		$formula = '';
	}
	$length=strlen($componentname);
	
	$searchsuppliername = $_REQUEST['searchsuppliername'];
	$searchsuppliercode = $_REQUEST['searchsuppliercode'];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_payrollcomponent where componentname = '$componentname'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_payrollcomponent (componentname, typecode, type, monthly, amounttype, ipaddress, updatetime, username, formula, notional,deductearning , notexceed, ledgercode, ledger) 
		values ('$componentname', '$typecode', '$type', '$monthly', '$amounttype', '$ipaddress', '$updatedatetime', '$username', '$formula', '$notional', '$deductearning', '$maxvalue', '$searchsuppliercode','$searchsuppliername')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$inserid = mysqli_insert_id($GLOBALS["___mysqli_ston"]);
		
		$exists = FALSE;
		$querychk = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'payroll_assign' AND COLUMN_NAME = '$inserid'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],$querychk) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$exists = (mysqli_num_rows($result))?TRUE:FALSE;
	
		if($exists == FALSE)
		{
			$alterquery = "ALTER TABLE `payroll_assign` ADD `$inserid` decimal(13,2) not null";
			$res123 = mysqli_query($GLOBALS["___mysqli_ston"],$alterquery) or die ("Error in Alterquery".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$alterquery1 = "ALTER TABLE `details_employeepayroll` ADD `$inserid` decimal(13,2) not null";
			$res1234 = mysqli_query($GLOBALS["___mysqli_ston"],$alterquery1) or die ("Error in Alterquery1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
			echo '#'.'Field defined already!<br/>';    
		}
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Payroll Component Already Exists.";
		$bgcolorcode = 'failed';
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
	
	header("location:addpayrollcomponent1.php");

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "select SUM(`$delanum`) as componentanum from payroll_assign where status <> 'deleted'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6componentanum = $res6['componentanum'];
	if($res6componentanum == '0' || $res6componentanum == '')
	{
		$query3 = "update master_payrollcomponent set recordstatus = 'deleted' where auto_number = '$delanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"],$query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$errmsg = "Failed. Payroll Component already Assigned to Employee.";
		$bgcolorcode = 'failed';
	}
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_payrollcomponent set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"],$query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


?>


<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.componentname.value == "")
	{
		alert ("Pleae Enter Componentname.");
		document.form1.componentname.focus();
		return false;
	}
	if (document.form1.type.value == "")
	{
		alert ("Pleae Select Type.");
		document.form1.type.focus();
		return false;
	}
	if(document.getElementById("amounttype").value == "")
	{
		alert("Please select Amount Type");
		document.getElementById("amounttype").focus();
		return false;
	}
	if(document.getElementById("amounttype").value == "Percent")
	{
		if(document.getElementById("formula").value == "")
		{
			alert("Please select Percent From");
			document.getElementById("formula").focus();
			return false;
		}
	}
}

function SelectRate()
{
	var chk1 = document.getElementById("monthly").checked;
	if(chk1 == true)
	{
		document.getElementById("amounttype").value = 'Rate';
	}
	else
	{
		document.getElementById("amounttype").value = '';
	}
}
/*function funcDeletePaymentType(varPaymentTypeAutoNumber)
{
    var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varPaymentTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Type Entry Delete Not Completed.");
		return false;
	}
	//return false;

}*/
function HideFormula1()
{
	document.getElementById("formulatr").style.display = "none";
	document.getElementById("formulatr1").style.display = "none";
	document.getElementById("deduct1").style.display = "none";
}

function Formula1()
{
	if(document.getElementById("amounttype").value == "Percent")
	{
		document.getElementById("formulatr").style.display = "";
		document.getElementById("formulatr1").style.display = "";
	}
	else
	{
		document.getElementById("formulatr").style.display = "none";
		document.getElementById("formulatr1").style.display = "none";
	}
}

function ShowDeduct()
{
	if(document.getElementById("type").value == "20||Deduction")
	{
		document.getElementById("deduct1").style.display = "";
	}
	else
	{
		document.getElementById("deduct1").style.display = "none";
	}
}

$(document).ready(function(){
	$('.earningledger').autocomplete({
	source:"ajaxpayrollledger.php?type=25",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				$("#searchsuppliercode").val(code);
			}
			},
    });
});	
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<body onLoad="return HideFormula1()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9tZW51MS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php eval(base64_decode('IC8vaW5jbHVkZSAoImluY2x1ZGVzL21lbnU0LnBocCIpOyA=')); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addpayrollcomponent1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payroll Component - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php  if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }  ?>" class="bodytext3"><div align="left"><?php eval(base64_decode('IGVjaG8gJGVycm1zZzsg')); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Component </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="componentname" id="componentname" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="type" id="type" onChange="return ShowDeduct()" style="border: 1px solid #001E6A;" title="Earning or Deduction">
						<option value="">Select</option>
						<option value="10||Earning">Earning</option>
						<option value="20||Deduction">Deduction</option>
						</select></td>
                      </tr>
					   <tr id="deduct1">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Deduct from Taxable Earnings </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="deductearning" id="deductearning" style="border: 1px solid #001E6A;" title="Deduct before PAYE Calculation">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Notional  </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="notional" id="notional" style="border: 1px solid #001E6A;" title="If Yes include only for Tax calculation">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="amounttype" id="amounttype" style="border: 1px solid #001E6A;" onChange="return Formula1()" title="Fixed value or Percent">
						<option value="">Select</option>
						<option value="Fixed">Fixed</option>
						<option value="Percent">Percent</option>
						</select></td>
                      </tr>
					   <tr id="formulatr">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="formula" id="formula" style="border: 1px solid #001E6A;" title="From BASIC or GROSS">
						<option value="">Select</option>
						<option value="1">BASIC</option>
						<option value="Gross">TOTAL GROSS</option>
						</select></td>
                      </tr>
					  <tr id="formulatr1">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Max Value</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" name="maxvalue" id="maxvalue" size="10" style="border: 1px solid #001E6A;" title="% amount should not exceed this value if not leave empty"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To Process Every Month </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="monthly" id="monthly" style="border: 1px solid #001E6A;" title="Changes every Month">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Ledger Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" class="earningledger" name="searchsuppliername" id="searchsuppliername" autocomplete="off" size="40" style="border: 1px solid #001E6A;" title="Account Ledger">
						<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="">
						</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="700" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Payment Component - Existing List </strong></td>
                      </tr>
					  <tr>
					  <td align="left" class="bodytext3"><strong>Delete</strong></td>
					  <td align="left" class="bodytext3"><strong>Component Name</strong></td>
					  <td align="left" class="bodytext3"><strong>Type</strong></td>
					  <td align="left" class="bodytext3"><strong>Amount</strong></td>
					  <td align="left" class="bodytext3"><strong>Monthly</strong></td>
					  <td align="left" class="bodytext3"><strong>Notional</strong></td>
					  <td align="left" class="bodytext3"><strong>Ledger</strong></td>
					  <td align="left" class="bodytext3"><strong>Edit</strong></td>
					  </tr>
                      <?php 
	    $query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$componentname = $res1["componentname"];
		$auto_number = $res1["auto_number"];
		$type = $res1['type'];
		$amounttype = $res1['amounttype'];
		$monthly = $res1['monthly'];
		$notional = $res1["notional"];
		$ledger = $res1['ledger'];

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
		<td width="7%" align="left" valign="top"  class="bodytext3">
		<div align="center">	
		<a href="addpayrollcomponent1.php?st=del&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>"> 
		<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
		<td width="25%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?> </td>
		<td width="15%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHR5cGU7IA==')); ?> </td>
		<td width="7%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGFtb3VudHR5cGU7IA==')); ?> </td>
		<td width="7%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG1vbnRobHk7IA==')); ?> </td>
		<td width="7%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG5vdGlvbmFsOyA=')); ?> </td>
		<td width="46%" align="left" valign="top"  class="bodytext3"><?php echo $ledger; ?></td>
		<td width="6%" align="left" valign="top"  class="bodytext3">
		<a href="editpayrollcomponent1.php?st=edit&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>" style="text-decoration:none">Edit</a>	
		</td>
	  </tr>
	  <?php 
		}
		 ?>
		  <tr>
			<td align="middle" colspan="3" >&nbsp;</td>
		  </tr>
		</tbody>
	  </table>
	<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<tbody>
		  <tr bgcolor="#011E6A">
			<td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong> Payroll Component - Deleted </strong></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Activate</strong></td>
		  <td align="left" class="bodytext3"><strong>Component Name</strong></td>
		  <td align="left" class="bodytext3"><strong>Type</strong></td>
		  <td align="left" class="bodytext3"><strong>Amount</strong></td>
		  <td align="left" class="bodytext3"><strong>Monthly</strong></td>
		  <td align="left" class="bodytext3"><strong>Notional</strong></td>
		  </tr>
		  <?php 
		
	    $query1 = "select * from master_payrollcomponent where recordstatus = 'deleted' order by componentname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$componentname = $res1["componentname"];
		$auto_number = $res1["auto_number"];
		$type = $res1['type'];
		$amounttype = $res1['amounttype'];
		$monthly = $res1['monthly'];
		$notional = $res1['notional'];

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
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addpayrollcomponent1.php?st=activate&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHR5cGU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGFtb3VudHR5cGU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG1vbnRobHk7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG5vdGlvbmFsOyA=')); ?></td>
                        </tr>
        <?php 
		}
		 ?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
              </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

