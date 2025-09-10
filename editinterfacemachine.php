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
    $machineanum = $_REQUEST['machineanum'];
	$machine = $_REQUEST["machine"];

	//$machine = strtoupper($machine);
	$machine = trim($machine);
	$length=strlen($machine);
	$machineip = $_REQUEST["machineip"];
	$machineport = $_REQUEST["machineport"];
	$machinecode = $_REQUEST["machinecode"];
	$is_analyzer = $_REQUEST["is_analyzer"];
	$machine = ucwords($machine);
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_interfacemachine where auto_number = '$machineanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
	    $query1 = "update master_interfacemachine set machine = '$machine', machineip = '$machineip', machineport = '$machineport', recorddate = '$updatedatetime', is_analyzer='$is_analyzer' 
		where auto_number = '$machineanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New machine Updated.";
		//$bgcolorcode = 'success';
		header ("location:addinterfacemachine.php?bgcolorcode=success&&st=edit&&anum=$machineanum");
	}
	else
	{
		$errmsg = "Failed. machine Already Exists.";
		//$bgcolorcode = 'failed';
		header ("location:editinterfacemachine.php?bgcolorcode=failed&&st=edit&&anum=$machineanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editinterfacemachine.php?bgcolorcode=failed&&st=edit&&anum=$machineanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_interfacemachine set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_interfacemachine set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_interfacemachine set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_interfacemachine set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_interfacemachine set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add machine To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{

    $query1 = "select * from master_interfacemachine where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
    $res1autonumber = $res1['auto_number'];
    $res1machine = $res1['machine'];
    $res1machineip = $res1['machineip'];
	$machinecode = $res1['machinecode'];
	$machineport = $res1['machineport'];
	$is_analyzer = $res1['is_analyzer'];
}


if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Interface Machine Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Interface Machine Already Exists.";
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

function addmachine1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.machine.value == "")
	{
		alert ("Please Enter machine Name.");
		document.form1.machine.focus();
		return false;
	}
/* 	if (document.form1.machineport.value == "")
	{
		alert ("Please Enter machine PORT.");
		document.form1.machineport.focus();
		return false;
	} */
}

function funcDeletemachine(varmachineAutoNumber)
{
     var varmachineAutoNumber = varmachineAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this machine Type '+varmachineAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("machine Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("machine Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editinterfacemachine.php" onSubmit="return addmachine1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Equipment Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Equipment Code </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="machinecode" id="machinecode" value="<?php echo $machinecode; ?>" style="border: 1px solid #001E6A;" size="40" readonly /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Equipment Name</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="machine" id="machine" value="<?php echo $res1machine; ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>


                      <tr  style = "display:none">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">Machine Port</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input type="hidden" name="machineip" id="machineip" value="<?php echo $res1machineip; ?>" style="border: 1px solid #001E6A;" size="40" />
					<input type="text" name="machineport" id="machineport" value="<?php echo $machineport; ?>" style="border: 1px solid #001E6A;" size="40" />
					</td>
                      </tr>

                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Analyzer</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<?php if($is_analyzer == 0){ ?>
                        	<input type="checkbox" name="is_analyzer" id="is_analyzer" value="1"></td>
                        <?php } else { ?>
							<input type="checkbox" name="is_analyzer" id="is_analyzer" value="1" checked="checked" ></td>
						<?php } ?>


					</td>
                      </tr>


                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                       <input type="hidden" name="frmflag1" value="frmflag1" />
					   <input type="hidden" name="machineanum" id="machineanum" value="<?php echo $res1autonumber; ?>">
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