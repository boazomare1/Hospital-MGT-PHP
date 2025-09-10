// JavaScript Document



//Function call from billnumber onBlur and Save button click.

//function to call ajax process

function funcbatchselection(serial)

{

	var serial = serial;

	//alert ("Calling Bill Number Validation");

	var batch = document.getElementById("batch"+serial+"").value;

	

	

	//alert(serial);

	

	

	if(document.getElementById("batch"+serial+"").value != "")

	{

		//alert("Meow...");

		ajaxprocess2(serial);		

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



function ajaxprocess2(serial1)

{



xmlHttp=GetXmlHttpObject2()

if (xmlHttp==null)

  {

  alert ("Browser does not support HTTP Request")

  return

  } 

  	var serial1 = serial1;

  	var varbatch = document.getElementById("batch"+serial1+"").value;

	//alert(varbatch);

	var itemcode = document.getElementById("itemcode"+serial1+"").value;

	var fromstore = document.getElementById("fromstore").value;

	

	var locationcode = document.getElementById("locationcode").value;

	var storecode = document.getElementById("fromstore").value;



	//alert(varbatch);

	//var hairsize=document.form1.hairsize.value;

	//var type=document.form1.type.value;

	var url = "";

	var url="validation1batch1stocktransfer.php?RandomKey="+Math.random()+"&&batch="+varbatch+"&&itemcode="+itemcode+"&&serial1="+serial1+"&&tostore22="+storecode+"&&locationcode="+locationcode;

  	//alert (url);

  



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

	var batchdata = t;

	

	var arrbatchdata=batchdata.split('||');

	var expirydate = arrbatchdata[0];

	var stock = arrbatchdata[1];

	var costprice = arrbatchdata[2];

	var serialnumber = arrbatchdata[3];

	//alert(stock);

	document.getElementById("expirydate"+serialnumber+"").value = expirydate;

	

	document.getElementById("availablestock"+serialnumber+"").value = stock;

	
	document.getElementById("costprice"+serialnumber+"").value = costprice;
	document.getElementById("cost"+serialnumber+"").value = costprice;

	var transferqty = $.trim($('#transferqty'+serialnumber).val());
	if(transferqty!='' && transferqty >=0 )
	{
		amountcalc(serialnumber);
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



