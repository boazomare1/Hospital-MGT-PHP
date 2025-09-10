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

	$vatid = $_REQUEST["vatid"];
	
	$flag = $_REQUEST["flag"];	

	if ($length<=500)
	{
	$query2 = "SELECT * from master_vat where auto_number = '$id'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{ 
		$query1 = "UPDATE master_vat set vat_id='$vatid', vat='$name', flag='$flag', ip_address = '$ipaddress' where auto_number = '$id'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success.  Updated.";

		//$bgcolorcode = 'success';

		header ("location:vat_edit.php?bgcolorcode=success&&st=edit&&anum=$id");

	}

	//exit();

	else

	{

		$errmsg = "Failed. Please Try again!";

		//$bgcolorcode = 'failed';

		header ("location:vat_edit.php?bgcolorcode=failed&&st=edit&&anum=$id");

	}

	}

	else

	{

		$errmsg = "Failed. Only 500 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:vat_edit.php?bgcolorcode=failed&&st=edit&&anum=$id");

	}



}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{

    $query1 = "SELECT * from master_vat where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);
	$vat_id = $res1["vat_id"];
		$auto_number = $res1["auto_number"];
		$name = ucwords($res1['vat']);
		$flag = $res1['flag'];
}



   

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

		$errmsg = "Success.  Updated. <a href='vat.php'>Back</a>";

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


<script language="javascript">

function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.vatid.value == "")
	{
		alert ("Pleae Enter VAT ID.");
		document.form1.department.focus();
		return false;
	}
	if (document.form1.name.value == "")
	{
		alert ("Pleae Enter VAT Name.");
		document.form1.name.focus();
		return false;
	}
	if (document.form1.flag.value == "")
	{
		alert ("Pleae Select Flag.");
		document.form1.flag.focus();
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

              <td><form name="form1" id="form1" method="post" action="vat_edit.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master VAT - Edit </strong></td>
                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>


					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">VAT ID </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="vatid" id="vatid" style="border: 1px solid #001E6A; text-transform:uppercase;"   readonly value="<?php echo $vat_id; ?>"   /></td>

                      </tr>

					  <tr>

					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">VAT Name </div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="name" size="40" id="name" style="border: 1px solid #001E6A; text-transform:uppercase;"  value="<?php echo $name; ?>"  /></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><div align="right"><label for="Type">Flag</label></div></td>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">

						<select name="flag" id="flag">
							<option value="">--Select Flag--</option>
							<option value="sales" <?php if($flag=='sales') { echo 'selected'; } ?>>Sales</option>
							<option value="purchase" <?php if($flag=='purchase') { echo 'selected'; } ?>>Purchase</option>
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



