// JavaScript Document
//function to call ajax process
function funcSupplierSearch2()
{
	//alert("Meow...");
	if(document.getElementById("suppliercode").value!="")
	{
		var varSupplierSearch = document.getElementById("suppliercode").value;
		alert (varSupplierSearch);
		var varSupplierSearchLen = varSupplierSearch.length;
		//alert (varSupplierSearchLen);
		if (varSupplierSearchLen > 1)
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
  
  	var suppliersearch=document.getElementById("suppliercode").value;
	//alert(suppliercode);
	var url = "";
	var url="autosuppliercodesearch2.php?RandomKey="+Math.random()+"&&suppliersearch="+suppliersearch;
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
	//document.getElementById("suppliername").innerHTML="";
	//document.getElementById("suppliersearch").value="";
	
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
		var varSupplierCode1 = varNewRecordValue[0];
		//alert (varSupplierCode1);
		var varSupplierName1 = varNewRecordValue[1];
		//alert (varSupplierName1);
		var varSupplierAddress1 = varNewRecordValue[2];
		//alert (varSupplierAddress1);
		var varSupplierArea1 = varNewRecordValue[3];
		//alert (varSupplierArea1);
		var varSupplierCity1 = varNewRecordValue[4];
		//alert (varSupplierCity1);
		var varSupplierPincode1 = varNewRecordValue[5];
		//alert (varSupplierPincode1);
		var varSupplierTinnumber1 = varNewRecordValue[6];
		//alert (varSupplierPincode1);
		var varSupplierCstnumber1 = varNewRecordValue[7];
		//alert (varSupplierPincode1);
		
		document.getElementById("suppliercode").value = "";
		document.getElementById("supplier").value = "";
		document.getElementById("suppliercode").value = varSupplierCode1;
		document.getElementById("supplier").value = varSupplierName1;
		document.getElementById("address1").value = varSupplierAddress1;
		document.getElementById("area").value = varSupplierArea1;
		document.getElementById("city1").value = varSupplierCity1;
		document.getElementById("pincode").value = varSupplierPincode1;
		document.getElementById("suppliertin").value = varSupplierTinnumber1;
		document.getElementById("suppliercst").value = varSupplierCstnumber1;
		document.getElementById("itemcode").focus();
		
			
	}
	//alert (k);
	} 
	//alert ("Meow...");
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