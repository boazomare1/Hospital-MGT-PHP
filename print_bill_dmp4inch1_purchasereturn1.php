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

$query3 = "select * from master_purchasereturn where billnumber = '$billnumber' and recordstatus <> 'deleted' and companyanum = '$companyanum'";
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
	window.opener.document.getElementById("supplier").focus();
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
<body onLoad="return funcBodyOnLoadFunction1()" onkeydown="escapekeypressed()">
This window is to print bill.<br>
Press ESC Key to close this window.<br>
Auto close in 10 seconds.
</body>
<script type="text/javascript">
      var sleepCounter = 0;   
   
      function findPrinter() {
         var applet = document.jZebra;
         if (applet != null) {
            // Searches for locally installed printer with "zebra" in the name
            applet.findPrinter("zebra");
         }
         
         monitorFinding();
      }

      function funcPrint() {
         var applet = document.jZebra;
         if (applet != null) {
            // Send characters/raw commands to applet using "append"
            // Hint:  Carriage Return = \r, New Line = \n, Escape Double Quotes= \"
            
			//applet.append("A590,1600,2,3,1,1,N,\"jZebra " + applet.getVersion() + " sample.html\"\n");
            //applet.append("A590,1570,2,3,1,1,N,\"Testing the print() function\"\n");
            //applet.append("P1\n");
            //applet.append("This is the first print from PHP direct to printer. \"jZebra " + applet.getVersion() + " sample.html\"\n");
            //applet.append("First PHP Direct To Printer Success On 23-July-2011\"\n");
            //applet.append("Print Success - 23-July-2011 By Prem Kumar.\n");
            //applet.append("This is the stop line. Simple Solutions.\n");
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
			applet.append("<?php echo $wishesontop; ?>\n");
            applet.append("\n");
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
            applet.append("<?php echo $companyname; ?>\n");
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
            applet.append("<?php echo $address1; ?>\n");
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
            applet.append("<?php echo $address2; ?>\n");
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
            applet.append("<?php echo $address3; ?>\n");
            //applet.append("\n");
			<?php
			if ($suppliername != '')
			{
			?>
            applet.append("TO: <?php echo $suppliername; ?>\n");
			<?php
			}
			?>
            applet.append("PURCHASE RETURN BILL NO: <?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?>\n");
            applet.append("<?php echo 'DATE: '.$billdate; ?>\n");
            applet.append("-------------------------------------\n");
            applet.append("ITEM        RATE QTY   TAX   AMOUNT\n");
			<?php
			$serialnumber = "";
			$query4 = "select * from purchasereturn_details where bill_autonumber = '$billautonumber' and recordstatus <> 'deleted' and companyanum = '$companyanum'";
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
            applet.append("<?php echo $printgridtext; ?>\n");
            <?php
			}
			?>
			applet.append("-------------------------------------\n");
            //applet.append("<?php //echo $convertedwords; ?>\n");
            applet.append("<?php echo 'Total Items: '.$serialnumber; ?>\n");
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
            applet.append("<?php echo $subtotal5; ?>\n");
			<?php
			/*
			if ($res3subtotaldiscounttotal != '0.00')
			{
				$footerline2split1 = '                 Discount:  ';
				$footerline2split2 = $res3subtotaldiscounttotal;
				$footerline2split1length1 = strlen($footerline2split1);
				$footerline2split2length2 = strlen($footerline2split2);
				$footerline2textlength1 = $footerline2split1length1 + $footerline2split2length2;
				$footerline2space1diff1 = 35 - $footerline2textlength1;
				if ($footerline2space1diff1 > 0)
				{
					for ($i=1;$i<=$footerline2space1diff1;$i++)
					{
						$footerline2space1 = $footerline2space1.' ';
					}
				}
				$footerline2split3 = $footerline2split1.$footerline2space1.$footerline2split2;
			*/

			if ($subtotaldiscounttotal != '')
			{
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
				
				$subtotaldiscounttotal5 = $discountpercent3.$subtotaldiscounttotal4;
			?>
			applet.append("<?php echo $subtotaldiscounttotal5; ?>\n");
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
				
				$totalafterdiscount5 = $totalafterdiscount3.$subtotalafterdiscountamount4;
			
			?>
            applet.append("<?php echo $totalafterdiscount5; ?>\n");
            <?php
			}
			?>
			<?php
			$query41 = "select *, sum(taxamount) as sumtaxamount from purchasereturn_tax  where bill_autonumber = '$billautonumber' and recordstatus <> 'deleted' and companyanum = '$companyanum' group by tax_autonumber"; 
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
				
			$taxprint5 = $taxname3.$taxamount4;
			?>
            applet.append("<?php echo $taxprint5; ?>\n");
			<?php
			}
			?>
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
				
			$packaging5 = $packaging3.$packaging4;

			?>
            applet.append("<?php echo $packaging5; ?>\n");
			<?php
			}
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
				
			$delivery5 = $delivery3.$delivery4;

			?>
            applet.append("<?php echo $delivery5; ?>\n");
			<?php
			}
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
				
			$roundoff5 = $roundoff3.$roundoff4;

			?>
            applet.append("<?php echo $roundoff5; ?>\n");
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
				
			$totalamount5 = $totalamount3.$totalamount4;
			?>
            applet.append("<?php echo $totalamount5; ?>\n");
            applet.append("<?php echo strtoupper($res3username); ?>\n");
            applet.append("<?php echo $wishesonbottom; ?>\n");
            applet.append("\n");
			<?php 
			$query7 = "select * from master_edition where status = 'ACTIVE'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7edition = $res7['edition'];
			if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
			{
			?>
            applet.append("<?php echo "Software By: WWW.SIMPLEINDIA.COM"; ?>\n");
			<?php
			}
			?>
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");
            applet.append("\n");

            // Send characters/raw commands to printer
            applet.print();
	 }
	 
	 monitorPrinting();
         
         /**
           *  PHP PRINTING:
           *  // Uses the php `"echo"` function in conjunction with jZebra `"append"` function
           *  // This assumes you have already assigned a value to `"$commands"` with php
           *  document.jZebra.append(<?phpphp echo $commands; ?>);
           */
           
         /**
           *  SPECIAL ASCII ENCODING
           *  //applet.setEncoding("UTF-8");
           *  applet.setEncoding("Cp1252"); 
           *  applet.append("\xDA");
           *  applet.append(String.fromCharCode(218));
           *  applet.append(chr(218));
           */
         
      }

      function print64() {
         var applet = document.jZebra;
         if (applet != null) {
            // Use jZebra's `"append64"` function. This will automatically convert provided
            // base64 encoded text into ascii/bytes, etc.
            applet.append64("QTU5MCwxNjAwLDIsMywxLDEsTiwialplYnJhIHNhbXBsZS5odG1sIgpBNTkwLDE1NzAsMiwzLDEsMSxOLCJUZXN0aW5nIHRoZSBwcmludDY0KCkgZnVuY3Rpb24iClAxCg==");
            
            // Send characters/raw commands to printer
            applet.print();
         }
         monitorPrinting();
      }
      
      function printPages() {
         var applet = document.jZebra;
         if (applet != null) {
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 1\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 2\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 3\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 4\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 5\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 6\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 7\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
            
            applet.append("A590,1600,2,3,1,1,N,\"jZebra 8\"\n");
            applet.append("A590,1570,2,3,1,1,N,\"Testing the printPages() function\"\n");
            applet.append("P1\n");
 
            // Mark the end of a label, in this case  P1 plus a newline character
            // jZebra knows to look for this and treat this as the end of a "page"
            // for better control of larger spooled jobs (i.e. 50+ labels)
            applet.setEndOfDocument("P1\n");
            
            // The amount of labels to spool to the printer at a time. When
            // jZebra counts this many `EndOfDocument`'s, a new print job will 
            // automatically be spooled to the printer and counting will start
            // over.
            applet.setDocumentsPerSpool("3");
            
            // Send characters/raw commands to printer
            applet.print();

         }
         monitorPrinting();
      }

      function printXML() {
         var applet = document.jZebra;
         if (applet != null) {
            // Appends the contents of an XML file from a SOAP response, etc.
            // a valid relative URL or a valid complete URL is required for the XML
            // file.  The second parameter must be a valid XML tag/node containing
            // base64 encoded data, i.e. <node_1>aGVsbG8gd29ybGQ=</node_1>
            // Example:
            //     applet.appendXML("http://yoursite.com/zpl.xml", "node_1");
            //     applet.appendXML("http://justtesting.biz/jZebra/dist/epl.xml", "v7:Image");
            applet.appendXML(window.location.href + "/../zpl.xml", "v7:Image");
            
            // Send characters/raw commands to printer
            //applet.print(); // Can't do this yet because of timing issues with XML
         }
         
         // Monitor the append status of the xml file, prints when appending if finished
         monitorAppending();
      }
      
      function printHex() {
      	 var applet = document.jZebra;
         if (applet != null) {
            // Using jZebra's "append()" function, hexadecimanl data can be sent
            // by using JavaScript's "\x00" notation. i.e. "41 35 39 30 2c ...", etc
            // Example: 
            //     applet.append("\x41\x35\x39\x30\x2c"); // ...etc
            applet.append("\x41\x35\x39\x30\x2c\x31\x36\x30\x30\x2c\x32\x2c\x33\x2c\x31\x2c\x31\x2c\x4e\x2c\x22\x6a\x5a\x65\x62\x72\x61\x20\x73\x61\x6d\x70\x6c\x65\x2e\x68\x74\x6d\x6c\x22\x0A\x41\x35\x39\x30\x2c\x31\x35\x37\x30\x2c\x32\x2c\x33\x2c\x31\x2c\x31\x2c\x4e\x2c\x22\x54\x65\x73\x74\x69\x6e\x67\x20\x74\x68\x65\x20\x70\x72\x69\x6e\x74\x48\x65\x78\x28\x29\x20\x66\x75\x6e\x63\x74\x69\x6f\x6e\x22\x0A\x50\x31\x0A");
            
            // Send characters/raw commands to printer
            applet.print();

            
         }
         
         monitorPrinting();
         
         /**
           *  CHR/ASCII PRINTING:
           *  // Appends CHR(27) + CHR(29) using `"fromCharCode"` function
           *  // CHR(27) is commonly called the "ESCAPE" character
           *  document.jZebra.append(String.fromCharCode(27) + String.fromCharCode(29));
           */
      }
      
      function chr(i) {
         return String.fromCharCode(i);
      }
      
      function monitorPrinting() {
	var applet = document.jZebra;
	if (applet != null) {
	   if (!applet.isDonePrinting()) {
	      window.setTimeout('monitorPrinting()', 100);
	   } else {
	      var e = applet.getException();
		  //Commented By Prem Kumar.
	      //alert(e == null ? "Printed Successfully" : "Exception occured: " + e.getLocalizedMessage());
	   }
	} else {
            alert("Applet not loaded!");
        }
      }
      
      function monitorFinding() {
	var applet = document.jZebra;
	if (applet != null) {
	   if (!applet.isDoneFinding()) {
	      window.setTimeout('monitorFinding()', 100);
	   } else {
	      var printer = applet.getPrinterName();
              alert(printer == null ? "Printer not found" : "Printer \"" + printer + "\" found");
	   }
	} else {
            alert("Applet not loaded!");
        }
      }
      
      function monitorAppending() {
	var applet = document.jZebra;
	if (applet != null) {
	   if (!applet.isDoneAppending()) {
	      window.setTimeout('monitorAppending()', 100);
	   } else {
	      applet.print(); // Don't print until all of the data has been appended
              monitorPrinting();
	   }
	} else {
            alert("Applet not loaded!");
        }
      }

   </script>
   <applet name="jZebra" code="jzebra.RawPrintApplet.class" archive="./jzebra.jar" width="1" height="1">
      <param name="printer" value="zebra">
      <!-- <param name="sleep" value="200"> -->
   </applet>
   <!--<input type=button onClick="findPrinter()" value="Detect Printer"><br><br>-->
   
   <!--<input type=button onClick="funcPrint()" value="Print" style="border: 1px solid #001E6A"><br>-->
   
   <!--<input type=button onClick="print64()" value="Print Base64"><br>-->
   <!--<input type=button onClick="printPages()" value="Print Spooling Every 3"><br>-->
   <!--<input type=button onClick="printXML()" value="Print XML"><br>-->
   <!--<input type=button onClick="printHex()" value="Print Hex"><br>-->