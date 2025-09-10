// JavaScript Document
function insertitem2()
{
	if(document.getElementById("d_patientcode").value == "")
	{
		alert("Please select patientname name");
		document.getElementById("d_patientcode").focus();
		return false;
	}
	
	if((document.getElementById("d_opoverall").value=="") || (document.getElementById("d_ipoverall").value==""))
	{
		alert("Please enter limits");
		document.getElementById("d_opoverall").focus();
		return false;
	}  
	var varSerialNumber11 = document.getElementById("serialnumber").value;
	//alert(varSerialNumber11);
	var vard_patientcode = document.getElementById("d_patientcode").value;
	var vard_patientname = document.getElementById("d_patientname").value;
	var vard_accountname = document.getElementById("d_accountname").value;
	var vard_planname = document.getElementById("d_planname").value;
	var vard_oppercent = document.getElementById("d_oppercent").value;
	var vard_ippercent = document.getElementById("d_ippercent").value;
	var vard_opoverall = document.getElementById("d_opoverall").value;
	var vard_ipoverall = document.getElementById("d_ipoverall").value;
	
	var varSerialNumber1=parseInt(varSerialNumber11);
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
	text11.id = "d_patientcode"+j+"";
	text11.name = "d_patientcode[]"+j+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "10";
	text11.value = vard_patientcode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	
	var td8 = document.createElement ('td');
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "d_patientname"+j+"";
	text8.name = "d_patientname[]"+j+"";
	text8.type = "text";
	text8.size = "35";
	text8.value = vard_patientname;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td9 = document.createElement ('td');
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text9 = document.createElement ('input');
	text9.id = "d_accountname"+j+"";
	text9.name = "d_accountname[]"+j+"";
	text9.type = "text";
	text9.size = "35";
	text9.value = vard_accountname;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
	var td12 = document.createElement ('td');
	td12.align = "left";
	td12.valign = "top";
	td12.style.backgroundColor = "#FFFFFF";
	td12.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text12 = document.createElement ('input');
	text12.id = "d_planname"+j+"";
	text12.name = "d_planname[]"+j+"";
	text12.type = "text";
	text12.size = "10";
	text12.value = vard_planname;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	td12.appendChild (text12);
	tr.appendChild (td12);
	
	var td13 = document.createElement ('td');
	td13.align = "left";
	td13.valign = "top";
	td13.style.backgroundColor = "#FFFFFF";
	td13.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text13 = document.createElement ('input');
	text13.id = "d_oppercent"+j+"";
	text13.name = "d_oppercent[]"+j+"";
	text13.type = "text";
	text13.size = "5";
	text13.value = vard_oppercent;
	text13.readOnly = "readonly";
	text13.style.backgroundColor = "#FFFFFF";
	text13.style.border = "0px solid #001E6A";
	text13.style.textAlign = "left";
	td13.appendChild (text13);
	tr.appendChild (td13);
	
	var td14 = document.createElement ('td');
	td14.align = "left";
	td14.valign = "top";
	td14.style.backgroundColor = "#FFFFFF";
	td14.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text14 = document.createElement ('input');
	text14.id = "d_opoverall"+j+"";
	text14.name = "d_opoverall[]"+j+"";
	text14.type = "text";
	text14.size = "30";
	text14.value = vard_opoverall;
	text14.readOnly = "readonly";
	text14.style.backgroundColor = "#FFFFFF";
	text14.style.border = "0px solid #001E6A";
	text14.style.textAlign = "left";
	td14.appendChild (text14);
	tr.appendChild (td14);
	
	var td15 = document.createElement ('td');
	td15.align = "left";
	td15.valign = "top";
	td15.style.backgroundColor = "#FFFFFF";
	td15.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text15 = document.createElement ('input');
	text15.id = "d_ippercent"+j+"";
	text15.name = "d_ippercent[]"+j+"";
	text15.type = "text";
	text15.size = "5";
	text15.value = vard_ippercent;
	text15.readOnly = "readonly";
	text15.style.backgroundColor = "#FFFFFF";
	text15.style.border = "0px solid #001E6A";
	text15.style.textAlign = "left";
	td15.appendChild (text15);
	tr.appendChild (td15);
	
	var td16 = document.createElement ('td');
	td16.align = "left";
	td16.valign = "top";
	td16.style.backgroundColor = "#FFFFFF";
	td16.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text16 = document.createElement ('input');
	text16.id = "d_ipoverall"+j+"";
	text16.name = "d_ipoverall[]"+j+"";
	text16.type = "text";
	text16.size = "30";
	text16.value = vard_ipoverall;
	text16.readOnly = "readonly";
	text16.style.backgroundColor = "#FFFFFF";
	text16.style.border = "0px solid #001E6A";
	text16.style.textAlign = "left";
	td16.appendChild (text16);
	tr.appendChild (td16);
	
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
	text11.onclick = function() { return btnDeleteClick1(j); }
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow').appendChild (tr);

	document.getElementById("serialnumber").value = parseInt(j) + 1;
	var vard_patientcode = document.getElementById("d_patientcode").value="";
	var vard_patientname = document.getElementById("d_patientname").value="";
	var vard_accountname = document.getElementById("d_accountname").value="";
	var vard_planname = document.getElementById("d_planname").value="";
	var vard_oppercent = document.getElementById("d_oppercent").value="";
	var vard_ippercent = document.getElementById("d_ippercent").value="";
	var vard_opoverall = document.getElementById("d_opoverall").value="";
	var vard_ipoverall = document.getElementById("d_ipoverall").value="";
	document.getElementById("d_patientname").focus();
	
	totalCalc();
	window.scrollBy(0,5); 
	return true;

}