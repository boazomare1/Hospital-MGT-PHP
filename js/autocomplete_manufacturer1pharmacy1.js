// JavaScript Document
//called from sales1.php
var sd = 0;
//function to call ajax process
function funcManufacturerPopulate1(x)
{
	// if x = callfromAutoSuggest2ItemJs it handle mouse click event of item name drop down list.
	
	//if(document.getElementById("categoryname").value!="")
	//{
		var x= x;
		sd=x;
		//alert("Meow...");
		//alert(x);
			//alert ("2");
		var varItemCode = document.getElementById("itemcode").value;
		var varManufacturerName = document.getElementById("manufacturername").value;
		//alert (varManufacturerName);
		if (varManufacturerName == "")
		{
			if (varItemCode != '')
			{
				ajaxprocess5manufacturername(x);
			}
		}
			//alert ("3");
		//var url = "";
	//}
	/*
	else if(document.form1.hairtype.value=="Select" || document.form1.hairsize.value=="Select")
	{
		document.getElementById("price").innerHTML='';
		
	}
	*/
}

var xmlHttp

function ajaxprocess5manufacturername(sd)
{

xmlHttp=GetXmlHttpObject5manufacturername()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  	var y = sd;
  	//var catservice=document.getElementById("itemname"+y).value;
  	//var catservice=document.getElementById("itemname").value;
	//var csarr = catservice.split("||");
	//var varItemCode = csarr[0];
	//alert(serviceanum);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	
  	var varItemCode = document.getElementById("itemcode").value;
	//alert (varItemCode);
	
	var url = "";
	var url="autocompletemanufacturer1pharmacy.php?RandomKey="+Math.random()+"&&itemcode="+varItemCode;
	//alert(url);
  

xmlHttp.onreadystatechange=stateChanged5manufacturername
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged5manufacturername() 
{ 
//alert("Simple");
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	//alert("Simple");
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customername").value="";
	//document.getElementById('servicename').options.length=null; 

	
	//var t="$";
	var z=sd;
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var longstring=t;
	//alert (longstring);
	var brokenstring=longstring.split("||||");
	//alert(brokenstring);
	//alert(brokenstring[1]);
	//alert(brokenstring.length);
	var arraylength = brokenstring.length;

	arraylength = arraylength - 1;
	//alert(arraylength);
	//if (longstring == "")
	if (arraylength == 0)
	{
		return false;
	}
	else
	{
		//alert ("Inside Else");
		document.getElementById('manufacturername').options.length=null; 
		
		//Function connected with autoitemsearch3purchase.js
		//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
		var newOption = document.createElement('option');
		newOption.text = "MFR";
		newOption.value = "";
		newOption.selected = "selected";
		try 
		{
			document.getElementById("manufacturername").options.add(newOption, null); //Standard To Chrome and Firefox.
		}
		catch(error) 
		{
			document.getElementById("manufacturername").options.add(newOption); //Only For IE.
		}

		//for (i=0;i<20;i++)
		for (i=0;i<arraylength;i++)
		{
				//alert(Simple);
				if (brokenstring[i] != "")
				{
					//alert(brokenstring[i]);
					///*
					if (brokenstring[i] != null)
					{
						var varManufacturerValues1 = brokenstring[i];
						var varManufacturerValues2 = varManufacturerValues1.split("^^");
						//alert(varManufacturerValues2[0]);
						///*
						var varManufacturerAnum = varManufacturerValues2[0];
						var varManufacturerName = varManufacturerValues2[1];
						var varQuantityPerManufacturer = varManufacturerValues2[2];
						//var varShowTextValue = varManufacturerName+' '+varQuantityPerManufacturer;
						
						var newOption = document.createElement('option');
						newOption.text = varManufacturerName;
						newOption.value = varManufacturerName;
						try 
						{
							document.getElementById("manufacturername").options.add(newOption, null); //Standard To Chrome and Firefox.
						}
						catch(error) 
						{
							document.getElementById("manufacturername").options.add(newOption); //Only For IE.
						}
						//*/
						
						/*
						var newOption = document.createElement('<option value="TOYOTA">');
						document.form4.to1.options.add(newOption);
						newOption.innerText = "Toyota";
						*/
					}
				}
				
		}
		
	}
 } 
}

function GetXmlHttpObject5manufacturername()
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

