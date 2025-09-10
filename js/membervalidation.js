// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function membernovalidation1()
{
	//alert ("Calling Bill Number Validation");
	//var memberno = document.getElementById("memberno").value;
	//alert (memberno);

	if(document.getElementById("memberno").value != "")
	{
		ajaxprocess2();		

	}
}

var xmlHttp

function ajaxprocess2()
{

xmlHttp=GetXmlHttpObject2()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var memberno=document.getElementById("memberno").value;
	//alert(memberno);
	var url = "";
	var url="membernovalid.php?RandomKey="+Math.random()+"&&membernos="+memberno;
  //alert(url);
  

xmlHttp.onreadystatechange=stateChanged2 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged2() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	
		
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var longstring=t;
	//alert (longstring);
	var brokenstring=longstring.split("||");
	//alert(brokenstring[0]);
	//alert(brokenstring.length);
//	var arraylength = brokenstring.length;
	//alert(arraylength);
	//arraylength = arraylength - 1;
	//alert(arraylength);

	if(brokenstring[2] != '')
	{
		
		document.getElementById("policy").innerHTML = brokenstring[2];
		document.getElementById("name").innerHTML = brokenstring[1];
		document.getElementById("insurance").innerHTML = brokenstring[0];
	
	}
	else
	{
		document.getElementById("policy").innerHTML = brokenstring[2];
		document.getElementById("name").innerHTML = brokenstring[1];
		document.getElementById("insurance").innerHTML = brokenstring[0];
		alert ("Member is Invalid");
		document.getElementById("memberno").value = "";
		return false;
		
	
	}
	
 } 
}

function GetXmlHttpObject2()
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

