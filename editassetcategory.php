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

    $assetcategoryanum = $_REQUEST['assetcategoryanum'];

	$assetcategory = $_REQUEST["assetcategory"];

	$assetcategory = strtoupper($assetcategory);

	$assetcategory = trim($assetcategory);

	$length=strlen($assetcategory);

	$id = $_REQUEST['id'];

	$section = $_REQUEST['section'];

	//$salvage = $_REQUEST['salvage'];

	$salvage = 0;
	$noofyears = $_REQUEST['noofyears'];

	

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_assetcategory where auto_number = '$assetcategoryanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0)

	{

		$query1 = "update master_assetcategory set category = '$assetcategory',id='$id',salvage='$salvage',noofyears='$noofyears' where auto_number = '$assetcategoryanum'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Payment Type Updated.";

		//$bgcolorcode = 'success';

		header ("location:assetcategory.php");

	}

	//exit();

	else

	{

		$errmsg = "Failed. Payment Type Already Exists.";

		//$bgcolorcode = 'failed';

		header ("location:editassetcategory.php?bgcolorcode=failed&&st=edit&&anum=$accountsmainanum");

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:editassetcategory.php?bgcolorcode=failed&&st=edit&&anum=$assetcategoryanum");

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_assetcategory set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_assetcategory set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_assetcategory set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_assetcategory set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_assetcategory set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Payment Type To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{

	$query1 = "select * from master_assetcategory where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	$res1autonumber = $res1['auto_number'];

	$res1assetcategory = $res1['category'];

	$id = $res1['id'];

	$salvage = $res1['salvage'];

	$noofyears = $res1['noofyears'];
	

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
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">

$(document).ready(function(){

	$('#noofyears').keypress(function (event) {
           return isOnlyNumber(event, this)
    });
});

function isOnlyNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    } 

function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.assetcategory.value == "")

	{

		alert ("Pleae Enter Payment Type Name.");

		document.form1.assetcategory.focus();

		return false;

	}

}



function funcDeletePaymentType(varPaymentTypeAutoNumber)

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

              <td><form name="form1" id="form1" method="post" action="editassetcategory.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong> Accounts Main Master - Edit </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="id" id="id" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $id; ?>"/></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Type </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="assetcategory" id="assetcategory" value="<?php echo $res1assetcategory;?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>

                      </tr>

					 <!--  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="salvage" id="salvage" value="<?php echo $salvage;?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="20" /> % </td>

                      </tr> -->

					    <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Years </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="noofyears" id="noofyears" style="text-transform:uppercase" size="20" value="<?= $noofyears;?>" />  </td>

                      </tr>

                      <tr>

                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

							<input type="hidden" name="assetcategoryanum" id="assetcategoryanum" value="<?php echo $res1autonumber; ?>">

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

