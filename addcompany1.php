<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];

if (isset($_POST["companyanum"])) { $companyanum = $_POST["companyanum"]; } else { $companyanum = ""; }
//$companyanum = $_SESSION["companyanum"];
if (isset($_POST["companyanum"])) { $companyanum = $_POST["companyanum"]; } else { $companyanum = ""; }
//$companyanum = $_SESSION["companyname"];

$errmsg = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$companycode=$_REQUEST["companycode"];
	$companyname = $_REQUEST["companyname"];
	//$companyname = strtoupper($companyname);
	$companyname = trim($companyname);
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber1 = $_REQUEST["faxnumber1"];
	$faxnumber2  = $_REQUEST["faxnumber2"];
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$tinnumber = $_REQUEST["tinnumber"];
	$cstnumber = $_REQUEST["cstnumber"];
	//$companystatus  = $_REQUEST["companystatus"];
	$currencyname = $_REQUEST["currencyname"];
	$currencydecimalname = $_REQUEST["currencydecimalname"];
	$currencycode = $_REQUEST["currencycode"];
	$stockmanagement = $_REQUEST["stockmanagement"];
	$patientcodeprefix = $_REQUEST["patientcodeprefix"];
	$patientcodeprefix = strtoupper($patientcodeprefix);
	$showlogo = $_REQUEST["showlogo"];
	
	$companystatus = 'Active'; 
	
	$dateposted = $updatedatetime;
	
	$query2 = "select * from master_company where companyname = '$companyname'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_company (companycode,companyname, tinnumber, cstnumber, 
		phonenumber1, phonenumber2, emailid1, emailid2, faxnumber1, faxnumber2, address1,address2, 
		area, city, state, pincode, country, companystatus, dateposted, 
		currencyname, currencycode, stockmanagement, currencydecimalname, patientcodeprefix) 
		values ('$companycode','$companyname', '$tinnumber', '$cstnumber', 
		'$phonenumber1', '$phonenumber2', '$emailid1', '$emailid2', '$faxnumber1', '$faxnumber2', '$address1','$address2', 
		'$area', '$city', '$state', '$pincode', '$country', '$companystatus', '$dateposted', 
		'$currencyname', '$currencycode', '$stockmanagement', '$currencydecimalname', '$patientcodeprefix')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query2 = "select * from master_company where companycode = '$companycode' and dateposted = '$dateposted'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$companyanum = $res2["auto_number"];
		
		$query3 = "select * from master_settings_primaryvalues order by auto_number"; // group by settingsname order by auto_number";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res3 = mysqli_fetch_array($exec3))
		{
			$res3modulename = $res3["modulename"];
			$res3submodulename = $res3["submodulename"];
			$res3settingsname = $res3["settingsname"];
			$res3settingsvalue = $res3["settingsvalue"];
			
			$query5 = "select * from master_settings where companyanum = '$companyanum' and companycode = '$companycode' and 
			settingsname = '$res3settingsname' and modulename = '$res3modulename'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount5 = mysqli_num_rows($exec5);
			if ($rowcount5 == 0)
			{
				$query4 = "insert into master_settings (companyanum, companycode, modulename, submodulename, settingsname, settingsvalue) 
				value ('$companyanum', '$companycode', '$res3modulename', '$res3submodulename', '$res3settingsname', '$res3settingsvalue')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
			
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$emailid1  = '';
		$emailid2 = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address1 = '';
		$address2 = '';
		$area = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$patientcodeprefix = '';
		$showlogo = '';
		
		$dateposted = $updatedatetime;
		header("location:setactivecompany1.php");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:addcompany1.php?st=failed");
	}

}
else
{
	$companyname = isset($_REQUEST["companyname"]);
	$companyname = strtoupper($companyname);
	$title1  = isset($_REQUEST["title1"]);
	$title2  = isset($_REQUEST["title2"]);
	$contactperson1  = isset($_REQUEST["contactperson1"]);
	$contactperson2 = isset($_REQUEST["contactperson2"]);
	$designation1 = isset($_REQUEST["designation1"]);
	$designation2  = isset($_REQUEST["designation2"]);
	$phonenumber1 = isset($_REQUEST["phonenumber1"]);
	$phonenumber2 = isset($_REQUEST["phonenumber2"]);
	$emailid1  = isset($_REQUEST["emailid1"]);
	$emailid2 = isset($_REQUEST["emailid2"]);
	$faxnumber1 = isset($_REQUEST["faxnumber1"]);
	$faxnumber2  = isset($_REQUEST["faxnumber2"]);
	$address1 = isset($_REQUEST["address1"]);
	$address2 = isset($_REQUEST["address2"]);
	$area = isset($_REQUEST["area"]);
	$location = isset($_REQUEST["location"]);
	$city  = isset($_REQUEST["city"]);
	$pincode = isset($_REQUEST["pincode"]);
	$country = isset($_REQUEST["country"]);
	$state = isset($_REQUEST["state"]);
	$tinnumber = isset($_REQUEST["tinnumber"]);
	$cstnumber = isset($_REQUEST["cstnumber"]);
	$companystatus  = isset($_REQUEST["companystatus"]);
	$currencyname  = isset($_REQUEST["currencyname"]);
	$currencydecimalname = isset($_REQUEST["currencydecimalname"]);
	$currencycode = isset($_REQUEST["currencycode"]);
	$patientcodeprefix = isset($_REQUEST["patientcodeprefix"]);
	$f9color = '#000000';//isset($_REQUEST["f9color"]);
	$f10color = '#000000';//isset($_REQUEST["f10color"]);
	$f25color  = '#000000';//isset($_REQUEST["f25color"]);
	$dateposted = $updatedatetime;
	$showcity = $city;
	$showlogo = $_REQUEST["showlogo"];
	
}

