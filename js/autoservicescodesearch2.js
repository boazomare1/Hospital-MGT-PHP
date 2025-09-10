// JavaScript Document// JavaScript Document// JavaScript Document
//function to call ajax process
function funcservicessearch7()
{
	//alert("Meow...");
	if(document.getElementById("servicescode").value!="")
	{
		var varservicessearch = document.getElementById("servicescode").value;
		//alert (varservicessearch);
		var varservicessearchLen = varservicessearch.length;
		//alert (varservicessearchLen);
		if (varservicessearchLen > 1)
		{
			ajaxprocessACCS27();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS27()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var servicessearch = document.getElementById("servicescode").value;
	var varpatienttype2 = document.getElementById("billtypes").value;
	var varpaymenttype = document.getElementById("payment").value;
	
	var locationcode = document.getElementById("locationcode").value;
			var subtype = document.getElementById("subtypeano").value;

	//alert(locationcode);
	
	//alert(servicessearch);
	var url = "";
	var url="autoservicescodesearch2.php?RandomKey="+Math.random()+"&&servicessearch="+servicessearch+"&&patienttypesearch="+varpatienttype2+"&&varpaymenttype="+varpaymenttype+"&&locationcode="+locationcode+"&&subtype="+subtype;
    //alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS27 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS27() 
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
		var varservicesCode = varNewLineValue[0];
		//alert (varservicesCode);
		document.getElementById("servicescode").value = varservicesCode;

		var varservicesName = varNewLineValue[1];
		//alert (varMedicineName);
		document.getElementById("services").value = varservicesName;

		var varservicesRate = varNewLineValue[2];
		
		document.getElementById("rate3").value = varservicesRate;
		
		var varservicesBase = varNewLineValue[3];
		
		document.getElementById("baseunit").value = varservicesBase;
		
		var varservicesIncrQty = varNewLineValue[4];
		
		document.getElementById("incrqty").value = varservicesIncrQty;
		
		var varservicesIncrRate = varNewLineValue[5];
		
		document.getElementById("incrrate").value = varservicesIncrRate;
		
		var varservicesSlab = varNewLineValue[6];
		
		document.getElementById("slab").value = varservicesSlab;
		
		if(document.getElementById("slab").value=='')
		{
			document.getElementById('baseunit').disabled=true;
			document.getElementById('incrqty').disabled=true;
			document.getElementById('incrrate').disabled=true;
			}
		if(document.getElementById("slab").value=='1')
		{
			document.getElementById('baseunit').disabled=false;
			document.getElementById('incrqty').disabled=false;
			document.getElementById('incrrate').disabled=false;
			}
		var varpkg = varNewLineValue[7];
		
		document.getElementById("pkg2").value = varpkg;
		
		var Packapp = document.getElementById("packcharge").value;
		
		document.getElementById("servicesfree").options.length = null;
		
		if(Packapp == 1)
		{
			if(varpkg=='yes')
			{
				
				var x = document.getElementById("servicesfree");
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
				
				var x = document.getElementById("servicesfree");
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
				var x = document.getElementById("servicesfree");
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
		document.getElementById("services").value = varservicesName;
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