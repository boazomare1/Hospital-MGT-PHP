function insertitem()
{
 
	if(document.form1.medicinename.value=="")
	{
		alert("Please enter medicine name");
		document.form1.medicinename.focus();
		return false;
	}
	if(document.form1.medicinebatch.value=="")
	{
		alert("Please Select Batch name");
		document.form1.quantity.value = "";
		document.form1.medicinebatch.focus();
		return false;
	}
	/*if(document.form1.expirydate.value=="")
	{
		alert("Expiry Date Cannot be Empty");
		document.form1.expirydate.focus();
		return false;
	}*/
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
	if(document.form1.quantity.value=="")
	{
		alert("Quantity cannot be zero or empty");
		document.form1.quantity.focus();
		return false;
	}
	//alert('ok');
	var varpkg = document.getElementById("pharmfree").value;
	//alert(varpkg);
	if(varpkg =="no")
	{
		varpharmfreename = 'No';
	}
	if(varpkg =="yes")
	{
		varpharmfreename = 'Yes';
	}//alert('ok');
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varMedicineName = document.getElementById("medicinename").value;
	
	var billno = document.getElementById("billno").value;
	var varBatchName = document.getElementById("medicinebatch").value;
	var aval = varBatchName.split('((');
						var varBatchName = aval[0];
						var varfifo_code = aval[1];
	//alert(varBatchName);
	//var batchsplit = document.getElementById("batchnumber").value;
	//spliting batch and sotre code
	/*var batchsplit=batchsplit.split("(");
	var batch=batchsplit[0];
	
	var storesplit=batchsplit[1].split(")");
	var store=storesplit[0];*/
	//var batchsplit=batchsplit.split("(");
	//var batch=batchsplit;
	
	//var storesplit=batchsplit[1].split(")");
	var store='IPSTORE';
	
	//alert('ok');
//	var expirydate = document.getElementById("expirydate").value;
	var varDose = document.getElementById("dose").value;
	var varFrequency = document.getElementById("frequency").value;
	
	//var store = document.getElementById("store").value;
	
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
	var varroute = document.getElementById("route").value;
	var varinstructions = document.getElementById("instructions").value;
	var varhour = document.getElementById("hour").value;
	//alert(varQuantity);
	var varminute = document.getElementById("minute").value;
	var varsession = document.getElementById("sess").value;
	var varrate= document.getElementById("rate").value;
	var varamount= parseFloat(document.getElementById("amount").value);
 	
	var vartotal= parseFloat(document.getElementById("total").value);

	vartotal=vartotal+varamount;
	
	document.getElementById("total").value=vartotal.toFixed(2);
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
	//alert(i);
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

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text11 = document.createElement ('input');
	text11.id = "medicinename"+i+"";
	text11.name = "medicinename"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "35";
	text11.value = varMedicineName;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	
	
	

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	//assigning batch name
	var td2 = document.createElement ('td');
	td2.id = "serialnumber"+i+"";
	//td1.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	
	var text15 = document.createElement ('input');
	text15.id = "medicinebatch"+i+"";
	text15.name = "medicinebatch"+i+"";
	text15.type = "text";
	text15.align = "left";
	text15.size = "5";
	text15.value = varBatchName;
	text15.readOnly = "readonly";
	text15.style.backgroundColor = "#FFFFFF";
	text15.style.border = "0px solid #001E6A";
	text15.style.textAlign = "left";
	
	var text16 = document.createElement ('input');
	text16.id = "uniquebatch"+i+"";
	text16.name = "uniquebatch"+i+"";
	text16.type = "hidden";
	text16.align = "left";
	text16.size = "35";
	text16.value = varBatchName+billno;
	text16.readOnly = "readonly";
	text16.style.backgroundColor = "#FFFFFF";
	text16.style.border = "0px solid #001E6A";
	text16.style.textAlign = "left";
	
	var text17 = document.createElement ('input');
	text17.id = "fifo_code"+i+"";
	text17.name = "fifo_code"+i+"";
	text17.type = "hidden";
	text17.align = "left";
	text17.size = "35";
	text17.value = varfifo_code;
	text17.readOnly = "readonly";
	text17.style.backgroundColor = "#FFFFFF";
	text17.style.border = "0px solid #001E6A";
	text17.style.textAlign = "left";
	

//	td15.appendChild (text15);
	td2.appendChild (text16);
	//tr.appendChild (td2);
	td2.appendChild (text15);
	//tr.appendChild (td2);
	td2.appendChild (text17);
	tr.appendChild (td2);
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		//var td2 = document.createElement ('td');
//	td2.id = "batchnumber"+i+"";
//	td2.align = "left";
//	td2.valign = "top";
//	td2.style.backgroundColor = "#FFFFFF";
//	td2.style.border = "0px solid #001E6A";
//	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
//	var text2 = document.createElement ('input');
//	text2.id = "batchnumber"+i+"";
//	text2.name = "batchnumber"+i+"";
//	text2.type = "hidden";
//	text2.size = "8";
//	text2.value = batch;
//	text2.readOnly = "readonly";
//	text2.style.backgroundColor = "#FFFFFF";
//	text2.style.border = "0px solid #001E6A";
//	text2.style.textAlign = "left";
//	td2.appendChild (text2);
//	tr.appendChild (td2);
//	
//	
//	
//	
//	
//	var td3 = document.createElement ('td');
//	td3.id = "expirydate"+i+"";
//	td3.align = "left";
//	td3.valign = "top";
//	td3.style.backgroundColor = "#FFFFFF";
//	td3.style.border = "0px solid #001E6A";
//	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
//	var text3 = document.createElement ('input');
//	text3.id = "expirydate"+i+"";
//	text3.name = "expirydate"+i+"";
//	text3.type = "hidden";
//	text3.size = "8";
//	text3.value = expirydate;
//	text3.readOnly = "readonly";
//	text3.style.backgroundColor = "#FFFFFF";
//	text3.style.border = "0px solid #001E6A";
//	text3.style.textAlign = "left";
//	td3.appendChild (text3);
//	tr.appendChild (td3);
//	
//alert('ok');
	var td4 = document.createElement ('td');
	td4.id = "pharmfree"+i+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text4 = document.createElement ('input');
	text4.id = "pharmfree"+i+"";
	text4.name = "pharmfree"+i+"";
	text4.type = "text";
	text4.size = "8";
	text4.value = varpharmfreename;
	text4.readOnly = "readonly";
	text4.style.backgroundColor = "#FFFFFF";
	text4.style.border = "0px solid #001E6A";
	text4.style.textAlign = "left";
	td4.appendChild (text4);
	tr.appendChild (td4);



var td5 = document.createElement ('td');
	td5.id = "dose"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text5 = document.createElement ('input');
	text5.id = "dose"+i+"";
	text5.name = "dose"+i+"";
	text5.type = "text";
	text5.size = "8";
	text5.value = varDose;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	td5.appendChild (text5);
	tr.appendChild (td5);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td6 = document.createElement ('td');
	td6.id = "frequency"+i+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text6 = document.createElement ('input');
	text6.id = "frequency"+i+"";
	text6.name = "frequency"+i+"";
	text6.type = "text";
	text6.size = "8";
	text6.value = varFrequencyName;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "left";
	td6.appendChild (text6);
	tr.appendChild (td6);


	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td7 = document.createElement ('td');
	td7.id = "days"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');
	var text7 = document.createElement ('input');
	text7.id = "days"+i+"";
	text7.name = "days"+i+"";
	text7.type = "text";
	text7.size = "8";
	text7.value = varDays;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);



	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td8 = document.createElement ('td');
	td8.id = "quantity"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');
	var text8 = document.createElement ('input');
	text8.id = "quantity"+i+"";
	text8.name = "quantity"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varQuantity;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);


	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td9 = document.createElement ('td');
	td9.id = "route"+i+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text9 = document.createElement ('input');
	text9.id = "route"+i+"";
	text9.name = "route"+i+"";
	text9.type = "text";
	text9.size = "8";
	text9.value = varroute;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
	var td91 = document.createElement ('td');
	td91.id = "instructions"+i+"";
	td91.align = "left";
	td91.valign = "top";
	td91.style.backgroundColor = "#FFFFFF";
	td91.style.border = "0px solid #001E6A";
	//var text7 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text91 = document.createElement ('input');
	text91.id = "instructions"+i+"";
	text91.name = "instructions"+i+"";
	text91.type = "text";
	text91.size = "20";
	text91.value = varinstructions;
	text91.readOnly = "readonly";
	text91.style.backgroundColor = "#FFFFFF";
	text91.style.border = "0px solid #001E6A";
	text91.style.textAlign = "left";
	td91.appendChild (text91);
	tr.appendChild (td91);
	



	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "hour"+i+"";
	td10.align = "left";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text10 = document.createElement ('input');
	text10.id = "hour"+i+"";
	text10.name = "hour"+i+"";
	text10.type = "text";
	text10.size = "4";
	text10.value = varhour;
	text10.readOnly = "readonly";
	text10.style.backgroundColor = "#FFFFFF";
	text10.style.border = "0px solid #001E6A";
	text10.style.textAlign = "left";
	td10.appendChild (text10);
	tr.appendChild (td10);


	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td11 = document.createElement ('td');
	td11.id = "minute"+i+"";
	td11.align = "left";
	td11.valign = "top";
	td11.style.backgroundColor = "#FFFFFF";
	td11.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text11 = document.createElement ('input');
	text11.id = "minute"+i+"";
	text11.name = "minute"+i+"";
	text11.type = "text";
	text11.size = "4";
	text11.value = varminute;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	td11.appendChild (text11);
	tr.appendChild (td11);
	
	var td12 = document.createElement ('td');
	td12.id = "sess"+i+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text12 = document.createElement ('input');
	text12.id = "sess"+i+"";
	text12.name = "sess"+i+"";
	text12.type = "text";
	text12.size = "4";
	text12.value = varsession;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);
	
	//rate and amount
	var td15 = document.createElement ('td');
	td15.id = "rate"+i+"";
	td15.align = "left";
	td15.valign = "top";
	td15.style.backgroundColor = "#FFFFFF";
	td15.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text15 = document.createElement ('input');
	text15.id = "rates"+i+"";
	text15.name = "rates"+i+"";
	text15.type = "text";
	text15.size = "4";
	text15.value = varrate;
	text15.readOnly = "readonly";
	text15.style.backgroundColor = "#FFFFFF";
	text15.style.border = "0px solid #001E6A";
	text15.style.textAlign = "left";
	td15.appendChild (text15);
	tr.appendChild (td15);
	
	
		//rate and amount
	var td16 = document.createElement ('td');
	td16.id = "amount"+i+"";
	td16.align = "left";
	td16.valign = "top";
	td16.style.backgroundColor = "#FFFFFF";
	td16.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="taxpercent'+i+'" value="'+varItemTaxPercent+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="3" />');
	var text16 = document.createElement ('input');
	text16.id = "amounts"+i+"";
	text16.name = "amounts"+i+"";
	text16.type = "text";
	text16.size = "4";
	text16.value = varamount;
	text16.readOnly = "readonly";
	text16.style.backgroundColor = "#FFFFFF";
	text16.style.border = "0px solid #001E6A";
	text16.style.textAlign = "left";
	td16.appendChild (text16);
	tr.appendChild (td16);
	
	
	//soter
	var td13 = document.createElement ('td');
	td13.id = "sesss"+i+"";
	td13.align = "left";
	td13.valign = "top";
	td13.style.backgroundColor = "#FFFFFF";
	td13.style.border = "0px solid #001E6A";
	var text13 = document.createElement ('input');
	text13.id = "store"+i+"";
	text13.name = "store"+i+"";
	text13.type = "hidden";
	text13.size = "8";
	text13.value = store;
	text13.readOnly = "readonly";
	text13.style.backgroundColor = "#FFFFFF";
	text13.style.border = "0px solid #001E6A";
	text13.style.textAlign = "left";
	td13.appendChild (text13);
	tr.appendChild (td13);
	
	var td14 = document.createElement ('td');
	td14.id = "btndelete"+i+"";
	td14.align = "right";
	td14.valign = "top";
	td14.style.backgroundColor = "#FFFFFF";
	td14.style.border = "0px solid #001E6A";
	
	
	var text14 = document.createElement ('input');
	text14.id = "btndelete"+i+"";
	text14.name = "btndelete"+i+"";
	text14.type = "button";
	text14.value = "Del";
	text14.style.border = "1px solid #001E6A";
	var ia=i;
	text14.onclick = function() { btnDeleteClick(ia); }
	//td10.appendChild (text10);
	td14.appendChild (text14);
	tr.appendChild (td14);
	
	//alert(i);
	

    document.getElementById ('insertrow').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	
	
	
	
	
	
	
	
	//alert(document.getElementById("availableqty").value);
	
						var xmlhttp;
						var str = document.getElementById("medicinecode").value;
						var strm = document.getElementById("medicinename").value;
						var availableqty = document.getElementById("availableqty").value;
						var billno = document.getElementById("billno").value;
						var varvisitcode = document.getElementById("visitcode").value;
						var varBatchName = document.getElementById("medicinebatch").value;
						var aval = varBatchName.split('((');
						var fifo = aval[1];
						var varBatchName = aval[0];
					//alert(availableqty);
						var medkey = varvisitcode+billno;
						
						if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
						  xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
						  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						xmlhttp.onreadystatechange=function()
						  {
						  if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
								
								var text17 = document.createElement ('input');
								text17.id = "uniqueautonum"+ia+"";
								text17.name = "uniqueautonum"+ia+"";
								text17.type = "hidden";
								text17.align = "left";
								text17.size = "35";
								text17.value = xmlhttp.responseText;
								text17.readOnly = "readonly";
								text17.style.backgroundColor = "#FFFFFF";
								text17.style.border = "0px solid #001E6A";
								text17.style.textAlign = "left";
								
							
							//	td15.appendChild (text15);
								td2.appendChild (text17);
								tr.appendChild (td2);
							//document.getElementById("medicinekey").innerHTML=xmlhttp.responseText;
							}
						  }
		xmlhttp.open("GET","ajaxtempbatch.php?medcod="+str+"&&mednam="+strm+"&&batnam="+varBatchName+"&&avlqty="+availableqty+"&&medkey="+medkey+"&&fifo="+fifo,true);
		xmlhttp.send();
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	var varMedicineName = document.getElementById("medicinename").value = "";
    //var batch = document.getElementById("batchnumber").value = "";
	//var expirydate = document.getElementById("expirydate").value = "";
	var varpharmfreename = document.getElementById("pharmfree").value = "0";
	var varDose = document.getElementById("dose").value = "";
	var varFrequency = document.getElementById("frequency").value = "select";
	var varDays = document.getElementById("days").value = "";
	var varQuantity = document.getElementById("quantity").value = "";
    var varroute = document.getElementById("route").value = "";
	var varinstructions = document.getElementById("instructions").value = "";
	var varhour = document.getElementById("hour").value = "";
	var varminute = document.getElementById("minute").value = "";
	var varsession = document.getElementById("sess").value = "am";
	var storecode = document.getElementById("store").value = "am";
	document.getElementById("request").value = "1";
//alert('working');
	var varrate = document.getElementById("rate").value = "";
	var varamount = document.getElementById("amount").value = "";
	
	document.getElementById("medicinename").focus();
	
document.getElementById("medicinebatch").innerHTML = '<option value="">Batch</option';
	
	
	//alert(batlen);
	// bat.remove();
	// bat.options.remove();
	
	/*if (batlen > 0) {
        bat.remove(batlen-1);
    }*/
	/*bat.remove(0);
	bat.remove(1);
	bat.remove(2);
	bat.remove(3);*/
	
	/*if (x.length > 0) {
        x.remove(x.length-1);
    }*/
/*	$('#medicinebatch')
    .find('option')
    .remove()
    .end()
    .append('<option value="whatever">text</option>')
    .val('whatever')
;*/

	document.getElementById("availableqty").value = "0";
	
	window.scrollBy(0,5); 
	return true;


//for storing the available quantity for batch temporaryly

}


