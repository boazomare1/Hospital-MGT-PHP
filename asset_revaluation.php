<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$itemname = $_REQUEST['itemname'];
	$assetid = $_REQUEST['assetid'];
	$assetanum = $_REQUEST['assetanum'];
	$impairmentledger = $_REQUEST['impairmentledger'];
	$impairmentledgercode = $_REQUEST['impairmentledgercode'];
	$revaluationvalue = $_REQUEST['revaluationvalue'];
	$revaluationvalue = str_replace(',','',$revaluationvalue);
	
	$query33 = "select asset_id from assets_register where asset_id = '$assetid'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row33 = mysqli_num_rows($exec33);
	if($row33 > 0)
	{ 
		$query88 = "INSERT INTO `assets_revaluation`(`companyanum`, `itemcode`, `itemname`, `rate`, `quantity`, `subtotal`, `totalamount`, `recordstatus`, `assetledger`, `assetledgercode`, `assetledgeranum`, `fxamount`, 
		`asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, `startyear`) 
		 SELECT `companyanum`, `itemcode`, `itemname`, `rate`, `quantity`, `subtotal`, `totalamount`, `recordstatus`, `assetledger`, `assetledgercode`, `assetledgeranum`, `fxamount`, 
		`asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, `startyear` FROM assets_register WHERE `auto_number` = '$assetanum'";
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		$insertid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
		$query78 = "UPDATE assets_revaluation SET revaluationvalue = '$revaluationvalue', impairmentledgercode = '$impairmentledgercode', impairmentledger = '$impairmentledger', entrydate = '$updatedatetime', username = '$username', ipaddress = '$ipaddress' WHERE auto_number = '$insertid'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:assetregister.php?st=success&&assetanum=$assetanum");
	}
	else
	{
		header("location:assetregister.php?st=failed&&assetanum=$assetanum");
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if($st == 'error')
{
	$errmsg = "Asset ID already exists";
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
if (isset($_REQUEST["assetanum"])) { $assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }

$query77 = "select * from assets_register where auto_number = '$assetanum'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$itemname = $res77['itemname'];
$totalamount = $res77['totalamount'];
$entrydate = $res77['entrydate'];
$asset_id = $res77['asset_id'];
$asset_category = $res77['asset_category'];
$asset_class = $res77['asset_class'];
$asset_department = $res77['asset_department'];
$asset_unit = $res77['asset_unit'];
$asset_period = $res77['asset_period'];
$startyear = $res77['startyear'];
$dep_percent = $res77['dep_percent'];
$depreciation = $totalamount * ($dep_percent / 100);
$accdepreciation = $depreciation * $asset_period;
$totalamount = number_format($totalamount,2);
$depreciation = number_format($depreciation,2);
$accdepreciation = number_format($accdepreciation,2);
$depreciationledger = $res77['depreciationledger'];
$depreciationledgercode = $res77['depreciationledgercode'];
$assetledger = $res77['assetledger'];
$assetledgercode = $res77['assetledgercode'];
$depreciationvalue = $res77['depreciation'];
$accdepreciationvalue = $res77['accdepreciation'];
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

function addward1process1()
{
	if (document.form1.impairmentledgercode.value == "")
	{
		alert ("Please Select Ledger");
		document.form1.impairmentledger.focus();
		return false;
	}
	if (document.form1.revaluationvalue.value == "")
	{
		alert ("Please Enter Amount");
		document.form1.revaluationvalue.focus();
		return false;
	}
	if (document.form1.revaluationvalue.value == '0')
	{
		alert ("Please Enter Amount");
		document.form1.revaluationvalue.focus();
		return false;
	}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#impairmentledger').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=impairment&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#impairmentledgercode').val(code);
			},
	html: true
    });
});
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
              <td><form name="form1" id="form1" method="post" action="asset_revaluation.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Asset Revaluation </strong></td>
                         <td width="77%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						?>                  </td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);"   style="border: 1px solid #001E6A;">
                          <?php
							$query5 = "select * from master_location where status = '' order by locationname";
							$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res5 = mysqli_fetch_array($exec5))
							{
							$locationcode = $res5["locationcode"];
							$res5location = $res5["locationname"];
							?>
                          <option value="<?php echo $locationcode; ?>"><?php echo $res5location; ?></option>
                          <?php
							}
							?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Name</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="itemname" id="itemname" value="<?php echo $itemname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" readonly size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset ID </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetid" id="assetid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly value="<?php echo $asset_id; ?>"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cost </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="costprice" id="costprice" value="<?php echo $totalamount; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Start Year </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="startyear" id="startyear" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly value="<?php echo $startyear; ?>"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetledger" id="assetledger" value="<?php echo $assetledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" readonly size="40"/>
						<input type="hidden" name="assetledgercode" id="assetledgercode" value="<?php echo $assetledgercode; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Impairment Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="impairmentledger" id="impairmentledger" value="<?php //echo $accdepreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="impairmentledgercode" id="impairmentledgercode" value="<?php //echo $accdepreciationledgercode; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Revaluation Value </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="revaluationvalue" id="revaluationvalue" value="<?php //echo $totalamount; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
                      <tr>
                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="77%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
						<input type="hidden" name="assetanum" id="assetanum" value="<?php echo $assetanum; ?>">
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

