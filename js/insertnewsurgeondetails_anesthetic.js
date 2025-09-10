// JavaScript Document// JavaScript Document

function insertitem_anesthetic()

{
	if(document.form1.referalcode_anesthetic.value=="")
	{
		alert("Please select doctor name");
		document.getElementById("referal_anesthetic").value="";
		document.form1.referal.focus();
		return false;
	}
	
	
	var varSerialNumber41 = document.getElementById("serialnumber_anesthetic").value;
	var varreferal = document.getElementById("referal_anesthetic").value;
	var varrefRate = document.getElementById("rate4_anesthetic").value;
	var varreferalcode = document.getElementById("referalcode_anesthetic").value;
	var vardescription = document.getElementById("description_anesthetic").value;
	var vardescriptioncode = document.getElementById("descriptioncode_anesthetic").value;
	
	var vartotal=0;
	var varrefRate= parseFloat(document.getElementById("rate4_anesthetic").value);
	var vartotal= parseFloat(document.getElementById("total_anthe").value);
	//alert(vartotal);
	vartotal=vartotal+varrefRate;
	document.getElementById("total_anthe").value=vartotal.toFixed(2);
	
	
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	var n = varSerialNumber4;
	//alert(n);
	var tr = document.createElement ('TR');
	tr.id = "idTR_anesthetic"+n+"";
	var td1 = document.createElement ('td');
	td1.id = "serialnumber_anesthetic"+n+"";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	var text1 = document.createElement ('input');
	text1.id = "serialnumber_anesthetic"+n+"";
	text1.name = "serialnumber_anesthetic"+n+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber4;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	
	var text11 = document.createElement ('input');
	text11.id = "referal_anesthetic"+n+"";
	text11.name = "referal_anesthetic[]"+n+"";
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


	var td8 = document.createElement ('td');
	td8.id = "rate4_anestheti"+n+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate4_anesthetic"+n+"";
	text8.name = "rate4_anesthetic[]"+n+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varrefRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td32 = document.createElement ('td');
	td32.id = "description_anesthetic"+n+"";
	td32.align = "left";
	td32.valign = "top";
	td32.style.backgroundColor = "#FFFFFF";
	td32.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text32 = document.createElement ('input');
	text32.id = "description_anesthetic"+n+"";
	text32.name = "description_anesthetic[]"+n+"";
	text32.type = "text";
	text32.size = "28";
	text32.value = vardescription;
	text32.readOnly = "readonly";
	text32.style.backgroundColor = "#FFFFFF";
	text32.style.border = "0px solid #001E6A";
	text32.style.textAlign = "left";
	td32.appendChild (text32);
	tr.appendChild (td32);

	var td18 = document.createElement ('td');
	td18.id = "referalcode_anesthetic"+n+"";
	td18.align = "left";
	td18.valign = "top";
	td18.style.backgroundColor = "#FFFFFF";
	td18.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text18 = document.createElement ('input');
	text18.id = "referalcode_anesthetic"+n+"";
	text18.name = "referalcode_anesthetic[]"+n+"";
	text18.type = "hidden";
	text18.size = "8";
	text18.value = varreferalcode;
	text18.readOnly = "readonly";
	text18.style.backgroundColor = "#FFFFFF";
	text18.style.border = "0px solid #001E6A";
	text18.style.textAlign = "left";
	td18.appendChild (text18);
	tr.appendChild (td18);
	
	var td17 = document.createElement ('td');
	td17.id = "descriptioncode"+n+"";
	td17.align = "left";
	td17.valign = "top";
	td17.style.backgroundColor = "#FFFFFF";
	td17.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text17 = document.createElement ('input');
	text17.id = "descriptioncode_anesthetic"+n+"";
	text17.name = "descriptioncode_anesthetic[]"+n+"";
	text17.type = "hidden";
	text17.size = "8";
	text17.value = vardescriptioncode;
	text17.readOnly = "readonly";
	text17.style.backgroundColor = "#FFFFFF";
	text17.style.border = "0px solid #001E6A";
	text17.style.textAlign = "left";
	td17.appendChild (text17);
	tr.appendChild (td17);


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
	text11.onclick = function() { return btnDeleteClick_anesthetic(n); }
	td10.appendChild (text11);
	tr.appendChild (td10);

	
    document.getElementById ('insertrow_anesthetic').appendChild (tr);
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber_anesthetic").value = parseInt(n) + 1;

	var varreferal = document.getElementById("referal_anesthetic").value = '';
	var varrefRate = document.getElementById("rate4_anesthetic").value = '';
	var vardescription = document.getElementById("description_anesthetic").value = '';
	var vardescriptioncode = document.getElementById("referalcode_anesthetic").value = '';
	document.getElementById("referal").focus();

	window.scrollBy(0,5); 
	return true;
}