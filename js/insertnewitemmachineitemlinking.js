function insertitem10()
{
	
	if(document.getElementById("lab").value=="")
	{
		alert("Please Enter Lab Name");
		document.getElementById('lab').focus();
		return false;
	}
	if(document.getElementById("analyserlabname").value=="")
	{
		alert("Please Enter Analyserlab Name");
		document.getElementById('analyserlabname').focus();
		return false;
	}
	if(document.getElementById("analyserlabcode").value=="")
	{
		alert("Please Enter Analyserlab Code");
		document.getElementById('analyserlabcode').focus();
		return false;
	}
		
	var varSerialNumber = document.getElementById("serialnumber").value;
	var lab = document.getElementById("lab").value;
	var labcode = document.getElementById("labcode").value;
	var alabname = document.getElementById("analyserlabname").value;
	var alabcode = document.getElementById("analyserlabcode").value;
	alabcode = alabcode.toUpperCase();
	var i = varSerialNumber;
	

	var tr = document.createElement('TR');
	tr.id = "idTR"+i+"";
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement('td');
	td1.id = "serialnumber"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement('input');
	text1.id = "serialnumber"+i+"";
	text1.name = "serialnumber"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var td2 = document.createElement ('td');
	td2.id = "lab"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	
	var text11 = document.createElement('input');
	text11.id = "lab"+i+"";
	text11.name = "lab"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "35";
	text11.value = lab;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	td2.appendChild (text11);
	tr.appendChild (td2);
	
	var td3 = document.createElement ('td');
	td3.id = "labcode"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	
	var text12 = document.createElement('input');
	text12.id = "labcode"+i+"";
	text12.name = "labcode"+i+"";
	text12.type = "hidden";
	text12.align = "left";
	text12.size = "45";
	text12.value = labcode;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td3.appendChild (text12);
	
	var text121 = document.createElement('input');
	text121.id = "analyserlabname"+i+"";
	text121.name = "analyserlabname"+i+"";
	text121.type = "text";
	text121.align = "left";
	text121.size = "35";
	text121.value = alabname;
	text121.readOnly = "readonly";
	text121.style.backgroundColor = "#FFFFFF";
	text121.style.border = "0px solid #001E6A";
	text121.style.textAlign = "left";
	td3.appendChild (text121);
	tr.appendChild (td3);
	
	
	var td101 = document.createElement ('td');
	td101.id = "btndelete"+i+"";
	td101.align = "right";
	td101.valign = "top";
	td101.style.backgroundColor = "#FFFFFF";
	td101.style.border = "0px solid #001E6A";
	var text122 = document.createElement('input');
	text122.id = "analyserlabcode"+i+"";
	text122.name = "analyserlabcode"+i+"";
	text122.type = "text";
	text122.align = "left";
	text122.size = "15";
	text122.value = alabcode;
	text122.readOnly = "readonly";
	text122.style.backgroundColor = "#FFFFFF";
	text122.style.border = "0px solid #001E6A";
	text122.style.textAlign = "left";
	td101.appendChild (text122);
	tr.appendChild (td101);
	
	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td10 = document.createElement ('td');
	td10.id = "btndelete"+i+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text111 = document.createElement ('input');
	text111.id = "btndelete"+i+"";
	text111.name = "btndelete"+i+"";
	text111.type = "button";
	text111.value = "Del";
	text111.style.border = "1px solid #001E6A";
	text111.onclick = function() { return btnDeleteClick10(i); }
	//td10.appendChild (text10);
	td10.appendChild (text111);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);
	
	
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	
	
	
	var lab = document.getElementById("lab").value = "";
	var labcode = document.getElementById("labcode").value = "";
	var alabname = document.getElementById("analyserlabname").value = "";
	var alabcode = document.getElementById("analyserlabcode").value = "";
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;

}
