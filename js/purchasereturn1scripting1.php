<script language="javascript">

//This file cannot be save as .js, reason, php coding is involved in tax calculation. It needs to be as .php file than .js 

function suppliersearch1(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_suppliersearch1.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function itemsearch1(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_itemsearch1purchase.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


function itemcodekeypress1(e)
{
	var data = document.getElementById("itemcode").value;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
	
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Item Code Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}

	/*
	//alert ("Key Press");
	if (event.keyCode=='13')
	{
		//function from autoitemsearch2.js
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
		itemsearch3();
		return false;
	}

}

function itemquantitykeypress1(e)
{
	//alert ("Key Press");
	/*
	if (event.keyCode=='13')
	{
		itemtotalamountupdate1();
		//same function call of add button click from purchaseinsertitem1.js
		insertitem1();
		return false;
	}
	*/
	
	evt = e || window.event; 
	key = evt.keyCode;
	//alert (key);
	if(key == 13) // if enter key press
	{
		//alert ("Key Press");
		itemtotalamountupdate1();
		//same function call of add button click from salesinsertitem1.js
		insertitem1();
		return false;
	}
	
}

function funcAllItemDiscountApply1()
{
	var varDiscountPercent = document.getElementById("allitemdiscountpercent").value;
	var varDiscountPercent = parseFloat(varDiscountPercent);
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
	
	for (z=1;z<=1000;z++)
	{
		//alert (z);
		if (document.getElementById('discountpercent'+z) != null) 
		{
			//alert (z);
			//alert (varDiscountPercent);
			//document.getElementById('discountpercent'+z).value = varDiscountPercent.toFixed(2);

			//var varItemTotalAmount = document.getElementById('totalamount'+z).value;
			var varItemRatePerUnit = document.getElementById('rateperunit'+z).value;
			var varItemTotalQuantity = document.getElementById('quantity'+z).value;
			var varItemTotalAmount = parseFloat(varItemRatePerUnit) * parseFloat(varItemTotalQuantity);

			var varDiscountPercentAmount = varDiscountPercent * varItemTotalAmount;
			var varDiscountPercentAmount = parseFloat(varDiscountPercentAmount) / 100;
			var varItemTotalAmount = parseFloat(varItemTotalAmount) - parseFloat(varDiscountPercentAmount);
			document.getElementById('discountpercent'+z).value = parseFloat(varDiscountPercent).toFixed(2);
			document.getElementById('totalamount'+z).value = varItemTotalAmount.toFixed(2);
		}
	}

	funcSubTotalCalc();
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
		if (varItemMRP == "")
		{
			alert ("Rate Can Only Be Numbers.");
			document.getElementById("itemmrp").value = "0.00";
			document.getElementById("itemmrp").focus();
			return false;
		}
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
		var varItemFreeQuantity = document.getElementById("itemfreequantity").value;
		if (isNaN(varItemFreeQuantity))
		{
			alert ("Free Quantity Can Only Be Numbers.");
			document.getElementById("itemfreequantity").value = "0";
			document.getElementById("itemfreequantity").focus();
			return false;
		}
		//alert('h');
		var varItemTotalQuantity = parseFloat(varItemQuantity) + parseFloat(varItemFreeQuantity);
		//alert (varItemTotalQuantity);
		document.getElementById("itemtotalquantity").value = varItemTotalQuantity;//.toFixed(2);
		//return false;
		
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

function funcSubTotalCalc()
{
	funcCumulativeDiscountReset1();

	var varSerialNumberUpdate = 0;
	var varTotalAmount = 0;
	var varTotalAmountLoop = 0;
	for (m=1;m<1000;m++)
	{
		
		if (document.getElementById('serialnumber'+m) != null) 
		{
			var varSerialNumberUpdate = varSerialNumberUpdate + 1;
			document.getElementById('serialnumber'+m).value = varSerialNumberUpdate;
			
			var varTotalAmountLoop = document.getElementById('totalamount'+m).value;
			if (varTotalAmountLoop != null) 
			{
				//alert (varTotalAmountLoop);
				var varTotalAmount = parseFloat(varTotalAmount) + parseFloat(varTotalAmountLoop);
			}
		}
	}
	//var varSerialNumberUpdate = varSerialNumberUpdate + 1;
	//document.getElementById('itemserialnumber').value = varSerialNumberUpdate;
	document.getElementById('subtotal').value = varTotalAmount.toFixed(2);
	
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
			document.getElementById('totaltaxsubamount<?php echo $res5anum; ?><?php echo $tslct; ?>').value = varTaxTotalAmount<?php echo $tslct; ?>.toFixed(2);;
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
	
	funcNetAmountCalc1();

}


function funcResetPaymentInfo1()
{
	//alert ("Meow...");
	document.getElementById("cashamount").value = "0.00";
	document.getElementById("cashgivenbysupplier").value = "0.00";
	document.getElementById("cashgiventosupplier").value = "0.00";
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

	document.getElementById("cashamounttr").style.display = 'none';
	document.getElementById("cashamounttr2").style.display = 'none';
	document.getElementById("cashamounttr3").style.display = 'none';
	document.getElementById("chequeamounttr").style.display = 'none';
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
	document.getElementById("cashgivenbysupplier").value = "0.00";
	document.getElementById("cashgiventosupplier").value = "0.00";
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

	if (document.getElementById("billtype").value == "")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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
	}
	if (document.getElementById("billtype").value == "CASH")
	{
		document.getElementById("cashamounttr").style.display = '';
		document.getElementById("cashamounttr2").style.display = '';
		document.getElementById("cashamounttr3").style.display = '';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = document.getElementById("totalamount").value
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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
		
		/*
		document.getElementById("cashgivenbysupplier").value = "";
		document.getElementById("cashgivenbysupplier").focus();
		//document.getElementById("cashgivenbysupplier").select();
		*/
		document.getElementById("nettamount").value = document.getElementById("cashamount").value

	}
	if (document.getElementById("billtype").value == "CREDIT")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = '';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
		document.getElementById("creditamount").value = document.getElementById("totalamount").value
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

		document.getElementById("creditamount").focus();
	}
	if (document.getElementById("billtype").value == "CHEQUE")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = '';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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
	}
	if (document.getElementById("billtype").value == "CREDIT CARD")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = '';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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
	}
	if (document.getElementById("billtype").value == "ONLINE")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = '';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
		document.getElementById("creditamount").value = "0.00";
		document.getElementById("chequeamount").value = "0.00";
		document.getElementById("chequedate").value = "";
		document.getElementById("chequenumber").value = "";
		document.getElementById("chequebank").value = "";
		document.getElementById("cardname").value = "";
		document.getElementById("cardnumber").value = "";
		document.getElementById("bankname").value = "";
		document.getElementById("cardamount").value = "0.00";
		document.getElementById("onlineamount").value = document.getElementById("totalamount").value
		document.getElementById("nettamount").value = "0.00";

		document.getElementById("onlineamount").focus();
	}
	if (document.getElementById("billtype").value == "SPLIT")
	{
		document.getElementById("cashamounttr").style.display = '';
		document.getElementById("cashamounttr2").style.display = '';
		document.getElementById("cashamounttr3").style.display = '';
		document.getElementById("chequeamounttr").style.display = '';
		document.getElementById("creditamounttr").style.display = '';
		document.getElementById("cardamounttr").style.display = '';
		document.getElementById("onlineamounttr").style.display = '';
		//document.getElementById("nettamounttr").style.display = '';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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

		document.getElementById("cashamount").readOnly = false;
		document.getElementById("chequeamount").readOnly = false;
		document.getElementById("creditamount").readOnly = false;
		document.getElementById("cardamount").readOnly = false;
		document.getElementById("onlineamount").readOnly = false;

		document.getElementById("cashamount").focus();
	}
	if (document.getElementById("billtype").value == "DC")
	{
		document.getElementById("cashamounttr").style.display = 'none';
		document.getElementById("cashamounttr2").style.display = 'none';
		document.getElementById("cashamounttr3").style.display = 'none';
		document.getElementById("chequeamounttr").style.display = 'none';
		document.getElementById("creditamounttr").style.display = 'none';
		document.getElementById("cardamounttr").style.display = 'none';
		document.getElementById("onlineamounttr").style.display = 'none';
		//document.getElementById("nettamounttr").style.display = 'none';
		
		document.getElementById("cashamount").value = "0.00";
		document.getElementById("cashgivenbysupplier").value = "0.00";
		document.getElementById("cashgiventosupplier").value = "0.00";
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

}

