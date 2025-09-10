function insertitem1()
{
	//alert("Insert New Item.");
	if (document.getElementById("itemname").value == "")
	{
		alert ("Select Item To Continue. Alt+S To View Item Search Window.");
		document.getElementById("itemcode").focus();
		return false;
	}
	if (document.getElementById("accountcode").value == "")
	{
		alert ("Select Expense Account");
		document.getElementById("account").focus();
		return false;
	}
	if(parseFloat(document.getElementById("itemmrp").value) <= 0)
	{
		alert ("Enter Rate");
		document.getElementById("itemmrp").focus();
		return false;
	}
	
	for (m=1;m<1000;m++)
	{
		if (document.getElementById('itemname'+m) != null) 
		{
			if (document.getElementById('itemname'+m).value == document.getElementById("itemname").value)
			{
				var fRet3; 
				//fRet3 = confirm('Item Already In List. To Add This Quantity With Existing Quantity Click OK. \nTo Minus One Quantity, Give -1 To Reduce. \nTo Exit Without Upating Click Cancel.'); 
				fRet3 = confirm('Item Already In List. To Add This Quantity With Existing Quantity Click OK. \nTo Reduce Item Quantity, Delete Item Entry & Add Again. \nTo Exit Without Upating Click Cancel.'); 
				//alert(fRet); 
				if (fRet3 == false)
				{
					alert ("Item Quantity Update Not Completed.");
					return false;
					break;
				}
				else
				{
					var varQuantityToUpdate = document.getElementById("itemquantity").value;
					var varExistingQuantity = document.getElementById('quantity'+m).value;
					var varFinalQuantity = parseInt(varQuantityToUpdate) + parseInt(varExistingQuantity);
					//alert (varQuantityToUpdate+' + '+varExistingQuantity+' = '+varFinalQuantity);
					document.getElementById('quantity'+m).value = varFinalQuantity;
					
					var varItemMRP = document.getElementById('rateperunit'+m).value;
					var varItemQuantity = document.getElementById('quantity'+m).value;
					var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
					document.getElementById('totalamount'+m).value = varItemTotalAmount.toFixed(2);
	//alert(varExistingQuantity);
					//document.getElementById("itemserialnumber").value = k + 1;
					//document.getElementById("itemcode").value = "";
					document.getElementById("itemname").value = "";
					document.getElementById("itemmrp").value = "0.00";
					document.getElementById("itemquantity").value = "1";
					document.getElementById("itemfreequantity").value = "0";
					document.getElementById("itemtotalquantity").value = "1";
					//document.getElementById("itemdiscountpercent").value = "0.00";
					//document.getElementById("itemdiscountrupees").value = "0.00";
					//document.getElementById("itemtaxpercent").value = "0.00";
					document.getElementById("itemtotalamount").value = "0.00";
					if (document.getElementById("pageidentificationcontrol").value == "purchaseentry" || document.getElementById("pageidentificationcontrol").value == "purchasereturnentry")
					{
						document.getElementById("batchnumber").value = "";
						document.getElementById("salesprice").value = "";
						document.getElementById("expirydate").value = "";
					}
					document.getElementById("itemcode").focus();
					
					funcSubTotalCalc(); //function from purchase1.php
					
					alert ("Item Quantity Update Completed.");
					return false;
					break;
				}
			}
		}
	}
	
	var currrate=document.getElementById("currency").value;
	var varItemSerialNumber = document.getElementById("itemserialnumber").value;
	//var varItemCode = document.getElementById("itemcode").value;
	//var varItemCode = varItemCode.toUpperCase();
	var varItemName = document.getElementById("itemname").value;
	var varItemDescription = document.getElementById("itemdescription").value;
	//alert (varItemDescription);
	var varItemMRP = document.getElementById("itemmrp").value;
	//var costprice = document.getElementById("costprice").value;
	varItemMRP=varItemMRP.replace(/,/g , "");
	
	
	var varItemMRP = parseFloat(varItemMRP);
	var varItemMRP = varItemMRP.toFixed(2);
	var varItemQuantity = document.getElementById("itemquantity").value;
	var varItemDiscountPercent = document.getElementById("itemdiscountpercent").value;
	/*var varItemDiscountRupees = document.getElementById("itemdiscountrupees").value;*/
	var varItemTaxPercent = document.getElementById("itemtaxpercent").value;
	
	var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
	//varItemTotalAmount =varItemTotalAmount*currrate;
	varItemTotalAmount = parseFloat(varItemTotalAmount).toFixed(2);
	varItemTotalAmount = varItemTotalAmount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	var varItemTotalAmount = varItemTotalAmount;
	varItemMRP = parseFloat(varItemMRP).toFixed(2);
	varItemMRP = varItemMRP.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	var varAccount = document.getElementById("account").value;
	var varAccountCode = document.getElementById("accountcode").value;
	//var varItemTotalAmount = document.getElementById("itemtotalamount").value;
	
//	var totfxamount=varItemTotalAmount*currrate;
	
	if (document.getElementById("pageidentificationcontrol").value == "purchaseentry")
	{
		/*var varItemBatchNumber = document.getElementById("batchnumber").value;
		
		var varItemSalesPrice = document.getElementById("salesprice").value;
		if (varItemSalesPrice == "") varItemSalesPrice = 0;
		var varItemSalesPrice = parseFloat(varItemSalesPrice);
		var varItemSalesPrice = varItemSalesPrice.toFixed(2);
		var varItemExpiryDate = document.getElementById("expirydate").value;*/
		
		var varItemFreeQuantity = document.getElementById("itemfreequantity").value;
		//var varItemTotalQuantity = document.getElementById("itemtotalquantity").value;
		//var varItemPackageName = document.getElementById("packagename").value;
		//var varItemManufacturerName = document.getElementById("manufacturername").value;;
	}
	if (document.getElementById("pageidentificationcontrol").value == "purchasereturnentry" )
	{
		var varItemBatchNumber = document.getElementById("batchnumber").value;
		var varItemSalesPrice = '';//document.getElementById("salesprice").value;
		var varItemExpiryDate = document.getElementById("expirydate").value;
	}
	//alert (varItemBatchNumber);
	//alert (varItemSalesPrice);
	//alert (varItemExpiryDate);
	
	/*var varItemBatchNumber = document.getElementById("batchnumber").value;
	//alert (varItemMRP);
	if (varItemBatchNumber == "")
	{
		alert ("Please Enter Batch Number.");
		document.getElementById("batchnumber").focus();
		return false;
	}

	//var varItemExpiryDate = document.getElementById("expirydate").value;
	//alert (varItemMRP);
	if (varItemExpiryDate == "")
	{
		alert ("Please Enter Expiry Date.");
		document.getElementById("expirydate").focus();
		return false;
	}
	
	
	var varItemExpiryDateLength = varItemExpiryDate.length;
	var varItemExpiryDateLength = parseInt(varItemExpiryDateLength);
	if (varItemExpiryDateLength != 5)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Length Should Be Five Characters.");
		document.getElementById("expirydate").focus();
		return false;
	}
	
	var varItemExpiryDateArray = varItemExpiryDate.split("/");
	//alert(varItemExpiryDateArray);
	var varItemExpiryDateArrayLength = varItemExpiryDateArray.length;
	//alert(varItemExpiryDateArrayLength);
	if (varItemExpiryDateArrayLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Forward Slash Is Missing.");
		document.getElementById("expirydate").focus();
		return false;
	}
	
	var varItemExpiryDateMonthLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = varItemExpiryDateMonthLength.length;
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = parseInt(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonthLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Preceding Zero Is Required Except November & December.");
		document.getElementById("expirydate").focus();
		return false;
	}
	
	var varItemExpiryDateYearLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = varItemExpiryDateYearLength.length;
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = parseInt(varItemExpiryDateYearLength);
	if (varItemExpiryDateYearLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Simply Give Current Year In Two Digits.");
		document.getElementById("expirydate").focus();
		return false;
	}
	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (isNaN(varItemExpiryDateMonth))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Month Should Be Number.");
		document.getElementById("expirydate").focus();
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (isNaN(varItemExpiryDateYear))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Year Should Be Number.");
		document.getElementById("expirydate").focus();
		return false;
	}

	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonth > 12 || varItemExpiryDateMonth == 0)
	{
		alert ("Expiry Month Should Be Between 1 And 12.");
		document.getElementById("expirydate").focus();
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (varItemExpiryDateYear < 13 || varItemExpiryDateYear > 23)
	{
		alert ("Expiry Year Should Be Between 2013 And 2023.");
		document.getElementById("expirydate").focus();
		return false;
	}

	var varItemPackageName = document.getElementById("packagename").value;
	//alert (varItemMRP);
	if (varItemPackageName == "")
	{
		alert ("Please Select Package Name.");
		document.getElementById("packagename").focus();
		return false;
	}

	*/

	//return false;

	////alert (varItemSerialNumber);
	var k = parseInt(varItemSerialNumber);// + 1;
	//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";

	


	//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "idTD1"+k+"";
	td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+k+"";
	text1.name = "serialnumber"+k+"";
	text1.type = "text";
	text1.size = "1";
	text1.value = k;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "right";
	td1.appendChild (text1);
	tr.appendChild (td1);







	//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	/*var td2 = document.createElement ('td');
	td2.id = "idTD2"+k+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+k+'" value="'+varItemCode+'" id="itemcode'+k+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "itemcode"+k+"";
	text2.name = "itemcode"+k+"";
	text2.type = "text";
	text2.size = "5";
	text2.value = varItemCode;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);*/




	//var td3 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+k+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+k+'" value="'+varItemName+'" size="50" id="itemname'+k+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "itemname"+k+"";
	text3.name = "itemname"+k+"";
	text3.type = "text";
	text3.size = "30";
	text3.value = varItemName;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	//var td3 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td251 = document.createElement ('td');
	td251.id = "idTD251"+k+"";
	td251.align = "left";
	td251.valign = "top";
	td251.style.backgroundColor = "#FFFFFF";
	td251.style.border = "0px solid #001E6A";
	//var text251 = document.createElement ('<textarea name="itemdescription'+k+'" cols="40" rows="2" id="itemdescription'+k+'" style="border: 0px solid #001E6A;"></textarea>');
	var text251 = document.createElement ('input');
	text251.id = "account"+k+"";
	text251.name = "account"+k+"";
	text251.value = varAccount;
	text251.readOnly = "readonly";
	text251.size = "35";
	text251.style.backgroundColor = "#FFFFFF";
	text251.style.border = "0px solid #001E6A";
	text251.style.textAlign = "left";
	td251.appendChild (text251);
	
	var text2511 = document.createElement ('input');
	text2511.id = "accountcode"+k+"";
	text2511.name = "accountcode"+k+"";
	text2511.value = varAccountCode;
	text2511.readOnly = "readonly";
	text2511.type = "hidden";
	text2511.style.backgroundColor = "#FFFFFF";
	text2511.style.border = "0px solid #001E6A";
	text2511.style.textAlign = "left";
	td251.appendChild (text2511);
	
	var text2512 = document.createElement ('input');
	text2512.id = "itemdescription"+k+"";
	text2512.name = "itemdescription"+k+"";
	text2512.cols = "40";
	text2512.rows = "2";
	text2512.value = varItemDescription;
	text2512.readOnly = "readonly";
	text2512.style.backgroundColor = "#FFFFFF";
	text2512.style.border = "0px solid #001E6A";
	text2512.style.textAlign = "left";
	td251.appendChild (text2512);
	
	tr.appendChild (td251);



	//var td5 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD3"+k+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+k+'" value="'+varItemMRP+'" id="rateperunit'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "rateperunit"+k+"";
	text5.name = "rateperunit"+k+"";
	text5.type = "text";
	text5.size = "15";
	text5.value = varItemMRP;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);





	//var td6 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "idTD3"+k+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+k+'" value="'+varItemQuantity+'" id="quantity'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text6 = document.createElement ('input');
	text6.id = "quantity"+k+"";
	text6.name = "quantity"+k+"";
	text6.type = "text";
	text6.size = "4";
	text6.value = varItemQuantity;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "center";
	td6.appendChild (text6);
	tr.appendChild (td6);





	//var td61 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td61 = document.createElement ('td');
	td61.id = "idTD3"+k+"";
	td61.align = "left";
	td61.valign = "top";
	td61.style.backgroundColor = "#FFFFFF";
	td61.style.border = "0px solid #001E6A";
	//var text61 = document.createElement ('<input name="quantity'+k+'" value="'+varItemQuantity+'" id="quantity'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text61 = document.createElement ('input');
	text61.id = "freequantity"+k+"";
	text61.name = "freequantity"+k+"";
	text61.type = "hidden";
	text61.size = "1";
	text61.value = varItemFreeQuantity;
	text61.readOnly = "readonly";
	text61.style.backgroundColor = "#FFFFFF";
	text61.style.border = "0px solid #001E6A";
	text61.style.textAlign = "center";
	
	//tr.appendChild (td61);


	//var td7 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td7 = document.createElement ('td');
	td7.id = "idTD3"+k+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+k+'" value="'+varItemDiscountPercent+'" id="discountpercent'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "discountpercent"+k+"";
	text7.name = "discountpercent"+k+"";
	text7.type = "hidden";
	text7.size = "2";
	text7.value = varItemDiscountPercent;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "right";
	
	//td7.appendChild (text7);
	//td61.appendChild (text61);
	//td7.appendChild (text84);
	//tr.appendChild (td61);
	
	/*
	//var text83 = document.createElement ('<input type="hidden"  name="taxname'+k+'" value="'+varItemTaxName+'" id="itemtaxname'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text84 = document.createElement ('input');
	text84.id = "batchnumber"+k+"";
	text84.name = "batchnumber"+k+"";
	text84.type = "text";
	text84.size = "5";
	text84.value = varItemBatchNumber;
	text84.readOnly = "readonly";
	text84.style.backgroundColor = "#FFFFFF";
	text84.style.border = "0px solid #001E6A";
	text84.style.textAlign = "left";
	
	






	//var td8 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "idTD3"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+k+'" value="'+varItemDiscountRupees+'" id="discountrupees'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "discountrupees"+k+"";
	text8.name = "discountrupees"+k+"";
	text8.type = "hidden";
	text8.size = "2";
	text8.value = varItemDiscountRupees;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "right";
	
	var text81 = document.createElement ('input');
	text81.id = "costprice"+k+"";
	text81.name = "costprice"+k+"";
	text81.type = "hidden";
	text81.size = "2";
	text81.value = costprice;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "right";

	//var text83 = document.createElement ('<input type="hidden"  name="taxname'+k+'" value="'+varItemTaxName+'" id="itemtaxname'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text86 = document.createElement ('input');
	text86.id = "expirydate"+k+"";
	text86.name = "expirydate"+k+"";
	text86.type = "text";
	text86.size = "3";
	text86.value = varItemExpiryDate;
	text86.readOnly = "readonly";
	text86.style.backgroundColor = "#FFFFFF";
	text86.style.border = "0px solid #001E6A";
	text86.style.textAlign = "left";
	
	td8.appendChild (text8);
	td8.appendChild (text86);
	td8.appendChild (text81);
	tr.appendChild (td8);






	//var td8 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "idTD3"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text83 = document.createElement ('<input type="hidden"  name="taxname'+k+'" value="'+varItemTaxName+'" id="itemtaxname'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text87 = document.createElement ('input');
	text87.id = "packagename"+k+"";
	text87.name = "packagename"+k+"";
	text87.type = "text";
	text87.size = "2";
	text87.value = varItemPackageName;
	text87.readOnly = "readonly";
	text87.style.backgroundColor = "#FFFFFF";
	text87.style.border = "0px solid #001E6A";
	text87.style.textAlign = "left";
	
	td8.appendChild (text87);
	tr.appendChild (td8);

//var td62 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td62 = document.createElement ('td');
	td62.id = "idTD3"+k+"";
	td62.align = "left";
	td62.valign = "top";
	td62.style.backgroundColor = "#FFFFFF";
	td62.style.border = "0px solid #001E6A";
	//var text62 = document.createElement ('<input name="quantity'+k+'" value="'+varItemQuantity+'" id="quantity'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text62 = document.createElement ('input');
	text62.id = "totalquantity"+k+"";
	text62.name = "totalquantity"+k+"";
	text62.type = "text";
	text62.size = "1";
	text62.value = varItemTotalQuantity;
	text62.readOnly = "readonly";
	text62.style.backgroundColor = "#FFFFFF";
	text62.style.border = "0px solid #001E6A";
	text62.style.textAlign = "right";
	td62.appendChild (text62);
	tr.appendChild (td62);*/


	//var td9 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td9 = document.createElement ('td');
	td9.id = "idTD3"+k+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text9 = document.createElement ('<input name="totalamount'+k+'" value="'+varItemTotalAmount+'" id="totalamount'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="8" />');
	var text9 = document.createElement ('input');
	text9.id = "totalamount"+k+"";
	text9.name = "totalamount"+k+"";
	text9.type = "text";
	text9.size = "15";
	text9.value = varItemTotalAmount;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "right";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
//alert(varItemTotalAmount);
//alert("hi");

	//var td9 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	/*var td9 = document.createElement ('td');
	td9.id = "idTD3"+k+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text9 = document.createElement ('<input name="totalamount'+k+'" value="'+varItemTotalAmount+'" id="totalamount'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="8" />');
	var text9 = document.createElement ('input');
	text9.id = "salesprice"+k+"";
	text9.name = "salesprice"+k+"";
	text9.type = "text";
	text9.size = "3";
	text9.value = varItemSalesPrice;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "right";
	td9.appendChild (text9);
	tr.appendChild (td9);*/




	//var td10 = document.createElement ('<td id="idTD3'+k+'" align="right" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "idTD3"+k+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	/*
	//var text10 = document.createElement ('<input onClick="return btnFreeClick('+k+')" name="btnfree'+k+'" id="btnfree'+k+'" type="button" value="Free" class="button" style="border: 1px solid #001E6A"/>');
	var text10 = document.createElement ('input');
	text10.id = "btnfree"+k+"";
	text10.name = "btnfree"+k+"";
	text10.type = "button";
	text10.value = "Free";
	text10.style.border = "1px solid #001E6A";
	text10.onclick = function() { return btnFreeClick(k); }
	//var text11 = document.createElement ('<input onClick="return btnDeleteClick('+k+')" name="btndelete'+k+'" id="btndelete'+k+'" type="button" value="Del" class="button" style="border: 1px solid #001E6A"/>');
	*/
	var td51 = document.createElement ('td');
	td51.id = "idTD3"+k+"";
	td51.align = "left";
	td51.valign = "top";
	td51.style.backgroundColor = "#FFFFFF";
	td51.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+k+'" value="'+varItemMRP+'" id="rateperunit'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text51 = document.createElement ('input');
	text51.id = "fxrate"+k+"";
	text51.name = "fxrate"+k+"";
	text51.type = "hidden";
	text51.size = "1";
	text51.value = currrate;
	text51.readOnly = "readonly";
	text51.style.backgroundColor = "#FFFFFF";
	text51.style.border = "0px solid #001E6A";
	text51.style.textAlign = "left";
	td51.appendChild (text51);
	tr.appendChild (td51);
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete"+k+"";
	text11.name = "btndelete"+k+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick(k); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

	document.getElementById ('tblrowinsert').appendChild (tr);



	//document.getElementById ('tblrowinsert').appendChild (tr);
	
	// if additional text this tr will be inserted.
	//alert (varItemDescription);
	if (varItemDescription == "none43")
	{

	//var trAddDescription = document.createElement ('<TR id="idTRaddtxt'+k+'"></TR>');
	var trAddDescription = document.createElement ('TR');
	trAddDescription.id = "idTRaddtxt"+k+"";
		



	//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td1 = document.createElement ('td');
	td1.id = "idTD2"+k+"";
	td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td1);


	//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td2 = document.createElement ('td');
	td2.id = "idTD2"+k+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td2);


	//var td3 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+k+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<textarea name="itemdescription'+k+'" cols="40" rows="2" id="itemdescription'+k+'" style="border: 0px solid #001E6A;"></textarea>');
	var text3 = document.createElement ('input');
	text3.id = "itemdescription"+k+"";
	text3.name = "itemdescription"+k+"";
	text3.cols = "40";
	text3.rows = "2";
	text3.value = varItemDescription;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	trAddDescription.appendChild (td3);

	

	//var td4 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td4 = document.createElement ('td');
	td4.id = "idTD3"+k+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td4);

	
	//var td5 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD3"+k+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td5);

	
	//var td6 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td6 = document.createElement ('td');
	td6.id = "idTD3"+k+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td6);

	
	//var td7 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td7 = document.createElement ('td');
	td7.id = "idTD3"+k+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td7);

	
	//var td8 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td8 = document.createElement ('td');
	td8.id = "idTD3"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td8);

	
	//var td81 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td81 = document.createElement ('td');
	td81.id = "idTD3"+k+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td81);

	
	//var td9 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td9 = document.createElement ('td');
	td9.id = "idTD3"+k+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td9);

	
	//var td10 = document.createElement ('<td id="idTD3'+k+'" align="right" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td10 = document.createElement ('td');
	td10.id = "idTD3"+k+"";
	td10.align = "left";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	trAddDescription.appendChild (td10);
	

	document.getElementById ('tblrowinsert').appendChild (trAddDescription);


	}

	
	
	document.getElementById("itemserialnumber").value = k + 1;
	//document.getElementById("itemcode").value = "";
	document.getElementById("itemname").value = "";
	document.getElementById("itemdescription").value = "";
	document.getElementById("itemmrp").value = "0.00";
	document.getElementById("itemquantity").value = "1";
	document.getElementById("itemfreequantity").value = "0";
	document.getElementById("itemtotalamount").value = "0.00";
	var varAccount = document.getElementById("account").value = "";
	var varAccountCode = document.getElementById("accountcode").value = "";
	/*document.getElementById("itemtotalquantity").value = "1";
	document.getElementById("itemdiscountpercent").value = "0.00";
	document.getElementById("itemdiscountrupees").value = "0.00";
	document.getElementById("itemtaxpercent").value = "0.00";
	document.getElementById("itemtaxautonumber").value = "";
	document.getElementById("itemtaxname").value = "";
	
	document.getElementById("costprice").value = "0.00";
	if (document.getElementById("pageidentificationcontrol").value == "purchaseentry")
	{
		document.getElementById("batchnumber").value = "";
		document.getElementById("expirydate").value = "";
		document.getElementById("salesprice").value = "";
	}
	if (document.getElementById("pageidentificationcontrol").value == "purchasereturnentry")
	{
		document.getElementById("batchnumber").value = "";
		document.getElementById("expirydate").value = "";
		//document.getElementById("salesprice").value = "";
	}*/
	//alert("hi1");
	//Function connected with autoitemsearch3purchase.js
	//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
	/*document.getElementById('packagename').options.length=null; 
	var newOption = document.createElement('option');
	newOption.text = "Pack";
	newOption.value = "";
	newOption.selected = "selected";
	try 
	{
		document.getElementById("packagename").options.add(newOption, null); //Standard To Chrome and Firefox.
	}
	catch(error) 
	{
		document.getElementById("packagename").options.add(newOption); //Only For IE.
	}
	*/

	
	
	//alert('h');
	document.getElementById("itemname").focus();
	
	funcSubTotalCalc(); //function from purchase1.php
	paymentinfo(); // to reset payment method if it is selected.

	window.scrollBy(0,25); 
}