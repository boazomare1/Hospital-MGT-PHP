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
$tyear = date('Y');

if (isset($_REQUEST["tyear"])) { $tyear = $_REQUEST["tyear"]; } else { $tyear = date('Y'); }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$amount = $_REQUEST['amount'];	
	$finalamount = $amount;	
	$type = 'Monthly';
	$tyear = $_REQUEST['tyear'];
	$st = $_REQUEST['st'];
	$anum = $_REQUEST['anum'];
	
	if($st == '')
	{
		$query2 = "insert into master_taxrelief(amount, type, finalamount, ipaddress, username, updatedatetime,tyear) values('$amount', '$type', '$finalamount', '$ipaddress', '$username', '$updatedatetime','$tyear')";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$query3 = "update master_taxrelief set amount = '$amount', finalamount = '$finalamount', tyear = '$tyear' where auto_number = '$anum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"],$query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	header("location:mastertaxrelief1.php");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit')
{
	$query5 = "select * from master_taxrelief where auto_number = '$anum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"],$query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$amount1 = $res5['amount'];
	$tyear = $res5['tyear'];
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
	if(document.getElementById("amount").value == "")
	{
		alert("Please Enter Amount");
		document.getElementById("amount").focus();
		return false;
	}
	if(isNaN(document.getElementById("amount").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("amount").focus();
		return false;
	}
	/*if(document.getElementById("type").value == "")
	{
		alert("Please Select Type");
		document.getElementById("type").focus();
		return false;
	}*/
	
}

function SelectType()
{
	if(document.getElementById("amount").value != "")
	{
		if(document.getElementById("type").value == 'Annually')
		{
			var Amount = document.getElementById("amount").value;
			var Amount = parseFloat(Amount);
			document.getElementById("finalamount").value = Amount.toFixed(2);
		}
		else
		{
			var Amount = document.getElementById("amount").value;
			var Calc1 = parseFloat(Amount) / 12;
			document.getElementById("finalamount").value = Calc1.toFixed(2);
		}
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
              <td><form name="form1" id="form1" method="post" action="mastertaxrelief1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax Relief</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Year </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="tyear" id="tyear" style="border: 1px solid #001E6A;" size="10" value="<?php echo $tyear; ?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amount" id="amount" value="<?php echo $amount1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Anually / Monthly </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="type" id="type" style="border: 1px solid #001E6A;" onChange="return SelectType()">
						<option value="">Select</option>
						<option value="Annually">Annually</option>
						<option value="Monthly">Monthly</option>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Final Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="finalamount" id="finalamount" value="<?php //echo $amount1; ?>" readonly="readonly" style="border: 1px solid #001E6A;background-color:#ecf0f5;" size="10" /></td>
                      </tr>-->
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="st" id="st" value="<?php echo $st; ?>">
							<input type="hidden" name="anum" id="anum" value="<?php echo $anum; ?>">
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
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax Relief - Existing List </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
						$query1 = "select * from master_taxrelief where status <> 'deleted' order by tyear";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$auto_number = $res1["auto_number"];
						$amount = $res1['amount'];
						$finalamount = $res1['finalamount'];
						$type = $res1['type'];
						$tyear = $res1['tyear'];
						//$defaultstatus = $res1["defaultstatus"];
				
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
                        <td width="44%" align="left" valign="top"  class="bodytext3"><?php echo $tyear;?> </td>
						<td width="50%" align="left" valign="top"  class="bodytext3"><?php echo $finalamount;?> </td>
                        <td width="6%" align="left" valign="top"  class="bodytext3">
						<a href="mastertaxrelief1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
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

