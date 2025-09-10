// JavaScript Document// JavaScript Document
function insertitem3()
{
	if(document.form1.radiology.value=="")
	{
		alert("Please enter radiology name");
		document.form1.radiology.focus();
		return false;
	}
	if(document.form1.rate8.value=="")
	{
		alert("Please enter rate");
		document.form1.rate8.focus();
		return false;
	}
	var varSerialNumber21 = document.getElementById("serialnumber2").value;
	//alert(varSerialNumber21);
	var varRadiology = document.getElementById("radiology").value;
	
	var varradRate = document.getElementById("rate8").value;
	
	var varr=Number(varradRate.replace(/[^0-9\.]+/g,""));
	var varSerialNumber2=varSerialNumber21+41;
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
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
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
	text8.value = formatMoney(varr);
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
	text11.onclick = function() { return btnDeleteClick5(k,varr); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber2").value = parseInt(k) + 1;
	
		if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
		
	total2=document.getElementById('total2').value;
	totalamount2=Number(total2.replace(/[^0-9\.]+/g,""));
	}
	
	
	totalamount2=parseFloat(totalamount2) + parseFloat(varr);
	document.getElementById("total2").value=formatMoney(totalamount2);
	
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	total=document.getElementById('total').value;
	totalamount=Number(total.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	total1=document.getElementById('total1').value;
	totalamount1=Number(total1.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	total3=document.getElementById('total3').value;
	totalamount3=Number(total3.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	total4=document.getElementById('total5').value;
	totalamount4=Number(total4.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalr=document.getElementById('totalr').value;
	totalamountr=Number(totalr.replace(/[^0-9\.]+/g,""));
	}
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	
	
	
	var varLab = document.getElementById("radiology").value = "";
	var varRate = document.getElementById("rate8").value = "";
	
	document.getElementById("radiology").focus();
	
	window.scrollBy(0,5); 
	return true;

}