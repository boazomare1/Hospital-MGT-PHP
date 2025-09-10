function insertitem65()
{
//alert('h');
	if(document.form1.medicinename.value=="")
	{
		alert("Please enter medicine name");
		document.form1.medicinename.focus();
		return false;
	}

	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
		var varQuantity = document.getElementById("quantity").value;
	
	var varpharmRate = document.getElementById("rate").value;
	//alert(varpharmRate);
	var varpharmAmount = document.getElementById("amount").value;
 
//alert(document.getElementById("rate").value);	
/*
	if (varSerialNumber == "")
	{
	var i = parseInt(1);	
	}
	else
	{
	 i = parseInt(varSerialNumber)+parseInt(1);
	}
	*/
	
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
	text11.size = "45";
	text11.value = varMedicineName;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	



	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "quantity"+i+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text6 = document.createElement ('input');
	text6.id = "quantity"+i+"";
	text6.name = "quantity"+i+"";
	text6.type = "text";
	text6.size = "4";
	text6.value = varQuantity;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "left";
	td6.appendChild (text6);
	tr.appendChild (td6);


	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "rate"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate"+i+"";
	text8.name = "rate"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varpharmRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);


	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td81 = document.createElement ('td');
	td81.id = "amount"+i+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text81 = document.createElement ('input');
	text81.id = "amount"+i+"";
	text81.name = "amount"+i+"";
	text81.type = "text";
	text81.size = "8";
	text81.value = varpharmAmount;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "left";
	td81.appendChild (text81);
	tr.appendChild (td81);
	
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
	text11.onclick = function() { return btnDeleteClick(i,varpharmAmount); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	totalamount=document.getElementById('total').value;
	}
	
	
	totalamount=parseFloat(totalamount) + parseFloat(varpharmAmount);
	totalamount = totalamount.toFixed(2);
	//alert(totalamount);
	document.getElementById("total").value=totalamount;
	
	
	document.getElementById("subtotal").value=totalamount;
	 //alert('h');
		document.getElementById("totalamount").value=totalamount;
		document.getElementById("tdShowTotal").innerHTML=totalamount;

	var varMedicineName = document.getElementById("medicinename").value = "";
	var varQuantity = document.getElementById("quantity").value = "";
	
	var varRate = document.getElementById("rate").value = "";
	var varAmount = document.getElementById("amount").value = "";
	

	
	document.getElementById("medicinename").focus();
	
	window.scrollBy(0,5); 
	return true;

}


