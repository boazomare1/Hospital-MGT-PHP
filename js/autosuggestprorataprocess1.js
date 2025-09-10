//alert ("Meow...");
/**
 * An autosuggest textbox control.
 * @class
 * @scope public
 */
function AutoSuggestControl(oTextbox /*:HTMLInputElement*/, 
                            oProvider /*:SuggestionProvider*/) {
    
   /**
     * The currently selected suggestions.
     * @scope private
     */   
    this.cur /*:int*/ = -1;

    /**
     * The dropdown list layer.
     * @scope private
     */
    this.layer = null;
    
    /**
     * Suggestion provider for the autosuggest feature.
     * @scope private.
     */
    this.provider /*:SuggestionProvider*/ = oProvider;
    
    /**
     * The textbox to capture.
     * @scope private
     */
    this.textbox /*:HTMLInputElement*/ = oTextbox;
    
    //initialize the control
    this.init();
    
}

/**
 * Autosuggests one or more suggestions for what the user has typed.
 * If no suggestions are passed in, then no autosuggest occurs.
 * @scope private
 * @param aSuggestions An array of suggestion strings.
 * @param bTypeAhead If the control should provide a type ahead suggestion.
 */
 
var xmlHttp;

AutoSuggestControl.prototype.autosuggest = function (aSuggestions /*:Array*/,
                                                     bTypeAhead /*:boolean*/) {
 
 //alert('hi');
	///*
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  	var searchsuppliername1 = document.getElementById("searchsuppliername").value;
	//var searchemployeecode1 = document.getElementById("searchemployeecode").value;
	//var searchdescription1 = document.getElementById("searchdescription").value;
	//alert(searchsuppliername1);
    if (searchsuppliername1.length < 2) 
	{
		//var searchsuppliername1 = 'xyzxyzxyzxyz'; //To hide the already populated drop list automatically.
		//return false;
	}
	
	//var varEmployeesearch = document.getElementById("employeesearch").value;
	var Assignmonth = document.getElementById("assignmonth").value;
	//alert(customersearch);
	var url = "";
	var url="autoemployeecodesearch5.php?RandomKey="+Math.random()+"&&employeesearch="+searchsuppliername1+"&&assignmonth="+Assignmonth;
   	//alert(url);
	
	//var url = "";
	//var url="ajaxjobdescription1build2.php?searchsuppliername="+searchsuppliername1+"&&RandomKey="+Math.random()+"";
    //alert(url);
	///*
	xmlHttp.onreadystatechange=function()   
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 
			//var t="$";
			var t = "";
			t=t+xmlHttp.responseText;
			//alert("Inside"+t);
			document.getElementById("searchsuppliername1hiddentextbox").value = t;
			
			//alert ("1");
		}
	}
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

	var varCompleteStringReturned = document.getElementById("searchsuppliername1hiddentextbox").value;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||^||");
	//alert(varNewLineValue);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	
	for (m=0;m<=varNewLineLength;m++)
	{
		//(varNewLineValue[m]);					
		aSuggestions.push(varNewLineValue[m]);
	}


	//make sure there's at least one suggestion
    if (aSuggestions.length > 0) {
        if (bTypeAhead) {
           this.typeAhead(aSuggestions[0]);
        }
        
        this.showSuggestions(aSuggestions);
    } else {
        this.hideSuggestions();
    }
};


function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
	// Firefox, Opera 8.0+, Safari
	xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
	// Internet Explorer
	try
	{
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e)
	{
	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	}
	return xmlHttp;
}




/**
 * Creates the dropdown layer to display multiple suggestions.
 * @scope private
 */
