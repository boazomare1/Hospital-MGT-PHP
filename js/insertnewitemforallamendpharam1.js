function insertitem10()
{

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
	if(document.form1.frequency.value=="")
	{
		alert("Please enter frequency");
		document.form1.frequency.focus();
		return false;
	}if(document.form1.days.value=="")
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
	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
	var varDose = document.getElementById("dose").value;
	var varFrequency = document.getElementById("frequency").value;
	//var varpharamcheck = document.getElementById("pharamcheck").value;
	//var varpharamlater = document.getElementById("pharamlatertonow").value;
	var varpharmacysno = document.getElementById("pharmacysno").value;
	//alert(varpharmacysno);
	if(varpharmacysno=='')
	{
	varpharmacysno=0;	
	}
	
	var a=1;
	var varpharamsno=parseInt(varpharmacysno)+parseInt(a);
	//alert(varpharamsno);
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
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	tr.appendChild (td1);
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	
	
		var td101 = document.createElement ('td');
	td101.id = "serialnumber"+i+"";
	//td1.align = "left";
	td101.valign = "top";
	td101.style.backgroundColor = "#FFFFFF";
	td101.style.border = "0px solid #001E6A";

	
	
	var text10 = document.createElement ('input');
	text10.id = "pharamcheck"+varpharamsno+"";
	text10.name = "pharamcheck["+varpharamsno+"]";
	text10.type = "checkbox";
	text10.align = "left";
	text10.size = "10";
	text10.value = varpharamsno;
	text10.readOnly = "readonly";
	text10.style.backgroundColor = "#FFFFFF";
	text10.style.border = "0px solid #001E6A";
	text10.style.textAlign = "left";
	text10.onclick = function() {  selectselect('pharam',varpharamsno),approvalfunction("pharamcheck"+varpharamsno+"",varpharmAmount); }

	//td1.appendChild (text1);
	td101.appendChild (text10);
	tr.appendChild (td101);

	
	
	
	
	var text11 = document.createElement ('input');
	text11.id = "medicinename"+varpharamsno+"";
	text11.name = "medicinename["+varpharamsno+"]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "35";
	text11.value = varMedicineName;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text10);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "dose"+varpharamsno+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "dose"+varpharamsno+"";
	text2.name = "dose["+varpharamsno+"]";
	text2.type = "text";
	text2.size = "8";
	text2.value = varDose;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "frequency"+varpharamsno+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "frequency"+varpharamsno+"";
	text3.name = "frequency["+varpharamsno+"]";
	text3.type = "text";
	text3.size = "12";
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
	td5.id = "days"+varpharamsno+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text5 = document.createElement ('input');
	text5.id = "days"+varpharamsno+"";
	text5.name = "days["+varpharamsno+"]";
	text5.type = "text";
	text5.size = "6";
	text5.value = varDays;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);



	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "quantity"+varpharamsno+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text6 = document.createElement ('input');
	text6.id = "quantity"+varpharamsno+"";
	text6.name = "quantity["+varpharamsno+"]";
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
	text12.id = "route"+varpharamsno+"";
	text12.name = "route["+varpharamsno+"]";
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
	td7.id = "instructions"+varpharamsno+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "instructions"+varpharamsno+"";
	text7.name = "instructions["+varpharamsno+"]";
	text7.type = "text";
	text7.size = "14";
	text7.value = varInstructions;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);



	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "rates"+varpharamsno+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rates"+varpharamsno+"";
	text8.name = "rates["+varpharamsno+"]";
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
	td81.id = "amounttd"+varpharamsno+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text81 = document.createElement ('input');
	text81.id = "amount"+varpharamsno+"";
	text81.name = "amount["+varpharamsno+"]";
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
	td82.id = "exclude"+varpharamsno+"";
	td82.align = "left";
	td82.valign = "top";
	td82.style.backgroundColor = "#FFFFFF";
	td82.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text82 = document.createElement ('input');
	text82.id = "exclude"+varpharamsno+"";
	text82.name = "exclude["+varpharamsno+"]";
	text82.type = "text";
	text82.size = "8";
	text82.value = varexclude;
	text82.readOnly = "readonly";
	text82.style.backgroundColor = "#FFFFFF";
	text82.style.border = "0px solid #001E6A";
	text82.style.textAlign = "left";
	td82.appendChild (text82);
	tr.appendChild (td82);
	
	
		var td102 = document.createElement ('td');
	td102.id = "serialnumber"+varpharamsno+"";
	//td1.align = "left";
	td102.valign = "top";
	td102.style.backgroundColor = "#FFFFFF";
	td102.style.border = "0px solid #001E6A";

	
	
	var text102 = document.createElement ('input');
	text102.id = "pharamlatertonow"+varpharamsno+"";
	text102.name = "pharamlatertonow["+varpharamsno+"]";
	text102.type = "checkbox";
	text102.align = "left";
	text102.size = "10";
	text102.value = i;
	text102.readOnly = "readonly";
	text102.style.backgroundColor = "#FFFFFF";
	text102.style.border = "0px solid #001E6A";
	text102.style.textAlign = "left";
	text102.onclick = function() { return selectcash('pharam',varpharamsno); }
	

	//td1.appendChild (text1);
	td102.appendChild (text102);
	tr.appendChild (td102);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete"+varpharamsno+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete"+varpharamsno+"";
	text11.name = "btndelete"+varpharamsno+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick10(varpharamsno,varpharmAmount, "pharamcheck"+varpharamsno+""); }
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
	
	var varMedicineName = document.getElementById("medicinename").value = "";
	var varDose = document.getElementById("dose").value = "";
	var varFrequency = document.getElementById("frequency").value = "select";
	var varDays = document.getElementById("days").value = "";
	var varQuantity = document.getElementById("quantity").value = "";
	var varInstructions = document.getElementById("instructions").value = "";
	var varRate = document.getElementById("rates").value = "";
	var varAmount = document.getElementById("amount").value = "";
	var varRoute = document.getElementById("route").value = "";
	var varexclude = document.getElementById("exclude").value = "";
	document.getElementById("pharmacysno").value="";
	 document.getElementById("pharmacysno").value = varpharamsno;
	

	
	document.getElementById("medicinename").focus();
	grandtotl(varpharmAmount);
	window.scrollBy(0,5); 
	return true;

}
