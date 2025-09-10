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
	$category = $_REQUEST["category"];
	$fixedasset = $_REQUEST["itemname"];
	$id = $_REQUEST["id"];  
	$assetvalue = $_REQUEST['cost'];
	$assetlife = $_REQUEST['life'];
	$salvage = $_REQUEST['salvage'];
	$startyear = $_REQUEST['startyear'];
	$depreciation = $_REQUEST['depreciation'];
	$accdepreciation = $_REQUEST['accdepreciation'];
	$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date('Y-m-d');
	$accdepreciationledger = $_REQUEST['accdepreciationledger'];
	$accdepreciationledgerid = $_REQUEST['accdepreciationledgerid'];
	$depreciationledger = $_REQUEST['depreciationledger'];
	$depreciationledgerid = $_REQUEST['depreciationledgerid'];
	$asset = $_REQUEST['asset'];
	$assetcode = $_REQUEST['assetcode'];
	$locationcode = $_REQUEST['location'];
	
	$query899 = "select * from master_location where locationcode = '$locationcode'";
	$exec899 = mysqli_query($GLOBALS["___mysqli_ston"], $query899) or die ("Error in Query899".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res899 = mysqli_fetch_array($exec899);
	$locationname = $res899['locationname'];
	
		$query77 = "select * from asset_information where itemname = '$fixedasset'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows77 = mysqli_num_rows($exec77);
		if($rows77 == 0)
		{
			$query1 = "insert into asset_information(`category`, `itemname`, `fixedassetscode`, `fixedassets`, `id`, `assetvalue`, `assetlife`, `salvagevalue`, `depreciation`, `depreciationacc`, `depreciationcode`, `startyear`, `ipaddress`, `recorddate`, `username`, `locationcode`, `locationname`,`accumulateddepreciation`,`accumulateddepreciationcode`) 
			values ('$category', '$fixedasset', '$assetcode', '$asset', '$id','$assetvalue','$assetlife','$salvage','$depreciation','$depreciationledger','$depreciationledgerid','$startyear','$ipaddress','$ADate1','$username','$locationcode','$locationname','$accdepreciationledger','$accdepreciationledgerid')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$errmsg = "Success. New Depreciation Updated.";
			$bgcolorcode = 'success';
		}
		
		header("location:depreciation.php");
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


$patientcodeprefix = 'FA';
$patientcodeprefix1=strlen($patientcodeprefix);
//echo $patientcodeprefix1;
$query2 = "select * from master_fixedassets order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2id = $res2["id"];
if ($res2id == '')
{
	//$customercode = 'AMF00000001';
	$id = $patientcodeprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$res2id = $res2["id"];
	//echo $res2customercode;
	$id = substr($res2id,$patientcodeprefix1,9);
	
	$id = intval($id);
	
	$id = $id + 1;
//echo $customercode;
	$maxanum = $id;
	
	
	
	//$customercode = 'AMF'.$maxanum1;
	$id = $patientcodeprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
include ("autocompletebuild_depreciation.php");
include ("autocompletebuild_depreciationled.php");
include ("autocompletebuild_accdepreciation.php");
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
	if (document.form1.itemname.value == "")
	{
		alert ("Please Enter Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	if (document.form1.category.value == "")
	{
		alert ("Please Select Category.");
		document.form1.category.focus();
		return false;
	}
	if (document.form1.startyear.value == "")
	{
		alert ("Please Enter Start Year.");
		document.form1.startyear.focus();
		return false;
	}
	if (document.form1.depreciation.value == "")
	{
		alert ("Please Enter Depreciation.");
		document.form1.depreciation.focus();
		return false;
	}
	if (document.form1.depreciationledger.value == "")
	{
		alert ("Please Enter Depreciation.");
		document.form1.depreciationledger.focus();
		return false;
	}
	if (document.form1.accdepreciationledger.value == "")
	{
		alert ("Please Enter Acc Depreciation.");
		document.form1.accdepreciationledger.focus();
		return false;
	}
	if (document.form1.location.value == "")
	{
		alert ("Please Select Location.");
		document.form1.location.focus();
		return false;
	}
	if (document.form1.life.value == "0" || document.form1.life.value == "")
	{
		alert ("Please Enter Life.");
		document.form1.life.focus();
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

function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch3();
	
	
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
		document.getElementById("salvage").value = "<?php echo $salvage; ?>";
	}
	<?php
	}
	?>
	
	var Cost = document.getElementById("cost").value;
	var Salvage = document.getElementById("salvage").value;
	if(Cost == '') { Cost = 0; }
	if(Salvage == '') { Salvage = 0; }
	var Sal1 = parseFloat(Cost) * (parseFloat(Salvage) / 100);
	var Salm = parseFloat(Sal1) / 12;
	document.getElementById("depreciation").value = Sal1.toFixed(2);
	document.getElementById("depreciationmonth").value = Salm.toFixed(2);
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<?php include ("js/dropdownlist1scriptingdepreciation.php"); ?>
<script type="text/javascript" src="js/autocomplete_depreciation.js"></script>
<script type="text/javascript" src="js/autosuggestdepreciation.js"></script> 
<script type="text/javascript" src="js/autocompletebuild_depreciation.js"></script>
<script type="text/javascript" src="js/autosuggestdepreciation12.js"></script> 
<script type="text/javascript" src="js/autocompletebuild_accdepreciation.js"></script>
<script type="text/javascript" src="js/autosuggestdepreciation13.js"></script>
<script type="text/javascript" src="js/autodepreciationcodesearch.js"></script>
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
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
              <td><form name="form1" id="form1" method="post" action="depreciation.php" onSubmit="return addward1process1()" onKeyDown="return disableEnterKey()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Asset Details </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
              					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="id" id="id">
						<input name="itemname" id="itemname" style="text-transform:uppercase" size="40" value="" autocomplete="off"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Category</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="category" id="category" onChange="return Salvage()">
						<option value="" selected="selected">Select Type</option>
                          <?php
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
                        </select>
						<input type="hidden" name="assetanum" id="assetanum" style="text-transform:uppercase" size="2" readonly/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Ledger</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="asset" id="asset" style="text-transform:uppercase" size="40" readonly/>
						<input type="hidden" name="assetcode" id="assetcode" style="text-transform:uppercase" size="40" readonly/>
					  </td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cost</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="cost" id="cost" style="text-transform:uppercase" size="20" readonly/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation %</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="salvage" id="salvage" style="text-transform:uppercase" size="20" readonly/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Life</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="life" id="life" style="text-transform:uppercase" size="20"/> </td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Ledger</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="depreciationledger" id="depreciationledger" style="text-transform:uppercase" size="40" autocomplete="off"/>
						<input type="hidden" name="depreciationledgerid" id="depreciationledgerid" style="text-transform:uppercase" size="40"/>
					  </td>
					  </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Value / Year</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="depreciation" id="depreciation" readonly="readonly" style="text-transform:uppercase" size="20" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Value / Month</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="depreciationmonth" id="depreciationmonth" readonly="readonly" style="text-transform:uppercase" size="20" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Start Year </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="startyear" id="startyear" style="text-transform:uppercase" size="20" value=""/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Acc Depreciation Ledger</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accdepreciationledger" id="accdepreciationledger" style="text-transform:uppercase" size="40" autocomplete="off"/>
						<input type="hidden" name="accdepreciationledgerid" id="accdepreciationledgerid" style="text-transform:uppercase" size="20" readonly/>
						<input type="hidden" name="accdepreciation" id="accdepreciation" style="text-transform:uppercase" size="20" readonly/>
					  </td>
					  </tr>
						<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Entry Date</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="ADate1" id="ADate1" size="15" value="<?php echo date('Y-m-d'); ?>" readonly />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>	</td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" style="border: 1px solid #001E6A" >
						<option value="">Select Location</option>
						<?php
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationcode; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
						</td>
                      </tr>
					  
                      <tr>
                        <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="70%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" /></td>
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