AutoSuggestControl.prototype.createDropDown = function () {

    var oThis = this;

    //create the layer and assign styles
    this.layer = document.createElement("div");
    this.layer.className = "suggestions";
    this.layer.style.visibility = "hidden";
    this.layer.style.width = this.textbox.offsetWidth;
    //when the user clicks on the a suggestion, get the text (innerHTML)
    //and place it into a textbox
    this.layer.onmousedown = 
    this.layer.onmouseup = 
    this.layer.onmouseover = function (oEvent) {
        oEvent = oEvent || window.event;
        oTarget = oEvent.target || oEvent.srcElement;

        if (oEvent.type == "mousedown") {
            oThis.textbox.value = oTarget.firstChild.nodeValue;
            oThis.hideSuggestions();
			
			//File called from paymententry1.php
			//Code by Prem Kumar.
			//alert ("Mouse Down."); 
			
			var varSupplierName = document.getElementById("searchsuppliername").value;
			var arrSupplierName = varSupplierName.split('||'); 
		    var varSupplierName = arrSupplierName[1];
			//alert (varSupplierName);
			//var varDescription = arrSupplierName[1];
			var varEmployeeCode = arrSupplierName[0];
			//alert (varEmployeeCode);
			//var varVisitCode = arrSupplierName[2];
			//alert (varVisitCode);
			
			//document.getElementById("searchsuppliercode").value = varSubtypeAnum;
			document.getElementById("searchsuppliername").value = varSupplierName;
			//document.getElementById("searchdescription").value = varDescription;
			document.getElementById("searchemployeecode").value = varEmployeeCode;
			
			//alert("Hello");
			suppliernamelostfocus() //Function located at the bottom of this file.
			
			
        } else if (oEvent.type == "mouseover") {
            oThis.highlightSuggestion(oTarget);
        } else {
            oThis.textbox.focus();
        }
    };
    
    
    document.body.appendChild(this.layer);
};

/**
 * Gets the left coordinate of the textbox.
 * @scope private
 * @return The left coordinate of the textbox in pixels.
 */
AutoSuggestControl.prototype.getLeft = function () /*:int*/ {

    var oNode = this.textbox;
    var iLeft = 0;
    
    while(oNode.tagName != "BODY") {
        iLeft += oNode.offsetLeft;
        oNode = oNode.offsetParent;        
    }
    
    return iLeft;
};

/**
 * Gets the top coordinate of the textbox.
 * @scope private
 * @return The top coordinate of the textbox in pixels.
 */
AutoSuggestControl.prototype.getTop = function () /*:int*/ {

    var oNode = this.textbox;
    var iTop = 0;
    
    while(oNode.tagName != "BODY") {
        iTop += oNode.offsetTop;
        oNode = oNode.offsetParent;
    }
    
    return iTop;
};

/**
 * Handles three keydown events.
 * @scope private
 * @param oEvent The event object for the keydown event.
 */
AutoSuggestControl.prototype.handleKeyDown = function (oEvent /*:Event*/) {

	switch(oEvent.keyCode) {
        case 38: //up arrow
            this.previousSuggestion();
            break;
        case 40: //down arrow 
            this.nextSuggestion();
            break;
        case 13: //enter
            this.hideSuggestions();
			//change done by premkumar.
			//alert ("13Meow...");
			
			var varSupplierName = document.getElementById("searchsuppliername").value;
			var arrSupplierName = varSupplierName.split('||'); 
			var varSupplierName = arrSupplierName[1];
			//alert (varSupplierName);
			//var varDescription = arrSupplierName[1];
			var varEmployeeCode = arrSupplierName[0];
			
			//document.getElementById("searchsuppliercode").value = varSubtypeAnum;
			document.getElementById("searchsuppliername").value = varSupplierName;
			//document.getElementById("searchdescription").value = varDescription;
			document.getElementById("searchemployeecode").value = varEmployeeCode;
			
			suppliernamelostfocus() //Function located at the bottom of this file.

			//change completed here.
            break;
        case 9: //enter
            this.hideSuggestions();
			//change done by premkumar.
			//alert ("9Meow...");
			suppliernamelostfocus()
			//change completed here.
            break;
    }

};

/**
 * Handles keyup events.
 * @scope private
 * @param oEvent The event object for the keyup event.
 */
