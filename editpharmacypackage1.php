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
	$editanum = $_REQUEST['editanum'];
	$packagename = $_REQUEST['packagename'];
	$packagename = strtoupper($packagename);
	$quantity = $_REQUEST['quantity'];
	
	$query1 = "update master_packagepharmacy set packagename = '$packagename', quantityperpackage = '$quantity', updatetime = '$updatedatetime' where auto_number = '$editanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:addpharmacypackage1.php?st=editsuccess");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{
	$anum = $_REQUEST["anum"];
	
	$query1 = "select * from master_packagepharmacy where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1packagename = $res1['packagename'];
	$res1quantity = $res1['quantityperpackage'];
	
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
	if (document.getElementById("packagename").value == "")
	{
		alert ("Pleae Enter Package Name.");
		document.getElementById("packagename").focus();
		return false;
	}
	if (document.getElementById("quantity").value == "")
	{
		alert ("Pleae Enter Quantity.");
		document.getElementById("quantity").focus();
		return false;
	}
	if (isNaN(document.getElementById("quantity").value))
	{
		alert ("Pleae Enter Numbers.");
		document.getElementById("quantity").focus();
		return false;
	}
}

/*function funcDeleteNurse1(varNurseAutoNumber)
{

     var varNurseAutoNumber = varNurseAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Nurse '+varNurseAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Nurse  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Nurse Entry Delete Not Completed.");
		return false;
	}

}*/

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
              <td><form name="form1" id="form1" method="post" action="editpharmacypackage1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Package - Edit </strong></td>
                      </tr>
					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Package Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="editanum" id="editanum" value="<?php echo $anum; ?>">
						<input name="packagename" id="packagename" value="<?php echo $res1packagename; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
					    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Quantity Pre Package </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="quantity" id="quantity" value="<?php echo $res1quantity; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>

