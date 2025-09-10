<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$billnumber = $_REQUEST['billnumber'];
//$billnumber = 'SBL00000007';
//echo "Hello Print World.";
$subtotaldiscounttotal = '';
$showdiscountext = '';
$wishesontop = '';
$wishesonbottom = '';


$query1 = "select * from master_wishes";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$showontop = $res1['showontop'];
if ($showontop == 'yes')
{
	$wishesontop = $res1['wishesontop'];
}
$showonbottom = $res1['showonbottom'];
if ($showonbottom == 'yes')
{
	$wishesonbottom = $res1['wishesonbottom'];
}

$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2['companyname'];
$address1 = $res2['address1'];
$area = $res2['area'];
$city = $res2['city'];
$pincode = $res2['pincode'];
$phonenumber1 = $res2['phonenumber1'];
$phonenumber2 = $res2['phonenumber2'];

$query3 = "select * from master_purchase where billnumber = '$billnumber' and recordstatus <> 'deleted' and companyanum = '$companyanum'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount3 = mysqli_num_rows($exec3);
if ($rowcount3 == 0) 
{
	echo "Sorry. Invalid Bill Number #$billnumber. Make Sure The Bill Number Is Correct And Try Again.";
	exit;
}

$res3 = mysqli_fetch_array($exec3);
$billautonumber = $res3['auto_number'];
$billdate = $res3['billdate'];

$dotarray = explode("-", $billdate);
$billyear = $dotarray[0];
$billmonth = $dotarray[1];
$billday = $dotarray[2];
$dotarray2 = explode(" ", $billday);
$billday = $dotarray2[0];
$billtime = $dotarray2[1];
$billdate = $billday.'-'.$billmonth.'-'.$billyear.' '.$billtime;
//echo $billdate;

$paymentmode = $res3['billtype'];
$billnumberprefix = $res3['billnumberprefix'];
$billnumberpostfix = $res3['billnumberpostfix'];
$suppliername = $res3['suppliername'];
$res3packaging = $res3["packaging"];
$res3delivery = $res3['delivery'];
$res3subtotal = $res3['subtotal'];
$res3subtotalafterdiscount = $res3['subtotalafterdiscount'];
$res3subtotalaftertax = $res3['subtotalaftertax'];
$res3totaltax = $res3subtotalaftertax - $res3subtotalafterdiscount;
$res3subtotaldiscounttotal = $res3['subtotaldiscounttotal'];
$res3totalamount = $res3['totalamount'];
$res3username = $res3['username'];
$res3roundoff = $res3['roundoff'];

include ('convert_currency_to_words.php');
$convertedwords = covert_currency_to_words($res3totalamount); //function call

		$subtotaldiscountpercent = $res3["subtotaldiscountpercent"];
		$subtotaldiscountrupees = $res3["subtotaldiscountrupees"];
		
		$subtotaldiscountpercentapply1 = $res3['subtotaldiscountpercentapply1'];
		$subtotaldiscountamountapply1 = $res3['subtotaldiscountamountapply1'];
		$subtotaldiscountamountonlyapply1 = $res3['subtotaldiscountamountonlyapply1'];
		$subtotaldiscountamountonlyapply2 = $res3['subtotaldiscountamountonlyapply2'];
		//$subtotaldiscounttotal = $res3['subtotaldiscounttotal'];
		if ($subtotaldiscountpercentapply1 != "0.00")
		{
			$subtotaldiscounttotal = $res3['subtotaldiscountamountapply1'];
			$subtotaldiscountpercent = $res3['subtotaldiscountpercentapply1'];	
			$discountshowtext = 'Discount @ '.$subtotaldiscountpercent.'%'; 	
		}
		if ($subtotaldiscountamountonlyapply1 != "0.00")
		{
			$subtotaldiscounttotal = $res3['subtotaldiscountamountonlyapply1'];
			$subtotaldiscountpercent = $res3['subtotaldiscountamountonlyapply2'];		
			$discountshowtext = 'Discount Amount'; 
		}
		
		$subtotalafterdiscountamount = $res3["subtotalafterdiscount"];
		$subtotalaftertax = $res3["subtotalaftertax"];


?>
<head>
<title>Bill Printout</title>
</head>
<script language="javascript">
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

</script>
<!--<body onLoad="return funcBodyOnLoadFunction1()" onkeydown="escapekeypressed()">-->
<body onkeydown="escapekeypressed()">
<table width="350" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="5"><div align="center">
  <?php
