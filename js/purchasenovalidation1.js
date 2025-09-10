// JavaScript Document

//Function call from billnumber onBlur and Save button click.
//function to call ajax process
function billnovalidation1()
{
	//alert ("Calling Bill Number Validation");
	var varLatestBillNumber1 = document.getElementById("latestbillnumber").value;
	//alert (varLatestBillNumber1);
	
	if(document.getElementById("billnumber").value == "")
	{
		alert ("Bill Number Cannot Be Blank. Please Enter Bill Number.");
		alert ("Switching Back To Latest Bill Number "+varLatestBillNumber1+"");
		document.getElementById("billnumber").value = varLatestBillNumber1;
		document.getElementById("billnumber").focus();
		return false;
	}
	if(isNaN(document.getElementById("billnumber").value))
	{
		alert ("Bill Number Should Be Only Numbers. Please Enter Proper Bill Number.");
		alert ("Switching Back To Latest Bill Number "+varLatestBillNumber1+"");
		document.getElementById("billnumber").value = varLatestBillNumber1;
		document.getElementById("billnumber").focus();
		return false;
	}
	if(document.getElementById("billnumber").value != "")
	{
		//alert("Meow...");
		ajaxprocess2();		
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

function ajaxprocess2()
{

xmlHttp=GetXmlHttpObject2()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
  	var billnumber=document.getElementById("billnumber").value;
	//alert(customercode);
	//var hairsize=document.form1.hairsize.value;
	//var type=document.form1.type.value;
	var url = "";
	var url="purchasenumbervalidation1.php?RandomKey="+Math.random()+"&&billnumber="+billnumber;
  
  

xmlHttp.onreadystatechange=stateChanged2 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged2() 
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
	
	//document.getElementById("price").innerHTML=t;
//	var longstring=t;
	//alert (longstring);
//	var brokenstring=longstring.split("^^");
	//alert(brokenstring);
	//alert(brokenstring.length);
//	var arraylength = brokenstring.length;
	//alert(arraylength);
	//arraylength = arraylength - 1;
	//alert(arraylength);

	if(t == '')
	{
	
		var varLatestBillNumber1 = document.getElementById("latestbillnumber").value;
		//alert (varLatestBillNumber1);
		
		var billnumber=document.getElementById("billnumber").value;
		alert("Bill Number "+billnumber+" Already Used & Exists In Database. Cannot Proceed. Changing To Latest Bill Number.")
		//document.getElementById("billnumber").focus();
		//document.getElementById("billnumber").value = "";
		alert ("Switching Back To Latest Bill Number "+varLatestBillNumber1+"");
		document.getElementById("billnumber").value = varLatestBillNumber1;
		document.getElementById("billnumber").focus();
		//window.location = "sales1.php"
	}
	else
	{
		//alert ("Bill Number Is Properly Set.");
		//document.getElementById("billnumber").value = t;
	}
/*	for (i=0;i<arraylength;i++)
		{
			//alert(brokenstring[i]);
			var longstring2 = brokenstring[i];
			var brokenstring2 = longstring2.split("||");
			//alert(brokenstring2);
			var varItemCode = brokenstring2[0];
			var varItemName = brokenstring2[1];
			//alert (varItemName);
			document.getElementById("servicename").add(new Option(varItemName,varItemName));
		
		}*/
	/*
	var newOption = document.createElement('<option value="TOYOTA">');
	document.form4.to1.options.add(newOption);
    newOption.innerText = "Toyota";
	*/
	
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

