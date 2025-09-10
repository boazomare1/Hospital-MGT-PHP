<script language="javascript">

//This file cannot be save as .js, reason, php coding is involved in tax calculation. It needs to be as .php file than .js 

function customersearch1(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_customersearch1.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function itemsearch1(varCallFrom)
{
	window.open("popup_itemsearch1.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


function itemcodekeypress1(e)
{
	//alert ("Inside itemcodekeypress1");
	var data = document.getElementById("itemcode").value;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		//alert ("inside for loop");
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Item Code Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}

	//alert ("Key Press");
	/*
	if (event.keyCode == 13)
	{
		//function from autoitemsearch2.js
		alert ("Inside Event Function.");
		itemsearch2();
		return false;
	}
	*/
	
	evt = e || window.event; 
	key = evt.keyCode;
	//alert (key);
	if(key == 13) // if enter key press
	{
		//function from autoitemsearch2.js
		//alert ("Inside Event Function.");
		itemsearch2();
		return false;
	}

}

function itemquantitykeypress1(e)
{
	/*
	//alert ("Key Press");
	if (event.keyCode=='13')
	{
		itemtotalamountupdate1();
		//same function call of add button click from salesinsertitem1.js
		insertitem1();
		return false;
	}
	*/
	
	evt = e || window.event; 
	key = evt.keyCode;
	//alert (key);
	if(key == 13) // if enter key press
	{
		itemtotalamountupdate1();
		//same function call of add button click from salesinsertitem1.js
		insertitem1();
		return false;
	}
}

function funcAllItemDiscountApply1()
{
if(document.getElementById("totaldiscountamountonlyapply1").value == 0.00)
{
	var varDiscountPercent = document.getElementById("allitemdiscountpercent").value;
	//alert(varDiscountPercent);
	var varDiscountPercent = parseFloat(varDiscountPercent);
	//alert(varDiscountPercent);
	if (isNaN(varDiscountPercent))
	{
		alert ("All Item Discount Percent Can Only Be Numbers.");
		document.getElementById("allitemdiscountpercent").value = "0.00";
		document.getElementById("allitemdiscountpercent").focus();
		return false;
	}
	if (varDiscountPercent > 100)
	{
		alert ("All Item Discount Percent Cannot Be Greater Than 100.")
		return false;
	}
	
	
		//alert (z);
		
			//alert (z);
			//alert (varDiscountPercent);
			//document.getElementById('discountpercent'+z).value = varDiscountPercent.toFixed(2);

			//var varItemTotalAmount = document.getElementById('totalamount'+z).value;
		
			var varItemTotalAmount 	= document.getElementById('subtotal').value;
			var varItemTotalAmount1 	= document.getElementById('subtotal').value;
//alert(varItemTotalAmount);
			var varDiscountPercentAmount = varDiscountPercent * varItemTotalAmount;
			//alert(varDiscountPercentAmount);
			var varDiscountPercentAmount = parseFloat(varDiscountPercentAmount) / 100;
			var varItemTotalAmount = parseFloat(varItemTotalAmount) - parseFloat(varDiscountPercentAmount);
			document.getElementById('allitemdiscountpercent1').value = parseFloat(varDiscountPercentAmount).toFixed(2);
			document.getElementById('totalaftercombinediscount').value = varItemTotalAmount.toFixed(2);
		    document.getElementById('totalamount').value = varItemTotalAmount.toFixed(2);
	
            document.getElementById('tdShowTotal').innerHTML = varItemTotalAmount.toFixed(2);
			
	funcSubTotalCalc();
	
	}
	else
	{
	alert("Either discount percent or discount amount can be done");
	document.getElementById("allitemdiscountpercent").value=0;
	}
}
function funcDiscountAmountCalc1()
{
	if(document.getElementById("allitemdiscountpercent").value == 0.00)
	{
		var varTotalAmountBeforeDiscount = document.getElementById("subtotal").value;
		var varDiscountAmount = document.getElementById("totaldiscountamountonlyapply1").value;
		var varTotalAmountBeforeDiscount = parseFloat(varTotalAmountBeforeDiscount);
		var varDiscountAmount = parseFloat(varDiscountAmount);
		var varTotalAmount = varTotalAmountBeforeDiscount - varDiscountAmount;
		document.getElementById("totalaftercombinediscount").value = varTotalAmount.toFixed(2);
		document.getElementById("totalamount").value = varTotalAmount.toFixed(2);
		document.getElementById("tdShowTotal").innerHTML = varTotalAmount.toFixed(2);
		document.getElementById("totaldiscountamountonlyapply2").value = varTotalAmount.toFixed(2);
		}
		else
		{
		alert("Either discount percent or discount amount can be done");
		 document.getElementById("totaldiscountamountonlyapply1").value=0;
		}
		
}

function funcSubTotalCalc()
{
	funcCumulativeDiscountReset1();
//alert(varItemTotalAmount1);
	
	//var varSerialNumberUpdate = varSerialNumberUpdate + 1;
	//document.getElementById('itemserialnumber').value = varSerialNumberUpdate;
	
	
	var varSubTotalAmount = document.getElementById("subtotal").value;
	
	var varTotalAfterDiscount = document.getElementById("subtotal").value;
	
	var varTotalAfterDiscount = parseFloat(varTotalAfterDiscount);
	//alert (varTotalAfterDiscount);
	
	
	
	
	//Calculation of TAX.
	
	//To Reset Cumulative Discount Options
	document.getElementById("subtotaldiscountrupees").value = "0.00"
	document.getElementById("subtotaldiscountpercent").value = "0.00"
	


	if (document.getElementById("totaldiscountamount").value != "0.00")
	{
		//alert ("1");
		
		var varTotalDiscountAmount = document.getElementById("totaldiscountamount").value;
		var varAfterDiscountAmount = parseFloat(varSubTotalAmount) - parseFloat(varTotalDiscountAmount);
		//alert (varTotalAfterDiscount);
		document.getElementById("subtotalaftercombinediscount").value = varAfterDiscountAmount.toFixed(2);	
		document.getElementById('afterdiscountamount').value = varAfterDiscountAmount.toFixed(2);
	}
	else if (document.getElementById("subtotaldiscountpercentapply1").value != "0.00")
	{
		//alert ("2");
	
		var varSubTotalAfterDiscountPercent = document.getElementById("subtotaldiscountpercentapply1").value;
		var varSubTotalAfterDiscountPercent = parseFloat(varSubTotalAfterDiscountPercent);
		//alert (varSubTotalAfterDiscountPercent);
		var varTotalAfterDiscount = parseFloat(varTotalAfterDiscount);
		var varSubTotalAfterDiscountPercent = varTotalAfterDiscount * varSubTotalAfterDiscountPercent;
		var varSubTotalAfterDiscountPercent = parseFloat(varSubTotalAfterDiscountPercent) / 100;
		//alert (varSubTotalAfterDiscountPercent);
		document.getElementById("subtotaldiscountamountapply1").value = parseFloat(varSubTotalAfterDiscountPercent).toFixed(2);
		var varSubTotalAfterDiscountPercent = parseFloat(varTotalAfterDiscount) - parseFloat(varSubTotalAfterDiscountPercent);
		//alert (varSubTotalAfterDiscountPercent);
		document.getElementById("subtotalaftercombinediscount").value = varSubTotalAfterDiscountPercent.toFixed(2);	
		//var varTotalAfterTax = varNetTotalTaxAmount + varTotalAfterDiscount;
		//alert (varTotalAfterTax);
		document.getElementById('afterdiscountamount').value = varSubTotalAfterDiscountPercent.toFixed(2);
	}
	
	else if (document.getElementById("subtotaldiscountamountonlyapply1").value != "0.00")
	{
		//alert ("3");
			
		var varSubTotalDiscountAmount = document.getElementById("subtotaldiscountamountonlyapply1").value;
		var varSubTotalDiscountAmount = parseFloat(varSubTotalDiscountAmount);
		//alert (varSubTotalDiscountAmount);
		
		var varSubTotalAmount = document.getElementById("subtotal").value;
		var varSubTotalAmount = parseFloat(varSubTotalAmount);
		//alert (varSubTotalAmount);
	
		var varDiscountPercentDerived = varSubTotalDiscountAmount * 100;
		var varDiscountPercentDerived = parseFloat(varDiscountPercentDerived);
		//alert (varDiscountPercentDerived);
		
		var varDiscountPercentDerived = varDiscountPercentDerived / varSubTotalAmount; 
		var varDiscountPercentDerived = parseFloat(varDiscountPercentDerived);
		//alert (varDiscountPercentDerived);
		
		//document.getElementById("subtotaldiscountamountonlyapply2").value = parseFloat(varDiscountPercentDerived).toFixed(2);
		document.getElementById("subtotaldiscountamountonlyapply2").value = parseFloat(varDiscountPercentDerived);//.toFixed(2);

		var varSubTotalDiscountAmount = varSubTotalAmount - varSubTotalDiscountAmount;
		var varSubTotalDiscountAmount = parseFloat(varSubTotalDiscountAmount);
		//alert (varSubTotalDiscountAmount);

		//var varSubTotalAfterDiscountAmount = parseFloat(varTotalAfterDiscount) - parseFloat(varSubTotalDiscountAmount);
		//alert (varSubTotalAfterDiscountAmount);
		//document.getElementById("subtotalaftercombinediscount").value = varSubTotalAfterDiscountAmount.toFixed(2);	

		document.getElementById("subtotalaftercombinediscount").value = varSubTotalDiscountAmount.toFixed(2);	
		
		//var varTotalAfterTax = varNetTotalTaxAmount + varTotalAfterDiscount;
		//alert (varTotalAfterTax);
		document.getElementById('afterdiscountamount').value = varSubTotalDiscountAmount.toFixed(2);
	}
	else
	{
	
		//alert ("4");
		var varTotalAfterDiscount = parseFloat(varTotalAfterDiscount);
		//alert (varTotalAfterDiscount);
		document.getElementById("subtotalaftercombinediscount").value = varTotalAfterDiscount.toFixed(2);	

		document.getElementById('afterdiscountamount').value = varTotalAfterDiscount.toFixed(2);
	}


		//var varTotalDiscountAmount = varTotalDiscountAmount * 1;
		var varTotalAfterDiscount = document.getElementById('afterdiscountamount').value;
		var varTotalAfterDiscount = varTotalAfterDiscount * 1;
		//var varTotalAfterDiscount = varSubTotalAmount - varTotalDiscountAmount;
		var varTotalAfterDiscount = varTotalAfterDiscount.toFixed(2);
		//document.getElementById('totalafterdiscount').value = varTotalAfterDiscount;
		//alert (varTotalAfterDiscount);
		
	
		
	if (document.getElementById("subtotaldiscountpercentapply1").value == "0.00" && document.getElementById("subtotaldiscountamountonlyapply1").value == "0.00")
	{
	//alert ("Normal Tax Calucaltion");
	<?php
		//To get default tax values
		if (isset($_SESSION["defaulttax"])) { $defaulttax = $_SESSION["defaulttax"]; } else { $defaulttax = ""; }
		//$defaulttax = $_SESSION[defaulttax];
		
		if ($defaulttax == '')
		{
			$query5 = "select * from master_tax where status = ''";
		}
		else
		{
			$query5 = "select * from master_tax where status = '' and auto_number = '$defaulttax'";
		}
		
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res5 = mysqli_fetch_array($exec5))
		{
		$res5anum = $res5['auto_number'];
		$res5taxname = $res5['taxname'];
		$res5taxpercent = $res5['taxpercent'];
	?>

	//To avoid adding up existing amount, it needs to be reset to zero.
	document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value = "0.00";	
	
	for (z=1;z<=1000;z++)
	{
		//alert (z);
		if (document.getElementById('taxpercent'+z) != null) 
		{
			//alert ('<?php echo $res5taxname; ?>');
			//alert (i);
			var varTaxPercentageTextBox = document.getElementById('taxpercent'+z).value;
			//alert (varTaxPercentageTextBox);
			var varTaxAutoNumberTextBox = document.getElementById('taxautonumber'+z).value;
			//alert (varTaxPercentageTextBox);
	
			var varTaxPercentage = <?php echo $res5taxpercent; ?>;
			//alert (varTaxPercentage);
			var varTaxAutoNumber = <?php echo $res5anum; ?>;
			//alert (varTaxAutoNumber);

			if (varTaxPercentage == varTaxPercentageTextBox)
			{
				if (varTaxAutoNumber == varTaxAutoNumberTextBox)
				{
					//alert ('Inside <?php echo $res5taxname; ?>');
					var varTaxPercentage = varTaxPercentage * 1;
					//var varTaxTotalAmount = document.getElementById('totalafterdiscount').value;
					var varTaxTotalAmount<?php echo $res5anum; ?> = document.getElementById('totalamount'+z).value; //total amount of individual item.
					//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
					var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> * 1;
					var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> / 100;
					var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> * varTaxPercentage;
					//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
					
					var varCurrentTaxTotalAmount = document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value;
					//alert (varCurrentTaxTotalAmount);
					var varCurrentTaxTotalAmount = varCurrentTaxTotalAmount * 1;
					var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> + varCurrentTaxTotalAmount;
					//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
					var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?>.toFixed(2);
					//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
					
					document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value = varTaxTotalAmount<?php echo $res5anum; ?>;
					
					var varTotalAfterTax = varTotalAfterTax * 1;
					var varTaxTotalAmount = varTaxTotalAmount * 1;
					var varTotalAfterTax = varTotalAfterTax + varTaxTotalAmount;
				}
			}
		}
	}
	
	<?php
	$tslct = '';
	
	//to calculate sub taxes if any.
	$query6 = "select * from master_taxsub where taxparentanum = '$res5anum' and status = ''";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res6 = mysqli_fetch_array($exec6))
	{
		$tslct = $tslct + 1;
		$res6anum = $res6['auto_number'];
		$res6taxsubname = $res6['taxsubname'];
		$res6taxsubpercent = $res6['taxsubpercent'];
		?>
		//alert("Subtax <?php echo $tslct; ?>");
		var varTaxSubPercentage<?php echo $tslct; ?> = <?php echo $res6taxsubpercent; ?>;
		var varTaxSubPercentage<?php echo $tslct; ?> = varTaxSubPercentage<?php echo $tslct; ?> * 1;
		var varTaxTotalAmount<?php echo $tslct; ?> = document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value;
		var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * 1;
		var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> / 100;
		var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * varTaxSubPercentage<?php echo $tslct; ?>;
		var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?>.toFixed(2);
		//To avoid duplicates, parent taxanum is joined.
		document.getElementById('totaltaxsubamount<?php echo $res5anum; ?><?php echo $tslct; ?>').value = varTaxTotalAmount<?php echo $tslct; ?>;

		var varTotalAfterTax = varTotalAfterTax * 1;
		var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * 1;
		var varTotalAfterTax = varTotalAfterTax + varTaxTotalAmount<?php echo $tslct; ?>;

		<?php
	}

	} //end of master tax while.

	?>
	
	var varNetTotalMainTax1 = 0;
	var varNetTotalMainTax2 = 0;
	var varNetTotalSubTax1 = 0;
	var varNetTotalSubTax2 = 0;
	for (x=1;x<=100;x++)
	{
		if (document.getElementById('totaltaxamount'+x) != null) 
		{
			//alert (document.getElementById('totaltaxamount'+x).value);
			var varNetTotalMainTax1 = document.getElementById('totaltaxamount'+x).value;
			var varNetTotalMainTax1 = varNetTotalMainTax1 * 1;
			var varNetTotalMainTax2 = varNetTotalMainTax2 * 1;
			var varNetTotalMainTax2 = varNetTotalMainTax2 + varNetTotalMainTax1;
		}
		for (y=1;y<=5;y++)
		{
			if (document.getElementById('totaltaxsubamount'+x+y) != null) 
			{
				//alert (document.getElementById('totaltaxsubamount'+x+y).value);
				var varNetTotalSubTax1 = document.getElementById('totaltaxsubamount'+x+y).value;
				var varNetTotalSubTax1 = varNetTotalSubTax1 * 1;
				var varNetTotalSubTax2 = varNetTotalSubTax2 * 1;
				var varNetTotalSubTax2 = varNetTotalSubTax2 + varNetTotalSubTax1;
			}
		}
	}
	
	} // Normal Tax calculation if condition end.
	else
	{
		//alert ("Tax Calculated From Sub Total");
		var varTaxPercentageTextBox = "";
		var varTaxAutoNumberTextBox = "";
		var varNetTotalMainTax2 = "0";
		var varNetTotalSubTax2 = "0";

		<?php
			//To get default tax values
			if (isset($_SESSION["defaulttax"])) { $defaulttax = $_SESSION["defaulttax"]; } else { $defaulttax = ""; }
			//$defaulttax = $_SESSION[defaulttax];
			
			if ($defaulttax == '')
			{
				$query5 = "select * from master_tax where status = ''";
			}
			else
			{
				$query5 = "select * from master_tax where status = '' and auto_number = '$defaulttax'";
			}
			
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
			$res5anum = $res5['auto_number'];
			$res5taxname = $res5['taxname'];
			$res5taxpercent = $res5['taxpercent'];
		?>
	
			if (document.getElementById('taxpercent1') != null) 
			{
				var varTaxPercentageTextBox = document.getElementById('taxpercent1').value;
				//alert (varTaxPercentageTextBox);
				var varTaxAutoNumberTextBox = document.getElementById('taxautonumber1').value;
				//alert (varTaxPercentageTextBox);
		
			}
				var varTaxPercentage = <?php echo $res5taxpercent; ?>;
				//alert (varTaxPercentage);
				var varTaxAutoNumber = <?php echo $res5anum; ?>;
				//alert (varTaxAutoNumber);
						
			if (varTaxAutoNumberTextBox == varTaxAutoNumber)
			{
				//alert ('Inside <?php echo $res5taxname; ?>');
				var varTaxPercentage = varTaxPercentage * 1;
				//var varTaxTotalAmount = document.getElementById('totalafterdiscount').value;
				var varTaxTotalAmount<?php echo $res5anum; ?> = document.getElementById("subtotalaftercombinediscount").value; //sub total after discount apply.
				//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
				var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> * 1;
				var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> / 100;
				var varTaxTotalAmount<?php echo $res5anum; ?> = varTaxTotalAmount<?php echo $res5anum; ?> * varTaxPercentage;
				//alert (varTaxTotalAmount<?php echo $res5anum; ?>);
				
				document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value = varTaxTotalAmount<?php echo $res5anum; ?>.toFixed(2);;
				
				var varNetTotalMainTax2 = varTaxTotalAmount<?php echo $res5anum; ?>;
				//alert (varNetTotalMainTax2);
		
		<?php
		//to calculate sub taxes if any.
		$tslct = '';
		$query6 = "select * from master_taxsub where taxparentanum = '$res5anum' and status = ''";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res6 = mysqli_fetch_array($exec6))
		{
			$tslct = $tslct + 1;
			$res6anum = $res6['auto_number'];
			$res6taxsubname = $res6['taxsubname'];
			$res6taxsubpercent = $res6['taxsubpercent'];
			?>
			//alert("Subtax <?php echo $tslct; ?>");
			var varTaxSubPercentage<?php echo $tslct; ?> = <?php echo $res6taxsubpercent; ?>;
			var varTaxSubPercentage<?php echo $tslct; ?> = varTaxSubPercentage<?php echo $tslct; ?> * 1;
			var varTaxTotalAmount<?php echo $tslct; ?> = document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value;
			var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * 1;
			var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> / 100;
			var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * varTaxSubPercentage<?php echo $tslct; ?>;
			var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?>.toFixed(2);
			//To avoid duplicates, parent taxanum is joined.
			document.getElementById('totaltaxsubamount<?php echo $res5anum; ?><?php echo $tslct; ?>').value = varTaxTotalAmount<?php echo $tslct; ?>.toFixed(2);
			//alert (varTaxTotalAmount<?php echo $tslct; ?>);
			var varNetTotalSubTax2 = varNetTotalSubTax2 * 1;
			var varTaxTotalAmount<?php echo $tslct; ?> = varTaxTotalAmount<?php echo $tslct; ?> * 1;
			var varNetTotalSubTax2 = varNetTotalSubTax2 + varTaxTotalAmount<?php echo $tslct; ?>;
				
			<?php
			}
			?>

			}
	
			<?php
		//}
	
		} //end of master tax while.
		?>
	
	}
	
	//alert (varNetTotalMainTax2);
	//alert (varNetTotalSubTax2);
	var varNetTotalTaxAmount = varNetTotalMainTax2 + varNetTotalSubTax2;
	var varNetTotalTaxAmount = varNetTotalTaxAmount * 1;
	//alert (varNetTotalTaxAmount);
	var varTotalAfterDiscount = varTotalAfterDiscount * 1;
	//alert (varTotalAfterDiscount);
	
	var varTotalAfterTax = varNetTotalTaxAmount + varTotalAfterDiscount;
	//alert (varTotalAfterTax);
	var varTotalAfterTax = varTotalAfterTax.toFixed(2);
	document.getElementById('totalaftertax').value = varTotalAfterTax;
	
	document.getElementById('subtotal').value = varItemTotalAmount1.toFixed(2);
	funcNetAmountCalc1();

}





