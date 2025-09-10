// JavaScript Document// JavaScript Document
function insertitem14()
{
	//alert('hi');
	
	if(document.form1.dis1.value=="")
	{
		alert("Please enter disease name");
		document.form1.dis1.focus();
		return false;
	}
	if(document.getElementById("code1").value == "" || document.getElementById("code1").value == "undefined")
	{
		alert("Select disease name from dropdown");
		document.form1.dis1.focus();
		return false;
	}
	//alert('hi');
	var varSerialNumber25 = document.getElementById("serialnumberdisease1").value;
	//alert(varSerialNumber21);
	var vardisease1 = document.getElementById("dis1").value;
	//alert(vardisease);
	var varcode1 = document.getElementById("code1").value;
	//alert(varcode);
	var varchapter1 = document.getElementById("chapter1").value;
	//alert(varchapter);
	var varSerialNumber24=varSerialNumber25+99;
	//alert(varRate);
	var q = varSerialNumber25;
	//alert(z);
	
	var tr = document.createElement ('TR');
	//alert(tr);
	tr.id = "idTR"+q+"";
	//alert(tr.id);
	var td1 = document.createElement ('td');
	td1.id = "dis1"+q+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumberdisease1"+q+"";
	//alert(text1.id);
	text1.name = "serialnumberdisease1"+q+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber25;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "dis1"+q+"";
	text11.name = "dis1[]"+q+"";
	//alert(text11.name);
	text11.type = "text";
	text11.align = "left";
	text11.size = "85";
	text11.value = vardisease1;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var text115 = document.createElement ('input');
	text115.id = "code1"+q+"";
	text115.name = "code1[]"+q+"";
	text115.type = "text";
	text115.align = "left";
	text115.size = "25";
	text115.value = varcode1;
	text115.readOnly = "readonly";
	text115.style.backgroundColor = "#FFFFFF";
	text115.style.border = "0px solid #001E6A";
	text115.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text115);
	tr.appendChild (td1);
	
	/*var text116 = document.createElement ('input');
	text116.id = "chapter1"+q+"";
	text116.name = "chapter1[]"+q+"";
	text116.type = "text";
	text116.align = "left";
	text116.size = "25";
	text116.value = varchapter1;
	text116.readOnly = "readonly";
	text116.style.backgroundColor = "#FFFFFF";
	text116.style.border = "0px solid #001E6A";
	text116.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text116);
	tr.appendChild (td1);*/
	
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+q+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+q+"";
	text11.name = "btndelete5"+q+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick14(q); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow14').appendChild (tr);
	document.getElementById("serialnumberdisease1").value = parseInt(q) + 1;
		
	var vardis1 = document.getElementById("dis1").value = "";
	var varcode1 = document.getElementById("code1").value = "";
	var varchapter1 = document.getElementById("chapter1").value = "";
	
	document.getElementById("dis1").focus();
	document.getElementById("code1").focus();
	document.getElementById("chapter1").focus();
	
	window.scrollBy(0,5); 
	return true;

}// JavaScript Document