// JavaScript Document
function insertitem21(str)
{
	//alert("insertitem2");
	//alert(str);
	var checkdata = str.split(",");
	//alert(checkdata.length);
      // alert(document.getElementById("labcode").value);
	if(checkdata.length=="")
	{
		alert("Please select laboratory name from list");
		document.form1.lab.focus();
		return false;
	}
	
	if(document.form1.rate5.value=="")
	{
		/*alert("Please enter rate");
		document.form1.rate5.focus();
		return false;*/
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

		var varp = document.getElementById("rate5").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(document.getElementById("visitlimit").value<currtot){
         alert("order value exceeds the available Limits "+formatMoney(document.getElementById("visitlimit").value-totalgrand));
		var varLab = document.getElementById("lab").value = "";
		var varLab = document.getElementById("hiddenlab").value = "";
		var varRate = document.getElementById("rate5").value = "";
		document.getElementById("lab").focus();
		 return false;
		}

	}else if(availablelimit100>=0){
       
	    var varp = document.getElementById("rate5").value;
	    var varpharmAmount = Number(varp.replace(/[^0-9\.]+/g,""));
		var currtot=parseFloat(totalgrand)+parseFloat(varpharmAmount);
		if(availablelimit100<currtot){
         alert("order value exceeds the available Limits "+formatMoney(availablelimit100-totalgrand));
		var varLab = document.getElementById("lab").value = "";
		var varLab = document.getElementById("hiddenlab").value = "";
		var varRate = document.getElementById("rate5").value = "";
		document.getElementById("lab").focus();
		 return false;
		}
	}
   } */
    
	for (var i = 0, len = checkdata.length; i < len; i++) 
	{
		
           
		var itemdetails = checkdata[i];
		if(itemdetails.trim() != '#')
		{
		var itemdata = itemdetails.split("#");
		var varSerialNumber11 = document.getElementById("serial1").value;
		var varLab = itemdata[0];
		var varlab = itemdata[1];
		var varlabRate = Number(varlab);
if(varlabRate > 0.00)
{
	var varSerialNumber1=varSerialNumber11+51;
	var j = varSerialNumber1;
	//alert(j);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+j+"";
	tr.size = "40";
	
	var td1 = document.createElement ('td');
	td1.id = "lab"+j+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber1"+j+"";
	text1.name = "serialnumber1"+j+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber1;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "lab"+j+"";
	text11.name = "lab[]"+j+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "50";
	text11.value = varLab;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	var text112 = document.createElement ('input');
	text112.id = "labcode1"+j+"";
	text112.name = "labcode1[]"+j+"";
	text112.type = "text";
	text112.align = "left";
	text112.size = "25";
	text112.value = document.getElementById("labcode").value ;
	text112.readOnly = "readonly";
	text112.style.backgroundColor = "#FFFFFF";
	text112.style.border = "0px solid #001E6A";
	text112.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text112);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "ratelab"+j+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate5"+j+"";
	text8.name = "rate5[]"+j+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = formatMoney(varlabRate);
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete1"+j+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete1"+j+"";
	text11.name = "btndelete1"+j+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick12(this.parentElement.parentElement.id); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow1').appendChild (tr);
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serial1").value = parseInt(j) + 1;
	//alert(document.getElementById("serial1").value);
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	total1=document.getElementById('total1').value;
	totalamount1=Number(total1.replace(/[^0-9\.]+/g,""));
	}
	
	totalamount1=parseFloat(totalamount1) + parseFloat(varlabRate);
	document.getElementById("total1").value=formatMoney(totalamount1);
		}
	}
	} // for for loop Kenique
	if(document.getElementById('total').value=='')
	{
	 totalamount=0;
	//alert(totalamount11);
	}
	else
	{
	total=document.getElementById('total').value;
	totalamount=Number(total.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount2=0;
	//alert(totalamount21);
	}
	else
	{
	total2=document.getElementById('total2').value;
	totalamount2=Number(total2.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount3=0;
	//alert(totalamount31);
	}
	else
	{
	 total3=document.getElementById('total3').value;
	 totalamount3=Number(total3.replace(/[^0-9\.]+/g,""));
	 
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount4=0;
	//alert(totalamount41);
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
	//alert(totalamount);
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	
	
	var varLab = document.getElementById("lab").value = "";
	var varLab = document.getElementById("hiddenlab").value = "";
	var varRate = document.getElementById("rate5").value = "";
	
	
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;

}