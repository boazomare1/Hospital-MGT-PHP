<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$suppliercode=$_REQUEST["suppliercode"];
	$suppliername = $_REQUEST["suppliername"];
	//$suppliername = strtoupper($suppliername);
	$suppliername = trim($suppliername);
	$typeofsupplier = '';
	$address1=$_REQUEST["address1"];
	$address2=$_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber = '';
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks = '';
	$tinnumber=$_REQUEST["tinnumber"];
	$cstnumber=$_REQUEST["cstnumber"];
	$openingbalance=$_REQUEST["openingbalance"];
	$status = '';
		
	$query2 = "select * from master_supplier where suppliercode = '$suppliercode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
		$query1 = "update master_supplier set suppliername = '$suppliername', 
		typeofsupplier = '$typeofsupplier', address1 = '$address1', address2 = '$address2',
		area = '$area', city = '$city', state = '$state', country = '$country', 
		pincode = '$pincode', phonenumber1 = '$phonenumber1', phonenumber2 = '$phonenumber2', faxnumber = '$faxnumber', 
		mobilenumber = '$mobilenumber', emailid1 = '$emailid1', emailid2 = '$emailid2',
		remarks = '$remarks', status = '$status', tinnumber = '$tinnumber', cstnumber = '$cstnumber', 
		openingbalance = '$openingbalance' where suppliercode  = '$suppliercode'"; 
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
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
		$address = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$dateposted = $updatedatetime;
		header("location:editsupplier1.php?suppliercode=$suppliercode&&st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:editsupplier1.php?suppliercode=$suppliercode&&st=failed");
	}

}
else
{
	$suppliercode=$_REQUEST["suppliercode"];
	$query2 = "select * from master_supplier where suppliercode = '$suppliercode' order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	
	$suppliercode = $res2["suppliercode"];
	$suppliername = $res2["suppliername"];
	//$suppliername = strtoupper($suppliername);
	$suppliername = trim($suppliername);
	$typeofsupplier = $res2["typeofsupplier"];
	$address1 = $res2["address1"];
	$address2 = $res2["address2"];
	$area = $res2["area"];
	$city  = $res2["city"];
	$state  = $res2["state"];
	$pincode = $res2["pincode"];
	$country = $res2["country"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$emailid1  = $res2["emailid1"];
	$emailid2 = $res2["emailid2"];
	$faxnumber = $res2["faxnumber"];
	$mobilenumber  = $res2["mobilenumber"];
	$remarks=$res2["remarks"];
	$tinnumber=$res2["tinnumber"];
	$cstnumber=$res2["cstnumber"];
	$openingbalance=$res2["openingbalance"];
	$dateposted=$res2["dateposted"];
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Supplier Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Supplier Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Supplier Already Exists.";
}


/*
$query2 = "select * from master_supplier order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2suppliercode = $res2["suppliercode"];
if ($res2suppliercode == '')
{
	$suppliercode = 'CST00000001';
	$openingbalance = '0.00';
}
else
{
	$res2suppliercode = $res2["suppliercode"];
	$suppliercode = substr($res2suppliercode, 3, 8);
	$suppliercode = intval($suppliercode);
	$suppliercode = $suppliercode + 1;

	$maxanum = $suppliercode;
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
	
	$suppliercode = 'CST'.$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}
*/



?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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

function onloadfunction1()
{
	document.form1.suppliername.focus();	
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


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function process1()
{

	if (document.form1.suppliercode.value == "")
	{
		alert ("Company Code Cannot Be Empty.");
		document.form1.suppliercode.focus();
		return false;
	}
	if (document.form1.suppliername.value == "")
	{
		alert ("Supplier Name Cannot Be Empty.");
		document.form1.suppliername.focus();
		return false;
	}
/*	else if (document.form1.address1.value == "")
	{
		alert ("Address1  Cannot Be Empty.");
		document.form1.address1.focus();
		return false;
	}
*/
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
/*
	else if (isNaN(document.getElementById("pincode").value))
	{
		alert ("Pincode Can Only Be Numbers");
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
*/
	if (document.form1.openingbalance.value == "")
	{
		alert ("Opening Balance Cannot Be Empty.");
		document.form1.openingbalance.value = "0.00";
		document.form1.openingbalance.focus();
		return false;
	}
	if (isNaN(document.form1.openingbalance.value))
	{
		alert ("Opening Balance Can Only Be Numbers.");
		document.form1.openingbalance.focus();
		return false;
	}
	//return false;
}

</script>
<body onLoad="return onloadfunction1()">
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
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="editsupplier1.php" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Supplier - Edit </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Supplier Name   *</span></td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="60"></td>
                </tr>
			  <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 1 </td>
			    <td width="39%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address1" id="address1" value="<?php echo $address1; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 2 </td>
                <td width="29%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address2" id="address2" value="<?php echo $address2; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
			  </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31"><span class="bodytext32">State</span></span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="state" id="state" onChange="return processflowitem1()">
                  <?php
		 			 	if ($state != '') 
		  	{
			  echo '<option value="'.$state.'" selected="selected">'.$state.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_state where status <> 'deleted' order by state";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.state".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$state = $res1["state"];
			?>
                  <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                  <?php
			  }
			  ?>
                </select>
-->				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">City </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="city" id="city" value="<?php echo $city; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="city" id="city" >
                  <option value="">Select City</option>
                </select>
-->				   </td>
              </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Area</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext31">
				     <input name="area" id="area" value="<?php echo $area; ?>" style="border: 1px solid #001E6A;"  size="20" />
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Country </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="country" id="country" value="<?php echo $country; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="country" id="select">
                    <?php
		 	if ($country != '') 
		  	{
			  echo '<option value="'.$country.'" selected="selected">'.$country.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_country where status <> 'deleted' order by country";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.country".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$country = $res1["country"];
			if ($country == 'India') { $selectedcountry = 'selected="selected"'; }
			?>
                    <option <?php echo $selectedcountry; ?> value="<?php echo $country; ?>"><?php echo $country; ?></option>
                    <?php
			  $selectedcountry = '';
				  
			  }
			  ?>
                  </select>                
-->				   </td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Pincode</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="pincode" id="pincode" value="<?php echo $pincode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Mobile Number </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="mobilenumber" id="mobilenumber" value="<?php echo $mobilenumber; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 1 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" style="border: 1px solid #001E6A;" size="20" />                   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 2 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" style="border: 1px solid #001E6A;"  size="20"></td>
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
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="border: 1px solid #001E6A; text-transform: uppercase;"  size="20" /></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Supplier Code   *</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>" readonly="readonly" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Opening Balance  *</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="border: 1px solid #001E6A; text-align:right" size="20"></td>
				 </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Supplier" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">


</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

