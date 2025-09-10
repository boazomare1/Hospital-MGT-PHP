// JavaScript Document
//function to call ajax process
function employeesearch6()
{
	//alert("Meow...");
	//to get number of rows in the table before deleting.
	//for(var j = document.getElementById("tblrowinsert").rows.length; j > 0;j--)
	//{
		//document.getElementById("tblrowinsert").deleteRow(j -1);
	//}
	
	for(var s = document.getElementById("tblrowinsert1").rows.length; s > 0;s--)
	{
		document.getElementById("tblrowinsert1").deleteRow(s -1);
	}
	
	//if(document.getElementById("employeesearch").value!="")
	//{
		var varEmployeesearch = document.getElementById("searchsuppliername").value;
		//alert (varCustomerSearch);
		var varEmployeesearch = varEmployeesearch.toUpperCase();
		document.getElementById("searchsuppliername").value = varEmployeesearch;
		
		var varEmployeesearchLen = varEmployeesearch.length;
		//alert (varCustomerSearchLen);
		//if (varEmployeesearchLen > 0)
		//{
			ajaxprocessACCS2();		
		//}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	//}
	
	//ajaxprocessACCS2();	
}

var xmlHttp

function ajaxprocessACCS2()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmployeesearch = document.getElementById("searchsuppliername").value;
	var Assignmonth = document.getElementById("assignmonth").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeecodesearchpro.php?RandomKey="+Math.random()+"&&employeesearch="+varEmployeesearch+"&&assignmonth="+Assignmonth;
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS2 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS2() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	if(t!= '')
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
		var varEmployeecode = varNewRecordValue[0];
		//alert (varCustomerName1);
		var varEmployeeName = varNewRecordValue[1];
		//alert (varCustomerName1);
		var varWorkdays = varNewRecordValue[2];
		//alert (varCustomerName1);
		
			var m = parseInt(m);
			var k = m + 1;
			var k = parseInt(k);
			//alert (k);
			//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
			var tr = document.createElement ('TR');
			tr.id = "idTR"+k+"";
			tr.value = k+'||'+varEmployeecode;
			tr.onclick = function() { TrSelect(this.value); }
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
			text1.id = "empserialnumber"+k+"";
			text1.name = "empserialnumber"+k+"";
			text1.type = "checkbox";
			text1.checked = "checked";
			text1.size = "1";
			text1.value = k+'||'+varEmployeecode;
			text1.readOnly = "readonly";
			text1.style.backgroundColor = "#FFFFFF";
			text1.style.border = "0px solid #001E6A";
			text1.style.textAlign = "center";
			text1.style.fontSize = "12";
			text1.onclick = function() { return TrSelect(this.value); }
			td1.appendChild (text1);
			tr.appendChild (td1);


			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td2 = document.createElement ('td');
			td2.id = "idTD2"+k+"";
			td2.align = "left";
			td2.valign = "top";
			td2.style.backgroundColor = "#FFFFFF";
			td2.style.border = "0px solid #F3F3F3";
			//var text2 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="12">');
			var text2 = document.createElement ('input');
			text2.id = "employeecode"+k+"";
			text2.name = "employeecode"+k+"";
			text2.type = "text";
			text2.size = "12";
			text2.value = varEmployeecode;
			text2.readOnly = "readonly";
			text2.style.backgroundColor = "#FFFFFF";
			text2.style.border = "0px solid #001E6A";
			text2.style.textAlign = "left";
			text2.style.fontSize = "12";
			td2.appendChild (text2);
			tr.appendChild (td2);

			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td3 = document.createElement ('td');
			td3.id = "idTD3"+k+"";
			td3.align = "left";
			td3.valign = "top";
			td3.style.backgroundColor = "#FFFFFF";
			td3.style.border = "0px solid #F3F3F3";
			//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
			var text3 = document.createElement ('input');
			text3.id = "employeename"+k+"";
			text3.name = "employeename"+k+"";
			text3.type = "text";
			text3.size = "30";
			text3.value = varEmployeeName;
			text3.readOnly = "readonly";
			text3.style.backgroundColor = "#FFFFFF";
			text3.style.border = "0px solid #001E6A";
			text3.style.textAlign = "left";
			text3.style.fontSize = "12";
			td3.appendChild (text3);
			tr.appendChild (td3);
			
			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td4 = document.createElement ('td');
			td4.id = "idTD4"+k+"";
			td4.align = "left";
			td4.valign = "top";
			td4.style.backgroundColor = "#FFFFFF";
			td4.style.border = "0px solid #F3F3F3";
			//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
			var text4 = document.createElement ('input');
			text4.id = "workdays"+k+"";
			text4.name = "workdays"+k+"";
			text4.type = "text";
			text4.size = "10";
			text4.value = varWorkdays;
			//text4.readOnly = "readonly";
			text4.style.backgroundColor = "#FFFFFF";
			text4.style.border = "1px solid blue";
			text4.style.textAlign = "left";
			text4.style.fontSize = "12";
			td4.appendChild (text4);
			tr.appendChild (td4);

			document.getElementById ('tblrowinsert').appendChild (tr);
		
					
	}
	
	}
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