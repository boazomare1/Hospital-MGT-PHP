function insertitem10()
{

	if(document.form1.reference.value=="")
	{
		alert("Please enter Reference name");
		document.form1.reference.focus();
		return false;
	}
	
	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varsubheader = document.getElementById("subheader").value;
	var varreference = document.getElementById("reference").value;
	var varunits = document.getElementById("units").value;
	var varrangelow = document.getElementById("rangelow").value;
	var varrangehigh = document.getElementById("rangehigh").value;
	var vargender = document.getElementById("gender").value;
	var varagefrom = document.getElementById("agelimitfrom").value;
	var varageto = document.getElementById("agelimitto").value;
	var varrefrange_label = document.getElementById("refrange_label").value;
	var varreforder = document.getElementById("reforder").value;
	var varrefcode = document.getElementById("refcode").value;

	var genericsearch = document.getElementById("genericsearch").value;

	//var varrefcomments = document.getElementById("refcomments").value;
	//var varrefcomments = document.getElementById("editor1").value;
	var varrefcomments = '';
	/*var varrefcomments = CKEDITOR.instances.refcomments.getData();
	var varrefcomments = varrefcomments.replace('<p>','');   
	var varrefcomments = varrefcomments.replace('</p>',''); 
	var varrefcomments = varrefcomments.replace('&nbsp;','');  */
	//var varrefcomments = varrefcomments[0];
	//alert(varrefcomments);  
	
//alert(document.getElementById("rate").value);	
/*
	if (varSerialNumber == "")
	{
	var i = parseInt(1);	
	}
	else
	{
	 i = parseInt(varSerialNumber)+parseInt(1);
	}
	*/
	
	var i = varSerialNumber;
	
	//alert(i);
	//alert (varMedicineName);
	//alert (i);
	//var tr = document.createElement ('<TR id="idTR'+i+'"></TR>');
	var tr = document.createElement ('TR');
	tr.id = "idTR"+i+"";
	
	
	
	var td31 = document.createElement ('td');
	td31.id = "serialnumber3"+i+"";
	//td1.align = "left";
	td31.valign = "top";
	td31.style.backgroundColor = "#FFFFFF";
	td31.style.border = "0px solid #001E6A";
	
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text11 = document.createElement ('input');
	text11.id = "reference"+i+"";
	text11.name = "reference[]"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "20";
	text11.value = varreference;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	//td1.appendChild (text1);
	td31.appendChild (text11);
	tr.appendChild (td31);
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "units"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "units"+i+"";
	text2.name = "units[]"+i+"";
	text2.type = "text";
	text2.size = "8";
	text2.value = varunits;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);

