// JavaScript Document// JavaScript Document
function insertitem7()
{
	
	if(document.form1.charge.value=="")
	{
		alert("Please enter charge name");
		document.form1.charge.focus();
		return false;
	}
	if(document.form1.rate8.value=="")
	{
		alert("Please enter rate");
		document.form1.rate8.focus();
		return false;
	}
	var varSerialNumber2 = document.getElementById("serialnumber").value;
	var varcharge = document.getElementById("charge").value;
	var varradRate = document.getElementById("rate8").value;
	
	//alert('h');
	//alert(varRate);
	var k = varSerialNumber2;
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";
	
	var td1 = document.createElement ('td');
	td1.id = "charge"+k+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+k+"";
	text1.name = "serialnumber"+k+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "charge"+k+"";
	text11.name = "charge[]"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "20";
	text11.value = varcharge;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate8"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate8"+k+"";
	text8.name = "rate8[]"+k+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varradRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+k+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+k+"";
	text11.name = "btndelete5"+k+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick9(k); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber").value = parseInt(varSerialNumber2) + 1;
	
		
		
	var varLab = document.getElementById("charge").value = "";
	var varRate = document.getElementById("rate8").value = "";
	
	document.getElementById("charge").focus();
	
	window.scrollBy(0,5); 
	return true;

}