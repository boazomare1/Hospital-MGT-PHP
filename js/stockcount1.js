// JavaScript Document


//function to call ajax process
function itemcodesearch1()
{
	if(document.getElementById("itemcode").value != "")
	{
		//alert("Meow...");
		ajaxprocess("itemcodesearch1");		
		//var url = "";
	}
}

function itemcodesearch2()
{
	if(document.getElementById("searchitemcode").value != "")
	{
		//alert("Meow...");
		//var varSearchItemCode = document.getElementById("searchitemcode").value;
		ajaxprocess("itemcodesearch2");		
		//var url = "";
	}
	else
	{
		alert ("Please Enter Proper Item Code.");
		document.getElementById("searchitemcode").focus();
		return false;
	}
}

function itemcodesearch3()
{
	if(document.getElementById("itemname").value != "")
	{
		//alert("Meow...");
		ajaxprocess("itemcodesearch3");		
		//var url = "";
	}
	else
	{
		alert ("Please Enter Proper Item Name.");
		document.getElementById("itemname").focus();
		return false;
	}
}


var xmlHttp

function ajaxprocess(varSearchItemCode)
{

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var varSearchItemCode = varSearchItemCode;
	if (varSearchItemCode == "itemcodesearch1")
	{
		var itemcode=document.getElementById("itemcode").value;
	}
	if (varSearchItemCode == "itemcodesearch2")
	{
		var itemcode=document.getElementById("searchitemcode").value;
	}
	if (varSearchItemCode == "itemcodesearch3")
	{
		var longstring = document.getElementById("itemname").value;
		//alert (longstring);
		var brokenstring = longstring.split("||");
		//alert(brokenstring);
		var arraylength = brokenstring.length;
		arraylength = arraylength - 1;
		//alert(arraylength);
		if (arraylength == 0)
		{
			alert ("Please Enter Proper Item Name.");
			document.getElementById("itemname").focus();
			return false;
		}
		var varItemCode = brokenstring[0];
		var varItemName = brokenstring[1];
		var varSearchItemCode = varItemCode;
		var itemcode = varItemCode;
	}
	//alert(customercode);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	//alert(customercode);
	var url = "";
	var url="autocompletestockcount1.php?RandomKey="+Math.random()+"&&itemcode="+itemcode;
  	//alert(url);
	//document.getElementById("remarks").value = url;

xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	if (document.getElementById("currentstock") != null)
	{
		document.getElementById("currentstock").value = "";
	}
	document.getElementById("selecteditemcode").value = "";
	document.getElementById("selecteditemname").value = "";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	var longstring = t;
	//alert (longstring);
	var brokenstring=longstring.split("||");
	//alert(brokenstring);
	var arraylength = brokenstring.length;
	arraylength = arraylength - 1;
	//alert(arraylength);
	if (arraylength == 0)
	{
		alert ("Selected Item Code Does Not Exist. Select Proper Item Code.");
		document.getElementById("currentstock").value = "";	//this will avoid msgbox loop.	
		return false;
	}
	var varCurrentStock = brokenstring[0];
	var varItemCode = brokenstring[1];
	var varItemName = brokenstring[2];

	if (document.getElementById("currentstock") != null)
	{
		document.getElementById("currentstock").value = varCurrentStock;
	}
	document.getElementById("selecteditemcode").value = varItemCode;
	document.getElementById("selecteditemname").value = varItemName;
	
	/*
	//document.getElementById("price").innerHTML=t;
	var longstring=t;
	//alert (longstring);
	var brokenstring=longstring.split("||");
	//alert(brokenstring);
	//alert(brokenstring.length);
	var arraylength = brokenstring.length;
	//alert(arraylength);
	arraylength = arraylength - 1;
	//alert(arraylength);
	if (arraylength == 0)
	{
		alert ("Item Code Does Not Exist. Select Proper Code.");
		document.getElementById("currentstock").value = "";	//this will avoid msgbox loop.	
		return false;
	}
	else
	{
		for (i=0;i<arraylength;i++)
		{
			//alert(brokenstring[i]);
			var longstring2 = t;
			var brokenstring2 = longstring2.split("||");
			//alert(brokenstring2);
			//var newOption = document.createElement('<option value="'+brokenstring2[1]+'">');
			//document.getElementById("to1").options.add(newOption);
			//newOption.innerText = brokenstring2[0];
			document.getElementById("currentstock").value = brokenstring2[0];
		}
	}
	*/
	/*
	var newOption = document.createElement('<option value="TOYOTA">');
	document.form4.to1.options.add(newOption);
    newOption.innerText = "Toyota";
	*/
	
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

