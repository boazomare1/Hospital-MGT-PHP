function functionBanksearch()
{
	//alert("hi");
	if(document.getElementById("bankname").value!="")
	{
	var varbankname = document.getElementById("bankname").value;
	//alert(varbankname);
	
	ajaxprocessACCS5();		
	
		
	}
}

var xmlHttp

function ajaxprocessACCS5()
{
	
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return false;
	} 
	 var bankname =document.getElementById("bankname").value;
	//alert (bankname);
	var url = "";
	var url="autobanknamesearch1.php?RandomKey="+Math.random()+"&&bankname="+bankname;
    //alert(url);
    xmlHttp.onreadystatechange=stateChangedACCS5
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedACCS5() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
	
			var t = "";
			t=t+xmlHttp.responseText;
			//alert(t);
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
		var varGarment1 = varNewRecordValue[0];
		//alert (varGarment1);
		var varWashType1 = varNewRecordValue[1];
		//alert (varSupplierName1);
		var varUnitsname1= varNewRecordValue[2];
		//alert (varUnitsname1);
		document.getElementById("branchname").value =varGarment1;
		document.getElementById("accno").value = varWashType1;
		document.getElementById("acctype").value =  varUnitsname1;
	
		document.getElementById("transactiontype").focus();
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