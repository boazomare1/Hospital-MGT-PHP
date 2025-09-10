function insertitem()
{
//alert('h');
	if(document.getElementById("medicinename").value=="")
	{
		alert("Please enter medicine name");
		document.getElementById("medicinename").focus();
		return false;
	}
	
	/*if(document.getElementById("dose").value=="0" || document.getElementById("dose").value=="")
	{
		alert("Please enter dose");
		document.getElementById("dose").focus();
		return false;
	}else if(!/^[0-9]+$/.test(document.getElementById("dose").value)){
        alert("Please only enter numeric characters for dose! (Allowed input:0-9)");
		return false;
    }

	if(document.getElementById("dosemeasure").value=="")
	{
		alert("Please select dose measure");
		document.getElementById("dosemeasure").focus();
		return false;
	}

	if(document.getElementById("frequency").value=="")
	{
		alert("Please select frequency");
		document.getElementById("frequency").focus();
		return false;
	}
	if(document.getElementById("days").value=="")
	{
		alert("Please enter days");
		document.getElementById("days").focus();
		return false;
	}*/
	
	/*if(document.getElementById("route").value=="")
	{
		alert("Please select Route");
		document.getElementById("route").focus();
		return false;
	}*/
	if(document.getElementById("pharmaqty").value=="")
	{
		alert("Please Enter Quantity");
		document.getElementById("pharmaqty").focus();
		return false;
	}
	if(document.getElementById("pharmarate").value=="")
	{
		alert("Please Enter Rate");
		document.getElementById("pharmarate").focus();
		return false;
	}
	
	if(parseInt(document.getElementById("pharmaamt").value)<0)
	{
		alert("Please Enter amount");
		document.getElementById("pharmaamt").focus();
		return false;
	}
var varSerialNumber = document.getElementById("serialnumberp").value;
	var varmedicinecode = document.getElementById("medicinecode").value;
	//alert(varmedicinecode);
	var match=0;
	var dosemeasure = document.getElementById("dosemeasure").value;
	for(z=1;z<varSerialNumber;z++)
	{
		
		var add_med = document.getElementById("medicinecode"+z).value;
		if(varmedicinecode==add_med)
		{
			match=parseFloat(match)+1;
		}
		
	}
	if(match>0)
	{
		alert('This Item already added');
		document.getElementById("medicinename").value="";
		document.getElementById("pharmaqty").value="";
		document.getElementById("pharmarate").value="";
		document.getElementById("pharmaamt").value="";
		return false;
	}
	var varMedicineName = document.getElementById("medicinename").value;
	var varDose = document.getElementById("dose").value;
	var varFrequency = document.getElementById("frequency").value;

	var vardays = document.getElementById("days").value;
	var varpharmaqty = document.getElementById("pharmaqty").value;
	var varpharmaamt = document.getElementById("pharmaamt").value;

	var varFrequencyName;
	if(varFrequency==1)
	{
		varFrequencyName='OD';
	}else if(varFrequency==2)
	{
		varFrequencyName='BD';
	}else if(varFrequency==3)
	{
		varFrequencyName='TID';
	}else if(varFrequency==4)
	{
		varFrequencyName='QID';
	}else if(varFrequency==5)
	{
		varFrequencyName='NOCTE';
	}else 
	{
		varFrequencyName='PRN';
	}
	
	//var varRoute = document.getElementById("route").value;
	//var varInstructions = document.getElementById("pharinstuct").value;
	var varpharmRate = document.getElementById("pharmarate").value;
	//alert(varpharmRate);
	
 
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
	td1.id = "serialnumberp"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "serialnumberp"+i+"";
	text1.name = "serialnumberp"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "medicinecode"+i+"";
	text11.name = "medicinecode"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varmedicinecode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	td1.appendChild (text11);

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
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "tddose"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	td2.style.display = "none";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "dose"+i+"";
	text2.name = "dose"+i+"";
	text2.type = "text";
	text2.size = "8";
	text2.value = varDose;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.display = "none";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);
	
	
	
	var td21 = document.createElement ('td');
	td21.id = "tddosemeasure"+i+"";
	td21.align = "left";
	td21.valign = "top";
	td21.style.backgroundColor = "#FFFFFF";
	td21.style.border = "0px solid #001E6A";
	td21.style.display = "none";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text21 = document.createElement ('input');
	text21.id = "dosemeasure"+i+"";
	text21.name = "dosemeasure"+i+"";
	text21.type = "text";
	text21.size = "8";
	text21.value = dosemeasure;
	text21.readOnly = "readonly";
	text21.style.backgroundColor = "#FFFFFF";
	text21.style.border = "0px solid #001E6A";
	text21.style.textAlign = "left";
	td21.appendChild (text21);
	tr.appendChild (td21);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "tdfrequency"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	td3.style.display = "none";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "frequency"+i+"";
	text3.name = "frequency"+i+"";
	text3.type = "text";
	text3.size = "8";
	text3.value = varFrequencyName;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);

    
	var td12 = document.createElement ('td');
	td12.id = "tddays"+i+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	td12.style.display = "none";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text12 = document.createElement ('input');
	text12.id = "days"+i+"";
	text12.name = "days"+i+"";
	text12.type = "text";
	text12.size = "3";
	text12.value = vardays;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);

    var td12 = document.createElement ('td');
	td12.id = "tdpharmaqty"+i+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text12 = document.createElement ('input');
	text12.id = "pharmaqty"+i+"";
	text12.name = "pharmaqty"+i+"";
	text12.type = "text";
	text12.size = "4";
	text12.value = varpharmaqty;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);
	
	/*var td12 = document.createElement ('td');
	td12.id = "route"+i+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	
	var text12 = document.createElement ('input');
	text12.id = "route"+i+"";
	text12.name = "route"+i+"";
	text12.type = "text";
	text12.size = "10";
	text12.value = varRoute;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);*/



	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	/*var td7 = document.createElement ('td');
	td7.id = "pharinstuct"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	
	var text7 = document.createElement ('input');
	text7.id = "pharinstuct"+i+"";
	text7.name = "pharinstuct"+i+"";
	text7.type = "text";
	text7.size = "20";
	text7.value = varInstructions;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);*/



	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "tdpharmarate"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "pharmarate"+i+"";
	text8.name = "pharmarate"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varpharmRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "right";
	td8.appendChild (text8);
	tr.appendChild (td8);

	var td8 = document.createElement ('td');
	td8.id = "tdpharmaamt"+i+"";
	td8.className = "pharmacalamt";
	td8.align = "right";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "pharmaamt"+i+"";
	text8.name = "pharmaamt"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varpharmaamt;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "right";
	td8.appendChild (text8);
	tr.appendChild (td8);

	
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
	text11.onclick = function() { return btnDeleteClick10(i,''); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow1').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumberp").value = parseInt(i) + 1;
	
	
	
	
	var varMedicineName = document.getElementById("medicinename").value = "";
	var varDose = document.getElementById("dose").value = "";
	var varDose = document.getElementById("dosemeasure").value = "";
	var varFrequency = document.getElementById("frequency").value = "";
	
	//var varInstructions = document.getElementById("pharinstuct").value = "";
	var varRate = document.getElementById("pharmarate").value = "";

	document.getElementById("days").value = "";
	document.getElementById("pharmaqty").value = "";
	document.getElementById("pharmaamt").value = "";
	
	//var varRoute = document.getElementById("route").value = "";
	
	// Calculate Sub Total for all items
	/*var sum = 0;
	 $(".pharmacalamt").each(function()
      {
                  sum += parseFloat($(this).find("input").val());
				
        });
	 $('#mi_items_subtotal').html(formatMoney(sum.toFixed(2)));*/

	  var classname = 'pharmacalamt';
	var id = 'mi_items_subtotal';
    calculate_items_total(classname,id);
	
	document.getElementById("medicinename").focus();
	
	window.scrollBy(0,5); 
	return true;

}


