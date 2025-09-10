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
$percent1 = '';
$addonpaye1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$percent = $_REQUEST['percent'];
	$addonpaye = '';
	
	$query2 = "select * from master_fringebenefit where componentname = 'FRINGE BENEFIT'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_fringebenefit (componentname, percent, ipaddress, updatedatetime, username,addonpaye) 
		values ('FRINGE BENEFIT', '$percent', '$ipaddress', '$updatedatetime', '$username', '$addonpaye')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Percent Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$query2 = "update master_fringebenefit set percent = '$percent', addonpaye = '$addonpaye', updatedatetime = '$updatedatetime' where componentname = 'FRINGE BENEFIT'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$errmsg = "Success. New Percent Updated.";
		$bgcolorcode = 'success';
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{
	$editanum = $_REQUEST["anum"];
	$query3 = "select * from master_fringebenefit where auto_number = '$editanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$percent1 = $res3['percent'];
	$addonpaye1 = $res3['addonpaye'];
}

$query3 = "select * from master_fringebenefit where status <> 'deleted'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$percent1 = $res3['percent'];
$addonpaye1 = $res3['addonpaye'];

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
	if (document.form1.percent.value == "")
	{
		alert ("Pleae Enter Percent.");
		document.form1.percent.focus();
		return false;
	}
	if(isNaN(document.getElementById("percent").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("percent").focus();
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
              <td><form name="form1" id="form1" method="post" action="fringebenefit1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Fringe Benefit Master</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Percent </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="percent" id="percent" value="<?php echo $percent1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fringe Rate Calculated on PAYE </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="addonpaye" id="addonpaye" style="border: 1px solid #001E6A;">
						<?php if($addonpaye1 != '') { ?>
						<option value="<?php echo $addonpaye1; ?>"><?php echo $addonpaye1; ?></option>
						<?php } ?>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						</select></td>
                      </tr>-->
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
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Fringe Benefit Master - Existing List </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
						$query1 = "select * from master_fringebenefit where status <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$componentname = $res1["componentname"];
						$auto_number = $res1["auto_number"];
						$percent = $res1['percent'];
						$addonpaye = $res1["addonpaye"];
				
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
                        <td width="29%" align="left" valign="top"  class="bodytext3"><?php echo $componentname;?> </td>
						<td width="27%" align="left" valign="top"  class="bodytext3"><?php echo $percent;?> </td>
						<td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $addonpaye;?> </td>
                        <td width="10%" align="left" valign="top"  class="bodytext3">
						<a href="fringebenefit1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
						}
						?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
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
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

