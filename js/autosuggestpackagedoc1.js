//alert ("Meow...");
/**
 * An autosuggest textbox control.
 * @class
 * @scope public
 */
function AutoSuggestControlcustomer1(oTextbox /*:HTMLInputElement*/, 
                            oProvider /*:SuggestionProvider*/) {//alert(keyval);
							
							//document.getElementById("keyforahpl").value=keyval;
    //alert("hi"); 
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

AutoSuggestControlcustomer1.prototype.autosuggest = function (aSuggestions /*:Array*/,
                                                     bTypeAhead /*:boolean*/) {  
													 
													 //alert(document.getElementById("keyforahpl").value);
													 
													var oTextbox1=document.getElementById("pvtdoctor2").value;
													// alert(oTextbox1);
    
//alert('hi');
	///*
	if(oTextbox1!=''){
		alert('Please Select Either Hospital Doctor (or) Private Doctor');
		document.getElementById("pvtdoctor2").value='';
		document.getElementById("pvtdoctorcode2").value = '';
		document.getElementById("pvtdoctorrate2").value = '';
		return false;
		}
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  	var customer = document.getElementById("hpldoctor2").value;
	var location = document.getElementById("location").value;
	
	//alert(customer);
    if (customer.length < 2) 
	{
		var customer = 'xyzxyzxyzxyz'; //To hide the already populated drop list automatically.
		//return false;
	}
	//alert(customer);alert(location);
	
	var url = "";
	var url="ajaxdoctorpackage.php?customer="+customer+"&&location="+location+"&&RandomKey="+Math.random()+"";
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
			document.getElementById("customerhiddentextbox").value = t;
			
			//alert ("1");
		}
	}
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

	var varCompleteStringReturned = document.getElementById("customerhiddentextbox").value;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split(",");
	//alert(varNewLineValue);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	
	for (m=0;m<=varNewLineLength;m++)
	{
		//alert (varNewLineValue[m]);					
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
AutoSuggestControlcustomer1.prototype.createDropDown = function () { 

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
			
			
			var varSupplierName = document.getElementById("hpldoctor2").value;
			
			var arrSupplierName = varSupplierName.split('#'); 
		
			var vardoctorcode = arrSupplierName[0];
			var vardoctorname = arrSupplierName[1];
			var vardoctorrate = arrSupplierName[2];
			
			//alert (varSupplierName);
			var varconsultation = arrSupplierName[3];
			//var varpkgname = arrSupplierName[4];
			//var varpkgid = arrSupplierName[5];
			//var varpkgamount = arrSupplierName[6];
			
			//alert (varSupplierName);
			document.getElementById("hpldoctor2").value = vardoctorname;
			//document.getElementById("patientcode").value = varcustomercode;
			//document.getElementById("accountnamename").value = varaccountname;
			
			
				
				
			//document.getElementById("ptname").value = varcustomerfullname;
			document.getElementById("hpldoctorcode2").value = vardoctorcode;
			document.getElementById("hpldoctorrate2").value = vardoctorrate;
			
			calculateamount();
			//document.getElementById("packg").value = varpkgname;
			//document.getElementById("costpkg").value = varpkgamount;
			//alert('ok');
			//document.getElementById("AutoNumber33").style.display="block";
			//funcCustomerSearch2();
			//alert(varaccountname);
			//funcmedicinesearch4();
			//suppliernamelostfocus() //Function located at the bottom of this file.
			
			
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
AutoSuggestControlcustomer1.prototype.getLeft = function () /*:int*/ {

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
AutoSuggestControlcustomer1.prototype.getTop = function () /*:int*/ {

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
AutoSuggestControlcustomer1.prototype.handleKeyDown = function (oEvent /*:Event*/) {

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
			var varSupplierName = document.getElementById("hpldoctor2").value;
			
			var arrSupplierName = varSupplierName.split('#'); 
		
			var vardoctorcode = arrSupplierName[0];
			var vardoctorname = arrSupplierName[1];
			var vardoctorrate = arrSupplierName[2];
			
			//alert (varSupplierName);
			var varconsultation = arrSupplierName[3];
			//var varpkgname = arrSupplierName[4];
			//var varpkgid = arrSupplierName[5];
			//var varpkgamount = arrSupplierName[6];
			
			//alert (varSupplierName);
			document.getElementById("hpldoctor2").value = vardoctorname;
			//document.getElementById("patientcode").value = varcustomercode;
			//document.getElementById("accountnamename").value = varaccountname;
			
			
				
				
			//document.getElementById("ptname").value = varcustomerfullname;
			document.getElementById("hpldoctorcode2").value = vardoctorcode;
			document.getElementById("hpldoctorrate2").value = vardoctorrate;
			//document.getElementById("pkgaction").value = varcustomerfullname;
			
			
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
AutoSuggestControlcustomer1.prototype.handleKeyUp = function (oEvent /*:Event*/) {

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
		var varSupplierName = document.getElementById("hpldoctor2").value;
		//alert (varSupplierName);
		
		var varSupplierName = varSupplierName.toUpperCase();
		//alert (varSupplierName);
		document.getElementById("hpldoctor2").value = varSupplierName;
		//code end by prem.
		
        this.provider.requestSuggestions(this, true);
		
		//alert ("Meow...");
    }
};

/**
 * Hides the suggestion dropdown.
 * @scope private
 */
AutoSuggestControlcustomer1.prototype.hideSuggestions = function () {
    this.layer.style.visibility = "hidden";
};

/**
 * Highlights the given node in the suggestions dropdown.
 * @scope private
 * @param oSuggestionNode The node representing a suggestion in the dropdown.
 */
AutoSuggestControlcustomer1.prototype.highlightSuggestion = function (oSuggestionNode) {
    
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
AutoSuggestControlcustomer1.prototype.init = function () {

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
AutoSuggestControlcustomer1.prototype.nextSuggestion = function () {
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
AutoSuggestControlcustomer1.prototype.previousSuggestion = function () {
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
AutoSuggestControlcustomer1.prototype.selectRange = function (iStart /*:int*/, iLength /*:int*/) {

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
AutoSuggestControlcustomer1.prototype.showSuggestions = function (aSuggestions /*:Array*/) {
    
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
AutoSuggestControlcustomer1.prototype.typeAhead = function (sSuggestion /*:String*/) {

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
	        var varSupplierName = document.getElementById("hpldoctor2").value;
			
			var arrSupplierName = varSupplierName.split('#'); 
		
			var vardoctorcode = arrSupplierName[0];
			var vardoctorname = arrSupplierName[1];
			var vardoctorrate = arrSupplierName[2];
			
			//alert (varSupplierName);
			var varconsultation = arrSupplierName[3];
			//var varpkgname = arrSupplierName[4];
			//var varpkgid = arrSupplierName[5];
			//var varpkgamount = arrSupplierName[6];
			
			//alert (varSupplierName);
			document.getElementById("hpldoctor2").value = vardoctorname;
			//document.getElementById("patientcode").value = varcustomercode;
			//document.getElementById("accountnamename").value = varaccountname;
			
			
				
				
			//document.getElementById("ptname").value = varcustomerfullname;
			document.getElementById("hpldoctorcode2").value = vardoctorcode;
			document.getElementById("hpldoctorrate2").value = vardoctorrate;
			
		
			
			
	if (vardisease != undefined)
	{
		document.getElementById("hpldoctor2").value = vardoctorname;
			//document.getElementById("patientcode").value = varcustomercode;
			//document.getElementById("accountnamename").value = varaccountname;
			
			
				
				
			//document.getElementById("ptname").value = varcustomerfullname;
			document.getElementById("hpldoctorcode2").value = vardoctorcode;
			document.getElementById("hpldoctorrate2").value = vardoctorrate;
		
	}
	else
	{
			document.getElementById("hpldoctor2").value = vardoctorname;
			//document.getElementById("patientcode").value = varcustomercode;
			//document.getElementById("accountnamename").value = varaccountname;
			
			
				
				
			//document.getElementById("ptname").value = varcustomerfullname;
			document.getElementById("hpldoctorcode2").value = vardoctorcode;
			document.getElementById("hpldoctorrate2").value = vardoctorrate;
			
	}
	
}

