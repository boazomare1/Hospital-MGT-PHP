// JavaScript Document
//function to call ajax process
function BasicCalculation1(grosspay)
{
	
	//alert("Meow...");
	var vargrosspay = grosspay;
	
	if(vargrosspay != "")
	{	
		if(!isNaN(vargrosspay))
		{
			var vargrosspay = vargrosspay;
			//alert (varEarningValue);
			var vargrosspaylen = vargrosspay.length;
			//alert (varItemSearchLen);
			
			if (vargrosspaylen > 0)
			{
				ajaxprocess10(vargrosspay);		
			}
			else
			{
				//alert ("Item Code Not Found. Give Proper Code. Try Again.");
			}
			
		}
		else
		{
			alert("Please Enter Numbers");
			document.getElementById("basic").value = "0.00";
			document.getElementById("paye").value = "0.00";
			document.getElementById("nssf").value = "0.00";
			document.getElementById("nhif").value = "0.00";
			document.getElementById("deductions").value = "0.00";
			document.getElementById("nettpay").value = "0.00";
			return false;
		}
	}
	else
	{
		document.getElementById("basic").value = "0.00";
		document.getElementById("paye").value = "0.00";
		document.getElementById("nssf").value = "0.00";
		document.getElementById("nhif").value = "0.00";	
		document.getElementById("deductions").value = "0.00";
		document.getElementById("nettpay").value = "0.00";
	}
}

var xmlHttp

function ajaxprocess10(grosspay)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  	
  	var grosspay = grosspay;
	
	//alert(itemcode);
	var url = "";
	var url="autobasiccalculation1.php?RandomKey="+Math.random()+"&&grosspay="+grosspay;
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
			var varBasic = varNewRecordValue[0];
			//alert (varItemCode1);
			var varPAYE = varNewRecordValue[1];
			//alert (varEarningAmount);
			var varNSSF = varNewRecordValue[2];
			//alert (varEarningAmount);
			var varNHIF = varNewRecordValue[3];
			//alert (varEarningAmount);
			var varDeductions = varNewRecordValue[4];
			//alert (varEarningAmount);
			var varNettpay = varNewRecordValue[5];
			//alert (varEarningAmount);
		
			document.getElementById("basic").value = varBasic;
			document.getElementById("paye").value = varPAYE;
			document.getElementById("nssf").value = varNSSF;
			document.getElementById("nhif").value = varNHIF;
			document.getElementById("deductions").value = varDeductions;
			document.getElementById("nettpay").value = varNettpay;
			
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