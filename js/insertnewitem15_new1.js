// JavaScript Document// JavaScript Document
function insertitem5()
{
	
	if(document.form1.referalcode.value=="")
	{
		alert("Please enter referal name");
		document.form1.referal.focus();
		return false;
	}
	if(document.form1.rate4.value=="" || parseFloat(document.form1.rate4.value)=="0.00")
	{
		alert("Please enter rate");
		document.form1.rate4.focus();
		return false;
	}
	var varSerialNumber41 = document.getElementById("serialnumber4").value;
	var varreferal = document.getElementById("referal").value;
	var varref = document.getElementById("rate4").value;	var varremark = document.getElementById("remark4").value;
	var referalcode = document.getElementById("referalcode").value;
	var varrefRate = Number(varref.replace(/[^0-9\.]+/g,""));
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
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
	
	var text12 = document.createElement ('input');
	text12.id = "referalcode"+n+"";
	text12.name = "referalcode[]"+n+"";
	text12.type = "hidden";
	text12.align = "left";
	text12.size = "25";
	text12.value = referalcode;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text11 = document.createElement ('input');
	text11.id = "referal"+n+"";
	text11.name = "referal[]"+n+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varreferal;
	text11.readOnly = "readonly";	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	tr.appendChild (td1);
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
	text8.value = formatMoney(varrefRate);
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);				var td9 = document.createElement ('td');
	td9.id = "remarktd4"+n+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	var text9 = document.createElement ('input');
	text9.id = "remark4"+n+"";
	text9.name = "remark4[]"+n+"";
	text9.type = "text";
	text9.size = "30";
	text9.value = varremark;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
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
	text11.onclick = function() { return btnDeleteClick4(n,varrefRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	

    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber4").value = parseInt(n) + 1;
	
		if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	total4=document.getElementById('total5').value;
	totalamount4=Number(total4.replace(/[^0-9\.]+/g,""));
	}
	
	
	
     
	//alert(vRate);
	totalamount4=parseInt(totalamount4) + parseInt(varrefRate);
	
	document.getElementById("total5").value=formatMoney(totalamount4);
	
	
	
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalr=document.getElementById('totalr').value;
	totalamountr=Number(totalr.replace(/[^0-9\.]+/g,""));
	}
	
	//alert(totalamount4);
	
//	grandtotal= parseInt(totalamount)+parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3)+parseInt(totalamount4);

grandtotal= parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	
	
	
		document.getElementById("referalcode").value = "";
	var varLab = document.getElementById("referal").value = "";
	var varRate = document.getElementById("rate4").value = "";	var varRemark = document.getElementById("remark4").value = "";
	
	document.getElementById("referal").focus();
	document.getElementById("Add4").disabled=true;
	document.getElementById("referal").disabled=true;	document.getElementById("remark4").disabled=true;
	document.getElementById("rate4").disabled=true;
	
	window.scrollBy(0,5); 
	return true;

}