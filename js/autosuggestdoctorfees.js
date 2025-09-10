// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function funcVisitdoctor()
{
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	
	var varPatientCode = document.getElementById("consultingdoctorcode").value;
	//alert (varPatientCode);
	
	if(document.getElementById("consultingdoctorcode").value != "")
	{
		//alert("Meow...");
		ajaxprocess2visitentry1();		
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

function ajaxprocess2visitentry1()
{

xmlHttp=GetXmlHttpObject2visitentry()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var varPatientCode = document.getElementById("consultingdoctorcode").value;
	//alert(customercode);
	var location = document.getElementById("location").value;
	var subtype = document.getElementById("subtype").value;
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="ajaxdoctorfees.php?RandomKey="+Math.random()+"&&consultingdoctor="+varPatientCode+"&&location="+location+"&&subtype="+subtype;
  	//alert (url);
  

xmlHttp.onreadystatechange=stateChanged2visitentry1
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged2visitentry1() 
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
	
	if(t != '')
	{
		//alert(t);
		var tsplit = t.split('#');
		var consultfees = tsplit[2];
		var hospfees = tsplit[3];
		var drfees = tsplit[4];
		
		document.getElementById("hospitalfees").value = hospfees;
		document.getElementById("doctorfees").value = drfees;
		document.getElementById("consultationfees").value = consultfees;
		//window.location = "sales1.php"
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