function funcSubTotalDiscountApply1()
{
	var varCheckTaxValues = "";
	for (z=1;z<=100;z++)
	{
		//alert (z);
		if (document.getElementById('taxpercent'+z) != null) 
		{
			//alert (z);
			var varTaxPercentageTextBoxZ = document.getElementById('taxpercent'+z).value;
			//alert (varTaxPercentageTextBox);
			var varTaxAutoNumberTextBoxZ = document.getElementById('taxautonumber'+z).value;
			//alert (varTaxPercentageTextBox);
			
			for (y=1;y<=100;y++)
			{
				//alert (z);
				if (document.getElementById('taxpercent'+y) != null) 
				{
					//alert (y);
					var varTaxPercentageTextBoxY = document.getElementById('taxpercent'+y).value;
					//alert (varTaxPercentageTextBox);
					var varTaxAutoNumberTextBoxY = document.getElementById('taxautonumber'+y).value;
					//alert (varTaxPercentageTextBox);
					
					//alert (varTaxPercentageTextBoxZ);
					//alert (varTaxPercentageTextBoxY);
					if (varTaxPercentageTextBoxZ != varTaxPercentageTextBoxY)
					{
						//alert ("z "+varTaxPercentageTextBoxZ+" y "+varTaxPercentageTextBoxY);
						//alert ("Different Tax");
						var varCheckTaxValues = "DifferentTax";
					}
				}
			}
	
		}	
	}
	//alert (varCheckTaxValues);
	if (varCheckTaxValues == "DifferentTax")
	{
		alert ("Failed. Items With Different Tax Percentage Exists On This Bill. Sub Total Amount Discount Cannot Be Applied.");
		document.getElementById("subtotaldiscountpercentapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountonlyapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountonlyapply2").value = "0.00";
		funcSubTotalCalc();
		return false;
	}

	var varSubTotalDiscountPercent = document.getElementById("subtotaldiscountpercentapply1").value;
	var varSubTotalDiscountPercent = parseFloat(varSubTotalDiscountPercent);
	if (isNaN(varSubTotalDiscountPercent))
	{
		alert ("Sub Total Discount Percent Can Only Be Numbers.");
		document.getElementById("subtotaldiscountpercentapply1").value = "0.00";
		document.getElementById("subtotaldiscountpercentapply1").focus();
		return false;
	}
	if (varSubTotalDiscountPercent > 100)
	{
		alert ("Sub Total Discount Percent Cannot Be Greater Than 100.")
		document.getElementById("subtotaldiscountpercentapply1").value = "0.00";
		document.getElementById("subtotaldiscountpercentapply1").focus();
		return false;
	}
	
	var varSubTotalDiscountAmount = document.getElementById("subtotaldiscountamountonlyapply1").value;
	var varSubTotalDiscountAmount = parseFloat(varSubTotalDiscountAmount);
	if (isNaN(varSubTotalDiscountAmount))
	{
		alert ("Sub Total Discount Amount Can Only Be Numbers.");
		document.getElementById("subtotaldiscountamountapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountapply1").focus();
		return false;
	}
	
	var varSubTotalAmount = document.getElementById("subtotal").value;
	var varSubTotalAmount = parseFloat(varSubTotalAmount);
	//alert (varSubTotalAmount);

	if (varSubTotalDiscountAmount > varSubTotalAmount)
	{
		alert ("Sub Total Discount Amount Cannot Be Greater Than Sub Total Amount.")
		document.getElementById("subtotaldiscountamountonlyapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountonlyapply1").focus();
		return false;
	}
	
	if (varSubTotalDiscountPercent != 0 && varSubTotalDiscountAmount != 0)
	{
		alert ("Either Discount Percent Or Discount Amount Can Be Given. Percent And Amount Together Not Allowed.");
		document.getElementById("subtotaldiscountpercentapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountonlyapply1").value = "0.00";
		document.getElementById("subtotaldiscountamountonlyapply2").value = "0.00";
		funcSubTotalCalc();
		return false;
	}
	else
	{
		funcSubTotalCalc();
	}
}



