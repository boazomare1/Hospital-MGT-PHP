// JavaScript Document// JavaScript Document
function insertitem3()
{
	if(document.form1.radiology.value=="")
	{
		alert("Please enter radiology name");
		document.form1.radiology.focus();
		return false;
	}
	if(document.form1.rate8.value=="")
	{
		alert("Please enter rate");
		document.form1.rate8.focus();
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

		var varp = document.getElementById("rate8").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(document.getElementById("visitlimit").value<currtot){
         alert("order value exceeds the available Limits "+formatMoney(document.getElementById("visitlimit").value-totalgrand));
		var varLab = document.getElementById("radiology").value = "";
		var varLab = document.getElementById("hiddenradiology").value = "";
		var varRate = document.getElementById("rate8").value = "";
		document.getElementById("radiology").focus();
		 return false;
		}

	}else if(availablelimit100>=0){
       
	    var varp = document.getElementById("rate8").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(availablelimit100<currtot){
         alert("order value exceeds the available Limits "+formatMoney(availablelimit100-totalgrand));
		var varLab = document.getElementById("radiology").value = "";
		var varLab = document.getElementById("hiddenradiology").value = "";
		var varRate = document.getElementById("rate8").value = "";
		document.getElementById("radiology").focus();
		 return false;
		}
	}
	}
    */	var itemCode=document.getElementById("radiologycode").value ;
	var varSerialNumber21 = document.getElementById("serialnumber2").value;
	//alert(varSerialNumber21);
		var varradiologyinstructions = document.getElementById("radiologyinstructions").value;

	var varRadiology = document.getElementById("hiddenradiology").value;
	var varr = document.getElementById("rate8").value;
	var varradRate=Number(varr.replace(/[^0-9\.]+/g,""));
	//var varSerialNumber2=varSerialNumber21+41;    var varSerialNumber2=varSerialNumber21;	//alert(varRate);	var k = varSerialNumber2;	for(i =1;i< varSerialNumber2;i++){	var initial=$("#radiologycode1"+i).val();	if(initial==itemCode){	alert("This Test Already Exist ");	$("#radiology").val('');	$("#rate8").val('');	return false;	}}
	//alert(k);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+k+"";
	
	var td1 = document.createElement ('td');
	td1.id = "radiology"+k+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber2"+k+"";
	text1.name = "serialnumber2"+k+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber2;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "radiology"+k+"";
	text11.name = "radiology[]"+k+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varRadiology;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	var text112 = document.createElement ('input');
	text112.id = "radiologycode1"+k+"";
	text112.name = "radiologycode1[]"+k+"";
	text112.type = "text";
	text112.align = "left";
	text112.size = "25";
	text112.value = document.getElementById("radiologycode").value ;
	text112.readOnly = "readonly";
	text112.style.backgroundColor = "#FFFFFF";
	text112.style.border = "0px solid #001E6A";
	text112.style.textAlign = "left";
	

	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text112);
	tr.appendChild (td1);
	
	
	
		var td71 = document.createElement ('td');
	td71.id = "radiologyinstructions"+k+"";
	td71.align = "left";
	td71.valign = "top";
	td71.style.backgroundColor = "#FFFFFF";
	td71.style.border = "0px solid #001E6A";
	//var text71 = document.createElement ('<input name="discountpercent'+i+'" value="'+varItemDiscountPercent+'" id="discountpercent'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text71 = document.createElement ('input');
	text71.id = "radiologyinstructions"+k+"";
	text71.name = "radiologyinstructions[]"+k+"";
	text71.type = "text";
	text71.size = "20";
	text71.value = varradiologyinstructions;
	text71.readOnly = "readonly";
	text71.style.backgroundColor = "#FFFFFF";
	text71.style.border = "0px solid #001E6A";
	text71.style.textAlign = "left";
	td71.appendChild (text71);
	tr.appendChild (td71);
	
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate8"+k+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate8"+k+"";
	text8.name = "rate8[]"+k+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = formatMoney(varradRate);
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete5"+k+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete5"+k+"";
	text11.name = "btndelete5"+k+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick5(k,varradRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow2').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber2").value = parseInt(k) + 1;
	
		if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	total2=document.getElementById('total2').value;
	totalamount2=Number(total2.replace(/[^0-9\.]+/g,""));
	}
	
	
	totalamount2=parseFloat(totalamount2) + parseFloat(varradRate);
	document.getElementById("total2").value=formatMoney(totalamount2);
	
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
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	total3=document.getElementById('total3').value;
	totalamount3=Number(total3.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount4=0;
	}
	else
	{
	total4=document.getElementById('total5').value;
	totalamount4=Number(total4.replace(/[^0-9\.]+/g,""));
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
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	
	
		var varInstructions = document.getElementById("radiologyinstructions").value = "";

	var varLab = document.getElementById("radiology").value = "";
	var varLab = document.getElementById("hiddenradiology").value = "";
	var varRate = document.getElementById("rate8").value = "";
	
	document.getElementById("radiology").focus();
	
	window.scrollBy(0,5); 
	return true;

}