function funcItemAddToOrder1(varItemCode,varItemName,varItemRate)
{
	
	//document.getElementById('total1').value=0;
	//alert ("Meow...");
	if (document.getElementById("tableanum").value == "")
	{
		alert ("Please Select Table To Proceed.");
		document.getElementById("tableanum").focus();
		return false;
	}
	if (document.getElementById("seatanum").value == "")
	{
		alert ("Please Select Seat To Proceed.");
		document.getElementById("seatanum").focus();
		return false;
	}
	
	var varItemCode = varItemCode;
	//alert (varItemCode);
	var varItemName = varItemName;
	//alert (varItemName);
	
	//To Set Serial Number Value.
	var varSerialNumberSet = 0;
	for (m=1;m<10;m++)
	{
		if (document.getElementById('serialnumber'+m) != null) 
		{
			varSerialNumberSet = document.getElementById('serialnumber'+m).value;
		}
	}

	if (varSerialNumberSet == 0)
	{
		varSerialNumberSet = 1;
	}
	else
	{
		varSerialNumberSet = parseInt(varSerialNumberSet) + 1;
	}
	//alert (varSerialNumberSet);
	//return false; //to exit out of function.
	
	
	//To Find ItemCode Already Exists or Not.
	for (n=1;n<100;n++)
	{
		if (document.getElementById('itemcode'+n) != null) 
		{
			if (document.getElementById('itemcode'+n).value == varItemCode)
			{
				var varItemCodeFound = "FOUND";
				var varItemQuantityFound = document.getElementById('itemquantity'+n).value;
				//alert (varItemQuantityFound);
				var varItemQuantityFound = parseInt(varItemQuantityFound) + 1;
				//alert (varItemQuantityFound);
				var varItemRateFound =  parseFloat(varItemRate);
				//alert (varItemRateFound);
				var varRate1=varItemQuantityFound*varItemRateFound;
				var varRate1 = parseFloat(varRate1).toFixed(2);
	    		varRate1 = varRate1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				document.getElementById('rate'+n).value = varRate1;
				document.getElementById('itemquantity'+n).value = varItemQuantityFound;
				document.getElementById('itemquantityhidden'+n).value = varItemQuantityFound;

			//	document.getElementById('total1').value-=varItemRate;
				document.getElementById('total1').value = parseFloat(document.getElementById('total1').value)+parseFloat(varItemRate);
				var diff1 = parseFloat(document.getElementById('total1').value).toFixed(2);
	    		diff1 = diff1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				 document.getElementById('total').innerHTML=  diff1;
				 
				 	
					var amount= parseFloat(document.getElementById('total1').value).toFixed(2);
					document.getElementById("tdShowTotal").innerHTML =amount;
					document.getElementById("cashamount").value =amount;
					//alert(amount)
		if(amount >= 5000 )
		{
							//	alert(amount);

			var vat = (amount*10)/100;
			amount2=parseFloat(amount);
					 amount=amount2+vat;
					vat=parseFloat(vat).toFixed(2)
				
				vat = vat.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				
			document.getElementById("vat").value=vat;
			}
			else
			{
				document.getElementById("vat").value=0.00;
				
			}
				
					 amount = parseFloat(amount).toFixed(2);
					amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					document.getElementById("subtotal").value = amount;
			
					var amount1=amount-Math.round(amount);
					document.getElementById("totalamount").value = amount;
					document.getElementById("roundoff").value = -amount1.toFixed(3);
	  
			     document.getElementById("billtype").value == "";
					paymentinfo();	
		
				return false;
			}
		}
	}

	
				
					
					
	//k = "1";
	var k = varSerialNumberSet;
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";
	
	var td7 = document.createElement ('td');
	td7.id = "idTD1"+k+"";
	td7.align = "left";
	td7.valign = "top";
	td7.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text7 = document.createElement ('input');
	text7.id = "serialnumber"+k+"";
	text7.name = "serialnumber"+k+"";
	text7.type = "text";
	text7.size = "1";
	text7.value = varSerialNumberSet;
	text7.readOnly = "readonly";
	//text7.style.width = "100";
	//text7.style.height = "120";
	//text7.style.fontSize = "72px";
	text7.style.textAlign = "center";
	//text7.style.backgroundColor = "#FFFFFF";
	//text7.style.border = "1px solid #001E6A";
	
	var td1 = document.createElement ('td');
	td1.id = "idTD1"+k+"";
	td1.align = "left";
	td1.valign = "top";
	td1.width = "78%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "itemname"+k+"";
	text1.name = "itemname"+k+"";
	text1.type = "text";
	text1.size = "60";
	text1.value = varItemName;
	text1.readOnly = "readonly";
	text1.style.fontWeight = "bold";
	//text1.style.width = "500";
	//text1.style.height = "120";
	//text1.style.fontSize = "72px";
	text1.style.textAlign = "left";
	//text1.style.backgroundColor = "#FFFFFF";
	//text1.style.border = "1px solid #001E6A";
	
	
	
	var td2 = document.createElement ('td');
	td2.id = "idTD1"+k+"";
	td2.align = "left";
	td2.valign = "top";
	td2.width = "1%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text2 = document.createElement ('input');
	text2.id = "itemquantity"+k+"";
	text2.name = "itemquantity"+k+"";
	text2.type = "text";
	text2.size = "1";
	text2.value = "1";
	text2.readOnly = "readonly";
	text2.style.fontWeight = "bold";
	//text2.style.width = "100";
	//text2.style.height = "120";
	//text2.style.fontSize = "72px";
	text2.style.textAlign = "center";
	//text2.style.backgroundColor = "#FFFFFF";
	//text2.style.border = "1px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text21 = document.createElement ('input');
	text21.id = "itemquantityhidden"+k+"";
	text21.name = "itemquantityhidden"+k+"";
	text21.type = "hidden";
	text21.size = "1";
	text21.value = "1";
	text21.readOnly = "readonly";
	//text21.style.width = "100";
	//text21.style.height = "120";
	//text21.style.fontSize = "72px";
	text21.style.textAlign = "center";
	//text2.style.backgroundColor = "#FFFFFF";
	//text2.style.border = "1px solid #001E6A";
	
	var td25 = document.createElement ('td');
	td25.id = "idTD15"+k+"";
	td25.align = "left";
	td25.valign = "top";
	td25.width = "5%";
	td25.style.backgroundColor = "#FFFFFF";
	td25.style.border = "0px solid #001E6A";
	
	var td3 = document.createElement ('td');
	td3.id = "idTD1"+k+"";
	td3.align = "left";
	td3.valign = "top";
	td3.width = "1%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text3 = document.createElement ('input');
	text3.id = "itemadd"+k+"";
	text3.name = "itemadd"+k+"";
	text3.type = "button";
	text3.size = "1";
	text3.value = "+";
	text3.readOnly = "readonly";
	//text3.style.width = "100";
	//text3.style.height = "120";
	//text3.style.fontSize = "72px";
	text3.style.textAlign = "center";
	text3.onclick = function() { return funcItemAddButtonClick(k,varItemRate); }
	//text3.style.backgroundColor = "#FFFFFF";
	//text3.style.border = "1px solid #001E6A";
	
	
	
	var td4 = document.createElement ('td');
	td4.id = "idTD1"+k+"";
	td4.align = "left";
	td4.valign = "top";
	td4.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text4 = document.createElement ('input');
	text4.id = "itemminus"+k+"";
	text4.name = "itemminus"+k+"";
	text4.type = "button";
	text4.size = "1";
	text4.value = "-";
	text4.readOnly = "readonly";
	//text4.style.width = "100";
	//text4.style.height = "120";
	//text4.style.fontSize = "72px";
	text4.style.textAlign = "center";
	text4.onclick = function() { return funcItemMinusButtonClick(k,varItemRate); }
	
	var varItemRate = parseFloat(varItemRate).toFixed(2);
	varItemRate = varItemRate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	var td51 = document.createElement ('td');
	td51.id = "idTD1"+k+"";
	td51.align = "left";
	td51.valign = "top";
	td51.width = "200";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td51.style.backgroundColor = "#FFFFFF";
	td51.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text51 = document.createElement ('input');
	text51.id = "rate"+k+"";
	text51.name = "rate"+k+"";
	text51.type = "text";
	text51.size = "15";
	text51.value = varItemRate;
	text51.readOnly = "readonly";
	//text51.style.width = "500";
	//text51.style.height = "120";
	//text51.style.fontSize = "72px";
	text51.style.textAlign = "right";
	text51.onclick = function() { }
	//text4.style.backgroundColor = "#FFFFFF";
	//text4.style.border = "1px solid #001E6A";
	
	
	var td611 = document.createElement ('td');
	td611.id = "idTD1a"+k+"";
	td611.align = "left";
	td611.valign = "top";
	td611.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td611.style.backgroundColor = "#FFFFFF";
	td611.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text611 = document.createElement ('input');
	text611.id = "itemratea"+k+"";
	text611.name = "itemratea"+k+"";
	text611.type = "hidden";
	text611.size = "1";
	text611.value = varItemRate;
	text611.readOnly = "readonly";
	//text611.style.width = "100";
	//text611.style.height = "120";
	//text611.style.fontSize = "72px";
	text611.style.textAlign = "center";
	
	var varItemRate = varItemRate.replace(/,/g,'');
	document.getElementById('total1').value =parseFloat(document.getElementById('total1').value)+parseFloat(varItemRate);
	
	var td5 = document.createElement ('td');
	td5.id = "idTD1"+k+"";
	td5.align = "left";
	td5.valign = "top";
	td5.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text5 = document.createElement ('input');
	text5.id = "itemdelete"+k+"";
	text5.name = "itemdelete"+k+"";
	text5.type = "button";
	text5.size = "1";
	text5.value = "x";
	text5.readOnly = "readonly";
	//text5.style.width = "100";
	//text5.style.height = "120";
	//text5.style.fontSize = "72px";
	text5.style.textAlign = "center";
	text5.onclick = function() { return funcItemDeleteButtonClick(k); }
	//text5.style.backgroundColor = "#FFFFFF";
	//text5.style.border = "1px solid #001E6A";
	
	
	
	var td6 = document.createElement ('td');
	td6.id = "idTD1"+k+"";
	td6.align = "left";
	td6.valign = "top";
	td6.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text6 = document.createElement ('input');
	text6.id = "itemcode"+k+"";
	text6.name = "itemcode"+k+"";
	text6.type = "hidden";
	text6.size = "1";
	text6.value = varItemCode;
	text6.readOnly = "readonly";
	//text6.style.width = "100";
	//text6.style.height = "120";
	//text6.style.fontSize = "72px";
	text6.style.textAlign = "center";
	
	
	
	
	var td61 = document.createElement ('td');
	td61.id = "idTDa1"+k+"";
	td61.align = "left";
	td61.valign = "top";
	td61.width = "11%";
	//td1.innerHTML = "<font size=\"10\"><strong>VEG BIRYANI ( 1 )</strong></font>";
	td61.style.backgroundColor = "#FFFFFF";
	td61.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+k+'" value="'+k+'" id="serialnumber'+k+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text61 = document.createElement ('input');
	text61.id = "itemnamea"+k+"";
	text61.name = "itemnamea"+k+"";
	text61.type = "hidden";
	text61.size = "1";
	text61.value = varItemName;
	text61.readOnly = "readonly";
	//text61.style.width = "100";
	//text61.style.height = "120";
	//text61.style.fontSize = "72px";
	text61.style.textAlign = "center";
	
	td1.appendChild (text1);
	td2.appendChild (text2);
	td2.appendChild (text21);
	td3.appendChild (text3);
	td4.appendChild (text4);
	td5.appendChild (text5);
	td6.appendChild (text6);
	td7.appendChild (text7);
	td51.appendChild (text51);
	td61.appendChild (text61);
	td611.appendChild (text611);
	
	tr.appendChild (td7);
	tr.appendChild (td1);
	tr.appendChild (td2);
	tr.appendChild (td25);
	tr.appendChild (td3);
	tr.appendChild (td4);
	tr.appendChild (td5);
	tr.appendChild (td6);
	tr.appendChild (td51);
	tr.appendChild (td61);
		tr.appendChild (td611);

	document.getElementById ('tblrowinsert').appendChild (tr);
	var diff = parseFloat(document.getElementById('total1').value).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById('total').innerHTML=  diff;
	 
	 	
	var amount= parseFloat(document.getElementById('total1').value).toFixed(2);
					document.getElementById("tdShowTotal").innerHTML =amount;
					document.getElementById("cashamount").value =amount;
				
							if(amount >= 5000 )
		{
			//alert(amount);
			var vat = (amount*10)/100;
			amount2=parseFloat(amount);
					 amount=amount2+vat;
					vat=parseFloat(vat).toFixed(2)
				
				vat = vat.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				
			document.getElementById("vat").value=vat;
			
			
			}
			else
			{
				document.getElementById("vat").value=0.0;
			}
			
			        var amount = parseFloat(amount).toFixed(2);
					amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					document.getElementById("subtotal").value = amount;
					var amount1=amount-Math.round(amount);
					document.getElementById("totalamount").value = amount;
					document.getElementById("roundoff").value = -amount1.toFixed(3);
	
				   document.getElementById("billtype").value == "";
					paymentinfo();	

}