function itemtotalamountupdate1()
{
		//to update total amount after quantity update.
		var varItemMRP = document.getElementById("itemmrp").value;
		//alert (varItemMRP);
		if (isNaN(varItemMRP))
		{
			alert ("Rate Can Only Be Numbers.");
			document.getElementById("itemmrp").focus();
			return false;
		}
		var varItemQuantity = document.getElementById("itemquantity").value;
		if (isNaN(varItemQuantity))
		{
			alert ("Quantity Can Only Be Numbers.");
			document.getElementById("itemquantity").value = "1";
			document.getElementById("itemquantity").focus();
			return false;
		}
		var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
		//alert (varItemTotalAmount);
		document.getElementById("itemtotalamount").value = varItemTotalAmount.toFixed(2);
		//return false;

		//to check whether discount percent and discount amount are given together.
		if (document.getElementById("itemdiscountrupees").value != "0.00" && document.getElementById("itemdiscountpercent").value != "0.00")
		{
			alert ("Either Discount Percent Or Discount Amount Can Be Given. Percent And Amount Together Not Allowed.");
			document.getElementById("itemdiscountrupees").value = "0.00";
			document.getElementById("itemdiscountpercent").value = "0.00";
			return false;
		}
		

		//to update totalamount after discount percent updated.
		var varItemTotalAmount = document.getElementById("itemtotalamount").value;
		var varDiscountPercent = document.getElementById("itemdiscountpercent").value;
		var varItemTotalAmount = parseFloat(varItemTotalAmount);
		var varDiscountPercent = parseFloat(varDiscountPercent);
		if (isNaN(varDiscountPercent))
		{
			alert ("Discount Percent Can Only Be Numbers.");
			document.getElementById("itemdiscountpercent").value = "0.00";
			document.getElementById("itemdiscountpercent").focus();
			return false;
		}
		if (varDiscountPercent > 100)
		{
			alert ("Discount Percent Cannot Be Greater Than 100.")
			return false;
		}
		var varDiscountPercentAmount = varDiscountPercent * varItemTotalAmount;
		var varDiscountPercentAmount = parseFloat(varDiscountPercentAmount) / 100;
		var varItemTotalAmount = parseFloat(varItemTotalAmount) - parseFloat(varDiscountPercentAmount);
		document.getElementById("itemdiscountpercent").value = parseFloat(varDiscountPercent).toFixed(2);
		document.getElementById("itemtotalamount").value = varItemTotalAmount.toFixed(2);
		//return false;


		//to update totalamount after discount rupees updated.
		var varItemTotalAmount = document.getElementById("itemtotalamount").value;
		var varDiscountRupees = document.getElementById("itemdiscountrupees").value;
		var varItemTotalAmount = parseFloat(varItemTotalAmount);
		var varDiscountRupees = parseFloat(varDiscountRupees);
		if (isNaN(varDiscountRupees))
		{
			alert ("Discount Rupees Can Only Be Numbers.");
			document.getElementById("itemdiscountrupees").value = "0.00";
			document.getElementById("itemdiscountrupees").focus();
			return false;
		}
		if (varDiscountRupees > varItemTotalAmount)
		{
			alert ("Discount Amount Cannot Be Greater Than Total Amount.")
			return false;
		}
		var varItemTotalAmount = parseFloat(varItemTotalAmount) - parseFloat(varDiscountRupees);
		document.getElementById("itemdiscountrupees").value = parseFloat(varDiscountRupees).toFixed(2);
		document.getElementById("itemtotalamount").value = varItemTotalAmount.toFixed(2);
		
//Working Perfect. But, tax cannot be applied before giving discount on totalamount.
/*		//To update totalamount after tax percent applied.
		var varItemTotalAmount = document.getElementById("itemtotalamount").value;
		var varTaxPercent = document.getElementById("itemtaxpercent").value;
		var varItemTotalAmount = parseFloat(varItemTotalAmount);
		var varTaxPercent = parseFloat(varTaxPercent);
		var varTaxAmount = varTaxPercent * varItemTotalAmount;
		var varTaxAmount = parseFloat(varTaxAmount) / 100;
		var varItemTotalAmount = parseFloat(varItemTotalAmount) + parseFloat(varTaxAmount);
		document.getElementById("itemtotalamount").value = varItemTotalAmount.toFixed(2);
*/		
		return false;


}

