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
$ADate1 = '';
$ADate2 = '';
$comments1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$fromyear = $_REQUEST['fromyear'];
	$toyear = $_REQUEST['toyear'];
	$comments = $_REQUEST['comments'];
	
	$query2 = mysqli_query($GLOBALS["___mysqli_ston"], "update master_financialyear set status = 'Inactive'") or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query1 = "insert into master_financialyear (fromyear, toyear, comments, ipaddress, updatedatetime, username, status) 
	values ('$fromyear', '$toyear', '$comments', '$ipaddress', '$updatedatetime', '$username', 'Active')";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$errmsg = "Success. Added Successfully.";
	$bgcolorcode = 'success';
	
	header("location:addfinancialyear.php?st=success");
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{
	$editanum = $_REQUEST["anum"];
	$query3 = "select * from master_financialyear where auto_number = '$editanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$ADate1 = $res3['fromyear'];
	$ADate2 = $res3['toyear'];
	$comments1 = '';
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
<script src="js/datetimepicker_css.js"></script>

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
	if(document.getElementById("fromyear").value == "")
	{
		alert("Please Select Year From");
		document.getElementById("fromyear").focus();
		return false;
	}
	if(document.getElementById("toyear").value == "")
	{
		alert("Please Select Year To");
		document.getElementById("toyear").focus();
		return false;
	}
	if(document.getElementById("comments").value == "")
	{
		alert("Please Enter Comments");
		document.getElementById("comments").focus();
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
              <td><form name="form1" id="form1" method="post" action="addfinancialyear.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Financial Year Master</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fromyear" id="fromyear" value="<?php echo $ADate1; ?>" readonly="readonly" style="border: 1px solid #001E6A;" size="10" />
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('fromyear')" style="cursor:pointer"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="toyear" id="toyear" value="<?php echo $ADate2; ?>" readonly="readonly" style="border: 1px solid #001E6A;" size="10" />
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('toyear')" style="cursor:pointer"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Comments</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<textarea name="comments" id="comments" cols="50" rows="5" style="border: 1px solid #001E6A;"><?php echo $comments1; ?></textarea></td>
                      </tr>
                      <tr>
                        <td width="21%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="79%" align="left" valign="top"  bgcolor="#FFFFFF">
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
					  <td align="left" class="bodytext3"><strong>Status</strong></td>
					  <td align="left" class="bodytext3"><strong>From</strong></td>
					  <td align="left" class="bodytext3"><strong>To</strong></td>
					  <td align="left" class="bodytext3"><strong>Edit</strong></td>
					  </tr>
                      <?php
						$query31 = "select * from master_financialyear where status = 'Active' order by auto_number desc";
						$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res31 = mysqli_fetch_array($exec31);
						$ADate11 = $res31['fromyear'];
						$ADate21 = $res31['toyear'];
						$auto_number = $res31['auto_number'];
						$status = $res31['status'];
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
                        <td width="18%" align="left" valign="top"  class="bodytext3"><?php echo $status;?> </td>
						<td width="19%" align="left" valign="top"  class="bodytext3"><?php echo $ADate11;?> </td>
						<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $ADate21;?> </td>
                        <td width="9%" align="left" valign="top"  class="bodytext3">
						<a href="addfinancialyear.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                     
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

