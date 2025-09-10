// JavaScript Document
//called from sales1.php
var sd = 0;
//function to call ajax process
function funcBatchNumberPopulate1(x)
{
	// if x = callfromAutoSuggest2ItemJs it handle mouse click event of item name drop down list.
	
	//if(document.getElementById("categoryname").value!="")
	//{
		var x= x;
		sd=x;
		//alert("Meow...");
		//alert(x);
			//alert ("2");
		var varItemCode = document.getElementById("medicinecode").value;
		//alert(varItemCode);
		if (varItemCode != '')
		{
			ajaxprocess5batchnumber(x);
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
	
  	var varItemCode = document.getElementById("medicinecode").value;
	
  	/*var locationcode = document.getElementById("locationcode").value;*/
	var locationcode = document.getElementById("location").value;
	var storecode = document.getElementById("store").value;
	
	var url = "";
	var url="autocompletebatchnumberippharmacyissue.php?RandomKey="+Math.random()+"&&itemcode="+varItemCode+"&&locationcode="+locationcode+"&&storecode="+storecode;
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
	var brokenstring=longstring.split("||");
	//alert(brokenstring);
	//alert(brokenstring.length);
	var arraylength = brokenstring.length;

	//arraylength = arraylength - 1;
	//alert(arraylength);
	//if (longstring == "")
	if (arraylength == 0)
	{
			return false;
	}
	else
	{
		//alert ("Inside Else");
		
		/* Working in IE. Not in Chrome or Firefox
		document.getElementById('batchnumber').options.length=null; 
		var newOption = document.createElement('<option value="">');
		document.getElementById("batchnumber").options.add(newOption);
		newOption.innerText = "BatchNo";
		*/
		
		document.getElementById('batchnumber').options.length=null; 
		//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
		var newOption = document.createElement('option');
		newOption.text = "Batch";
		newOption.value = "";
		newOption.selected = "selected";
		try 
		{
			document.getElementById("batchnumber").options.add(newOption, null); //Standard To Chrome and Firefox.
		}
		catch(error) 
		{
			document.getElementById("batchnumber").options.add(newOption); //Only For IE.
		}



		for (i=0;i<9;i++)
		{
				//alert(Simple);
				if (brokenstring[i] != null)
				{
				//alert(brokenstring[i]);
				var longstring = t;
				var brokenstring = longstring.split("||");
				if (brokenstring[i] != null)
				{
					/* Working in IE. Not in Chrome or Firefox
					var newOption = document.createElement('<option value="'+brokenstring[i]+'">');
					document.getElementById("batchnumber").options.add(newOption);
					newOption.innerText = brokenstring[i];
					*/
					//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
					var newOption = document.createElement('option');
					newOption.text = brokenstring[i];
					newOption.value = brokenstring[i];
					try 
					{
						document.getElementById("batchnumber").options.add(newOption, null); //Standard To Chrome and Firefox.
					}
					catch(error) 
					{
						document.getElementById("batchnumber").options.add(newOption); //Only For IE.
					}
					
				}

				
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

