function insertitem1()
{
	//alert("Insert New Item.");
	if (document.getElementById("itemname").value == "")
	{
		alert ("Please Enter the Itemname To Continue.");
		document.getElementById("itemname").focus();
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
					var varExistingQuantity = document.getElementById('itemquantitys'+m).value;
					var varFinalQuantity = parseInt(varQuantityToUpdate) + parseInt(varExistingQuantity);
					//alert (varQuantityToUpdate+' + '+varExistingQuantity+' = '+varFinalQuantity);
					document.getElementById('itemquantitys'+m).value = varFinalQuantity;
					
					var varItemMRP = document.getElementById('rateperunit'+m).value;
					var varItemQuantity = document.getElementById('itemquantitys'+m).value;
					var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
					document.getElementById('totalamount'+m).value = varItemTotalAmount.toFixed(2);
					
					document.getElementById("itemname").value = "";
					document.getElementById("itemmrp").value = "0.00";
					document.getElementById("itemquantity").value = "1";
					document.getElementById("itemtotalquantity").value = "1";
					document.getElementById("itemtotalamount").value = "0.00";

					document.getElementById("itemname").focus();
					
					//funcSubTotalCalc(); //function from purchase1.php
					
					alert ("Item Quantity Update Completed.");
					return false;
					break;
				}
			}
		}
	}
	
	
	var varItemSerialNumber = document.getElementById("itemserialnumber").value;
	
	var varItemName = document.getElementById("itemname").value;
	var varItemName = varItemName.toUpperCase();
	
	var varItemMRP = document.getElementById("itemmrp").value;
	
	var varItemMRP = parseFloat(varItemMRP);
	var varItemMRP = varItemMRP.toFixed(2);
	
	var varItemQuantity = document.getElementById("itemquantity").value;
	
	var varItemTotalAmount = parseFloat(varItemMRP) * parseFloat(varItemQuantity);
	var varItemTotalAmount = varItemTotalAmount.toFixed(2);

	var varItemSubTotalAmount1 = document.getElementById("subtotal").value;
	
	var varItemSubTotalAmount = parseFloat(varItemSubTotalAmount1) + parseFloat(varItemTotalAmount);
	var varItemSubTotalAmount = varItemSubTotalAmount.toFixed(2);

	
	////alert (varItemSerialNumber);
	var k = parseInt(varItemSerialNumber);// + 1;
	//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";

		//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "idTD3"+k+"";
	td1.align = "left";
	td1.valign = "top";
	td1.width = "4%";
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
	text1.style.textAlign = "center";
	td1.appendChild (text1);
	tr.appendChild (td1);

	//var td3 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+k+"";
	td3.align = "left";
	td3.valign = "middle";
	td3.width = "40%";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+k+'" value="'+varItemName+'" size="50" id="itemname'+k+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "itemname"+k+"";
	text3.name = "itemname"+k+"";
	text3.type = "text";
	text3.size = "35";
	text3.value = varItemName;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);


	//var td5 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD3"+k+"";
	td5.align = "left";
	td5.valign = "middle";
	td5.width = "4%";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+k+'" value="'+varItemMRP+'" id="rateperunit'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "rateperunit"+k+"";
	text5.name = "rateperunit"+k+"";
	text5.type = "text";
	text5.size = "5";
	text5.value = varItemMRP;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "right";
	td5.appendChild (text5);
	tr.appendChild (td5);


	//var td6 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "idTD3"+k+"";
	td6.align = "left";
	td6.valign = "middle";
	td6.width = "7%";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+k+'" value="'+varItemQuantity+'" id="quantity'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text6 = document.createElement ('input');
	text6.id = "itemquantitys"+k+"";
	text6.name = "itemquantitys"+k+"";
	text6.type = "text";
	text6.size = "5";
	text6.value = varItemQuantity;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "right";
	td6.appendChild (text6);
	tr.appendChild (td6);


	//var td9 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td9 = document.createElement ('td');
	td9.id = "idTD3"+k+"";
	td9.align = "left";
	td9.valign = "middle";
	td9.width = "4%";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text9 = document.createElement ('<input name="totalamount'+k+'" value="'+varItemTotalAmount+'" id="totalamount'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="8" />');
	var text9 = document.createElement ('input');
	text9.id = "totalamount"+k+"";
	text9.name = "totalamount"+k+"";
	text9.type = "text";
	text9.size = "10";
	text9.value = varItemTotalAmount;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "right";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
//alert(varItemTotalAmount);


	//var td10 = document.createElement ('<td id="idTD3'+k+'" align="right" valign="middle" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "idTD3"+k+"";
	td10.align = "center";
	td10.valign = "middle";
	td10.width = "11%";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	var text10 = document.createElement ('input');
	text10.id = "btndelete"+k+"";
	text10.name = "btndelete"+k+"";
	text10.type = "button";
	text10.value = "Del";
	text10.style.border = "1px solid #001E6A";
	text10.onclick = function() { return btnDeleteClick(k); }
	
	td10.appendChild (text10);
	tr.appendChild (td10);

	document.getElementById ('tblrowinsert').appendChild (tr);



    document.getElementById("subtotal").value = varItemSubTotalAmount;
	//document.getElementById ('tblrowinsert').appendChild (tr);
	
	
	document.getElementById("itemserialnumber").value = k + 1;
	document.getElementById("itemname").value = "";
	document.getElementById("itemmrp").value = "0.00";
	document.getElementById("itemquantity").value = "1";
	document.getElementById("itemtotalamount").value = "0.00";

	
	//alert('h');
	document.getElementById("itemname").focus();
	
//	funcSubTotalCalc(); //function from purchase1.php
//	paymentinfo(); // to reset payment method if it is selected.

	window.scrollBy(0,25); 
}