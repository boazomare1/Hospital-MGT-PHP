<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
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
    $packageid = $_REQUEST['packageid'];
    if($locationcode !='')
    	$condn = "and locationcode='$locationcode'";
	$qryreset = "update package_items set recordstatus = 'deleted' where package_id = '$packageid'". $condn;
    mysqli_query($GLOBALS["___mysqli_ston"], $qryreset);

  
	
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
					 $serquery2="insert into package_items (package_id,itemcode, itemname,username, ipaddress,rate,locationname,locationcode,quantity,package_type,amount)
					values ('$packageid','$sercode', '$sername','$username', '$ipaddress','$serrate','$res1location','$res1locationanum','$serqty','$package_type','$seramt')";

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
			 $medicinequery2="insert into package_items (package_id, itemcode, itemname, username, ipaddress,rate,locationname,locationcode,dose,dosemeasure,frequency,days,quantity,package_type,amount)
			values ('$packageid','$medicinecode', '$medicinename','$username', '$ipaddress','$pharmarate','$res1location','$res1locationanum','$dose','$dosemeasure','$frequency','$days','$pharmaqty','$package_type','$pharmaamt')";

			
			
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
			 $labquery2="insert into package_items (package_id, itemcode, itemname,username, ipaddress,rate,locationname,locationcode,package_type,amount)
			values ('$packageid','$labcode', '$labname','$username', '$ipaddress','$labrate','$res1location','$res1locationanum','$package_type','$labrate')";
			
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
				 $radquery2="insert into package_items (package_id,itemcode, itemname,username, ipaddress,rate,locationname,locationcode,package_type,amount)
				values ('$packageid','$radcode', '$radname','$username', '$ipaddress','$radrate','$res1location','$res1locationanum','$package_type','$radrate')";
				
				$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $radquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
		
			}
		$consultationamt = trim($_POST['consultationamt']);
		$qryreset = "update package_items set rate='$consultationamt',amount = '$consultationamt',recordstatus='' where package_id = '$packageid' and package_type='CT'";
    	mysqli_query($GLOBALS["___mysqli_ston"], $qryreset);

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
function btnDeleteClick10(delID,rowid)
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

     if(rowid !='' && rowid > 0)
    delete_package_item(rowid);
}
function btnDeleteClick12(delID,rowid)
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
     if(rowid !='' && rowid > 0)
    delete_package_item(rowid);

}
function btnDeleteClick13(delID,rowid)
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

    if(rowid !='' && rowid > 0)
    delete_package_item(rowid);

}
function btnDeleteClick14(delID,rowid)
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

    if(rowid !='' && rowid>0)
    delete_package_item(rowid);
}
function calculate_items_total(classname,id){
	
	toggle_column_headings(id);
	// Calculate Sub Total for all items
	var sum = 0;
	 $("."+classname).each(function()
      {
              sum += parseFloat($(this).find("input").val());
        });
	 
	 $('#'+id).html(formatMoney(sum.toFixed(2)));
	 $('#'+id+'_val').val(sum);
	 calculate_items_grand_total();
	 calculate_package_variance();
}
function calculate_items_grand_total(){
	
	// $('#'+id).html(formatMoney(sum.toFixed(2)));
	var ct_items_subtotal_val = $('#ct_items_subtotal_val').val();
	 var si_items_subtotal_val = $('#si_items_subtotal_val').val();
	 var mi_items_subtotal_val = $('#mi_items_subtotal_val').val();
	 var li_items_subtotal_val = $('#li_items_subtotal_val').val();
	 var ri_items_subtotal_val = $('#ri_items_subtotal_val').val();

	 var package_grand_total = parseFloat(ct_items_subtotal_val) + parseFloat(si_items_subtotal_val) + parseFloat(mi_items_subtotal_val) + parseFloat(li_items_subtotal_val) + parseFloat(ri_items_subtotal_val);
	 $('#package_grand_total').html(formatMoney(package_grand_total.toFixed(2)));// Grand total for all items category
	 $('#package_grand_total_val').val(package_grand_total);

}
function calculate_package_variance()
{
	var package_amt            =  $('#packageamtval').val();
	var package_grandtotal_amt =  $('#package_grand_total_val').val();
	var package_variance_amt   =  parseFloat(package_amt) - parseFloat(package_grandtotal_amt);
	$('#package_variance_amt').html(formatMoney(package_variance_amt.toFixed(2)));
}
function toggle_column_headings(id)
{
	 //aaa
	 console.log(id)
	 console.log($('#'+id+'_table > tbody > tr').length)
	 if ($('#'+id+'_table > tbody > tr').length > 0){
     	//$('#'+id+'_table > thead').css('display','block');
     	$('#'+id+'_table > thead').show();
     	console.log('show')
 	 }
 	 else
 	 {
 	 	$('#'+id+'_table > thead').hide();
 	 	console.log('hide')
 	 }
}
function delete_package_item(id)
{

	console.log('in del function')
    $.ajax({
		  url: 'ajax/packageitemdel.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      auto_number: id
		  },
		  success: function (data) { 
		  	//alert(data)
		  	
		  	/*var msg = data.msg;
		  	if(data.status == 1)
		  	{
		  		alert(msg);
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}*/
		  	
		  }
		});
}
</script>
<script>
function medicinecheck()
{
	if(document.getElementById('services').value=='')
	{
		alert("Please Select the Service package");
		document.cbform1.services.focus();
		return false;
	}
	
	return true;
	
}
</script>

