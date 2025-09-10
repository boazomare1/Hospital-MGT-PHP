// JavaScript Document// JavaScript Document
function insertitem3()
{
	if(document.getElementById("radname").value=="")
	{
		alert("Please enter radiology name");
		document.getElementById("radname").focus();
		return false;
	}
	if(document.getElementById("radrate").value=="")
	{
		alert("Please enter rate");
		document.getElementById("radrate").focus();
		return false;
	}
	var varSerialNumber21 = document.getElementById("serialnumberr").value;
	//alert(varSerialNumber21);
	var varRadiology = document.getElementById("radname").value;
	var varradRate = document.getElementById("radrate").value;
	//var varradinstuct = document.getElementById("radinstuct").value;
	var varradcode = document.getElementById("radcode").value;
	var varSerialNumber2=varSerialNumber21;
	
	var k = varSerialNumber2;
	//alert(k);
	
	var tr = document.createElement ('TR');
	tr.id = "idradTR"+k+"";
	
	var td1 = document.createElement ('td');
	td1.id = "tdradname"+k+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumberr"+k+"";
	text1.name = "serialnumberr"+k+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "radcode"+k+"";
	text11.name = "radcode"+k+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varradcode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	td1.appendChild (text11);
	
	
	var text11 = document.createElement ('input');
	text11.id = "radname"+k+"";
	text11.name = "radname"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "45";
	text11.value = varRadiology;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	//td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);



	/*var td8 = document.createElement ('td');
	td8.id = "radinstuct"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	
	var text8 = document.createElement ('input');
	text8.id = "radinstuct"+k+"";
	text8.name = "radinstuct"+k+"";
	text8.type = "text";
	text8.size = "25";
	text8.value = varradinstuct;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "center";
	td8.appendChild (text8);
	tr.appendChild (td8);*/
	
	
	var td8 = document.createElement ('td');
	td8.id = "tdradrate"+k+"";
	td8.className = "radcalrate";
	td8.align = "right";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "radrate"+k+"";
	text8.name = "radrate"+k+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varradRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "right";
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
	text11.onclick = function() { return btnDeleteClick13(k,''); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow3').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumberr").value = parseInt(k) + 1;
	

	
	
	
	var varLab = document.getElementById("radname").value = "";
	var varRate = document.getElementById("radrate").value = "";
	//var varRate = document.getElementById("radinstuct").value = "";
	document.getElementById("searchrad1hiddentextbox").value = "";
	document.getElementById("searchradnum1").value = "";
	var varradcode = document.getElementById("radcode").value = "";

	var classname = 'radcalrate';
	var id = 'ri_items_subtotal';
    calculate_items_total(classname,id);
	document.getElementById("radname").focus();
	
	window.scrollBy(0,5); 
	return true;

}