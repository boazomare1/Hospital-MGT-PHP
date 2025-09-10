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
	$location = $_REQUEST["location"];
	$store = $_REQUEST["store"];
	$storeno = $_REQUEST['storeno'];
	$store = strtoupper($store);
	$store = trim($store);
	$length=strlen($store);
	$description = $_REQUEST['description'];
	$calories = $_REQUEST['calories'];
	$amountkit = $_REQUEST['amountkit'];
	
	$query6 = "select * from master_location where auto_number = '$location'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$locationcode = $res6['locationcode'];
	$locationname = $res6['locationname'];
	//echo $length;
	
	$query2 = "select * from master_ipkitchen where typename = '$store' and locationcode = '$location'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_ipkitchen (rate,typename,typecode, description, calories, ipaddress,username,add_datetime,locationcode,locationname) 
		values ('".$amountkit."','".$store."','".$storeno."','".$description."','".$calories."','".$ipaddress."','".$username."','".date('Y-m-d h:i:s')."','".$locationcode."','".$locationname."')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Store Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Name Already Exists.";
		$bgcolorcode = 'failed';
	}
	
	
header('location:addkitchenmaster.php');
exit();
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_ipkitchen set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_ipkitchen set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_ipkitchen set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_ipkitchen set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_store set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


 $query5 = "select typecode from master_ipkitchen where 1 order by auto_number desc";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res=mysqli_fetch_array($exec5);
	 $storecode=$res['typecode'];
	 $storecode=$res['typecode'];
	 $stotemp=substr($storecode,2,9);
	 $storecode=$stotemp+1;
	

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
	if (document.form1.store.value == "")
	{
		alert ("Pleae Enter Name.");
		document.form1.store.focus();
		return false;
	}
	if (document.form1.description.value == "")
	{
		alert ("Pleae Enter Description.");
		document.form1.description.focus();
		return false;
	}
	if (document.form1.calories.value == "")
	{
		alert ("Pleae Enter Calories.");
		document.form1.calories.focus();
		return false;
	}
	if (document.form1.amountkit.value == "")
	{
		alert ("Pleae Enter Amount.");
		document.form1.amountkit.focus();
		return false;
	}
}
function funcDeletestore(varstoreAutoNumber)
{
 var varstoreAutoNumber = varstoreAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varstoreAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Store Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Store Entry Delete Not Completed.");
		return false;
	}

}
function isNumberDecimal(evt) {
        //getting key code of pressed key  
        var charCode = (evt.which) ? evt.which : evt.keyCode
  //comparing pressed keycodes
  
        if (  (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        return true;
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
              <td><form name="form1" id="form1" method="post" action="addkitchenmaster.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Kitchen Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location"  style="border: 1px solid #001E6A;">
						
                          <?php
				$query5 = "select * from master_location where status = '' order by locationname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5location = $res5["locationname"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5location; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Menu No </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="storeno" id="storeno" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly value="KM<?php echo $storecode;?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Menu </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="store" id="store" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					   
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Description</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="description" id="description" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Calories</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="calories" id="calories" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" onKeyPress="return isNumberDecimal(event)"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amountkit" id="amountkit" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" onKeyPress="return isNumberDecimal(event)"/></td>
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
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Kitchen Master - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Location </strong></td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Menu </strong></td>
                        <td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_ipkitchen where recordstatus <> 'deleted' order by locationname";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$locationanum = $res1['locationcode'];
		$store = $res1["typename"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		
		
		$location = $res1['locationname'];
	
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
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
					    <a href="addkitchenmaster.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletestore('<?php echo $store;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $store; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editipkitchen.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>
						</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Kitchen Master - Deleted </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Store </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_ipkitchen where recordstatus = 'deleted' order by locationname";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$locationanum = $res1['locationname'];
		$store = $res1["typename"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		
		
		$location = $res1['locationname'];
	
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
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addkitchenmaster.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>
                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $store; ?></td>
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

