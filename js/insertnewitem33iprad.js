// JavaScript Document// JavaScript Document
var radiologycode=['1'];	
function insertitem3()
{
	if(document.getElementById("radiology").value=="")
	{
		alert("Please enter radiology name");
		document.getElementById("radiology").focus();
		return false;
	}
	
	if(document.getElementById("rate8").value=="")
	{
		alert("Please enter rate");
		document.getElementById("rate8").focus();
		return false;
	}
	if(document.getElementById("radiologyfree").value=="")
	{
		alert("Please enter free status");
		document.getElementById("radiologyfree").focus();
		return false;
	}
	
	var varradiologyfree = document.getElementById("radiologyfree").value;
	
	if(varradiologyfree == "no")
	{
		varradiologyfreename = 'No';
	}
	if(varradiologyfree == "yes")
	{
		varradiologyfreename = 'Yes';
	}
		
	// var varradiologyinstructions = document.getElementById("radiologyinstructions").value;
	
	var billtypes = document.getElementById("billtypes").value;
	
	var varavailableamount =Number(document.getElementById("availableamount").value.replace(/[^0-9\.]+/g,""));
	var varavailableamount_new = document.getElementById("availableamount").value.replace(/\,/g,'');

	var varSerialNumber21 = document.getElementById("serialnumber27").value;
	//alert(varSerialNumber21);
	var varRadiology = document.getElementById("radiology").value;
	var varRadiologycode = document.getElementById("radiologycode").value;
	var varradRate = document.getElementById("rate8").value;
	var varSerialNumber2=parseInt(varSerialNumber21)+41;
	//alert(varRate);
	var k = varSerialNumber2;
	//alert(k);
	
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=Number(document.getElementById('total2').value.replace(/[^0-9\.]+/g,""));
	}

	//totalamount2=parseInt(totalamount2) + parseInt(varradRate);

	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=Number(document.getElementById('total1').value.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=Number(document.getElementById('total3').value.replace(/[^0-9\.]+/g,""));
	}
	
	
	grandtotal= parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(varradRate);
	
	if(varavailableamount_new<='0.00'){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;	
	}
	
	if(varavailableamount<grandtotal){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;
	}
	
	var result = radiologycode.indexOf(varRadiologycode);
	console.log(result);
	
if(result>0){
 	alert('"The  item has already been added above. Please Click OK to continue to add other items"');
 	
 	document.getElementById("radiology").value = "";
 	document.getElementById("rate8").value = "";
 	document.getElementById("radiologyfree").value = "";

 }else{
radiologycode.push(varRadiologycode);
console.log(radiologycode);

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

	var text122 = document.createElement ('input');
	text122.id = "radiologycode"+k+"";
	text122.name = "radiologycode[]"+k+"";
	text122.type = "hidden";
	text122.size = "25";
	text122.value = varRadiologycode;
	text122.readOnly = "readonly";
	text122.style.backgroundColor = "#FFFFFF";
	text122.style.border = "0px solid #001E6A";
	text122.style.textAlign = "left";
	td1.appendChild (text122);
	
	
	var text11 = document.createElement ('input');
	text11.id = "radiology"+k+"";
	text11.name = "radiology[]"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "60";
	text11.value = varRadiology;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	// 	var td71 = document.createElement ('td');
	// td71.id = "radiologyinstructions"+k+"";
	// td71.align = "left";
	// td71.valign = "top";
	// td71.style.backgroundColor = "#FFFFFF";
	// td71.style.border = "0px solid #001E6A";
	// //var text71 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	// var text71 = document.createElement ('input');
	// text71.id = "radiologyinstructions"+k+"";
	// text71.name = "radiologyinstructions[]"+k+"";
	// text71.type = "text";
	// text71.size = "20";
	// text71.value = varradiologyinstructions;
	// text71.readOnly = "readonly";
	// text71.style.backgroundColor = "#FFFFFF";
	// text71.style.border = "0px solid #001E6A";
	// text71.style.textAlign = "left";
	// td71.appendChild (text71);
	// tr.appendChild (td71);
	
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
	
	var td9 = document.createElement ('td');
	td9.id = "radiologyfree"+k+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text9 = document.createElement ('input');
	text9.id = "radiologyfree"+k+"";
	text9.name = "radiologyfree[]"+k+"";
	text9.type = "text";
	text9.size = "8";
	text9.value = varradiologyfreename;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+k+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text10 = document.createElement ('input');
	text10.id = "btndelete5"+k+"";
	text10.name = "btndelete5"+k+"";
	text10.type = "button";
	text10.value = "Del";
	text10.style.border = "1px solid #001E6A";
	text10.onclick = function() { return btnDeleteClick5(k,varradRate); }
	
	
	td10.appendChild (text10);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	
	document.getElementById("serialnumber27").value = parseInt(k) + 1;
	document.getElementById("total2").value=formatMoney(parseFloat(totalamount2)+parseFloat(varradRate));
	document.getElementById("availableamount_org").value=formatMoney(parseFloat(varavailableamount)-grandtotal);
	document.getElementById("total4").value=formatMoney(grandtotal);
	document.getElementById("grand_total").value=formatMoney(grandtotal);
		
	var varRadiology = document.getElementById("radiology").value = "";
	var varRate = document.getElementById("rate8").value = "";
	var varRadiologycode = document.getElementById("radiologycode").value = "";
			// var varInstructions = document.getElementById("radiologyinstructions").value = "";

	document.getElementById("radiology").focus();
	
	window.scrollBy(0,5); 
	return true;
}
}
function pop_delete_radcode(){
	var varRadcode1 = document.getElementById("radiologycode").value;
	 radiologycode.pop(varRadcode1);
	 console.log(radiologycode);
}