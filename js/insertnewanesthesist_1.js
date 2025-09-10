function insertNewanesthesist()
{

     console.log("test.....");

	if(document.getElementById("anesthesist_name").value=="")
	{
		alert("Please enter anesthesist name");
		document.form1.anesthesist_name.focus();
		return false;
	}
    

    

	var varserialnumberanesthesist = document.getElementById("serialnumberanesthesist").value;
	var varanesthesistName = document.getElementById("anesthesist_name").value;
	var varanesthesistCode = document.getElementById("anesthesist").value;
	
	//console.log(varanesthesistName);
	var check_surg_count = document.getElementById('autoanesthesist_id').value;
	if(check_surg_count==0){
	var check_surg_count = document.getElementById("sno_anthe").value;
	}
	
    if(check_surg_count > 0){
    	console.log("check duplicate"+check_surg_count);
	    for(let j = 1; j <= check_surg_count; j++){
	    	console.log(j);
	    	console.log('anesthesist'+j);
	    	if ($('#anesthesist'+j).length > 0){
		    	var surg_code = document.getElementById('anesthesist'+j).value;
		    	console.log(surg_code);
		    	if(surg_code == varanesthesistCode){
		    		// throw error duplicate

		    		
		    		alert("anesthesist already selected!");
		    		document.formpanel.anesthesist_name.value = '';
					document.formpanel.anesthesist_name.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varserialnumberanesthesist;

	var tr = document.createElement ('tr');
	tr.id = "idTR"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumberanesthesist"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumberanesthesist"+i+"";
	text1.name = "serialnumberanesthesist"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "anesthesist"+i+"";
	text11.name = "anesthesist"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varanesthesistCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "anesthesist_name"+i+"";
	text12.name = "anesthesist_name"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "40";
	text12.value = varanesthesistName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text13 = document.createElement ('input');
	text13.id = "btndelete7"+i+"";
	text13.name = "btndelete7"+i+"";
	text13.type = "button";
	text13.value = "Del";
	text13.style.border = "1px solid #001E6A";
	text13.onclick = function() { return btnDeleteClick7(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text13);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrowanesthesist').appendChild (tr);

	var autoanesthesist_id = document.getElementById('autoanesthesist_id').value;
    
    var nw_id = Math.round(Number(autoanesthesist_id) + Number(1));

    //console.log('rrrr'+autoanesthesist_id);

    document.getElementById('autoanesthesist_id').value = nw_id;

	document.getElementById("serialnumberanesthesist").value = parseInt(i) + 1;

	var varanesthesistName = document.getElementById("anesthesist_name").value = "";
	var varanesthesistCode = document.getElementById("anesthesist").value = "";

	document.getElementById("anesthesist_name").focus();
	
	window.scrollBy(0,5); 
	return true;
	

}