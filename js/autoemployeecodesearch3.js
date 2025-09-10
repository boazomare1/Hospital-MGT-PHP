// JavaScript Document
//function to call ajax process
function FuncEmployeeSearch()
{
	//alert("Meow...");
	if(document.getElementById("searchemployeecode").value!="")
	{
		var varEmployeesearch = document.getElementById("searchemployeecode").value;
		//alert (varCustomerSearch);
		var varEmployeesearchLen = varEmployeesearch.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
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
		return false;
	} 
  
  	var varEmployeesearch = document.getElementById("searchemployeecode").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeecodesearch2.php?RandomKey="+Math.random()+"&&employeesearch="+varEmployeesearch;
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
		var varEmployeecode = varNewRecordValue[0];
		//alert (varCustomerName1);
		var varEmployeeName = varNewRecordValue[1];
		//alert (varCustomerName1);
		var Location = varNewRecordValue[2];
		var Store = varNewRecordValue[3];
		var Shift = varNewRecordValue[4];
		var JobDescription = varNewRecordValue[5];
		var Gender = varNewRecordValue[6];
		var DOB = varNewRecordValue[7];
		var DOJ = varNewRecordValue[8];
		var Employmenttype = varNewRecordValue[9];
		var Firstjob = varNewRecordValue[10];
		var Overtime = varNewRecordValue[11];
		var Nationality = varNewRecordValue[12];
		var Category = varNewRecordValue[13];
		
		document.getElementById("employeecode").value = varEmployeecode;
		document.getElementById("employeename").value = varEmployeeName;
		//document.getElementById("location").value = Location;
		//document.getElementById("store").value = Store;
		//document.getElementById("shift").value = Shift;
		//document.getElementById("jobdescription").value = JobDescription;
		//document.getElementById("gender").value = Gender;
		//document.getElementById("dob").value = DOB;
		//document.getElementById("doj").value = DOJ;
		//document.getElementById("employmenttype").value = Employmenttype;
		//document.getElementById("firstjob").value = Firstjob;
		//document.getElementById("overtime").value = Overtime;
		//document.getElementById("nationality").value = Nationality;
		//document.getElementById("category").value = Category;
		
		FuncLoanEdit();
					
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