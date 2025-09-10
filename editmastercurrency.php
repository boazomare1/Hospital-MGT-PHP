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
 $anum = $_REQUEST["anum"];
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{  
   // $subtypeanum = $_REQUEST['subtypeanum'];
	//echo $subtypeanum;
	$currency = strtoupper($_REQUEST["currency"]);
	$rate = $_REQUEST["rate"];
	$anum = $_REQUEST["anum"];
	$symbol = $_REQUEST["symbol"];
	$ledgername = $_REQUEST["ledger"];
	$ledgercode=$_REQUEST['ledgerid'];
	//$subtype = trim($subtype);
//	echo $length=strlen($rate);
	//echo $length;
	$query44 = "select * from master_currency where auto_number = '$currency '";
	$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res44= mysqli_fetch_array($exec44);
	$res44dcurrencyanum = $res44['auto_number'];
	$res44currency = $res44['currency'];
	
	$query55 = "select * from master_currency where auto_number = '$rate'"; 
	$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res55= mysqli_fetch_array($exec55);
	$res55anum = $res55["auto_number"];
	$res55rate = $res55["rate"];
	
	 $query26 = "select * from master_currency where auto_number = '$anum'";
	$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res26 = mysqli_num_rows($exec26);
	if ($res26 != 0)
	{
	    $query31 = "update master_currency set currency = '$currency', rate = '$rate', ledgername = '$ledgername', symbol = '$symbol', ledgercode = '$ledgercode'  where auto_number = '$anum'"; 
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Sub Type Updated.";
		$bgcolorcode = 'success';
		header ("location:addcurrency.php?bgcolorcode=success&&st=edit&&anum=$subtypeanum");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Sub Type Already Exists.";
		//$bgcolorcode = 'failed';
	//header ("location:editsubtype1.php?bgcolorcode=failed&&st=edit&&anum=$subtypeanum");
	
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query33 = "update master_currency set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query34 = "update master_currency set recordstatus = '' where auto_number = '$delanum'";
	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query40= "update master_currency set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec40= mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query59 = "update master_currency set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query60 = "update master_currency set defaultstatus = '' where auto_number = '$delanum'";
	$exec60 = mysqli_query($GLOBALS["___mysqli_ston"], $query60) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$query100 = "select * from master_currency where auto_number = '$anum'";
	$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res101 = mysqli_fetch_array($exec100);
	$res101autonumber = $res101['auto_number'];
  	  $res101currency = $res101['currency'];
    $res101rate = $res101['rate'];
	 $symbol = $res101['symbol'];
    $ledgername = $res101['ledgername'];
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

<script type="text/javascript">
window.onload = function(){

var oTextbox = new AutoSuggestControlledger(document.getElementById("ledger"), new StateSuggestions()); 
	//alert(oTextbox1); 
}
</script>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script type="text/javascript" src="js/autocomplete_ledger.js"></script>
<script type="text/javascript" src="js/autosuggestledger2.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />     
</head>
<script language="javascript">

function addward1process1()
{
	if (document.form1.currency.value == "")
	{
		alert ("Pleae Enter Currency Name.");
		document.form1.currency.focus();
		return false;
	}
	if (document.form1.rate.value == "")
	{
		alert ("Pleae Enter Rate.");
		document.form1.rate.focus();
		return false;
	}
	if (document.form1.symbol.value == "")
	{
		alert ("Pleae Enter Symbol Name.");
		document.form1.symbol.focus();
		return false;
	}
	if (document.form1.ledgerid.value == "")
	{
		alert ("Pleae Enter Ledger Name.");
		document.form1.ledger.focus();
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
              <td><form name="form1" id="form1" method="post" action="editmastercurrency.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Currency Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New  Currency </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="currency" id="currency"  style="border: 1px solid #001E6A; text-transform:uppercase" autocomplete="off" size="15" value="<?php echo $res101currency; ?>" />
				</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rate" id="rate"  autocomplete="off" value="<?php echo $res101rate;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Symbol </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="symbol" id="symbol"  autocomplete="off" value="<?php echo $symbol;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Ledger name </div></td>
                       
						 <td align="left" valign="top"  bgcolor="#FFFFFF">
						
                        <input type="text" name="ledger" id="ledger" autocomplete="off" value="<?php echo $ledgername;?>"  size="40" />
					 	<input type="hidden" name="autobuildledger" id="autobuildledger" size="50"> 
					 	<input type="hidden" name="ledgerid" id="ledgerid" size="10" >
                     	<input type="hidden" name="ledgeranum" id="ledgeranum" size="10" > </td>
                      </tr>
                      
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="rateanum" id="rateanum" value="<?php echo $res101autonumber; ?>">
						<input type="hidden" name="anum" id="anum" value="<?php echo $anum; ?>">
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

