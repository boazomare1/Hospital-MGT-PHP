<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = "";

if (isset($_REQUEST["bankcode"])) { $bankcode = $_REQUEST["bankcode"]; } else { $bankcode = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$bankcode = $_REQUEST["bankcode"];
	$bankcode = $bankcode;
	$companyname = $_REQUEST["companyname"];
	$bankname = $_REQUEST["bankname"];
	$bankname = strtoupper($bankname);
	$bankname = trim($bankname);
	$contactpersonname = $_REQUEST["contactpersonname"];
	$contactpersonname = strtoupper($contactpersonname);
	$contactpersonphone = $_REQUEST["contactpersonphone"];
	$branchname  = $_REQUEST["branchname"];
	$branchname = strtoupper($branchname);
	$branchname = trim($branchname);
	$netbankinglogin = $_REQUEST["netbankinglogin"];
	$netbankinglogin = strtoupper($netbankinglogin);
	$accountnumber = $_REQUEST["accountnumber"];
	$accounttype  = $_REQUEST["accounttype"];
	$currentbalance = $_REQUEST["currentbalance"];
	$commissionpercentage = $_REQUEST["commissionpercentage"];
	$phonenumber = $_REQUEST["phonenumber"];
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$address  = $_REQUEST["address"];
	$remarks = $_REQUEST["remarks"];
	$remarks = strtoupper($remarks);
	$branchcode = $_REQUEST["branchcode"];
	$branchcode = strtoupper($branchcode);
	$swiftcode = $_REQUEST["swiftcode"];
	$swiftcode = strtoupper($swiftcode);
	$dateposted = $_REQUEST["dateposted"];
	$bankstatus = $_REQUEST["bankstatus"];
	$lastupdate = $updatedatetime;
	$lastupdateusername = $username;
	$lastupdateipaddress = $ipaddress;
	if($accountnumber=='')
		$accountnumber =$bankcode;
	
	$query2 = "select * from master_bank where bankcode = '$bankcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount2 = mysqli_num_rows($exec2);
	if ($rowcount2 != 0)
	{
		$query1 = "update master_bank set companyname = '$companyname', bankname = '$bankname', 
		contactpersonname = '$contactpersonname', contactpersonphone = '$contactpersonphone', branchname = '$branchname', 
		netbankinglogin = '$netbankinglogin', accountnumber = '$accountnumber', accounttype = '$accounttype', 
		currentbalance = '$currentbalance', commissionpercentage = '$commissionpercentage', phonenumber = '$phonenumber', 
		mobilenumber = '$mobilenumber', address = '$address', remarks = '$remarks', bankstatus = '$bankstatus', 
		branchcode = '$branchcode', swiftcode = '$swiftcode', lastupdate = '$lastupdate', 
		lastupdateusername = '$lastupdateusername', lastupdateipaddress = '$lastupdateipaddress' where bankcode = '$bankcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header ("location:addbank1.php?bankcode=$bankcode");
	}
	else
	{
		header ("location:addbank1.php?bankcode=$bankcode");
	}	

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. Bank Update Completed.";
}
if ($st == 'failed')
{
	$errmsg = "Failed. Bank Account Number Does Not Exist.";
}


