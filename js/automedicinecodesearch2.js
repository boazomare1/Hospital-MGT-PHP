// JavaScript Document
//function to call ajax process
function funcmedicinesearch4()
{
	//alert("Meow...");
	if(document.getElementById("medicinecode").value!="")
	{
		var varmedicinesearch = document.getElementById("medicinecode").value;
		//alert (varmedicinesearch);
		var varmedicinesearchLen = varmedicinesearch.length;
		//alert (varmedicinesearchLen);
		if (varmedicinesearchLen > 1)
		{
			ajaxprocessACCS24();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS24()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var medicinesearch = document.getElementById("medicinecode").value;
	var accountname = document.getElementById("subtype").value;
	//alert(medicinesearch);

	
	//alert(medicinesearch);
	var url = "";
	var url="automedicinecodesearch2.php?RandomKey="+Math.random()+"&&medicinesearch="+medicinesearch+"&&accountname="+accountname;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS24 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS24() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("medicinesearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
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
		//alert(varNewLineValue[7]);
		if(varNewLineValue[7]>0)
		{
		//alert (varCustomerCode1);
		var varMedicineCode = varNewLineValue[0];
		//alert (varMedicineCode);
		document.getElementById("medicinecode").value = varMedicineCode;

		var varMedicineName = varNewLineValue[1];
		//alert (varMedicineName);
		document.getElementById("medicinename").value = varMedicineName;

		var varMedicineRate = varNewLineValue[2];
		//alert (varMedicineName);
		document.getElementById("rates").value = varMedicineRate;
		
	    var varFormula = varNewLineValue[3];
		//alert (varFormula);
		document.getElementById("formula").value = varFormula;
		//alert(varMedicinefrequency);
	    var varStrength = varNewLineValue[4];
		
		document.getElementById("strength").value = varStrength;
		
		var vargenericname1 = varNewLineValue[5];
		
		document.getElementById("genericname").value = vargenericname1;
		
		var drugallergy = document.getElementById("drugallergy").value;
		
		vargenericname1 = vargenericname1.toUpperCase();
		
		if((vargenericname1 != '')&&(drugallergy != ''))
		{
		
		if(drugallergy == vargenericname1)
		{
			var check=confirm('Patient is Allergic to this drug, Do you like to Proceed?');
			//alert(check);
			if(check == false)
			{
				document.getElementById("medicinename").value ='';
				document.getElementById("rates").value = '';
				
			}
			
		}
		}
		
		var status = varNewLineValue[6];
		
		if(status > 0)
		{
			
			var check=confirm('Medicine is Excluded for Patient Account');
			//alert(check);
			if(check == false)
			{
				document.getElementById("medicinename").value ='';
				document.getElementById("rates").value = '';
				
			}
			else
			{
				document.getElementById("exclude").value ='excluded';
			}
		}
	
		//document.getElementById("serialnumber").value = "";
		//document.getElementById("medicinename").value = "";
		document.getElementById("medicinename").value = varMedicineName;
		}
		else
		{
			alert('Medicine Is Out of stock');
			document.getElementById("medicinecode").value = '';
			document.getElementById("medicinename").value = '';
			return false;
		}
	//}
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