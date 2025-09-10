// JavaScript Document
//function to call ajax process
function EmployeeLoanmonthwise()
{
	//alert("Meow...");
	
		for(var j = document.getElementById("tblrowinsert2").rows.length; j > 0;j--)
		{
			document.getElementById("tblrowinsert2").deleteRow(j -1);
		}
	
	
	var Empcode;
	var Empcode = document.getElementById("searchemployeecode").value;
	//alert(Empcode);
	if(Empcode!="")
	{
		
		var varEmployeesearchLen = Empcode.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
		{
			ajaxprocessACCS22(Empcode);		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS22(Empcode)
{
	xmlHttp=GetXmlHttpObject1()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmpcode = Empcode;
	var Assignmonth = document.getElementById("assignmonth").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeeloandetails1.php?RandomKey="+Math.random()+"&&employeesearch="+varEmpcode+"&&assignmonth="+Assignmonth+"";
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS22 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS22() 
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
		var varEmployeecode = varNewRecordValue[0];
		//alert (varCustomerName1);
		var varLoanname = varNewRecordValue[1];
		var varLoanamount = varNewRecordValue[2];
		var varLoanremain = varNewRecordValue[3];
		var varInterest = varNewRecordValue[4];
		var varInstallments = varNewRecordValue[5];
		var varInterestapplicable = varNewRecordValue[6];
		var varFringeBenefit = varNewRecordValue[7];
		var varMonthamount = varNewRecordValue[8];
		var varMonthinterest = varNewRecordValue[9];
		var varMonthpay = varNewRecordValue[10];
		var varFringerate = varNewRecordValue[11];
		var varHoldstatus = varNewRecordValue[12];
		if(varHoldstatus == 'Yes')
		{
			var varMonthpay = varMonthinterest;	
		}
		else
		{
			var varMonthpay = varMonthpay;
		}
		
		var m = parseInt(m);
		var k = m + 1;
		var k = parseInt(k);
		//alert (k);
		//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
		var tr = document.createElement ('TR');
		tr.id = "idTRL"+k+"";
		tr.value = k;
		//tr.onclick = function() { TrSelect(this.value); }
		//tr.onmouseover = function() { TrBgcolor(this.value); }
		//tr.onmouseout = function() { TRremovecolor(this.value); }
		//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td1 = document.createElement ('td');
		td1.id = "idTDL1"+k+"";
		td1.align = "left";
		td1.valign = "top";
		td1.style.backgroundColor = "#FFFFFF";
		td1.style.border = "0px solid #F3F3F3";
		//var text1 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text1 = document.createElement ('input');
		text1.id = "serialnumberloan"+k+"";
		text1.name = "serialnumberloan"+k+"";
		text1.type = "hidden";
		text1.size = "1";
		text1.value = k;
		text1.readOnly = "readonly";
		text1.style.backgroundColor = "#FFFFFF";
		text1.style.border = "0px solid #001E6A";
		text1.style.textAlign = "center";
		text1.style.fontSize = "12";
		
		td1.appendChild (text1);
		tr.appendChild (td1);
		
		var td2 = document.createElement ('td');
		td2.id = "idTDL2"+k+"";
		td2.align = "left";
		td2.valign = "top";
		td2.style.backgroundColor = "#FFFFFF";
		td2.style.border = "0px solid #F3F3F3";
		//var text2 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text2 = document.createElement ('input');
		text2.id = "loanname"+k+"";
		text2.name = "loanname"+k+"";
		text2.type = "text";
		text2.size = "15";
		text2.value = varLoanname;
		text2.readOnly = "readonly";
		text2.style.backgroundColor = "#FFFFFF";
		text2.style.border = "0px solid #001E6A";
		text2.style.textAlign = "left";
		text2.style.fontSize = "12";
		td2.appendChild (text2);
		tr.appendChild (td2);
		
		
		var td3 = document.createElement ('td');
		td3.id = "idTDL3"+k+"";
		td3.align = "left";
		td3.valign = "top";
		td3.style.backgroundColor = "#FFFFFF";
		td3.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text3 = document.createElement ('input');
		text3.id = "loanamount"+k+"";
		text3.name = "loanamount"+k+"";
		text3.type = "text";
		text3.size = "5";
		text3.value = varLoanamount;
		text3.readOnly = "readonly";
		text3.style.backgroundColor = "#FFFFFF";
		text3.style.border = "0px solid #001E6A";
		text3.style.textAlign = "left";
		text3.style.fontSize = "12";
		td3.appendChild (text3);
		tr.appendChild (td3);
		
		
		var td4 = document.createElement ('td');
		td4.id = "idTDL4"+k+"";
		td4.align = "left";
		td4.valign = "top";
		td4.style.backgroundColor = "#FFFFFF";
		td4.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text4 = document.createElement ('input');
		text4.id = "loanremain"+k+"";
		text4.name = "loanremain"+k+"";
		text4.type = "text";
		text4.size = "5";
		text4.value = varLoanremain;
		text4.readOnly = "readonly";
		text4.style.backgroundColor = "#FFFFFF";
		text4.style.border = "0px solid #001E6A";
		text4.style.textAlign = "left";
		text4.style.fontSize = "12";
		td4.appendChild (text4);
		tr.appendChild (td4);
		
		
		var td5 = document.createElement ('td');
		td5.id = "idTDL5"+k+"";
		td5.align = "left";
		td5.valign = "top";
		td5.style.backgroundColor = "#FFFFFF";
		td5.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text5 = document.createElement ('input');
		text5.id = "interest"+k+"";
		text5.name = "interest"+k+"";
		text5.type = "text";
		text5.size = "1";
		text5.value = varInterest;
		text5.readOnly = "readonly";
		text5.style.backgroundColor = "#FFFFFF";
		text5.style.border = "0px solid #001E6A";
		text5.style.textAlign = "left";
		text5.style.fontSize = "12";
		td5.appendChild (text5);
		tr.appendChild (td5);
		
		var td6 = document.createElement ('td');
		td6.id = "idTDL6"+k+"";
		td6.align = "left";
		td6.valign = "top";
		td6.style.backgroundColor = "#FFFFFF";
		td6.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text6 = document.createElement ('input');
		text6.id = "installments"+k+"";
		text6.name = "installments"+k+"";
		text6.type = "text";
		text6.size = "1";
		text6.value = varInstallments;
		text6.readOnly = "readonly";
		text6.style.backgroundColor = "#FFFFFF";
		text6.style.border = "0px solid #001E6A";
		text6.style.textAlign = "left";
		text6.style.fontSize = "12";
		td6.appendChild (text6);
		tr.appendChild (td6);
		
		var td7 = document.createElement ('td');
		td7.id = "idTDL7"+k+"";
		td7.align = "left";
		td7.valign = "top";
		td7.style.backgroundColor = "#FFFFFF";
		td7.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text7 = document.createElement ('input');
		text7.id = "interestapplicable"+k+"";
		text7.name = "interestapplicable"+k+"";
		text7.type = "text";
		text7.size = "2";
		text7.value = varInterestapplicable;
		text7.readOnly = "readonly";
		text7.style.backgroundColor = "#FFFFFF";
		text7.style.border = "0px solid #001E6A";
		text7.style.textAlign = "left";
		text7.style.fontSize = "12";
		td7.appendChild (text7);
		tr.appendChild (td7);
		
		
		var td8 = document.createElement ('td');
		td8.id = "idTDL8"+k+"";
		td8.align = "left";
		td8.valign = "top";
		td8.style.backgroundColor = "#FFFFFF";
		td8.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
		var text8 = document.createElement ('input');
		text8.id = "fringebenefit"+k+"";
		text8.name = "fringebenefit"+k+"";
		text8.type = "text";
		text8.size = "1";
		text8.value = varFringeBenefit;
		text8.readOnly = "readonly";
		text8.style.backgroundColor = "#FFFFFF";
		text8.style.border = "0px solid #001E6A";
		text8.style.textAlign = "left";
		text8.style.fontSize = "12";
		td8.appendChild (text8);
		tr.appendChild (td8);
		
		var td9 = document.createElement ('td');
		td9.id = "idTDL9"+k+"";
		td9.align = "left";
		td9.valign = "top";
		td9.style.backgroundColor = "#FFFFFF";
		td9.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:9pt" size="3">');
		var text9 = document.createElement ('input');
		text9.id = "monthamount"+k+"";
		text9.name = "monthamount"+k+"";
		text9.type = "text";
		text9.size = "5";
		text9.value = varMonthamount;
		text9.readOnly = "readonly";
		text9.style.backgroundColor = "#FFFFFF";
		text9.style.border = "0px solid #001E6A";
		text9.style.textAlign = "left";
		text9.style.fontSize = "12";
		td9.appendChild (text9);
		tr.appendChild (td9);
		
		var td10 = document.createElement ('td');
		td10.id = "idTDL10"+k+"";
		td10.align = "left";
		td10.valign = "top";
		td10.style.backgroundColor = "#FFFFFF";
		td10.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:10pt" size="3">');
		var text10 = document.createElement ('input');
		text10.id = "monthinterest"+k+"";
		text10.name = "monthinterest"+k+"";
		text10.type = "text";
		text10.size = "5";
		text10.value = varMonthinterest;
		text10.readOnly = "readonly";
		text10.style.backgroundColor = "#FFFFFF";
		text10.style.border = "0px solid #001E6A";
		text10.style.textAlign = "left";
		text10.style.fontSize = "12";
		td10.appendChild (text10);
		tr.appendChild (td10);
		
		/*var td11 = document.createElement ('td');
		td11.id = "idTDL11"+k+"";
		td11.align = "left";
		td11.valign = "top";
		td11.style.backgroundColor = "#FFFFFF";
		td11.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:10pt" size="3">');
		var text11 = document.createElement ('input');
		text11.id = "monthinterest"+k+"";
		text11.name = "monthinterest"+k+"";
		text11.type = "text";
		text11.size = "5";
		text11.value = varMonthinterest;
		text11.readOnly = "readonly";
		text11.style.backgroundColor = "#FFFFFF";
		text11.style.border = "0px solid #001E6A";
		text11.style.textAlign = "left";
		text11.style.fontSize = "12";
		td11.appendChild (text11);
		tr.appendChild (td11);
		*/
		
		var td12 = document.createElement ('td');
		td12.id = "idTDL12"+k+"";
		td12.align = "left";
		td12.valign = "top";
		td12.style.backgroundColor = "#FFFFFF";
		td12.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:10pt" size="3">');
		var text12 = document.createElement ('input');
		text12.id = "monthpay"+k+"";
		text12.name = "monthpay"+k+"";
		text12.type = "text";
		text12.size = "5";
		text12.value = varMonthpay;
		text12.readOnly = "readonly";
		text12.style.backgroundColor = "#FFFFFF";
		text12.style.border = "0px solid #001E6A";
		text12.style.textAlign = "left";
		text12.style.fontSize = "12";
		td12.appendChild (text12);
		tr.appendChild (td12);
		
		var td13 = document.createElement ('td');
		td13.id = "idTDL13"+k+"";
		td13.align = "left";
		td13.valign = "top";
		td13.style.backgroundColor = "#FFFFFF";
		td13.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:10pt" size="3">');
		var text13 = document.createElement ('input');
		text13.id = "fringerate"+k+"";
		text13.name = "fringerate"+k+"";
		text13.type = "text";
		text13.size = "5";
		text13.value = varFringerate;
		text13.readOnly = "readonly";
		text13.style.backgroundColor = "#FFFFFF";
		text13.style.border = "0px solid #001E6A";
		text13.style.textAlign = "left";
		text13.style.fontSize = "12";
		td13.appendChild (text13);
		tr.appendChild (td13);
		
		var td14 = document.createElement ('td');
		td14.id = "idTDL14"+k+"";
		td14.align = "left";
		td14.valign = "top";
		td14.style.backgroundColor = "#FFFFFF";
		td14.style.border = "0px solid #F3F3F3";
		//var text3 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:10pt" size="3">');
		var text14 = document.createElement ('input');
		text14.id = "hold"+k+"";
		text14.name = "hold"+k+"";
		text14.type = "checkbox";
		text14.size = "1";
		text14.value = k;
		if(varHoldstatus == 'Yes')
		{
			text14.checked = "checked";	
		}
		else
		{
			text14.checked = "";	
		}
		//text14.readOnly = "readonly";
		text14.style.backgroundColor = "#FFFFFF";
		text14.style.border = "0px solid #001E6A";
		text14.style.textAlign = "left";
		text14.style.fontSize = "12";
		text14.onchange = function() { return LoanHold(this.value); }
		td14.appendChild (text14);
		tr.appendChild (td14);
		
		document.getElementById ('tblrowinsert2').appendChild (tr);
		
		
	}
	
	}
	//alert (k);
	} 
}

function GetXmlHttpObject1()
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

function monthwiseCalc(id)
{
	var id = id;
	var k = id.substr(4,10);
	//alert(k);
	if(document.getElementById("unit"+k).value != "")
	{
		if(!isNaN(document.getElementById("unit"+k).value))
		{
			var Rate = document.getElementById("rate"+k).value;
			var Unit = document.getElementById("unit"+k).value;
			var Amount = parseFloat(Rate) * parseFloat(Unit);
			document.getElementById("amount"+k).value = Amount.toFixed(2);
		}
		else
		{
			alert("Please Enter Numbers");	
			document.getElementById("unit"+k).value = "";
			document.getElementById("amount"+k).value = "0.00";
			return false;			
		}
	}
	else
	{
		document.getElementById("amount"+k).value = "0.00";
	}
}