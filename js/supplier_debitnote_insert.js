function insertitem10()

{

	if(document.getElementById("amount").value=="0.00" || document.getElementById("amount").value=="")

	{

		alert("Purchase Amount can not be zero");

		document.getElementById("reqqty").focus();

		return false;

	}
	if( document.getElementById("expense").value=="")

	{

		alert("Select the Ledger");

		document.getElementById("expense").focus();

		return false;

	}

	

	

	var varSerialNumber = document.getElementById("serialnumber").value;

	var varMedicineName = document.getElementById("medicinename").value;
	var varReqqty = document.getElementById("req_qty").value;
	var varTax = document.getElementById("tax_percent").value;
	var varpharmRate = document.getElementById("rate_fx").value;
	var varpharmAmount = document.getElementById("amount").value;
	var varExpense = document.getElementById("expense").value;
	var varExpenseno = document.getElementById("expenseno").value;
	// var vardescription = document.getElementById("description").value;
	var vartaxamount = document.getElementById("taxamount").value;
	var i = varSerialNumber;

	
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


    
	var td1 = document.createElement ('td');
	td1.id = "medicinename"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');

	var text11 = document.createElement ('input');

	text11.id = "medicinename"+i+"";

	text11.name = "medicinename"+i+"";

	text11.type = "text";

	text11.align = "left";

	text11.size = "25";

	text11.value = varMedicineName;

	text11.readOnly = "readonly";

	text11.style.backgroundColor = "#FFFFFF";

	text11.style.border = "0px solid #001E6A";

	text11.style.textAlign = "left";



	td1.appendChild (text1);

	td1.appendChild (text11);

	tr.appendChild (td1);

	

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	// var td3331 = document.createElement ('td');
	// td3331.id = "description"+i+"";
	// td3331.align = "left";
	// td3331.valign = "top";
	// td3331.style.backgroundColor = "#FFFFFF";
	// td3331.style.border = "0px solid #001E6A";
	// var text3331 = document.createElement ('input');
	// text3331.id = "description"+i+"";
	// text3331.name = "description"+i+"";
	// text3331.type = "text";
	// text3331.size = "16";
	// text3331.value = vardescription;
	// text3331.readOnly = "readonly";
	// text3331.style.backgroundColor = "#FFFFFF";
	// text3331.style.border = "0px solid #001E6A";
	// text3331.style.textAlign = "left";
	// td3331.appendChild (text3331);
	// tr.appendChild (td3331);

	//////////////////
	var td3 = document.createElement ('td');

	td3.id = "reqqty"+i+"";

	td3.align = "left";

	td3.valign = "top";

	td3.style.backgroundColor = "#FFFFFF";

	td3.style.border = "0px solid #001E6A";

	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');

	var text3 = document.createElement ('input');

	text3.id = "reqqty"+i+"";

	text3.name = "reqqty"+i+"";

	text3.type = "hidden";

	text3.size = "16";

	text3.value = varReqqty;

	text3.readOnly = "readonly";

	text3.style.backgroundColor = "#FFFFFF";

	text3.style.border = "0px solid #001E6A";

	text3.style.textAlign = "left";

	td3.appendChild (text3);

	tr.appendChild (td3);
	////////////////




	var td8 = document.createElement ('td');
	td8.id = "rate"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate"+i+"";
	text8.name = "rate"+i+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varpharmRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);




	var td812 = document.createElement ('td');

	td812.id = "tax_percent"+i+"";

	td812.align = "left";

	td812.valign = "top";

	td812.style.backgroundColor = "#FFFFFF";

	td812.style.border = "0px solid #001E6A";

	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');

	var text812 = document.createElement ('input');

	text812.id = "tax_percent"+i+"";

	text812.name = "tax_percent"+i+"";

	text812.type = "text";

	text812.size = "8";

	text812.value = varTax;

	text812.readOnly = "readonly";

	text812.style.backgroundColor = "#FFFFFF";

	text812.style.border = "0px solid #001E6A";

	text812.style.textAlign = "left";

	td812.appendChild (text812);

	tr.appendChild (td812);


	var td3331 = document.createElement ('td');
	td3331.id = "taxamount"+i+"";
	td3331.align = "left";
	td3331.valign = "top";
	td3331.style.backgroundColor = "#FFFFFF";
	td3331.style.border = "0px solid #001E6A";
	var text3331 = document.createElement ('input');
	text3331.id = "taxamount"+i+"";
	text3331.name = "taxamount"+i+"";
	text3331.type = "text";
	text3331.size = "8";
	text3331.value = vartaxamount;
	text3331.readOnly = "readonly";
	text3331.style.backgroundColor = "#FFFFFF";
	text3331.style.border = "0px solid #001E6A";
	text3331.style.textAlign = "left";
	td3331.appendChild (text3331);
	tr.appendChild (td3331);





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

	//////////////
	var td71 = document.createElement ('td');
	td71.id = "expense"+i+"";
	td71.align = "left";
	td71.valign = "top";
	td71.style.backgroundColor = "#FFFFFF";
	td71.style.border = "0px solid #001E6A";
	var text71 = document.createElement ('input');
	text71.id = "expense"+i+"";
	text71.name = "expense"+i+"";
	text71.type = "text";
	text71.size = "25";
	text71.value = varExpense;
	text71.readOnly = "readonly";
	text71.style.backgroundColor = "#FFFFFF";
	text71.style.border = "0px solid #001E6A";
	text71.style.textAlign = "left";
	td71.appendChild (text71);
	tr.appendChild (td71);


	var td72 = document.createElement ('td');
	td72.id = "expense"+i+"";
	td72.align = "left";
	td72.valign = "top";
	td72.style.backgroundColor = "#FFFFFF";
	td72.style.border = "0px solid #001E6A";
	var text72 = document.createElement ('input');
	text72.id = "expenseno"+i+"";
	text72.name = "expenseno"+i+"";
	text72.type = "hidden";
	text72.size = "8";
	text72.value = varExpenseno;
	text72.readOnly = "readonly";
	text72.style.backgroundColor = "#FFFFFF";
	text72.style.border = "0px solid #001E6A";
	text72.style.textAlign = "left";
	td72.appendChild (text72);
	 tr.appendChild (td72);
	/////////////////

	

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
	text11.onclick = function() { 
		return btnDeleteClick10(i,varpharmAmount.replace(/[^0-9\.]+/g,""),vartaxamount.replace(/[^0-9\.]+/g,""),varpharmRate.replace(/[^0-9\.]+/g,"")); 
		// return btnDeleteClick(i,vartaxamount.replace(/[^0-9\.]+/g,""));   
		// return btnDeleteClick10(i,varpharmRate.replace(/[^0-9\.]+/g,"")); 
		// var vartaxamount=0;
		// var varpharmRate=0;

	}
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);



    document.getElementById ('insertrow').appendChild (tr);
	
	document.getElementById("serialnumber").value = parseInt(i) + 1;

	if(document.getElementById('total').value=='')
	{
	var totalamount='0';
	}
	else
	{
	var totalamount=document.getElementById('total').value;
	}

	if(document.getElementById('total_tax').value==''){
		var totalamount_tax='0';
	}else{
	var totalamount_tax=document.getElementById('total_tax').value;
	}

	if(document.getElementById('total_amount').value=='') {
	var totalamount_without_tax='0';
	} else {
	var totalamount_without_tax=document.getElementById('total_amount').value;
	}

	// alert(totalamount);
	totalamount=parseFloat(totalamount.replace(/[^0-9\.]+/g,"")) + parseFloat(varpharmAmount.replace(/[^0-9\.]+/g,""));
	totalamount_tax=parseFloat(totalamount_tax.replace(/[^0-9\.]+/g,"")) + parseFloat(vartaxamount.replace(/[^0-9\.]+/g,""));
	totalamount_without_tax=parseFloat(totalamount_without_tax.replace(/[^0-9\.]+/g,"")) + parseFloat(varpharmRate.replace(/[^0-9\.]+/g,""));
	//alert(totalamount);
	document.getElementById("total").value=formatMoney(totalamount.toFixed(2));
	document.getElementById("total_tax").value=formatMoney(totalamount_tax.toFixed(2));
	document.getElementById("total_amount").value=formatMoney(totalamount_without_tax.toFixed(2));

	var varMedicineName = document.getElementById("medicinename").value = "";
	var varReqqty = document.getElementById("req_qty").value = "1";
	var varRate = document.getElementById("rate_fx").value = "";
	var varTaxF = document.getElementById("tax_percent").value = "";
	var varAmount = document.getElementById("amount").value = "";
	var varTaxamount1 = document.getElementById("taxamount").value = "";
	var varExpense1 = document.getElementById("expense").value = "";
	var varExpenseno1 = document.getElementById("expenseno").value = "";

	document.getElementById("medicinename").focus();

	window.scrollBy(0,5); 


// currencyfix();
	return true;

}