function btnDeleteClick(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('tblrowinsert'); // tbody name.
	document.getElementById ('tblrowinsert').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('tblrowinsert'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('tblrowinsert').removeChild(child);
	}

	document.getElementById("subtotaldiscountpercentapply1").value = "0.00";
	document.getElementById("subtotaldiscountamountapply1").value = "0.00";
	document.getElementById("subtotaldiscountamountonlyapply1").value = "0.00";
	document.getElementById("subtotaldiscountamountonlyapply2").value = "0.00";

	funcCumulativeDiscountReset1();
	funcSubTotalCalc();
	
	alert ("Delete Item Entry Completed.");
}

function btnFreeClick(freeID)
{
	var varFreeID = freeID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('This Will Make Rate As 0.00. Are You Sure Want To Make Item No. '+varFreeID+' As FREE Entry? '); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	document.getElementById('rateperunit'+varFreeID).value = "0.00";
	document.getElementById('discountpercent'+varFreeID).value = "0.00";
	document.getElementById('discountrupees'+varFreeID).value = "0.00";
	document.getElementById('totalamount'+varFreeID).value = "0.00";

	funcCumulativeDiscountReset1();
	funcSubTotalCalc();
}



function funcResetPaymentInfo1()
{
	//alert ("Meow...");
	document.getElementById("cashamount").value = "0.00";
	document.getElementById("cashgivenbycustomer").value = "0.00";
	document.getElementById("cashgiventocustomer").value = "0.00";
	document.getElementById("creditamount").value = "0.00";
	document.getElementById("chequeamount").value = "0.00";
	document.getElementById("chequedate").value = "";
	document.getElementById("chequenumber").value = "";
	document.getElementById("chequebank").value = "";
	document.getElementById("cardname").value = "";
	document.getElementById("cardnumber").value = "";
	document.getElementById("bankname").value = "";
	document.getElementById("cardamount").value = "0.00";
	document.getElementById("onlineamount").value = "0.00";
	document.getElementById("nettamount").value = "0.00";

	document.getElementById("cashamount").readOnly = true;
	document.getElementById("chequeamount").readOnly = true;
	document.getElementById("creditamount").readOnly = true;
	document.getElementById("cardamount").readOnly = true;
	document.getElementById("onlineamount").readOnly = true;

	//document.getElementById("cashamounttr").style.display = 'none';
	$('.cc').hide();
	//document.getElementById("cashamounttr2").style.display = 'none';
	//document.getElementById("cashamounttr3").style.display = 'none';
	document.getElementById("chequeamounttr").style.display = 'none';
	document.getElementById("chequeamounttr1").style.display = 'none';
	document.getElementById("creditamounttr").style.display = 'none';
	document.getElementById("cardamounttr").style.display = 'none';
	document.getElementById("onlineamounttr").style.display = 'none';

	document.getElementById("billtype").selectedIndex = 0;
	document.getElementById("billtype").options[0].selected = true; 

}

