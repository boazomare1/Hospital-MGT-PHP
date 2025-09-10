<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
//print_r($_SESSION);
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

$res1location = $res1["locationname"];
$res1locationanum = $res1["locationcode"];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["locationcode"])) {  $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{

//$servicesPackage = $_REQUEST['packageName'];
$packageid = $_REQUEST['packageid'];
$consultation_amt = $_REQUEST['consultationamt'];
$package_item_type = $_REQUEST['packageType'];
//$packagename = $_REQUEST['package'];
//if(isset($_POST['Submitp'])){

//if(isset($_POST['Submit'])){	

$serial4 = $_REQUEST['serialnumbers'];
$number4 = $serial4 ;

for ($p=1;$p<=$number4;$p++)
{
if($number4==$p){
$sername=$_REQUEST['sername'];
$sercode=$_REQUEST['sercode'];
$serrate=$_REQUEST['serrate'];
$serqty=$_REQUEST['serqty'];
$seramt=$_REQUEST['seramt'];
}else{	   
$sername=$_REQUEST['sername'.$p];
$sername=trim($sername);
/*$query77="select itemcode from master_medicine where itemname='$medicinename'";
$exec77=mysql_query($query77);
$num77=mysql_num_rows($exec77);
echo $num77;
$res77=mysql_fetch_array($exec77);
$medicinecode=$res77['itemcode'];*/
$sercode=$_REQUEST['sercode'.$p];
$serrate=$_REQUEST['serrate'.$p];
$serqty=$_REQUEST['serqty'.$p];
$seramt=$_REQUEST['seramt'.$p];
}
if($sername!="")
{
$package_type ='SI';
$serquery2="insert into package_items (package_id,itemcode, itemname,username, ipaddress,rate,locationname,locationcode,quantity,package_type,amount,package_item_type)
values ('$packageid','$sercode', '$sername','$username', '$ipaddress','$serrate','$res1location','$res1locationanum','$serqty','$package_type','$seramt','$package_item_type')";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $serquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


}
$serial1 = $_REQUEST['serialnumberp'];
$number1 = $serial1 ;
for ($p=1;$p<=$number1;$p++)
{
if($number1==$p){
$medicinename=$_REQUEST['medicinename'];
$medicinecode=$_REQUEST['medicinecode'];
$pharmarate=$_REQUEST['pharmarate'];
$dose=$_REQUEST['dose'];
$dosemeasure=$_REQUEST['dosemeasure'];
$frequency=$_REQUEST['frequency'];
//$route=$_REQUEST['route'];
//$pharinstuct=$_REQUEST['pharinstuct'];
$pharmaamt=$_REQUEST['pharmaamt'];
$days=$_REQUEST['days'];
$pharmaqty=$_REQUEST['pharmaqty'];

}else{		   
$medicinename=$_REQUEST['medicinename'.$p];
$medicinename=trim($medicinename);


$medicinecode=$_REQUEST['medicinecode'.$p];

$pharmarate=$_REQUEST['pharmarate'.$p];
$dose=$_REQUEST['dose'.$p];
$dosemeasure=$_REQUEST['dosemeasure'.$p];
$frequency=$_REQUEST['frequency'.$p];
//$route=$_REQUEST['route'.$p];
//$pharinstuct=$_REQUEST['pharinstuct'.$p];
$pharmaamt=$_REQUEST['pharmaamt'.$p];
$days=$_REQUEST['days'.$p];
$pharmaqty=$_REQUEST['pharmaqty'.$p];
}

if($medicinename!="")
{
$package_type ='MI';
$medicinequery2="insert into package_items (package_id, itemcode, itemname, username, ipaddress,rate,locationname,locationcode,dose,dosemeasure,frequency,days,quantity,package_type,amount,package_item_type)
values ('$packageid','$medicinecode', '$medicinename','$username', '$ipaddress','$pharmarate','$res1location','$res1locationanum','$dose','$dosemeasure','$frequency','$days',$pharmaqty,'$package_type','$pharmaamt','$package_item_type')";

$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


}
$serial2 = $_REQUEST['serialnumberl'];
$number2 = $serial2 ;
for ($p=1;$p<=$number2;$p++)
{
if($number2==$p){
$labname=$_REQUEST['labname'];
$labcode=$_REQUEST['labcode'];
$labrate=$_REQUEST['labrate'];
}else{				   
$labname=$_REQUEST['labname'.$p];
$labname=trim($labname);


$labcode=$_REQUEST['labcode'.$p];

$labrate=$_REQUEST['labrate'.$p];
}


if($labname!="")
{
$package_type ='LI';
$labquery2="insert into package_items (package_id, itemcode, itemname,username, ipaddress,rate,locationname,locationcode,package_type,amount,package_item_type)
values ('$packageid','$labcode', '$labname','$username', '$ipaddress','$labrate','$res1location','$res1locationanum','$package_type','$labrate','$package_item_type')";

$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $labquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


}
$serial3 = $_REQUEST['serialnumberr'];
$number3 = $serial3 ;
for ($p=1;$p<=$number3;$p++)
{
if($number3==$p){
$radname=$_REQUEST['radname'];
$radcode=$_REQUEST['radcode'];
$radrate=$_REQUEST['radrate'];
//$radinstuct=$_REQUEST['radinstuct'];
}else{			   
$radname=$_REQUEST['radname'.$p];
$radname=trim($radname);


$radcode=$_REQUEST['radcode'.$p];

$radrate=$_REQUEST['radrate'.$p];
//$radinstuct=$_REQUEST['radinstuct'.$p];
}


if($radname!="")
{
$package_type ='RI';
$radquery2="insert into package_items (package_id,itemcode, itemname,username, ipaddress,rate,locationname,locationcode,package_type,amount,package_item_type)
values ('$packageid','$radcode', '$radname','$username', '$ipaddress','$radrate','$res1location','$res1locationanum','$package_type','$radrate','$package_item_type')";

$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $radquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


}
$package_type ='CT';
$conquery="insert into package_items (package_id,itemcode, itemname,username, ipaddress,rate,locationname,locationcode,package_type,amount,package_item_type)
values ('$packageid','', '','$username', '$ipaddress','$consultation_amt','$res1location','$res1locationanum','$package_type','$consultation_amt','$package_item_type')";
$execcon=mysqli_query($GLOBALS["___mysqli_ston"], $conquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//}
header("location:packageitems.php");
}
?>
<?php
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];
$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];
$res7storeanum = $res23['store'];
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
?>
<script>
function funcOnLoadBodyFunctionCall()
{
//funcCustomerDropDownSearch4();
//funcCustomerDropDownSearch3();


}
function btnDeleteClick10(delID)
{
//alert ("Inside btnDeleteClick.");

//alert(pharmamount);
var varDeleteID = delID;
//alert (varDeleteID);
var fRet3; 
fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
//alert(fRet); 
if (fRet3 == false)
{
//alert ("Item Entry Not Deleted.");
return false;
}
var child = document.getElementById('idTR'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow1'); // tbody name.
document.getElementById ('insertrow1').removeChild(child);

var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow1'); // tbody name.
//alert (child);
if (child != null) 
{
//alert ("Row Exsits.");
document.getElementById ('insertrow1').removeChild(child);




}

var classname = 'pharmacalamt';
var id = 'mi_items_subtotal';
calculate_items_total(classname,id);
}
function btnDeleteClick12(delID)
{
//alert ("Inside btnDeleteClick.");

//alert(pharmamount);
var varDeleteID = delID;
//alert (varDeleteID);
var fRet3; 
fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
//alert(fRet); 
if (fRet3 == false)
{
//alert ("Item Entry Not Deleted.");
return false;
}
var child = document.getElementById('idlabTR'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow2'); // tbody name.
document.getElementById ('insertrow2').removeChild(child);

var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow2'); // tbody name.
//alert (child);
if (child != null) 
{
//alert ("Row Exsits.");
document.getElementById ('insertrow2').removeChild(child);



}
var classname = 'labcalrate';
var id = 'li_items_subtotal';
calculate_items_total(classname,id);
}
function btnDeleteClick13(delID)
{
//alert ("Inside btnDeleteClick.");

//alert(pharmamount);
var varDeleteID = delID;
//alert (varDeleteID);
var fRet3; 
fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
//alert(fRet); 
if (fRet3 == false)
{
//alert ("Item Entry Not Deleted.");
return false;
}
var child = document.getElementById('idradTR'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow3'); // tbody name.
document.getElementById ('insertrow3').removeChild(child);

var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow3'); // tbody name.
//alert (child);
if (child != null) 
{
//alert ("Row Exsits.");
document.getElementById ('insertrow3').removeChild(child);


}
var classname = 'radcalrate';
var id = 'ri_items_subtotal';
calculate_items_total(classname,id);
}
function btnDeleteClick14(delID)
{
//console.log("Inside btnDeleteClick.");

//alert(pharmamount);
var varDeleteID = delID;
//alert (varDeleteID);
var fRet3; 
fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
//alert(fRet); 
if (fRet3 == false)
{
//alert ("Item Entry Not Deleted.");
return false;
}
var child = document.getElementById('idserTR'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow4'); // tbody name.
document.getElementById ('insertrow4').removeChild(child);

var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
var parent = document.getElementById('insertrow4'); // tbody name.
//alert (child);
if (child != null) 
{
//alert ("Row Exsits.");
document.getElementById ('insertrow4').removeChild(child);


}
var classname = 'sercalamt';
var id = 'si_items_subtotal';
calculate_items_total(classname,id);
}
function calculate_items_total(classname,id){
// Calculate Sub Total for all items
var sum = 0;
$("."+classname).each(function()
{
sum += parseFloat($(this).find("input").val());
});
$('#'+id).html('');
$('#'+id).html(formatMoney(sum.toFixed(2)));
$('#'+id+'_val').val(sum);
calculate_items_grand_total();
calculate_package_variance();
}
function calculate_items_grand_total(){

// $('#'+id).html(formatMoney(sum.toFixed(2)));
var si_items_subtotal_val = $('#si_items_subtotal_val').val();
var mi_items_subtotal_val = $('#mi_items_subtotal_val').val();
var li_items_subtotal_val = $('#li_items_subtotal_val').val();
var ri_items_subtotal_val = $('#ri_items_subtotal_val').val();
var package_grand_total = parseFloat(si_items_subtotal_val) + parseFloat(mi_items_subtotal_val) + parseFloat(li_items_subtotal_val) + parseFloat(ri_items_subtotal_val);
$('#package_grand_total').html(formatMoney(package_grand_total.toFixed(2)));// Grand total for all items category
$('#package_grand_total_val').val(package_grand_total);
}
function calculate_package_variance()
{
var package_amt            =  $('#packageamtval').val();
var package_grandtotal_amt =  $('#package_grand_total_val').val();
var package_variance_amt   =  parseFloat(package_amt) - parseFloat(package_grandtotal_amt);
$('#package_variance_amt').html(formatMoney(package_variance_amt.toFixed(2)));
$('#package_variance_amt_val').val(package_variance_amt);
}
</script>
<script>
function medicinecheck()
{
if(document.getElementById('packageid').value=='')
{
alert("Please select the package");
document.cbform1.package.focus();
return false;
}
if(document.getElementById('package_exists').value==1)
{
alert("Package already exists");
document.cbform1.package.focus();
return false;
}
}
</script>
<!--<<link href="css/bootstrap.min.css" rel="stylesheet">-->
<style type="text/css">
<!--
body {
margin-left: 0px;
margin-top: 0px;
background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->

</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<script>
function hidePackageInfo()
{
$('#packageamttd').hide();
$('#packagedaystd').hide();
}
function showPackageInfo()
{
$('#packageamttd').show();
$('#packagedaystd').show();
}
$(document).ready(function() {
// hide Package Amount and Package Days until Package is selected
hidePackageInfo();
/*$('#package').autocomplete({

source:'ajaxippackagesearch.php', 
//alert(source);
minLength:3,
delay: 0,
html: true, 
select: function(event,ui){
var anum = ui.item.anum;
var value = ui.item.value;
$('#packageid').val(anum);
showPackageInfo();
funcpackageChange();
},
});*/
$('#package').autocomplete({
source:'ajaxippackagesearch.php', 
select: function(event,ui){
var anum = ui.item.anum;
var value = ui.item.value;
$('#packageid').val(anum);
showPackageInfo();
funcpackageChange();
},
html: true
});
$('#services').autocomplete({

source:'ajaxhealthcaresearch.php', 
//alert(source);
minLength:1,
delay: 0,
html: true, 
select: function(event,ui){
var servicescode = ui.item.itemcode;
var varservicesname = ui.item.itemname;
$('#servicescode').val(servicescode);
$('#hiddenservices').val(varservicesname);
//funcservicessearch7();
},
});

$('#medicinename').autocomplete({

source:'ajaxhealthcaremedicinesearch.php?loc=<?= $res1locationanum ?>', 
//alert(source);
minLength:1,
delay: 0,
html: true, 
select: function(event,ui){
var medicinecode = ui.item.itemcode;
var varmedicinename = ui.item.value;
var varmedicinerate = ui.item.rate;
$('#medicinecode').val(medicinecode);
$('#searchmedicineanum1').val(medicinecode);
$('#searchmedicinename1hiddentextbox').val(varmedicinename);
$('#pharmarate').val(varmedicinerate);
$('#exclude').val(ui.item.exclude);
$('#formula').val(ui.item.formula);
$('#strength').val(ui.item.strength);
$('#dose').val('');
$('#dosemeasure').val('');
$('#frequency').val('');
$('#days').val('');
$('#pharmaqty').val('');
//$('#pharinstuct').val('');
$('#pharmaamt').val('');
//funcservicessearch7();
},

})
.focusout(function() {
if($('#medicinename').val()!= $('#searchmedicinename1hiddentextbox').val())
{
$('#medicinecode').val('');
}
});

$('#labname').autocomplete({

source:'ajaxhealthcarelabsearch.php', 
//alert(source);
minLength:1,
delay: 0,
html: true, 
select: function(event,ui){
var labcode = ui.item.itemcode;
var varlabname = ui.item.value;
var varlabrate = ui.item.rate;
$('#labcode').val(labcode);
$('#searchlabnum1').val(labcode);
$('#searchlab1hiddentextbox').val(varlabname);
$('#labrate').val(varlabrate);
//funcservicessearch7();
},

})
.focusout(function() {
if($('#labname').val()!= $('#searchlab1hiddentextbox').val())
{
$('#labcode').val('');
}
});
$('#radname').autocomplete({
source:'ajaxhealthcareradsearch.php', 
//alert(source);
minLength:1,
delay: 0,
html: true, 
select: function(event,ui){
var radcode = ui.item.itemcode;
var varradname = ui.item.value;
var varradrate = ui.item.rate;
$('#radcode').val(radcode);
$('#searchradnum1').val(radcode);
$('#searchrad1hiddentextbox').val(varradname);
$('#radrate').val(varradrate);
//$('#radinstuct').val('');
//funcservicessearch7();
},

})
.focusout(function() {
if($('#radname').val()!= $('#searchrad1hiddentextbox').val())
{
$('#radcode').val('');
}
});
$('#sername').autocomplete({

source:'ajaxhealthcaresersearch.php', 
//alert(source);
minLength:1,
delay: 0,
html: true, 
select: function(event,ui){
var sercode = ui.item.itemcode;
var varsername = ui.item.value;
var varserrate = ui.item.rate;
$('#sercode').val(sercode);
$('#searchseranum1').val(sercode);
$('#searchser1hiddentextbox').val(varsername);
$('#serrate').val(varserrate);
$('#seramt').val('');
$('#serqty').val('');
//funcservicessearch7();
},

})
.focusout(function() {
if($('#sername').val()!= $('#searchser1hiddentextbox').val())
{
$('#sercode').val('');
}
});

$('.decimalnumber').keypress(function (event) {
return isNumber(event, this)
});
});
function isNumber(evt, element) {
var charCode = (evt.which) ? evt.which : event.keyCode
if (
//(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
(charCode < 48 || charCode > 57))
return false;
return true;
} 
function funcpackageChange()
{
//alert();
dataString = "packageid="+ $('#packageid').val()+"&&locationcode="+$('#locationcode').val();
$.ajax({
type:"POST",
url:"ajax/getpackageinfo.php",
data:dataString,
cache: true,
success: function(resdata)
{
//var data = resdata;
var res = resdata.split("||");
var rate = res[0];
var days = res[1];
var package_cnt = res[2];
if(package_cnt > 0)
{
alert('This package is already linked with Items');
$('#package_exists').val(1);
}
else
{
$('#package_exists').val(0);
}
/* console.log(rate)
console.log(days)*/
//$("#packcharge").empty().append(html);
/*$("#packageamt").val(rate);
$("#packagedays").val(days);*/
$("#packageamt").html(formatMoney(rate));//aaa
$("#packagedays").html(days);
$("#packageamtval").val(rate);
//	alert(html);
}
});
}
function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
var  varFrequency = document.getElementById("frequency").value;
var frequencyanum;
if(varFrequency==1 || varFrequency=='OD')
{
frequencyanum='1';
}else if(varFrequency==2 || varFrequency=='BD')
{
frequencyanum='2';
}else if(varFrequency==3 || varFrequency=='TID')
{
frequencyanum='3';
}else if(varFrequency==4 || varFrequency=='QID')
{
frequencyanum='4';
}else if(varFrequency==5 || varFrequency=='NOCTE')
{
frequencyanum='5';
}else if(varFrequency==6 || varFrequency=='PRN')
{
frequencyanum='6';
}
if(formula == 'INCREMENT')
{
var ResultFrequency;

var medicinedose=document.getElementById("dose").value;
var VarDays = document.getElementById("days").value; 

if((frequencyanum != '') && (VarDays != ''))
{
ResultFrequency = medicinedose*frequencyanum * VarDays;
}
else
{
ResultFrequency =0;
}
document.getElementById("pharmaqty").value = ResultFrequency;
var VarRate  = document.getElementById("pharmarate").value;
var ResultAmount = parseFloat(VarRate) * parseFloat(ResultFrequency);
document.getElementById("pharmaamt").value = ResultAmount.toFixed(2);

}
else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
//var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
var VarDays = document.getElementById("days").value; 

if((frequencyanum != '') && (VarDays != ''))
{
ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
}
else
{
ResultFrequency =0;
}
//ResultFrequency = parseInt(ResultFrequency);
ResultFrequency = Math.ceil(ResultFrequency);
//alert(ResultFrequency);
document.getElementById("pharmaqty").value = ResultFrequency;


var VarRate = document.getElementById("pharmarate").value;
//var varr=parseFloat(VarRate.replace(/[^0-9\.]+/g,""));
var ResultAmount = parseFloat(VarRate) * parseFloat(ResultFrequency);
document.getElementById("pharmaamt").value = ResultAmount;
}
}
function sertotal()
{
var varquantityser = document.getElementById("serqty").value;
var varserRate = document.getElementById("serrate").value;
if(varquantityser!='' && varserRate!='') {
var totalservi = parseFloat(varquantityser) * parseFloat(varserRate);
document.getElementById("seramt").value=totalservi.toFixed(2);}
}
function numbervaild(key)
{
var keycode = (key.which) ? key.which : key.keyCode;
if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
{
return false;
}
}
function formatMoney(number, places, thousand, decimal) {
number = number || 0;
places = !isNaN(places = Math.abs(places)) ? places : 2;

thousand = thousand || ",";
decimal = decimal || ".";
var negative = number < 0 ? "-" : "",
i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
j = (j = i.length) > 3 ? j % 3 : 0;
return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}
function frequencyitem()
{
if(document.getElementById("frequency").value=="")
{
alert("please select a frequency");
document.getElementById("frequency").focus();
return false;
}
return true;
}
</script>
<?php
//include ("autocompletebuild_services11.php");
?>
<?php //include ("js/dropdownlist1scriptingservices1.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
-->
<script type="text/javascript" src="js/insertnewitem1pklinking.js"></script> <!--pharmacy-->
<script type="text/javascript" src="js/insertnewitem2pklinking.js"></script> <!--lab-->
<script type="text/javascript" src="js/insertnewitem3pklinking.js"></script><!--radiology-->
<script type="text/javascript" src="js/insertnewitem4pklinking.js"></script><!--service-->
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">

.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
#si_items_subtotal,#mi_items_subtotal,#li_items_subtotal,#ri_items_subtotal,#package_grand_total,#package_variance_amt{
font-weight: bold;
}
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
</tr>
<tr>
<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
</tr>
<tr>
<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>
<td width="1%">&nbsp;</td>
<td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
&nbsp;</td>
<td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="860">


<form name="cbform1" method="post" action="packageitems.php" onsubmit="return medicinecheck();">
<table width="80%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
<tbody>
<tr>
<td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Package Items Linking </strong></td>
<td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
<?php echo $res1location; ?>

<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">

</td> 
</tr>
<tr>
<td colspan="8" class="bodytext3">&nbsp;</td>
</tr>
<!--<tr>
<td colspan="8" class="bodytext3"><strong> Package </strong>
<select name="packageName" id="packageName" onchange='changePackage(this);'>
<option value=""> Select Package</option>
<option value="Lab"> Lab  </option>
<option value="Radiology"> Radiology </option>
<option value="Pharmacy"> Pharmacy </option>
<option value="Service"> Service </option>
</select>
</td>
</tr>-->

<tr>
<td colspan="8" class="bodytext3">&nbsp;</td>
</tr>
<!--Service-->
<tr>
<td colspan="8" id="serviceArea" >
<table width="80%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber4" style="border-collapse: collapse">

<tr>
<td class="bodytext3" >Package Type &nbsp;&nbsp;

</td>
<td class="bodytext3" ><select name="packageType" id="packageType">

<option value="IPD" selected>IPD</option>
<option value="OPD" selected>OPD</option>
</select></td>
</tr>


<tr>
<td class="bodytext3" colspan="8" >&nbsp;</td></tr>
<tr>
<td class="bodytext3"> Select Package </td>
<td><input name="package" type="text" id="package" size="29">
</td>
<input type="hidden" name="packageid" id="packageid" value="">

<!-- <td id="packageamttd" class="bodytext3">Package Amount<input type="text" class="bal" name="packageamt" id="packageamt" value=""></td>
<td id="packagedaystd" class="bodytext3">Validy Days<input type="text" class="bal" name="packagedays" id="packagedays" value=""></td> -->
<td class="bodytext3" id="packageamttd">Package Amount <strong><span id="packageamt"></span>
<input type="hidden" name="packageamtval" id="packageamtval"></strong></td>
<td class="bodytext3" id="packagedaystd">Days <strong><span id="packagedays"></span><strong></td>
</tr>
<tr>
<td class="bodytext3" colspan="8" >&nbsp;</td></tr>
<tr>
<td class="bodytext3" > Consultation Amount

</td>
<td class="bodytext3" ><input type="text" name="consultationamt" id="consultationamt" value="1" class="decimalnumber"></td>
</tr>
<tr>
<td class="bodytext3" colspan="8" >&nbsp;</td></tr>
<tr id="pressid3">
<td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">
<tbody >
<tr>
<td width="211" class="bodytext3"> Service Item</td>								  
<td width="55" class="bodytext3">Rate</td>
<td width="55" class="bodytext3">Qty</td>
<td width="55" class="bodytext3">Amount</td>
</tr>
</tbody>	
<tr>
<input type="hidden" name="serialnumbers" id="serialnumbers" value="1">
<input type="hidden" name="sercode" id="sercode" value="">
<td><input name="sername" type="text" id="sername" size="45" autocomplete="off" ></td>
<input name="searchser1hiddentextbox" id="searchser1hiddentextbox" type="hidden" value="">
<input name="searchseranum1" id="searchseranum1" value="" type="hidden">

<td><input type="text" name="serrate" id="serrate" size="8" readonly/></td>
<td><input type="text" name="serqty" id="serqty" size="8" onkeydown="return numbervaild(event)" onkeyup="return sertotal()"/></td>
<td><input type="text" name="seramt" id="seramt" size="8" readonly/></td>
<input name="avlquantity" type="hidden" id="avlquantity" size="8">


<td width="224"><label>
<input type="button" name="Add" id="Add" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">
</label></td>
</tr>

<input type="hidden" name="h" id="h" value="0">
</table>	</td>
</tr> 
<tr><td colspan="15" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><table  width="550" border="0" cellspacing="1" cellpadding="1">
<div id="insertrow4"></div>
</table>
</td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
<td>Service Items Sub Total:</td><td id="si_items_subtotal">0.00</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<input type="hidden" id="si_items_subtotal_val" value="0">


<!-- <tr>
<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
<td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
<td align="left" valign="top">			              </td>
</tr>
<tr>
<td align="left" valign="middle" class="bodytext3"></td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">
<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
<input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submitservice" onClick="return medicinecheck();"/>               </td>
</tr> --> 
</table>
</td>
</tr>
<!--end of Service-->
<!--Pharmacy-->
<tr>
<td colspan="8" id="pharmacyArea" >
<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber4" style="border-collapse: collapse">

<tr id="pressid3">
<td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">

<tr>
<td width="150" class="bodytext3">Medicine Item</td>
<td width="20" class="bodytext3">Dose</td>
<td width="30" class="bodytext3">Dose.Measure</td>
<td width="30" class="bodytext3">Freq</td>
<td width="20" class="bodytext3">Days</td>
<td width="20" class="bodytext3">Quantity</td>
<!-- <td width="30" class="bodytext3">Route</td> -->
<!-- <td width="40" class="bodytext3">Instructions</td> -->
<td width="20" class="bodytext3">Rate</td>
<td width="20" class="bodytext3">Amount</td>
</tr>

<tr>
<input type="hidden" name="serialnumberp" id="serialnumberp" value="1">
<input type="hidden" name="medicinecode" id="medicinecode" value="">
<td><input name="medicinename" type="text" id="medicinename" size="45" autocomplete="off" ></td>
<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

<td>
<input type="text" name="dose" id="dose" size="3" onkeydown="return numbervaild(event)" onkeyup="return Functionfrequency()"/></td>
<td><select name="dosemeasure" id="dosemeasure">
<option value="">Select Measure</option>
<option value="suppositories">suppositories</option>
<option value="tabs">tabs</option>
<option value="caps">caps</option>
<option value="ml">ml</option>
<option value="vial">vial</option>
<option value="inj">inj</option>
<option value="amp">amp</option>
<option value="gel">Gel</option>
<option value="tube">tube</option>
<option value="mg">mg</option>
<option value="drops">drops</option>
<option value="pcs">pcs</option>
</select>
</td>
<td>
<select name="frequency" id="frequency" onchange="return Functionfrequency()">
<option value="">Select Frequency</option>
<?php

$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while ($res5 = mysqli_fetch_array($exec5))
{
$res5num = $res5["frequencynumber"];
$res5code = $res5["frequencycode"];
?>
<option value="<?php echo $res5code; ?>"><?php echo $res5code; ?></option>
<?php
}
?>
</select>			
</td>	
<td>
<input type="text" name="days" id="days" size="3" onkeyup="return Functionfrequency()" onfocus="return frequencyitem()"/></td>
<td>
<input type="text" name="pharmaqty" id="pharmaqty" size="3" readonly/></td>
<!-- <td><select name="route" id="route">
<option value="">Select Route</option>
<option value="Oral">Oral</option>
<option value="Sublingual">Sublingual</option>
<option value="Rectal">Rectal</option>
<option value="Vaginal">Vaginal</option>
<option value="Topical">Topical</option>
<option value="Intravenous">Intravenous</option>
<option value="Intramuscular">Intramuscular</option>
<option value="Subcutaneous">Subcutaneous</option>
<option value="Intranasal">Intranasal </option>
<option value="Intraauditory">Intraauditory </option>
<option value="Eye">Eye</option>
</select></td> -->
<!--  <td><input type="text" name="pharinstuct" id="pharinstuct" size="20" />-->
<input name="exclude" type="hidden" id="exclude" readonly size="8">
<input name="formula" type="hidden" id="formula" readonly size="8">
<input name="strength" type="hidden" id="strength" readonly size="8"></td>  
<td>
<input type="text" name="pharmarate" id="pharmarate" size="8" readonly/></td>
<td>
<input type="text" name="pharmaamt" id="pharmaamt" size="8" readonly/></td>
<td width="224"><label>
<input type="button" name="Add" id="Add1" value="Add" onClick="return insertitem()" class="button" style="border: 1px solid #001E6A">
</label></td>
</tr>
</table>				 
</td>
</tr> 
<tr><td colspan="3" class="bodytext3"><table>
<div id="insertrow1"></div></table></td></tr>
<tr><td colspan="8">&nbsp;</td></tr>
<tr>
<td>Medicine Items Sub Total:</td><td id="mi_items_subtotal">0.00</td><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>

<input type="hidden" id="mi_items_subtotal_val" value="0">


</table>
</td>
</tr>
<!--end of Pharmacy-->
<!--Lab-->
<tr>
<td colspan="8" id="labArea" >
<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber4" style="border-collapse: collapse">

<tr id="pressid3">
<td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">

<tr>
<td width="211" class="bodytext3"> Laboratory Item</td>

<td width="55" class="bodytext3">Rate</td>
</tr>

<tr>
<input type="hidden" name="serialnumberl" id="serialnumberl" value="1">
<input type="hidden" name="labcode" id="labcode" value="">
<td><input name="labname" type="text" id="labname" size="45" autocomplete="off" ></td>
<input name="searchlab1hiddentextbox" id="searchlab1hiddentextbox" type="hidden" value="">
<input name="searchlabnum1" id="searchlabnum1" value="" type="hidden">

<td><input type="text" name="labrate" id="labrate" size="8" readonly/></td>



<td width="224"><label>
<input type="button" name="Add" id="Add2" value="Add" onClick="return insertitem2()" class="button" style="border: 1px solid #001E6A">
</label></td>
</tr>
<tr><td colspan="3" class="bodytext3"><table>
<div id="insertrow2"></div></table></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td>Laboratory Items Sub Total:</td><td colspan="13" id="li_items_subtotal">0.00</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<input type="hidden" id="li_items_subtotal_val" value="0">
</table>				  
</td>
</tr> 

</table>
</td>
</tr>
<!--end of Lab-->
<!--Radiology-->
<tr>
<td colspan="8" id="radArea" >
<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber4" style="border-collapse: collapse">

<tr id="pressid3">
<td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">

<tr>
<td width="211" class="bodytext3">Radiology Item</td>
<!-- <td width="55" class="bodytext3">Instructions</td> -->
<td width="55" class="bodytext3">Rate</td>
</tr>

<tr>
<input type="hidden" name="serialnumberr" id="serialnumberr" value="1">
<input type="hidden" name="radcode" id="radcode" value="">
<td><input name="radname" type="text" id="radname" size="45" autocomplete="off" ></td>
<input name="searchrad1hiddentextbox" id="searchrad1hiddentextbox" type="hidden" value="">
<input name="searchradnum1" id="searchradnum1" value="" type="hidden">
<!-- <td><input type="text" name="radinstuct" id="radinstuct"  /></td> -->
<td><input type="text" name="radrate" id="radrate" size="8" readonly/></td>



<td width="224"><label>
<input type="button" name="Add" id="Add3" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">
</label></td>
</tr>
</table>				  
</td>
</tr> 
<tr><td colspan="3" class="bodytext3"><table>
<div id="insertrow3"></div></table></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td>Radiology Items Sub Total:</td><td colspan="13" id="ri_items_subtotal">0.00</td><input type="hidden" id="ri_items_subtotal_val" value="0"></tr>
<tr><td colspan="3">&nbsp;</td></tr>

<tr><td>Package Grand Total:</td><td id="package_grand_total">0.00</td></tr>
<input type="hidden" name="package_grand_total_val" id="package_grand_total_val" value="0">
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td>Package Variance:</td><td id="package_variance_amt">0.00</td></tr>
<input type="hidden" name="package_variance_amt_val" id="package_variance_amt_val" value="0">
<tr>

<td align="right" colspan="3">
<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
<input type="hidden" name="package_exists" id="package_exists" value="0">

<input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submitlab"/>                 </td>
</tr>
<tr>
<td align="left" valign="middle" class="bodytext3"></td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top">&nbsp;</td>

</tr>
</table>
</td>
</tr>
<!--end of Radiology -->
<tr bgcolor="#011E6A">
<td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Packages - Existing List </strong></td>
</tr>
<tr>
<td width="5%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>S.no </strong></td>
<td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Package </strong></td>
<td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Pkg Amount</strong></td>
<td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Pkg Include Amount</strong></td>
<td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Pkg Diff Amount</strong></td>
<td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Action</strong></td>
</tr>
<?php
$colorloopcount = '';

$query1 = "select auto_number,packagename,rate from master_ippackage where status <> 'deleted' order by `auto_number` DESC";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$auto_number = $res1['auto_number'];
$packagename = $res1["packagename"];
$package_amount = $res1["rate"];
//$defaultstatus = $res1["defaultstatus"];

$query11 = "select sum(amount)as pkgitemamt from package_items where recordstatus <> 'deleted' and package_id='$auto_number' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$pkgitemamt = $res11['pkgitemamt'];

$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
if ($showcolor == 0)
{
$colorcode = 'bgcolor="#CBDBFA"';
}
else
{
$colorcode = 'bgcolor="#ecf0f5"';
}

?>
<tr <?php echo $colorcode; ?>>
<td align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?> </td>
<td align="left" valign="top"  class="bodytext3"><?php echo $packagename; ?> </td>
<td align="left" valign="top"  class="bodytext3"><?php echo  number_format($package_amount,'2','.',','); ?> </td>
<td align="left" valign="top"  class="bodytext3"><?php echo  number_format($pkgitemamt,'2','.',','); ?> </td>
<td align="left" valign="top"  class="bodytext3"><?php echo  number_format($package_amount-$pkgitemamt,'2','.',','); ?> </td>
<td align="left" valign="top"  class="bodytext3"><a href="editpackageitems.php?st=edit&&packageid=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
</tr>
<?php
}
?>
<tr>
<td align="middle" colspan="2" >&nbsp;</td>
</tr>
</tbody>
</table>
</form>		</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>

</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>