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
$totaldays1 = '';
$proratatotaldays1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$totaldays = $_REQUEST['totaldays'];
	$formula = $_REQUEST['formula'];
	$proratatotaldays = $_REQUEST['proratatotaldays'];
	
	$query2 = "select * from master_prorata where componentname = 'PRORATA'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_prorata (componentanum, componentname, totaldays, formula, ipaddress, updatedatetime, username, proratatotaldays) 
		values ('0', 'PRORATA', '$totaldays', '$formula', '$ipaddress', '$updatedatetime', '$username', '$proratatotaldays')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. Added Successfully.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$query2 = "update master_prorata set totaldays = '$totaldays', proratatotaldays = '$proratatotaldays', formula = '$formula', updatedatetime = '$updatedatetime' where componentanum = '0'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$errmsg = "Success. Added Successfully.";
		$bgcolorcode = 'success';
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{
	$editanum = $_REQUEST["anum"];
	$query3 = "select * from master_prorata where auto_number = '$editanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$totaldays1 = $res3['totaldays'];
	$proratatotaldays1 = $res3['proratatotaldays'];
	$formula1 = $res3['formula'];
	if($formula1 == '1')
	{
		$calc1 = 'BASIC';
	}
	else if($formula1 == '1+2')
	{
		$calc1 = 'BASIC+HRA';
	}
	else if($formula1 == 'Gross')
	{
		$calc1 = 'TOTAL GROSS';
	}
	
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
	if(document.getElementById("totaldays").value == "")
	{
		alert("Please Enter Totaldays");
		document.getElementById("totaldays").focus();
		return false;
	}
	if(isNaN(document.getElementById("totaldays").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("totaldays").focus();
		return false;
	}
	if(document.getElementById("formula").value == "")
	{
		alert("Please Select Based on");
		document.getElementById("formula").focus();
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
              <td><form name="form1" id="form1" method="post" action="proratamaster1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Prorata Master</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Total Working Days</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="totaldays" id="totaldays" value="<?php echo $totaldays1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Based on</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="formula" id="formula" style="border: 1px solid #001E6A;">
						<?php if($formula1 != '') { ?>
						<option value="<?php echo $formula1; ?>"><?php echo $calc1; ?></option>
						<?php } ?>
						<option value="1">BASIC</option>
                        <option value="1+2">BASIC+HRA</option>
                        <option value="Gross">TOTAL GROSS</option>
						</select></td>
                      </tr>
					  <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">For Prorata Total Working Days</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="proratatotaldays" id="proratatotaldays" value="<?php echo $proratatotaldays1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>-->
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
                        <input type="hidden" name="proratatotaldays" id="proratatotaldays" value="<?php echo $proratatotaldays1; ?>" style="border: 1px solid #001E6A;" size="10" />
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
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Prorata Master - Existing List </strong></td>
                      </tr>
					  <tr>
					  <td align="left" class="bodytext3"><strong>Component Name</strong></td>
					  <td align="left" class="bodytext3"><strong>Total Days</strong></td>
					  <!--<td align="left" class="bodytext3"><strong>Prorata Total Days</strong></td>-->
					  <td align="left" class="bodytext3"><strong>Based on</strong></td>
					  <td align="left" class="bodytext3"><strong>Edit</strong></td>
					  </tr>
                      <?php
						$query1 = "select * from master_prorata where status <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$componentname = $res1["componentname"];
						$auto_number = $res1["auto_number"];
						$totaldays = $res1['totaldays'];
						$proratatotaldays = $res1['proratatotaldays'];
						$formula = $res1["formula"];
						if($formula == '1')
						{
							$calcfrom = 'BASIC';
						}
						else if($formula == '1+2')
						{
							$calcfrom = 'BASIC+HRA';
						}
						else
						{
							$calcfrom = 'TOTAL GROSS';
						}
				
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
                        <td width="18%" align="left" valign="top"  class="bodytext3"><?php echo $componentname;?> </td>
						<td width="19%" align="left" valign="top"  class="bodytext3"><?php echo $totaldays;?> </td>
						<!--<td width="23%" align="left" valign="top"  class="bodytext3"><?php echo $proratatotaldays;?> </td>-->
						<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $calcfrom;?> </td>
                        <td width="9%" align="left" valign="top"  class="bodytext3">
						<a href="proratamaster1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
						}
						?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
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

