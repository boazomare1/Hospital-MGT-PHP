<?php
//session_start();
include ("db/db_connect.php");
?>
<script>
function StateSuggestionspharm4() {

//alert(document.getElementById("medicinename").value);

if(document.getElementById("medicinename").value !="")
{
var varmedicinenamesearch = document.getElementById("medicinename").value;
		//alert (varmedicinesearch);
		var varmedicinenamesearchLen = varmedicinenamesearch.length;
		//alert (varmedicinesearchLen);
		if (varmedicinenamesearchLen > 1)
		{
			ajaxprocessACCS56();		
		}
}
}
var xmlHttp

function ajaxprocessACCS56()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return false;
	} 
  
  	var medicinenamesearch = document.getElementById("medicinename").value;
	
//alert(medicinenamesearch);
	
	//alert(medicinesearch);
	var url = "";
	var url="automedicinenamesearchtesting.php?RandomKey="+Math.random()+"&&medicinenamesearch="+medicinenamesearch;
    //alert(url);

	xmlHttp.onreadystatechange=StateSuggestions4
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 
function StateSuggestions4() {

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	var u = "";
	u=u+xmlHttp.responseText;
	//alert(u);
this.states = 
[u];
}
}

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

StateSuggestions4.prototype.requestSuggestions = function (AutoSuggestControl4 /*:AutoSuggestControl4*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl4.textbox.value;
    //alert (sTextboxValue);
 	var loopLength = 0;

    if (sTextboxValue.length > 0){
    
	var sTextboxValue = sTextboxValue.toUpperCase();

        //search for matching states
        for (var i=0; i < this.states.length; i++) 
		{ 
            if (this.states[i].indexOf(sTextboxValue) >= 0) 
			{
                loopLength = loopLength + 1;
				if (loopLength <= 15) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

    //provide suggestions to the control
    AutoSuggestControl4.autosuggest(aSuggestions, bTypeAhead);
}


</script>