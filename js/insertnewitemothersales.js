// JavaScript Document// JavaScript Document

function insertitem5()

{

	

	if(document.form1.searchaccountcode.value=="")

	{

		alert("Please select valid account");

		document.form1.searchaccountname.value=="";

		document.form1.searchaccountname.focus();

		return false;  

	}

	

	if(document.form1.referal.value=="")

	{

		alert("Please enter referal name");

		document.form1.referal.focus();

		return false;

	}

	if(document.form1.units.value=="")

	{

		alert("Please enter unit");

		document.form1.units.focus();

		return false;

	}

	if(document.form1.rate4.value=="")

	{

		alert("Please enter rate");

		document.form1.rate4.focus();

		return false;

	}

	if(document.form1.amount.value=="")

	{

		alert("Please enter amount");

		document.form1.amount.focus();

		return false;

	}

	var scode=document.getElementById("scode").value;
	var varamount_new=0;

	scode=parseInt(scode)+1;

	document.getElementById("scode").value=scode;

	var varSerialNumber41 = document.getElementById("serialnumber4").value;

	var varreferal = document.getElementById("referal").value;

	var varrefRate = document.getElementById("rate4").value;

	var varunits = document.getElementById("units").value;

	//var varamount = Number(document.getElementById("amount").value.replace(/[^0-9\.]+/g,""));
	var varamount =document.getElementById("amount").value;
	varamount_new = document.getElementById("amount").value;

	varamount=varamount.replace(/,/g,'');
	varamount_new=varamount_new.replace(/,/g,'');

	var varaccountname= document.getElementById("searchaccountname").value;

	var varaccountcode= document.getElementById("searchaccountcode").value;

	

	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
	if(document.getElementById('total_amt').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=Number(document.getElementById("total_amt").value.replace(/[^0-9\.]+/g,""));
	}
	
	totalamount1=parseFloat(totalamount2) + parseFloat(varamount);
	
	
	

	var n = varSerialNumber4;

	//alert(n);

	

	var tr = document.createElement ('TR');

	tr.id = "idTR"+n+"";

	

	var td1 = document.createElement ('td');

	td1.id = "serialnumber4"+n+"";

	

	td1.valign = "top";

	td1.style.backgroundColor = "#FFFFFF";

	td1.style.border = "0px solid #001E6A";

	

	var text1 = document.createElement ('input');

	text1.id = "serialnumber4"+n+"";

	text1.name = "serialnumber4"+n+"";

	text1.type = "hidden";

	text1.size = "25";

	text1.value = varSerialNumber4;

	text1.readOnly = "readonly";

	text1.style.backgroundColor = "#FFFFFF";

	text1.style.border = "0px solid #001E6A";

	text1.style.textAlign = "left";

	td1.appendChild (text1);

	

	



	var text11 = document.createElement ('input');

	text11.id = "accountname"+n+"";

	text11.name = "accountname[]"+n+"";

	text11.type = "text";

	text11.align = "left";

	text11.size = "32";

	text11.value = varaccountname;

	text11.readOnly = "readonly";

	text11.style.backgroundColor = "#FFFFFF";

	text11.style.border = "0px solid #001E6A";

	text11.style.textAlign = "left";

	

	var text011 = document.createElement ('input');

	text011.id = "accountcode"+n+"";

	text011.name = "accountcode[]"+n+"";

	text011.type = "hidden";

	text011.align = "left";

	text011.size = "32";

	text011.value = varaccountcode;

	text011.readOnly = "readonly";

	text011.style.backgroundColor = "#FFFFFF";

	text011.style.border = "0px solid #001E6A";

	text011.style.textAlign = "left";



	td1.appendChild (text1);

	td1.appendChild (text11);

	td1.appendChild (text011);

	tr.appendChild (td1);

	

	var td2 = document.createElement ('td');

	td2.id = "referal"+n+"";

	td2.align = "left";

	td2.valign = "top";

	td2.style.backgroundColor = "#FFFFFF";

	td2.style.border = "0px solid #001E6A";

	var text21 = document.createElement ('input');

	text21.id = "referal"+n+"";

	text21.name = "referal[]"+n+"";

	text21.type = "text";

	text21.align = "left";

	text21.size = "32";

	text21.value = varreferal;

	text21.readOnly = "readonly";

	text21.style.backgroundColor = "#FFFFFF";

	text21.style.border = "0px solid #001E6A";

	text21.style.textAlign = "left";



	td2.appendChild (text21);

	tr.appendChild (td2);

	

	var td3 = document.createElement ('td');

	td3.id = "units"+n+"";

	td3.align = "left";

	td3.valign = "top";

	td3.style.backgroundColor = "#FFFFFF";

	td3.style.border = "0px solid #001E6A";

	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');

	var text3 = document.createElement ('input');

	text3.id = "units"+n+"";

	text3.name = "units[]"+n+"";

	text3.type = "text";

	text3.size = "8";

	text3.value = varunits;

	text3.readOnly = "readonly";

	text3.style.backgroundColor = "#FFFFFF";

	text3.style.border = "0px solid #001E6A";

	text3.style.textAlign = "left";

	td3.appendChild (text3);

	tr.appendChild (td3);

	

	

	var td8 = document.createElement ('td');

	td8.id = "rate4"+n+"";

	td8.align = "left";

	td8.valign = "top";

	td8.style.backgroundColor = "#FFFFFF";

	td8.style.border = "0px solid #001E6A";

	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');

	var text8 = document.createElement ('input');

	text8.id = "rate4"+n+"";

	text8.name = "rate4[]"+n+"";

	text8.type = "text";

	text8.size = "8";

	text8.value = varrefRate;

	text8.readOnly = "readonly";

	text8.style.backgroundColor = "#FFFFFF";

	text8.style.border = "0px solid #001E6A";

	text8.style.textAlign = "left";

	td8.appendChild (text8);

	tr.appendChild (td8);

	

	var td7 = document.createElement ('td');

	td7.id = "amount"+n+"";

	td7.align = "left";

	td7.valign = "top";

	td7.style.backgroundColor = "#FFFFFF";

	td7.style.border = "0px solid #001E6A";

	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');

	var text7 = document.createElement ('input');

	text7.id = "amount"+n+"";

	text7.name = "amount[]"+n+"";

	text7.type = "text";

	text7.size = "8";

	text7.value = varamount;

	text7.readOnly = "readonly";

	text7.style.backgroundColor = "#FFFFFF";

	text7.style.border = "0px solid #001E6A";

	text7.style.textAlign = "left";

	td7.appendChild (text7);

	tr.appendChild (td7);

	

	var td10 = document.createElement ('td');

	td10.id = "btndelete4"+n+"";

	td10.align = "right";

	td10.valign = "top";

	td10.style.backgroundColor = "#FFFFFF";

	td10.style.border = "0px solid #001E6A";

	

	

	var text11 = document.createElement ('input');

	text11.id = "btndelete4"+n+"";

	text11.name = "btndelete4"+n+"";

	text11.type = "button";

	text11.value = "Del";

	text11.style.border = "1px solid #001E6A";

	text11.onclick = function() { return btnDeleteClick4(n,varamount_new); }

	

	

	td10.appendChild (text11);

	tr.appendChild (td10);

	



    document.getElementById ('insertrow4').appendChild (tr);

	

	

	//var i = parseInt(varSerialNumber)+parseInt(1);

	document.getElementById("serialnumber4").value = parseInt(n) + 1;

	document.getElementById("total_amt").value=formatMoney(totalamount1);
	document.getElementById("grand_total").value=formatMoney(totalamount1);

		

	

	var varreferal = document.getElementById("referal").value = '';

	var varrefRate = document.getElementById("rate4").value = '';

	var varunits = document.getElementById("units").value = '';

	var varamount = document.getElementById("amount").value = '';

	document.getElementById("searchaccountname").value = '';

	document.getElementById("searchaccountname").focus();

	

	window.scrollBy(0,5); 

	return true;



}