function funcBodyOnLoad()
{
	document.getElementById("cashamounttr").style.display = 'none';
	document.getElementById("cashamounttr2").style.display = 'none';
	document.getElementById("cashamounttr3").style.display = 'none';
	document.getElementById("chequeamounttr").style.display = 'none';
	document.getElementById("creditamounttr").style.display = 'none';
	document.getElementById("cardamounttr").style.display = 'none';
	document.getElementById("onlineamounttr").style.display = 'none';
	//document.getElementById("nettamounttr").style.display = 'none';

	document.getElementById("supplier").focus();	
}	
	
function funcSaveBill1()
{

if(document.getElementById("location").value=='')
	{
		alert("Please Select The location");
		document.getElementById("location").focus();
		return false;
	}
	if(document.getElementById("suppliercode").value=='')
	{
		alert("Please Select The supplier");
		document.getElementById("supplier").focus();
		return false;
	}
		if(document.getElementById("tostore").value=='')
	{
		alert("Please Select The Store ");
		document.getElementById("tostore").focus();
		return false;
	}
	
	/*	
	if(document.getElementById("medicinecode").value=='')
	{
		alert("Please Select The Item Name");
		document.getElementById("medicinename").focus();
		return false;
	}
	
	if(document.getElementById("itemquantity").value=='')
	{
		alert("Please Select The Quantity");
		document.getElementById("itemquantity").focus();
		return false;
	}
*/

    if (document.getElementById("supplierbillnumber").value == "")
	{
		alert ("Please Enter Supplier Bill Number To Proceed.");
		document.getElementById("supplierbillnumber").focus();
		return false;
	}
	if (document.getElementById("billtype").value == "")
	{
		alert ("Please Select Bill Type To Proceed.");
		document.getElementById("billtype").focus();
		return false;
	}
	if (document.getElementById("subtotal").value == "0.00" || document.getElementById("subtotal").value == "0.0" || document.getElementById("subtotal").value == "")
	{
		alert ("No Items Selected. Please Add Items To Proceed.");
		document.getElementById("itemcode").focus();
		return false;
	}
	if (document.getElementById("billtype").value == "CREDIT" && document.getElementById("suppliercode").value == "")
	{
			alert ("For Credit Bill, Please Select Supplier To Proceed. Without Supplier Details Credit Bill Cannot Be Completed.");
			return false;
	}
	if (document.getElementById("billtype").value == "SPLIT" && document.getElementById("creditamount").value != "0.00" && document.getElementById("suppliercode").value == "")
	{
			alert ("For Split Bill With Credit Amount Please Select Supplier. Without Supplier Details Split Bill Cannot Be Completed.");
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
		if (document.getElementById("cashgivenbysupplier").value == "0.00")
		{
			alert ("Please Enter Cash Given By Supplier.");
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
	}
	if (document.getElementById("billtype").value == "CREDIT")
	{
		if (document.getElementById("creditamount").value == "0.00")
		{
			alert ("Please Enter Credit Amount.");
			document.getElementById("creditamount").focus();
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
		if (document.getElementById("cardname").value == "")
		{
			alert ("Please Enter Credit Card Name.");
			document.getElementById("cardname").focus();
			return false;
		}
/*		if (document.getElementById("cardnumber").value == "")
		{
			alert ("Please Enter Credit Card Number.");
			document.getElementById("cardnumber").focus();
			return false;
		}
*/		if (document.getElementById("bankname").value == "")
		{
			alert ("Please Enter Credit Bank Name.");
			document.getElementById("bankname").focus();
			return false;
		}
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
	if (document.getElementById("totalamount").value != document.getElementById("nettamount").value)
	{
		alert ("Nett Total Amount Does Not Tallying With Total Amount. Recheck Payment Amount.");
		document.getElementById("nettamount").focus();
		return false;
	}
	
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	
}

function funcbillamountcalc1()
{
	///*
	if (document.getElementById("cashgivenbysupplier").value == "")
	{
		document.getElementById("cashgivenbysupplier").value = "0.00"
		return false;
	}
	//*/
	if (document.getElementById("subtotaldiscountrupees").value == 0 && document.getElementById("subtotaldiscountpercent").value == 0)
	{
			//To reset all the values to zero if already given discount is reversed.
			funcSubTotalCalc();
			//return false;
	}
	if (document.getElementById("subtotaldiscountrupees").value != "0.00" && document.getElementById("subtotaldiscountpercent").value != "0.00")
	{
			alert ("Either Discount Percent Or Discount Amount Can Be Given. Percent And Amount Together Not Allowed.");
			document.getElementById("subtotaldiscountrupees").value = "0.00";
			document.getElementById("subtotaldiscountpercent").value = "0.00";
			document.getElementById("totaldiscountamount").value = "0.00";
			document.getElementById("afterdiscountamount").value = "0.00";
			return false;
	}

	if (isNaN(document.getElementById("subtotaldiscountpercent").value))
	{
		alert ("Sub Total Discount Percent Can Only Be Numbers.");
		document.getElementById("subtotaldiscountpercent").value = "0.00"
		document.getElementById("subtotaldiscountpercent").focus();
		return false;
	}
	if (document.getElementById("subtotaldiscountpercent").value != "0.00")
	{
		document.getElementById("subtotaldiscountpercent").value = parseFloat(document.getElementById("subtotaldiscountpercent").value).toFixed(2);
		var varSubTotalDiscountPercent = parseFloat(document.getElementById("subtotaldiscountpercent").value).toFixed(2);
		var varSubTotalAmount = parseFloat(document.getElementById("subtotal").value).toFixed(2);

		if (parseFloat(varSubTotalDiscountPercent) > 100)
		{
			alert ("Sub Total Discount Percent Cannot Be Greater Than 100.")
			document.getElementById("subtotaldiscountpercent").value = "0.00";
			return false;
		}
		var varDiscountPercentAmount = parseFloat(varSubTotalDiscountPercent) * parseFloat(varSubTotalAmount);
		var varDiscountPercentAmount = parseFloat(varDiscountPercentAmount) / 100;
		var varAfterDiscountAmount = parseFloat(varSubTotalAmount) - parseFloat(varDiscountPercentAmount);
		document.getElementById("totaldiscountamount").value = parseFloat(varDiscountPercentAmount).toFixed(2);
		document.getElementById("afterdiscountamount").value = parseFloat(varAfterDiscountAmount).toFixed(2);

		//funcSubTotalCalc();
	}
	if (isNaN(document.getElementById("subtotaldiscountrupees").value))
	{
		alert ("Sub Total Discount Rupees Can Only Be Numbers.");
		document.getElementById("subtotaldiscountrupees").value = "0.00"
		document.getElementById("subtotaldiscountrupees").focus();
		return false;
	}
	if (document.getElementById("subtotaldiscountrupees").value != "0.00")
	{
		document.getElementById("subtotaldiscountrupees").value = parseFloat(document.getElementById("subtotaldiscountrupees").value).toFixed(2);
		var varSubTotalDiscountRupees = parseFloat(document.getElementById("subtotaldiscountrupees").value).toFixed(2);
		var varSubTotalAmount2 = parseFloat(document.getElementById("subtotal").value).toFixed(2);
		if (parseFloat(varSubTotalDiscountRupees) > parseFloat(varSubTotalAmount2))
		{
			alert ("Sub Total Discount Rupees Cannot Be Greater Than Sub Total Amount.")
			document.getElementById("subtotaldiscountrupees").value = "0.00"
			document.getElementById("subtotaldiscountrupees").focus();
			return false;
		}
		var varAfterDiscountAmount = parseFloat(varSubTotalAmount2) - parseFloat(varSubTotalDiscountRupees);
		document.getElementById("totaldiscountamount").value = parseFloat(varSubTotalDiscountRupees).toFixed(2);
		document.getElementById("afterdiscountamount").value = parseFloat(varAfterDiscountAmount).toFixed(2);

		//funcSubTotalCalc();
	}
	
	//To check and apply discount for over all bill total only if tax percent are same.
	if (document.getElementById("subtotaldiscountrupees").value != "0.00" || document.getElementById("subtotaldiscountpercent").value != "0.00")
	{
			var varTaxPercentCheck1 = 0;
			for (z=1;z<=100;z++)
			{
				//alert (z);
				if (document.getElementById('taxpercent'+z) != null) 
				{
					//alert (z);
					var varTaxPercentageTextBox = document.getElementById('taxpercent'+z).value;
					//alert (varTaxPercentageTextBox);
					if (varTaxPercentCheck1 == "")
					{
						//alert ("Empty"); //To assign value of first tax percent to check all the tax percent are equal.
						varTaxPercentCheck1 = varTaxPercentageTextBox;
						funcCumulativeDiscCalc1();
					}
					else
					{
						//alert ("Full"); //To compare if the following tax percent boxes are equal. if not no discount allowed.
						if (varTaxPercentCheck1 != varTaxPercentageTextBox)
						{
							//alert ("Differenct Taxes.");
							alert ("Sorry. Cumulative Discount Cannot Be Applied. Tax Percentage Is Different For More Than One Item.");
							alert ("Discount Apply Not Completed.");
							document.getElementById("subtotaldiscountrupees").value = "0.00"
							document.getElementById("subtotaldiscountpercent").value = "0.00"
							document.getElementById("totaldiscountamount").value = "0.00"
							document.getElementById("afterdiscountamount").value = "0.00"
							funcSubTotalCalc();
							return false;
						}
						else
						{
							funcCumulativeDiscCalc1();
						}
					}
				}
			}
			//return false;
	}
	

	//To calculate packaging charges.
	if (isNaN(document.getElementById("packaging").value))
	{
		alert ("Packaging Amount Can Only Be Numbers.");
		document.getElementById("packaging").value = "0.00"
		document.getElementById("packaging").focus();
		funcSubTotalCalc();
		return false;
	}
	else
	{
		document.getElementById("packaging").value = parseFloat(document.getElementById("packaging").value).toFixed(2);
		
		var varSubTotalAmount1 = document.getElementById("subtotal").value;
		var varTotalAfterDiscount1 = document.getElementById("afterdiscountamount").value;
		if (varTotalAfterDiscount1 == varSubTotalAmount1)
		{
			//calling item wise calculation.
			funcSubTotalCalc();
			//return false;
		}
	}

	//To calculate delivery charges.
	if (isNaN(document.getElementById("delivery").value))
	{
		alert ("Delivery Amount Can Only Be Numbers.");
		document.getElementById("delivery").value = "0.00"
		document.getElementById("delivery").focus();
		funcSubTotalCalc();
		return false;
	}
	else
	{
		document.getElementById("delivery").value = parseFloat(document.getElementById("delivery").value).toFixed(2);
		
		var varSubTotalAmount1 = document.getElementById("subtotal").value;
		var varTotalAfterDiscount1 = document.getElementById("afterdiscountamount").value;
		if (varTotalAfterDiscount1 == varSubTotalAmount1)
		{
			//calling item wise calculation.
			funcSubTotalCalc();
			//return false;
		}
	}
	funcPaymentInfoCalculation1()
}

function funcPaymentInfoCalculation1()
{
	if (isNaN(document.getElementById("cashamount").value))
	{
		alert ("Cash Amount Can Only Be Numbers.");
		document.getElementById("cashamount").value = "0.00"
		document.getElementById("cashamount").focus();
		return false;
	}
	document.getElementById("cashamount").value = parseFloat(document.getElementById("cashamount").value).toFixed(2);
	///*
	if (isNaN(document.getElementById("cashgivenbysupplier").value))
	{
		alert ("Cash Given By Supplier Can Only Be Numbers.");
		document.getElementById("cashgivenbysupplier").value = "0.00"
		document.getElementById("cashgivenbysupplier").focus();
		return false;
	}
	document.getElementById("cashgivenbysupplier").value = parseFloat(document.getElementById("cashgivenbysupplier").value).toFixed(2);
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

	if (document.getElementById("billtype").value == "CASH")
	{	
		document.getElementById("nettamount").value = document.getElementById("cashamount").value;
		//to calculate the cash to be return to supplier
		///*
		var varCashGivenBySupplier1 = document.getElementById("cashgivenbysupplier").value;
		var varCashGivenToSupplier1 = document.getElementById("cashgiventosupplier").value;
		var varActualCashAmount = document.getElementById("cashamount").value;
		var varCashGivenToSupplier1 = parseFloat(varCashGivenBySupplier1).toFixed(2) - parseFloat(varActualCashAmount).toFixed(2);
		var varVarFinalCashGivenToSupplier1 = parseFloat(varCashGivenToSupplier1).toFixed(2);
		document.getElementById("cashgiventosupplier").value = varVarFinalCashGivenToSupplier1;
		//*/
	}
	if (document.getElementById("billtype").value == "CREDIT")
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

	/*
	var varTDShowSupplierBalanceAmount1 = document.getElementById("cashgiventosupplier").value;
	//var varTDShowSupplierBalanceAmount1 = "Balance: "+varTDShowSupplierBalanceAmount1;
	document.getElementById("tdShowSupplierBalanceAmount1").innerHTML = varTDShowSupplierBalanceAmount1;
	*/

}

function funcCumulativeDiscountReset1()
{
	document.getElementById("subtotaldiscountrupees").value = "0.00"
	document.getElementById("subtotaldiscountpercent").value = "0.00"
	document.getElementById("totaldiscountamount").value = "0.00"
	document.getElementById("afterdiscountamount").value = "0.00"
}

function funcCumulativeDiscCalc1()
{
		//alert ("Meow..");
		//To update totalamount after discount percent applied.
		<?php
		$query5 = "select * from master_tax where status = ''";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res5 = mysqli_fetch_array($exec5))
		{
		$res5anum = $res5['auto_number'];
		$res5taxname = $res5['taxname'];
		$res5taxpercent = $res5['taxpercent'];
		?>
		//To avoid adding up existing amount, it needs to be reset to zero.
		document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value = "0.00";	
		//alert ('<?php echo $res5taxname; ?>');
		var varTaxPercentageTextBox = <?php echo $res5taxpercent; ?>;
		if (document.getElementById('taxpercent1').value != null) 
		{
			var varTaxPercentCheck1 = document.getElementById('taxpercent1').value;
			//alert (varTaxPercentCheck1);
			if (varTaxPercentCheck1 == varTaxPercentageTextBox)
			{
				//alert (varTaxPercentCheck1);
				var varItemTotalAmount = document.getElementById("afterdiscountamount").value;
				//alert (varItemTotalAmount);
				var varTaxPercentCheck1 = varTaxPercentCheck1 * 1;
				var varItemTotalAmount = parseFloat(varItemTotalAmount);
				var varTaxPercent = parseFloat(varTaxPercentCheck1);
				var varTaxAmount = varTaxPercent * varItemTotalAmount;
				var varTaxAmount = parseFloat(varTaxAmount) / 100;
				//alert (varItemTotalAmount);
				var varTotalAfterTaxAmount = parseFloat(varItemTotalAmount) + parseFloat(varTaxAmount);
				
				document.getElementById('totaltaxamount<?php echo $res5anum; ?>').value = varTaxAmount.toFixed(2);;	
				document.getElementById("totalaftertax").value = varTotalAfterTaxAmount.toFixed(2);
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
			document.getElementById('totaltaxsubamount<?php echo $res5anum; ?><?php echo $res6anum; ?>').value = varTaxTotalAmount<?php echo $tslct; ?>;
	
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
					//alert (varNetTotalSubTax2);
				}
			}
		}
		//alert (varNetTotalMainTax2);
		//alert (varNetTotalSubTax2);
		var varNetTotalMainTax2 = varNetTotalMainTax2 * 1;
		var varNetTotalSubTax2 = varNetTotalSubTax2 * 1;
		var varNetTotalTaxAmount = varNetTotalMainTax2 + varNetTotalSubTax2;
		//alert (varNetTotalTaxAmount);
		var varNetTotalTaxAmount = varNetTotalTaxAmount * 1;
		var varTotalAfterDiscount = document.getElementById("afterdiscountamount").value;
		var varTotalAfterDiscount = varTotalAfterDiscount * 1;
		var varTotalAfterTax = varNetTotalTaxAmount + varTotalAfterDiscount;
		//alert (varTotalAfterTax);
		var varTotalAfterTax = varTotalAfterTax.toFixed(2);
		document.getElementById('totalaftertax').value = varTotalAfterTax;

		funcNetAmountCalc1()	
}


function funcRedirectWindow1()
{
	window.location = "purchase1.php";
}

function funcPreviousBillPrint1(varPreviousBillNumber1)
{
	var varPreviousBillNumber1 = varPreviousBillNumber1;
	//alert (varPreviousBillNumber1);
	window.open("print_bill1_purchase1.php?copy1=ORIGINAL&&billnumber="+varPreviousBillNumber1,"OriginalWindow"+varPreviousBillNumber1,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcPurchaseReportBillPrint1(varPurchaseReportBillNumber1)
{
	var varPurchaseReportBillNumber1 = varPurchaseReportBillNumber1;
	//alert (varPreviousBillNumber1);
	window.open("print_bill1_purchase1.php?copy1=ORIGINAL&&billnumber="+varPurchaseReportBillNumber1,"OriginalWindow"+varPurchaseReportBillNumber1,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}


function quickprintbill1purchase()
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
	
	window.open("print_bill_dmp4inch1_purchase1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill2purchase()
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
	
	window.open("print_bill_dmp4inch1view1purchase1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}


function quickprintbill1purchaseorder()
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
	
	window.open("print_bill_dmp4inch1_purchaseorder1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill2purchaseorder()
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
	
	window.open("print_bill_dmp4inch1view1purchaseorder1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
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
	
	window.open("print_bill_dmp4inch1_purchasereturn1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
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
	
	window.open("print_bill_dmp4inch1view1purchasereturn1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill1dcsupplier()
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
	
	window.open("print_bill_dmp4inch1_dcsupplier1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=50,height=50,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function quickprintbill2dcsupplier()
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
	
	window.open("print_bill_dmp4inch1view1dcsupplier1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=400,height=500,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,left=25,top=25');
	//window.open("print_bill_dmp4inch1.php?copy1=ORIGINAL&&billnumber="+varQuickPrintBillNumber,"OriginalWindow"+varQuickPrintBillNumber,'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}


function funcTaxReverseCalc1()
{
	//alert ("Meow...");
	var varItemCode = document.getElementById("itemcode").value;
	if (varItemCode != "")
	{
		var varItemTotalAmount = document.getElementById("itemtotalamount").value;
		if (isNaN(varItemTotalAmount))
		{
			alert ("Total Amount Can Only Be Numbers.");
			document.getElementById("itemtotalamount").value = "0.00";
			document.getElementById("itemtotalamount").focus();
			return false;
		}
		var varItemTotalAmount = parseFloat(varItemTotalAmount);

		var varItemQuantity = document.getElementById("itemquantity").value;
		var varItemQuantity = parseFloat(varItemQuantity);

		var varItemMRP = varItemTotalAmount / varItemQuantity;
		var varItemMRP = parseFloat(varItemMRP);

		var varItemTotalAmount = varItemTotalAmount.toFixed(2);
		document.getElementById("itemtotalamount").value = varItemTotalAmount;
		
		var varItemMRP = varItemMRP.toFixed(2);
		document.getElementById("itemmrp").value = varItemMRP;
	
	}
	else
	{
		alert ("Please Select Item Before Changing Total Amount.");
		document.getElementById("itemtotalamount").value = "0.00";
		document.getElementById("itemcode").focus();
		return false;
	}
}



function funcTaxReverseCalc2()
{
	//alert ("Meow...");
	//To calculate reverse tax for the item rate.
	//http://answers.yahoo.com/question/index?qid=20080914103752AAzQ6nk
	//If the item costs 100 including 6.75% tax, then 100 represents 106.75% of the original price. 
	//So you divide 100 by 106.75 and get 93.68 (rounded to the nearest cent).
	//Original Price = Total Price / (1 + Tax Rate)
	//2750 / 2887.5 / 95.24 / 2619.1 / 130.95 / 2750
	//$taxpercent = 10;  //testing value.

	var varItemCode = document.getElementById("itemcode").value;
	if (varItemCode != "")
	{
		var varItemReverseTaxTotalAmount = document.getElementById("itemreversetax").value;
		if (isNaN(varItemReverseTaxTotalAmount))
		{
			alert ("Reverse Tax Total Amount Can Only Be Numbers.");
			document.getElementById("itemreversetax").value = "0.00";
			document.getElementById("itemreversetax").focus();
			return false;
		}
		
		if (varItemReverseTaxTotalAmount != "0.00")
		{
			var varItemReverseTaxTotalAmount = parseFloat(varItemReverseTaxTotalAmount);
			
			var varItemTaxPercent = document.getElementById("itemtaxpercent").value;
			var varItemTaxPercent = parseFloat(varItemTaxPercent);
			
			var varItemTaxAmount = varItemTaxPercent / 100;
			var varItemTaxAmount = varItemTaxAmount * varItemReverseTaxTotalAmount;
			var varItemTaxAmount = parseFloat(varItemTaxAmount);
			
			var varItemActualAmount = varItemReverseTaxTotalAmount + varItemTaxAmount;
			var varItemActualAmount = varItemReverseTaxTotalAmount /  varItemActualAmount;
			var varItemActualAmount = varItemActualAmount * varItemReverseTaxTotalAmount;
			var varItemActualAmount = parseFloat(varItemActualAmount);
			var varItemActualAmount = varItemActualAmount.toFixed(2);
			
			var varItemQuantity = document.getElementById("itemquantity").value;
			var varItemQuantity = parseFloat(varItemQuantity);
			
			var varItemPerUnitAmount = varItemActualAmount / varItemQuantity;
			var varItemPerUnitAmount = parseFloat(varItemPerUnitAmount);
			
			document.getElementById("itemtotalamount").value = varItemActualAmount;
			document.getElementById("itemmrp").value = varItemPerUnitAmount;
			document.getElementById("itemreversetax").value = "0.00";
		}
		else
		{
			document.getElementById("itemtotalamount").value = "0.00";
			document.getElementById("itemmrp").value = "0.00";
			document.getElementById("itemreversetax").value = "0.00";
		}
	
	}
	else
	{
		alert ("Please Select Item Before Giving Reverse Tax Total Amount.");
		document.getElementById("itemreversetax").value = "0.00";
		document.getElementById("itemcode").focus();
		return false;
	}
}












</script>