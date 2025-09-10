<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];

$query3 = "select * from master_transactionpaynow where billnumber = '$billautonumber'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3patientname = $res3['patientname'];
$res3patientcode = $res3['patientcode'];
$res3visitcode = $res3['visitcode'];
$res3billnumber = $res3['billnumber'];
$res3transactionamount = $res3['transactionamount'];
$res3transactiondate = $res3['transactiondate'];
$res3transactionmode = $res3['transactionmode'];
$res3cashgiventocustomer = $res3['cashgiventocustomer'];
$res3cashgivenbycustomer = $res3['cashgivenbycustomer'];
$res3username = $res3['username'];
$res3username = strtoupper($res3username);
$res3transactiondate = $res3['transactiondate'];
$res3transactiontime = $res3['transactiontime'];
$res3transactiontime1 = explode(":",$res3transactiontime);
include ('convert_currency_to_words.php');
$convertedwords = covert_currency_to_words($res3transactionamount); 

$query45 = "select * from master_transactionpaynow where billnumber = '$billautonumber' and transactionmode = 'CHEQUE'";
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
$res45 = mysqli_fetch_array($exec45);
$res45chequenumber = $res45['chequenumber'];
$res45chequedate = $res45['chequedate'];
$res45bankname = $res45['bankname'];

if($res3transactionmode == 'CHEQUE')
{
$res3transactionmode = 'Cheque'.' '.'('.$res45chequenumber.' '.$res45bankname.' '.$res45chequedate.')';
}

$query46 = "select * from master_transactionpaynow where billnumber = '$billautonumber' and transactionmode = 'CREDIT CARD'";
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query46".mysqli_error($GLOBALS["___mysqli_ston"]));
$res46 = mysqli_fetch_array($exec46);
$res46creditcardname = $res46['creditcardname'];
$res46creditcardnumber = $res46['creditcardnumber'];
$res46creditcardbankname = $res46['creditcardbankname'];

if($res3transactionmode == 'CREDIT CARD')
{
$res3transactionmode = 'CREDIT CARD'.' '.'('.$res46creditcardname.' '.$res46creditcardnumber.' '.$res46creditcardbankname.')';
}

if ($res3transactionmode  == 'CASH')
{
$res3transactionmode = 'CASH';
}

?>
<head>
<title>Bill Printout</title>
</head>
<!--<script language="javascript">
function funcBodyOnLoadFunction1()
{
	window.blur()  //To minimize the popup window.
	funcPrint();
	funcWindowAutoClose1()
}

function funcWindowAutoClose1()
{
	//Close after printing is complete.
	setTimeout("self.close();",10000)  //After Ten Seconds.
	//window.close();
}

function escapekeypressed()
{

	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>-->
<!--<body onLoad="return funcBodyOnLoadFunction1()" onkeydown="escapekeypressed()">-->
<body onkeydown="escapekeypressed()">
<table width="350" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2"></td>
</tr>

<tr>
<td width="192">Bill No: <?php  ?></td>
<td width="149" colspan="-2">Bill Date: <?php  ?></td>
</tr>

<tr>
<td>Reg No : <?php  ?> Vis No: <?php  ?></td>
<td colspan="-2">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="-2">&nbsp;</td>
</tr>


	
	<tr>
		<td colspan="2">Payment Mode: <?php  ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><?php   ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td><div align="right"></div></td>
     	<td colspan="-2">Served By: <?php  ?> </td>
	</tr>
	<!--<tr>
		<td><div align="right"></div></td>
	<td colspan="-2">
	<div align="center"><?php echo $res3transactiondate; ?> <?php echo $res3transactiontime1[0]; ?> : <?php echo $res3transactiontime1[1]; ?> </div></td>
	</tr>-->
	<tr>
	<td colspan="2"></td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	</table>
	<br>
	<br>
	</body>