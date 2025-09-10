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



include ("autocompletebuild_payroll.php");



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$editanum = $_REQUEST['editanum'];

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

	$resetmonthly = $_REQUEST['resetmonthly'];

	

	$searchsuppliername = $_REQUEST['searchsuppliername'];

	$searchsuppliercode = $_REQUEST['searchsuppliercode'];

	if(isset($_REQUEST['formula'])) { $formula = $_REQUEST['formula']; } else{ $formula = ''; }

	if($amounttype != 'Percent')

	{

		$formula = '';

	}

	$length=strlen($componentname);

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_payrollcomponent where auto_number = '$editanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0)

	{

		$query1 = "update master_payrollcomponent set componentname = '$componentname', typecode = '$typecode', type = '$type', monthly = '$monthly', amounttype = '$amounttype', ipaddress = '$ipaddress', 

		updatetime = '$updatedatetime', username = '$username', formula = '$formula', notional = '$notional',deductearning = '$deductearning', notexceed = '$maxvalue', resetmonthly = '$resetmonthly', ledgercode = '$searchsuppliercode', ledger = '$searchsuppliername' where auto_number = '$editanum'"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$errmsg = "Success. Payroll Component Updated.";

		$bgcolorcode = 'success';

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Payroll Component Not Edited.";

		$bgcolorcode = 'failed';

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		$bgcolorcode = 'failed';

	}

	

	header('location:addpayrollcomponent1.php');

	exit;



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'edit')

{

	$editanum = $_REQUEST["anum"];

	$query3 = "select * from master_payrollcomponent where auto_number = '$editanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	$res3typecode = $res3['typecode'];

	$res3componentname = $res3['componentname'];

	$res3type = $res3['type'];

	$res3amounttype = $res3['amounttype'];

	$res3monthly = $res3['monthly'];

	$res3notional = $res3['notional'];

	$res3formula = $res3['formula'];

	if($res3formula == '1') { $resformulaname = 'BASIC'; }

	else if($res3formula == '1+2') { $resformulaname = 'BASIC+HRA'; }

	else if($res3formula == 'Gross') { $resformulaname = 'TOTAL GROSS'; }

	else { $resformulaname = ''; }

	$res3deductearning = $res3['deductearning'];

	$res3notexceed = $res3['notexceed'];

	if($res3notexceed == '0.00') { $res3notexceed = ''; }

	$res3taxinclude = $res3['taxinclude'];

	$ledger = $res3['ledger'];

	$ledgercode = $res3['ledgercode'];

	$resetmonthly = $res3['resetmonthly'];

}



?>

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
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script type="text/javascript" src="js/autocomplete_payroll.js"></script>

<script type="text/javascript" src="js/autosuggest2payroll.js"></script>



<script language="javascript">



window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}



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

	document.getElementById("earn1").style.display = "none";

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

	if(document.getElementById("type").value == "10||Earning")

	{

		document.getElementById("earn1").style.display = "";

	}

	else

	{

		document.getElementById("earn1").style.display = "none";

	}

}

