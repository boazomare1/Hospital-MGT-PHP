function insertitem10()
{

	if(document.getElementById("purchasetype").value == "non-medical" || document.getElementById("purchasetype").value == "ASSETS")

	{
		
		if(document.form1.medicinename.value=="")

	{

		alert("Please enter medicine name");

		document.form1.medicinename.focus();

		return false;

	}

	}

	else

	{

	if(document.form1.medicinecode.value=="")

	{

		alert("Please enter medicine name");

		document.form1.medicinename.focus();

		return false;

	}

	}

	if(document.getElementById("amount").value=="0.00" || document.getElementById("amount").value=="")

	{

		alert("Purchase Amount can not be zero");

		document.getElementById("reqqty").focus();

		return false;

	}

	

	var itemscode=document.getElementById("medicinecode").value;
    itemscode=itemscode.trim();
	if($("#medcode"+itemscode).length >0) {
	    var confirm1=confirm("Item has been already added above. Do you like to ADD ? If yes Click OK else Cancel");
		if(confirm1 == false) 
		{
		   $("#medicinename").val('');
		   $("#avlqty").val('');
		   $("#reqqty").val('');
		   $("#packsize").val('');
		   $("#pkgqty").val('');
		   $("#rate").val('');
		   $("#amount").val('');
		   return false;
		}

       
	}

	//var varSerialNumber = document.getElementById("serialnumber").value;

	//var varSerialNumber = $('#itemscnt').val();
	var table = $("#insertrow");

	if (table.children().length == 0) {
	   console.log('table is empty')
	   //varSerialNumber = parseInt(varSerialNumber) + 1;

	    // increment items count variable
		var itemscnt = $('#itemscnt').val();

		itemscnt = parseInt(itemscnt) + 1;

		$('#itemscnt').val(itemscnt);

	}
	/*else
	{
		 console.log('table is not empty')
		 varSerialNumber = varSerialNumber;
	}*/

	var varSerialNumber = $('#itemscnt').val();

	var varMedicineName = document.getElementById("medicinename").value;

	var varAvlqty = document.getElementById("avlqty").value;

	var varReqqty = document.getElementById("reqqty").value;

	var varPacksize = document.getElementById("packsize").value;

	var varPkgqty = document.getElementById("pkgqty").value;



	var varpharmRate = document.getElementById("rate").value;

	//alert(varpharmRate);

	var varpharmAmount = document.getElementById("amount").value;

 

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


    
	var td1 = document.createElement ('td');
	td1.id = "medcode"+itemscode+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "medcode"+itemscode+"";
	text1.name = "medcode"+itemscode+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = itemscode;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);


	var text111 = document.createElement ('input');
	//text1.id = "medicinecode"+i+"";
	text111.name = "medicinecode"+i+"";
	text111.type = "hidden";
	text111.size = "15";
	text111.value = itemscode;
	text111.readOnly = "readonly";
	text111.style.backgroundColor = "#FFFFFF";
	text111.style.border = "0px solid #001E6A";
	text111.style.textAlign = "left";
	td1.appendChild (text111);


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

	td2.id = "avlqty"+i+"";

	td2.align = "left";

	td2.valign = "top";

	td2.style.backgroundColor = "#FFFFFF";

	td2.style.border = "0px solid #001E6A";

	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');

	var text2 = document.createElement ('input');

	text2.id = "avlqty"+i+"";

	text2.name = "avlqty"+i+"";

	text2.type = "text";

	text2.size = "8";

	text2.value = varAvlqty;

	text2.readOnly = "readonly";

	text2.style.backgroundColor = "#FFFFFF";

	text2.style.border = "0px solid #001E6A";

	text2.style.textAlign = "left";

	td2.appendChild (text2);

	tr.appendChild (td2);





	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

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

	text3.type = "text";

	text3.size = "16";

	text3.value = varReqqty;

	text3.readOnly = "readonly";

	text3.style.backgroundColor = "#FFFFFF";

	text3.style.border = "0px solid #001E6A";

	text3.style.textAlign = "left";

	td3.appendChild (text3);

	tr.appendChild (td3);





	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');



	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td5 = document.createElement ('td');

	td5.id = "packsize"+i+"";

	td5.align = "left";

	td5.valign = "top";

	td5.style.backgroundColor = "#FFFFFF";

	td5.style.border = "0px solid #001E6A";

	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');

	var text5 = document.createElement ('input');

	text5.id = "packsize"+i+"";

	text5.name = "packsize"+i+"";

	text5.type = "text";

	text5.size = "8";

	text5.value = varPacksize;

	text5.readOnly = "readonly";

	text5.style.backgroundColor = "#FFFFFF";

	text5.style.border = "0px solid #001E6A";

	text5.style.textAlign = "left";

	td5.appendChild (text5);

	tr.appendChild (td5);







	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td6 = document.createElement ('td');

	td6.id = "pkgqty"+i+"";

	td6.align = "left";

	td6.valign = "top";

	td6.style.backgroundColor = "#FFFFFF";

	td6.style.border = "0px solid #001E6A";

	//var text6 = document.createElement ('<input name="quantity'+i+'" value="'+varItemQuantity+'" id="quantity'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="4" />');

	var text6 = document.createElement ('input');

	text6.id = "pkgqty"+i+"";

	text6.name = "pkgqty"+i+"";

	text6.type = "text";

	text6.size = "4";

	text6.value = varPkgqty;

	text6.readOnly = "readonly";

	text6.style.backgroundColor = "#FFFFFF";

	text6.style.border = "0px solid #001E6A";

	text6.style.textAlign = "left";

	td6.appendChild (text6);

	tr.appendChild (td6);





	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	



	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

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

	text81.className = "amountaddeddyn";

	text81.style.backgroundColor = "#FFFFFF";

	text81.style.border = "0px solid #001E6A";

	text81.style.textAlign = "left";

	td81.appendChild (text81);

	tr.appendChild (td81);

	

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

	text11.onclick = function() { return btnDeleteClick10(i,varpharmAmount.replace(/[^0-9\.]+/g,"")); }

	//td10.appendChild (text10);

	td10.appendChild (text11);

	tr.appendChild (td10);



    document.getElementById ('insertrow').appendChild (tr);

	currencyfix();

	

	//var i = parseInt(varSerialNumber)+parseInt(1);

	//document.getElementById("serialnumber").value = i + 1;

	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);

	

	//alert (varItemSerialNumberInsert);

	document.getElementById("serialnumber").value = parseInt(i) + 1;

	

	if(document.getElementById('total').value=='')

	{

	var totalamount='0';

	}

	else

	{

	var totalamount=document.getElementById('total').value;

	}

	

	

	totalamount=parseFloat(totalamount.replace(/[^0-9\.]+/g,"")) + parseFloat(varpharmAmount.replace(/[^0-9\.]+/g,""));

	//alert(totalamount);

	document.getElementById("total").value=formatMoney(totalamount.toFixed(2));

	

	var varMedicineName = document.getElementById("medicinename").value = "";

	var varAvlqty = document.getElementById("avlqty").value = "";

	var varReqqty = document.getElementById("reqqty").value = "";

	var varPacksize = document.getElementById("packsize").value = "";

	var varPkgqty = document.getElementById("pkgqty").value = "";

	var varRate = document.getElementById("rate").value = "";

	var varAmount = document.getElementById("amount").value = "";

	
    // increment items count variable
	var itemscnt = $('#itemscnt').val();

	itemscnt = parseInt(itemscnt) + 1;

	$('#itemscnt').val(itemscnt);

	document.getElementById("medicinename").focus();

	

	window.scrollBy(0,5); 

	return true;



}