function funcItemAddButtonClick(varItemSerialNumber,varItemRate)
{
	//alert ("Inside Add Function");
	var varItemSerialNumber = varItemSerialNumber;
	//alert (varItemSerialNumber);
	var p = varItemSerialNumber;
	if (document.getElementById('itemquantity'+p) != null) 
	{
		var varItemQuantityFound = "FOUND";
		var varItemQuantityFound = document.getElementById('itemquantity'+p).value;
		
	    	var varItemRateFound =  parseFloat(varItemRate);
		//alert (varItemRateFound);
		
		var varItemQuantityFound = parseInt(varItemQuantityFound) + 1;
		
		var varRate1=varItemQuantityFound*varItemRateFound;
		//alert (varItemQuantityFound);
		var varRate1 = parseFloat(varRate1).toFixed(2);
	    varRate1 = varRate1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById('rate'+p).value = varRate1;
		document.getElementById('itemquantity'+p).value = varItemQuantityFound;
		document.getElementById('itemquantityhidden'+p).value = varItemQuantityFound;
		
		document.getElementById('total1').value = parseFloat(document.getElementById('total1').value)+parseFloat(varItemRate);
		var diff = parseFloat(document.getElementById('total1').value).toFixed(2);
	    diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	    document.getElementById('total').innerHTML=  diff;
		
					
					var amount= parseFloat(document.getElementById('total1').value).toFixed(2);
					document.getElementById("tdShowTotal").innerHTML =amount;
					document.getElementById("cashamount").value =amount;
					if(amount >= 5000 )
		{
			//alert(amount);
			var vat = (amount*10)/100;
			amount2=parseFloat(amount);
					 amount=amount2+vat;
					vat=parseFloat(vat).toFixed(2)
				
				vat = vat.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				
			document.getElementById("vat").value=vat;
			
			}
			else
			{
				document.getElementById("vat").value=0.0;
			}
			
					 amount = parseFloat(amount).toFixed(2);
					amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					document.getElementById("subtotal").value = amount;
					var amount1=amount-Math.round(amount);
					document.getElementById("totalamount").value = amount;
					document.getElementById("roundoff").value = -amount1.toFixed(3);
					
				     document.getElementById("billtype").value == "";
					paymentinfo();			
					
					
		return false;
	}
	return false;
}

