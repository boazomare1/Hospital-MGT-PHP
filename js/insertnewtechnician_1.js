function insertNewtechnician()
{

     console.log("test.....");

	if(document.getElementById("technician").value=="")
	{
		alert("Please enter technician name");
		document.cbform1.technician_name.focus();
		return false;
	}
    

    

	var varserialnumbertechnician = document.getElementById("serialnumbertechnician").value;
	var vartechnicianName = document.getElementById("technician_name").value;
	var vartechnicianCode = document.getElementById("technician").value;

	//console.log(vartechnicianName);
	var check_surg_count = document.getElementById('autotechnician_id').value;
	if(check_surg_count==0){
	var check_surg_count = document.getElementById('sno_tech').value;
	}
	
    if(check_surg_count > 0){
    	console.log("check duplicate"+check_surg_count);
	    for(let j = 1; j <= check_surg_count; j++){
	    	console.log(j);
	    	console.log('technician'+j);
	    	if ($('#technician'+j).length > 0){
		    	var surg_code = document.getElementById('technician'+j).value;
		    	console.log(surg_code);
		    	if(surg_code == vartechnicianCode){
		    		// throw error duplicate

		    		
		    		alert("technician already selected!");
		    		document.formpanel.technician_name.value = '';
					document.formpanel.technician_name.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varserialnumbertechnician;

	var tr = document.createElement ('tr');
	tr.id = "idTR"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumbertechnician"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumbertechnician"+i+"";
	text1.name = "serialnumbertechnician"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "technician"+i+"";
	text11.name = "technician"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = vartechnicianCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "technician_name"+i+"";
	text12.name = "technician_name"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "40";
	text12.value = vartechnicianName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text13 = document.createElement ('input');
	text13.id = "btndelete10"+i+"";
	text13.name = "btndelete10"+i+"";
	text13.type = "button";
	text13.value = "Del";
	text13.style.border = "1px solid #001E6A";
	text13.onclick = function() { return btnDeleteClick10(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text13);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrowtechnician').appendChild (tr);

	var autotechnician_id = document.getElementById('autotechnician_id').value;
    
    var nw_id = Math.round(Number(autotechnician_id) + Number(1));

    //console.log('rrrr'+autotechnician_id);

    document.getElementById('autotechnician_id').value = nw_id;

	document.getElementById("serialnumbertechnician").value = parseInt(i) + 1;

	var vartechnicianName = document.getElementById("technician_name").value = "";
	var vartechnicianCode = document.getElementById("technician").value = "";

	document.getElementById("technician_name").focus();
	
	window.scrollBy(0,5); 
	return true;
	

}