<link href="css/bootstrap.min.css" rel="stylesheet">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">

<script>
$(document).ready(function() {

	//console.log('#'+$('#mi_items_subtotal_table > tbody > tr').length+'#');

	if ($('#si_items_subtotal_table > tbody > tr').length == 0){
     	//$('#si_items_subtotal_table > thead').css('display','none');
     	$('#si_items_subtotal_table > thead').hide();
 	}

	if ($('#mi_items_subtotal_table > tbody > tr').length == 0){
     	//$('#mi_items_subtotal_table > thead').css('display','none');
     	$('#mi_items_subtotal_table > thead').hide();
 	}

 	if ($('#li_items_subtotal_table > tbody > tr').length == 0){
     	//$('#li_items_subtotal_table > thead').css('display','none');
     	$('#li_items_subtotal_table > thead').hide();
 	}

 	if ($('#ri_items_subtotal_table > tbody > tr').length == 0){
     	//$('#ri_items_subtotal_table > thead').css('display','none');
     	$('#ri_items_subtotal_table > thead').hide();
 	}
	
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
			//$('#strength').val(ui.item.roq);
			$('#strength').val(ui.item.strength);

			$('#dosemeasure').val('');
			$('#frequency').val('');
			$('#days').val('');
			$('#pharmaqty').val('');
			$('#pharinstuct').val('');
			$('#pharmaamt').val('');
			$('#dose').val('');
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
			$('#radinstuct').val('');
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
	$("#consultationamt" ).keyup(function() {

    	if($(this).val() !='')
    	{	
    		$('#ct_items_subtotal_val').val($(this).val());
    		 calculate_items_grand_total();
	 		 calculate_package_variance();
    	}
    	if($(this).val() =="")
    	{
    		$('#ct_items_subtotal_val').val(0);
    		 calculate_items_grand_total();
	 		 calculate_package_variance();
    	}
			
	});
    
});

function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
formula = 'CONSTANT';
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
// var frequencyanum = document.getElementById("frequency").value;
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
var varr1 = document.getElementById("pharmarate").value;

