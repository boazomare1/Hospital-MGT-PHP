
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

if (isset($_REQUEST["ledger"])) { $ledger = $_REQUEST["ledger"]; } else { $ledger = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Currency</title>
<!-- Modern CSS -->
<link href="css/addcurrency-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/addcurrency-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php

if ($frmflag1 == 'frmflag1')

{

	

	$currency=strtoupper($_REQUEST['currency']);

	

	$rate=$_REQUEST['rate'];

	$ledgercode=$_REQUEST['ledgerid']; 

	$symbol = $_REQUEST["symbol"];

	$ledgername = $_REQUEST["ledger"];



$length=strlen($rate);

	//echo $length;

	if ($length<=100)

	{

		 $query1 = "insert into master_currency (currency,rate,symbol, ledgername, ledgercode, ipaddress, recorddate, username) 

		values ('$currency',  '$rate','$symbol','$ledgername','$ledgercode', '$ipaddress', '$updatedatetime', '$username')"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Sub Type Updated.";

		$bgcolorcode = 'success';

		

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

	$query99 = "update master_currency set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec99= mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query03".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query37 = "update master_currency set recordstatus = '' where auto_number = '$delanum'";

	$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query46 = "update master_subcurrency set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query500 = "update master_subtype set defaultstatus = 'DEFAULT' where auto_number = '$autonumber'";

	$exec500 = mysqli_query($GLOBALS["___mysqli_ston"], $query500) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query600= "update master_currency set defaultstatus = '' where auto_number = '$autonumber'";

	$exec600 = mysqli_query($GLOBALS["___mysqli_ston"], $query600) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Sub Type To Proceed For Billing.";

	$bgcolorcode = 'failed';

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

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>      



</head>

<script language="javascript">



function addward1process1()

{

	//alert ("Inside Funtion");

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

	fRet = confirm('Are you sure want to delete this currency');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Currency Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Currency Delete Not Completed.");

		return false;

	}



}

</script>

<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" ><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/menu1.php"); ?></td>

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

              <td><form name="form1" id="form1" method="post" action="addcurrency.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2"  class="bodytext3"><strong>Currency Master - Add New </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Currency </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="currency" id="currency" style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  autocomplete="off" />

												</td>

                      </tr>

					  

					  

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add RX Rate </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="rate" id="rate" style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  autocomplete="off" /></td>

                      </tr>

                       <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Symbol </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="symbol" id="symbol" style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  autocomplete="off" /></td>

                      </tr>

                       <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Ledger Name </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" >

						

                        <input type="text" name="ledger" id="ledger" autocomplete="off"  size="40" />

					 	<input type="hidden" name="autobuildledger" id="autobuildledger" size="50"> 

					 	<input type="hidden" name="ledgerid" id="ledgerid" size="10" >

                     	<input type="hidden" name="ledgeranum" id="ledgeranum" size="10" > </td>

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

                        <td colspan="6"  class="bodytext3"><strong>Currency Master - Existing List </strong></td>

                      </tr>

                      <tr>

                        <td align="left" valign="top"   class="bodytext3">&nbsp;</td>

                        <td align="left" valign="top"   class="bodytext3"><strong>Currency </strong></td>                   

						<td width="17%" align="left" valign="top"   class="bodytext3"><strong>Rate </strong></td>

                        <td  valign="top"   class="bodytext3"><strong>Symbol </strong></td>                  

						<td width="24%"  valign="top"   class="bodytext3"><strong>Ledger Name </strong></td>

                        <td width="15%" align="left" valign="top"   class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

	    $query101 = "select * from master_currency where recordstatus != 'deleted' order by currency";

		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res101 = mysqli_fetch_array($exec101))

		{

		

		

		$currencyanum=$res101['currency'];

		$rate=$res101['rate'];

		$symbol=$res101['symbol'];

		$ledgername=$res101['ledgername'];

		$currencyanum = $res101["auto_number"];

		//$defaultstatus = $res1["defaultstatus"];

		

		$query201 = "select * from master_currency where auto_number = '$currencyanum'";

		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res201 = mysqli_fetch_array($exec201);

		$currency=$res201['currency'];

		$autonumber= $res201['auto_number'];

	

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = '';

		}

		  

		?>

                      <tr <?php echo $colorcode; ?>>

                        <td width="4%" align="left" valign="top"  class="bodytext3"><div align="center">

					    <a href="addcurrency.php?st=del&&anum=<?php echo $autonumber; ?>" onClick="return funcDeleteSubType('<?php echo $currency;?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $currency; ?> </td>                        

						<td align="left" valign="top"  class="bodytext3"><?php echo $rate; ?> </td>

                         <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $symbol; ?> </td>

                        	<td align="left" valign="top"  class="bodytext3"><?php echo $ledgername; ?> </td>

                        <td align="left" valign="top"  class="bodytext3">

						<a href="editmastercurrency.php?st=edit&&anum=<?php echo $autonumber; ?>" style="text-decoration:none">Edit</a></td>

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

                      <td colspan="8"  class="bodytext3"><strong>Currency Master - Deleted </strong></td>

                    </tr>

                    <tr bgcolor="011E6A">

                      <td height="34" align="left" valign="top"   class="bodytext3">&nbsp;</td>

                      <td colspan="2"  class="bodytext3"><strong>Currency</strong></td>

                      <td  align="left"  class="bodytext3"><strong>Rate </strong></td>

                      <td colspan="2"  class="bodytext3"><strong>Symbol</strong></td>

                      <td  align="left"  class="bodytext3"><strong>Ledger Name </strong></td>

                    </tr>

                   <?php

		

	    $query11 = "select * from master_currency where recordstatus = 'deleted' order by currency";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res11 = mysqli_fetch_array($exec11))

		{

		$rate = $res11['rate'];

		$currency = $res11['currency'];

		$symbol=$res11['symbol'];

		$ledgername=$res11['ledgername'];

		$currencyanum=$res11["auto_number"];

		

	    $query22="select * from master_currency where auto_number='$currencyanum'";

		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res22 = mysqli_fetch_array($exec22);

		$currency = $res22['currency'];

	    $auto_number = $res22['auto_number'];

		

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			//$colorcode = '';

		}?>

		

                    <tr <?php echo $colorcode; ?>>

                      <td width="150" align="left" valign="top"  class="bodytext3"><a href="addcurrency.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                        <div align="center" class="bodytext3">Activate</div>

                      </a></td>

                      <td colspan="2" align="left" valign="top"  class="bodytext3"><?php echo $currency; ?></td>

                      <td colspan="1" width="121" align="left" valign="top"  class="bodytext3"><?php echo $rate; ?></td>

                      <td colspan="2" align="left" valign="top"  class="bodytext3"><?php echo $symbol; ?></td>

                      <td colspan="1" width="140" align="left" valign="top"  class="bodytext3"><?php echo $ledgername; ?></td>

                    </tr>

           <?php

		   }

		   ?>         

		

		

                    <tr>

                      <td align="middle" colspan="3" >&nbsp;</td>

                    </tr>

                  </tbody>

                </table>

              </form>                </td>

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

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>



