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
	for (var i = 0, len = checkdata.length; i < len; i++) 
	{
		
           
		var itemdetails = checkdata[i];
		if(itemdetails !='##No')
		{
		var itemdata = itemdetails.split("#");
		var varSerialNumber11 = document.getElementById("serialnumber17").value;
		
		var varLab = itemdata[0];
		var varlab = itemdata[1];
		var varlabfreename = itemdata[2];
		var varlabcode = itemdata[3];
		//alert(varlabfreecode);
		var varlabRate = Number(varlab);
	if(varlabRate >0.00)
{
	var varSerialNumber1=varSerialNumber11+51;
	var j = varSerialNumber1;
	//alert(j);
	
	var varSerialNumber1=parseInt(varSerialNumber11)+51;
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
	
	var text12 = document.createElement ('input');
	text12.id = "labcode1"+j+"";
	text12.name = "labcode1[]"+j+"";
	text12.type = "hidden";
	text12.align = "left";
	text12.size = "50";
	text12.value = varlabcode;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate5"+j+"1";
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
	text8.value = varlabRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td9 = document.createElement ('td');
	td9.id = "labfree"+j+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text9 = document.createElement ('input');
	text9.id = "labfree"+j+"";
	text9.name = "labfree[]"+j+"";
	text9.type = "text";
	text9.size = "8";
	text9.value = varlabfreename;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
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
	document.getElementById("serialnumber17").value = parseInt(j) + 1;
	
		if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	
	totalamount1=parseInt(totalamount1) + parseInt(varlabRate);
	document.getElementById("total1").value=totalamount1.toFixed(2);
		}
	}
	}
	//alert(varSerialNumber11);
	var varLab = document.getElementById("lab").value;
	var varlabRate = document.getElementById("rate5").value;
	
	
	
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
	
	grandtotal= parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	
	
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;

}