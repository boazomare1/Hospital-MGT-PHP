// JavaScript Document// JavaScript Document
function insertitem5()
{
	
	if(document.form1.referal.value=="")
	{
		alert("Please enter description");
		document.form1.referal.focus();
		return false;
	}
	if(document.form1.units.value=="")
	{
		alert("Please enter unit");
		document.form1.units.focus();
		return false;
	}
	if(document.form1.rate4.value=="")
	{
		alert("Please enter rate");
		document.form1.rate4.focus();
		return false;
	}
	if(document.form1.amount.value=="")
	{
		alert("Please enter amount");
		document.form1.amount.focus();
		return false;
	}
	var varSerialNumber41 = document.getElementById("serialnumber4").value;
	var varreferal = document.getElementById("referal").value;
	var varrefRate = document.getElementById("rate4").value;
	var varunits = document.getElementById("units").value;
	var varamount = document.getElementById("amount").value;
	
	
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
	var n = varSerialNumber4;
	//alert(n);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+n+"";
	
	var td1 = document.createElement ('td');
	td1.id = "serialnumber4"+n+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber4"+n+"";
	text1.name = "serialnumber4"+n+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber4;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "referal"+n+"";
	text11.name = "referal[]"+n+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "32";
	text11.value = varreferal;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var td3 = document.createElement ('td');
	td3.id = "units"+n+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text3 = document.createElement ('input');
	text3.id = "units"+n+"";
	text3.name = "units[]"+n+"";
	text3.type = "text";
	text3.size = "8";
	text3.value = varunits;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate4"+n+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate4"+n+"";
	text8.name = "rate4[]"+n+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varrefRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td7 = document.createElement ('td');
	td7.id = "amount"+n+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "amount"+n+"";
	text7.name = "amount[]"+n+"";
	text7.type = "text";
	text7.size = "8";
	text7.value = varamount;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete4"+n+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete4"+n+"";
	text11.name = "btndelete4"+n+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick4(n); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	

    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber4").value = parseInt(n) + 1;
	
		
	
	var varreferal = document.getElementById("referal").value = '';
	var varrefRate = document.getElementById("rate4").value = '';
	var varunits = document.getElementById("units").value = '';
	var varamount = document.getElementById("amount").value = '';
	
	document.getElementById("referal").focus();
	
	window.scrollBy(0,5); 
	return true;

}