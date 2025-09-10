// JavaScript Document
function insertitem2()
{
//alert(document.getElementById("serial1").value);
	if(document.getElementById("typename").value=="")
	{
		alert("Please Select Type name");
		document.getElementById("typename").focus();
		return false;
	}
	if(document.getElementById("description").value=="")
	{
		alert("Please Enter Description");
		document.getElementById("description").focus();
		return false;
	}
	if(document.getElementById("calories").value=="")
	{
		alert("Please Enter Calories");
		document.getElementById("calories").focus();
		return false;
	}
	if(document.getElementById("amountkitchen").value=="")
	{
		alert("Please Enter Amount");
		document.getElementById("amountkitchen").focus();
		return false;
	}
	
	//if(document.form1.rate5.value=="")
//	{
//		alert("Please enter rate");
//		document.form1.rate5.focus();
//		return false;
//	}
	var varSerialNumber11 = document.getElementById("serial1").value;
	//alert(varSerialNumber11);
	var vartypename = document.getElementById("typename").value;
	var vardescription = document.getElementById("description").value;
	var varcalories = document.getElementById("calories").value;
	var varfreestatus = document.getElementById("freestatus").value;
	var totalamount = document.getElementById("totalamount").value;
	var kitchenamount = document.getElementById("amountkitchen").value;
	if(varSerialNumber11==1)
	{
		var grandtotal = parseFloat(kitchenamount);
		}
		else
		{
			var grandtotal = parseFloat(totalamount)+parseFloat(kitchenamount);
			}
	
	//alert(grandtotal);
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
	text1.name = "serialnumber1[]";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber1;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	
	
	var text11 = document.createElement ('input');
	text11.id = "typename"+j+"";
	text11.name = "typename[]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "12";
	text11.value = vartypename;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	
	
	var td8 = document.createElement ('td');
	td8.id = "description"+j+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "description1"+j+"";
	text8.name = "description[]";
	text8.type = "text";
	text8.size = "60";
	text8.value = vardescription;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	
	var td12 = document.createElement ('td');
	td12.id = "calories"+j+"";
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text12 = document.createElement ('input');
	text12.id = "calories1"+j+"";
	text12.name = "calories[]";
	text12.type = "text";
	text12.size = "8";
	text12.value = varcalories;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);
	
	var td14 = document.createElement ('td');
	td14.id = "amountkitchen"+j+"";
	td14.align = "left";
	td14.valign = "top";
	td14.style.backgroundColor = "#FFFFFF";
	td14.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text14 = document.createElement ('input');
	text14.id = "amountkitchen1"+j+"";
	text14.name = "amountkitchen[]";
	text14.type = "text";
	text14.size = "20";
	text14.value = kitchenamount;
	text14.readOnly = "readonly";
	text14.style.backgroundColor = "#FFFFFF";
	text14.style.border = "0px solid #001E6A";
	text14.style.textAlign = "left";
	td14.appendChild (text14);
	tr.appendChild (td14);
	
	var td13 = document.createElement ('td');
	td13.id = "freestatus"+j+"";
	td13.align = "left";
	td13.valign = "top";
	td13.style.backgroundColor = "#FFFFFF";
	td13.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text13 = document.createElement ('input');
	text13.id = "freestatus1"+j+"";
	text13.name = "freestatus[]";
	text13.type = "text";
	text13.size = "8";
	text13.value = varfreestatus;
	text13.readOnly = "readonly";
	text13.style.backgroundColor = "#FFFFFF";
	text13.style.border = "0px solid #001E6A";
	text13.style.textAlign = "left";
	td13.appendChild (text13);
	tr.appendChild (td13);
	
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
	text11.onclick = function() { return btnDeleteClick1(j,varSerialNumber11); }
//	alert(j);
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow1').appendChild (tr);
	
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serial1").value = parseInt(j) + 1;
	
	//alert('okok');
	
	var vartypename = document.getElementById("typename").value = "";
	var varRate = document.getElementById("description").value = "";
	var varRate = document.getElementById("calories").value = "";
	var varamountkitchen = document.getElementById("amountkitchen").value = "";
	var varRate = document.getElementById("freestatus").value = "No";
	
	grandtotal= parseFloat(grandtotal);
	
	document.getElementById("totalamount").value=grandtotal.toFixed(2);
	
		if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	
	totalamount1=parseFloat(totalamount1) + parseFloat(vardescription);
	document.getElementById("total1").value=totalamount1.toFixed(2);
	
	if(document.getElementById('total').value=='')
	{
	 totalamount=0;
	//alert(totalamount11);
	}
	else
	{
	totalamount=document.getElementById('total').value;
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount2=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount3=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount3=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount4=0;
	//alert(totalamount41);
	}
	else
	{
	 totalamount4=document.getElementById('total5').value;
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalamountr=document.getElementById('totalr').value;
	}
	//alert(totalamount);
	 grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	
	
	
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;

}