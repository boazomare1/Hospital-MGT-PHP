// JavaScript Document// JavaScript Document
function insertitem5()
{
	
	if(document.form1.referal.value=="")
	{
		alert("Please enter referal name");
		document.form1.referal.focus();
		return false;
	}
	if(document.form1.rate4.value=="")
	{
		alert("Please enter rate");
		document.form1.rate4.focus();
		return false;
	}
	/*
    if(document.getElementById('billtype').value!='PAY NOW'){
	totalgrand=document.getElementById('total4').value;
	if(totalgrand!=''){
	  totalgrand=Number(totalgrand.replace(/[^0-9\.]+/g,""));
	}else
		totalgrand=0;

	availablelimit100=document.getElementById('overalllimit').value;
	if(availablelimit100!='' && availablelimit100>0 && (document.getElementById("visitlimit").value==0 || document.getElementById("visitlimit").value=='')){
	  availablelimit100=document.getElementById('availablelimit100').value;
	  availablelimit100=Number(availablelimit100.replace(/[^0-9\.]+/g,""));
	}else
		availablelimit100=0;

	if(document.getElementById("visitlimit").value>=0 && availablelimit100==0){

		var varp = document.getElementById("rate4").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(document.getElementById("visitlimit").value<currtot){
         alert("order value exceeds the available Limits "+formatMoney(document.getElementById("visitlimit").value-totalgrand));
		var varLab = document.getElementById("referal").value = "";
	    var varRate = document.getElementById("rate4").value = "";
		document.getElementById("referal").focus();
		 return false;
		}
	}else if(availablelimit100>=0){
       
	   var varp = document.getElementById("rate4").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(availablelimit100<currtot){
         alert("order value exceeds the available Limits "+formatMoney(availablelimit100-totalgrand));
		var varLab = document.getElementById("referal").value = "";
	    var varRate = document.getElementById("rate4").value = "";
		document.getElementById("referal").focus();
		 return false;
		}
	}
	}
	*/


	var varSerialNumber41 = document.getElementById("serialnumber4").value;
	var varreferal = document.getElementById("referal").value;
	var varref = document.getElementById("rate4").value;
	var varrefRate = Number(varref.replace(/[^0-9\.]+/g,""));
	var varSerialNumber4=parseInt(varSerialNumber41)+71;
	
	var n = varSerialNumber4;
	//alert(n);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+n+"";
	
	var td1 = document.createElement ('td');
	td1.id = "serialnumber4"+n+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber4"+n+"";
	text1.name = "serialnumber4"+n+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber4;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "referal"+n+"";
	text11.name = "referal[]"+n+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varreferal;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate4"+n+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate4"+n+"";
	text8.name = "rate4[]"+n+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = formatMoney(varrefRate);
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete4"+n+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete4"+n+"";
	text11.name = "btndelete4"+n+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick4(n,varrefRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	

    document.getElementById ('insertrow4').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber4").value = parseInt(n) + 1;
	
		if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	total4=document.getElementById('total5').value;
	totalamount4=Number(total4.replace(/[^0-9\.]+/g,""));
	}
	
	
	
     
	//alert(vRate);
	totalamount4=parseInt(totalamount4) + parseInt(varrefRate);
	
	document.getElementById("total5").value=formatMoney(totalamount4);
	
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	total=document.getElementById('total').value;
	totalamount=Number(total.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	total1=document.getElementById('total1').value;
	totalamount1=Number(total1.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	total2=document.getElementById('total2').value;
	totalamount2=Number(total2.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	total3=document.getElementById('total3').value;
	totalamount3=Number(total3.replace(/[^0-9\.]+/g,""));
	}
	
		if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalr=document.getElementById('totalr').value;
	totalamountr=Number(totalr.replace(/[^0-9\.]+/g,""));
	}
	
	//alert(totalamount4);
	
//	grandtotal= parseInt(totalamount)+parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3)+parseInt(totalamount4);

grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	
	
	
	
	var varLab = document.getElementById("referal").value = "";
	var varRate = document.getElementById("rate4").value = "";
	
	document.getElementById("referal").focus();
	
	window.scrollBy(0,5); 
	return true;

}