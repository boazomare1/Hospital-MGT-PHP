function insertitem1()
{
	//alert("Insert New Item.");
	if (document.getElementById("itemcode").value == "" || document.getElementById("itemname").value == "")
	{
		alert ("Select Item To Continue. Alt+S To View Item Search Window.");
		document.getElementById("itemcode").focus();
		return false;
	}
	
	for (m=1;m<1000;m++)
	{
		if (document.getElementById('itemcode'+m) != null) 
		{
			if (document.getElementById('itemcode'+m).value == document.getElementById("itemcode").value)
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
					var varFinalQuantity = parseFloat(varQuantityToUpdate) + parseFloat(varExistingQuantity);
					//alert (varQuantityToUpdate+' + '+varExistingQuantity+' = '+varFinalQuantity);
					document.getElementById('quantity'+m).value = parseFloat(varFinalQuantity).toFixed(4);
					
					var varItemMRP = document.getElementById('rateperunit'+m).value;
					var varItemQuantity = document.getElementById('quantity'+m).value;
					var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
					document.getElementById('totalamount'+m).value = varItemTotalAmount.toFixed(2);
	
					//document.getElementById("itemserialnumber").value = k + 1;
					document.getElementById("itemcode").value = "";
					document.getElementById("itemname").value = "";
					document.getElementById("itemmrp").value = "0.00";
					document.getElementById("itemquantity").value = "1";
					document.getElementById("itemdiscountpercent").value = "0.00";
					document.getElementById("itemdiscountrupees").value = "0.00";
					document.getElementById("itemtaxpercent").value = "0.00";
					document.getElementById("itemtotalamount").value = "0.00";
					document.getElementById("itemcode").focus();
					
					funcSubTotalCalc(); //function from purchase1.php
					
					alert ("Item Quantity Update Completed.");
					return false;
					break;
				}
			}
		}
	}
	
	
	var varItemSerialNumber = document.getElementById("itemserialnumber").value;
	var varItemCode = document.getElementById("itemcode").value;
	var varItemCode = varItemCode.toUpperCase();
	var varItemName = document.getElementById("itemname").value;
	var varItemDescription = document.getElementById("itemdescription").value;
	//alert (varItemDescription);
	var varItemMRP = document.getElementById("itemmrp").value;
	var varItemMRP = parseFloat(varItemMRP);
	var varItemMRP = varItemMRP.toFixed(2);
	var varItemQuantity = document.getElementById("itemquantity").value;
	var varItemDiscountPercent = document.getElementById("itemdiscountpercent").value;
	var varItemDiscountRupees = document.getElementById("itemdiscountrupees").value;
	var varItemTaxPercent = document.getElementById("itemtaxpercent").value;
	var varItemTaxAnum = document.getElementById("itemtaxautonumber").value;
	var varItemTaxName = document.getElementById("itemtaxname").value;
	var varItemTotalAmount = document.getElementById("itemtotalamount").value;
	


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
	var td2 = document.createElement ('td');
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
	text2.size = "10";
	text2.value = varItemCode;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);




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
	text3.size = "50";
	text3.value = varItemName;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);






	//var td4 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td4 = document.createElement ('td');
	td4.id = "idTD3"+k+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	tr.appendChild (td4);






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
	text5.size = "6";
	text5.value = varItemMRP;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "right";
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
	text6.style.textAlign = "right";
	td6.appendChild (text6);
	tr.appendChild (td6);






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
	text7.type = "text";
	text7.size = "2";
	text7.value = varItemDiscountPercent;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "right";
	td7.appendChild (text7);
	tr.appendChild (td7);






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
	text8.type = "text";
	text8.size = "2";
	text8.value = varItemDiscountRupees;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "right";
	td8.appendChild (text8);
	tr.appendChild (td8);





	//var td81 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td81 = document.createElement ('td');
	td81.id = "idTD3"+k+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+k+'" value="'+varItemTaxPercent+'" id="discountrupees'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text81 = document.createElement ('input');
	text81.id = "taxpercent"+k+"";
	text81.name = "taxpercent"+k+"";
	text81.type = "text";
	text81.size = "3";
	text81.value = varItemTaxPercent;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "right";
	//var text82 = document.createElement ('<input type="hidden"  name="taxautonumber'+k+'" value="'+varItemTaxAnum+'" id="itemtaxautonumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text82 = document.createElement ('input');
	text82.id = "taxautonumber"+k+"";
	text82.name = "taxautonumber"+k+"";
	text82.type = "hidden";
	text82.size = "3";
	text82.value = varItemTaxAnum;
	text82.readOnly = "readonly";
	text82.style.backgroundColor = "#FFFFFF";
	text82.style.border = "0px solid #001E6A";
	text82.style.textAlign = "right";
	//var text83 = document.createElement ('<input type="hidden"  name="taxname'+k+'" value="'+varItemTaxName+'" id="itemtaxname'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text83 = document.createElement ('input');
	text83.id = "taxname"+k+"";
	text83.name = "taxname"+k+"";
	text83.type = "hidden";
	text83.size = "3";
	text83.value = varItemTaxName;
	text83.readOnly = "readonly";
	text83.style.backgroundColor = "#FFFFFF";
	text83.style.border = "0px solid #001E6A";
	text83.style.textAlign = "right";
	td81.appendChild (text81);
	td81.appendChild (text82);
	td81.appendChild (text83);
	tr.appendChild (td81);







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
	text9.size = "8";
	text9.value = varItemTotalAmount;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "right";
	td9.appendChild (text9);
	tr.appendChild (td9);
	



	
	

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
	if (varItemDescription != "")
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
	document.getElementById("itemcode").value = "";
	document.getElementById("itemname").value = "";
	document.getElementById("itemdescription").value = "";
	document.getElementById("itemmrp").value = "0.00";
	document.getElementById("itemquantity").value = "1";
	document.getElementById("itemdiscountpercent").value = "0.00";
	document.getElementById("itemdiscountrupees").value = "0.00";
	document.getElementById("itemtaxpercent").value = "0.00";
	document.getElementById("itemtaxautonumber").value = "";
	document.getElementById("itemtaxname").value = "";
	document.getElementById("itemtotalamount").value = "0.00";
	document.getElementById("itemcode").focus();
	
	funcSubTotalCalc(); //function from purchase1.php
	paymentinfo(); // to reset payment method if it is selected.

	window.scrollBy(0,25); 
}