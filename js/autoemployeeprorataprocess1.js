// JavaScript Document
//function to call ajax process
function PayrollProcess()
{	
	var Flagno = 0;  
	
	for(i=1;i<2000;i++)  
	{
		if(document.getElementById("empserialnumber"+i)!= null)
		{
			if(document.getElementById("empserialnumber"+i).checked == true)
			{
				var Flagno = Flagno + 1;
				
				var varEmployeecode = document.getElementById("employeecode"+i).value;
				var Workdays = document.getElementById("workdays"+i).value;
				//alert(varEmployeecode);
				ajaxprocessACCS25(varEmployeecode,Workdays);
			}
		}
	}
	
	if(Flagno == 0)
	{
		alert("Please Select Employee to Process");
		return false;
	}
	else
	{
		document.getElementById("imgloader").style.display = "block";
	
		//CloseImageLoader();
	}
}

function CloseImageLoader()
{
	setTimeout(CloseImageLoader1,10000);	
}

function CloseImageLoader1()
{
	document.getElementById("imgloader").style.display = "none";
}

var xmlHttp

function ajaxprocessACCS25(Empcode,Workdays)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmpcode = Empcode;
	var Assignmonth = document.getElementById("assignmonth").value;
	var Workdays = Workdays;
	//alert(customersearch);
	var url = "";
	var url="autoemployeeprorataprocess1.php?RandomKey="+Math.random()+"&&employeesearch="+varEmpcode+"&&assignmonth="+Assignmonth+"&&workdays="+Workdays+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS25
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS25() 
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
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	if(t != '')
	{
		//alert("Payroll is in Hold for this Employee");	
	}
	
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
	
	CloseImageLoader1();
	
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