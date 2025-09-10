// JavaScript Document
//function to call ajax process
function funcCustomerSearch2()
{
	//alert("Meow...");
	if(document.getElementById("customercode").value!="")
	{
		var varCustomerSearch = document.getElementById("customercode").value;
		//alert (varCustomerSearch);
		var varCustomerSearchLen = varCustomerSearch.length;
		//alert (varCustomerSearchLen);
		if (varCustomerSearchLen > 1)
		{
			ajaxprocessACCS2();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS2()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  
  	var customersearch=document.getElementById("customercode").value;
	//alert(customercode);
	var url = "";
	var url="autocustomercodesearch2.php?RandomKey="+Math.random()+"&&customersearch="+customersearch;
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
		var varCustomerCode1 = varNewRecordValue[0];
		//alert (varCustomerCode1);
		var varCustomerName1 = varNewRecordValue[1];
		//alert (varCustomerName1);
		var varCustomerAddress1 = varNewRecordValue[2];
		//alert (varCustomerAddress1);
		var varCustomerArea1 = varNewRecordValue[3];
		//alert (varCustomerArea1);
		var varCustomerCity1 = varNewRecordValue[4];
		//alert (varCustomerCity1);
		var varCustomerPincode1 = varNewRecordValue[5];
		//alert (varCustomerPincode1);
		var varCustomerTinnumber1 = varNewRecordValue[6];
		//alert (varCustomerPincode1);
		var varCustomerCstnumber1 = varNewRecordValue[7];
		//alert (varCustomerPincode1);
		
		document.getElementById("customercode").value = "";
		document.getElementById("customer").value = "";
		document.getElementById("customercode").value = varCustomerCode1;
		document.getElementById("customer").value = varCustomerName1;
		document.getElementById("address1").value = varCustomerAddress1;
		document.getElementById("area").value = varCustomerArea1;
		document.getElementById("city1").value = varCustomerCity1;
		document.getElementById("pincode").value = varCustomerPincode1;
		document.getElementById("customertin").value = varCustomerTinnumber1;
		document.getElementById("customercst").value = varCustomerCstnumber1;
		//document.getElementById("itemcode").focus();
		
			
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