AutoSuggestControl.prototype.handleKeyUp = function (oEvent /*:Event*/) {

    var iKeyCode = oEvent.keyCode;

    //for backspace (8) and delete (46), shows suggestions without typeahead
    if (iKeyCode == 8 || iKeyCode == 46) {
        this.provider.requestSuggestions(this, false);
        
    //make sure not to interfere with non-character keys
    } else if (iKeyCode < 32 || (iKeyCode >= 33 && iKeyCode < 46) || (iKeyCode >= 112 && iKeyCode <= 123)) {
        //ignore
    } else {
        //request suggestions from the suggestion provider with typeahead
		
		//code by premkumar. to make the characters to upper case.
		//alert ("Meow...");
		var varSupplierName = document.getElementById("searchsuppliername").value;
		//alert (varSupplierName);
		
		var varSupplierName = varSupplierName.toUpperCase();
		//alert (varSupplierName);
		document.getElementById("searchsuppliername").value = varSupplierName;
		//code end by prem.
		
        this.provider.requestSuggestions(this, true);
		
		//alert ("Meow...");
    }
};

/**
 * Hides the suggestion dropdown.
 * @scope private
 */
AutoSuggestControl.prototype.hideSuggestions = function () {
    this.layer.style.visibility = "hidden";
};

/**
 * Highlights the given node in the suggestions dropdown.
 * @scope private
 * @param oSuggestionNode The node representing a suggestion in the dropdown.
 */
AutoSuggestControl.prototype.highlightSuggestion = function (oSuggestionNode) {
    
    for (var i=0; i < this.layer.childNodes.length; i++) {
        var oNode = this.layer.childNodes[i];
        if (oNode == oSuggestionNode) {
            oNode.className = "current"
        } else if (oNode.className == "current") {
            oNode.className = "";
        }
    }
};

/**
 * Initializes the textbox with event handlers for
 * auto suggest functionality.
 * @scope private
 */
AutoSuggestControl.prototype.init = function () {

    //save a reference to this object
    var oThis = this;
    
    //assign the onkeyup event handler
    this.textbox.onkeyup = function (oEvent) {
    
        //check for the proper location of the event object
        if (!oEvent) {
            oEvent = window.event;
        }    
        
        //call the handleKeyUp() method with the event object
        oThis.handleKeyUp(oEvent);
    };
    
    //assign onkeydown event handler
    this.textbox.onkeydown = function (oEvent) {
    
        //check for the proper location of the event object
        if (!oEvent) {
            oEvent = window.event;
        }    
        //call the handleKeyDown() method with the event object
        oThis.handleKeyDown(oEvent);
    };
    
    //assign onblur event handler (hides suggestions)    
    this.textbox.onblur = function () {
        oThis.hideSuggestions();
    };
    
    //create the suggestions dropdown
    this.createDropDown();
};

/**
 * Highlights the next suggestion in the dropdown and
 * places the suggestion into the textbox.
 * @scope private
 */
AutoSuggestControl.prototype.nextSuggestion = function () {
    var cSuggestionNodes = this.layer.childNodes;

    if (cSuggestionNodes.length > 0 && this.cur < cSuggestionNodes.length-1) {
        var oNode = cSuggestionNodes[++this.cur];
        this.highlightSuggestion(oNode);
        this.textbox.value = oNode.firstChild.nodeValue; 
    }
};

/**
 * Highlights the previous suggestion in the dropdown and
 * places the suggestion into the textbox.
 * @scope private
 */
AutoSuggestControl.prototype.previousSuggestion = function () {
    var cSuggestionNodes = this.layer.childNodes;

    if (cSuggestionNodes.length > 0 && this.cur > 0) {
        var oNode = cSuggestionNodes[--this.cur];
        this.highlightSuggestion(oNode);
        this.textbox.value = oNode.firstChild.nodeValue;   
    }
};

