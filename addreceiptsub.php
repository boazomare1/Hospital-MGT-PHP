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

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$receiptmainanum = $_REQUEST["receiptmainanum"];
	$receiptsubname = $_REQUEST["receiptsubname"];
	$receiptsubname = strtoupper($receiptsubname);
	$receiptsubname = trim($receiptsubname);
	$length=strlen($receiptsubname);
	//echo $length;
	if ($length<=100)
	{
	$query1 = "select * from master_receiptmain where auto_number = '$receiptmainanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$receiptmainname = $res1["receiptmainname"];
	
	$query2 = "select * from master_receiptsub where receiptmainanum = '$receiptmainanum' and receiptsubname = '$receiptsubname'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_receiptsub (receiptmainanum, receiptmainname, receiptsubname, ipaddress, updatetime) 
		values ('$receiptmainanum', '$receiptmainname', '$receiptsubname', '$ipaddress', '$updatedatetime')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Receipt Sub Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Receipt Sub Already Exists.";
		$bgcolorcode = 'failed';
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $delanum = $_REQUEST["anum"]; } else { $delanum = ""; }
if ($st == 'del')
{
	$query3 = "update master_receiptsub set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$query3 = "update master_receiptsub set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$query4 = "update master_receiptsub set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_receiptsub set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$query6 = "update master_receiptsub set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
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

function addreceiptsubprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.receiptmainanum.value == "")
	{
		alert ("Please Select Receipt Main Name.");
		document.form1.receiptmainanum.focus();
		return false;
	}
	if (document.form1.receiptsubname.value == "")
	{
		alert ("Please Enter Receipt Sub Name.");
		document.form1.receiptsubname.focus();
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
              <td><form name="form1" id="form1" method="post" action="addreceiptsub.php" onSubmit="return addreceiptsubprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Receipt Main  - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">Select Receipt Main </div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF">
						<select name="receiptmainanum" id="receiptmainanum"  >
						<option value="" selected="selected">Select Receipt Main Name</option>
						<?php
						$query1 = "select * from master_receiptmain where status <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.city".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$receiptmainanum = $res1["auto_number"];
						$receiptmainname = $res1["receiptmainname"];
						?>
						<option value="<?php echo $receiptmainanum; ?>"><?php echo $receiptmainname; ?></option>
						<?php
						}
						?>
						</select>
						<span class="bodytext3">Example: TELEPHONE </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">Add New Receipt Sub </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="receiptsubname" id="receiptsubname" style="border: 1px solid #001E6A" size="20" />
                          <span class="bodytext3">Example: TEL-04442012133, TEL-42012134... </span></td>
                      </tr>
                      <tr>
                        <td width="25%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="75%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />
                          <span class="bodytext3">(* You cannot change name later) </span> </td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Receipt Sub - Existing List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="6%" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Receipt Main </strong></td>
                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Receipt Sub </strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_receiptsub where status <> 'deleted' order by receiptmainname, receiptsubname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$receiptmainname = $res1["receiptmainname"];
		$receiptsubname = $res1["receiptsubname"];
		$auto_number = $res1["auto_number"];
		$defaultstatus = $res1["defaultstatus"];

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
                        <td align="left" valign="top"  class="bodytext3">
						<div align="center"><a href="addreceiptsub.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="42%" align="left" valign="top"  class="bodytext3">
						<?php echo $receiptmainname; ?> </td>
                        <td width="52%" align="left" valign="top"  class="bodytext3">
						<?php echo $receiptsubname; ?></td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Receipt Sub - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="11%" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
                        <td width="37%" bgcolor="#FFFFFF" class="bodytext3"><strong>Receipt</strong></td>
                        <td width="52%" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_receiptsub where status = 'deleted' order by receiptmainname, receiptsubname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$receiptmainname = $res1["receiptmainname"];
		$receiptsubname = $res1["receiptsubname"];
		$auto_number = $res1["auto_number"];

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
                        <td align="left" valign="top" >
						<a href="addreceiptsub.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $receiptmainname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $receiptsubname; ?></td>
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
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

