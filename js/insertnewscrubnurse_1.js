function insertNewScrubnurse(){



console.log("test.....");

	if(document.getElementById("scrubnurse_name").value=="")
	{
		alert("Please enter scrubnurse name");
		document.cbform1.scrubnurse_name.focus();
		return false;
	}
    

    

	var varserialnumberscrub = document.getElementById("serialnumberscrub").value;
	var varscrubnurseName = document.getElementById("scrubnurse_name").value;
	var varscrubnurseCode = document.getElementById("scrubnurse").value;

	//console.log(varscrubnurseName);
	var check_scrubnurse_count = document.getElementById('autoscrub_id').value;
	
	if(check_scrubnurse_count==0){
	var check_scrubnurse_count = document.getElementById('sno_suc').value;
	}
	
	
    if(check_scrubnurse_count > 0){
    	console.log("check duplicate"+check_scrubnurse_count);
	    for(let k = 1; k <= check_scrubnurse_count; k++){
	    	console.log(k);
	    	console.log('scrubnurse'+k);
	    	if ($('#scrubnurse'+k).length > 0){
		    	var scrubnurse_code = document.getElementById('scrubnurse'+k).value;
		    	
		    	if(scrubnurse_code == varscrubnurseCode){
		    		// throw error duplicate
		    		alert("scrubnurse already selected!");
		    		document.formpanel.scrubnurse_name.value = '';
					document.formpanel.scrubnurse_name.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varserialnumberscrub;

	var tr = document.createElement ('tr');
	tr.id = "idTR"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumberscrub"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumberscrub"+i+"";
	text1.name = "serialnumberscrub"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "scrubnurse"+i+"";
	text11.name = "scrubnurse"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varscrubnurseCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "scrubnurse_name"+i+"";
	text12.name = "scrubnurse_name"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "40";
	text12.value = varscrubnurseName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text13 = document.createElement ('input');
	text13.id = "btndelete6"+i+"";
	text13.name = "btndelete6"+i+"";
	text13.type = "button";
	text13.value = "Del";
	text13.style.border = "1px solid #001E6A";
	text13.onclick = function() { return btnDeleteClick11(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text13);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrowscrubnurse').appendChild (tr);

	var autoscrub_id = document.getElementById('autoscrub_id').value;
    
    var nw_id = Math.round(Number(autoscrub_id) + Number(1));

    //console.log('rrrr'+autoscrub_id);

    document.getElementById('autoscrub_id').value = nw_id;

	document.getElementById("serialnumberscrub").value = parseInt(i) + 1;

	var varscrubnurseName = document.getElementById("scrubnurse_name").value = "";
	var varscrubnurseCode = document.getElementById("scrubnurse").value = "";

	document.getElementById("scrubnurse_name").focus();
	
	window.scrollBy(0,5); 
	return true;



}