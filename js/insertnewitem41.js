function insertitem10()
{
	
	if(document.cbform1.medicinename.value=="")
	{
		alert("Please enter medicine name");
		document.cbform1.medicinename.focus();
		return false;
	}

	if(document.cbform1.salesrate.value<=0 || document.cbform1.salesrate.value=='')
	{
		alert("Cost price can not be zero.");
		document.cbform1.salesrate.focus();
		return false;
	}

	
	if(document.cbform1.store.value=="")
	{
		alert("Please select store name");
		document.cbform1.store.focus();
		return false;
	}

	if(document.cbform1.quantity.value=="")
	{
		alert("Please enter quantity");
		document.getElementById("quantity").focus();
		return false;
	}

	if(document.cbform1.batch.value=="")
	{
		alert("Please enter batch");
		document.getElementById("batch").focus();
		return false;
	}
	
	var varItemExpiryDate = document.getElementById("expirydate").value;
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
	if (varItemExpiryDateYear < 20 || varItemExpiryDateYear > 30)
	{
		alert ("Expiry Year Should Be Between 2020 And 2030.");
		document.getElementById("expirydate").focus();
		return false;
	}

	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
	var varSalesrate = document.getElementById("salesrate").value;
	var varMedicinecode = document.getElementById("medicinecode").value;
	if(varMedicinecode == '')
	{
		alert("Please Select an Item");
		return false;
	}
	var varBatch = document.getElementById("batch").value;
	var varQuantity = document.getElementById("quantity").value;
		//alert(varpharmRate);
	var varExpdate = document.getElementById("expirydate").value;

	var i = varSerialNumber;
	
	//alert(i);
	//alert (varMedicineName);
	//alert (i);
	//var tr = document.createElement ('<TR id="idTR'+i+'"></TR>');
	var tr = document.createElement ('TR');
	tr.id = "idTR"+i+"";
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "serialnumber"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+i+"";
	text1.name = "serialnumber"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text11 = document.createElement ('input');
	text11.id = "medicinename"+i+"";
	text11.name = "medicinename"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varMedicineName;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "salesrate"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "salesrate"+i+"";
	text2.name = "salesrate"+i+"";
	text2.type = "text";
	text2.size = "8";
	text2.value = varSalesrate;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);
	

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "quantity"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "quantity"+i+"";
	text3.name = "quantity"+i+"";
	text3.type = "text";
	text3.size = "16";
	text3.value = varQuantity;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);


	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "batch"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "batch"+i+"";
	text5.name = "batch"+i+"";
	text5.type = "text";
	text5.size = "8";
	text5.value = varBatch;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);


	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td7 = document.createElement ('td');
	td7.id = "expirydate"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "expirydate"+i+"";
	text7.name = "expirydate"+i+"";
	text7.type = "text";
	text7.size = "20";
	text7.value = varExpdate;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);
	
	var td8 = document.createElement ('td');
	td8.id = "medicinecode"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "medicinecode"+i+"";
	text8.name = "medicinecode"+i+"";
	text8.type = "text";
	text8.size = "20";
	text8.value = varMedicinecode;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);


	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "btndelete"+i+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete"+i+"";
	text11.name = "btndelete"+i+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick10(i); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	
	
	
	var varMedicineName = document.getElementById("medicinename").value = "";
	var varSalesrate = document.getElementById("salesrate").value = "";
	var varQuantity = document.getElementById("quantity").value = "";
	var varBatch = document.getElementById("batch").value = "";
	var varExpdate = document.getElementById("expirydate").value = "";
	var varMedicinecode = document.getElementById("medicinecode").value = "";
	document.getElementById("codevalue").value = "1";
	

	
	document.getElementById("medicinename").focus();
	
	window.scrollBy(0,5); 
	return true;

}
