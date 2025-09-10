function InsertRow()
{	
	for(var j = document.getElementById("loanrowinsert").rows.length; j > 0;j--)
	{
		document.getElementById("loanrowinsert").deleteRow(j -1);
	}
	
	var varSerialNumber = document.getElementById("serialnumber").value;
	var varinstallpermonth = document.getElementById("installpermonth").value;
	//var varinstallpermonth = Math.round(varinstallpermonth);
	var varinstallpermonth = parseFloat(varinstallpermonth);
	var vartotalloanamt = document.getElementById("totalloanamt").value;
	var varinterestratepermonth = document.getElementById("interestratepermonth").value;
	var varinterestratepermonth = parseFloat(varinterestratepermonth);
	var varinterestratepermonth = varinterestratepermonth.toFixed(6);
	var vartotaldue = document.getElementById("totaldue").value;
	var vartotalinterest = document.getElementById("totalinterest").value;
	var varnoofinstallment = document.getElementById("noofinstallment").value;
	var noofinstallment = document.getElementById("noofinstallment").value;
	var Interestper = parseFloat(varinterestratepermonth) * parseFloat(vartotalloanamt) / 100;
	var varprinciple = parseFloat(varinstallpermonth) - parseFloat(Interestper);
	var varbalance = parseFloat(vartotalloanamt) - parseFloat(varprinciple);
	//var varnoofinstallment = parseFloat(varnoofinstallment);
	var varnoofinstallment1 = Math.round(varnoofinstallment);
	if(parseFloat(varnoofinstallment) > parseFloat(varnoofinstallment1))
	{
		var varnoofinstallment1 = parseFloat(varnoofinstallment1) + 1;
	}
	else
	{
		var varnoofinstallment1 = parseFloat(varnoofinstallment1);
	}
	//alert(varnoofinstallment);
	for(var i=1;i<=varnoofinstallment1;i++)
	{
	var s = parseFloat(i);
	
	if(parseFloat(i) == 1)
	{
		var Interestper = parseFloat(varinterestratepermonth) * parseFloat(vartotalloanamt) / 100;
		var varprinciple = parseFloat(varinstallpermonth) - parseFloat(Interestper);
		var varbalance = parseFloat(vartotalloanamt) - parseFloat(varprinciple);
	}
	else
	{	
		var k = parseFloat(i) - 1;
		var loanbalance = document.getElementById("balance"+k).value;
		var loanprinciple = document.getElementById("principle"+k).value;
		var loanint = document.getElementById("interest"+k).value;
		
		var Interestper = parseFloat(varinterestratepermonth) * parseFloat(loanbalance) / 100;
		//var Interestper = Math.round(Interestper);
		var varprinciple = parseFloat(varinstallpermonth) - parseFloat(Interestper);
		var varbalance = parseFloat(loanbalance) - parseFloat(varprinciple);
	}
	
	if(parseFloat(i) >= parseFloat(varnoofinstallment))
	{
		var k = parseFloat(i) - 1;
		var loanbalance = document.getElementById("balance"+k).value;
		var varprinciple = parseFloat(loanbalance);
		var varbalance = parseFloat(loanbalance) - parseFloat(varprinciple);
		var Interestper = parseFloat(varinterestratepermonth) * parseFloat(loanbalance) / 100;
		var varinstallpermonth = parseFloat(Interestper) + parseFloat(varprinciple);
		var s = parseFloat(noofinstallment);
	}
	
	var Interestper = Interestper.toFixed(0);
	var varprinciple = varprinciple.toFixed(0);
	var varbalance = varbalance.toFixed(0);
	
	var Interestper1 = parseFloat(Interestper);
	var varprinciple1 = parseFloat(varprinciple);
	var varbalance1 = parseFloat(varbalance);
	
	var varinstallpermonth1 = Math.round(varinstallpermonth);
	var varinstallpermonth1 = parseFloat(varinstallpermonth1);
	var Interestper1 = Interestper1.toFixed(2);
	var varprinciple1 = varprinciple1.toFixed(2);
	var varbalance1 = varbalance1.toFixed(2);
	
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
	text1.type = "hidden";
	text1.size = "3";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "right";
	
	var text32 = document.createElement ('input');
	text32.id = "serialnumberid1"+i+"";
	text32.name = "serialnumberid1"+i+"";
	text32.type = "text";
	text32.size = "3";
	text32.value = s;
	text32.readOnly = "readonly";
	text32.style.backgroundColor = "#FFFFFF";
	text32.style.border = "0px solid #001E6A";
	text32.style.textAlign = "right";
	td1.appendChild (text32);
	td1.appendChild (text1);
	tr.appendChild (td1);
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	/*var td8 = document.createElement ('td');
	td8.id = "idtd8"+i+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text8 = document.createElement ('input');
	text8.id = "date1"+i+"";
	text8.name = "date1"+i+"";
	text8.type = "text";
	text8.size = "7";
	text8.value = "Jan-2015";
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);*/
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td2 = document.createElement ('td');
	td2.id = "idTD2"+i+"";
	td2.align = "right";
	td2.valign = "top";
	td2.style.backgroundColor = "#FFFFFF";
	td2.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text2 = document.createElement ('input');
	text2.id = "payment"+i+"";
	text2.name = "payment"+i+"";
	text2.type = "text";
	text2.size = "10";
	text2.value = varinstallpermonth1.toFixed(2);
	text2.readOnly = "readonly";
	text2.style.backgroundColor = "#FFFFFF";
	text2.style.border = "0px solid #001E6A";
	text2.style.textAlign = "right";
	td2.appendChild (text2);
	tr.appendChild (td2);
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td3 = document.createElement ('td');
	td3.id = "idTD3"+i+"";
	td3.align = "right";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text3 = document.createElement ('input');
	text3.id = "principle"+i+"";
	text3.name = "principle"+i+"";
	text3.type = "text";
	text3.size = "10";
	text3.value = varprinciple1;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "right";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td4 = document.createElement ('td');
	td4.id = "idTD4"+i+"";
	td4.align = "right";
	td4.valign = "top";
	td4.style.backgroundColor = "#FFFFFF";
	td4.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text4 = document.createElement ('input');
	text4.id = "interest"+i+"";
	text4.name = "interest"+i+"";
	text4.type = "text";
	text4.size = "8";
	text4.value = Interestper1;
	text4.readOnly = "readonly";
	text4.style.backgroundColor = "#FFFFFF";
	text4.style.border = "0px solid #001E6A";
	text4.style.textAlign = "right";
	td4.appendChild (text4);
	tr.appendChild (td4);
	
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td5 = document.createElement ('td');
	td5.id = "idTD5"+i+"";
	td5.align = "right";
	td5.valign = "top";
	td5.style.backgroundColor = "#FFFFFF";
	td5.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text5 = document.createElement ('input');
	text5.id = "balance"+i+"";
	text5.name = "balance"+i+"";
	text5.type = "text";
	text5.size = "10";
	text5.value = varbalance1;
	text5.readOnly = "readonly";
	text5.style.backgroundColor = "#FFFFFF";
	text5.style.border = "0px solid #001E6A";
	text5.style.textAlign = "right";
	td5.appendChild (text5);
	tr.appendChild (td5);
	
	
    document.getElementById ('loanrowinsert').appendChild (tr);
	 
	//return true;
	
	}

}


function btnDeleteClick(k)
{
 
 var varDeleteID = k;
 //alert(vrate1);
 
 var fRet4; 
 fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
 //alert(fRet4); 
 if (fRet4 == false)
 {
  //alert ("Item Entry Not Deleted.");
  return false;
 }
 
 var child1 = document.getElementById('idTR'+varDeleteID); //tr name
 var parent1 = document.getElementById('loanrowinsert'); // tbody name.
 document.getElementById ('loanrowinsert').removeChild(child1); 
 
}