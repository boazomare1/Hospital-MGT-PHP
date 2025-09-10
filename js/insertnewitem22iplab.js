// JavaScript Document
var labcode=['1'];	
function insertitem2()
{
	if(document.getElementById("lab").value=="")
	{
		alert("Please enter laboratory name");
		document.getElementById("lab").focus();
		return false;
	}
	
	if(document.getElementById("rate5").value=="")
	{
		alert("Please enter rate");
		document.getElementById("rate5").focus();
		return false;
	}
	if(document.getElementById("labfree").value=="")
	{
		alert("Please enter free status");
		document.getElementById("labfree").focus();
		return false;
	}	
	var varlabfree = document.getElementById("labfree").value;
	
	if(varlabfree == "no")
	{
		varlabfreename = 'No';
	}
	if(varlabfree == "yes")
	{
		varlabfreename = 'Yes';
	}
	
	var varavailableamount = Number(document.getElementById("availableamount").value.replace(/[^0-9\.]+/g,""));
	var varavailableamount_new = document.getElementById("availableamount").value.replace(/\,/g,'');
	
	 
	var billtypes = document.getElementById("billtypes").value;
	var varSerialNumber11 = document.getElementById("serialnumber17").value;
	
	// alert(varSerialNumber11);
	var varLab = document.getElementById("lab").value;
	var varLabcode = document.getElementById("labcode").value;
	
	// console.log(labcode);
	var varlabRate = Number(document.getElementById("rate5").value.replace(/[^0-9\.]+/g,""));
	
	// alert(labcode[0]);
	// let strArray = labcode=[];
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount1=Number(document.getElementById('total1').value.replace(/[^0-9\.]+/g,""));
	
	}
	
	//totalamount11=totalamount11 + varlabRate;
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=Number(document.getElementById('total2').value.replace(/[^0-9\.]+/g,""));
	
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount3=Number(document.getElementById('total3').value.replace(/[^0-9\.]+/g,""));
	
	}
	
	grandtotal= parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(varlabRate);
	
	if(varavailableamount_new<='0.00'){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;	
	}
	
	if((varavailableamount<grandtotal)){
	alert('"Available Limit Exceeded. Please Check with Admin"');	
	return false;
	}
	
	
	
	var varSerialNumber1=parseInt(varSerialNumber11)+51;
	var j = varSerialNumber1;
	
	
	var result = labcode.indexOf(varLabcode);
	// var result = _.findWhere(labcode, {varLabcode});
	
	console.log(result);
	// console.log(findDuplicates(labcode));
if(result>0){
 	alert('"The  item has already been added above. Please Click OK to continue to add other items"');
 	
 	document.getElementById("lab").value = "";
 	document.getElementById("rate5").value = "";
 	document.getElementById("labfree").value = "";
 }else{
labcode.push(varLabcode);
console.log(labcode);
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
	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate5"+j+"";
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
	var td81 = document.createElement ('td');
	td81.id = "labcode"+j+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text81 = document.createElement ('input');
	text81.id = "labcode"+j+"";
	text81.name = "labcode[]"+j+"";
	text81.type = "hidden";
	text81.size = "8";
	text81.value = varLabcode;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "left";
	td81.appendChild (text81);
	tr.appendChild (td81);
	
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
	text11.onclick = function() { return btnDeleteClick1(j,varlabRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
    document.getElementById ('insertrow1').appendChild (tr);
	
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	
	document.getElementById("serialnumber17").value = parseInt(j) + 1;
	document.getElementById("total1").value=formatMoney(parseFloat(totalamount1)+parseFloat(varlabRate));
	document.getElementById("availableamount_org").value=formatMoney(parseFloat(varavailableamount)-grandtotal);
	document.getElementById("total4").value=formatMoney(grandtotal);
	document.getElementById("grand_total").value=formatMoney(grandtotal);
		
	
	
	var varLab = document.getElementById("lab").value = "";
	var varRate = document.getElementById("rate5").value = "";
	
	
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;
}
}
function pop_delete_labcode(){
	var varLabcode1 = document.getElementById("labcode").value;
	 labcode.pop(varLabcode1);
	 console.log(labcode);
}