if ($bankcode != '')
{
	$query3 = "select * from master_bank where bankcode = '$bankcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	
	$bankcode = $res3["bankcode"];
	$bankcode = $bankcode;
	$companyname = $res3["companyname"];
	$bankname = $res3["bankname"];
	$bankname = strtoupper($bankname);
	$bankname = trim($bankname);
	$contactpersonname = $res3["contactpersonname"];
	$contactpersonphone = $res3["contactpersonphone"];
	$branchname  = $res3["branchname"];
	$branchname = strtoupper($branchname);
	$branchname = trim($branchname);
	$netbankinglogin = $res3["netbankinglogin"];
	$netbankinglogin = strtoupper($netbankinglogin);
	$accountnumber = $res3["accountnumber"];
	$accounttype  = $res3["accounttype"];
	$currentbalance = $res3["currentbalance"];
	$commissionpercentage = $res3["commissionpercentage"];
	$phonenumber = $res3["phonenumber"];
	$mobilenumber  = $res3["mobilenumber"];
	$address  = $res3["address"];
	$remarks = $res3["remarks"];
	$branchcode = $res3["branchcode"];
	$branchcode = strtoupper($branchcode);
	$swiftcode = $res3["swiftcode"];
	$swiftcode = strtoupper($swiftcode);
	$bankstatus = $res3["bankstatus"];
	$lastupdate = $updatedatetime;
	$lastupdateusername = $username;
	$lastupdateipaddress = $ipaddress;

}
else
{
	header ("location:addbank1.php");
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
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

	if (document.form1.bankname.value == "")
	{
		alert ("Bank Name Cannot Be Empty.");
		document.form1.bankname.focus();
		return false;
	}
	/*if (document.form1.branchname.value == "")
	{
		alert ("Branch Branch Cannot Be Empty.");
		document.form1.branchname.focus();
		return false;
	}
	if (document.form1.accountnumber.value == "")
	{
		alert ("Account Number Cannot Be Empty.");
		document.form1.accountnumber.focus();
		return false;
	}
	if (document.form1.accounttype.value == "")
	{
		alert ("Account Type Cannot Be Empty.");
		document.form1.accounttype.focus();
		return false;
	}
	if (document.form1.currentbalance.value == "")
	{
		alert ("Current Balance Cannot Be Empty.");
		document.form1.currentbalance.focus();
		return false;
	}
	if (isNaN(document.getElementById("currentbalance").value))
	{
		alert ("Payment Amount Can Only Be Numbers.")
		document.getElementById("currentbalance").focus();
		return false;
	}
	if (isNaN(document.getElementById("commissionpercentage").value))
	{
		alert ("Commission Percentage Can Only Be Numbers.")
		document.getElementById("commissionpercentage").focus();
		return false;
	}*/
}
function banksearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_bankandcashaccount.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
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
		include ("includes/menu1.php"); 
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="editbank1.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Bank - New </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                </tr>
				<tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bank Code   *</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="bankcode" id="bankcode" value="<?php echo $bankcode; ?>" readonly="readonly" style="border: 1px solid #001E6A" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Company Name * </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="companyname" id="companyname" value="<?php echo $companyname; ?>" readonly="readonly" style="border: 1px solid #001E6A"  size="40"></td>
				</tr>
              <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bank Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="bankname" id="bankname" value="<?php echo $bankname; ?>" style="border: 1px solid #001E6A;" size="60">
				<input type="hidden" onClick="javascript:banksearch('4')" value="Select Bank" accesskey="m" style="border: 1px solid #001E6A"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Contact Person Name </td>
                <td width="35%" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="contactpersonname" id="contactpersonname" value="<?php echo $contactpersonname; ?>" style="border: 1px solid #001E6A;" size="20" />                </td>
                <td width="22%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Contact Phone Number </td>
                <td width="27%" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="contactpersonphone" id="contactpersonphone" value="<?php echo $contactpersonphone; ?>" style="border: 1px solid #001E6A" size="20" /></td>
              </tr>
			  <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Branch *</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="branchname" id="branchname" value="<?php echo $branchname; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Net Banking Login ID </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="netbankinglogin" id="netbankinglogin" value="<?php echo $netbankinglogin; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Account Number * </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="accountnumber" id="accountnumber" value="<?php echo $accountnumber; ?>" style="border: 1px solid #001E6A;" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Account Type * </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext31">
				<input name="accounttype" id="accounttype" value="<?php echo $accounttype; ?>" style="border: 1px solid #001E6A;" size="20">
                </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" style="border: 1px solid #001E6A"  size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Mobile Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="mobilenumber" id="mobilenumber" value="<?php echo $mobilenumber; ?>" style="border: 1px solid #001E6A"  size="20"></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="address" id="address" value="<?php echo $address; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Remarks</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="remarks" id="remarks" value="<?php echo $remarks; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Branch Code </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="branchcode" id="branchcode" value="<?php echo $branchcode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Swift Code </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="swiftcode" id="swiftcode" value="<?php echo $swiftcode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Date Posted</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="dateposted" id="dateposted" value="<?php echo $updatedatetime; ?>" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A"  size="20"  readonly="readonly" />                </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Bank  Status</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="bankstatus" id="bankstatus" style="width: 130px;">
                    <?php
		 	if ($bankstatus != '') 
		  	{
			  echo '<option value="'.$status.'" selected="selected">'.$bankstatus.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Active</option>';
			}
			?>
                    <option value="">Active</option>
                    <option value="Deleted">Deleted</option>
                </select></td>
                <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>-->
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
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
                bgcolor="#ecf0f5" class="bodytext31"><div align="right">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                    <input name="Submit222" type="submit"  value="Save Bank" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
                </tr>
            </tbody>
          </table></td>
        </tr>
    </table>
	</form>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

