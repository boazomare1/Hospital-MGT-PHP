// JavaScript Document// JavaScript Document
function insertitem3()
{
	if(document.form1.radiology.value=="")
	{
		alert("Please enter radiology name");
		document.form1.radiology.focus();
		return false;
	}		if(document.form1.radiologycode.value=="")
	{
		alert("Please select radiology name properly");
		document.form1.radiology.focus();
		return false;
	}
	if(document.form1.rate8.value=="")
	{
		alert("Please enter rate");
		document.form1.rate8.focus();
		return false;
	}
	var varSerialNumber21 = document.getElementById("serialnumber27").value;
	//alert(varSerialNumber21);		var radcode = document.getElementById("radiologycode").value;
	var varRadiology = document.getElementById("radiology").value;
	var varradRate = document.getElementById("rate8").value;
	var varSerialNumber2=parseInt(varSerialNumber21)+41;
	//alert(varRate);
	var k = varSerialNumber2;
	//alert(k);

	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";
	
	var td1 = document.createElement ('td');
	td1.id = "radiology"+k+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber2"+k+"";
	text1.name = "serialnumber2"+k+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";					 var text112 = document.createElement ('input');	text112.id = "raditemcode"+k+"";	text112.name = "raditemcode[]"+k+"";	text112.type = "hidden";	text112.align = "left";	text112.size = "50";	text112.value = radcode;	text112.readOnly = "readonly";	text112.style.backgroundColor = "#FFFFFF";	text112.style.border = "0px solid #001E6A";	text112.style.textAlign = "left";	
	td1.appendChild (text112);	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "radiology"+k+"";
	text11.name = "radiology[]"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varRadiology;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);	
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate8"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate8"+k+"";
	text8.name = "rate8[]"+k+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varradRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+k+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+k+"";
	text11.name = "btndelete5"+k+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick5(k,varradRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber27").value = parseInt(k) + 1;
	
		if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	
	
	totalamount2=parseInt(totalamount2) + parseInt(varradRate);
	document.getElementById("total2").value=totalamount2.toFixed(2);
	
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	
	
	grandtotal= parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);

	var varLab = document.getElementById("radiology").value = "";
	document.getElementById("radiologycode").value = "";		var varRate = document.getElementById("rate8").value = "";
	
	document.getElementById("radiology").focus();
	
	window.scrollBy(0,5); 
	return true;

}