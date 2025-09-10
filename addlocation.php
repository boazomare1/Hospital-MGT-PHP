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
$locationcode='';
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$location = $_REQUEST["location"];
	$prefix = $_REQUEST["prefix"];
	$suffix = $_REQUEST["suffix"];
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$phone = $_REQUEST["phone"];
	$email = $_REQUEST["email"];
	$paynowbillprefix = 'LTC-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_location order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["locationcode"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["locationcode"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$paynowbillprefixcentral = 'CTL-';
$paynowbillprefix1central=strlen($paynowbillprefixcentral);
$query2central = "select * from master_store where store = 'CENTRAL STORE' order by auto_number desc limit 0, 1";
$exec2central = mysqli_query($GLOBALS["___mysqli_ston"], $query2central) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2central = mysqli_fetch_array($exec2central);
$billnumbercentral = $res2central["storecode"];
$billdigitcentral=strlen($billnumbercentral);
if ($billnumbercentral == '')
{
	$billnumbercodecentral =$paynowbillprefixcentral.'1';
	$openingbalancecentral = '0.00';
}
else
{
	$billnumbercentral = $res2central["storecode"];
	$billnumbercodecentral = substr($billnumbercentral,$paynowbillprefix1central, $billdigitcentral);
	//echo $billnumbercode;
	$billnumbercodecentral = intval($billnumbercodecentral);
	$billnumbercodecentral = $billnumbercodecentral + 1;

	$maxanumcentral = $billnumbercodecentral;
	
	
	$billnumbercodecentral = $paynowbillprefixcentral .$maxanumcentral;
	$openingbalancecentral = '0.00';
	//echo $companycode;
}

	$locationcode = strtoupper($locationcode);
	$prefix = strtoupper($prefix);
	$suffix = strtoupper($suffix);
	$address1 = strtoupper($address1);
	$address2 = strtoupper($address2);
	$location = trim($location);
	$length=strlen($location);
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_location where locationname = '$location'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_location (locationcode,locationname,prefix,suffix,address1,address2,phone,email,ipaddress, username) 
		values ('$billnumbercode','$location','$prefix','$suffix','$address1','$address2','$phone','$email','$ipaddress', '$username')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Department Updated.";
		$bgcolorcode = 'success';
		
		$query55 = "select * from master_location where locationcode='$billnumbercode'";
		$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res55 = mysqli_fetch_array($exec55);
		$locationanum = $res55['auto_number'];
		
		$query2 = "insert into master_store (location, store,storecode, ipaddress, recorddate, username) 
		values ('$locationanum', 'CENTRAL STORE', '$billnumbercodecentral','$ipaddress', '$updatedatetime', '$username')";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Department Already Exists.";
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
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_location set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_location set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_location set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_location set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_location set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Department To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'LTC-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_location order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["locationcode"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["locationcode"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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
	if (document.form1.location.value == "")
	{
		alert ("Pleae Enter Location Name");
		document.form1.location.focus();
		return false;
	}
}

function ucFirstAllWords1( str,id,key)
{
	var keycode = (key.which) ? key.which : key.keyCode;	
	//alert(str);		
		
		
		if(document.getElementById('fullnamevaild').value=='1')
		{
			//pieces=1;
			//var pieces = str.split(" ");
			var str=str;
			//alert(str);
		}
		else
		{
			var str=str;
			//var pieces = str.split(" ");
			//var pieces = pieces.length;
		}
		var pieces = str.split(" ");
		//alert(pieces);
		for ( var i = 0; i < pieces.length; i++ )
		{
			var j = pieces[i].charAt(0).toUpperCase();
			pieces[i] = j + pieces[i].substr(1);
		}
		var word = pieces.join(" ");
		//alert(word);
		document.getElementById(id).value=word;
	
}
function funcDeleteDepartment1(varDepartmentAutoNumber)
{

     var varDepartmentAutoNumber = varDepartmentAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Department '+varDepartmentAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Department  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Department Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="addlocation.php" onSubmit="return addward1process1()">
                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Location Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location Code </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="locationcode" id="locationcode" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" value="<?php echo $billnumbercode; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="location" id="location" onKeyPress="ucFirstAllWords1(this.value,this.id,event)" style="border: 1px solid #001E6A; " size="40" /><input name="fullnamevaild" id="fullnamevaild" type="hidden">
                    </td>
                      </tr> 
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">PREFIX</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="prefix" id="prefix" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">SUFFIX</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="suffix" id="suffix" style="border: 1px solid #001E6A; text-transform:uppercase; " size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ADDRESS1</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="address1" id="address1" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ADDRESS2</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="address2" id="address2" style="border: 1px solid #001E6A; text-transform:uppercase; " size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF"  class="bodytext3"><div align="right">PHONE</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="phone" id="phone"  style="border: 1px solid #001E6A; " size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">EMAIL </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="email" id="email" style="border: 1px solid #001E6A;" size="40" /></td>
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
                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong>Location Master - Existing List </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <tr>
                      <tr>
                      <td width="10%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Delete</td>
                      <td width="10%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Location Code</td>
                      <td width="20%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Location Name</td>
                      <td width="15%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Prefix</td>
                      <td width="15%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Suffix</td>
                      <td width="20%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Phone</td>
                      <td width="10%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        </tr>
                      <?php
	    $query1 = "select * from master_location where status <> 'deleted' order by locationname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$location = $res1["locationname"];
		$locationcode = $res1['locationcode'];
		$prefix = $res1['prefix'];
		$suffix = $res1['suffix'];
		$address1 = $res1['address1'];
		$address2 = $res1['address2'];
		$phone = $res1['phone'];
		$email = $res1['email'];
	
		$auto_number = $res1["auto_number"];
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
                        <td width="7%" align="left" valign="top"  class="bodytext3"><div align="center">
						<a href="addlocation.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteDepartment1('<?php echo $department;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
						  <td width="10%" align="left" valign="top"  class="bodytext3"><?php echo $locationcode; ?> </td>
                        <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
                        <td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $prefix; ?> </td>
                        <td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $suffix; ?> </td>
                        <td width="8%" align="left" valign="top"  class="bodytext3"><?php echo $phone; ?> </td>
                        <td width="10%" align="left" valign="top"  class="bodytext3">
						<a href="editlocation.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Location Master - Deleted </strong></td>
                      </tr>
                      <tr>
                      <td width="7%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Activate</td>
                      <td width="10%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Location Code</td>
                      <td width="20%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Location Name</td>
                      <td width="5%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Prefix</td>
                      <td width="5%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Suffix</td>
                      <td width="8%" align="left" valign="left"  bgcolor="#FFFFFF" class="bodytext3">Phone</td>
                        </tr>
                      <?php
		
	    $query1 = "select * from master_location where status = 'deleted' order by locationname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
	$location = $res1["locationname"];
		$locationcode = $res1['locationcode'];
		$prefix = $res1['prefix'];
		$suffix = $res1['suffix'];
		$address1 = $res1['address1'];
		$address2 = $res1['address2'];
		$phone = $res1['phone'];
		$email = $res1['email'];
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
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addlocation.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="left" class="bodytext3">Activate</div>
                        </a></td>
              	  <td width="10%" align="left" valign="top"  class="bodytext3"><?php echo $locationcode; ?> </td>
                        <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
                        <td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $prefix; ?> </td>
                        <td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $suffix; ?> </td>
                        <td width="8%" align="left" valign="top"  class="bodytext3"><?php echo $phone; ?> </td>
                             </tr>
                      <?php
		}
		?>
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