/*var varr2=varr1.replace(",","");
var varr3=varr2.replace(",","");
var varr=varr3.replace(",","");
var VarRate = parseInt(varr);*/
var VarRate = document.getElementById("pharmarate").value;
var ResultAmount = parseFloat(VarRate) * parseFloat(ResultFrequency);
  document.getElementById("pharmaamt").value = ResultAmount;
  
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
	document.getElementById("seramt").value=totalservi.toFixed(2);
  }
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
function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

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
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 16px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
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
		<?php
		$st = $_REQUEST['st'];
		if($st == 'edit')
		{
		//$servicecode = $_REQUEST['packageid'];
		$packageid = $_REQUEST['packageid'];
		$qrypackage = "select packagename,rate,days from master_ippackage where auto_number = '$packageid'";
		$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage);
		$respackage = mysqli_fetch_array($execpackage);
		$packagename = $respackage['packagename'];
		$package_amt = $respackage['rate'];
		$package_days = $respackage['days'];

		$qrypkgtype = "select package_item_type from package_items where package_id = '$packageid' and recordstatus != 'deleted' limit 0,1";
		$execpkgtype = mysqli_query($GLOBALS["___mysqli_ston"], $qrypkgtype) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$respkgtype = mysqli_fetch_array($execpkgtype);
		$package_item_type = $respkgtype['package_item_type'];
		?>
		
              <form name="cbform1" method="post" action="editpackageitems.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong> Package Items Linking </strong></td>
               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             		<?php echo $res1location; ?>
            						
						<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">
                  
                  </td> 
              </tr>

              <tr>
							<td class="bodytext3">Package Type &nbsp;&nbsp;
							        
							</td>
						<td class="bodytext3"><select style="margin:5px;" name="packageType" id="packageType">
						  
						   <option value="<?php echo $package_item_type; ?>"><?php echo $package_item_type; ?></option>
						  
						   </select></td>
               </tr>
            
            <tr>
              <td  class="bodytext3"><strong> Package </strong></td>
               <td> <input name="packagename" type="text" id="packagename" size="29" style="margin:5px;" readonly value="<?php echo $packagename?>">
            </td>
			    <input type="hidden" name="packageid" id="packageid" value="<?php echo $packageid?>">
			    
			    <td class="bodytext3">Package Amount  &nbsp;&nbsp;&nbsp;<strong><?php echo number_format($package_amt,'2','.',','); ?></strong><input type="hidden" name="packageamtval" id="packageamtval" value="<?php echo $package_amt; ?>"></td>
			    <!-- <td class="bodytext3"></td> -->
			    <td class="bodytext3">Days &nbsp;&nbsp;&nbsp;<strong><?php echo $package_days; ?></strong></td>
			   <!--  <td class="bodytext3"></td> -->
			   </tr>

   	<?php 
   		$pkg_consulation_amt = 0;
   		$package_type = 'CT';
		
   		$qrypackage = "select amount from package_items where package_id = '$packageid' and package_type ='$package_type' and recordstatus != 'deleted'";
		$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage);
		$respackage = mysqli_fetch_array($execpackage);
		$pkg_consulation_amt = $respackage['amount'];
   	?>
   	<tr><td>&nbsp;</td></tr>
   	<tr>
							<td class="bodytext3"> Consultation Amount
							       
									</td>
									<td class="bodytext3"><strong><input type="text" name="consultationamt" id="consultationamt" value="<?php echo $pkg_consulation_amt; ?>" class="decimalnumber"></strong></td>
									<input type="hidden" id="ct_items_subtotal_val" value="<?php  echo $pkg_consulation_amt;?>">
                          </tr>
               <!--Service-->
               <tr id="pressid3">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tbody >
					 <tr>
                       <td width="211" class="bodytext3">Service Item</td>
                       <td width="55" class="bodytext3">Rate</td>
					   <td width="55" class="bodytext3">Qty</td>
					   <td width="55" class="bodytext3">Amount</td>
                     </tr>
					</tbody>				 					 
					
					  
                     <tr>
					  
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
					    <tr><td>&nbsp;</td></tr>
					  <tr><td colspan="5"></td></tr>
					  
                       <tr> <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
					  
						 <table class="bodytext3" id="si_items_subtotal_table">
						 	<thead><tr><td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Service Item</strong>
						 </td><td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Rate</strong>
						 </td>
						 <td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Qty</strong>
						 </td>
						 <td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Amount</strong>
						 </td>
						</tr>
						 </thead>
						 <tbody id="insertrow4">
						 	
					    <?php
					    $si_items_subtotal = 0;
						 $i=1;
						 $package_type = 'SI';
						 $qrylab = "select * from package_items where package_id = '$packageid' and package_type ='$package_type' and recordstatus != 'deleted'";
						 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						while($reslab = mysqli_fetch_array($execlab))
						{
						 $itemcode = $reslab['itemcode'];
						 $itemname = $reslab['itemname'];
						 $itemrate = $reslab['rate'];
						 $rowid = $reslab['id'];
						 $si_items_subtotal =  $si_items_subtotal + $reslab['amount'];
						 ?>
						 <tr id="idserTR<?=$i?>">
						 <td id="serialnumber<?=$i?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						 <input id="serialnumber<?=$i?>" name="serialnumber<?=$i?>" type="hidden" size="25" value="<?=$i?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
						 <input id="sercode<?=$i?>" name="sercode<?=$i?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
						<!-- </td>
						 <td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
						 <input id="sername<?=$i?>" name="sername<?=$i?>" type="text" align="left" value="<?=$itemname?>" size="45" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
						 </td>
						 <td id="serrate<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						 <input id="serrate<?=$i?>" name="serrate<?=$i?>" type="text" size="8" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
						 </td>

						 <td id="serqty<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						 <input id="serqty<?=$i?>" name="serqty<?=$i?>" type="text" size="8" readonly="" value="<?=$reslab['quantity']?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;">
						 </td>

						 <td id="seramt<?=$i?>" class="sercalamt" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						 <input id="seramt<?=$i?>"  name="seramt<?=$i?>" type="text" size="8" readonly="" value="<?=$reslab['amount']?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
						 </td>

						 <td id="btndeleteser<?=$i?>" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						 <input id="btndeleteser<?=$i?>" name="btndeleteser<?=$i?>" onclick = "return btnDeleteClick14('<?=$i?>','<?=$rowid?>');" type="button" value="Del" style="border: 1px solid rgb(0, 30, 106);"></td></tr>
						 <?php
						 $i++;
						 }
					 ?>
					 </tbody>
					 </table></td></tr>
                     <input type="hidden" name="serialnumbers" id="serialnumbers" value="<?=$i?>">
					 <input type="hidden" name="h" id="h" value="0">
                   </table>	 </td>
			       </tr>  <!--end of Service-->
                   <tr><td colspan="3">&nbsp;</td></tr>
                   <tr><!-- <td colspan="5">&nbsp;</td> --><td width="100px">Service Items Sub Total:</td><td colspan="13" id="si_items_subtotal"><?php if($si_items_subtotal > 0) echo number_format($si_items_subtotal,'2','.',',');?></td><input type="hidden" id="si_items_subtotal_val" value="<?php echo $si_items_subtotal;?>"></tr>
				    <!--Pharmacy-->
				    <tr><td>&nbsp;</td></tr>
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
								   <td width="30" align="left" class="bodytext3">Freq</td>
								   <td width="20" class="bodytext3">Days</td>
								   <td width="20" class="bodytext3">Quantity</td>
								  <!--  <td width="30" class="bodytext3">Route</td> -->
								   <!-- <td width="40" class="bodytext3">Instructions</td> -->
								   <td width="20" align="center" class="bodytext3">Rate</td>
								   <td width="20" class="bodytext3">Amount</td>
								 </tr>
								 
								 <tr>
								  
								  <input type="hidden" name="medicinecode" id="medicinecode" value="">
								 
									<td><input name="medicinename" type="text" id="medicinename" size="45" autocomplete="off" ></td>

										<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
										<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
						            
									<td>
									<input type="text" name="dose" id="dose" size="3" onkeyup="return Functionfrequency()"/></td>

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
											<option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
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
                                    <!-- <input type="text" name="pharinstuct" id="pharinstuct" size="20" /> -->
									 <input name="exclude" type="hidden" id="exclude" readonly size="8">
                                     <input name="formula" type="hidden" id="formula" readonly size="8">
									  <input name="strength" type="hidden" id="strength" readonly size="8">

									  <td>
									<input type="text" name="pharmarate" id="pharmarate" size="8" readonly/></td>
									<td>
									<input type="text" name="pharmaamt" id="pharmaamt" size="8" readonly/></td>

									<td width="224"><label>
								   <input type="button" name="Add" id="Add1" value="Add" onClick="return insertitem()" class="button" style="border: 1px solid #001E6A">
								   </label></td>
								   </tr>
								    <tr><td>&nbsp;</td></tr>
							     </table>				 
							     </td>
							   </tr> 

							    <tr><td colspan="3" >
								  
									 <table class="bodytext3" id="mi_items_subtotal_table"> 

									 	<thead><td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Medicine Item</strong>
						 </td><td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Dose</strong>
						 </td>
						 <td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Dose.Measure</strong>
						 </td>
						 <td align="left"  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Freq</strong>
						 </td>
						  <td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Days</strong>
						 </td>
						  <td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Quantity</strong>
						 </td>
						  <td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Rate</strong>
						 </td>
						   <td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Amount</strong>
						 </td>
						 </thead>
						
									 	<tbody id="insertrow1">
									<?php
									 $mi_items_subtotal = 0;
									 $p=1;
									  $package_type = 'MI';
						 			 $qrylab = "select * from package_items where package_id = '$packageid' and package_type ='$package_type' and recordstatus != 'deleted'";
									
									 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
									while($reslab = mysqli_fetch_array($execlab))
									{
									 $itemcode = $reslab['itemcode'];
									 $itemname = $reslab['itemname'];
									 //$itemins = $reslab['instructions'];
									 $itemrate = $reslab['rate'];
									 $rowid = $reslab['id'];
									 $mi_items_subtotal =  $mi_items_subtotal +  $reslab['amount'];
									
									 ?>
									 <tr id="idTR<?=$p?>">
										 <td id="serialnumberp<?=$p?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="medicinecode<?=$p?>" name="medicinecode<?=$p?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
											 <input id="serialnumberp<?=$p?>" name="serialnumberp<?=$p?>" type="hidden" size="25" value="<?=$p?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
											 <input id="medicinename<?=$p?>" name="medicinename<?=$p?>" type="text" align="left" size="45" readonly="" value="<?=$itemname?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
										 </td>
											<td id="tddose<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
												<input id="dose<?=$p?>" name="dose<?=$p?>" type="text" size="4" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['dose']?>">
										 </td>
										 <td id="tddosemeasure<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="dosemeasure<?=$p?>" name="dosemeasure<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['dosemeasure']?>">
										 </td>
										 <td id="tdfrequency<?=$p?>" align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="frequency<?=$p?>" name="frequency<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['frequency']?>">
										 </td>

										 <td id="tddays<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="days<?=$p?>" name="days<?=$p?>" type="text" size="4" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['days']?>">
										 </td>
										  <td id="tdpharmaqty<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="pharmaqty<?=$p?>" name="pharmaqty<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['quantity']?>">
										 </td>


										<!--  <td id="route<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="route<?=$p?>" name="route<?=$p?>" type="text" size="10" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['route']?>">
										 </td> -->
										<!--  <td id="pharinstuct<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											 <input id="pharinstuct<?=$p?>" name="pharinstuct<?=$p?>" type="text" size="20" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['instructions']?>">
										 </td> -->
										 <td id="tdpharmarate<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											<input id="pharmarate<?=$p?>" name="pharmarate<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;" value="<?=$itemrate?>">
										 </td>

										 <td id="tdpharmaamt<?=$p?>" class="pharmacalamt" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											<input id="pharmaamt<?=$p?>"  name="pharmaamt<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;" value="<?=$reslab['amount']?>">
										 </td>

										 <td id="btndelete<?=$p?>" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
											<input id="btndelete<?=$p?>" name="btndelete<?=$p?>" type="button" value="Del" style="border: 1px solid rgb(0, 30, 106);" onclick = "return btnDeleteClick10('<?=$p?>','<?=$rowid?>');">
										 </td>
									 </tr>
									 <?php
									 $p++;
									 }
								 ?>
								 </tbody>
								 </table></td></tr>
								  <input type="hidden" name="serialnumberp" id="serialnumberp" value="<?=$p?>">
							   
							  
				  </table>
                </td>
			   </tr>
                <!--end of Pharmacy -->

                 <tr><td colspan="3">&nbsp;</td></tr>
                 <tr><!-- <td colspan="6">&nbsp;</td><td width="">&nbsp;</td> --><td width="1%">Medicine Items Sub Total:</td><td colspan="13" id="mi_items_subtotal"> <?php if($mi_items_subtotal > 0) echo number_format($mi_items_subtotal,'2','.',',');?></td><input type="hidden" id="mi_items_subtotal_val" value="<?php echo $mi_items_subtotal;?>"></tr>
					<tr><td>&nbsp;</td></tr>				

				 <!--Lab-->
				 <tr><td></td></tr>
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
								 
								  <input type="hidden" name="labcode" id="labcode" value="">

									<td><input name="labname" type="text" id="labname" size="45" autocomplete="off" ></td>
										<input name="searchlab1hiddentextbox" id="searchlab1hiddentextbox" type="hidden" value="">
										<input name="searchlabnum1" id="searchlabnum1" value="" type="hidden">
						
									<td><input type="text" name="labrate" id="labrate" size="8" readonly/></td>
									
									
									
									<td width="224"><label>
								   <input type="button" name="Add" id="Add2" value="Add" onClick="return insertitem2()" class="button" style="border: 1px solid #001E6A">
								   </label></td>
								   </tr>
								    <tr><td>&nbsp;</td></tr>
									<tr><td colspan="3" >
								  
									 <table class="bodytext3" id="li_items_subtotal_table"> 
									 	<thead><tr><td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Laboratory Item</strong>
						 </td><td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Rate</strong>
						 </td>
						</tr>
						 </thead>
						
									 	<tbody id="insertrow2">
									<?php
									$li_items_subtotal = 0;
									 $j=1;
									 $package_type = 'LI';
						 			 $qrylab = "select * from package_items where package_id = '$packageid' and package_type ='$package_type' and recordstatus != 'deleted'";
									 
									 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
									while($reslab = mysqli_fetch_array($execlab))
									{
									 $itemcode = $reslab['itemcode'];
									 $itemname = $reslab['itemname'];
									 $itemrate = $reslab['rate'];
									 $li_items_subtotal =  $li_items_subtotal + $itemrate;
									 ?>
									 <tr id="idlabTR<?=$j?>">
									 <td id="serialnumberl<?=$j?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="serialnumberl<?=$j?>" name="serialnumberl<?=$j?>" type="hidden" size="25" value="<?=$j?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									 <input id="labcode<?=$j?>" name="labcode<?=$j?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									<!-- </td>
									 <td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
									 <input id="labname<?=$j?>" name="labname<?=$j?>" type="text" align="left" value="<?=$itemname?>" size="45" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									 </td>
									 <td id="tdlabrate<?=$j?>" class="labcalrate" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="labrate<?=$j?>"  name="labrate<?=$j?>" type="text" size="8" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
									 </td>
									 <td id="btndelete1<?=$j?>" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="btndelete1<?=$j?>" name="btndelete1<?=$j?>" onclick = "return btnDeleteClick12('<?=$j?>','<?=$rowid?>');" type="button" value="Del" style="border: 1px solid rgb(0, 30, 106);"></td></tr>
									 <?php
									 $j++;
									 }
								 ?>
								 </tbody>
								 </table></td></tr>
								  <input type="hidden" name="serialnumberl" id="serialnumberl" value="<?=$j?>">
							   </table>				  
							   </td>
							   </tr> 
							   
				  </table>
                </td>
			   </tr>
                <!--end of Lab-->

                  <tr><td colspan="3">&nbsp;</td></tr>

                  <tr><!-- <td>&nbsp;</td> --><td width="1%">Laboratory Items Sub Total:</td><td id="li_items_subtotal"> <?php if($li_items_subtotal > 0) echo number_format($li_items_subtotal,'2','.',',');?></td><input type="hidden" id="li_items_subtotal_val" value="<?php echo $li_items_subtotal;?>"></tr>
									
				<!--Radiology-->
				<tr><td>&nbsp;</td></tr>
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
								  <input type="hidden" name="radcode" id="radcode" value="">

									<td><input name="radname" type="text" id="radname" size="45" autocomplete="off" ></td>
										<input name="searchrad1hiddentextbox" id="searchrad1hiddentextbox" type="hidden" value="">
										<input name="searchradnum1" id="searchradnum1" value="" type="hidden">
						           <!--  <td><input type="text" name="radinstuct" id="radinstuct"  /></td> -->
									<td><input type="text" name="radrate" id="radrate" size="8" readonly/></td>
									
									
									
									<td width="224"><label>
								   <input type="button" name="Add" id="Add3" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">
								   </label></td>
								   </tr>
								    <tr><td>&nbsp;</td></tr>
								   <tr><td colspan="3" >
								  
									 <table class="bodytext3" id="ri_items_subtotal_table"> 
									 	<thead><th align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Radiology Item</strong>
						 </th><td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
						<strong>Rate</strong>
						 </td>
						
						 </thead>
						
									 	<tbody id="insertrow3">
									<?php
									$ri_items_subtotal = 0;
									 $k=1;
									  $package_type = 'RI';
						 			 $qrylab = "select * from package_items where package_id = '$packageid' and package_type ='$package_type' and recordstatus != 'deleted'";
									
									 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
									while($reslab = mysqli_fetch_array($execlab))
									{
									 $itemcode = $reslab['itemcode'];
									 $itemname = $reslab['itemname'];
									 //$itemins = $reslab['instructions'];
									 $itemrate = $reslab['rate'];
									 $rowid = $reslab['id'];
									 $ri_items_subtotal =  $ri_items_subtotal + $itemrate;
									 ?>
									 <tr id="idradTR<?=$k?>">
									 <td id="serialnumberr<?=$k?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="serialnumberr<?=$k?>" name="serialnumberr<?=$k?>" type="hidden" size="25" value="<?=$k?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									 <input id="radcode<?=$k?>" name="radcode<?=$k?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									<!-- </td>
									 <td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
									 <input id="radname<?=$k?>" name="radname<?=$k?>" type="text" align="left" value="<?=$itemname?>" size="45" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
									 </td>
									 <!-- <td id="radinstuct<?=$k?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><input id="radinstuct<?=$k?>" name="radinstuct<?=$k?>" type="text" size="25" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" value="<?=$itemins?>"></td> -->

									 <td id="tdradrate<?=$k?>" class="radcalrate" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="radrate<?=$k?>"  name="radrate<?=$k?>" type="text" size="8" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
									 </td>
									 <td id="btndelete5<?=$k?>" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
									 <input id="btndelete5<?=$k?>" name="btndelete5<?=$k?>" onclick = "return btnDeleteClick13('<?=$k?>','<?=$rowid?>');" type="button" value="Del" style="border: 1px solid rgb(0, 30, 106);"></td></tr>
									 <?php
									 $k++;
									 }
								 ?>
								 </tbody>
								 </table></td></tr>
								  <input type="hidden" name="serialnumberr" id="serialnumberr" value="<?=$k?>">
							   </table>				  
							   </td>
							   </tr> 
							     <tr><td colspan="3">&nbsp;</td></tr>
							     <tr><!-- <td>&nbsp;</td> --><td width="1%">Radiology Items Sub Total:</td><td id="ri_items_subtotal"><?php if($ri_items_subtotal > 0)echo number_format($ri_items_subtotal,'2','.',',');?></td><input type="hidden" id="ri_items_subtotal_val" value="<?php echo $ri_items_subtotal;?>"></tr>
						<?php 
						$package_grand_total = $pkg_consulation_amt + $si_items_subtotal + $mi_items_subtotal + $li_items_subtotal+$ri_items_subtotal; 
						$package_variance_amt = $package_amt - $package_grand_total;

						 ?>
						 <tr><td>&nbsp;</td></tr>
							      <tr><td width="5%">Grand Total:</td><td id="package_grand_total"><?php echo number_format($package_grand_total,'2','.',',');?></td></tr>
							      <input type="hidden" name="package_grand_total_val" id="package_grand_total_val" value="<?php echo $package_grand_total; ?>">
							      <tr><td>&nbsp;</td></tr>

							   <tr><td>Package Variance:</td><td id="package_variance_amt"><?php echo number_format($package_variance_amt,'2','.',',');?></td> 
							   	<input type="hidden" name="package_variance_amt_val" id="package_variance_amt_val" value="<?php echo $package_variance_amt; ?>"></tr>
							     <tr><td colspan="3">&nbsp;</td></tr>
								<tr>
						 			             
						  <td align="center" colspan="8">
						       <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
							  <input  style="border: 1px solid #001E6A;width: 100px;font-weight: bold;font-size: 17px" type="submit" value="Save" name="Submitlab" onClick="return medicinecheck();"/>                 </td>
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

          </tbody>
        </table>
		</form>		
		</td>
      </tr>
	  <?php
	  }
	  ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  
	  </form>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

