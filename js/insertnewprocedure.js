function insertNewProcedure(){

 console.log("test.....");

	if(document.getElementById("procedure").value=="")
	{
		alert("Please enter procedure type");
		document.form1.serv.focus();
		return false;
	}
    

    

	var varserialnumberProcedure = document.getElementById("serialnumberProcedure").value;
	var varprocedureName = document.getElementById("serv").value;
	var varprocedureCode = document.getElementById("procedure").value;

	//console.log(varprocedureName);
	var check_surg_count = document.getElementById('auto_idProcedure').value;
    if(check_surg_count > 0){
    	console.log("check duplicate"+check_surg_count);
	    for(let j = 1; j <= check_surg_count; j++){
	    	console.log(j);
	    	console.log('procedure'+j);
	    	if ($('#procedure'+j).length > 0){
		    	var surg_code = document.getElementById('procedure'+j).value;
		    	console.log(surg_code);
		    	if(surg_code == varprocedureCode){
		    		// throw error duplicate
		    		alert("procedure already selected!");
		    		document.form1.serv.value = '';
					document.form1.serv.focus();
					return false;
		    	}
		    }
	    }
	}


	var i = varserialnumberProcedure;

	var tr = document.createElement ('tr');
	tr.id = "idTR1"+i+"";

	var td1 = document.createElement ('td');
	td1.id = "serialnumberProcedure"+i+"";

	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";


	var text1 = document.createElement ('input');
	text1.id = "serialnumberProcedure"+i+"";
	text1.name = "serialnumberProcedure"+i+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = i;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);

	var text11 = document.createElement ('input');
	text11.id = "procedure"+i+"";
	text11.name = "procedure"+i+"";
	text11.type = "hidden";
	text11.align = "left";
	text11.size = "25";
	text11.value = varprocedureCode;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";



	var text12 = document.createElement ('input');
	text12.id = "serv"+i+"";
	text12.name = "serv"+i+"";
	text12.type = "text";
	text12.align = "left";
	text12.size = "40";
	text12.value = varprocedureName;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";

	var text14 = document.createElement ('input');
	text14.id = "btndelete6"+i+"";
	text14.name = "btndelete6"+i+"";
	text14.type = "button";
	text14.value = "Del";
	text14.style.border = "1px solid #001E6A";
	text14.onclick = function() { return btnDeleteClick6(i); }


	td1.appendChild (text1);
	td1.appendChild (text11);
	td1.appendChild (text12);
	td1.appendChild (text14);
	tr.appendChild (td1);

    //console.log(td1);

	document.getElementById ('insertrowProcedure').appendChild (tr);

	var auto_idProcedure = document.getElementById('auto_idProcedure').value;
    
    var nw_id = Math.round(Number(auto_idProcedure) + Number(1));

    //console.log('rrrr'+auto_idProcedure);

    document.getElementById('auto_idProcedure').value = nw_id;

	document.getElementById("serialnumberProcedure").value = parseInt(i) + 1;

	var varprocedureName = document.getElementById("serv").value = "";
	var varprocedureCode = document.getElementById("procedure").value = "";

	document.getElementById("serv").focus();
	
	window.scrollBy(0,5); 
	return true;
	



}