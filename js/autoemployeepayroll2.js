// JavaScript Document
//function to call ajax process
function EmployeePayrollmonthwise()
{
	//alert("Meow...");
	
	for(var j = document.getElementById("tblrowinsert1").rows.length; j > 0;j--)
	{
		document.getElementById("tblrowinsert1").deleteRow(j -1);
	}
	
	var Empcode;
	var Empcode = document.getElementById("searchemployeecode").value;
	//alert(Empcode);
	if(Empcode!="")
	{
		
		var varEmployeesearchLen = Empcode.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
		{
			ajaxprocessACCS21(Empcode);		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS21(Empcode)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmpcode = Empcode;
	var Assignmonth = document.getElementById("assignmonth").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeepayroll2.php?RandomKey="+Math.random()+"&&employeesearch="+varEmpcode+"&&assignmonth="+Assignmonth+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS21 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS21() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
	
		//EmployeeLoanmonthwise();
		
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	if(t!='')
	{
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||^||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	if (varNewLineLength == 0)
	{
		//return false;
	}
	
	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		var varAnum = varNewRecordValue[0];
		
		var varEmployeecode = varNewRecordValue[1];
		//alert (varCustomerName1);
		var varEmployeeName = varNewRecordValue[2];
		//alert (varCustomerName1);
		var varComponentname = varNewRecordValue[3];
		
		var varComponentAmount = varNewRecordValue[4];
		
		var varAmounttype = varNewRecordValue[5];
		
		var varTypeColor = varNewRecordValue[6];
		
		var varType = varNewRecordValue[7];
		
		var varUnit = varNewRecordValue[8];
		//alert(varUnit);
		var varAmount = varNewRecordValue[9];
		//alert(varAmount);
		var m = parseInt(m);
		var k = m + 1;
		var k = parseInt(k);
		//alert (k);
		//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
		var tr = document.createElement ('TR');
		tr.id = "idTR"+k+"";
		tr.value = k;
		//tr.onclick = function() { TrSelect(this.value); }
		//tr.onmouseover = function() { TrBgcolor(this.value); }
		//tr.onmouseout = function() { TRremovecolor(this.value); }
		//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td1 = document.createElement ('td');
		td1.id = "idTD1"+k+"";
		td1.align = "left";
		td1.valign = "top";
		td1.style.backgroundColor = "#FFFFFF";
		td1.style.border = "0px solid #F3F3F3";
		//var text1 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text1 = document.createElement ('input');
		text1.id = "serialnumbermonth"+k+"";
		text1.name = "serialnumbermonth"+k+"";
		text1.type = "hidden";
		text1.size = "1";
		text1.value = k;
		text1.readOnly = "readonly";
		text1.style.backgroundColor = "#FFFFFF";
		text1.style.border = "0px solid #001E6A";
		text1.style.textAlign = "center";
		text1.style.fontSize = "12";
		//text1.onclick = function() { return TrSelect(this.value); }
		var text7 = document.createElement ('input');
		text7.id = "type"+k+"";
		text7.name = "type"+k+"";
		text7.type = "text";
		text7.size = "1";
		text7.value = varType;
		text7.readOnly = "readonly";
		text7.style.backgroundColor = "#FFFFFF";
		text7.style.color = varTypeColor;
		text7.style.border = "0px solid #001E6A";
		text7.style.textAlign = "center";
		text7.style.fontSize = "12";
		
		td1.appendChild (text7);
		td1.appendChild (text1);
		tr.appendChild (td1);
		
		var td5 = document.createElement ('td');
		td5.id = "idTD5"+k+"";
		td5.align = "left";
		td5.valign = "top";
		td5.style.backgroundColor = "#FFFFFF";
		td5.style.border = "0px solid #F3F3F3";
		//var text5 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text5 = document.createElement ('input');
		text5.id = "componentanum"+k+"";
		text5.name = "componentanum"+k+"";
		text5.type = "hidden";
		text5.size = "1";
		text5.value = varAnum;
		text5.readOnly = "readonly";
		text5.style.backgroundColor = "#FFFFFF";
		text5.style.border = "0px solid #001E6A";
		text5.style.textAlign = "center";
		text5.style.fontSize = "12";
		//text5.onclick = function() { return TrSelect(this.value); }
		td5.appendChild (text5);
		tr.appendChild (td5);

		//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td2 = document.createElement ('td');
		td2.id = "idTD2"+k+"";
		td2.align = "left";
		td2.valign = "top";
		td2.style.backgroundColor = "#FFFFFF";
		td2.style.border = "0px solid #F3F3F3";
		//var text2 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="12">');
		var text2 = document.createElement ('input');
		text2.id = "componentname"+k+"";
		text2.name = "componentname"+k+"";
		text2.type = "text";
		text2.size = "15";
		text2.value = varComponentname;
		text2.readOnly = "readonly";
		text2.style.backgroundColor = "#FFFFFF";
		text2.style.border = "0px solid #001E6A";
		text2.style.textAlign = "left";
		text2.style.fontSize = "12";
		td2.appendChild (text2);
		tr.appendChild (td2);
		
		//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td4 = document.createElement ('td');
		td4.id = "idTD4"+k+"";
		td4.align = "left";
		td4.valign = "top";
		td4.style.backgroundColor = "#FFFFFF";
		td4.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
		var text4 = document.createElement ('input');
		text4.id = "rate"+k+"";
		text4.name = "rate"+k+"";
		text4.type = "text";
		text4.size = "5";
		text4.value = varComponentAmount;
		text4.readOnly = "readonly";
		text4.style.backgroundColor = "#FFFFFF";
		text4.style.border = "1px solid #001E6A";
		text4.style.textAlign = "right";
		text4.style.fontSize = "12";
		td4.appendChild (text4);
		tr.appendChild (td4);
		
		//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td6 = document.createElement ('td');
		td6.id = "idTD6"+k+"";
		td6.align = "left";
		td6.valign = "top";
		td6.style.backgroundColor = "#FFFFFF";
		td6.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
		var text6 = document.createElement ('input');
		text6.id = "unit"+k+"";
		text6.name = "unit"+k+"";
		text6.type = "text";
		text6.size = "5";
		text6.value = varUnit;
		//text6.readOnly = "readonly";
		text6.style.backgroundColor = "#FFFFFF";
		text6.style.border = "1px solid #001E6A";
		text6.style.textAlign = "right";
		text6.style.fontSize = "12";
		text6.onkeyup = function() { monthwiseCalc(this.id); }
		td6.appendChild (text6);
		tr.appendChild (td6);


		//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td3 = document.createElement ('td');
		td3.id = "idTD3"+k+"";
		td3.align = "left";
		td3.valign = "top";
		td3.style.backgroundColor = "#FFFFFF";
		td3.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
		var text3 = document.createElement ('input');
		text3.id = "amount"+k+"";
		text3.name = "amount"+k+"";
		text3.type = "text";
		text3.size = "6";
		text3.value = varAmount;
		text3.readOnly = "readonly";
		text3.style.backgroundColor = "#FFFFFF";
		text3.style.border = "1px solid #001E6A";
		text3.style.textAlign = "right";
		text3.style.fontSize = "12";
		td3.appendChild (text3);
		tr.appendChild (td3);

		document.getElementById ('tblrowinsert1').appendChild (tr);
	
					
	}
	
	}
	
	EmployeeLoanmonthwise();
	
	//alert (k);
	} 
	
	
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

function monthwiseCalc(id)
{
	var id = id;
	var k = id.substr(4,10);
	//alert(k);
	if(document.getElementById("unit"+k).value != "")
	{
		if(!isNaN(document.getElementById("unit"+k).value))
		{
			var Rate = document.getElementById("rate"+k).value;
			var Unit = document.getElementById("unit"+k).value;
			var Amount = parseFloat(Rate) * parseFloat(Unit);
			document.getElementById("amount"+k).value = Amount.toFixed(2);
		}
		else
		{
			alert("Please Enter Numbers");	
			document.getElementById("unit"+k).value = "";
			document.getElementById("amount"+k).value = "0.00";
			return false;			
		}
	}
	else
	{
		document.getElementById("amount"+k).value = "0.00";
	}
}