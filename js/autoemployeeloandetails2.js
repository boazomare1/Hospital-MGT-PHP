// JavaScript Document
//function to call ajax process
function EmployeeLoanmonthwise2()
{
	//alert("Meow...");
	
	
	var Empcode;
	var Empcode = document.getElementById("searchemployeecode").value;
	//alert(Empcode);
	if(Empcode!="")
	{
		
		var varEmployeesearchLen = Empcode.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
		{
			ajaxprocessACCS22(Empcode);		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS22(Empcode)
{
	xmlHttp=GetXmlHttpObject1()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmpcode = Empcode;
	var Assignmonth = document.getElementById("assignmonth").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeeloandetails2.php?RandomKey="+Math.random()+"&&employeesearch="+varEmpcode+"&&assignmonth="+Assignmonth+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS22 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS22() 
{ 
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
		
	EmployeePayroll();
	
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
		
		
	}
	
	//alert (k);
	} 
}

function GetXmlHttpObject1()
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