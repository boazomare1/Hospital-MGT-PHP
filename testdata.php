<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<input name="submit" value="submit" onClick="compile(); validate(this.form); return document.formSubmit;" type="button">
<script>
function validate(form){
var error = "";
//for each form element
for(var i=0; i<form.length; i++){
var element = form[i];
//if required
if(element.getAttribute("required") == "yes"){
//if form element if empty
if(!valid(element.value,element.getAttribute("vali date"),element))
error += element.getAttribute("message") + "\r\n";	
}
}
if(error != ""){
alert(error);
document.formSubmit = false;
}
else
document.formSubmit = true;
}	

function valid(value,type,element){
if(value == "")
return false;

switch(type){
case "int":
if(isNaN(parseInt(value)))
return false;
break;
case "float":
if(isNaN(parseFloat(value)))
return false;
break;
case "email":
var p = value.indexOf('@');
if(p<1 || p==(value.length-1))
return false;
break;
case "checked":
if(!element.checked)
return false;
break;
default://string
break;
}
return true;
}

//gather information
//pass on to "kontakta_print.html". 
function compile() {
var falt = escape(document.form1.fornamn.value) + "&" +
escape(document.form1.efternamn.value) + "&" +
escape(document.form1.gatuadress.value) + "&" +
escape(document.form1.postnummer.value) + "&" +
escape(document.form1.postort.value) + "&" +
escape(document.form1.tfnnummer.value) + "&" +
escape(document.form1.epost.value) + "&" +
escape(document.form1.meddelande.value);
location.href = "kontakta_print.html?" + falt;
}

//get information from previous form
function getInfo() {
var find = location.search;
var get = find.substring(1);
var lista = get.split("&");
lista[0] = unescape(lista[0]);	
return lista;
}

//funtion for printout
function skrivUt() {
var skriv = getInfo();
document.write("<p><b>F&ouml;rnamn: </b>" + skriv[0] + "<p>");
document.write("<p><b>Efternamn: </b>" + skriv[1] + "<p>");
document.write("<p><b>Adress: </b>" + skriv[2] + "<p>");
document.write("<p><b>Postnummer: </b>" + skriv[3] + "<p>");
document.write("<p><b>Postort: </b>" + skriv[4] + "<p>");
document.write("<p><b>Telefonnummer: </b>" + skriv[5] + "<p>");
document.write("<p><b>E-post: </b>" + skriv[6] + "<p>");
for (var i=0; i<skriv.length; i++)
document.write("<input type='hidden' name='input'" + i + "' value='" +skriv[i] + "' />");
}
</body>
</html>
