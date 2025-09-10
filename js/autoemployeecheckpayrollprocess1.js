// JavaScript Document
//function to call ajax process
function CheckPayrollProcess(callfrom)
{	
	var Flagno = 0; 
	
	var callfrom = callfrom;
	
	ajaxprocessACCS251(callfrom);
	
}

var xmlHttp

function ajaxprocessACCS251(callfrom)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request") 
		return false;
	} 
  
  	var callfrom = callfrom;
	var Assignmonth = document.getElementById("assignmonth").value;

	var url = "";
	var url="autoemployeepayrollcheck1.php?RandomKey="+Math.random()+"&&callfrom="+callfrom+"&&assignmonth="+Assignmonth+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS251
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS251() 
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
	if(t != '')
	{
		//alert(t);	
	}
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned;
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	
		//alert (m);
		var varNewRecordValue=varNewLineValue;
		varNewRecordValue=varNewRecordValue.trim();
		//alert(varNewRecordValue);
		var varAccess = varNewRecordValue[0];
		//alert (varAccess);
		var varCallFrom = varNewRecordValue[1];
		//alert (varCallFrom);
		
		if(varNewRecordValue == 'Process||all')
		{
			AllProcess();
		}
		else if(varNewRecordValue == 'Process||selected')
		{
			PayrollProcess();
		}
		else
		{
			alert("Payroll already Processed for this Month.");
			return false;
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