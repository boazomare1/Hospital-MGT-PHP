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


if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	// $id = $anum;
	$id = $_REQUEST["id"];
	$name = $_REQUEST["name"];
	$length=strlen($name);

	$taxid = $_REQUEST["taxid"];
	// $name = $_REQUEST["name"];
	$percentage = $_REQUEST["percentage"];
	$saccountname = $_REQUEST["saccountname"];
	$saccountid = $_REQUEST["saccountid"];
	$type = $_REQUEST["type"];	

	if ($length<=100)
	{
	$query2 = "SELECT * from master_withholding_tax where auto_number = '$id'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{ 
		$query1 = "UPDATE master_withholding_tax set tax_id='$taxid', name='$name', tax_percent='$percentage', ledger_name='$saccountname', ledger_code='$saccountid', type='$type', ip_address = '$ipaddress' where auto_number = '$id'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success.  Updated.";

		//$bgcolorcode = 'success';

		header ("location:master_withholding_tax_edit.php?bgcolorcode=success&&st=edit&&anum=$id");

	}

	//exit();

	else

	{

		$errmsg = "Failed. Please Try again!";

		//$bgcolorcode = 'failed';

		header ("location:master_withholding_tax_edit.php?bgcolorcode=failed&&st=edit&&anum=$id");

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:master_withholding_tax_edit.php?bgcolorcode=failed&&st=edit&&anum=$id");

	}



}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{

    $query1 = "SELECT * from master_withholding_tax where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);
	$tax_id = $res1["tax_id"];
		$auto_number = $res1["auto_number"];
		$name = ucwords($res1['name']);
		$tax_percent = $res1['tax_percent'];
		$ledger_name = $res1['ledger_name'];
		$ledger_code = $res1['ledger_code'];
		$type = $res1['type'];

}



   

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

		$errmsg = "Success.  Updated. <a href='master_withholding_tax.php'>Back</a>";

}

if ($bgcolorcode == 'failed')

{

		$errmsg = "Failed. Please Try again!.";

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

<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script language="javascript">

$(function() {

    $('#accountname').autocomplete({
		
	source:'accountnameajax_tax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#saccountauto').val(saccountauto);	
				$('#saccountid').val(saccountid);	
			}
    });
});

function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.taxid.value == "")

	{

		alert ("Pleae Enter Tax Name.");

		document.form1.taxid.focus();

		return false;

	}

	if (document.form1.name.value == "")

	{

		alert ("Pleae Enter TAX Name.");

		document.form1.name.focus();

		return false;

	}

	if (document.form1.percentage.value == "")

	{

		alert ("Pleae Enter percentage.");

		document.form1.percentage.focus();

		return false;

	}

	if (document.form1.saccountname.value == "")

	{

		alert ("Pleae Select Ledger.");

		document.form1.percentage.focus();

		return false;

	}
	if (document.form1.type.value == "")

	{

		alert ("Pleae Select Type.");

		document.form1.type.focus();

		return false;

	}

}


</script>

<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td><form name="form1" id="form1" method="post" action="master_withholding_tax_edit.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Withholding Tax - Edit </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>


					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">TAX ID </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="taxid" id="taxid" style="border: 1px solid #001E6A; text-transform:uppercase;"   readonly value="<?php echo $tax_id; ?>"  /></td>

                      </tr>

					  <tr>

					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Name </div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="name" id="name" style="border: 1px solid #001E6A; text-transform:uppercase;"  value="<?php echo $name; ?>" /></td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Percentage</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="percentage" value="<?php echo $tax_percent; ?>"  id="percentage" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" />%
						</td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Ledger</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<!-- <input name="rate3" id="rate3" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" /></td> -->
						<input type="text" value="<?php echo $ledger_name; ?>"  name="saccountname" id="accountname" size="30" />
                        <input type="hidden"  name="saccountauto" id="saccountauto" />
                        <input type="hidden" value="<?php echo $ledger_code; ?>"  name="saccountid" id="saccountid" />

                      </tr>

					  

					<tr>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><div align="right"><label for="Type">Type</label></div></td>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">

						<select name="type" id="type">
							<option value="">--Select Type--</option>
							<option value="0" <?php if($type==0) { echo 'selected'; } ?>>TAX</option>
							<option value="1" <?php if($type==1) { echo 'selected'; } ?>>VAT</option>
						</select>

                      </tr>

					  

					  

					  

                      <tr>

                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

							<input type="hidden" name="id" id="id" value="<?php echo $anum; ?>">

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

<?php include ("includes/footer1.php"); ?>

</body>

</html>



