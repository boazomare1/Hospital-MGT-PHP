function insertitem()
{
//alert('h');
	if(document.form1.medicinename.value=="")
	{
		alert("Please enter medicine name");
		document.form1.medicinename.focus();
		return false;
	}
	if(document.form1.dose.value=="")
	{
		alert("Please enter dose");
		document.form1.dose.focus();
		return false;
	}
	if(document.form1.dose.value=="0")
	{
		alert("Please enter dose");
		document.form1.dose.focus();
		return false;
	}
	if(document.form1.frequency.value=="")
	{
		alert("Please enter frequency");
		document.form1.frequency.focus();
		return false;
	}
	if(document.form1.days.value=="")
	{
		alert("Please enter days");
		document.form1.days.focus();
		return false;
	}
	if(document.form1.days.value=="0")
	{
		alert("Please enter days");
		document.form1.days.focus();
		return false;
	}
	if(document.form1.route.value=="")
	{
		alert("Please select Route");
		document.form1.route.focus();
		return false;
	}
	if(document.form1.quantity.value=="")
	{
		alert("Please Enter Quantity");
		document.form1.quantity.focus();
		return false;
	}
	if(document.form1.rates.value=="")
	{
		alert("Please Enter Rate");
		document.form1.rates.focus();
		return false;
	}
	if(isNaN(document.form1.dose.value))
	{
		alert("Please enter dose");
		document.form1.dose.focus();
		return false;
	}
	if(isNaN(document.form1.days.value))
	{
		alert("Please enter days");
		document.form1.days.focus();
		return false;
	}
	var dosemeasure = document.getElementById("dosemeasure").value;
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
	var varDose = document.getElementById("dose").value;
	var varFrequency = document.getElementById("frequency").value;
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
	var varDays = document.getElementById("days").value;
	var varQuantity = document.getElementById("quantity").value;
	var varRoute = document.getElementById("route").value;
	var varInstructions = document.getElementById("instructions").value;
	var varpharmRate = document.getElementById("rates").value;
	//alert(varpharmRate);
	var varpharmAmount = document.getElementById("amount").value;
	var varexclude = document.getElementById("exclude").value;
 
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
	td1.id = "serialnumber"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+i+"";
	text1.name = "serialnumber"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

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
	td2.id = "dose"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
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
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);
	
	
	
	var td21 = document.createElement ('td');
	td21.id = "dosemeasure"+i+"";
	td21.align = "left";
	td21.valign = "top";
	td21.style.backgroundColor = "#FFFFFF";
	td21.style.border = "0px solid #001E6A";
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
	td3.id = "frequency"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "frequency"+i+"";
	text3.name = "frequency"+i+"";
	text3.type = "text";
	text3.size = "16";
	text3.value = varFrequencyName;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);


	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "days"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "days"+i+"";
	text5.name = "days"+i+"";
	text5.type = "text";
	text5.size = "8";
	text5.value = varDays;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);



	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "quantity"+i+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text6 = document.createElement ('input');
	text6.id = "quantity"+i+"";
	text6.name = "quantity"+i+"";
	text6.type = "text";
	text6.size = "4";
	text6.value = varQuantity;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "left";
	td6.appendChild (text6);
	tr.appendChild (td6);
	
	var td12 = document.createElement ('td');
	td12.id = "route"+i+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
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
	tr.appendChild (td12);



	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td7 = document.createElement ('td');
	td7.id = "instructions"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "instructions"+i+"";
	text7.name = "instructions"+i+"";
	text7.type = "text";
	text7.size = "20";
	text7.value = varInstructions;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);



	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "rates"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rates"+i+"";
	text8.name = "rates"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varpharmRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);


	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td81 = document.createElement ('td');
	td81.id = "amount"+i+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text81 = document.createElement ('input');
	text81.id = "amount"+i+"";
	text81.name = "amount"+i+"";
	text81.type = "text";
	text81.size = "8";
	text81.value = varpharmAmount;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "left";
	td81.appendChild (text81);
	tr.appendChild (td81);
	
	var td82 = document.createElement ('td');
	td82.id = "exclude"+i+"";
	td82.align = "left";
	td82.valign = "top";
	td82.style.backgroundColor = "#FFFFFF";
	td82.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text82 = document.createElement ('input');
	text82.id = "exclude"+i+"";
	text82.name = "exclude"+i+"";
	text82.type = "text";
	text82.size = "8";
	text82.value = varexclude;
	text82.readOnly = "readonly";
	text82.style.backgroundColor = "#FFFFFF";
	text82.style.border = "0px solid #001E6A";
	text82.style.textAlign = "left";
	td82.appendChild (text82);
	tr.appendChild (td82);
	
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
	text11.onclick = function() { return btnDeleteClick(i,varpharmAmount); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	totalamount=document.getElementById('total').value;
	}
	
	
	totalamount=parseFloat(totalamount) + parseFloat(varpharmAmount);
	
	document.getElementById("total").value=totalamount.toFixed(2);
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	totalamount4=document.getElementById('total5').value;
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalamountr=document.getElementById('totalr').value;
	}
	
	
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	
	//alert("hi");
	//i++;
    //alert(i);
   
	// if additional text this tr will be inserted.
	/*if (lab != "")
	{
	//alert (varItemDescription);

	//var trAddDescription = document.createElement ('<TR id="idTRaddtxt'+i+'"></TR>');
	var trlab = document.createElement ('TR');
	trlab.id = "idTRaddtxt"+i+"";
		
*/
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	/*var td1 = document.createElement ('td');
	td1.id = "idTD2"+i+"";
	td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	trlab.appendChild (td1);

	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td2 = document.createElement ('td');
	td2.id = "idTD2"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	trlab.appendChild (td2);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<textarea name="itemdescription'+i+'" cols="40" rows="2" id="itemdescription'+i+'" style="border: 0px solid #001E6A;"></textarea>');
	var text3 = document.createElement ('input');
	text3.id = "lab"+i+"";
	text3.name = "lab"+i+"";
	text3.cols = "40";
	text3.rows = "2";
	text3.value = varLab;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	trlab.appendChild (td3);

	
	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td4 = document.createElement ('td');
	td4.id = "idTD3"+i+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	trlab.appendChild (td4);

	
	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD3"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	trlab.appendChild (td5);

	
	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td6 = document.createElement ('td');
	td6.id = "idTD3"+i+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	trlab.appendChild (td6);

	
	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td7 = document.createElement ('td');
	td7.id = "idTD3"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	trlab.appendChild (td7);

	
	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td8 = document.createElement ('td');
	td8.id = "idTD3"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	trlab.appendChild (td8);

	
	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td81 = document.createElement ('td');
	td81.id = "idTD3"+i+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	trlab.appendChild (td81);

	
	//var td9 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td9 = document.createElement ('td');
	td9.id = "idTD3"+i+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	trlab.appendChild (td9);*/

	
	//var td10 = document.createElement ('<td id="idTD3'+i+'" align="right" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	/*var td10 = document.createElement ('td');
	td10.id = "idTD3"+i+"";
	td10.align = "left";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	trlab.appendChild (td10);
*/
	//document.getElementById ('insertrow').appendChild (tr);

	//}
	
	
	var varMedicineName = document.getElementById("medicinename").value = "";
	var varDose = document.getElementById("dose").value = "";
	var varDose = document.getElementById("dosemeasure").value = "";
	var varFrequency = document.getElementById("frequency").value = "select";
	var varDays = document.getElementById("days").value = "";
	var varQuantity = document.getElementById("quantity").value = "";
	var varInstructions = document.getElementById("instructions").value = "";
	var varRate = document.getElementById("rates").value = "";
	var varAmount = document.getElementById("amount").value = "";
	var varRoute = document.getElementById("route").value = "";
	var varexclude = document.getElementById("exclude").value = "";
	

	
	document.getElementById("medicinename").focus();
	
	window.scrollBy(0,5); 
	return true;

}


