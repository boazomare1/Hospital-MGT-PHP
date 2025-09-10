function insertitem10()
{
	
	
	if(document.cbform1.medicinename.value=="" )
	{
		alert("Please enter medicine name");
		return false;
	}
	
	if(document.cbform1.medicinename.value=="undefined" )
	{
		alert("Please select medicine name");
		return false;
	}
	if(document.cbform1.medicinecode.value=="" )
	{
		alert("Please select medicinename from the List");
		return false;
	}
	if(document.cbform1.reqquantity.value=="" )
	{
		alert("Please enter the Required Qty");
		return false;
	}
	if(document.getElementById("toavlquantity").value=="0" )
	{
		alert("To Store Available Quantity Required");
		return false;
	}
	if(document.cbform1.fromstorecode.value=="" )
	{
		alert("Please Check that Item has Mapped to Purchase type Or Not");
		return false;
	}
	if(document.cbform1.tostorecode.value=="" )
	{
		alert("Please Check that Item has Mapped to Purchase type Or Not");
		return false;
	}
	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
	var varMedicineCode = document.getElementById("medicinecode").value;
	
	var varAvlQuantity = document.getElementById("avlquantity").value;
	var varToAvlQuantity = document.getElementById("toavlquantity").value;
	var varReqQuantity = document.getElementById("reqquantity").value;
	
	var varFromStore = document.getElementById("fromstore").value;
	var varFromStoreCode = document.getElementById("fromstorecode").value;
	var varToStore = document.getElementById("tostore").value;
	var varToStoreCode = document.getElementById("tostorecode").value;
		//alert(varpharmRate);
	
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
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text11 = document.createElement ('input');
	text11.id = "medicinename"+i+"";
	text11.name = "medicinename"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "35";
	text11.value = varMedicineName;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	var text112 = document.createElement ('input');
	text112.id = "medicinecode"+i+"";
	text112.name = "medicinecode"+i+"";
	text112.type = "hidden";
	text112.align = "left";
	text112.size = "25";
	text112.value = varMedicineCode;
	text112.readOnly = "readonly";
	text112.style.backgroundColor = "#FFFFFF";
	text112.style.border = "0px solid #001E6A";
	text112.style.textAlign = "left";
	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text112);
	tr.appendChild (td1);
	
	
	
	//from store
	
	var td2 = document.createElement ('td');
	//td1.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text12 = document.createElement ('input');
	text12.id = "fromstore"+i+"";
	text12.name = "fromstore"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "23";
	text12.value = varFromStore;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	var text122 = document.createElement ('input');
	text122.id = "fromstorecode"+i+"";
	text122.name = "fromstorecode"+i+"";
	text122.type = "hidden";
	text122.align = "left";
	text122.size = "25";
	text122.value = varFromStoreCode;
	text122.readOnly = "readonly";
	text122.style.backgroundColor = "#FFFFFF";
	text122.style.border = "0px solid #001E6A";
	text122.style.textAlign = "left";
	td2.appendChild (text12);
	td2.appendChild (text122);
	tr.appendChild (td2);
	
	//end from store
	
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	
	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "avlquantity"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "avlquantity"+i+"";
	text3.name = "avlquantity"+i+"";
	text3.type = "text";
	text3.size = "8";
	text3.value = varAvlQuantity;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	
	
	//from store
	
	var td4 = document.createElement ('td');
	td4.id = "tostore"+i+"";
	//td1.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	var text121 = document.createElement ('input');
	text121.id = "tostore"+i+"";
	text121.name = "tostore"+i+"";
	text121.type = "text";
	text121.align = "left";
	text121.size = "24";
	text121.value = varToStore;
	text121.readOnly = "readonly";
	text121.style.backgroundColor = "#FFFFFF";
	text121.style.border = "0px solid #001E6A";
	text121.style.textAlign = "left";
	var text123 = document.createElement ('input');
	text123.id = "tostorecode"+i+"";
	text123.name = "tostorecode"+i+"";
	text123.type = "hidden";
	text123.align = "left";
	text123.size = "25";
	text123.value = varToStoreCode;
	text123.readOnly = "readonly";
	text123.style.backgroundColor = "#FFFFFF";
	text123.style.border = "0px solid #001E6A";
	text123.style.textAlign = "left";
	td4.appendChild (text121);
	td4.appendChild (text123);
	tr.appendChild (td4);
	
	//end from store
	
	var td8 = document.createElement ('td');
	td8.id = "toavlquantity"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text51 = document.createElement ('input');
	text51.id = "toavlquantity"+i+"";
	text51.name = "toavlquantity"+i+"";
	text51.type = "text";
	text51.size = "7";
	text51.value = varToAvlQuantity;
	text51.readOnly = "readonly";
	text51.style.backgroundColor = "#FFFFFF";
	text51.style.border = "0px solid #001E6A";
	text51.style.textAlign = "left";
	td8.appendChild (text51);
	tr.appendChild (td8);
	
	
	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "reqquantity"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "reqquantity"+i+"";
	text5.name = "reqquantity"+i+"";
	text5.type = "text";
	text5.size = "8";
	text5.value = varReqQuantity;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);
	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	
	

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
	
	
	var varAvlQuantity = document.getElementById("avlquantity").value = "";
	var varReqQuantity = document.getElementById("reqquantity").value = "";
	var vartoavlquantity = document.getElementById("toavlquantity").value = "";
	
	var vartoavlquantity = document.getElementById("fromstore").value = "";
	var vartoavlquantity = document.getElementById("fromstorecode").value = "";
	var vartoavlquantity = document.getElementById("tostore").value = "";
	var vartoavlquantity = document.getElementById("tostorecode").value = "";
	
	
	document.getElementById("medicinename").focus();
	
	window.scrollBy(0,5); 
	return true;
}