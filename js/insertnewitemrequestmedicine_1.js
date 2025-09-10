itemcode = new Array();
function insertitem10()
{
if(document.getElementById("typetransfer").value=="Consumable"){

	var code = document.getElementById("medicinecode").value;
	var a = $.inArray(code, itemcode );
	if(a<0){
		itemcode.push(code);
		// alert(1);
	}
 
	}

	

	if(document.cbform1.medicinename.value=="" )

	{

		alert("Please enter medicine name");

		return false;

	}

	

	if(document.cbform1.medicinename.value=="undefined" )

	{

		alert("Please select medicine name");

		return false;

	}

	if(document.cbform1.medicinecode.value=="" )

	{

		alert("Please select medicinename from the List");

		return false;

	}

	if((document.getElementById("batch").value=="" ) && document.getElementById("typetransfer").value=="Transfer")

	{

		alert("Please select Batch");

		return false;

	}

	if(document.getElementById("typetransfer").value=="Consumable"){
		if($("#expenseledgercode").val()==''){
			alert('Expense Ledger Not Found!');
			return false;
		}
	}


	if(document.getElementById("transferqty").value=="" )

	{

		alert("Please Enter Transfer Qty");

		return false;

	}



	if(document.getElementById("transferqty").value=="" )

	{

		alert("Please Enter Transfer Qty");

		document.getElementById("transferqty").focus();

		return false;

	}

	if(document.getElementById("transferqty").value == 0 )

	{

		alert("Please Enter Valid Transfer Qty");

		document.getElementById("transferqty").focus();

		return false;

	}



	var varcostprice = document.getElementById("costprice").value;

	if(parseFloat(varcostprice) == 0)

	{

		alert("Cost Price Cannot be Zero");

		return false;

	}



	var varSerialNumber = document.getElementById("serialnumberinc").value;

	var varMedicineCode = document.getElementById("medicinecode").value;

	var varMedicineName = document.getElementById("medicinename").value;



	var varExpenseLedgerCode = document.getElementById("expenseledgercode").value;

	var varExpenseLedgerName = document.getElementById("expenseledgername").value;


	if(document.getElementById("typetransfer").value=="Transfer"){
		var varBatch = document.getElementById("batch").value;
	}else{
		var varBatch = document.getElementById("batch").value;
	}

	
	var varAvailablestock = document.getElementById("availablestock").value;

	var varTransferqty = document.getElementById("transferqty").value;

	var varcostprice = document.getElementById("costprice").value;

	var varAmount = document.getElementById("amount").value;

	var varexpdate = document.getElementById("expirydate").value;

	

	var varAvlQuantity = document.getElementById("availablestock").value;

	var vartransferqty = document.getElementById("transferqty").value;

		//alert(varpharmRate);

	



	var i = varSerialNumber;

	

	//alert(i);

	//alert (varMedicineName);

	//alert (i);

	//var tr = document.createElement ('<TR id="idTR'+i+'"></TR>');

	var tr = document.createElement ('TR');

	tr.id = "idTR"+i+"";

	

	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td1 = document.createElement ('td');

	td1.id = "serialnumbertd"+i+"";

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

	//td1.appendChild (text1);



	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');

	var text11 = document.createElement ('input');

	text11.id = "medicinecode"+i+"";

	text11.name = "medicinecode"+i+"";

	text11.type = "hidden";

	text11.align = "left";

	text11.size = "25";

	text11.value = varMedicineCode;

	text11.readOnly = "readonly";

	text11.style.backgroundColor = "#FFFFFF";

	text11.style.border = "0px solid #001E6A";

	text11.style.textAlign = "left";

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');

	var text10 = document.createElement ('input');

	text10.id = "medicinename"+i+"";

	text10.name = "medicinename"+i+"";

	text10.type = "text";

	text10.align = "left";

	text10.size = "25";

	text10.value = varMedicineName;

	text10.readOnly = "readonly";

	text10.style.backgroundColor = "#FFFFFF";

	text10.style.border = "0px solid #001E6A";

	text10.style.textAlign = "left";



	td1.appendChild (text1);

	td1.appendChild (text10);

	td1.appendChild (text11);

	tr.appendChild (td1);

	

	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	



	var td2 = document.createElement ('td');

	td2.id = "ledgernametd"+i+"";

	td2.align = "left";

	td2.valign = "top";

	td2.style.backgroundColor = "#FFFFFF";

	td2.style.border = "0px solid #001E6A";

	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');

	var text2 = document.createElement ('input');

	text2.id = "ledgername"+i+"";

	text2.name = "ledgername"+i+"";

	text2.type = "text";

	text2.size = "25";

	text2.value = varExpenseLedgerName;

	text2.readOnly = "readonly";

	text2.style.backgroundColor = "#FFFFFF";

	text2.style.border = "0px solid #001E6A";

	text2.style.textAlign = "left";

	td2.appendChild (text2);





	var text22 = document.createElement ('input');

	text22.id = "ledgercode"+i+"";

	text22.name = "ledgercode"+i+"";

	text22.type = "hidden";

	text22.size = "10";

	text22.value = varExpenseLedgerCode;

	//text22.readOnly = "readonly";

	text22.style.backgroundColor = "#FFFFFF";

	text22.style.border = "0px solid #001E6A";

	text22.style.textAlign = "left";



	td2.appendChild (text22);

	tr.appendChild (td2);







	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td3 = document.createElement ('td');

	td3.id = "batchtd"+i+"";

	td3.align = "left";

	td3.valign = "top";

	td3.style.backgroundColor = "#FFFFFF";

	td3.style.border = "0px solid #001E6A";

	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');

	var text3 = document.createElement ('input');

	text3.id = "batch"+i+"";

	text3.name = "batch"+i+"";

	text3.type = "text";

	text3.size = "10";

	text3.value = varBatch;

	text3.readOnly = "readonly";

	text3.style.backgroundColor = "#FFFFFF";

	text3.style.border = "0px solid #001E6A";

	text3.style.textAlign = "left";

	td3.appendChild (text3);

	tr.appendChild (td3);

	

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td31 = document.createElement ('td');

	td31.id = "expdatetd"+i+"";

	td31.align = "left";

	td31.valign = "top";

	td31.style.backgroundColor = "#FFFFFF";

	td31.style.border = "0px solid #001E6A";

	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');

	var text31 = document.createElement ('input');

	text31.id = "expdate"+i+"";

	text31.name = "expdate"+i+"";

	text31.type = "text";

	text31.size = "10";

	text31.value = varexpdate;

	text31.readOnly = "readonly";

	text31.style.backgroundColor = "#FFFFFF";

	text31.style.border = "0px solid #001E6A";

	text31.style.textAlign = "left";

	td31.appendChild (text31);

	tr.appendChild (td31);





	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');



	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td5 = document.createElement ('td');

	td5.id = "avlquantitytd"+i+"";

	td5.align = "left";

	td5.valign = "top";

	td5.style.backgroundColor = "#FFFFFF";

	td5.style.border = "0px solid #001E6A";

	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');

	var text5 = document.createElement ('input');

	text5.id = "avlquantity"+i+"";

	text5.name = "avlquantity"+i+"";

	text5.type = "text";

	text5.size = "8";

	text5.value = varAvlQuantity;

	text5.readOnly = "readonly";

	text5.style.backgroundColor = "#FFFFFF";

	text5.style.border = "0px solid #001E6A";

	text5.style.textAlign = "left";

	td5.appendChild (text5);

	tr.appendChild (td5);





	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td51 = document.createElement ('td');

	td51.id = "tnxquantitytd"+i+"";

	td51.align = "left";

	td51.valign = "top";

	td51.style.backgroundColor = "#FFFFFF";

	td51.style.border = "0px solid #001E6A";

	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');

	var text51 = document.createElement ('input');

	text51.id = "tnxquantity"+i+"";

	text51.name = "tnxquantity"+i+"";

	text51.type = "text";

	text51.size = "8";

	text51.value = vartransferqty;

	text51.readOnly = "readonly";

	text51.style.backgroundColor = "#FFFFFF";

	text51.style.border = "0px solid #001E6A";

	text51.style.textAlign = "left";

	td51.appendChild (text51);

	tr.appendChild (td51);

	

	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td52 = document.createElement ('td');

	td52.id = "costpricetd"+i+"";

	td52.align = "left";

	td52.valign = "top";

	td52.style.backgroundColor = "#FFFFFF";

	td52.style.border = "0px solid #001E6A";

	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');

	var text52 = document.createElement ('input');

	text52.id = "costprice"+i+"";

	text52.name = "costprice"+i+"";

	text52.type = "text";

	text52.size = "8";

	text52.value = varcostprice;

	text52.readOnly = "readonly";

	text52.style.backgroundColor = "#FFFFFF";

	text52.style.border = "0px solid #001E6A";

	text52.style.textAlign = "right";

	td52.appendChild (text52);

	tr.appendChild (td52);

	

	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td53 = document.createElement ('td');

	td53.id = "amounttd"+i+"";

	td53.align = "left";

	td53.valign = "top";

	td53.style.backgroundColor = "#FFFFFF";

	td53.style.border = "0px solid #001E6A";

	//var text5 = document.createElement ('<input name="rateperunit'+i+'" value="'+varItemMRP+'" id="rateperunit'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="6" />');

	var text53 = document.createElement ('input');

	text53.id = "amount"+i+"";

	text53.name = "amount"+i+"";

	text53.type = "text";

	text53.size = "8";

	text53.value = varAmount;

	text53.readOnly = "readonly";

	text53.style.backgroundColor = "#FFFFFF";

	text53.style.border = "0px solid #001E6A";

	text53.style.textAlign = "left";

	td53.appendChild (text53);

	tr.appendChild (td53);



	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	



	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	var td10 = document.createElement ('td');

	td10.id = "btndeletetd"+i+"";

	td10.align = "left";

	td10.valign = "top";

	td10.style.backgroundColor = "#FFFFFF";

	td10.style.border = "0px solid #001E6A";

	

	

	var text11 = document.createElement ('input');

	text11.id = "btndelete"+i+"";

	text11.name = "btndelete"+i+"";

	text11.type = "button";

	text11.value = "Del";

	text11.style.border = "1px solid #001E6A";

	text11.onclick = function() { return btnDeleteClick10(i); }

	//td10.appendChild (text10);

	td10.appendChild (text11);

	tr.appendChild (td10);



    document.getElementById ('insertrow').appendChild (tr);

	

	

	//var i = parseInt(varSerialNumber)+parseInt(1);

	//document.getElementById("serialnumber").value = i + 1;

	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);

	

	//alert (varItemSerialNumberInsert);

	document.getElementById("serialnumberinc").value = parseInt(i) + 1;

	

	

	

	

	var varMedicineName = document.getElementById("medicinename").value = "";

	var varMedicineCode = document.getElementById("medicinecode").value = "";

	var varBatch = "";

	var varAvailablestock = document.getElementById("availablestock").value = "";

	var varTransferqty = document.getElementById("transferqty").value = "";

	var varcostprice = document.getElementById("costprice").value = "";

	var varAmount = document.getElementById("amount").value = "";

	var varexpdate = document.getElementById("expirydate").value = "";

	

	var varAvlQuantity = document.getElementById("availablestock").value = "";

	var vartransferqty = document.getElementById("transferqty").value = "";

		//alert(varpharmRate);

	

	document.getElementById("batch").options.length = null;

	var combo = document.getElementById("batch");

	combo.options[0] = new Option("Select Batch","");

	



	document.getElementById("expenseledgername").value = '';

	document.getElementById("expenseledgercode").value = '';



	document.getElementById("medicinename").focus();

	

	window.scrollBy(0,5); 

	return true;



}