function funcNetAmountCalc1()
{
	
	var varTotalAfterTax = document.getElementById("totalaftertax").value;
	var varPackagingAmount = document.getElementById("packaging").value;
	var varDeliveryAmount = document.getElementById("delivery").value;
	//var varNetAmount = parseFloat(varAfterDiscountAmount) + parseFloat(varDeliveryAmount);
	var varNetAmount = parseFloat(varTotalAfterTax) + parseFloat(varPackagingAmount) + parseFloat(varDeliveryAmount);

<?php
$query1roundoff = "select * from master_roundoff where defaultstatus = 'default'";
$exec1roundoff = mysqli_query($GLOBALS["___mysqli_ston"], $query1roundoff) or die ("Error in Query1roundoff".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1roundoff = mysqli_fetch_array($exec1roundoff);
$roundoffvalue = $res1roundoff['roundoff'];

if ($roundoffvalue == 'NO ROUND OFF')
{
?>
	//no round off apply.
	//alert ("NO ROUND OFF");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
if ($roundoffvalue == 'NEAREST TEN PAISE')
{
?>
	//to round off to nearest ten paise.
	//alert ("NEAREST TEN PAISE");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(1);
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
if ($roundoffvalue == 'NEAREST FIFTY PAISE')
{
?>
	//to round off to nearest fifty paise.
	//alert ("NEAREST FIFTY PAISE");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = roundToHalf(varNetAmount2); //function given below 
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
if ($roundoffvalue == 'NEAREST ONE RUPEE')
{
?>
	//to round off to nearest rupee.
	//alert ("NEAREST ONE RUPEE");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(0);
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
if ($roundoffvalue == 'NEAREST FIVE RUPEES')
{
?>
	//to round off to nearest five rupees.
	//alert ("NEAREST FIVE RUPEES");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = round5(varNetAmount2); //function given below 
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
if ($roundoffvalue == 'NEAREST TEN RUPEES')
{
?>
	//to round off to nearest ten rupees.
	//alert ("NEAREST TEN RUPEES");
	var varNetAmount2 = varNetAmount;
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = round10(varNetAmount2); //function given below 
	var varNetAmount2 = varNetAmount2 * 1;
	var varNetAmount2 = varNetAmount2.toFixed(2);
	//document.getElementById('netamount').value = varNetAmount2;
<?php
}
?>


	var varBeforeRoundOff = varNetAmount;
	var varBeforeRoundOff = parseFloat(varBeforeRoundOff);
	//var varAfterRoundOff = Math.round(varBeforeRoundOff);
	var varAfterRoundOff = varNetAmount2;
	var varAfterRoundOff = parseFloat(varAfterRoundOff);
	var varRoundOffAmount = parseFloat(varAfterRoundOff) - parseFloat(varBeforeRoundOff);
	//alert (varRoundOffAmount);
	
	//document.getElementById("totalamount").value = varNetAmount.toFixed(2);
	document.getElementById("roundoff").value = varRoundOffAmount.toFixed(2);
	document.getElementById("totalamount").value = varAfterRoundOff.toFixed(2);
	
	var varTDShowTotalAmount1 = document.getElementById("totalamount").value;
	//var varTDShowTotalAmount1 = "Total: "+varTDShowTotalAmount1;
	document.getElementById("tdShowTotalAmount1").innerHTML = varTDShowTotalAmount1;
	
}

function round5(x) 
{     
	return (x % 5) >= 2.5 ? parseInt(x / 5) * 5 + 5 : parseInt(x / 5) * 5; 
}  
function round10(x) 
{     
	return (x % 10) >= 5 ? parseInt(x / 10) * 10 + 10 : parseInt(x / 10) * 10; 
}  
function roundToHalf(value) 
{ 
   var converted = parseFloat(value); // Make sure we have a number 
   var decimal = (converted - parseInt(converted, 10)); 
   decimal = Math.round(decimal * 10); 
   if (decimal == 5) 
   { 
	   return (parseInt(converted, 10)+0.5); 
   } 
   if ( (decimal < 3) || (decimal > 7) ) 
   { 
      return Math.round(converted); 
   } 
   else 
   {
      return (parseInt(converted, 10)+0.5); 
   } 
} 




function paymentinfo()
{
		
	
	document.getElementById("cashamount").value = "0.00";
	document.getElementById("cashgivenbycustomer").value = "0.00";
	document.getElementById("cashgiventocustomer").value = "0.00";
	document.getElementById("creditamount").value = "0.00";
	document.getElementById("chequeamount").value = "0.00";
	document.getElementById("chequedate").value = "";
	document.getElementById("chequenumber").value = "";
	
	
	document.getElementById("chequebank").value = "";
	document.getElementById("cardname").value = "";
	
	
	document.getElementById("cardnumber").value = "";
	document.getElementById("bankname").value = "";

	document.getElementById("cardamount").value = "0.00";
	document.getElementById("onlineamount").value = "0.00";
	document.getElementById("nettamount").value = "0.00";
	

	document.getElementById("cashamount").readOnly = true;
	document.getElementById("chequeamount").readOnly = true;
	
	document.getElementById("creditamount").readOnly = true;
	document.getElementById("cardamount").readOnly = true;
	document.getElementById("onlineamount").readOnly = true;
	document.getElementById("cashgivenbycustomer").readOnly = true;
	
	if (document.getElementById("billtype").value == "")
	{
		//document.getElementById("cashamounttr").style.display = 'none';
		$('.cc').hide();
			document.getElementById("chequeamounttr").style.display = 'none';
			document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = "0.00";
		
		
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;

	}
	if (document.getElementById("billtype").value == "CASH")
	{
		
		//document.getElementById("cashamounttr").style.display = '';
		$('.cc').show();
			document.getElementById("chequeamounttr").style.display = 'none';
			document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = "0.00";
		
		///*
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
		//document.getElementById("cashgivenbycustomer").select();
		//*/
		document.getElementById("cashamount").value = document.getElementById("totalamount").value;
		document.getElementById("nettamount").value = document.getElementById("totalamount").value;

	}
	if (document.getElementById("billtype").value == "MPESA")
	{
		$('.cc').hide();
		
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
			document.getElementById("creditamounttr").style.display = '';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;

		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = document.getElementById("totalamount").value;
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = "0.00";
		document.getElementById("tdShowTotal").innerHTML = showtotal;

		document.getElementById("creditamount").focus();
		document.getElementById("nettamount").value = document.getElementById("creditamount").value;
	}
	if (document.getElementById("billtype").value == "CHEQUE")
	{
		$('.cc').hide();
		
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = '';
			document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;

		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = document.getElementById("totalamount").value
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = "0.00";

		document.getElementById("chequeamount").focus();
		document.getElementById("nettamount").value = document.getElementById("chequeamount").value;
	}
	if (document.getElementById("billtype").value == "CREDIT CARD")
	{
		$('.cc').hide();
			
		document.getElementById("cashamounttr").style.display = 'none';
			document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
			
		document.getElementById("cardamounttr").style.display = '';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;

		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = document.getElementById("totalamount").value
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = "0.00";

		document.getElementById("cardamount").focus();
		document.getElementById("nettamount").value = document.getElementById("cardamount").value;
		
	}
	if (document.getElementById("billtype").value == "ONLINE")
	{
		$('.cc').hide();
			
		document.getElementById("cashamounttr").style.display = 'none';
			document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = '';
		//document.getElementById("nettamounttr").style.display = 'none';
		var showtotal = document.getElementById("totalamount").value;
		document.getElementById("tdShowTotal").innerHTML = showtotal;

		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = document.getElementById("totalamount").value;
		document.getElementById("nettamount").value = "0.00";

		document.getElementById("onlineamount").focus();
		document.getElementById("nettamount").value = document.getElementById("onlineamount").value;
	}
	if (document.getElementById("billtype").value == "SPLIT")
	{
		$('.cc').show();
		document.getElementById("cashamounttr").style.display = '';
			document.getElementById("chequeamounttr").style.display = '';
		document.getElementById("creditamounttr").style.display = '';
		document.getElementById("cardamounttr").style.display = '';
		document.getElementById("onlineamounttr").style.display = '';
		//document.getElementById("nettamounttr").style.display = '';
		
		document.getElementById("cashamount").value = "";
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgiventocustomer").value = "";
		document.getElementById("creditamount").value = "";
		document.getElementById("chequeamount").value = "";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "";
		document.getElementById("onlineamount").value = "";
		document.getElementById("nettamount").value = "";

		//document.getElementById("cashamount").readOnly = false; 
		document.getElementById("chequeamount").readOnly = false;
		document.getElementById("creditamount").readOnly = false;
		document.getElementById("cardamount").readOnly = false;
		document.getElementById("onlineamount").readOnly = false;
		document.getElementById("cashamount").value = document.getElementById("totalamount").value;
		document.getElementById("cashamount").focus();
	
	}
	if (document.getElementById("billtype").value == "DC")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
			document.getElementById("chequeamounttr1").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = document.getElementById("totalamount").value

		//document.getElementById("creditamount").focus();
	}
	if (document.getElementById("billtype").value == "SALES ORDER")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
			document.getElementById("chequeamounttr1").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbycustomer").value = "0.00";
		document.getElementById("cashgiventocustomer").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = "0.00";
		document.getElementById("nettamount").value = document.getElementById("totalamount").value

		//document.getElementById("creditamount").focus();
	}

		document.getElementById("tdShowTotal").innerHTML =(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}

function funcBodyOnLoad()
{
	//document.getElementById("cashamounttr").style.display = 'none';
	
	//document.getElementById("cashamounttr").style.display = 'none';
	
	$('.cc').hide();
	
	//document.getElementsByClassName(cc).style.display='none';
	
		document.getElementById("chequeamounttr").style.display = 'none';
	document.getElementById("creditamounttr").style.display = 'none';
	document.getElementById("cardamounttr").style.display = 'none';
	document.getElementById("onlineamounttr").style.display = 'none';
	//document.getElementById("nettamounttr").style.display = 'none';

	
	
}	
function funcSaveBill1()
{
	//alert ("funcSaveBill1 Call");
	//To verify whether the bill number is already raised or not. Second check. First check is at billnumber onBlur.
	//billnumberlatest1(); // Ajax process from billnumberlatest1.js Not used anywhere.
	//billnovalidation1(); // Ajax process from billnovalidation1.js
	
	
	
	if (document.getElementById("billtype").value == "")
	{
		alert ("Please Select Bill Type To Proceed.");
		document.getElementById("billtype").focus();
		return false;
	}
	
	
	
	
	if (document.getElementById("billtype").value == "CREDIT" && document.getElementById("customercode").value == "")
	{
			alert ("For Credit Bill, Please Select Customer To Proceed. Without Customer Details Credit Bill Cannot Be Completed.");
			return false;
	}
	if (document.getElementById("billtype").value == "SPLIT" && document.getElementById("creditamount").value != "0.00" && document.getElementById("customercode").value == "")
	{
			alert ("For Split Bill With Credit Amount Please Select Customer. Without Customer Details Split Bill Cannot Be Completed.");
			return false;
	}
	if (document.getElementById("billtype").value == "CASH")
	{
		if (document.getElementById("cashamount").value == "0.00")
		{
			alert ("Please Enter Cash Amount.");
			document.getElementById("cashamount").focus();
			return false;
		}
		///*
		if (document.getElementById("cashgivenbycustomer").value == "")
		{
			alert ("Please Enter Cash Given By Customer.");
			document.getElementById("cashamount").focus();
			return false;
		}
		//*/
		if (isNaN(document.getElementById("cashamount").value))
		{
			alert ("Cash Amount Can Only Be Numbers.");
			document.getElementById("cashamount").value = "0.00"
			document.getElementById("cashamount").focus();
			return false;
		}
		var cashamount=document.getElementById("cashamount").value;
		var customeramount=document.getElementById("cashgivenbycustomer").value;
		if (parseFloat(customeramount) < parseFloat(cashamount))
		{
		
			alert ("Entry could not be saved because cash given by customer lesser than cash amount");
			document.getElementById("cashgivenbycustomer").focus();
			return false;
		}
	}
	if (document.getElementById("billtype").value == "CREDIT")
	{
		if (document.getElementById("creditamount").value == "0.00")
		{
			alert ("Please Enter Credit Amount.");
			document.getElementById("credit").focus();
			return false;
		}
		if (isNaN(document.getElementById("creditamount").value))
		{
			alert ("Credit Amount Can Only Be Numbers.");
			document.getElementById("creditamount").value = "0.00"
			document.getElementById("creditamount").focus();
			return false;
		}
	}
	if (document.getElementById("billtype").value == "ONLINE")
	{
		if (document.getElementById("onlineamount").value == "0.00")
		{
			alert ("Please Enter Online Amount.");
			document.getElementById("onlineamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("onlineamount").value))
		{
			alert ("Online Amount Can Only Be Numbers.");
			document.getElementById("onlineamount").focus();
			return false;
		}
	}
	if (document.getElementById("billtype").value == "CHEQUE")
	{
		if (document.getElementById("chequedate").value == "")
		{
			alert ("Please Enter Cheque Date.");
			document.getElementById("chequedate").focus();
			return false;
		}
		if (document.getElementById("chequenumber").value == "")
		{
			alert ("Please Enter Cheque Number.");
			document.getElementById("chequenumber").focus();
			return false;
		}
		if (document.getElementById("chequebank").value == "")
		{
			alert ("Please Enter Cheque Bank Name.");
			document.getElementById("chequebank").focus();
			return false;
		}
		if (document.getElementById("chequeamount").value == "0.00")
		{
			alert ("Please Enter Cheque Amount.");
			document.getElementById("chequeamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("chequeamount").value))
		{
			alert ("Cheque Amount Can Only Be Numbers.");
			document.getElementById("chequeamount").value = "0.00"
			document.getElementById("chequeamount").focus();
			return false;
		}
	}
	if (document.getElementById("billtype").value == "CREDIT CARD")
	{
/*		if (document.getElementById("cardname").value == "")
		{
			alert ("Please Enter Credit Card Name.");
			document.getElementById("cardname").focus();
			return false;
		}
*/
/*		if (document.getElementById("cardnumber").value == "")
		{
			alert ("Please Enter Credit Card Number.");
			document.getElementById("cardnumber").focus();
			return false;
		}
*/
/*
		if (document.getElementById("bankname").value == "")
		{
			alert ("Please Enter Credit Bank Name.");
			document.getElementById("bankname").focus();
			return false;
		}
*/
		if (document.getElementById("cardamount").value == "0.00")
		{
			alert ("Please Enter Credit Card Amount.");
			document.getElementById("cardamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("cardamount").value))
		{
			alert ("Card Amount Can Only Be Numbers.");
			document.getElementById("cardamount").value = "0.00"
			document.getElementById("cardamount").focus();
			return false;
		}
	}
	if (document.getElementById("billtype").value == "SPLIT")
	{
		if (isNaN(document.getElementById("cashamount").value))
		{
			alert ("Cash Amount Can Only Be Numbers.");
			document.getElementById("cashamount").value = "0.00"
			document.getElementById("cashamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("creditamount").value))
		{
			alert ("Credit Amount Can Only Be Numbers.");
			document.getElementById("creditamount").value = "0.00"
			document.getElementById("creditamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("onlineamount").value))
		{
			alert ("Online Amount Can Only Be Numbers.");
			document.getElementById("onlineamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("cardamount").value))
		{
			alert ("Card Amount Can Only Be Numbers.");
			document.getElementById("cardamount").value = "0.00"
			document.getElementById("cardamount").focus();
			return false;
		}
		if (isNaN(document.getElementById("chequeamount").value))
		{
			alert ("Cheque Amount Can Only Be Numbers.");
			document.getElementById("chequeamount").value = "0.00"
			document.getElementById("chequeamount").focus();
			return false;
		}
		if (document.getElementById("chequeamount").value != "0.00")
		{
			if (document.getElementById("chequedate").value == "")
			{
				alert ("Please Enter Cheque Date.");
				document.getElementById("chequedate").focus();
				return false;
			}
			if (document.getElementById("chequenumber").value == "")
			{
				alert ("Please Enter Cheque Number.");
				document.getElementById("chequenumber").focus();
				return false;
			}
			if (document.getElementById("chequebank").value == "")
			{
				alert ("Please Enter Cheque Bank Name.");
				document.getElementById("chequebank").focus();
				return false;
			}
		}
		if (document.getElementById("cardamount").value != "0.00")
		{
			if (document.getElementById("cardname").value == "")
			{
				alert ("Please Enter Credit Card Name.");
				document.getElementById("cardname").focus();
				return false;
			}
			if (document.getElementById("cardnumber").value == "")
			{
				//alert ("Please Enter Credit Card Number.");
				//document.getElementById("cardnumber").focus();
				//return false;
			}
			if (document.getElementById("bankname").value == "")
			{
				alert ("Please Enter Credit Bank Name.");
				document.getElementById("bankname").focus();
				return false;
			}
		}
	}
	var tot=document.getElementById("totalamount").value;
	tot=parseFloat(tot);
	
	var nettot=document.getElementById("nettamount").value;
	nettot=parseFloat(nettot);
	if (document.getElementById("billtype").value != "SPLIT")
	{
		if (tot != nettot)
		{
			alert ("Nett Total Amount Does Not Tallying With Total Amount. Recheck Payment Amount.");
			document.getElementById("nettamount").focus();
			return false;
		}	
	}
	else
	{
		var nettot=document.getElementById("balanceamt").value;
		nettot=parseFloat(nettot);
		if (nettot>0)
		{
			alert ("Nett Total Amount Does Not Tallying With Total Amount. Recheck Payment Amount.");
			document.getElementById("nettamount").focus();
			return false;
		}	
	}
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.form1.submit();
		//return true;
	}
}	


function funcbillamountcalc1()
{
	
	
	

	funcPaymentInfoCalculation1()
}

function funcPaymentInfoCalculation1()
{
//alert('in');
if(document.getElementById("cashamount").value == '')
{
document.getElementById("cashamount").value = "0.00";
}
if(document.getElementById("creditamount").value == '')
{
document.getElementById("creditamount").value = "0.00";
}
if(document.getElementById("onlineamount").value == '')
{
document.getElementById("onlineamount").value = "0.00";
}
if(document.getElementById("cardamount").value == '')
{
document.getElementById("cardamount").value = "0.00";
}
if(document.getElementById("chequeamount").value == '')
{
document.getElementById("chequeamount").value = "0.00";
}
	if (isNaN(document.getElementById("cashamount").value))
	{
		alert ("Cash Amount Can Only Be Numbers.");
		document.getElementById("cashamount").value = "0.00"
		document.getElementById("cashamount").focus();
		return false;
	}
	document.getElementById("cashamount").value = parseFloat(document.getElementById("cashamount").value).toFixed(2);
	
	///*
	
	
	//*/
	if (isNaN(document.getElementById("creditamount").value))
	{
		alert ("Credit Amount Can Only Be Numbers.");
		document.getElementById("creditamount").value = "0.00"
		document.getElementById("creditamount").focus();
		return false;
	}
	document.getElementById("creditamount").value = parseFloat(document.getElementById("creditamount").value).toFixed(2);
	
	if (isNaN(document.getElementById("onlineamount").value))
	{
		alert ("Online Amount Can Only Be Numbers.");
		document.getElementById("onlineamount").value = "0.00"
		document.getElementById("onlineamount").focus();
		return false;
	}
	document.getElementById("onlineamount").value = parseFloat(document.getElementById("onlineamount").value).toFixed(2);
	
	if (isNaN(document.getElementById("chequeamount").value))
	{
		alert ("Cheque Amount Can Only Be Numbers.");
		document.getElementById("chequeamount").value = "0.00"
		document.getElementById("chequeamount").focus();
		return false;
	}
	document.getElementById("chequeamount").value = parseFloat(document.getElementById("chequeamount").value).toFixed(2);
	
	if (isNaN(document.getElementById("cardamount").value))
	{
		alert ("Cash Amount Can Only Be Numbers.");
		document.getElementById("cardamount").value = "0.00"
		document.getElementById("cardamount").focus();
		return false;
	}
	document.getElementById("cardamount").value = parseFloat(document.getElementById("cardamount").value).toFixed(2);

	if ((document.getElementById("billtype").value == "CASH")||(document.getElementById("billtype").value == "SPLIT"))
	{	
		if((document.getElementById("cashamount").value != '')&&(document.getElementById("cashamount").value != 0.00))
		{
		
			document.getElementById("nettamount").value;
			//to calculate the cash to be return to customer
			///*
			var varCashGivenByCustomer1 = document.getElementById("cashgivenbycustomer").value;
			var varCashGivenToCustomer1 = document.getElementById("cashgiventocustomer").value;
			if(document.getElementById("cashgivenbycustomer").value == '')
			{
			varCashGivenByCustomer1 = "0";
			}
			if(document.getElementById("cashgiventocustomer").value == '')
			{
			varCashGivenToCustomer1 = "0";
			}
			var varActualCashAmount = document.getElementById("cashamount").value;
			
			//new
			var cashpay=document.getElementById("cashamount").value;
			
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			
			var allcash=parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay);
			var totalamount = document.getElementById("totalamount").value ;
			
			if(parseFloat(allcash)>=parseFloat(totalamount))
			{
				alert("Cant give more change than cash taken!");
				document.getElementById("creditamount").value='';
				document.getElementById("chequeamount").value='';
				document.getElementById("cardamount").value='';
				document.getElementById("onlineamount").value='';

				document.getElementById("cashgiventocustomer").value =0.00;
				funcbillamountcalc1();
				 balancecalc('2');
			
				return false;
			}
			else
			{
			//	var varCashGivenToCustomer1 = parseFloat(varCashGivenByCustomer1).toFixed(2) - parseFloat(varActualCashAmount).toFixed(2);
			//	var varVarFinalCashGivenToCustomer1 = parseFloat(varCashGivenToCustomer1).toFixed(2);
				
				
				var remainval=parseFloat(varCashGivenByCustomer1)-parseFloat(cashpay);
				if(parseFloat(remainval)<=0)
				{
					document.getElementById("cashgiventocustomer").value = 0.00;
				}
				else
				{
					document.getElementById("cashgiventocustomer").value = parseFloat(remainval).toFixed(2);
				}
				
			}
			
			//*/
		}
		else
		{
			document.getElementById("cashgiventocustomer").value = 0.00;
		}
	}
	if(document.getElementById("cashgiventocustomer").value < 0)
	{
	document.getElementById("cashgiventocustomer").value="0.00";
	}
	
	if (document.getElementById("billtype").value == "MPESA")
	{	
		document.getElementById("nettamount").value = document.getElementById("creditamount").value;
	}
	if (document.getElementById("billtype").value == "ONLINE")
	{	
		document.getElementById("nettamount").value = document.getElementById("onlineamount").value;
	}
	if (document.getElementById("billtype").value == "CHEQUE")
	{	
		document.getElementById("nettamount").value = document.getElementById("chequeamount").value;
	}
	if (document.getElementById("billtype").value == "CREDIT CARD")
	{	
		document.getElementById("nettamount").value = document.getElementById("cardamount").value;
	}
	if (document.getElementById("billtype").value == "SPLIT")
	{	
		var varCashAmount = document.getElementById("cashamount").value;
		var varCreditAmount = document.getElementById("creditamount").value;
		var varChequeAmount = document.getElementById("chequeamount").value;
		var varCardAmount = document.getElementById("cardamount").value;
		var varOnlineAmount = document.getElementById("onlineamount").value;
		var varTotalNettAmount = parseFloat(varCashAmount) + parseFloat(varCreditAmount) + parseFloat(varChequeAmount) + parseFloat(varCardAmount) + parseFloat(varOnlineAmount);
		var varTotalNettAmount = varTotalNettAmount.toFixed(2);
		document.getElementById("nettamount").value = varTotalNettAmount;
	}


	/*var varTDShowCustomerBalanceAmount1 = document.getElementById("cashgiventocustomer").value;
	//var varTDShowCustomerBalanceAmount1 = "Balance: "+varTDShowCustomerBalanceAmount1;
	document.getElementById("tdShowCustomerBalanceAmount1").innerHTML = varTDShowCustomerBalanceAmount1;
	*/


} 

function funcCumulativeDiscountReset1()
{
	document.getElementById("subtotaldiscountrupees").value = "0.00";
	document.getElementById("subtotaldiscountpercent").value = "0.00";
	document.getElementById("totaldiscountamount").value = "0.00";
	document.getElementById("afterdiscountamount").value = "0.00";

}




function funcRedirectWindow1()
{
	window.location = "sales1.php";
}

function funcPreviousBillPrint1(varPreviousBillNumber1)
{
	var varPreviousBillNumber1 = varPreviousBillNumber1;
	//alert (varPreviousBillNumber1);
	window.open("print_bill1.php?copy1=ORIGINAL&&billnumber="+varPreviousBillNumber1,"OriginalWindow"+varPreviousBillNumber1,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcSalesReportBillPrint1(varSalesReportBillNumber1)
{
	var varSalesReportBillNumber1 = varSalesReportBillNumber1;
	//alert (varPreviousBillNumber1);
	window.open("print_bill1.php?copy1=ORIGINAL&&billnumber="+varSalesReportBillNumber1,"OriginalWindow"+varSalesReportBillNumber1,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}


function quickprintbill1sales()
{
	if (document.getElementById("quickprintbill").value == "")
	{
		alert ("Please Enter Bill Number To Print");
		document.getElementById("quickprintbill").focus;
		return false;
	}
	var varQuickPrintBillNumber = document.getElementById("quickprintbill").value;
	var varBillNumberLength = varQuickPrintBillNumber.length;
	var varBillNumberLength = parseInt(varBillNumberLength);
	if (varBillNumberLength != 11)
	{
		//alert ("Bill Number Should Be 11 Characters Length.");
		//document.getElementById("quickprintbill").focus;
	}
	
	window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill2sales()
{
	if (document.getElementById("quickprintbill").value == "")
	{
		alert ("Please Enter Bill Number To Print");
		document.getElementById("quickprintbill").focus;
		return false;
	}
	var varQuickPrintBillNumber = document.getElementById("quickprintbill").value;
	var varBillNumberLength = varQuickPrintBillNumber.length;
	var varBillNumberLength = parseInt(varBillNumberLength);
	if (varBillNumberLength != 11)
	{
		//alert ("Bill Number Should Be 11 Characters Length.");
		//document.getElementById("quickprintbill").focus;
	}
	
	window.open("print_bill_dmp4inch1view1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill1return()
{
	if (document.getElementById("quickprintbill").value == "")
	{
		alert ("Please Enter Bill Number To Print");
		document.getElementById("quickprintbill").focus;
		return false;
	}
	var varQuickPrintBillNumber = document.getElementById("quickprintbill").value;
	var varBillNumberLength = varQuickPrintBillNumber.length;
	var varBillNumberLength = parseInt(varBillNumberLength);
	if (varBillNumberLength != 11)
	{
		//alert ("Bill Number Should Be 11 Characters Length.");
		//document.getElementById("quickprintbill").focus;
	}
	
	window.open("print_bill_dmp4inch1_salesreturn1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}


function quickprintbill2return()
{
	if (document.getElementById("quickprintbill").value == "")
	{
		alert ("Please Enter Bill Number To Print");
		document.getElementById("quickprintbill").focus;
		return false;
	}
	var varQuickPrintBillNumber = document.getElementById("quickprintbill").value;
	var varBillNumberLength = varQuickPrintBillNumber.length;
	var varBillNumberLength = parseInt(varBillNumberLength);
	if (varBillNumberLength != 11)
	{
		//alert ("Bill Number Should Be 11 Characters Length.");
		//document.getElementById("quickprintbill").focus;
	}
	
	window.open("print_bill_dmp4inch1view1salesreturn1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}


function quickprintbill1dccustomer()
{
	if (document.getElementById("quickprintbill").value == "")
	{
		alert ("Please Enter Bill Number To Print");
		document.getElementById("quickprintbill").focus;
		return false;
	}
	var varQuickPrintBillNumber = document.getElementById("quickprintbill").value;
	var varBillNumberLength = varQuickPrintBillNumber.length;
	var varBillNumberLength = parseInt(varBillNumberLength);
	if (varBillNumberLength != 11)
	{
		//alert ("Bill Number Should Be 11 Characters Length.");
		//document.getElementById("quickprintbill").focus;
	}
	
	window.open("print_bill_dmp4inch1_dccustomer1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}
















</script>