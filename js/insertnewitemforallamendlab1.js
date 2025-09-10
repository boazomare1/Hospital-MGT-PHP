// JavaScript Document
function insertitem6()
{//alert(sno);
	
	if(document.form1.lab.value=="")
	{
		alert("Please enter laboratory name");
		document.form1.lab.focus();
		return false;
	}
		if(document.form1.rate5.value=="")
	{
		alert("Please enter rate");
		document.form1.rate5.focus();
		return false;
	}

	var varSerialNumber1 = document.getElementById("serialnumber1").value;
	var varLab = document.getElementById("lab").value;
	var varlabRate = document.getElementById("rate5").value;
	//alert(varlabRate);
	var varlabsno = document.getElementById("labsno").value;
	//alert(varlabsno);
	if(varlabsno=='')
	{
	varlabsno=0;	
	}
	var a=1;
	//alert(a);
	var varlabsno1=parseInt(varlabsno)+parseInt(a);
	//alert(varlabsno1);
	
	//alert(varlabsno1);
	var j = varSerialNumber1;
	
	/*if(sno >0 && sno<2)
	{
		var ano = parseInt(sno)+1;
	}
	 var ano;*/
	
	
	var tr = document.createElement ('TR');
	tr.id = "labidTR"+varlabsno1+"";
	tr.size = "40";
	
	var td1 = document.createElement ('td');
	td1.id = "lab"+varlabsno1+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber1"+varlabsno1+"";
	text1.name = "serialnumber1"+varlabsno1+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber1;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var td101 = document.createElement ('td');
	td101.id = "serialnumber"+varlabsno1+"";
	//td1.align = "left";
	td101.valign = "top";
	td101.style.backgroundColor = "#FFFFFF";
	td101.style.border = "0px solid #001E6A";

	
	
	var text10 = document.createElement ('input');
	text10.id = "labcheck"+varlabsno1+"";
	text10.name = "labcheck["+varlabsno1+"]";
	text10.type = "checkbox";
	text10.align = "left";
	text10.size = "10";
	text10.value = varlabsno1;
	text10.readOnly = "readonly";
	text10.style.backgroundColor = "#FFFFFF";
	text10.style.border = "0px solid #001E6A";
	text10.style.textAlign = "left";

	text10.onclick = function() {  selectselect('lab',varlabsno1),approvalfunction("labcheck"+varlabsno1+"",varlabRate); }
	//
	

	//td1.appendChild (text1);
	td101.appendChild (text10);
	tr.appendChild (td101);

	var text101 = document.createElement ('input');
	text101.id = "labanum"+varlabsno1+"";
	text101.name = "labanum["+varlabsno1+"]";
	text101.type = "hidden";
	text101.align = "left";
	text101.size = "10";
	text101.value = varlabsno1;
	text101.readOnly = "readonly";
	text101.style.backgroundColor = "#FFFFFF";
	text101.style.border = "0px solid #001E6A";
	text101.style.textAlign = "left";
	text101.onclick = function() { return selectselect('lab',varlabsno1); }

	//td1.appendChild (text1);
	td101.appendChild (text101);
	tr.appendChild (td101);
	
	var text11 = document.createElement ('input');
	text11.id = "lab"+varlabsno1+"";
	text11.name = "lab["+varlabsno1+"]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "50";
	text11.value = varLab;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate5td"+varlabsno1+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate5"+varlabsno1+"";
	text8.name = "rate5["+varlabsno1+"]";
	text8.type = "text";
	text8.size = "8";
	text8.value = varlabRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	
	var td102 = document.createElement ('td');
	td102.id = "serialnumber"+varlabsno1+"";
	//td1.align = "left";
	td102.valign = "top";
	td102.style.backgroundColor = "#FFFFFF";
	td102.style.border = "0px solid #001E6A";

	
	
	var text102 = document.createElement ('input');
	text102.id = "lablatertonow"+varlabsno1+"";
	text102.name = "lablatertonow["+varlabsno1+"]";
	text102.type = "checkbox";
	text102.align = "left";
	text102.size = "10";
	text102.value = varlabsno1;
	text102.readOnly = "readonly";
	text102.style.backgroundColor = "#FFFFFF";
	text102.style.border = "0px solid #001E6A";
	text102.style.textAlign = "left";
	text102.onclick = function() { return selectcash('lab',varlabsno1); }
	td102.appendChild (text102);
	tr.appendChild (td102);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete1"+varlabsno1+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete1"+varlabsno1+"";
	text11.name = "btndelete1"+varlabsno1+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick6(varlabsno1,varlabRate, "labcheck"+varlabsno1+""); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow1').appendChild (tr);
	
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber1").value = parseInt(varSerialNumber1) + 1;
	
		if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	totalamount1=totalamount1.replace(/[$,]+/g,"");
	//var ano = parseInt(ano) +1;
	//alert(ano);
	
	totalamount1=parseInt(totalamount1) + parseInt(varlabRate);
	document.getElementById("total1").value=totalamount1.toFixed(2);
	
	
	
	var varLab = document.getElementById("lab").value = "";
	var varRate = document.getElementById("rate5").value = "";
	document.getElementById("labsno").value="";
	 document.getElementById("labsno").value = varlabsno1;
	
	
	document.getElementById("lab").focus();
	//grandtotl(varlabRate);
	window.scrollBy(0,5); 
	return true;
	
	

}