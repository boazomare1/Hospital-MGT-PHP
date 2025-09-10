// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function funcaccountValidation1()
{
	//alert ("Calling Bill Number Validation");
	var varaccountNumber = document.getElementById("accountname").value;
	//alert (varNationalIDNumber);
	
	
	if(document.getElementById("accountname").value != "")
	{
		//alert("Meow...");
		ajaxprocess2validation();		
		//var url = "";
	}
	/*
	else if(document.form1.hairtype.value=="Select" || document.form1.hairsize.value=="Select")
	{
		document.getElementById("price").innerHTML='';
		
	}
	*/
}

var xmlHttp

function ajaxprocess2validation()
{

xmlHttp=GetXmlHttpObject2validation()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var varaccountNumber = document.getElementById("accountname").value;
	alert(varaccountNumber);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="accountvalidation.php?account="+varaccountNumber+"&&RandomKey="+Math.random()+"";
  	alert(url);
  

xmlHttp.onreadystatechange=stateChanged2validation 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged2validation() 
{ 
alert (xmlHttp.readyState);
alert (xmlHttp.responseText);
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	
	//alert (xmlHttp);
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customername").value="";
//	document.getElementById('servicename').options.length=null; 

	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	alert(t);
	
	if(t == 'ID FOUND')
	{
		document.getElementById("submit").disabled=true;
		
		alert("Account has been suspended.Please Contact Accounts.");
		document.getElementById("accountnamename").focus();
		
		//window.location = "sales1.php"
		return false;
	}
	if (t == 'NOT IN RECORD')
	{
		document.getElementById("submit").disabled=false;
		
		
		//alert ("Bill Number Is Properly Set.");
	}
	/*
	var newOption = document.createElement('<option value="TOYOTA">');
	document.form4.to1.options.add(newOption);
    newOption.innerText = "Toyota";
	*/
	
 } 
}

function GetXmlHttpObject2validation()
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

