// JavaScript Document
//function to call ajax process
function funcitemsearch2()
{
	//alert("Meow...");
	if(document.getElementById("food").value!="")
	{
		var varCustomerSearch = document.getElementById("food").value;
		//alert (varCustomerSearch);
		var varCustomerSearchLen = varCustomerSearch.length;
		//alert (varCustomerSearchLen);
		if (varCustomerSearchLen > 1)
		{
			ajaxprocessACCS2();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS2()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var customersearch=document.getElementById("food").value;
	alert(customersearch);
	var url = "";
	var url="autofoodsearch2.php?RandomKey="+Math.random()+"&&customersearch="+customersearch;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS2 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS2() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("customersearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||^||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	if (varNewLineLength == 0)
	{
		//return false;
	}
	
	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		
		//alert (varCustomerCode1);
		var food1 = varNewRecordValue[0];
	
		//alert (varCustomerName1);
		/*var VarCustomername1 = varNewRecordValue[1];
		//alert (varCustomerAddress1);
		var VarMiddlename1 = varNewRecordValue[2];
		//alert (varCustomerArea1);
		var VarlastName1 = varNewRecordValue[3];
		//alert (varCustomerCity1);
		var varCustomerPaymentType = varNewRecordValue[4];
		//alert (varCustomerPincode1);
		var varCustomerSubType = varNewRecordValue[5];
		//alert (varCustomerPincode1);
		
		var varCustomerBillType = varNewRecordValue[6];
		
		var varCustomerAccountName = varNewRecordValue[7];
		
		var varCutomeAccountExpiryDate = varNewRecordValue[8];
		
		var varCustomerPlanName = varNewRecordValue[9];
		
		var varCustomerPlanExpiryDate = varNewRecordValue[10];
		
		var varCustomerVisitLimit = varNewRecordValue[11];
		
		var varCustomerOverallLimit = varNewRecordValue[12];
		//alert (varCustomerPincode1);
		var varRes4PaymentType = varNewRecordValue[13];
		
		var varRes4SubType = varNewRecordValue[14];
		
		var varRes4AccountName = varNewRecordValue[15];
		
		var varRes4PlanName = varNewRecordValue[16];
				
		var varVisitCount = varNewRecordValue[17];
		
		var varRes4PlanFixedAmount = varNewRecordValue[18];
				
		var varRes4PlanPercentage = varNewRecordValue[19];
		
		var VarRes4AvailableLimit = varNewRecordValue[20];*/
		
		
		//document.getElementById("customercode").value = "";
		//document.getElementById("customer").value = "";
		//document.getElementById("drug1").value = itemname1;
		/*document.getElementById("patientfirstname").value = VarCustomername1;
		document.getElementById("patientmiddlename").value = VarMiddlename1;
		document.getElementById("patientlastname").value = VarlastName1;
		document.getElementById("patientcode").value = varCustomercode1;
		//document.getElementById("").value = varPatientFirstname;
		
		document.getElementById("paymenttype").value = varCustomerPaymentType;
		document.getElementById("subtype").value = varCustomerSubType;
		document.getElementById("billtype").value = varCustomerBillType;
		document.getElementById("accountname").value = varCustomerAccountName;
		document.getElementById("accountexpirydate").value = varCutomeAccountExpiryDate;
		document.getElementById("planname").value = varCustomerPlanName;
		document.getElementById("planexpirydate").value = varCustomerPlanExpiryDate;
		document.getElementById("visitlimit").value = varCustomerVisitLimit;
		document.getElementById("overalllimit").value =varCustomerOverallLimit;
		
		document.getElementById("paymenttypename").value = varRes4PaymentType;
		document.getElementById("subtypename").value = varRes4SubType;
		document.getElementById("accountnamename").value = varRes4AccountName;
		document.getElementById("plannamename").value = varRes4PlanName;
		document.getElementById("visitcount").value = varVisitCount;
		document.getElementById("planfixedamount").value = varRes4PlanFixedAmount;
		document.getElementById("planpercentageamount").value = varRes4PlanPercentage;
		document.getElementById("availablelimit").value = VarRes4AvailableLimit;*/
	}
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