$strlen1 = strlen($wishesontop);
$totalcharacterlength1 = 35;
$totalblankspace1 = 35 - $strlen1;
$splitblankspace1 = $totalblankspace1 / 2;
for($i=1;$i<=$splitblankspace1;$i++)
{
$wishesontop = ' '.$wishesontop.' ';
}
?>
  <?php echo $wishesontop; ?> </div></td>
</tr>
<tr>
<td colspan="5"><div align="center">
  <?php
$strlen2 = strlen($companyname);
$totalcharacterlength2 = 35;
$totalblankspace2 = 35 - $strlen2;
$splitblankspace2 = $totalblankspace2 / 2;
for($i=1;$i<=$splitblankspace2;$i++)
{
$companyname = ' '.$companyname.' ';
}
?>
</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php echo $companyname; ?>
    <?php
$strlen3 = strlen($address1);
$totalcharacterlength3 = 35;
$totalblankspace3 = 35 - $strlen3;
$splitblankspace3 = $totalblankspace3 / 2;
for($i=1;$i<=$splitblankspace3;$i++)
{
$address1 = ' '.$address1.' ';
}
?>
</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php echo $address1; ?>
    <?php
$address2 = $area.', '.$city.' - '.$pincode.'';
$strlen3 = strlen($address2);
$totalcharacterlength3 = 35;
$totalblankspace3 = 35 - $strlen3;
$splitblankspace3 = $totalblankspace3 / 2;
for($i=1;$i<=$splitblankspace3;$i++)
{
$address2 = ' '.$address2.' ';
}
?>
</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php echo $address2; ?>
    <?php
$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
$strlen3 = strlen($address3);
$totalcharacterlength3 = 35;
$totalblankspace3 = 35 - $strlen3;
$splitblankspace3 = $totalblankspace3 / 2;
for($i=1;$i<=$splitblankspace3;$i++)
{
$address3 = ' '.$address3.' ';
}
?>
</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php echo $address3; ?>
    <?php
if ($suppliername != '')
{
?>
</div></td>
</tr>
<tr>
<td colspan="5">
TO: 
<?php echo $suppliername; ?>
<?php
}
?></td>
</tr>
<tr>
<td colspan="5">
PURCHASE BILL NO: <?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?></td>
</tr>
<tr>
<td colspan="5">
<?php echo 'DATE: '.$billdate; ?></td>
</tr>
<tr>
<td colspan="5">
  <div align="center">-------------------------------------------------------</div></td>
</tr>
<tr>
<td>
ITEM</td>
<td>RATE</td>
<td>QTY</td>
<td>TAX</td>
<td><div align="left">AMOUNT
</div></td>
</tr>
<?php
$serialnumber = "";
$query4 = "select * from purchase_details where bill_autonumber = '$billautonumber' and recordstatus <> 'deleted' and companyanum = '$companyanum'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res4 = mysqli_fetch_array($exec4))
{
$serialnumber = $serialnumber + 1;
$itemcode = $res4['itemcode'];
$itemname = $res4['itemname'];
$itemunitabb = $res4['unit_abbreviation'];
$rate = $res4['rate'];
$qty = $res4['quantity'];
$qty = round($qty, 4);
$itemtaxpercentage = $res4['itemtaxpercentage'];
$itemtaxpercentage = number_format($itemtaxpercentage, 2, '.', '');
$subtotal = $res4['subtotal'];
$res4totalamount = $res4['totalamount'];
$discountpercentage = $res4['discountpercentage'];
$discountrupees = $res4['discountrupees'];
$discountamount = $res4['discountamount'];

$printitem = substr($itemname, 0, 8);

$printrate = $rate;
$strlenprintrate = strlen($printrate);
if ($strlenprintrate == 7) { $printrate = $printrate; }
if ($strlenprintrate == 6) { $printrate = ' '.$printrate; }
if ($strlenprintrate == 5) { $printrate = '  '.$printrate; }
if ($strlenprintrate == 4) { $printrate = '   '.$printrate; }

$printquantity = $qty;
$strlenprintqty = strlen($printquantity);
if ($strlenprintqty == 3) { $printquantity = $printquantity; }
if ($strlenprintqty == 2) { $printquantity = ' '.$printquantity; }
if ($strlenprintqty == 1) { $printquantity = '  '.$printquantity; }

$printtax = $itemtaxpercentage;
$strlenprinttax = strlen($printtax);
if ($strlenprinttax == 5) { $printtax = $printtax; }
if ($strlenprinttax == 4) { $printtax = ' '.$printtax; }

$printtotal = $res4totalamount;
$strlenprinttotal = strlen($printtotal);
if ($strlenprinttotal == 8) { $printtotal = $printtotal; }
if ($strlenprinttotal == 7) { $printtotal = ' '.$printtotal; }
if ($strlenprinttotal == 6) { $printtotal = '  '.$printtotal; }
if ($strlenprinttotal == 5) { $printtotal = '   '.$printtotal; }
if ($strlenprinttotal == 4) { $printtotal = '    '.$printtotal; }

$printgridtext = $printitem.' '.$printrate.' '.$printquantity.' '.$printtax.' '.$printtotal
?>
<tr>
<td><?php echo $printitem; ?></td>
<td><div align="right"><?php echo $printrate; ?></div></td>
<td><div align="right"><?php echo $printquantity; ?></div></td>
<td><div align="right"><?php echo $printtax; ?></div></td>
<td><div align="right"><?php echo $printtotal; ?></div></td>
</tr>
<?php //echo $printgridtext; ?>
<?php
}
?>
<tr>
<td colspan="5">
  <div align="center">-------------------------------------------------------</div></td>
