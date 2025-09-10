// JavaScript Document

//function to call ajax process

function funcCustomerSearch2()

{

	//alert("Meow...");

	if(document.getElementById("patientcode").value!="")

	{

		var varCustomerSearch = document.getElementById("patientcode").value;

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

  

  	var customersearch=document.getElementById("patientcode").value;

	var visitId=document.getElementById("visitcode").value;

	var arrayId = visitId.split("-");

	//alert(arrayId[2]);

	

	

	//alert(customersearch);

	var url = "";

	var url="autocustomercodesearch2.php?RandomKey="+Math.random()+"&&customersearch="+customersearch+"&&id="+arrayId[2];

   // alert(url);



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

	var varNewLineValue=varCompleteStringReturned.split("#^#");

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

		var varNewRecordValue=varNewLineValue[m].split("#");

		//alert(varNewRecordValue);

		

		//alert (varCustomerCode1);

		var varCustomercode1 = varNewRecordValue[0];

		//alert (varCustomerName1);

		var VarCustomername1 = varNewRecordValue[1];

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

		

		var varRes4PaymentType = varNewRecordValue[13];

		

		//alert(varRes4PaymentType);

		

		var varRes4SubType = varNewRecordValue[14];

		

		var varRes4AccountName = varNewRecordValue[15];

		

		var varRes4PlanName = varNewRecordValue[16];

				

		var varVisitCount = varNewRecordValue[17];

		

		var varRes4PlanFixedAmount = varNewRecordValue[18];

		

		var varRes4patientspent=  varNewRecordValue[19];

				

		var varRes4PlanPercentage = varNewRecordValue[20];

		

		var VarRes4AvailableLimit = varNewRecordValue[21];

		

		var VarRes4Age = varNewRecordValue[22];

		

		var VarRes4Gender = varNewRecordValue[23];

		

		var VarRes4Recordstatus = varNewRecordValue[24];

		

		

		var varRes4Mrdno = varNewRecordValue[25];

		

		var varadmissionfees = varNewRecordValue[26];

		

		var varRes4Planstatus = varNewRecordValue[27];

		//alert(varadmissionfees);

		var varphoto = varNewRecordValue[28];

		var inactivestatus = varNewRecordValue[29];

		var memberno = varNewRecordValue[30];

		var varRes4Smartap = varNewRecordValue[31];

		var plandue = varNewRecordValue[32];
		var scheme_id = varNewRecordValue[33];
       var excluded_status = varNewRecordValue[34];
		

		document.getElementById("customercode").value = "";

		document.getElementById("customer").value = "";

		document.getElementById("customer").value = VarCustomername1;

		document.getElementById("patientfirstname").value = VarCustomername1;

		document.getElementById("patientmiddlename").value = VarMiddlename1;

		document.getElementById("patientlastname").value = VarlastName1;

		document.getElementById("patientcode").value = varCustomercode1;

		//document.getElementById("img").src = "patientphoto/"+varCustomercode1+".jpg";

		document.getElementById("admissionfees").value = varadmissionfees;

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

		document.getElementById("patientspent").value=varRes4patientspent;

		document.getElementById("planpercentageamount").value = varRes4PlanPercentage;

		

		if(varCustomerVisitLimit>0){document.getElementById("availablelimit").value = parseFloat(varCustomerVisitLimit).toFixed(2);}

		else{document.getElementById("availablelimit").value = parseFloat(VarRes4AvailableLimit).toFixed(2);}

		

		

		//document.getElementById("availablelimit").value = VarRes4AvailableLimit;

		document.getElementById("age").value = VarRes4Age;

		document.getElementById("gender").value = VarRes4Gender;

		document.getElementById("recordstatus").value = VarRes4Recordstatus;

		//document.getElementById("mrdno").value = varRes4Mrdno;

		document.getElementById("admissionfees").value = varadmissionfees;

		document.getElementById("planstatus").value = varRes4Planstatus;

		

		document.getElementById("photoavailable").value = varphoto;

		 document.getElementById("plandue").value = plandue;
		 document.getElementById("scheme_id").value = scheme_id;

		if(varRes4Smartap >0 ){

			if(varCustomerVisitLimit>0){document.getElementById("availablelimit").value = 0;}
		else{document.getElementById("availablelimit").value = 0;}			

		document.getElementById("fetch").disabled = false;
        document.getElementById("submit").disabled = true;
		document.getElementById("fetchbtn").style.display = "";

			if(varRes4Smartap==1){
				 document.getElementById("fetch").value = "Smart";
				 document.getElementById("fetch").onclick = function() { funcCustomerSmartSearch(); };

			}
			else if(varRes4Smartap==2){
				 document.getElementById("fetch").value = "Slade";
				 document.getElementById("fetch").onclick = function() { funfetchsavannah(2); };

			}
			 else if(varRes4Smartap==3){
				 document.getElementById("fetch").value = "Smart+Slade";
				 document.getElementById("fetch").onclick = function() { funfetchsavannah(3); };

			 }

		}else{

			if(varCustomerVisitLimit>0){document.getElementById("availablelimit").value = parseFloat(varCustomerVisitLimit).toFixed(2);}
		else{document.getElementById("availablelimit").value = parseFloat(VarRes4AvailableLimit).toFixed(2);}


		document.getElementById("fetch").disabled = true;
        document.getElementById("submit").disabled = false;
		document.getElementById("fetchbtn").style.display = "none";

		}

//		var x=document.getElementById("consultationtype");

//		alert(x);

//		var option=document.createElement("option");

//		option.text= varRes4Paymenttype ;

//		option.value= varRes4Paymentanum;

//		try

//		  {

//		  // for IE earlier than version 8

//		  x.add(option,x.options[null]);

//		  }

//		catch (e)

//		  {

//		  x.add(option,null);

//		  }		

//		  document.getElementById("consultationtype").focus();
        excluded_status = excluded_status.trim();
		if(excluded_status!='')
		{
		alert(varRes4SubType+" is not applicable for this Location");
		document.getElementById("submit").disabled = true;
		return false;	
		}

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