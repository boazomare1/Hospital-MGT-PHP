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
    $fixedassetsanum = $_REQUEST['fixedassetsanum'];
	//echo $fixedassetsanum;
	$category = $_REQUEST["category"];
	
	$fixedassets = $_REQUEST["fixedassets"];
	$fixedassets = strtoupper($fixedassets);
	$fixedassets = trim($fixedassets);
	$length=strlen($fixedassets);
	$id = $_REQUEST["id"];
	$assetvalue = $_REQUEST['assetvalue'];
	$assetlife = $_REQUEST['assetlife'];
	$salvagevalue = $_REQUEST['salvagevalue'];
	$location = $_REQUEST['location'];
	$entrydate1 = $_REQUEST['ADate1'];
	
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_fixedassets where auto_number = '$fixedassetsanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
	    $query1 = "update master_fixedassets set category = '$category',fixedassets = '$fixedassets',id='$id',assetvalue='$assetvalue',assetlife='$assetlife',salvagevalue='$salvagevalue',location='$location',entrydate = '$entrydate1' where auto_number = '$fixedassetsanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Sub Type Updated.";
		//$bgcolorcode = 'success';
		header ("location:fixedassets.php");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Sub Type Already Exists.";
		//$bgcolorcode = 'failed';
	header ("location:editfixedassets.php?bgcolorcode=failed&&st=edit&&anum=$fixedassetsanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editfixedassets.php?bgcolorcode=failed&&st=edit&&anum=$fixedassetsanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_fixedassets set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_fixedassets set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_fixedassets set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_fixedassets set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_fixedassets set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Sub Type To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_fixedassets where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
    $res1category = $res1['category'];
    $res1fixedassets = $res1['fixedassets'];
	$id = $res1['id'];
	$assetvalue = $res1['assetvalue'];
	$assetlife = $res1['assetlife'];
	$salvagevalue = $res1['salvagevalue'];
	$location = $res1['location'];
	$entrydate2 = $res1['entrydate'];
	
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Sub Type Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Visit Sub Already Exists.";
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
	if (document.form1.fixedassets.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.fixedassets.focus();
		return false;
	}
}
function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varSubTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Sub Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Sub Type Entry Delete Not Completed.");
		return false;
	}

}

function Salvage()
{
	<?php 
	$query89 = "select * from master_assetcategory where recordstatus = '' order by category";
	$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res89 = mysqli_fetch_array($exec89))
	{
	$res89anum = $res89['auto_number'];
	$salvage = $res89['salvage'];
	?>
	var Anum = "<?php echo $res89anum; ?>";
	if(document.getElementById("category").value == "<?php echo $res89anum; ?>")
	{
		document.getElementById("salvagevalue").value = "<?php echo $salvage; ?>";
	}
	<?php
	}
	?>
}
</script>
<script src="js/datetimepicker_css.js"></script>

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
              <td><form name="form1" id="form1" method="post" action="editfixedassets.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Fixed Assets - Edit</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">   Category</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="category" id="category"  style="border: 1px solid #001E6A;" onChange="return Salvage()">
                          <?php
						
						if ($res1category == '')
						{
						echo '<option value="" selected="selected">Select Payment Type</option>';
						}
						else
						{
						$query4 = "select * from master_assetcategory where auto_number = '$res1category'";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res4 = mysqli_fetch_array($exec4);
						$res4dcategoryanum = $res4['auto_number'];
						$res4categoryname = $res4['category'];
					
						echo '<option value="'.$res4dcategoryanum.'" selected="selected">'.$res4categoryname.'</option>';
						}
					
						$query5 = "select * from master_assetcategory where recordstatus = '' order by category";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
						$res5anum = $res5["auto_number"];
						$res5category = $res5["category"];
						?>
						<option value="<?php echo $res5anum; ?>"><?php echo $res5category; ?></option>
						<?php
						}
						?>
                        </select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="id" id="id" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $id; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fixed Assets </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fixedassets" id="fixedassets"  value="<?php echo $res1fixedassets;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Value</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetvalue" id="assetvalue" style="text-transform:uppercase" size="20" value="<?php echo $assetvalue; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Life</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetlife" id="assetlife" style="text-transform:uppercase" size="20" value="<?php echo $assetlife; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Salvage Value</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="salvagevalue" id="salvagevalue" style="text-transform:uppercase" size="20" value="<?php echo $salvagevalue; ?>" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="location" id="location" style="text-transform:uppercase" size="20" value="<?php echo $location; ?>"/></td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Entry Date</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="ADate1" id="ADate1" size="15" readonly value="<?php echo $entrydate2; ?>" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>	</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="fixedassetsanum" id="fixedassetsanum" value="<?php echo $res1autonumber; ?>">
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

