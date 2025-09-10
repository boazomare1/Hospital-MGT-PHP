// JavaScript Document// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function funcNationalIDValidation2()
{
	//alert ("Calling Bill Number Validation");
	var varNationalIDNumber = document.getElementById("nationalidnumber").value;
	//alert (varNationalIDNumber);
	
	if(document.getElementById("nationalidnumber").value == "")
	{
		alert ("National ID Number Cannot Be Blank. Please Enter National ID Number.");
		//document.getElementById("nationalidnumber").focus();
		return false;
	}
	if(document.getElementById("nationalidnumber").value != "")
	{
		//alert("Meow...");
		ajaxprocess3();	
		//var url = "";
	}
	/*
	else if(document.form1.hairtype.value=="Select" || document.form1.hairsize.value=="Select")
	{
		document.getElementById("price").innerHTML='';
		
	}
	*/
}

var xmlHttp;

function ajaxprocess3()
{

xmlHttp=GetXmlHttpObject3();
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var varNationalIDNumber = document.getElementById("nationalidnumber").value;
	//alert(customercode);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="validation2nationalidnumber2.php?RandomKey="+Math.random()+"&&nationalidnumber="+varNationalIDNumber;
  	//alert (url);
  

xmlHttp.onreadystatechange=stateChanged3 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged3() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customername").value="";
//	document.getElementById('servicename').options.length=null; 

	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	if(t == 'ID FOUND')
	{
		
		alert("National ID Exists In Records. Please Verify Your National ID Again.");
		document.getElementById("submit").disabled=true;
		document.getElementById("nationalidnumber").focus();
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

function GetXmlHttpObject3()
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

