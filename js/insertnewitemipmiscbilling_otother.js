// JavaScript Document// JavaScript Document

function insertitem6()
{
	if(document.form1.searchaccountcode.value=="")
	{
		alert("Please select valid account");
		document.form1.searchaccountname.value=="";
		document.form1.searchaccountname.focus();
		return false;  
	}
	if(document.form1.referal_otother.value=="")
	{
		alert("Please enter referal_otother name");
		document.form1.referal_otother.focus();
		return false;
	}
	if(document.form1.units.value=="")
	{
		alert("Please enter unit");
		document.form1.units.focus();
		return false;
	}
	if(document.form1.rate4_otother.value=="")
	{
		alert("Please enter rate");
		document.form1.rate4_otother.focus();
		return false;
	}
	if(document.form1.amount_otother.value=="")
	{
		alert("Please enter amount");
		document.form1.amount_otother.focus();
		return false;
	}
	var scode=document.getElementById("scode").value;
	scode=parseInt(scode)+1;
	document.getElementById("scode").value=scode;
	var varSerialNumber41 = document.getElementById("serialnumber6").value;
	var varreferal = document.getElementById("referal_otother").value;
	var varrefRate = document.getElementById("rate4_otother").value;
	var varunits = document.getElementById("units").value;
	var varamount = document.getElementById("amount_otother").value;
	var varaccountname= document.getElementById("searchaccountname").value;
	var varaccountcode= document.getElementById("searchaccountcode").value;
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
	
	var vartotal=0;
	var varrefRate= parseFloat(document.getElementById("rate4_otother").value);
	var vartotal= parseFloat(document.getElementById("total_otother").value);
	//alert(vartotal);
	vartotal=vartotal+varrefRate;
	document.getElementById("total_otother").value=vartotal.toFixed(2);

	var n = varSerialNumber4;
	//alert(n);
	var tr = document.createElement ('TR');
	tr.id = "idTR_otother"+n+"";
	var td1 = document.createElement ('td');
	td1.id = "serialnumber6"+n+"";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	var text1 = document.createElement ('input');
	text1.id = "serialnumber6"+n+"";
	text1.name = "serialnumber6"+n+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber4;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	var text11 = document.createElement ('input');
	text11.id = "accountname_otother"+n+"";
	text11.name = "accountname_otother[]"+n+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "32";
	text11.value = varaccountname;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	
	var text011 = document.createElement ('input');
	text011.id = "accountcode_otother"+n+"";
	text011.name = "accountcode_otother[]"+n+"";
	text011.type = "hidden";
	text011.align = "left";
	text011.size = "32";
	text011.value = varaccountcode;
	text011.readOnly = "readonly";
	text011.style.backgroundColor = "#FFFFFF";
	text011.style.border = "0px solid #001E6A";
	text011.style.textAlign = "left";
	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text011);
	tr.appendChild (td1);

	var td2 = document.createElement ('td');
	td2.id = "referal_otother"+n+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	var text21 = document.createElement ('input');
	text21.id = "referal_otother"+n+"";
	text21.name = "referal_otother[]"+n+"";
	text21.type = "text";
	text21.align = "left";
	text21.size = "32";
	text21.value = varreferal;
	text21.readOnly = "readonly";
	text21.style.backgroundColor = "#FFFFFF";
	text21.style.border = "0px solid #001E6A";
	text21.style.textAlign = "left";
	td2.appendChild (text21);
	tr.appendChild (td2);

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
	td8.id = "rate4_otother"+n+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; textalign:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate4_otother"+n+"";
	text8.name = "rate4_otother[]"+n+"";
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
	td7.id = "amount_otothe"+n+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "amount_otother"+n+"";
	text7.name = "amount_otother[]"+n+"";
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
	td10.id = "btndelete6"+n+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	var text11 = document.createElement ('input');
	text11.id = "btndelete6"+n+"";
	text11.name = "btndelete6"+n+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick6(n); }
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow_otother').appendChild (tr);
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber6").value = parseInt(n) + 1;

	var varreferal = document.getElementById("referal_otother").value = '';
	var varrefRate = document.getElementById("rate4_otother").value = '';
	var varunits = document.getElementById("units").value = '';
	var varamount = document.getElementById("amount_otother").value = '';
	document.getElementById("searchaccountname").value = '';
	document.getElementById("searchaccountname").focus();

	window.scrollBy(0,5); 
	return true;
}