</tr>
<tr>
<td colspan="5">
<?php echo 'Total Items: '.$serialnumber; ?></td>
</tr>
<tr>
<td colspan="4">
<div align="right">
<?php 
$subtotal3 = "Sub Total: ";
$strlen3 = strlen($subtotal3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$subtotal3 = ' '.$subtotal3;
}

$subtotal4 = $res3subtotal;
$strlen4 = strlen($subtotal4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$subtotal4 = ' '.$subtotal4;
}

$subtotal5 = $subtotal3.$subtotal4;
?>
<?php //echo $subtotal5; ?>
<?php echo $subtotal3; ?></div></td>
<td><div align="right"><?php echo $subtotal4; ?></div></td>
</tr>
<?php

if ($subtotaldiscounttotal != '')
{

?>
	<tr>
	<td colspan="4">
	<div align="right">
	<?php 
	$discountpercent3 = $discountshowtext;
	$strlen3 = strlen($discountpercent3);
	$totalcharacterlength3 = 17;
	$totalblankspace3 = 25 - $strlen3;
	//$splitblankspace3 = $totalblankspace3 / 2;
	$splitblankspace3 = $totalblankspace3;
	for($i=1;$i<=$splitblankspace3;$i++)
	{
	$discountpercent3 = ' '.$discountpercent3;
	}
	
	$subtotaldiscounttotal4 = $subtotaldiscounttotal;
	$strlen4 = strlen($subtotaldiscounttotal4);
	$totalcharacterlength4 = 18;
	$totalblankspace4 = 10 - $strlen4;
	//$splitblankspace4 = $totalblankspace4 / 2;
	$splitblankspace4 = $totalblankspace4;
	for($i=1;$i<=$splitblankspace4;$i++)
	{
	$subtotaldiscounttotal4 = ' '.$subtotaldiscounttotal4;
	}
	
	//$subtotaldiscounttotal5 = $discountpercent3.$subtotaldiscounttotal4;
	?>
	<?php //echo $subtotal5; ?>
	<?php echo $discountpercent3; ?></div></td>
	<td><div align="right"><?php echo $subtotaldiscounttotal4; ?></div></td>
	</tr>
	<tr>
	<td colspan="4">
	<div align="right">
	<?php 
	$totalafterdiscount3 = 'Total After Discount:';
	$strlen3 = strlen($totalafterdiscount3);
	$totalcharacterlength3 = 17;
	$totalblankspace3 = 25 - $strlen3;
	//$splitblankspace3 = $totalblankspace3 / 2;
	$splitblankspace3 = $totalblankspace3;
	for($i=1;$i<=$splitblankspace3;$i++)
	{
	$totalafterdiscount3 = ' '.$totalafterdiscount3;
	}
	
	$subtotalafterdiscountamount4 = $subtotalafterdiscountamount;
	$strlen4 = strlen($subtotalafterdiscountamount4);
	$totalcharacterlength4 = 18;
	$totalblankspace4 = 10 - $strlen4;
	//$splitblankspace4 = $totalblankspace4 / 2;
	$splitblankspace4 = $totalblankspace4;
	for($i=1;$i<=$splitblankspace4;$i++)
	{
	$subtotalafterdiscountamount4 = ' '.$subtotalafterdiscountamount4;
	}
	
	//$totalafterdiscount3 = $totalafterdiscount3.$subtotalafterdiscountamount4;
	?>
	<?php //echo $subtotal5; ?>
	<?php echo $totalafterdiscount3; ?></div></td>
	<td><div align="right"><?php echo $subtotalafterdiscountamount4; ?></div></td>
	</tr>
<?php
}
?>
<?php
$query41 = "select *, sum(taxamount) as sumtaxamount from purchase_tax  where bill_autonumber = '$billautonumber' and recordstatus <> 'deleted' and companyanum = '$companyanum' group by tax_autonumber, taxname order by auto_number";
$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res41 = mysqli_fetch_array($exec41))
{
$res41taxname = $res41['taxname'];
//$res41taxamount = $res41['taxamount'];
$res41taxamount = $res41['sumtaxamount'];
$taxname3 = $res41taxname.": ";
$strlen3 = strlen($taxname3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$taxname3 = ' '.$taxname3;
}

$taxamount4 = $res41taxamount;
$strlen4 = strlen($taxamount4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$taxamount4 = ' '.$taxamount4;
}

//$taxprint5 = $taxname3.$taxamount4;
?>
<tr>
<td colspan="4">
  <div align="right"><?php echo $taxname3;; ?>
</div>
</td>
<td>
  <div align="right"><?php echo $taxamount4; ?></div>
  </td>
<?php
}
?>
</tr>
<tr>
<td colspan="4">
<div align="right">
<?php
if ($res3packaging != '0.00')
{
$packaging3 = "Packaging: ";
$strlen3 = strlen($packaging3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$packaging3 = ' '.$packaging3;
}

$packaging4 = $res3packaging;
$strlen4 = strlen($packaging4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$packaging4 = ' '.$packaging4;
}

//$packaging5 = $delivery3.$delivery4;
echo $packaging3;
?>
  </div></td>
<td>
  <div align="right"><?php echo $packaging4; ?></div></td>
</tr>
<?php
}
?>
<tr>
<td colspan="4">
  <div align="right">
