// JavaScript Document
//function to call ajax process
function coasearch()
{
	
	
	//to get number of rows in the table before deleting.
	for(var j = document.getElementById("tblrowinsert").rows.length; j > 0;j--)
	{
		document.getElementById("tblrowinsert").deleteRow(j -1);
	}

	
	//alert("Meow...");
	if(document.getElementById("coasearch").value!="")
	{
		var varCoaSearch = document.getElementById("coasearch").value;
		//alert (varCoaSearch);
		var varCoaSearchLen = varCoaSearch.length;
		//alert (varCoaSearchLen);
		//if (varCoaSearchLen > 1)
		//{
			ajaxprocess();		
		//}
		
		//alert("Meow...");
		//ajaxprocess();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocess()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  
  	var coasearch=document.getElementById("coasearch").value;
	//alert(customercode);
	var url = "";
	var url="autocoasearch2.php?RandomKey="+Math.random()+"&&coasearch="+coasearch;
    //alert(url);

	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("coasearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
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
	
	var k = 0;
	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		//alert(varNewRecordValue.length);
		var varNewRecordLength = varNewRecordValue.length;
		//alert(varNewRecordLength);
		varNewRecordLength = varNewRecordLength - 4;
		//alert(varNewRecordLength);
		
		var k = k + 1;
		//for (i=0;i<varNewRecordLength;i++)
		//{
			var varId = varNewRecordValue[0];
			//alert (varCustomerCode1);
			var varCoaname = varNewRecordValue[1];
			//alert (varCustomerName1);
			var varType = varNewRecordValue[2];
			//alert (varCustomerName1);
			//var varCustomerAddress2 = varNewRecordValue[3];
			
			//alert (varCustomerName1);
			
			
			var m = parseInt(m);
			var k = m + 1;
			var k = parseInt(k);
			//alert (k);
			//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
			var tr = document.createElement ('TR');
			tr.id = "idTR"+k+"";


			//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td1 = document.createElement ('td');
			td1.id = "idTD1"+k+"";
			td1.align = "left";
			td1.valign = "top";
			td1.style.backgroundColor = "#FFFFFF";
			td1.style.border = "0px solid #F3F3F3";
			//var text1 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
			var text1 = document.createElement ('input');
			text1.id = "serialnumber"+k+"";
			text1.name = "serialnumber"+k+"";
			text1.type = "text";
			text1.size = "3";
			text1.value = k;
			text1.readOnly = "readonly";
			text1.style.backgroundColor = "#FFFFFF";
			text1.style.border = "0px solid #001E6A";
			text1.style.textAlign = "right";
			text1.style.fontSize = "12";
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
			text2.id = "customercode"+k+"";
			text2.name = "customercode"+k+"";
			text2.type = "text";
			text2.size = "12";
			text2.value = varId;
			text2.readOnly = "readonly";
			text2.style.backgroundColor = "#FFFFFF";
			text2.style.border = "0px solid #001E6A";
			text2.style.textAlign = "left";
			text2.style.fontSize = "12";
			td2.appendChild (text2);
			tr.appendChild (td2);


			//var td3 = document.createElement ('<td id="idTD3'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td3 = document.createElement ('td');
			td3.id = "idTD3"+k+"";
			td3.align = "left";
			td3.valign = "top";
			td3.style.backgroundColor = "#FFFFFF";
			td3.style.border = "0px solid #F3F3F3";
			//var text3 = document.createElement ('<input value="'+varCustomerName1+'" name="customername'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="30">');
			var text3 = document.createElement ('input');
			text3.id = "customername"+k+"";
			text3.name = "customername"+k+"";
			text3.type = "text";
			text3.size = "30";
			text3.value = varCoaname;
			text3.readOnly = "readonly";
			text3.style.backgroundColor = "#FFFFFF";
			text3.style.border = "0px solid #001E6A";
			text3.style.textAlign = "left";
			text3.style.fontSize = "12";
			td3.appendChild (text3);

			//var text4 = document.createElement ('<input value="'+varCustomerAddress1+'" name="customeraddress1'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="15">');
			var text4 = document.createElement ('input');
			text4.id = "customeraddress1"+k+"";
			text4.name = "customeraddress1"+k+"";
			text4.type = "text";
			text4.size = "15";
			text4.value = varType;
			text4.readOnly = "readonly";
			text4.style.backgroundColor = "#FFFFFF";
			text4.style.border = "0px solid #001E6A";
			text4.style.textAlign = "left";
			text4.style.fontSize = "12";
			td3.appendChild (text4);

			
			tr.appendChild (td3);

			document.getElementById ('tblrowinsert').appendChild (tr);
		//}
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