function funcItemMinusButtonClick(varItemSerialNumber,varItemRate)
{
	//alert ("Inside Minus Function");
	var varItemSerialNumber = varItemSerialNumber;
	//alert (varItemSerialNumber);
	var q = varItemSerialNumber;
	if (document.getElementById('itemquantity'+q) != null) 
	{
		var varItemQuantityFound = "FOUND";
		var varItemQuantityFound = document.getElementById('itemquantity'+q).value;
		//alert (varItemQuantityFound);
		var varItemQuantityFound = parseInt(varItemQuantityFound) - 1;
		
		var varItemRateFound =  parseFloat(varItemRate);

	 	
		var varItemQuantityFound = parseInt(varItemQuantityFound);
	
	
	if(varItemQuantityFound >= 0)
	{
	    document.getElementById('total1').value = parseFloat(document.getElementById('total1').value)-parseFloat(varItemRate);
		var diff = parseFloat(document.getElementById('total1').value).toFixed(2);
	    diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		 document.getElementById('total').innerHTML=  diff;
	}
	
	
		if (varItemQuantityFound < 0 )
		{
			varItemQuantityFound = 0;
		}
      
	  	var varRate1=(varItemRateFound*varItemQuantityFound).toFixed(2);	
		//alert(varRate1);
		var varRate1 = parseFloat(varRate1).toFixed(2);
	    varRate1 = varRate1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById('rate'+q).value = varRate1;
		document.getElementById('itemquantity'+q).value = varItemQuantityFound;
		document.getElementById('itemquantityhidden'+q).value = varItemQuantityFound;

    				 	var amount= parseFloat(document.getElementById('total1').value).toFixed(2);
					document.getElementById("tdShowTotal").innerHTML =amount;
					document.getElementById("cashamount").value =amount;
					if(amount >= 5000 )
		{
			//alert(amount);
			var vat = (amount*10)/100;
			amount2=parseFloat(amount);
					 amount=amount2+vat;
					vat=parseFloat(vat).toFixed(2)
				
				vat = vat.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				
			document.getElementById("vat").value=vat;
			
			
			}
			else
			{
				document.getElementById("vat").value=0.0;
			}
					
					 amount = parseFloat(amount).toFixed(2);
					amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					document.getElementById("subtotal").value = amount;
					var amount1=amount-Math.round(amount);
					document.getElementById("totalamount").value = amount;
					document.getElementById("roundoff").value = -amount1.toFixed(3);
					
			        document.getElementById("billtype").value == "";
					paymentinfo();	
	
		return false;
	}
	return false;
}

