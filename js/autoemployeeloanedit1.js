// JavaScript Document
//function to call ajax process
function FuncLoanEdit()
{
	//alert("Meow...");
	for(var j = document.getElementById("loanrowinsert").rows.length; j > 0;j--)
	{
		document.getElementById("loanrowinsert").deleteRow(j -1);
	}
	
	if(document.getElementById("searchemployeecode").value!="")
	{
		var varEmployeesearch = document.getElementById("searchemployeecode").value;
		//alert (varCustomerSearch);
		var varEmployeesearchLen = varEmployeesearch.length;
		//alert (varCustomerSearchLen);
		if (varEmployeesearchLen > 1)
		{
			ajaxprocessACCS23();		
		}
		//alert("Meow...");
		//ajaxprocessACCS2();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocessACCS23()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var varEmployeesearch = document.getElementById("searchemployeecode").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeeloanedit1.php?RandomKey="+Math.random()+"&&employeesearch="+varEmployeesearch;
   	//alert(url);

	xmlHttp.onreadystatechange=stateChangedACCS23 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChangedACCS23() 
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
	
	if(t != '')
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
		
		var varSerialNumber = document.getElementById("serialnumber").value;
		var varLoanname = varNewRecordValue[1];
		var varInstallments = varNewRecordValue[2];
		var varInterestapplicable = varNewRecordValue[3];
		var varInterest = varNewRecordValue[4];
		var varFringebenefit = varNewRecordValue[5];
		var varAmount = varNewRecordValue[6];
		//alert(varAmount);
		//var varAmount = parseFloat(varAmount);
		//var varAmount = varAmount.toFixed(2);
		var varInstallmentamount = '';
		var varMonthinterest = '';
		var varMonthamount = '';
		var varFringerate = '';
		//var varInstallmentamount = varNewRecordValue[9];
		//var varMonthinterest = varNewRecordValue[7];
		//var varMonthamount = varNewRecordValue[8];
		//var varFringerate = varNewRecordValue[10];
		
		var i = varSerialNumber;
	
		//var tr = document.createElement ('<TR id="idTR'+i+'"></TR>');
		var tr = document.createElement ('TR');
		tr.id = "idTR"+i+"";
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td1 = document.createElement ('td');
		td1.id = "idTD1"+i+"";
		td1.align = "left";
		td1.valign = "top";
		td1.style.backgroundColor = "#FFFFFF";
		td1.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text1 = document.createElement ('input');
		text1.id = "serialnumber"+i+"";
		text1.name = "serialnumber"+i+"";
		text1.type = "text";
		text1.size = "1";
		text1.value = i;
		text1.readOnly = "readonly";
		text1.style.backgroundColor = "#FFFFFF";
		text1.style.border = "0px solid #001E6A";
		text1.style.textAlign = "left";
		td1.appendChild (text1);
		tr.appendChild (td1);
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td2 = document.createElement ('td');
		td2.id = "idTD2"+i+"";
		td2.align = "left";
		td2.valign = "top";
		td2.style.backgroundColor = "#FFFFFF";
		td2.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text2 = document.createElement ('input');
		text2.id = "loanname"+i+"";
		text2.name = "loanname"+i+"";
		text2.type = "text";
		text2.size = "25";
		text2.value = varLoanname;
		text2.readOnly = "readonly";
		text2.style.backgroundColor = "#FFFFFF";
		text2.style.border = "0px solid #001E6A";
		text2.style.textAlign = "left";
		td2.appendChild (text2);
		tr.appendChild (td2);
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td3 = document.createElement ('td');
		td3.id = "idTD3"+i+"";
		td3.align = "left";
		td3.valign = "top";
		td3.style.backgroundColor = "#FFFFFF";
		td3.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text3 = document.createElement ('input');
		text3.id = "installments"+i+"";
		text3.name = "installments"+i+"";
		text3.type = "text";
		text3.size = "5";
		text3.value = varInstallments;
		text3.readOnly = "readonly";
		text3.style.backgroundColor = "#FFFFFF";
		text3.style.border = "0px solid #001E6A";
		text3.style.textAlign = "left";
		td3.appendChild (text3);
		tr.appendChild (td3);
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td4 = document.createElement ('td');
		td4.id = "idTD4"+i+"";
		td4.align = "center";
		td4.valign = "top";
		td4.style.backgroundColor = "#FFFFFF";
		td4.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text4 = document.createElement ('input');
		text4.id = "interestapplicable"+i+"";
		text4.name = "interestapplicable"+i+"";
		text4.type = "text";
		text4.size = "5";
		text4.value = varInterestapplicable;
		text4.readOnly = "readonly";
		text4.style.backgroundColor = "#FFFFFF";
		text4.style.border = "0px solid #001E6A";
		text4.style.textAlign = "left";
		td4.appendChild (text4);
		tr.appendChild (td4);
		
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td5 = document.createElement ('td');
		td5.id = "idTD5"+i+"";
		td5.align = "center";
		td5.valign = "top";
		td5.style.backgroundColor = "#FFFFFF";
		td5.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text5 = document.createElement ('input');
		text5.id = "interest"+i+"";
		text5.name = "interest"+i+"";
		text5.type = "text";
		text5.size = "5";
		text5.value = varInterest;
		text5.readOnly = "readonly";
		text5.style.backgroundColor = "#FFFFFF";
		text5.style.border = "0px solid #001E6A";
		text5.style.textAlign = "left";
		td5.appendChild (text5);
		tr.appendChild (td5);
		
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td8 = document.createElement ('td');
		td8.id = "idTD8"+i+"";
		td8.align = "center";
		td8.valign = "top";
		td8.style.backgroundColor = "#FFFFFF";
		td8.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text8 = document.createElement ('input');
		text8.id = "fringebenefit"+i+"";
		text8.name = "fringebenefit"+i+"";
		text8.type = "text";
		text8.size = "5";
		text8.value = varFringebenefit;
		text8.readOnly = "readonly";
		text8.style.backgroundColor = "#FFFFFF";
		text8.style.border = "0px solid #001E6A";
		text8.style.textAlign = "left";
		td8.appendChild (text8);
		tr.appendChild (td8);
		
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td6 = document.createElement ('td');
		td6.id = "idTD6"+i+"";
		td6.align = "center";
		td6.valign = "top";
		td6.style.backgroundColor = "#FFFFFF";
		td6.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text6 = document.createElement ('input');
		text6.id = "amount"+i+"";
		text6.name = "amount"+i+"";
		text6.type = "text";
		text6.size = "10";
		text6.value = varAmount;
		//text6.readOnly = "readonly";
		text6.style.backgroundColor = "#FFFFFF";
		text6.style.border = "1px solid #001E6A";
		text6.style.textAlign = "left";
		td6.appendChild (text6);
		tr.appendChild (td6);
		
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td9 = document.createElement ('td');
		td9.id = "idTD9"+i+"";
		td9.align = "center";
		td9.valign = "top";
		td9.style.backgroundColor = "#FFFFFF";
		td9.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text9 = document.createElement ('input');
		text9.id = "monthinterest"+i+"";
		text9.name = "monthinterest"+i+"";
		text9.type = "text";
		text9.size = "5";
		text9.value = varMonthinterest;
		text9.readOnly = "readonly";
		text9.style.backgroundColor = "#FFFFFF";
		text9.style.border = "0px solid #001E6A";
		text9.style.textAlign = "right";
		td9.appendChild (text9);
		tr.appendChild (td9);
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td10 = document.createElement ('td');
		td10.id = "idTD10"+i+"";
		td10.align = "center";
		td10.valign = "top";
		td10.style.backgroundColor = "#FFFFFF";
		td10.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
		var text10 = document.createElement ('input');
		text10.id = "monthamount"+i+"";
		text10.name = "monthamount"+i+"";
		text10.type = "text";
		text10.size = "5";
		text10.value = varMonthamount;
		text10.readOnly = "readonly";
		text10.style.backgroundColor = "#FFFFFF";
		text10.style.border = "0px solid #001E6A";
		text10.style.textAlign = "right";
		td10.appendChild (text10);
		tr.appendChild (td10);
		
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td7 = document.createElement ('td');
		td7.id = "idTD7"+i+"";
		td7.align = "center";
		td7.valign = "top";
		td7.style.backgroundColor = "#FFFFFF";
		td7.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E7A; text-align:left" size="1" />');
		var text7 = document.createElement ('input');
		text7.id = "installmentamount"+i+"";
		text7.name = "installmentamount"+i+"";
		text7.type = "text";
		text7.size = "10";
		text7.value = varInstallmentamount;
		text7.readOnly = "readonly";
		text7.style.backgroundColor = "#FFFFFF";
		text7.style.border = "0px solid #001E6A";
		text7.style.textAlign = "right";
		td7.appendChild (text7);
		tr.appendChild (td7);
		
		//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td12 = document.createElement ('td');
		td12.id = "idTD12"+i+"";
		td12.align = "center";
		td12.valign = "top";
		td12.style.backgroundColor = "#FFFFFF";
		td12.style.border = "0px solid #001E6A";
		//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E7A; text-align:left" size="1" />');
		var text12 = document.createElement ('input');
		text12.id = "fringerate"+i+"";
		text12.name = "fringerate"+i+"";
		text12.type = "text";
		text12.size = "5";
		text12.value = varFringerate;
		text12.readOnly = "readonly";
		text12.style.backgroundColor = "#FFFFFF";
		text12.style.border = "0px solid #001E6A";
		text12.style.textAlign = "right";
		td12.appendChild (text12);
		tr.appendChild (td12);
		
		//var td81 = document.createElement ('<td id="idTD3'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
		var td11 = document.createElement ('td');
		td11.id = "btndelete"+i+"";
		td11.align = "center";
		td11.valign = "top";
		td11.style.backgroundColor = "#FFFFFF";
		td11.style.border = "0px solid #001E6A";
		
		
		var text11 = document.createElement ('input');
		text11.id = "btndelete"+i+"";
		text11.name = "btndelete"+i+"";
		text11.type = "button";
		text11.value = "Del";
		text11.style.border = "1px solid #001E6A";
		text11.onclick = function() { return btnDeleteClick(i); }
		td11.appendChild (text11);
		tr.appendChild (td11);
	
		document.getElementById ('loanrowinsert').appendChild (tr);
		
		//alert (varItemSerialNumberInsert);
		document.getElementById("serialnumber").value = parseInt(i) + 1;
		
		/*document.getElementById("loanname").value = "";
		document.getElementById("installments").value = "1";
		document.getElementById("interestapplicable").value = "Yes";
		document.getElementById("interest").value = "0.00";
		document.getElementById("amount").value = "0.00";
		document.getElementById("installmentamount").value = "0.00";
		document.getElementById("monthinterest").value = "0.00";;
		document.getElementById("monthamount").value = "0.00";
		document.getElementById("fringerate").value = "0.00";
		
		
		document.getElementById("loanname").focus();*/
		
		//window.scrollBy(0,5); 
		//return true;

	}
	//alert (k);
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