//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "serialnumber"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
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
	var text71 = document.createElement ('input');
	text71.id = "subheader"+i+"";
	text71.name = "subheader[]"+i+"";
	text71.type = "text";
	text71.align = "left";
	text71.size = "20";
	text71.value = varsubheader;
	text71.readOnly = "readonly";
	text71.style.backgroundColor = "#FFFFFF";
	text71.style.border = "0px solid #001E6A";
	text71.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text71);
	tr.appendChild (td1);
	
	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "range"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "rangelow"+i+"";
	text3.name = "rangelow[]"+i+"";
	text3.type = "text";
	text3.size = "6";
	text3.value = varrangelow;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	
	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td32 = document.createElement ('td');
	td32.id = "range"+i+"";
	td32.align = "left";
	td32.valign = "top";
	td32.style.backgroundColor = "#FFFFFF";
	td32.style.border = "0px solid #001E6A";
	//var text32 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text32 = document.createElement ('input');
	text32.id = "rangehigh"+i+"";
	text32.name = "rangehigh[]"+i+"";
	text32.type = "text";
	text32.size = "6";
	text32.value = varrangehigh;
	text32.readOnly = "readonly";
	text32.style.backgroundColor = "#FFFFFF";
	text32.style.border = "0px solid #001E6A";
	text32.style.textAlign = "left";
	td32.appendChild (text32);
	tr.appendChild (td32);

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td4 = document.createElement ('td');
	td4.id = "gender"+i+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	//var text4 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text4 = document.createElement ('input');
	text4.id = "gender"+i+"";
	text4.name = "gender[]"+i+"";
	text4.type = "text";
	text4.size = "5";
	text4.value = vargender;
	text4.readOnly = "readonly";
	text4.style.backgroundColor = "#FFFFFF";
	text4.style.border = "0px solid #001E6A";
	text4.style.textAlign = "left";
	td4.appendChild (text4);
	tr.appendChild (td4);
	
	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "agelimitfrom"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text5 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text5 = document.createElement ('input');
	text5.id = "agelimitfrom"+i+"";
	text5.name = "agelimitfrom[]"+i+"";
	text5.type = "text";
	text5.size = "2";
	text5.value = varagefrom;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "left";
	
	//var text6 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="60" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text6 = document.createElement ('input');
	text6.id = "agelimitto"+i+"";
	text6.name = "agelimitto[]"+i+"";
	text6.type = "text";
	text6.size = "2";
	text6.value = varageto;
	text6.readOnly = "readonly";
	text6.style.backgroundColor = "#FFFFFF";
	text6.style.border = "0px solid #001E6A";
	text6.style.textAlign = "left";
	
	td5.appendChild (text5);
	td5.appendChild (text6);
	tr.appendChild (td5);

	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td99 = document.createElement ('td');
	td99.id = "refrange_label"+i+"";
	td99.align = "left";
	td99.valign = "top";
	td99.style.backgroundColor = "#FFFFFF";
	td99.style.border = "0px solid #001E6A";
	//var text32 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text99 = document.createElement ('input');
	text99.id = "refrange_label"+i+"";
	text99.name = "refrange_label[]"+i+"";
	text99.type = "text";
	text99.size = "10";
	text99.value = varrefrange_label;
	text99.readOnly = "readonly";
	text99.style.backgroundColor = "#FFFFFF";
	text99.style.border = "0px solid #001E6A";
	text99.style.textAlign = "left";
	td99.appendChild (text99);
	tr.appendChild (td99);
	
	var td67 = document.createElement ('td');
	td67.id = "reforder"+i+"";
	td67.align = "left";
	td67.valign = "top";
	td67.style.backgroundColor = "#FFFFFF";
	td67.style.border = "0px solid #001E6A";
	//var text61 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="610" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text67 = document.createElement ('textarea');
	text67.id = "refcomments"+i+"";
	text67.name = "refcomments[]"+i+"";
	//text67.type = "text";
	text67.rows = "2";
	text67.cols = "15";
	text67.value = varrefcomments;
	text67.readOnly = "readonly";
	text67.style.display = "none";
	text67.style.backgroundColor = "#FFFFFF";
	text67.style.border = "0px solid #001E6A";
	text67.style.textAlign = "left";
	td67.appendChild (text67);
	
	var text167 = document.createElement ('div');
	text167.id = "refdiv"+i+"";
	text167.name = "refdiv[]"+i+"";
	//text167.type = "text";
	//text167.rows = "2";
	//text167.cols = "15";
	text167.innerHTML = varrefcomments;
	//text167.readOnly = "readonly";
	text167.style.backgroundColor = "#FFFFFF";
	text167.style.border = "0px solid #001E6A";
	text167.style.textAlign = "left";
	
	td67.appendChild (text167);
	tr.appendChild (td67);
	
	var td61 = document.createElement ('td');
	td61.id = "reforder"+i+"";
	td61.align = "left";
	td61.valign = "top";
	td61.style.backgroundColor = "#FFFFFF";
	td61.style.border = "0px solid #001E6A";
	//var text61 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="610" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text61 = document.createElement ('input');
	text61.id = "reforder"+i+"";
	text61.name = "reforder[]"+i+"";
	text61.type = "text";
	text61.size = "2";
	text61.value = varreforder;
	text61.readOnly = "readonly";
	text61.style.backgroundColor = "#FFFFFF";
	text61.style.border = "0px solid #001E6A";
	text61.style.textAlign = "left";
	td61.appendChild (text61);
	tr.appendChild (td61);
	
	var td61 = document.createElement ('td');
	td61.id = "refcode"+i+"";
	td61.align = "left";
	td61.valign = "top";
	td61.style.backgroundColor = "#FFFFFF";
	td61.style.border = "0px solid #001E6A";
	//var text61 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="610" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text61 = document.createElement ('input');
	text61.id = "refcode"+i+"";
	text61.name = "refcode[]"+i+"";
	text61.type = "text";
	text61.size = "2";
	text61.value = varrefcode;
	text61.readOnly = "readonly";
	text61.style.backgroundColor = "#FFFFFF";
	text61.style.border = "0px solid #001E6A";
	text61.style.textAlign = "left";
	td61.appendChild (text61);
	tr.appendChild (td61);

	var td4 = document.createElement ('td');
	td4.id = "genericsearch"+i+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	//var text4 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text4 = document.createElement ('input');
	text4.id = "genericsearch"+i+"";
	text4.name = "genericsearch[]"+i+"";
	text4.type = "text";
	text4.size = "5";
	text4.value = genericsearch;
	text4.readOnly = "readonly";
	text4.style.backgroundColor = "#FFFFFF";
	text4.style.border = "0px solid #001E6A";
	text4.style.textAlign = "left";
	td4.appendChild (text4);
	tr.appendChild (td4);

	var td10 = document.createElement ('td');
	td10.id = "btndelete"+i+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete"+i+"";
	text11.name = "btndelete"+i+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick10(i); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("serialnumber").value = parseInt(i) + 1;
	
	//CKEDITOR.instances.refcomments.setData('');
	
	var varreference = document.getElementById("subheader").value = "";
	var varreference = document.getElementById("reference").value = "";
	var varunits = document.getElementById("units").value = "";
	var varrange = document.getElementById("rangelow").value = "";
	var varrange = document.getElementById("rangehigh").value = "";
	var vargender = document.getElementById("gender").value = "";
	var varagefrom = document.getElementById("agelimitfrom").value = "";
	var varageto = document.getElementById("agelimitto").value = "";
	var varrefrange_label = document.getElementById("refrange_label").value = "";
	var varageto = document.getElementById("reforder").value = "";
	document.getElementById("refcode").value = "";
	//var varrefcomments = document.getElementById("refcomments").value = "";
		
	window.scrollBy(0,5); 
	return true;
	
	

}
