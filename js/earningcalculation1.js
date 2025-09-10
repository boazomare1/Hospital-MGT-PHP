// JavaScript Document
//function to call ajax process
function EarningCalculation1(k)
{
	
	//alert("Meow...");
		var k = k;
	if(!isNaN(document.getElementById("earningvalue"+k).value))
	{
		var varEarningValue = document.getElementById("earningvalue"+k).value;
		//alert (varEarningValue);
		var varEarningValueLen = varEarningValue.length;
		//alert (varItemSearchLen);
		
		if (varEarningValueLen > 1)
		{
			ajaxprocess10(k);		
		}
		else
		{
			//alert ("Item Code Not Found. Give Proper Code. Try Again.");
		}
		
	}
	else
	{
		alert("Please Enter Numbers");
		document.getElementById("earningamount"+k).value = "";
		document.getElementById("earningvalue"+k).focus();
		return false;
	}
}

var xmlHttp

function ajaxprocess10(k)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  	var k = k;
  	var varEarningValue = document.getElementById("earningvalue"+k).value;
	var varEarningAnum = document.getElementById("earninganum"+k).value;
	//var varSupplierCode1 = document.getElementById("suppliercode").value;
	//alert(itemcode);
	var url = "";
	var url="autoearningcalculation1.php?RandomKey="+Math.random()+"&&earninganum="+varEarningAnum+"&&earningvalue="+varEarningValue+"&&sno="+k;
    //alert(url);

	xmlHttp.onreadystatechange=stateChanged10 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged10() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("itemname").innerHTML="";
	//document.getElementById("itemcode").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;

	//alert ("var");
	//var varNewLineValue=varCompleteStringReturned.split("||^||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	//var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	//varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	
	//for (m=0;m<=varNewLineLength;m++)
	//{
		//alert (m);
		var varNewRecordValue=varCompleteStringReturned.split("||");
		//alert(varNewRecordValue);
		//alert(varNewRecordValue.length);
		//var varNewRecordLength = varNewRecordValue.length;
		//alert(varNewRecordLength);
		//varNewRecordLength = varNewRecordLength - 4;
		//alert(varNewRecordLength);
		
		//var k = 0;
		//for (i=0;i<varNewRecordLength;i++)
		//{
			var varSno = varNewRecordValue[0];
			//alert (varItemCode1);
			var varEarningAmount = varNewRecordValue[1];
			//alert (varEarningAmount);
			

			document.getElementById("earningamount"+varSno).value = varEarningAmount;
			
		//}
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