<?php
if ($res3delivery != '0.00')
{
$delivery3 = "Delivery: ";
$strlen3 = strlen($delivery3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$delivery3 = ' '.$delivery3;
}

$delivery4 = $res3delivery;
$strlen4 = strlen($delivery4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$delivery4 = ' '.$delivery4;
}

//$roundoff5 = $delivery3.$delivery4;
echo $delivery3;
?>
  </div></td>
<td>
  <div align="right"><?php echo $delivery4; ?></div></td>
</tr>
<?php
}
?>
<tr>
<td colspan="4">
  <div align="right">
<?php
$roundoff3 = "Round Off: ";
$strlen3 = strlen($roundoff3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$roundoff3 = ' '.$roundoff3;
}

$roundoff4 = $res3roundoff;
$strlen4 = strlen($roundoff4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$roundoff4 = ' '.$roundoff4;
}

//$roundoff5 = $roundoff3.$roundoff4;
echo $roundoff3;
?>
  </div></td>
<td>
  <div align="right"><?php echo $roundoff4; ?></div></td>
</tr>
<tr>
<td colspan="4">
  <div align="right">
<?php
$totalamount3 = "Total Amount: ";
$strlen3 = strlen($totalamount3);
$totalcharacterlength3 = 17;
$totalblankspace3 = 25 - $strlen3;
//$splitblankspace3 = $totalblankspace3 / 2;
$splitblankspace3 = $totalblankspace3;
for($i=1;$i<=$splitblankspace3;$i++)
{
$totalamount3 = ' '.$totalamount3;
}

$totalamount4 = $res3totalamount;
$strlen4 = strlen($totalamount4);
$totalcharacterlength4 = 18;
$totalblankspace4 = 10 - $strlen4;
//$splitblankspace4 = $totalblankspace4 / 2;
$splitblankspace4 = $totalblankspace4;
for($i=1;$i<=$splitblankspace4;$i++)
{
$totalamount4 = ' '.$totalamount4;
}
echo $totalamount3;
//$totalamount5 = $totalamount3.$totalamount4;
?>
  </div></td>
<td>
  <div align="right"><?php echo $totalamount4; ?></div></td>
</tr>
<tr>
<td colspan="5">
<?php echo strtoupper($res3username); ?></td>
</tr>
<tr>
<td colspan="5">
<?php echo $wishesonbottom; ?></td>
</tr>
<tr>
<td colspan="5">
<?php echo ''; ?></td>
</tr>
<tr>
<td colspan="5">
<?php 
$query7 = "select * from master_edition where status = 'ACTIVE'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7edition = $res7['edition'];
if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
{
?>
<?php echo "Software By: WWW.SIMPLEINDIA.COM"; ?>
<?php
}
?></td>
</tr>
</table>
<br>
<br>
</body>