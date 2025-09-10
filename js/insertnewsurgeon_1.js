function insertNewSurgeon()
{

     console.log("test.....");

	if(document.getElementById("surgeon_name").value=="")
	{
		alert("Please enter surgeon name");
		document.form1.surgeon_name.focus();
		return false;
	}
    

    

	var varSerialNumber = document.getElementById("serialnumber").value;
	var varSurgeonName = document.getElementById("surgeon_name").value;
	var varSurgeonCode = document.getElementById("surgeon").value;

	//console.log(varSurgeonName);
	var check_surg_count = document.getElementById('auto_id').value;
	if(check_surg_count==0 ){
		var check_surg_count = document.getElementById('sno_an').value;
	}
	
    if(check_surg_count > 0){
    	console.log("check duplicate"+check_surg_count);
	    for(let j = 1; j <= check_surg_count; j++){
	    	console.log(j);
	    	console.log('surgeon'+j);
	    	if ($('#surgeon'+j).length > 0){
		    	var surg_code = document.getElementById('surgeon'+j).value;
		    	console.log(surg_code);
		    	if(surg_code == varSurgeonCode){
		    		// throw error duplicate
		    		alert("Surgeon already selected!");
		    		document.formpanel.surgeon_name.value = '';
					document.formpanel.surgeon_name.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varSerialNumber;

	var tr = document.createElement ('tr');
	tr.id = "idTR"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumber"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+i+"";
	text1.name = "serialnumber"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "surgeon"+i+"";
	text11.name = "surgeon"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varSurgeonCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "surgeon_name"+i+"";
	text12.name = "surgeon_name"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "35";
	text12.value = varSurgeonName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text13 = document.createElement ('input');
	text13.id = "btndelete5"+i+"";
	text13.name = "btndelete5"+i+"";
	text13.type = "button";
	text13.value = "Del";
	text13.style.border = "1px solid #001E6A";
	text13.onclick = function() { return btnDeleteClick5(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text13);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrow').appendChild (tr);

	var auto_id = document.getElementById('auto_id').value;
    
    var nw_id = Math.round(Number(auto_id) + Number(1));

    //console.log('rrrr'+auto_id);

    document.getElementById('auto_id').value = nw_id;

	document.getElementById("serialnumber").value = parseInt(i) + 1;

	var varSurgeonName = document.getElementById("surgeon_name").value = "";
	var varSurgeonCode = document.getElementById("surgeon").value = "";

	document.getElementById("surgeon_name").focus();
	
	window.scrollBy(0,5); 
	return true;
	

}