// JavaScript Document// JavaScript Document// JavaScript Document// JavaScript Document
//function to call ajax process
function funcposearch7()
{
	//alert("Meow...");
	if(document.getElementById("po").value!="")
	{
		var varposearch = document.getElementById("po").value;
		//alert (vaposearch);
		var varposearchLen = varposearch.length;
		//alert (varservicessearchLen);
		if (varposearchLen > 1)
		{
			ajaxprocessACCS27();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS27()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var posearch = document.getElementById("po").value;
	//alert(posearch);
	

	var url = "";
	var url="autopocodesearch2.php?RandomKey="+Math.random()+"&&posearch="+posearch;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS27 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS27() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("medicinesearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	//var varNewLineValue=varCompleteStringReturned.split("||^||");
	var varNewLineValue=varCompleteStringReturned.split("||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	//varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	//if (varNewLineLength == 0)
	//{
		//return false;
	//}
	
	//for (m=0;m<=varNewLineLength;m++)
	//{
		//alert (m);
		//var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		
		//alert (varCustomerCode1);
		var varbillnum = varNewLineValue[0];
		//alert (varbillnum);
		document.getElementById("po").value = varbillnum;

		var varsupplierName = varNewLineValue[1];
		//alert (varMedicineName);
		document.getElementById("supplier").value = varsupplierName;

		var varbillDate = varNewLineValue[2];
		//alert (varMedicineName);
		document.getElementById("lpodate").value = varbillDate;
		
	
		var varAddress = varNewLineValue[3];
		//alert (varMedicineName);
		document.getElementById("address").value = varAddress;
	
	    var varTelephone = varNewLineValue[4];
		//alert (varMedicineName);
		document.getElementById("telephone").value = varTelephone;
	
		

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