// JavaScript Document
//function to call ajax process
function funcmedicinesearch4()
{
	//alert("Meow...");
	if(document.getElementById("medicinecode").value!="")
	{
		var varmedicinesearch = document.getElementById("medicinecode").value;
		//alert (varmedicinesearch);
		var varmedicinesearchLen = varmedicinesearch.length;
		//alert (varmedicinesearchLen);
		if (varmedicinesearchLen > 1)
		{
			ajaxprocessACCS24();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS24()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var medicinesearch = document.getElementById("medicinecode").value;
	//alert(medicinesearch);
	var location = document.getElementById("locationcode").value;
	var store = document.getElementById("storecode").value;
	var accountname = document.getElementById("subtypeano").value;
	var tostore = document.getElementById("tostore").value;
	
	//alert(medicinesearch);
	var url = "";
	var url="automedicinecodesearchipmedicineissue.php?RandomKey="+Math.random()+"&&medicinesearch="+medicinesearch+"&&locationcode="+location+"&&storecode="+store+"&&tostore="+tostore+"&&accountname="+accountname;

    // alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS24 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS24() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("customername").innerHTML="";
	//document.getElementById("medicinesearch").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
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
		//alert(varNewLineValue[7]);
		//alert ('h');
		if(varNewLineValue[7]>0)
		{
			var varMedicineRate = varNewLineValue[2];
		if(parseInt(varMedicineRate) > 0){
		var varMedicineCode = varNewLineValue[0];
		//alert (varMedicineCode);
		document.getElementById("medicinecode").value = varMedicineCode;

		var varMedicineName = varNewLineValue[1];
		// alert (varMedicineName);
		// alert();
		document.getElementById("medicinename").value = varMedicineName;
		document.getElementById("medicine_rate").value = varMedicineRate;
		// document.getElementById("medicinename123").value = varMedicineName;

		
		var varstock = varNewLineValue[7];
		 //alert (varstock);
		document.getElementById("toavlquantity").value = varstock;

		///////// dose measure //////////////
		if(varNewLineValue[9] > 0)
		{ 
			 var options = document.getElementsByClassName("dose_measure")[0].options,
				name =varNewLineValue[10];
				for(i = 0; i < options.length; i++){
				if(options[i].text.indexOf(name) > -1){
				options[i].selected = true;
				break;
				}
				}
		}else{
			document.getElementById("dosemeasure").value = '';
		}
		///////// dose measure //////////////
		
	    var varFormula = varNewLineValue[3];
		//alert (varFormula);
		document.getElementById("formula").value = varFormula;
		
		//alert(varMedicinefrequency);
	    var varStrength = varNewLineValue[4];
		//alert(varStrength);
		document.getElementById("strength").value = varStrength;
		
		var vargenericname1 = varNewLineValue[5];
		
		//alert(vargenericname1);
		
		//document.getElementById("genericname").value = vargenericname1;
		
		
		/*var varpkg = varNewLineValue[6];
		
		document.getElementById("pkg").value = varpkg;
		
	if(varpkg=='on')
		{
			var x = document.getElementById("pharmfree");
			x.remove(x[0]);
			var option = document.createElement("option");
			option.text = "Yes";
			option.value=1;
			option.selected="selected";
			x.add(option, x[0]);
			var option2 = document.createElement("option");
			option2.text = "No";
			option2.value=0;
			x.add(option2, x[1]);
			
			
			
			}
			else
		{
			var x = document.getElementById("pharmfree");
			x.remove(x[0]);x.remove(x[1]);
			var option = document.createElement("option");
			option.text = "No";
			option.value=0;
			option.selected="selected";
			x.add(option, x[0]);
			
			}
		//alert(varMedicinefrequency)*/
		
		
/*		var drugallergy = document.getElementById("drugallergy").value;
		
		vargenericname1 = vargenericname1.toUpperCase();
		
		if(drugallergy == vargenericname1)
		{
			var check=confirm('Patient is Allergic to this drug, Do you like to Proceed?');
			//alert(check);
			if(check == false)
			{
				document.getElementById("medicinename").value ='';
				document.getElementById("rate").value = '';
				
			}
			
		}*/
		
		document.getElementById("medicinename").focus();
		
		funcmedicinebatch();
		var delayMillis = 300; //1 second

setTimeout(function() {
		document.getElementById("medicinebatch").onchange();
		document.getElementById("medicinename").value = varMedicineName;			
  //your code to be executed after 1 second
}, delayMillis);
		
		}
		else{
			alert('Medicine Is Not available for billing');
			document.getElementById("medicinecode").value = '';
			document.getElementById("medicine_rate").value='';
			document.getElementById("medicinename").value = '';
			document.getElementById('medicinebatch').options.length=null; 
			var newOption = document.createElement('option');
			newOption.text = "Batch";
			newOption.value = "";
			newOption.selected = "selected";
			document.getElementById("medicinebatch").options.add(newOption, null);
			return false;
			
		}
		}
		else
		{
			alert('Medicine Is Out of stock or Expired Medicine Available');
			document.getElementById("medicinecode").value = '';
			document.getElementById("medicine_rate").value='';
			document.getElementById("medicinename").value = '';
			document.getElementById('medicinebatch').options.length=null; 
			var newOption = document.createElement('option');
			newOption.text = "Batch";
			newOption.value = "";
			newOption.selected = "selected";
			document.getElementById("medicinebatch").options.add(newOption, null);
			return false;
		}
		//alert('h');
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

		document.getElementById("medicinename").value = varMedicineName;
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