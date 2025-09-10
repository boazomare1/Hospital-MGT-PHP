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
$amount1 = '';
$from1 = '';
$to1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{	
	$anum = $_REQUEST['anum'];
	$from = $_REQUEST['from'];
	$to = $_REQUEST['to'];
	$amount = $_REQUEST['amount'];
	
	$query1 = "update master_nhif set from1 = '$from', to1 = '$to', amount = '$amount', updatetime = '$updatedatetime' where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:addnhif1.php");
}

if(isset($_REQUEST['st'])) { $st = $_REQUEST['st']; } else { $st = ""; }
if(isset($_REQUEST['anum'])) { $anum = $_REQUEST['anum']; } else { $anum = ""; }
if($st == 'edit')
{
	$editanum = $_REQUEST['anum'];
	$query2 = "select * from master_nhif where auto_number = '$editanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$from1 = $res2['from1'];
	$to1 = $res2['to1'];
	$amount1 = $res2['amount'];
	
}
if($st == 'success')
{
	$errmsg = "Added Successfully";
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
	if (document.getElementById("from").value == "")
	{
		alert ("Pleae Enter From Amount.");
		document.getElementById("from").focus();
		return false;
	}
	if(isNaN(document.getElementById("from").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("from").focus();
		return false;
	}
	if (document.getElementById("to").value == "")
	{
		alert ("Pleae Enter To Amount.");
		document.getElementById("to").focus();
		return false;
	}
	if(isNaN(document.getElementById("to").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("to").focus();
		return false;
	}
	if (document.getElementById("amount").value == "")
	{
		alert ("Pleae Enter Amount.");
		document.getElementById("amount").focus();
		return false;
	}
	if(isNaN(document.getElementById("amount").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("amount").focus();
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
              <td><form name="form1" id="form1" method="post" action="editnhif1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>NHIF Master - Edit</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($st == '') { echo '#FFFFFF'; } else if ($st == 'success') { echo '#FFBF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="anum" id="anum" value="<?php echo $anum; ?>">
						<input name="from" id="from" value="<?php echo $from1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="to" id="to" value="<?php echo $to1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amount" id="amount" value="<?php echo $amount1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
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
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