if (isset($_REQUEST["st"]))
{
	$st = $_REQUEST["st"];
	if ($st == 'success')
	{
			$errmsg = "Success. New Company Updated.";
			$cpynum = $_REQUEST["cpynum"];
			if ($cpynum == 1) //for first company.
			{
				$errmsg = "Success. New Company Updated. Please Logout & Login Again To Proceed.";
			}
	}
	else if ($st == 'failed')
	{
			$errmsg = "Failed. Company Already Exists.";
	}
}

$cpycount = isset($_REQUEST["cpycount"]);
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Here.";
}

$query1 = "select * from master_company order by auto_number desc limit 0, 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0)
{
	$companycode = 'HSP00000001';
}
else
{
	$res1 = mysqli_fetch_array($exec1);
	$res1companycode = $res1["companycode"];
	$companycode = substr($res1companycode, 3, 8);
	$companycode = intval($companycode);
	$companycode = $companycode + 1;

	$maxanum = $companycode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$companycode = 'HSP'.$maxanum1;

	//echo $companycode;
}
//echo $res1companycode;

if ($currencyname == '') $currencyname = 'Rupees';
if ($currencydecimalname == '') $currencydecimalname = 'Paise';
if ($currencycode == '') $currencycode = 'INR';


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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}

}

function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
	<?php
	$query11 = "select * from master_state group by state order by state";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$statename = $res11["state"];
	?>
		if(document.form1.state.value=="<?php echo $statename; ?>")
		{
		document.getElementById("city").options.length=null; 
		var combo = document.getElementById('city'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select City", ""); 
		<?php
		$query10="select * from master_city where state = '$statename' group by city order by city asc";
		$exec10=mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10=mysqli_fetch_array($exec10))
		{
		$loopcount=$loopcount+1;
		$city1=$res10["city"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $city;?>", "<?php echo $city;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
}



function from1submit1()
{

	if (document.form1.companyname.value == "")
	{
		alert ("Company Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.state.value == "")
	{
		alert ("State Cannot Be Empty.");
		document.form1.state.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		alert ("City Cannot Be Empty.");
		document.form1.city.focus();
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
}

</script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	if ($cpycount == 'firstcompany')
	{
		include ("includes/menu2.php"); 
	}
	else
	{
		include ("includes/menu1.php"); 
	}
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
	
	<?php 
	if ($cpycount != 'firstcompany')
	{
	?>
	<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#011E6A">
          <td colspan="5" bgcolor="#999999" class="bodytext3"><strong>Company - Existing List </strong></td>
        </tr>
        <tr bgcolor="#011E6A">
          <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
          <td width="30%" bgcolor="#ecf0f5" class="bodytext3"><strong>Name</strong></td>
          <td width="41%" bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
          <td width="12%" bgcolor="#ecf0f5" class="bodytext3"><strong>Phone</strong></td>
          <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Status </strong></td>
        </tr>
        <?php
		$colorloopcount = '';
		$searchcontact = isset($_REQUEST["searchcontact"]);
	    $query100 = "select * from master_company order by companyname ";
		$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res100 = mysqli_fetch_array($exec100))
		{
		$res100companyname = $res100["companyname"];
		$res100address = $res100["address1"];
		$res100phonenumber1 = $res100["phonenumber1"];
		$res100companystatus = $res100["companystatus"];
		$res100auto_number = $res100["auto_number"];
	
		
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
		  <div align="center"><a href="editcompany1.php?anum=<?php echo $res100auto_number; ?>" class="bodytext3">Edit</a></div>		  </td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100companyname; ?> </td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100address; ?></td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100phonenumber1; ?></td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100companystatus; ?></td>
        </tr>
        <?php
		}
		?>
      </tbody>
    </table>  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">  
  <tr>
	<?php
	}
	?>	
	
	
	
    <td width="1%">&nbsp;</td>
    <td width="1%" valign="top">&nbsp;</td>
    <td width="98%" valign="top">


      	  <form name="form1" id="form1" method="post" action="addcompany1.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Company - New </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                </tr>
              <tr>
                <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Company Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="companyname" id="companyname" value="<?php echo $companyname; ?>" style="border: 1px solid #001E6A;" size="60"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 1 </td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address1" id="address1" value="<?php echo $address1; ?>" style="border: 1px solid #001E6A;"  size="60" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 2 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address2" id="address2" value="<?php echo $address2; ?>" style="border: 1px solid #001E6A;"  size="40" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Area / Location </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="area" id="area" value="<?php echo $area; ?>" style="border: 1px solid #001E6A"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">  State*</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> City* </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="city" id="city" value="<?php echo $city; ?>" style="border: 1px solid #001E6A"  size="20" />			</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Country </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="country" id="country" value="<?php echo $country; ?>" style="border: 1px solid #001E6A"  size="20" />			</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Pincode</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="pincode" id="pincode" value="<?php echo $pincode; ?>" style="border: 1px solid #001E6A"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 1 </td>
                <td width="35%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" style="border: 1px solid #001E6A" size="20" />                </td>
                <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 2 </td>
                <td width="33%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" style="border: 1px solid #001E6A"  size="20"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Fax Number 1 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="faxnumber1" id="faxnumber1" value="<?php echo $faxnumber1; ?>" style="border: 1px solid #001E6A"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Fax Number 2 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="faxnumber2" id="faxnumber2" value="<?php echo $faxnumber2; ?>" style="border: 1px solid #001E6A"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 1 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" style="border: 1px solid #001E6A"  size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 2 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" style="border: 1px solid #001E6A"  size="20"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TIN Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">CST Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Name </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="currencyname" id="currencyname" value="<?php echo $currencyname; ?>" style="border: 1px solid #001E6A;"  size="10" />
                    <span class="bodytext3">* Ex: Rupees / Dollar </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Decimal Name </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="currencydecimalname" id="currencydecimalname" value="<?php echo $currencydecimalname; ?>" style="border: 1px solid #001E6A;"  size="10" />
                  <span class="bodytext3">* Ex: Paise / Cent </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Code </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="currencycode" id="currencycode" value="<?php echo $currencycode; ?>" style="border: 1px solid #001E6A;"  size="10" />
                    <span class="bodytext3">* Ex: INR / USD </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Code Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="patientcodeprefix" id="patientcodeprefix" value="<?php echo $currencydecimalname; ?>" style="border: 1px solid #001E6A;"  size="10" />
                  <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Date Created </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="dateposted" id="dateposted" value="<?php echo $dateposted; ?>" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5"  size="20"  readonly="readonly" />                <!--Company Status-->                  &nbsp;
				
			&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Company Code   *</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="companycode" id="companycode" value="<?php echo $companycode; ?>" readonly="readonly" style="border: 1px solid #001E6A;text-transform: uppercase; background-color:#ecf0f5" size="20"></td>
                <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>-->
              </tr>
              <tr>
                <td align="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Show Logo </span></td>
                <td align="middle"  bgcolor="#ecf0f5">
				<select name="showlogo" id="showlogo" >
                  <?php
					if ($showlogo != '')
					{
					?>
                  <option value="<?php echo $showlogo; ?>" selected="selected"><?php echo $showlogo; ?></option>
                  <?php
					}
					else
					{
					?>
                  <option value="HIDE LOGO" selected="selected">HIDE LOGO</option>
                  <?php
					}
					?>
                  <option value="SHOW LOGO">SHOW LOGO</option>
                  <option value="HIDE LOGO">HIDE LOGO</option>
                </select>
				</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td align="middle" colspan="4" ><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 
            align="left" border="0">
                  <tbody>
                    <tr>
                      <td width="3%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                      <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                      <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                      <td width="41%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                          <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                          <input name="Submit222" type="submit"  value="Save Company" class="button" style="border: 1px solid #001E6A"/>
                      </font></font></font></font></font></div></td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
    <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
  <tr>
    <td colspan="3"></td>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