function funcItemDeleteButtonClick(varItemSerialNumber)
{
	//alert ("Inside Delete Function");
	var varItemSerialNumber = varItemSerialNumber;
	//alert (varItemSerialNumber);
	
	var varDeleteID = varItemSerialNumber;
	//alert (varDeleteID);
	var varDeleteItemName = document.getElementById("itemname"+varDeleteID).value;
	//alert (varDeleteItemName);
	var fRet3; 
	fRet3 = confirm('Remove Item '+varDeleteItemName+' ?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

var v11=document.getElementById('rate'+varDeleteID).value;
 var varRate100 = parseFloat(v11.replace(/,/g, ''));
	//alert(varRate100);
    				
    var varRate1=varRate100;
	//alert(varRate1);
    document.getElementById('total1').value = parseFloat(document.getElementById('total1').value)-varRate1;
	document.getElementById('total').innerHTML=  (parseFloat(document.getElementById('total1').value)).toFixed(2);
	
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('tblrowinsert'); // tbody name.
	document.getElementById ('tblrowinsert').removeChild(child);
	

					 	var amount= parseFloat(document.getElementById('total1').value).toFixed(2);
					document.getElementById("tdShowTotal").innerHTML =amount;
					document.getElementById("cashamount").value =amount;
					//alert(amount);
					
			if(amount >= 5000 )
		{
			//alert(amount);
			
			var vat = (amount*10)/100;
			
			amount2=parseFloat(amount);
			 amount=amount2+vat;
			 vat=parseFloat(vat).toFixed(2);
			vat = vat.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				
			document.getElementById("vat").value=vat;
			
			}
			else
			{
				document.getElementById("vat").value=0.0;
				
			}
					document.getElementById("subtotal").value = amount;
					var amount1=amount-Math.round(amount);
					document.getElementById("totalamount").value = amount;
					document.getElementById("roundoff").value = -amount1.toFixed(3);
					
				    document.getElementById("billtype").value == "";
					paymentinfo();	
	//alert ("Delete Item Entry Completed.");

	return false;
}


function funcFormValidation1()
{
	var varSerialNumberSet = 0;
	for (j=1;j<10;j++)
	{
		if (document.getElementById('serialnumber'+j) != null) 
		{
			varSerialNumberSet = document.getElementById('serialnumber'+j).value;
		}
	}

	if (varSerialNumberSet == 0)
	{
		alert ("Please Select Items To Place Order.");
		document.getElementById("tableanum").focus();
		return false;
	}

if(document.getElementById("paymenttype1").value=="1")
	{
		if(document.getElementById("searchemployeecode").value=='')
		{
			alert("Please Select Staff");
			document.getElementById("searchsuppliername").value="";
			document.getElementById("searchsuppliername").focus();
		return false;
		}
		if(document.getElementById("credit-textarea").value=='')
		{
			alert("Please Enter Text");
			document.getElementById("credit-textarea").focus();
		return false;
		}
	}
if(document.getElementById("paymenttype1").value=="0")
	{	
  if(parseFloat(document.getElementById("cashgivenbycustomer").value)<parseFloat(document.getElementById("cashamount").value))
	{
		alert("Entered Amount Lesser than Bill Amount");
		document.getElementById("cashgivenbycustomer").focus();
		return false;
	}
	}
	
	if (confirm("Do You Want To Save The Record?")==false){return false;}
	
	return true;
}



