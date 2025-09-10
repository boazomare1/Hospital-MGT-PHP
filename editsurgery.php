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
	$surgeryanum = $_REQUEST['surgeryanum'];
	$surgery = $_REQUEST["surgery"];
	$recordstatus = $_REQUEST["recordstatus"];
	
	$recorddate = $_REQUEST["recorddate"];
	//$surgery = strtoupper($surgery);
	$surgery = trim($surgery);
	$length=strlen($surgery);
	$rate = $_REQUEST['rate'];
	$rate2 = $_REQUEST['rate2'];
	$rate3 = $_REQUEST['rate3'];
	$selectedlocationcode=$_REQUEST["location"];
	
		 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	 $selectedlocation = $res31["locationname"];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_surgery where auto_number = '$surgeryanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
	    $query1 = "update master_surgery set locationname='$selectedlocation',locationcode='$selectedlocationcode', surgery = '$surgery',ipaddress = '$ipaddress',recorddate = '$updatedatetime',rate='$rate',rate2='$rate2',rate3='$rate3' where auto_number = '$surgeryanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New surgery Updated.";
		//$bgcolorcode = 'success';
		header ("location:addsurgery.php?bgcolorcode=success&&st=edit&&anum=$surgeryanum");
	}
	//exit();
	else
	{
		$errmsg = "Failed. surgery Already Exists.";
		//$bgcolorcode = 'failed';
		header ("location:editsurgery.php?bgcolorcode=failed&&st=edit&&anum=$surgeryanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editsurgery.php?bgcolorcode=failed&&st=edit&&anum=$surgeryanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_surgery set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_surgery set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_surgery set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_surgery set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_surgery set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add surgery To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
    $query1 = "select * from master_surgery where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$res1surgery = $res1['surgery'];
	$res1rate = $res1['rate'];
	$res1rate2 = $res1['rate2'];
	$res1rate3 = $res1['rate3'];
$res74locationname = $res1['locationname'];
$res74locationcode = $res1['locationcode'];
}

   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New surgery Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. surgery Already Exists.";
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

function addsurgery1process1()
{
	//alert ("Inside Funtion");
	
	if (document.form1.location.value == "")
	{
		alert ("Location Cannot Be Empty.");
		document.form1.location.focus();
		return false;
	}
	if (document.form1.surgery.value == "")
	{
		alert ("Pleae Enter surgery Name.");
		document.form1.surgery.focus();
		return false;
	}
	if (document.form1.store.value == "")
	{
		alert ("Pleae select store.");
		document.form1.store.focus();
		return false;
	}
}

function funcDeletesurgery1(varsurgeryAutoNumber)
{

     var varsurgeryAutoNumber = varsurgeryAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Consultation Type '+varsurgeryAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("surgery  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("surgery Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editsurgery.php" onSubmit="return addsurgery1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Surgery Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                                            				<tr>
                <td width="14%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange="return funclocationChange1();"  style="border: 1px solid #001E6A;">
                						<option value="<?php echo $res74locationcode;?>"><?php echo $res74locationname;?></option>
                  <?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
                </td>
				</tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Surgery </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="surgery" id="surgery" value="<?php echo $res1surgery ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rate" id="rate" value="<?php echo $res1rate ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate2 </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rate2" id="rate2" value="<?php echo $res1rate2 ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate3 </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rate3" id="rate3" value="<?php echo $res1rate3 ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="surgeryanum" id="surgeryanum" value="<?php echo $res1autonumber; ?>">
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