$(document).ready(function(){
	$('.earningledger').autocomplete({
	source:"ajaxpayrollledger.php?type=25",
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

              <td><form name="form1" id="form1" method="post" action="editpayrollcomponent1.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payroll Component - Edit </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php  if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }  ?>" class="bodytext3"><div align="left"><?php eval(base64_decode('IGVjaG8gJGVycm1zZzsg')); ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Component </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="editanum" id="editanum" value="<?php echo $editanum; ?>">

						<input name="componentname" id="componentname" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $res3componentname; ?>" /></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Type </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="type" id="type" onChange="return ShowDeduct()" style="border: 1px solid #001E6A;" title="Earning or Deduction">

						<?php if($res3type != '') { ?>

						<option value="<?php echo $res3typecode.'||'.$res3type; ?>"><?php echo $res3type; ?></option>

						<?php } ?>

						<option value="">Select</option>

						<option value="10||Earning">Earning</option>

						<option value="20||Deduction">Deduction</option>

						</select></td>

                      </tr>

					   <tr <?php if($res3typecode != '20') { ?> id="deduct1" <?php } else { ?> id="deductedit" <?php } ?>>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Deduct from Taxable Earnings </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="deductearning" id="deductearning" style="border: 1px solid #001E6A;" title="Deduct before PAYE Calculation">

						<?php if($res3deductearning != '') { ?>

						<option value="<?php echo $res3deductearning; ?>"><?php echo $res3deductearning; ?></option>

						<?php } ?>

						<option value="No">No</option>

						<option value="Yes">Yes</option>

						</select></td>

                      </tr>

                       <tr <?php if($res3typecode != '10') { ?> id="earn1" <?php } else { ?> id="earnedit" <?php } ?>>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Include in Taxable Income </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="taxinclude" id="taxinclude" style="border: 1px solid #001E6A;" title="Include in Taxable Income">

						<?php if($res3taxinclude != '') { ?>

						<option value="<?php echo $res3taxinclude; ?>"><?php echo $res3taxinclude; ?></option>

						<?php } ?>

                        <option value="Yes">Yes</option>

                        <option value="No">No</option>

						</select></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Notional  </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="notional" id="notional" style="border: 1px solid #001E6A;" title="If Yes include only for Tax calculation">

						<?php if($res3notional != '') { ?>

						<option value="<?php echo $res3notional; ?>"><?php echo $res3notional; ?></option>

						<?php } ?>

						<option value="No">No</option>

						<option value="Yes">Yes</option>

						</select></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="amounttype" id="amounttype" style="border: 1px solid #001E6A;" onChange="return Formula1()" title="Fixed value or Percent">

						<?php if($res3amounttype != '') { ?>

						<option value="<?php echo $res3amounttype; ?>"><?php echo $res3amounttype; ?></option>

						<?php } ?>

						<option value="">Select</option>

						<option value="Fixed">Fixed</option>

						<option value="Percent">Percent</option>

						</select></td>

                      </tr>

					   <tr <?php if($res3amounttype == 'Percent') { ?> id="formulatredit" <?php } else { ?> id="formulatr" <?php } ?>>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="formula" id="formula" style="border: 1px solid #001E6A;" title="From BASIC or GROSS">

						<?php if($res3formula != '') { ?>

						<option value="<?php echo $res3formula; ?>"><?php echo $resformulaname; ?></option>

						<?php } ?>

						<option value="">Select</option>

						<option value="1">BASIC</option>

						<option value="Gross">TOTAL GROSS</option>

						</select></td>

                      </tr>

					 <tr <?php if($res3amounttype == 'Percent') { ?> id="formulatredit1" <?php } else { ?> id="formulatr1" <?php } ?>>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Max Value</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" name="maxvalue" id="maxvalue" size="10" value="<?php echo $res3notexceed; ?>" style="border: 1px solid #001E6A;" title="% amount should not exceed this value if not leave empty"></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Value Change Every Month </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="monthly" id="monthly" style="border: 1px solid #001E6A;" title="Changes every Month">

						<?php if($res3monthly != '') { ?>

						<option value="<?php echo $res3monthly; ?>"><?php echo $res3monthly; ?></option>

						<?php } ?>

						<option value="No">No</option>

						<option value="Yes">Yes</option>

						</select></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Reset Every Month </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="resetmonthly" id="resetmonthly" style="border: 1px solid #001E6A;" title="Reset every Month">

						<?php if($resetmonthly != '') { ?>

						<option value="<?php echo $resetmonthly; ?>"><?php echo $resetmonthly; ?></option>

						<?php } ?>

						<option value="No">No</option>

						<option value="Yes">Yes</option>

						</select></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Ledger Name </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" class="earningledger" name="searchsuppliername" id="searchsuppliername" autocomplete="off" value="<?php echo $ledger; ?>" size="40" style="border: 1px solid #001E6A;" title="Account Ledger">

						<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $ledgercode; ?>">

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



