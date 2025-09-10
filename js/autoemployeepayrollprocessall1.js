// JavaScript Document
//function to call ajax process
function AllProcess()
{	
	//alert(varEmployeecode);
	ajaxprocessACCS26();
	
	document.getElementById("imgloader").style.display = "block";
	
	CloseImageLoader();
			
}

function CloseImageLoader()
{
	//setTimeout(CloseImageLoader1,10000);	
}

function CloseImageLoader1()
{
	document.getElementById("imgloader").style.display = "none";
}

var xmlHttp

function ajaxprocessACCS26()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	//var varEmpcode = Empcode;
	var Assignmonth = document.getElementById("assignmonth").value;
	
	//alert(customersearch);
	var url = "";
	var url="autoemployeepayrollprocessall1.php?RandomKey="+Math.random()+"&&assignmonth="+Assignmonth+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS26
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS26() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
	
	//employeesearch6();
	for(var j = document.getElementById("tblrowinsert").rows.length; j > 0;j--)
	{
		document.getElementById("tblrowinsert").deleteRow(j -1);
	}
	
	for(var s = document.getElementById("tblrowinsert1").rows.length; s > 0;s--)
	{
		document.getElementById("tblrowinsert1").deleteRow(s -1);
	}
	
	document.getElementById("grosspay").value = "";
	document.getElementById("totaldeductions").value = "";
	document.getElementById("nettpay").value = "";
	
	CloseImageLoader1();
	
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
		var varEmployeecode = varNewRecordValue[0];
		//alert (varCustomerName1);
		var varEmployeeName = varNewRecordValue[1];
		//alert (varCustomerName1);
		var varComponentname = varNewRecordValue[2];
		
		var varComponentrate = varNewRecordValue[3];
				
	}
	
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