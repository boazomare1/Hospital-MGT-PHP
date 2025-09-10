// JavaScript Document// JavaScript Document
//function to call ajax process
function funclabsearch6()
{
	//alert("Meow...");
	//alert(document.getElementById("billtypes").value);
	if(document.getElementById("radiologycode").value!="")
	{
		var varradiologysearch = document.getElementById("radiologycode").value;
		//alert (varmedicinesearch);
		var varradiologysearchLen = varradiologysearch.length;
		//alert (varmedicinesearchLen);
		if (varradiologysearchLen > 1)
		{
			ajaxprocessACCS26();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS26()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var radiologysearch = document.getElementById("radiologycode").value;
	var varpatienttype1 = document.getElementById("billtypes").value;
	var varpaymenttype = document.getElementById("payment").value;
	//alert(varpatienttype1);

	//get location code here
	//alert(radiologysearch);
	var locationcode = document.getElementById("locationcode").value;
		var subtype = document.getElementById("subtypeano").value;
	//alert(locationcode);
	//alert(medicinesearch);
	//alert(subtype);
	var url = "";
	var url="autoradiologycodesearch2.php?RandomKey="+Math.random()+"&&radiologysearch="+radiologysearch+"&&patienttypesearch="+varpatienttype1+"&&varpaymenttype="+varpaymenttype+"&&locationcode="+locationcode+"&&subtype="+subtype;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS26 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS26() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("medicinesearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	//var varNewLineValue=varCompleteStringReturned.split("||^||");
	var varNewLineValue=varCompleteStringReturned.split("||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	//varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	//if (varNewLineLength == 0)
	//{
		//return false;
	//}
	
	//for (m=0;m<=varNewLineLength;m++)
	//{
		//alert (m);
		//var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		
		//alert (varCustomerCode1);
		var varradiologyCode = varNewLineValue[0];
		//alert (varMedicineCode);
		document.getElementById("radiologycode").value = varradiologyCode;

		var varradiologyName = varNewLineValue[1];
		//alert (varMedicineName);
		document.getElementById("radiology").value = varradiologyName;

		var varradiologyRate = varNewLineValue[2];
		//alert (varMedicineName);
		document.getElementById("rate8").value = formatMoney(varradiologyRate);
		insertitem3();
		var varpkg = varNewLineValue[3];
		document.getElementById("pkg1").value = varpkg
		
		var Packapp = document.getElementById("packcharge").value;
		
		document.getElementById("radiologyfree").options.length = null;
		if(Packapp == 1)
		{
			if(varpkg=='yes')
			{
				var x = document.getElementById("radiologyfree");
				x.remove(x[0]);x.remove(x[1]);
				var option = document.createElement("option");
				option.text = "Yes";
				option.value="yes";
				option.selected="selected";
				x.add(option, x[0]);
				var option2 = document.createElement("option");
				option2.text = "No";
				option2.value="no";
				x.add(option2, x[1]);
				
			}
			else
			{
				
				var x = document.getElementById("radiologyfree");
				x.remove(x[0]);
				var option = document.createElement("option");
				option.text = "No";
				option.value="no";
				option.selected="selected";
				x.add(option, x[0]);				
			}
		}
		else
		{
				var x = document.getElementById("radiologyfree");
				x.remove(x[0]);
				var option = document.createElement("option");
				option.text = "No";
				option.value="no";
				option.selected="selected";
				x.add(option, x[0]);
		}
		//alert(varMedicinefrequency);
	    
		/*var VarMiddlename1 = varNewRecordValue[2];
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
		//document.getElementById("serialnumber").value = "";
		//document.getElementById("medicinename").value = "";
		document.getElementById("radiology").value = Varradiologyname;
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
	//}
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