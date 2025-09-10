function insertNewcircnurse(){



console.log("test.....");

	if(document.getElementById("circnurse_name").value=="")
	{
		alert("Please enter circnurse name");
		document.cbform1.circnurse_name.focus();
		return false;
	}
    

    

	var varserialnumbercircnurse = document.getElementById("serialnumbercircnurse").value;
	var varcircnurseName = document.getElementById("circnurse_name").value;
	var varcircnurseCode = document.getElementById("circnurse").value;

	//console.log(varcircnurseName);
	var check_circnurse_count = document.getElementById('autocircnurse_id').value;
	if(check_circnurse_count==0){
	var check_circnurse_count = document.getElementById('sno_cir').value;
	}
	
	
	
    if(check_circnurse_count > 0){
    	console.log("check duplicate"+check_circnurse_count);
	    for(let k = 1; k <= check_circnurse_count; k++){
	    	console.log(k);
	    	console.log('circnurse'+k);
	    	if ($('#circnurse'+k).length > 0){
		    	var circnurse_code = document.getElementById('circnurse'+k).value;
		    	
		    	if(circnurse_code == varcircnurseCode){
		    		// throw error duplicate
		    		alert("circnurse already selected!");
		    		document.cbform1.circnurse_name.value = '';
					document.cbform1.circnurse_name.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varserialnumbercircnurse;

	var tr = document.createElement ('tr');
	tr.id = "idTR"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumbercircnurse"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumbercircnurse"+i+"";
	text1.name = "serialnumbercircnurse"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "circnurse"+i+"";
	text11.name = "circnurse"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varcircnurseCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "circnurse_name"+i+"";
	text12.name = "circnurse_name"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "40";
	text12.value = varcircnurseName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text13 = document.createElement ('input');
	text13.id = "btndelete8"+i+"";
	text13.name = "btndelete8"+i+"";
	text13.type = "button";
	text13.value = "Del";
	text13.style.border = "1px solid #001E6A";
	text13.onclick = function() { return btnDeleteClick8(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text13);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrowcircnurse').appendChild (tr);

	var autocircnurse_id = document.getElementById('autocircnurse_id').value;
    
    var nw_id = Math.round(Number(autocircnurse_id) + Number(1));

    //console.log('rrrr'+autocircnurse_id);

    document.getElementById('autocircnurse_id').value = nw_id;

	document.getElementById("serialnumbercircnurse").value = parseInt(i) + 1;

	var varcircnurseName = document.getElementById("circnurse_name").value = "";
	var varcircnurseCode = document.getElementById("circnurse").value = "";

	document.getElementById("circnurse_name").focus();
	
	window.scrollBy(0,5); 
	return true;

}