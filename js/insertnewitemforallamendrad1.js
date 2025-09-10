// JavaScript Document// JavaScript Document
function insertitem7()
{
	
	if(document.form1.radiology.value=="")
	{
		alert("Please enter radiology name");
		document.form1.radiology.focus();
		return false;
	}
	if(document.form1.rate8.value=="")
	{
		alert("Please enter rate");
		document.form1.rate8.focus();
		return false;
	}
	var varSerialNumber2 = document.getElementById("serialnumber2").value;
	var varRadiology = document.getElementById("radiology").value;
	var varradRate = document.getElementById("rate8").value;

	
	var varradsno = document.getElementById("radsno").value;
	//alert(varlabsno);
	if(varradsno=='')
	{
	varradsno=0;	
	}
	var a=1;
	//alert(a);
	var varradsno1=parseInt(varradsno)+parseInt(a);
	
	//alert('h');
	//alert(varradsno1);
	var k = varSerialNumber2;
	
	var tr = document.createElement ('TR');
	tr.id = "radidTR"+varradsno1+"";
	
	var td1 = document.createElement ('td');
	td1.id = "radiology"+varradsno1+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber2"+varradsno1+"";
	text1.name = "serialnumber2"+varradsno1+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var td101 = document.createElement ('td');
	td101.id = "serialnumber"+varradsno1+"";
	//td1.align = "left";
	td101.valign = "top";
	td101.style.backgroundColor = "#FFFFFF";
	td101.style.border = "0px solid #001E6A";

	
	
	var text10 = document.createElement ('input');
	text10.id = "radcheck"+varradsno1+"";
	text10.name = "radcheck["+varradsno1+"]";
	text10.type = "checkbox";
	text10.align = "left";
	text10.size = "10";
	text10.value = varradsno1;
	text10.readOnly = "readonly";
	text10.style.backgroundColor = "#FFFFFF";
	text10.style.border = "0px solid #001E6A";
	text10.style.textAlign = "left";
	text10.onclick = function() {  selectselect('rad',varradsno1),approvalfunction("radcheck"+varradsno1+"",varradRate); }

	//td1.appendChild (text1);
	td101.appendChild (text10);
	tr.appendChild (td101);
	
	
	var text11 = document.createElement ('input');
	text11.id = "radiology"+varradsno1+"";
	text11.name = "radiology["+varradsno1+"]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varRadiology;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate8td"+varradsno1+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate8"+varradsno1+"";
	text8.name = "rate8["+varradsno1+"]";
	text8.type = "text";
	text8.size = "8";
	text8.value = varradRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	
	var td102 = document.createElement ('td');
	td102.id = "serialnumber"+varradsno1+"";
	//td1.align = "left";
	td102.valign = "top";
	td102.style.backgroundColor = "#FFFFFF";
	td102.style.border = "0px solid #001E6A";

	
	
	var text102 = document.createElement ('input');
	text102.id = "radlatertonow"+varradsno1+"";
	text102.name = "radlatertonow["+varradsno1+"]";
	text102.type = "checkbox";
	text102.align = "left";
	text102.size = "10";
	text102.value = varradsno1;
	text102.readOnly = "readonly";
	text102.style.backgroundColor = "#FFFFFF";
	text102.style.border = "0px solid #001E6A";
	text102.style.textAlign = "left";
	text102.onclick = function() { return selectcash('lab',varradsno1); }
	td102.appendChild (text102);
	tr.appendChild (td102);
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+varradsno1+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+varradsno1+"";
	text11.name = "btndelete5"+varradsno1+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { btnDeleteClick9(varradsno1,varradRate,"radcheck"+varradsno1+"");  }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber2").value = parseInt(varSerialNumber2) + 1;
	
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	totalamount2=totalamount2.replace(/[$,]+/g,"");
    
	totalamount2=parseInt(totalamount2) + parseInt(varradRate);
	
	document.getElementById("total2").value=totalamount2.toFixed(2);
	
	
	
	var varLab = document.getElementById("radiology").value = "";
	var varRate = document.getElementById("rate8").value = "";
	document.getElementById("radsno").value="";
	document.getElementById("radsno").value = varradsno1;
	
	document.getElementById("radiology").focus();
	//grandtotl(varradRate);
	window.scrollBy(0,5); 
	return true;

}