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
	$costprice = $_REQUEST['costprice'];
	$entrydate = $_REQUEST['entrydate'];
	$category1 = $_REQUEST['category'];
	$dep_percent = $_REQUEST['dep_percent'];
	$category = $category1;
	$department = $_REQUEST['department'];
	$department = ucfirst($department);
	$assetclass = $_REQUEST['assetclass'];
	$assetclass = ucfirst($assetclass);
	$unit = $_REQUEST['unit'];
	$period = $_REQUEST['period'];
	$startyear = $_REQUEST['startyear'];
	$startyear = strtoupper($startyear);
	$assetanum = $_REQUEST['assetanum'];
	$depreciation = $_REQUEST['depreciation'];
	$depreciationcode = $_REQUEST['depreciationcode'];
	$accdepreciation = $_REQUEST['accdepreciation'];
	$accdepreciationcode = $_REQUEST['accdepreciationcode'];
	$accdepreciationvalue = $_REQUEST['accdepreciationvalue'];
	$accdepreciationvalue = str_replace(',','',$accdepreciationvalue);
	
	$query33 = "select asset_id from assets_register where asset_id = '$assetid'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row33 = mysqli_num_rows($exec33);
	if($row33 == 0)
	{ 
		$query88 = "UPDATE assets_register SET `asset_id` = '$assetid', `asset_category` = '$category', `asset_department` = '$department', `asset_unit` = '$unit', `asset_period` = '$period',
		`startyear` = '$startyear', asset_class = '$assetclass', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciationcode', `accdepreciationledger` = '$accdepreciation',
		`accdepreciationledgercode` = '$accdepreciationcode', `accdepreciation` = '$accdepreciationvalue' WHERE `auto_number` = '$assetanum'";
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:assetregister.php?st=success&&assetanum=$assetanum");
	}
	else
	{
		$query88 = "UPDATE assets_register SET `asset_category` = '$category', `asset_department` = '$department', `asset_unit` = '$unit', `asset_period` = '$period',
		`startyear` = '$startyear', asset_class = '$assetclass', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciationcode', `accdepreciationledger` = '$accdepreciation',
		`accdepreciationledgercode` = '$accdepreciationcode', `accdepreciation` = '$accdepreciationvalue' WHERE `auto_number` = '$assetanum'";
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:assetregister.php?st=success&&assetanum=$assetanum");
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["assetanum"])) { $assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }
if($st == 'error')
{
	$errmsg = "Asset ID already exists";
}
if($st == 'success')
{
?>
<script>
window.open("print_assetlable.php?assetanum="+<?= $assetanum;?>+"","Window",'width=500,height=300,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
</script>
<?php
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


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
$depreciationledger = $res77['depreciationledger'];
$depreciationledgercode = $res77['depreciationledgercode'];
$accdepreciationledger = $res77['accdepreciationledger'];
$accdepreciationledgercode = $res77['accdepreciationledgercode'];
$accdepreciationvalue = $res77['accdepreciation'];
$depreciation = $totalamount * ($dep_percent / 100);
$accdepreciation = $depreciation * $asset_period;
$totalamount = number_format($totalamount,2);
$depreciation = number_format($depreciation,2);
$accdepreciation = number_format($accdepreciation,2);
$asset_classid = '';
if($asset_class != '')
{
$query61 = "select * from master_assetcategory where category like '$asset_class' and recordstatus <> 'deleted'";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
$res61 = mysqli_fetch_array($exec61);
$asset_classid = $res61['id'];
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
	//alert ("Inside Funtion");
	if (document.form1.assetid.value == "")
	{
		alert ("Please Enter Asset ID.");
		document.form1.assetid.focus();
		return false;
	}
	if (document.form1.assetclassid.value == "")
	{
		alert ("Please Select Asset Class From Search List.");
		document.form1.assetclass.focus();
		return false;
	}
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department");
		document.form1.department.focus();
		return false;
	}
	if (document.form1.unit.value == "")
	{
		alert ("Please Select Unit");
		document.form1.unit.focus();
		return false;
	}
	if (document.form1.period.value == "")
	{
		alert ("Please Enter Life.");
		document.form1.period.focus();
		return false;
	}
	if (document.form1.category.value == "")
	{
		alert ("Please Select Category.");
		document.form1.category.focus();
		return false;
	}
	if (document.form1.depreciationcode.value == "")
	{
		alert ("Please Enter Depreciation Ledger");
		document.form1.depreciation.focus();
		return false;
	}
	if (document.form1.accdepreciationcode.value == "")
	{
		alert ("Please Enter Accu Depreciation Ledger");
		document.form1.accdepreciation.focus();
		return false;
	}
}


function UnitSelect(val)
{
	<?php 
	$query_c = "select * from master_assetdepartment where recordstatus <> 'deleted' group by department";
	$exec_c = mysqli_query($GLOBALS["___mysqli_ston"], $query_c) or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res_c = mysqli_fetch_array($exec_c))
	{
		$assetdepartment = $res_c['department'];
	?>
	if(val == "<?php echo $assetdepartment; ?>")
	{
		document.getElementById("unit").options.length=null; 
		var combo = document.getElementById('unit'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select", ""); 
		<?php
		$query10 = "select * from master_assetdepartment where department = '$assetdepartment' and recordstatus <> 'deleted'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$unit = $res10["unit"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $unit;?>", "<?php echo $unit;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#depreciation').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=depreciation&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#depreciationcode').val(code);
			},
	html: true
    });
	
$('#accdepreciation').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=accdepreciation&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#accdepreciationcode').val(code);
			},
	html: true
    });	
	$('#assetclass').autocomplete({
	source:'autoassetclasssearch.php', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			var assetid = ui.item.asset_id;
			$('#assetclassid').val(code);
			
			},
	html: true
    });	
	
	$('#category').autocomplete({
	source:'autoassetclasssearch.php', 
	select: function(event,ui){
			var salvage = ui.item.salvage;
			var anum = ui.item.anum;
			$('#dep_percent').val(salvage);
			var assetano = $('#assetanum').val();
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
              <td><form name="form1" id="form1" method="post" action="asset_recording.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Asset Recording </strong></td>
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
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Category</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" name="category" id="category" value="<?php echo $asset_category; ?>" size="40" style="border: 1px solid #001E6A;">
		
                        <input type="hidden" name="dep_percent" id="dep_percent" value="<?php echo $dep_percent; ?>"></td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Class </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetclass" id="assetclass" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_class; ?>"/>
						<input type="hidden" name="assetclassid" id="assetclassid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_class; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="department" id="department" style="border: 1px solid #001E6A;" onChange="return UnitSelect(this.value);">
						<option value="">Select</option>
                        <?php 
						$query_c = "select * from master_assetdepartment where recordstatus <> 'deleted' group by department";
						$exec_c = mysqli_query($GLOBALS["___mysqli_ston"], $query_c) or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_c = mysqli_fetch_array($exec_c))
						{
							$assetdepartment = $res_c['department'];
						?>
						<option value="<?php echo $assetdepartment; ?>" <?php if($assetdepartment == $asset_department) { echo "selected"; } ?>><?php echo $assetdepartment; ?></option>
						<?php
						}
						?>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="unit" id="unit" style="border: 1px solid #001E6A;">
                        <option value="">Select</option>
                        <?php 
						$query_u = "select * from master_assetdepartment where department = '$asset_department' and recordstatus <> 'deleted'";
						$exec_u = mysqli_query($GLOBALS["___mysqli_ston"], $query_u) or die ("Error in Query_u".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_u = mysqli_fetch_array($exec_u))
						{
							$assetunit = $res_u['unit'];
						?>
						<option value="<?php echo $assetunit; ?>" <?php if($assetunit == $asset_unit) { echo "selected"; } ?>><?php echo $assetunit; ?></option>
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
						<input name="assetid" id="assetid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_id; ?>"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cost </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="costprice" id="costprice" value="<?php echo $totalamount; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Acquisition Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="entrydate" id="entrydate" value="<?php echo $entrydate; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
					  
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Life </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="period" id="period" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_period; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Start Year </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="startyear" id="startyear" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php if($startyear == '') { echo date('M-Y',strtotime($entrydate)); } else { echo $startyear; } ?>"/></td>
                      </tr>
					   
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="depreciation" id="depreciation" value="<?php echo $depreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="depreciationcode" id="depreciationcode" value="<?php echo $depreciationledgercode; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accu Depreciation Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accdepreciation" id="accdepreciation" value="<?php echo $accdepreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="accdepreciationcode" id="accdepreciationcode" value="<?php echo $accdepreciationledgercode; ?>">
						<input type="hidden" name="accdepreciationvalue" id="accdepreciationvalue" value="<?php echo $accdepreciation; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
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

