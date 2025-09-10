// JavaScript Document
//function to call ajax process
function ExpenseFunction()
{
	
	//alert("Meow...");
			//alert ("5");	
	if(document.getElementById("expensemainanum").value != "")
	{
					//alert ("6");
		var varItemSearch = document.getElementById("expensemainanum").value;
		//alert (varItemSearch);
		var varItemSearchLen = varItemSearch.length;
		//alert (varItemSearchLen);
		
/*		if (varItemSearchLen == 8)
		{
			ajaxprocess();		
		}
		else
		{
			alert ("Item Code Not Found. Give Proper Code. Try Again.");
		}
*/		
		ajaxprocess();		
		//alert("Meow...");
		//ajaxprocess();		
		//var url = "";

		
	}
}

var xmlHttp

function ajaxprocess()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  
  	var expensemainanum=document.getElementById("expensemainanum").value;
	//alert(expensemainanum);
	var url = "";
	var url="expensefunction.php?RandomKey="+Math.random()+"&&expensemainanum="+expensemainanum;
    //alert(url);

	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged() 
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
	document.getElementById("expensesubanum").options.length=null;
	var combo = document.getElementById("expensesubanum");
	combo.options[0] = new Option("Select Expense Sub Name","");

	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
			var expensesubanum = varNewRecordValue[0];
			//alert (expensesubanum);
			var expensesubname = varNewRecordValue[1];
			//alert (expensesubname);	
			combo.options[m] = new Option(expensesubname,expensesubanum );
			document.getElementById("expensesubanum").focus();

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