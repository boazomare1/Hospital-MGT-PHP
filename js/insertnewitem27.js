function insertitem27()
{

	
	var preventserialnumber6 = document.getElementById("preventserialnumber6").value;
	var preventservice = document.getElementById("preventservice").value;
	var preventdate = document.getElementById("preventdate").value;
	var preventvisit = document.getElementById("preventvisit").value;
	
	

	
	var i = preventserialnumber6;
	
	
	var tr = document.createElement ('TR');
	tr.id = "idTRa"+i+"";
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "preventserialnumber6"+i+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "preventserialnumber6"+i+"";
	text1.name = "preventserialnumber6"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = preventserialnumber6;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text11 = document.createElement ('input');
	text11.id = "preventservice"+i+"";
	text11.name = "preventservice"+i+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "20";
	text11.value = preventservice;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "preventdate"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text2 = document.createElement ('<input name="itemcode'+i+'" value="'+varItemCode+'" id="itemcode'+i+'" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />');
	var text2 = document.createElement ('input');
	text2.id = "preventdate"+i+"";
	text2.name = "preventdate"+i+"";
	text2.type = "text";
	text2.size = "8";
	text2.value = preventdate;
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "left";
	td2.appendChild (text2);
	tr.appendChild (td2);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "preventvisit"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<input name="itemname'+i+'" value="'+varItemName+'" size="50" id="itemname'+i+'" style="border: 0px solid #001E6A; text-align:left" readonly="readonly" />');
	var text3 = document.createElement ('input');
	text3.id = "preventvisit"+i+"";
	text3.name = "preventvisit"+i+"";
	text3.type = "text";
	text3.size = "8";
	text3.value = preventvisit;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);


	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');

	
	
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
	text11.onclick = function() { return btnDeleteClick27(i); }
	//td10.appendChild (text10);
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('preventinsertrow').appendChild (tr);
//alert("hio");	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	//document.getElementById("serialnumber").value = i + 1;
	//var varItemSerialNumberInsert = parseInt(varItemSerialNumberInsert);
	
	//alert (varItemSerialNumberInsert);
	document.getElementById("preventserialnumber6").value = parseInt(i) + 1;
	
	/*if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	totalamount=document.getElementById('total').value;
	}
	
	
	totalamount=parseFloat(totalamount) + parseFloat(varpharmAmount);
	
	document.getElementById("total").value=totalamount.toFixed(2);
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	totalamount4=document.getElementById('total5').value;
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalamountr=document.getElementById('totalr').value;
	}
	
	
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	*/
	//alert("hi");
	//i++;
    //alert(i);
   
	// if additional text this tr will be inserted.
	/*if (lab != "")
	{
	//alert (varItemDescription);

	//var trAddDescription = document.createElement ('<TR id="idTRaddtxt'+i+'"></TR>');
	var trlab = document.createElement ('TR');
	trlab.id = "idTRaddtxt"+i+"";
		
*/
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	/*var td1 = document.createElement ('td');
	td1.id = "idTD2"+i+"";
	td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	trlab.appendChild (td1);

	//var td2 = document.createElement ('<td id="idTD2'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td2 = document.createElement ('td');
	td2.id = "idTD2"+i+"";
	td2.align = "left";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	trlab.appendChild (td2);


	//var td3 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+i+"";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text3 = document.createElement ('<textarea name="itemdescription'+i+'" cols="40" rows="2" id="itemdescription'+i+'" style="border: 0px solid #001E6A;"></textarea>');
	var text3 = document.createElement ('input');
	text3.id = "lab"+i+"";
	text3.name = "lab"+i+"";
	text3.cols = "40";
	text3.rows = "2";
	text3.value = varLab;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	trlab.appendChild (td3);

	
	//var td4 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td4 = document.createElement ('td');
	td4.id = "idTD3"+i+"";
	td4.align = "left";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	trlab.appendChild (td4);

	
	//var td5 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD3"+i+"";
	td5.align = "left";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	trlab.appendChild (td5);

	
	//var td6 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td6 = document.createElement ('td');
	td6.id = "idTD3"+i+"";
	td6.align = "left";
	td6.valign = "top";
	td6.style.backgroundColor = "#FFFFFF";
	td6.style.border = "0px solid #001E6A";
	trlab.appendChild (td6);

	
	//var td7 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td7 = document.createElement ('td');
	td7.id = "idTD3"+i+"";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	trlab.appendChild (td7);

	
	//var td8 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td8 = document.createElement ('td');
	td8.id = "idTD3"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	trlab.appendChild (td8);

	
	//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td81 = document.createElement ('td');
	td81.id = "idTD3"+i+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	trlab.appendChild (td81);

	
	//var td9 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	var td9 = document.createElement ('td');
	td9.id = "idTD3"+i+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	trlab.appendChild (td9);*/

	
	//var td10 = document.createElement ('<td id="idTD3'+i+'" align="right" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>');
	/*var td10 = document.createElement ('td');
	td10.id = "idTD3"+i+"";
	td10.align = "left";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	trlab.appendChild (td10);
*/
	//document.getElementById ('insertrow').appendChild (tr);

	//}
	
	
	
	var preventservice = document.getElementById("preventservice").value='';
	var preventdate = document.getElementById("preventdate").value='';
	var preventvisit = document.getElementById("preventvisit").value='';
	

	
	document.getElementById("preventservice").focus();
	
	window.scrollBy(0,5); 
	return true;

}


