// JavaScript Document// JavaScript Document
function insertitem5()
{
	
	if(document.form1.referalcode.value=="")
	{
		alert("Please select doctor name");
		document.getElementById("referal").value="";
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
	
	var varrefRate_new=0;
	var varavailableamount = Number(document.getElementById("availableamount").value.replace(/[^0-9\.]+/g,""));
	var varavailableamount_new = document.getElementById("availableamount").value.replace(/\,/g,'');
	var billtypes = document.getElementById("billtypes").value;
	var varSerialNumber41 = document.getElementById("serialnumber4").value;
	var varreferal = document.getElementById("referal").value;
	var varrefRate = document.getElementById("rate4").value;
	varrefRate_new = document.getElementById("rate4").value;
	var varunits = document.getElementById("units").value;
	var varamount =Number(document.getElementById("amount").value.replace(/[^0-9\.]+/g,""));
	var varreferalcode = document.getElementById("referalcode").value;
	var vardescriptioncode = document.getElementById("descriptioncode").value;
	var vardescription = document.getElementById("description").value;
	
	var iptot=0
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
	if(document.getElementById('total_amt').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=Number(document.getElementById("total_amt").value.replace(/[^0-9\.]+/g,""));
	}
	
	totalamount1=parseFloat(totalamount2) + parseFloat(varamount);
	
	/*if(varavailableamount_new<='0.00'){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;	
	}
   
	if(varavailableamount<totalamount1){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;
	}*/
	
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
	text11.id = "referal1"+n+"";
	text11.name = "referal1[]"+n+"";
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
	
	var td32 = document.createElement ('td');
	td32.id = "description"+n+"";
	td32.align = "left";
	td32.valign = "top";
	td32.style.backgroundColor = "#FFFFFF";
	td32.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text32 = document.createElement ('input');
	text32.id = "description"+n+"";
	text32.name = "description[]"+n+"";
	text32.type = "text";
	text32.size = "28";
	text32.value = vardescription;
	text32.readOnly = "readonly";
	text32.style.backgroundColor = "#FFFFFF";
	text32.style.border = "0px solid #001E6A";
	text32.style.textAlign = "left";
	td32.appendChild (text32);
	tr.appendChild (td32);
	
	
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
	
	var td17 = document.createElement ('td');
	td17.id = "descriptioncode"+n+"";
	td17.align = "left";
	td17.valign = "top";
	td17.style.backgroundColor = "#FFFFFF";
	td17.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text17 = document.createElement ('input');
	text17.id = "descriptioncode"+n+"";
	text17.name = "descriptioncode[]"+n+"";
	text17.type = "text";
	text17.size = "8";
	text17.value = vardescriptioncode;
	text17.readOnly = "readonly";
	text17.style.backgroundColor = "#FFFFFF";
	text17.style.border = "0px solid #001E6A";
	text17.style.textAlign = "left";
	td17.appendChild (text17);
	tr.appendChild (td17);
	
	var td18 = document.createElement ('td');
	td18.id = "referalcode"+n+"";
	td18.align = "left";
	td18.valign = "top";
	td18.style.backgroundColor = "#FFFFFF";
	td18.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text18 = document.createElement ('input');
	text18.id = "referalcode"+n+"";
	text18.name = "referalcode[]"+n+"";
	text18.type = "text";
	text18.size = "8";
	text18.value = varreferalcode;
	text18.readOnly = "referalcode";
	text18.style.backgroundColor = "#FFFFFF";
	text18.style.border = "0px solid #001E6A";
	text18.style.textAlign = "left";
	td18.appendChild (text18);
	tr.appendChild (td18);
	
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
	text11.onclick = function() { return btnDeleteClick4(n,varrefRate_new); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	
    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber4").value = parseInt(n) + 1;
	
	document.getElementById("total_amt").value=formatMoney(totalamount1);
	document.getElementById("grand_total").value=formatMoney(totalamount1);
	document.getElementById("availableamount_org").value=formatMoney(parseFloat(varavailableamount)-totalamount1);
	
	if(totalamount1>0)
	{
		
	var button = document.getElementById("Add4").style.display = 'none';

	}
	
	var varreferal = document.getElementById("referal").value = '';
	var varrefRate = document.getElementById("rate4").value = '';
	var varunits = document.getElementById("units").value = '1';
	var varamount = document.getElementById("amount").value = '';
	var vardescription = document.getElementById("description").value = '';
	var vardescription = document.getElementById("descriptioncode").value = '';
	var vardescriptioncode = document.getElementById("referalcode").value = '';
	document.getElementById("referal").focus();
	
	window.scrollBy(0,5); 
	return true;
}