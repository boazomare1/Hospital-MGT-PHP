function insertitem34()
{
	
	if(document.form1.categorylab.value=="")
	{
		alert("Please enter lab category name");
		document.form1.categorylab.focus();
		return false;
	}
	
	if(document.form1.categoryrate5.value=="")
	{
		alert("Please enter category rate");
		document.form1.categoryrate5.focus();
		return false;
	}
	var varSerialNumber13 = document.getElementById("serialnumber8").value;
	var varcategoryLab = document.getElementById("categorylab").value;
	var varcategorylabRate = document.getElementById("categoryrate5").value;
	//alert(varlabRate);
	var varSerialNumber33=varSerialNumber13;
	var q = varSerialNumber33;
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+q+"";
	tr.size = "40";
	
	var td1 = document.createElement ('td');
	td1.id = "categorylab"+q+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber8"+q+"";
	text1.name = "serialnumber8"+q+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber33;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "categorylab"+q+"";
	text11.name = "categorylab[]"+q+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "50";
	text11.value = varcategoryLab;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "categoryrate5"+q+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "categoryrate5"+q+"";
	text8.name = "categoryrate5[]"+q+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varcategorylabRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete33"+q+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete33"+q+"";
	text11.name = "btndelete33"+q+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick33(q,varcategorylabRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow33').appendChild (tr);
	
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber8").value = parseInt(varSerialNumber33) + 1;
	
		if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	
	
	totalamount1=parseInt(totalamount1) + parseInt(varcategorylabRate);
	
	document.getElementById("total1").value=totalamount1.toFixed(2);
	var varcategoryLab = document.getElementById("categorylab").value = "";
	var varcategoryRate = document.getElementById("categoryrate5").value = "";
	
	
	
	document.getElementById("categorylab").focus();
	
	window.scrollBy(0,5); 
	return true;

}