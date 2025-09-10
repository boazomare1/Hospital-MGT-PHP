// JavaScript Document
//function to call ajax process
function accountsearchanum()
{
	//alert("Meow...");/* 
	if(document.getElementById("location").value=="")
	{
		alert('Select Location');
		document.getElementById("location").focus();
		return false;
	} */
	if(document.getElementById("accountsmaintype").value=="")
	{
		alert('Select Accounts Main');
		document.getElementById("accountsmaintype").focus();
		return false;
	}
	if(document.getElementById("accountssub").value=="")
	{
		alert('Select Accounts Sub');
		document.getElementById("accountssub").focus();
		return false;
	}	if(document.getElementById("accountssub").value!="2")	{		//alert("hide");		document.getElementById("iscapitation").disabled = true;		document.getElementById("is_receivable").disabled = true;		document.getElementById("misreport").disabled = true;		document.getElementById("paymenttype").disabled = true;		document.getElementById("subtype").disabled = true;	}				else{		//alert("show");		document.getElementById("iscapitation").disabled = false;		document.getElementById("is_receivable").disabled = false;		document.getElementById("misreport").disabled = false;		document.getElementById("paymenttype").disabled = false;		document.getElementById("subtype").disabled = false;	}
		
	ajaxprocess();		

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
  
  	var Location=document.getElementById("location").value;
	var Accmain=document.getElementById("accountsmaintype").value;
	var Accsub=document.getElementById("accountssub").value;
	//alert(customercode);
	var url = "";
	var url="autoaccountanumsearch.php?RandomKey="+Math.random()+"&&location="+Location+"&&accountsmain="+Accmain+"&&accountssub="+Accsub;
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
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("coasearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	document.getElementById("id").value = t;
	
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