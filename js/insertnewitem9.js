// JavaScript Document// JavaScript Document
function insertitem9()
{
	if(document.form1.referal.value=="")
	{
		alert("Please enter referal name");
		document.form1.referal.focus();
		return false;
	}
	if(document.form1.rate4.value=="")
	{
		alert("Please enter rate");
		document.form1.rate4.focus();
		return false;
	}
	
	var varSerialNumber4 = document.getElementById("serialnumber4").value;
	var varreferal = document.getElementById("referal").value;
	var varrefRate = document.getElementById("rate4").value;

	
	var n = varSerialNumber4;
	
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
	text11.size = "25";
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
	text11.onclick = function() { return btnDeleteClick11(n,varrefRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	

    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber4").value = parseInt(varSerialNumber4) + 1;
	
		if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	totalamount4=document.getElementById('total5').value;
	}
	
	
	
     
	//alert(vRate);
	totalamount4=parseInt(totalamount4) + parseInt(varrefRate);
	
	document.getElementById("total5").value=totalamount4.toFixed(2);
	

	
	
	
	var varLab = document.getElementById("referal").value = "";
	var varRate = document.getElementById("rate4").value = "";
	
	document.getElementById("referal").focus();
	
	window.scrollBy(0,5); 
	return true;

}