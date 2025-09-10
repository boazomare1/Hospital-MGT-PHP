// JavaScript Document

//function to call ajax process

function funcCustomerSmartSearch()

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

			ajaxprocessACCS20();		

		}

		//alert("Meow...");

		//ajaxprocessACCS2();		

		//var url = "";

	}

}


function funcCustomerSmartSearch_new()
{
	//alert("Meow...");
	if(document.getElementById("patientcode").value!="")
	{
		var varCustomerSearch = document.getElementById("patientcode").value;
		var visitcode = document.getElementById("visitcode").value;

		
		//alert (varCustomerSearch);
		var varCustomerSearchLen = varCustomerSearch.length;
		//alert (varCustomerSearchLen);
		if (varCustomerSearchLen > 1)
		{
			xmlHttp=GetXmlHttpObject()
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request")
				return false;
			} 
		  
			var customersearch=document.getElementById("patientcode").value;
			//alert(customersearch);
			var registrationdate=document.getElementById("registrationdate").value;
			//alert(location);
			var url = "";
			
			var url="autocustomersmartsearch_admit.php?InOut_Type=1&&RandomKey="+Math.random()+"&&customersearch="+customersearch+"&&registrationdate="+registrationdate+"&visitcode="+visitcode;
		   //alert(url);

			xmlHttp.onreadystatechange=stateChangedACCS20 
			xmlHttp.open("GET",url,true)
			xmlHttp.send(null)
		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}



var xmlHttp



function ajaxprocessACCS20()

{

	xmlHttp=GetXmlHttpObject()

	if (xmlHttp==null)

	{

		alert ("Browser does not support HTTP Request")

		return false;

	} 

  
  var visitcode = document.getElementById("visitcode").value;

  	var customersearch=document.getElementById("patientcode").value;

	//alert(customersearch);

	var registrationdate=document.getElementById("registrationdate").value;

	//alert(location);

	var url = "";

	

	var url="autocustomersmartsearch.php?InOut_Type=1&&RandomKey="+Math.random()+"&&customersearch="+customersearch+"&&registrationdate="+registrationdate+"&visitcode="+visitcode;

   //alert(url);



	xmlHttp.onreadystatechange=stateChangedACCS20 

	xmlHttp.open("GET",url,true)

	xmlHttp.send(null)

} 



function stateChangedACCS20() 

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

	

	if(t!='')

	{

	//document.getElementById("price").innerHTML=t;

	var varCompleteStringReturned=t;

	//alert (varCompleteStringReturned);

	var varNewLineValue=varCompleteStringReturned.split("#");

	//alert(varNewLineValue);

	//alert(varNewLineValue.length);

	var varNewLineLength = varNewLineValue.length;

	//alert(varNewLineLength);

	

	var Benefitno = varNewLineValue[0];

	var BenefitAmt = varNewLineValue[1];

	var Admitid = varNewLineValue[2];

	var availablelimit = document.getElementById("availablelimit").value;

	//if(availablelimit == 0){

	document.getElementById("availablelimit").value = BenefitAmt;

	document.getElementById("smartbenefitno").value = Benefitno;

	document.getElementById("admitid").value = Admitid;

	var totalfxamount = document.getElementById("totalfxamount").value;
	totalfxamount = parseFloat(totalfxamount || 0);
    BenefitAmt = parseFloat(BenefitAmt || 0);
	availablelimit = parseFloat(availablelimit || 0);
		
	//}

	if(Admitid==0)
	{
      alert("Error Smart Fetch , Please try again later");
      document.getElementById("smartfrm").disabled = true;
	}
	else{
	   alert("Smart Fetch Successfull");

	   if(document.getElementById("smartfrm") != null)
		{
			var net_amount = document.getElementById("totalamount").value;
			var iscapitation_f = document.getElementById("iscapitation_f").value;
			if(iscapitation_f==1)
			{
			var net_amount = document.getElementById("totalamount").value;    
			}
			if((net_amount<=0)&&(iscapitation_f==1))
			{
			document.getElementById("smartfrm").disabled = true;
			}else
			{
			document.getElementById("smartfrm").disabled = false;	
			}
		}
		//alert(BenefitAmt);
		//alert(availablelimit);
		if(BenefitAmt>availablelimit){
          location.reload();
		}
	
	}
	
	return true; // by Kenique 29Aug2018

	}

	

	

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

