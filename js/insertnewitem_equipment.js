// JavaScript Document// JavaScript Document
function insertitem3()
{
	if(document.form1.equipment.value=="")
	{
		alert("Please enter equipment name");
		document.form1.equipment.focus();
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
    //var varequipmentinstructions = document.getElementById("equipmentinstructions").value;

	var varequipment = document.getElementById("hiddenequipment").value;
	var varr = document.getElementById("rate8").value;
	var varradRate=Number(varr.replace(/[^0-9\.]+/g,""));
	var varSerialNumber2=varSerialNumber21+41;
	//alert(varRate);
	var k = varSerialNumber2;
	//alert(k);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";
	
	var td1 = document.createElement ('td');
	td1.id = "equipment"+k+"";
	
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
	text11.id = "equipment"+k+"";
	text11.name = "equipment[]"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varequipment;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);

	var td71 = document.createElement ('td');
	td71.id = "equip"+k+"";
	td71.align = "left";
	td71.valign = "top";
	td71.style.backgroundColor = "#FFFFFF";
	td71.style.border = "0px solid #001E6A";
	//var text71 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text71 = document.createElement ('input');
	text71.id = "equip"+k+"";
	text71.name = "equip[]";
	text71.type = "text";
	text71.size = "20";
	text71.value = '';
	text71.readOnly = "readonly";
	text71.style.display = "none";
	text71.style.backgroundColor = "#FFFFFF";
	text71.style.border = "0px solid #001E6A";
	text71.style.textAlign = "left";
	td71.appendChild (text71);
	tr.appendChild (td71);
	
	
	/*
    var td71 = document.createElement ('td');
	td71.id = "equipmentinstructions"+k+"";
	td71.align = "left";
	td71.valign = "top";
	td71.style.backgroundColor = "#FFFFFF";
	td71.style.border = "0px solid #001E6A";
	//var text71 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text71 = document.createElement ('input');
	text71.id = "equipmentinstructions"+k+"";
	text71.name = "equipmentinstructions[]"+k+"";
	text71.type = "text";
	text71.size = "20";
	text71.value = varequipmentinstructions;
	text71.readOnly = "readonly";
	text71.style.backgroundColor = "#FFFFFF";
	text71.style.border = "0px solid #001E6A";
	text71.style.textAlign = "left";
	td71.appendChild (text71);
	tr.appendChild (td71);
	*/
	
	
	/*
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
	text8.value = formatMoney(varradRate);
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	*/
	
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
	
	
	totalamount2=parseFloat(totalamount2) + parseFloat(varradRate);
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
	
	
	//var varInstructions = document.getElementById("equipmentinstructions").value = "";

	var varLab = document.getElementById("equipment").value = "";
	var varLab = document.getElementById("hiddenequipment").value = "";
	var varRate = document.getElementById("rate8").value = "";
	
	document.getElementById("equipment").focus();
	
	window.scrollBy(0,5); 
	return true;

}