/**
 * Selects a range of text in the textbox.
 * @scope public
 * @param iStart The start index (base 0) of the selection.
 * @param iLength The number of characters to select.
 */
AutoSuggestControl.prototype.selectRange = function (iStart /*:int*/, iLength /*:int*/) {

    //use text ranges for Internet Explorer
    if (this.textbox.createTextRange) {
        var oRange = this.textbox.createTextRange(); 
        oRange.moveStart("character", iStart); 
        oRange.moveEnd("character", iLength - this.textbox.value.length);      
        oRange.select();
        
    //use setSelectionRange() for Mozilla
    } else if (this.textbox.setSelectionRange) {
        this.textbox.setSelectionRange(iStart, iLength);
    }     

    //set focus back to the textbox
    this.textbox.focus();      
}; 

/**
 * Builds the suggestion layer contents, moves it into position,
 * and displays the layer.
 * @scope private
 * @param aSuggestions An array of suggestions for the control.
 */
AutoSuggestControl.prototype.showSuggestions = function (aSuggestions /*:Array*/) {
    
    var oDiv = null;
    this.layer.innerHTML = "";  //clear contents of the layer
    
    for (var i=0; i < aSuggestions.length; i++) {
        oDiv = document.createElement("div");
        oDiv.appendChild(document.createTextNode(aSuggestions[i]));
        this.layer.appendChild(oDiv);
    }
    
    this.layer.style.left = this.getLeft() + "px";
    this.layer.style.top = (this.getTop()+this.textbox.offsetHeight) + "px";
    this.layer.style.visibility = "visible";

};

/**
 * Inserts a suggestion into the textbox, highlighting the 
 * suggested part of the text.
 * @scope private
 * @param sSuggestion The suggestion for the textbox.
 */
AutoSuggestControl.prototype.typeAhead = function (sSuggestion /*:String*/) {

    //check for support of typeahead functionality
    if (this.textbox.createTextRange || this.textbox.setSelectionRange){
        var iLen = this.textbox.value.length; 
		
		//COMMENTED BY PREM THESE TWO LINES AUTO COMPLETES THE TEXT BOX.
        //this.textbox.value = sSuggestion; //COMMENTED BY PREM
        //this.selectRange(iLen, sSuggestion.length); //COMMENTED BY PREM
	
    }
};


