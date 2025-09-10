// JavaScript Document
//called from sales1.php
var sd = 0;
//function to call ajax process
function funcPackagePopulate1(x)
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
		var varPackageName = document.getElementById("packagename").value;
		//alert (varPackageName);
		if (varPackageName == "")
		{
			if (varItemCode != '')
			{
				ajaxprocess5batchnumber(x);
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

function ajaxprocess5batchnumber(sd)
{

xmlHttp=GetXmlHttpObject5batchnumber()
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
	var url="autocompletepackage1pharmacy.php?RandomKey="+Math.random()+"&&itemcode="+varItemCode;
	//alert(url);
  

xmlHttp.onreadystatechange=stateChanged5batchnumber
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged5batchnumber() 
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
		document.getElementById('packagename').options.length=null; 
		
		//Function connected with autoitemsearch3purchase.js
		//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
		var newOption = document.createElement('option');
		newOption.text = "Pack";
		newOption.value = "";
		newOption.selected = "selected";
		try 
		{
			document.getElementById("packagename").options.add(newOption, null); //Standard To Chrome and Firefox.
		}
		catch(error) 
		{
			document.getElementById("packagename").options.add(newOption); //Only For IE.
		}

		for (i=0;i<20;i++)
		{
				//alert(Simple);
				if (brokenstring[i] != "")
				{
					//alert(brokenstring[i]);
					///*
					if (brokenstring[i] != null)
					{
						var varPackageValues1 = brokenstring[i];
						var varPackageValues2 = varPackageValues1.split("^^");
						//alert(varPackageValues2[0]);
						///*
						var varPackageAnum = varPackageValues2[0];
						var varPackageName = varPackageValues2[1];
						var varQuantityPerPackage = varPackageValues2[2];
						//var varShowTextValue = varPackageName+' '+varQuantityPerPackage;
						
						var newOption = document.createElement('option');
						newOption.text = varPackageName;
						newOption.value = varPackageName;
						try 
						{
							document.getElementById("packagename").options.add(newOption, null); //Standard To Chrome and Firefox.
						}
						catch(error) 
						{
							document.getElementById("packagename").options.add(newOption); //Only For IE.
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

function GetXmlHttpObject5batchnumber()
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

