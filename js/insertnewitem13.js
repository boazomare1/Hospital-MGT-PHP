// JavaScript Document// JavaScript Document
function insertitem13()
{
	//alert('hi');
	
	if(document.form1.dis.value=="")
	{
		alert("Please enter disease name");
		document.form1.dis.focus();
		return false;
	}
	if(document.getElementById("code").value == "" || document.getElementById("code").value == "undefined")
	{
		alert("Select disease name from dropdown");
		document.form1.dis.focus();
		return false;
	}
	//alert('hi');
	var varSerialNumber24 = document.getElementById("serialnumberdisease").value;
	//alert(varSerialNumber21);
	var vardisease = document.getElementById("dis").value;
	//alert(vardisease);
	var varcode = document.getElementById("code").value;
	//alert(varcode);
	var varchapter = document.getElementById("chapter").value;
	//alert(varchapter);
	var varSerialNumber23=varSerialNumber24+69;
	//alert(varRate);
	var z = varSerialNumber23;
	//alert(z);
	
	var tr = document.createElement ('TR');
	//alert(tr);
	tr.id = "idTR"+z+"";
	//alert(tr.id);
	var td1 = document.createElement ('td');
	td1.id = "dis"+z+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumberdisease"+z+"";
	//alert(text1.id);
	text1.name = "serialnumberdisease"+z+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber23;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "dis"+z+"";
	text11.name = "dis[]"+z+"";
	//alert(text11.name);
	text11.type = "text";
	text11.align = "left";
	text11.size = "85";
	text11.value = vardisease;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var text111 = document.createElement ('input');
	text111.id = "code"+z+"";
	text111.name = "code[]"+z+"";
	text111.type = "text";
	text111.align = "left";
	text111.size = "25";
	text111.value = varcode;
	text111.readOnly = "readonly";
	text111.style.backgroundColor = "#FFFFFF";
	text111.style.border = "0px solid #001E6A";
	text111.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text111);
	tr.appendChild (td1);
	
	/*var text112 = document.createElement ('input');
	text112.id = "chapter"+z+"";
	text112.name = "chapter[]"+z+"";
	text112.type = "text";
	text112.align = "left";
	text112.size = "25";
	text112.value = varchapter;
	text112.readOnly = "readonly";
	text112.style.backgroundColor = "#FFFFFF";
	text112.style.border = "0px solid #001E6A";
	text112.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text112);
	tr.appendChild (td1);*/
	
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+z+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+z+"";
	text11.name = "btndelete5"+z+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick13(z); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow13').appendChild (tr);
	document.getElementById("serialnumberdisease").value = parseInt(z) + 1;
		
	var vardis1 = document.getElementById("dis").value = "";
	var varcode1 = document.getElementById("code").value = "";
	var varchapter1 = document.getElementById("chapter").value = "";
	document.getElementById("codevalue").value = "1";
	document.getElementById("dis").focus();
	document.getElementById("code").focus();
	document.getElementById("chapter").focus();
	
	window.scrollBy(0,5); 
	return true;

}// JavaScript Document