function suppliernamelostfocus()
{
	//alert ("you pressed a key.");
	var varEmployeeName = document.getElementById("searchsuppliername").value;
	//alert (varSupplierName);
	var varEmployeecode = document.getElementById("searchemployeecode").value;
	
			//var m = parseInt(m);
			var k = document.getElementById("serialno").value;
			var k = parseInt(k);
			//alert (k);
			//var tr = document.createElement ('<TR id="idTR'+k+'"></TR>');
			var tr = document.createElement ('TR');
			tr.id = "idTR"+k+"";
			tr.value = k+'||'+varEmployeecode;
			tr.onclick = function() { TrSelect(this.value); }
			//tr.onmouseover = function() { TrBgcolor(this.value); }
			//tr.onmouseout = function() { TRremovecolor(this.value); }
			//var td1 = document.createElement ('<td id="idTD1'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td1 = document.createElement ('td');
			td1.id = "idTD1"+k+"";
			td1.align = "left";
			td1.valign = "top";
			td1.style.backgroundColor = "#FFFFFF";
			td1.style.border = "0px solid #F3F3F3";
			//var text1 = document.createElement ('<input value="'+k+'" name="serialnumber'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="3">');
			var text1 = document.createElement ('input');
			text1.id = "empserialnumber"+k+"";
			text1.name = "empserialnumber"+k+"";
			text1.type = "checkbox";
			text1.size = "1";
			text1.value = k+'||'+varEmployeecode;
			//text1.readOnly = "readonly";
			text1.checked = "checked";
			text1.style.backgroundColor = "#FFFFFF";
			text1.style.border = "0px solid #001E6A";
			text1.style.textAlign = "center";
			text1.style.fontSize = "12";
			text1.onclick = function() { return TrSelect(this.value); }
			td1.appendChild (text1);
			tr.appendChild (td1);


			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td2 = document.createElement ('td');
			td2.id = "idTD2"+k+"";
			td2.align = "left";
			td2.valign = "top";
			td2.style.backgroundColor = "#FFFFFF";
			td2.style.border = "0px solid #F3F3F3";
			//var text2 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="12">');
			var text2 = document.createElement ('input');
			text2.id = "employeecode"+k+"";
			text2.name = "employeecode"+k+"";
			text2.type = "text";
			text2.size = "12";
			text2.value = varEmployeecode;
			text2.readOnly = "readonly";
			text2.style.backgroundColor = "#FFFFFF";
			text2.style.border = "0px solid #001E6A";
			text2.style.textAlign = "left";
			text2.style.fontSize = "12";
			td2.appendChild (text2);
			tr.appendChild (td2);

			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td3 = document.createElement ('td');
			td3.id = "idTD3"+k+"";
			td3.align = "left";
			td3.valign = "top";
			td3.style.backgroundColor = "#FFFFFF";
			td3.style.border = "0px solid #F3F3F3";
			//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
			var text3 = document.createElement ('input');
			text3.id = "employeename"+k+"";
			text3.name = "employeename"+k+"";
			text3.type = "text";
			text3.size = "30";
			text3.value = varEmployeeName;
			text3.readOnly = "readonly";
			text3.style.backgroundColor = "#FFFFFF";
			text3.style.border = "0px solid #001E6A";
			text3.style.textAlign = "left";
			text3.style.fontSize = "12";
			td3.appendChild (text3);
			tr.appendChild (td3);
			
			//var td2 = document.createElement ('<td id="idTD2'+k+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
			var td4 = document.createElement ('td');
			td4.id = "idTD4"+k+"";
			td4.align = "left";
			td4.valign = "top";
			td4.style.backgroundColor = "#FFFFFF";
			td4.style.border = "0px solid #F3F3F3";
			//var text3 = document.createElement ('<input value="'+varCustomerCode1+'" name="customercode'+k+'" readonly="readonly" style="border: 0px;font-size:8pt" size="13">');
			var text4 = document.createElement ('input');
			text4.id = "del"+k+"";
			text4.name = "del"+k+"";
			text4.type = "button";
			text4.size = "1";
			text4.value = "X";
			text4.readOnly = "readonly";
			text4.style.backgroundColor = "#FFFFFF";
			text4.style.color = "#FF0000";
			text4.style.border = "0px solid #001E6A";
			text4.style.textAlign = "left";
			text4.style.fontSize = "12";
			text4.onclick = function() { return DeleteTR(this.id); }
			td4.appendChild (text4);
			tr.appendChild (td4);
			
			document.getElementById ('tblrowinsert').appendChild (tr);
			
			document.getElementById("serialno").value = k + 1;
			document.getElementById("searchsuppliername").value = "";
		
	
}

function DeleteTR(TRid)
{
	var TRid = TRid;
	var k = TRid.substr(3,5);
	var fRet4; 
	 fRet4 = confirm('Are You Sure Want To Delete This Employee?'); 
	 //alert(fRet4); 
	 if (fRet4 == false)
	 {
	  //alert ("Item Entry Not Deleted.");
	  return false;
	 }
	 
	 var child1 = document.getElementById('idTR'+k); //tr name
	 var parent1 = document.getElementById('tblrowinsert'); // tbody name.
	 document.getElementById ('tblrowinsert').removeChild(child1); 
	 
	 for(var j = document.getElementById("tblrowinsert1").rows.length; j > 0;j--)
	 {
		document.getElementById("tblrowinsert1").deleteRow(j -1);
	 }
	 
	 document.getElementById ('grosspay').value = "";
	 document.getElementById ('totaldeductions').value = "";
	 document.getElementById ('nettpay').value = "";
	
	 
}
