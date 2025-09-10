// JavaScript Document// JavaScript Document
//function to call ajax process
function funcitemsearch5()
{
	//alert("Meow...");
	if(document.getElementById("id").value!="")
	{
		var vardepreciationsearch = document.getElementById("id").value;
			//alert(document.getElementById("billtypes").value);
		//alert (varmedicinesearch);
		var vardepreciationsearchLen = vardepreciationsearch.length;
		//alert (varmedicinesearchLen);
		if (vardepreciationsearchLen != "")
		{
			ajaxprocessACCS25();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS25()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var depreciationsearch = document.getElementById("id").value;
	
		//alert(medicinesearch);
	var url = "";
	var url="autodepreciationcodesearch.php?RandomKey="+Math.random()+"&&depreciationsearch="+depreciationsearch;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS25 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS25() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 

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

		var varitemname = varNewLineValue[0];
		//alert (varMedicineCode);
		document.getElementById("itemname").value = varitemname;

		var category = varNewLineValue[1];
		//alert (varMedicineName);
		//document.getElementById("category").value = category;

		var assetvalue = varNewLineValue[2];
		//alert (varlabRate);
		document.getElementById("cost").value = assetvalue;
		

		var life = varNewLineValue[3];
		//alert (varlabRate);
		document.getElementById("life").value = life;

		var salvage = varNewLineValue[4];
		//alert (varlabRate);
		document.getElementById("salvage").value = salvage;
		
		var depreciation = varNewLineValue[5];
		//alert (varlabRate);
		document.getElementById("depreciation").value = depreciation;
		
		var id = varNewLineValue[6];
		//alert (varlabRate);
		document.getElementById("id").value = id;
		 
		 var ACC = varNewLineValue[7];
		//alert (varlabRate);
		document.getElementById("accdepreciation").value = ACC;
		
		 var ACC1 = varNewLineValue[8];
		//alert (varlabRate);
		document.getElementById("asset").value = ACC1;
		
		 var ACC2 = varNewLineValue[9];
		//alert (varlabRate);
		document.getElementById("assetcode").value = ACC2;



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