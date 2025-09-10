function insertitem14()
{
	
	if(document.getElementById("sername").value=="")
	{
		alert("Please enter ser name");
		document.cbform1.sername.focus();
		return false;
	}

	if(document.getElementById("sercode").value=="")
	{
		alert("Please Select ser name From the list");
		document.cbform1.sername.focus();
		return false;
	}


	
	var varSerialNumber = document.getElementById("serialnumbers").value;
	var varserName = document.getElementById("sername").value;
	var varserRate = document.getElementById("serrate").value
	var varserCode = document.getElementById("sercode").value;
	
	
	
		//alert(varpharmRate);
	

	var i = varSerialNumber;
	
	//alert(i);
	//alert (varserName);
	//alert (i);
	//var tr = document.createElement ('<TR id="idTR'+i+'"></TR>');
	var tr = document.createElement ('TR');
	tr.id = "idserTR"+i+"";
	
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


	var text11 = document.createElement ('input');
	text11.id = "sercode"+i+"";
	text11.name = "sercode"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varserCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text12 = document.createElement ('input');
	text12.id = "sername"+i+"";
	text12.name = "sername"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "25";
	text12.value = varserName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	//td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	tr.appendChild (td1);
	
	
	
	var td2 = document.createElement ('td');
	td2.id = "serrate"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "serrate"+i+"";
	text2.name = "serrate"+i+"";
	text2.type = "text";
	text2.size = "16";
	text2.value = varserRate;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "right";
	td2.appendChild (text2);
	tr.appendChild (td2);
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
//	var td3 = document.createElement ('td');
//	td3.id = "quantity"+i+"";
//	td3.align = "left";
//	td3.valign = "top";
//	td3.style.backgroundColor = "#FFFFFF";
//	td3.style.border = "0px solid #001E6A";
//	var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
//	var text3 = document.createElement ('input');
//	text3.id = "quantity"+i+"";
//	text3.name = "quantity"+i+"";
//	text3.type = "text";
//	text3.size = "16";
//	text3.value = Quantity;
//	text3.readOnly = "readonly";
//	text3.style.backgroundColor = "#FFFFFF";
//	text3.style.border = "0px solid #001E6A";
//	text3.style.textAlign = "left";
//	td3.appendChild (text3);
//	tr.appendChild (td3);



	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "btndeleteser"+i+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndeleteser"+i+"";
	text11.name = "btndeleteser"+i+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick14(i); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumbers").value = parseInt(i) + 1;

	var varserName = document.getElementById("sername").value = "";
	var varserName = document.getElementById("sercode").value = "";
	document.getElementById("searchser1hiddentextbox").value = "";
	document.getElementById("searchseranum1").value = "";
	var Quantity = document.getElementById("serrate").value = "";
	document.getElementById("sername").focus();
	
	window.scrollBy(0,5); 
	return true;

}
