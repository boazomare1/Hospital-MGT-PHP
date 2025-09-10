// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function funcVisitEntryPatientCodeValidation1()
{
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	
	var varPatientCode = document.getElementById("patientcode").value;
	//alert (varPatientCode);
	
	if(document.getElementById("patientcode").value == "")
	{
		alert ("Patient Code Cannot Be Blank. Please Select Patient.");
		document.getElementById("patientcode").focus();
		return false;
	}
	if(document.getElementById("patientcode").value != "")
	{
		//alert("Meow...");
		ajaxprocess2visitentry();		
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

function ajaxprocess2visitentry()
{

xmlHttp=GetXmlHttpObject2visitentry()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var varPatientCode = document.getElementById("patientcode").value;
	//alert(customercode);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="validationvisitentrypatientcode1.php?RandomKey="+Math.random()+"&&patientcode="+varPatientCode;
  	//alert (url);
  

xmlHttp.onreadystatechange=stateChanged2visitentry 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged2visitentry() 
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
	//return false;
	
	if(t == 'ID FOUND')
	{
		alert("Patient Visited Already Today. Please Verify Visit Report.")
		document.getElementById("patientcode").focus();
		return false;
		//window.location = "sales1.php"
	}
	if (t == 'NOT IN RECORD')
	{
		//alert ("Bill Number Is Properly Set.");
		//return false;
	}
	/*
	var newOption = document.createElement('<option value="TOYOTA">');
	document.form4.to1.options.add(newOption);
    newOption.innerText = "Toyota";
	*/
	
 } 
}

function GetXmlHttpObject2visitentry()
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

