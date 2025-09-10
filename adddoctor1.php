<?php
session_start();
include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
//echo $menu_id;
include ("includes/check_user_access.php");
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$docno = $_SESSION['docno'];
$username = $_SESSION["username"];
$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];
	 
//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
	 $locationcode=$location;
	}
		//location get end here
if (isset($_REQUEST["searchdoctor"])) { $searchdoctor = $_REQUEST["searchdoctor"]; } else { $searchdoctor = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$doctorcode=$_REQUEST["doctorcode"];
	$locationcode =$_REQUEST['location'];
	$query = "select * from master_location where locationcode = '$locationcode'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 
	$doctorname = $_REQUEST["doctorname"];
	$doctorname = strtoupper($doctorname);
	$doctorname = trim($doctorname);
	$typeofdoctor=$_REQUEST["typeofdoctor"];
	$address1=$_REQUEST["address1"];
	$address2=$_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber = $_REQUEST["faxnumber"];
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks=$_REQUEST["remarks"];
	$tinnumber=$_REQUEST["tinnumber"];
	$cstnumber=$_REQUEST["cstnumber"];
	$ipdoctor=$_REQUEST["ipdoctor"];
	$isstaff = 0;
	if(isset($_REQUEST["isstaff"]))
	{
		$isstaff = $_REQUEST["isstaff"];
	}

	if(isset($_REQUEST["ipresdoctor"]))
	{
		$ipresdoctor = $_REQUEST["ipresdoctor"];
		$resdoclimit = $_REQUEST["resdoclimit"];
		$resdoclimitext = $_REQUEST["resdoclimitext"];
		$resdocshar = $_REQUEST["resdocshar"];
		$resdocsharext = $_REQUEST["resdocsharext"];
	}else{

       $ipresdoctor = 0;
	   $resdoclimit = 0;
		$resdoclimitext = 0;
		$resdocshar = 0;
		$resdocsharext = 0;

	}

	$excludeallocation=isset($_REQUEST['excludeallocation'])?$_REQUEST['excludeallocation']:'0';
	$openingbalance = $_REQUEST["openingbalance"];
	$department = $_REQUEST["department"];
	$consultationfees = $_REQUEST["consultationfees"];
	$hospitalfees = $_REQUEST['hospitalfees'];
	$doctorfees = $_REQUEST['doctorfees'];
	$consultationperc = $_REQUEST['consultationpercentage'];
	$ipserperc = $_REQUEST['ipserpercentage'];
	$pvtdrperc = $_REQUEST['pvtdrpercentage'];
	$max_appt = $_REQUEST['max_appt'];

	$ippvtdrperc = $_REQUEST['ippvtdrpercentage'];
	$pvtconsultationperc = $_REQUEST['pvtconsultationpercentage'];
	
	$resdoccharge = isset($_REQUEST["resdoccharge"])?$_REQUEST["resdoccharge"]:'';
	$pridoccharge = isset($_REQUEST["pridoccharge"])?$_REQUEST["pridoccharge"]:'';
		
	$query2 = "select * from master_doctor where doctorcode = '$doctorcode' AND locationcode = '".$locationcode."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "INSERT into master_doctor (doctorcode,doctorname,typeofdoctor,address1,address2,
		area,city,state,country,pincode,phonenumber1,phonenumber2,faxnumber,mobilenumber,emailid1, emailid2,
		remarks, status, tinnumber, cstnumber, openingbalance, department, consultationfees, ipdoctor,locationcode,locationname,resdoc_charge,pridoc_charge,hospitalfees,doctorfees, consultation_percentage, ipservice_percentage, pvtdr_percentage,is_staff,max_appt,excludeallocation,op_consultation_private_sharing,ip_consultation_private_sharing,is_resdoc,resdoc_limit,res_limit_ext,res_start_per,res_per_ext,username) 
		values('$doctorcode','$doctorname','$typeofdoctor','$address1','$address2','$area','$city',
		'$state','$country','$pincode','$phonenumber1','$phonenumber2','$faxnumber','$mobilenumber','$emailid1',
		'$emailid2','$remarks','$status', '$tinnumber', '$cstnumber', '$openingbalance', '$department', '$consultationfees', '$ipdoctor','".$locationcode."','".$locationname."','".$resdoccharge."','".$pridoccharge."','$hospitalfees','$doctorfees', '$consultationperc', '$ipserperc','$pvtdrperc','$isstaff','$max_appt','$excludeallocation','$pvtconsultationperc','$ippvtdrperc','$ipresdoctor','$resdoclimit','$resdoclimitext','$resdocshar','$resdocsharext','$username')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$doctor_ins_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		if($doctor_ins_id)
		{
			if(!empty($_POST['weekday'])){
				
				foreach($_POST['weekday'] as $weekdayid){
					//echo $weekdayid."</br>";
					$inser_qry = "INSERT INTO `doctor_weekdays` (`id`, `doctor_code`, `weekday_id`, `created_on`, `updated_on`) VALUES (NULL, '".$doctorcode."', $weekdayid, CURRENT_TIMESTAMP, '".$updatedatetime."'); ";
					
					$exec_weekdays = mysqli_query($GLOBALS["___mysqli_ston"], $inser_qry) or die ("Error in Insert Doctor Weekdays Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
		
		
		foreach($_REQUEST['employee'] as $key => $value)
		{
		$employeename= $_REQUEST['employee'][$key];
		$employeecode= $_REQUEST['employeecode'][$key];
		$docusername= $_REQUEST['docusername'][$key];
		$employeename = addslashes($employeename);
	$employeecode = addslashes($employeecode);
	$docusername = addslashes($docusername);
		if($docusername !='')
		{
		$query11 = "insert into doctor_mapping (doctorname,doctorcode,employeename,employeecode,docusername,ipaddress,created_at,locationcode,locationname)
		values('$doctorname','$doctorcode','$employeename','$employeecode','$docusername','$ipaddress','$updatedatetime','$locationcode','$locationname')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$emailid1  = '';
		$emailid2 = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$consultationpercentage = '0.00';
		$dateposted = $updatedatetime;
		$department = '';
		$consultationfees = '';
		
		header("location:adddoctor1.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:adddoctor1.php?st=failed");
	}
}
else
{
	$companyname = "";
	$title1  = "";
	$title2  = "";
	$contactperson1  = "";
	$contactperson2 = "";
	$designation1 = "";
	$designation2  = "";
	$phonenumber1 = "";
	$phonenumber2 = "";
	$emailid1  = "";
	$emailid2 = "";
	$faxnumber1 = "";
	$faxnumber2  = "";
	$address1 = "";
	$address2 = "";
	$location = "";
	$city  = "";
	$pincode = "";
	$country = "";
	$state = "";
	$tinnumber = "";
	$cstnumber = "";
	$companystatus  = "";
	$openingbalance = "";
	$consultationpercentage = "";
	$department = '';
	$consultationfees = '';
	
	$dateposted = $updatedatetime;
}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Doctor Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Doctor Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Doctor Already Exists.";
}
if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
}
$query2 = "select * from master_doctor order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2doctorcode = $res2["doctorcode"];
if ($res2doctorcode == '')
{
	$doctorcode = 'DTC00000001';
	$openingbalance = '0.00';
	$consultationpercentage = '0.00';
	$ipserpercentage = '0.00';
	$pvtdrpercentage = '0.00';
}
else
{
	$res2doctorcode = $res2["doctorcode"];
	$doctorcode = substr($res2doctorcode, 3, 8);
	$doctorcode = intval($doctorcode);
	$doctorcode = $doctorcode + 1;
	$maxanum = $doctorcode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$doctorcode = 'DTC'.$maxanum1;
	$openingbalance = '0.00';
	$consultationpercentage = '0.00';
	$ipserpercentage = '0.00';
	$pvtdrpercentage = '0.00';
	//echo $companycode;
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Doctor To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
?>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }

<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
.ui-menu .ui-menu-item {
zoom :1 !important;
}
</style>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here
function functionaddemp()
{
	employeename=$('#employee').val();
	employeecode=$('#employeecode').val();
	docusername=$('#docusername').val();
	if(employeecode == '' || docusername=='')
	{
		alert('Select a Proper User');
	}
	else{
		varHTML = '<tr id="'+employeecode+'"><td><input type="text" name="employee[]" readonly value="'+employeename+'"></td><td><input type="text" name="employeecode[]" readonly value="'+employeecode+'"></td><td><input type="text" name="docusername[]" readonly value="'+docusername+'"></td><td><input type="button" onclick="'+"delemp('"+employeecode+"')"+'" readonly value="Del"></td></tr>';
		$('#emptbody').append(varHTML);
		$('#employee').val('');
		$('#employeecode').val('');
		$('#docusername').val('');
	}
	
}	
function delemp(el)
{
	$('#'+el+'').remove();
}
function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}
function onloadfunction1()
{
	document.form1.doctorname.focus();	
}
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}
function processflowitem1()
{
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="css/autocomplete.css" rel="stylesheet"/>
</head>
<script language="javascript">
$(function() {
	
$('#employee').autocomplete({
	source:'ajaxemployeesearch.php', 
	//alert(source);
	delay: 0,
	html: true, 
		select: function(event,ui){
			var docusername = ui.item.docusername;
			var employeecode = ui.item.employeecode;
			$('#employee').val(ui.item.value);
			$('#employeecode').val(employeecode);
			$('#docusername').val(docusername);
			},
    }).keydown(function(){
		$('#employeecode').val('');
			$('#docusername').val('');
		
	});
	
		$('#doctorname').autocomplete({
		source:'search_doctor.php', 
		//alert(source);
		delay: 0,
		html: true, 
		select: function(event,ui){
		$('#doctorcode').val(ui.item.id);
		},
		}).keydown(function(){
		$('#doctorcode').val(ui.item.id);
		});
		
		$('#searchdoctor').autocomplete({
		source:'get_doctor.php', 
		delay: 0,
		html: true, 
		select: function(event,ui){
		$('#searchdoctor').val(ui.item.accountname);
		},
		});
});
function process1()
{
	if (document.form1.doctorcode.value == "")
	{
		alert ("Doctor Code Cannot Be Empty.");
		document.form1.doctorcode.focus();
		return false;
	}
	if (document.form1.doctorname.value == "")
	{
		alert ("Doctor Name Cannot Be Empty.");
		document.form1.doctorname.focus();
		return false;
	}
/*	else if (document.form1.address1.value == "")
	{
		alert ("Address1  Cannot Be Empty.");
		document.form1.address1.focus();
		return false;
	}
*/
/*
	else if (document.form1.state.value == "")
	{
		alert ("State Cannot Be Empty.");
		document.form1.state.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		alert ("City Cannot Be Empty.");
		document.form1.city.focus();
		return false;
	}
*/
/*
	else if (isNaN(document.getElementById("pincode").value))
	{
		alert ("Pincode Can Only Be Numbers");
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
*/
/*
	if (document.form1.openingbalance.value == "")
	{
		alert ("Opening Balance Cannot Be Empty.");
		document.form1.openingbalance.value = "0.00";
		document.form1.openingbalance.focus();
		return false;
	}
	if (isNaN(document.form1.openingbalance.value))
	{
		alert ("Opening Balance Can Only Be Numbers.");
		document.form1.openingbalance.focus();
		return false;
	}
*/
	/*if (document.form1.consultationfees.value == "")
	{
		alert ("Consultation Fees Cannot Be Empty.");
		document.form1.consultationfees.value = "0.00";
		document.form1.consultationfees.focus();
		return false;
	}
	if (isNaN(document.form1.consultationfees.value))
	{
		alert ("Consultation Fees Can Only Be Numbers.");
		document.form1.consultationfees.focus();
		return false;
	} */
	if (document.form1.department.value == "")
	{
		alert ("Department Cannot Be Empty.");
		document.form1.department.value = "0.00";
		document.form1.department.focus();
		return false;
	}

	/*if(document.getElementById("ipresdoctor").checked==true)
    {
		 if (document.form1.resdoclimit.value == "")
		{
			alert ("Resident Doctor Limit Cannot Be Empty.");
			document.form1.resdoclimit.value = "0.00";
			document.form1.resdoclimit.focus();
			return false;
		}
		 if (document.form1.resdoclimitext.value == "")
		{
			alert ("Resident Doctor Limit Ext. Cannot Be Empty.");
			document.form1.resdoclimitext.value = "0.00";
			document.form1.resdoclimitext.focus();
			return false;
		}
		 if (document.form1.resdocshar.value == "")
		{
			alert ("Starting Share Per. Cannot Be Empty.");
			document.form1.resdocshar.value = "0";
			document.form1.resdocshar.focus();
			return false;
		}
		 if (document.form1.resdocsharext.value == "")
		{
			alert ("Ext. Sharing Per. Cannot Be Empty.");
			document.form1.resdocsharext.value = "0";
			document.form1.resdocsharext.focus();
			return false;
		}
	}*/

	//return false;
}
</script>
<script>

function showrescharge()
   {
	    if(document.getElementById("ipresdoctor").checked==true)
		 {
	     	document.getElementById("residentarea").hidden=false;
		    document.getElementById("residentareaper").hidden=false;
		 }else{

            document.getElementById("residentarea").hidden=true;
		    document.getElementById("residentareaper").hidden=true;
		 }
   }
                 function showdoctorscharge()
				 {
					 if(document.getElementById("ipdoctor").checked==true)
					 {
					document.getElementById("residentdoc").hidden=false;
					document.getElementById("privatedoc").hidden=false;
					 }
					 else
					 {
					document.getElementById("residentdoc").hidden=true;
					document.getElementById("privatedoc").hidden=true;
					document.getElementById("resdoccharge").value='';
					document.getElementById("pridoccharge").value='';
						 }
					 }
					 
					 function selectcharge(val)
				 {
					 if(val=='res')
					 {
						 document.getElementById("pridoccharge").disabled=true;
						 document.getElementById("pridoccharge").value='';
						 document.getElementById("resdoccharge").disabled=false;
						 }
						 
						 else
					 {
						 document.getElementById("pridoccharge").disabled=false;
						 document.getElementById("resdoccharge").disabled=true;
						 document.getElementById("resdoccharge").value='';
						 }
					 
					 }
                 </script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchdoctor.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function ajaxdepartment(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("department").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxdepartment.php?loc="+str,true);
xmlhttp.send();
}
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here
function consult()
{
	var drfees = document.getElementById("hospitalfees").value;
	if(drfees == "") { drfees = "0.00"; }
	var hospfees = document.getElementById("doctorfees").value;
	if(hospfees == "") { hospfees = "0.00"; }
	var consultation = parseFloat(drfees) + parseFloat(hospfees);
	var consultation = consultation.toFixed(2);
	document.getElementById("consultationfees").value = consultation;
}

function checkConsPercentage(){
	var percentage = document.getElementById('consultationpercentage').value;
	if(percentage > 100){
		alert('Consultation percentage cannot be greater than 100');
		document.getElementById('consultationpercentage').value = '';
	}
}
function pvtcheckConsPercentage(){
	var percentage = document.getElementById('pvtconsultationpercentage').value;
	if(percentage > 100){
		alert('Consultation percentage cannot be greater than 100');
		document.getElementById('pvtconsultationpercentage').value = '';
	}
}

function checkServPercentage(){
	var percentage = document.getElementById('ipserpercentage').value;
	if(percentage > 100){
		alert('IP Service percentage cannot be greater than 100');
		document.getElementById('ipserpercentage').value = '';
	}
}

function checkPvtDrPercentage(){
	var percentage = document.getElementById('pvtdrpercentage').value;
	if(percentage > 100){
		alert('Pvt. Dr percentage cannot be greater than 100');
		document.getElementById('pvtdrpercentage').value = '';
	}
}
function pvtcheckPvtDrPercentage(){
	var percentage = document.getElementById('ippvtdrpercentage').value;
	if(percentage > 100){
		alert('Pvt. Dr percentage cannot be greater than 100');
		document.getElementById('ippvtdrpercentage').value = '';
	}
}

</script>
<body onLoad="return onloadfunction1()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      	 <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="adddoctor1.php" onSubmit="return process1()">
      	  	 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="964" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan=""><strong>Doctor - New </strong></td>
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="">* Indicated Mandatory Fields. </td>
                
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                              
                <td  colspan="2" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location: </strong>
             
            
                  <?php
						
	if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
						
						
                  
                  </td>
                  
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
                <tr>
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5"><span class="bodytext3">
               <select name="location" id="location" <?php /*?>onChange="return funclocationChange1();"<?php */?>
                onChange="ajaxdepartment(this.value);ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <option value="">-Select Location-</option>
				  <?php
						
						$query1 = "select * from master_location where  status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" ><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
				<tr>
                <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Doctor Name   *</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input type="text" name="doctorname" id="doctorname" size="40" autocomplete="off" />
				  <input type="hidden" name="paynowlabtype6" id="paynowcashtype" size="10"/>
						
</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" width="10%"><span class="bodytext32">Department</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				<strong>
				<select name="department" id="department">
                <option value="" selected="selected">Select Department</option>
				 <?php /*?> <?php
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
				?>
                  <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>
                  <?php
				}
				?><?php */?>
                </select>
				</strong></td>
				</tr>
			    <tr>
			     
			        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Doctor Code   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="doctorcode" id="doctorcode" value="" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20"></td>
                   
                      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Consultation Fees  </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationfees" id="consultationfees" readonly value="<?php echo $consultationfees; ?>" style="border: 1px solid #001E6A; background-color:#ecf0f5;"  size="20" /></td>
		          </tr>
					<tr style="display:none">
                     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Hospital Fee </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="hospitalfees" id="hospitalfees" onKeyUp="return consult();" value="<?php //echo $consultationfees; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Doctor Fee </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="doctorfees" id="doctorfees" onKeyUp="return consult();" value="<?php //echo $consultationfees; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
			     
			        </tr>
			    <tr style="display:none">
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 1 </td>
			    <td width="41%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address1" id="address1" value="<?php echo $address1; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 2 </td>
                <td width="31%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address2" id="address2" value="<?php echo $address2; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
			  </tr>
              <tr style="display:none">
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31"><span class="bodytext32">County </span></span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="state" id="state" onChange="return processflowitem1()">
                  <?php
		 			 	if ($state != '') 
		  	{
			  echo '<option value="'.$state.'" selected="selected">'.$state.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_state where status <> 'deleted' order by state";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.state".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$state = $res1["state"];
			?>
                  <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                  <?php
			  }
			  ?>
                </select>
-->				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">City</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="city" id="city" value="<?php echo $city; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="city" id="city" >
                  <option value="">Select City</option>
                </select>
-->				   </td>
              </tr style="display:none"> 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Area</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext31">
				     <input name="area" id="area" value="<?php echo $location; ?>" style="border: 1px solid #001E6A;"  size="20" />
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Country </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="country" id="country" value="<?php echo $country; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="country" id="select">
                    <?php
		 	if ($country != '') 
		  	{
			  echo '<option value="'.$country.'" selected="selected">'.$country.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_country where status <> 'deleted' order by country";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1.country".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$country = $res1["country"];
			if ($country == 'India') { $selectedcountry = 'selected="selected"'; }
			?>
                    <option <?php echo $selectedcountry; ?> value="<?php echo $country; ?>"><?php echo $country; ?></option>
                    <?php
			  $selectedcountry = '';
				  
			  }
			  ?>
                  </select>                
-->				   </td>
			      </tr>
				 <tr style="display:none">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Post Box </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="pincode" id="pincode" value="<?php echo $pincode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Mobile Number </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="mobilenumber" id="mobilenumber" value="<?php echo $faxnumber2; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 </tr>
				 <tr style="display:none">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 1  </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" style="border: 1px solid #001E6A;" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 2 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" style="border: 1px solid #001E6A;"  size="20"></td>
			      </tr>
				 <tr style="display:none">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 1 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" style="border: 1px solid #001E6A"  size="20">
			        <input type="hidden" name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 2 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" style="border: 1px solid #001E6A"  size="20">
			        <input type="hidden" name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="border: 1px solid #001E6A; text-transform: uppercase;"  size="20" /></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" style="display:none">Opening Balance  </td>
			        <td style="display:none"><input type="text" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="border: 1px solid #001E6A; text-align:right" size="20"></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">OP Consultation %</td>
                   
                    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Hospital <input type="text" onKeyUp="checkConsPercentage()" name="consultationpercentage" id="consultationpercentage" value="<?php echo $consultationpercentage; ?>" style="border: 1px solid #001E6A; text-align:right" size="10"></td>
                    
                     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >Private  </td>
			        <td ><input type="text" onKeyUp="pvtcheckConsPercentage()" name="pvtconsultationpercentage" id="pvtconsultationpercentage" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="10"></td>
                   
                   <!--
			        <td class="bodytext3">Hospital <input type="text" onKeyUp="checkConsPercentage()" name="consultationpercentage" id="consultationpercentage" value="<?php echo $consultationpercentage; ?>" style="border: 1px solid #001E6A; text-align:right" size="5">&nbsp;&nbsp;Private <input type="text" onKeyUp="pvtcheckConsPercentage()" name="pvtconsultationpercentage" id="pvtconsultationpercentage" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="5"></td>-->
					
				   </tr>
				   <tr>
				   	<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">IP Service Percentage</td>
			        <td><input type="text" onKeyUp="checkServPercentage()" name="ipserpercentage" id="ipserpercentage" value="<?php echo $ipserpercentage; ?>" style="border: 1px solid #001E6A; text-align:right" size="20"></td>

			        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">IP Pvt. Dr Percentage</td>
			        <td class="bodytext3">Hospital <input type="text" onKeyUp="checkPvtDrPercentage()" name="pvtdrpercentage" id="pvtdrpercentage" value="<?php echo $pvtdrpercentage; ?>" style="border: 1px solid #001E6A; text-align:right" size="5">&nbsp;&nbsp;Private <input type="text" onKeyUp="pvtcheckPvtDrPercentage()" name="ippvtdrpercentage" id="ippvtdrpercentage" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="5"></td>
				   </tr>
				   <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Is IP doctor ? </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ipdoctor" id="ipdoctor" value="1" onClick="showdoctorscharge()"></td>


				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Max. Appointments</td>
			        <td><input type="text" name="max_appt" id="max_appt"  style="border: 1px solid #001E6A; text-align:left" size="20"></td>
 					</tr>
 					<tr>
 					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Is Staff ? </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="isstaff" id="isstaff" value="1"></td>
				   
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Exclude Allocation  </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="excludeallocation" id="excludeallocation" value="1"></td>
				   
 					</tr>
					 <tr>
				 <!--<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Is Resident doctor ? </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ipresdoctor" id="ipresdoctor" value="1" onClick="showrescharge()"></td>-->
				    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> </td>
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> </td>
				    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
			        <td></td>
				 </tr>


				 <tr id="residentarea"  hidden="true">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Resident Doctor Limit</td>
			        <td><input type="text" name="resdoclimit" id="resdoclimit" style="border: 1px solid #001E6A; text-align:right" size="15"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Resident Limit Ext</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="resdoclimitext" id="resdoclimitext" style="border: 1px solid #001E6A; text-align:right" size="15"></td>
				 </tr>

				  <tr id="residentareaper"  hidden="true">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Resident Doc. Sharing Start %</td>
			        <td><input type="text" name="resdocshar" id="resdocshar" style="border: 1px solid #001E6A; text-align:right" size="5"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Resident Doc. Sharing Ext %</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="resdocsharext" id="resdocsharext" style="border: 1px solid #001E6A; text-align:right" size="5"></td>
				 </tr>
					
				 
				  <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Available Week Days </td></tr>
				   <tr>
				   
				    <?php  $weekdays_qry = "select id,weekday from weekdays where status = 1";
						$weekdays_exec = mysqli_query($GLOBALS["___mysqli_ston"], $weekdays_qry) or die ("Error in Weekdays Query".mysqli_error($GLOBALS["___mysqli_ston"]));
						//$result = mysql_fetch_array($exec);
						$inc = 1;
						while($weekdays_res = mysqli_fetch_assoc($weekdays_exec)) { 
							if($inc == 4) 
								echo '</tr><tr>';
							?>
							<td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
							<label><?php echo  $weekdays_res['weekday']; ?> </label>
							<input type="checkbox" name="weekday[]"  id="weekday_<?php echo $weekdays_res['id'] ?>" value="<?php echo $weekdays_res['id'] ?>"></td>
						<?php 
						$inc +=1;
					} ?>
				 </tr>
				
                  <tr id="residentdoc" hidden="true">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Resident Doctor Charge </td>
			        <td><input type="text" name="resdoccharge" id="resdoccharge" style="border: 1px solid #001E6A; text-align:right" size="15"><input name="chargerad" type="radio"  onClick="selectcharge('res')" checked></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
                 <tr  id="privatedoc" hidden="true">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Private Doctor Charge </td>
			        <td><input type="text" name="pridoccharge" id="pridoccharge" style="border: 1px solid #001E6A; text-align:right" disabled  size="15" ><input type="radio"  name="chargerad"   onClick="selectcharge('pri')"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
                 <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			      </tr>
				  <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Employees Link</td>
				   </tr>
				   <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Employee name</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Employee Code</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Employee Username</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Action</td>
				   </tr>
				   <tbody id="emptbody">
				   <?php
				   $i=1;


				   $query11 = "select * from doctor_mapping where status <> 'deleted' and doctorcode = '$doctorcode'";
				   $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($res11 = mysqli_fetch_array($exec11))
				   {
					   $employeename = $res11['employeename'];
					   $employeecode = $res11['employeecode'];
					   $docusername = $res11['docusername'];
				   ?>
				    <tr id ='<?= $employeecode?>'>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="employee[]" value='<?= $employeename?>' style="border: 1px solid #001E6A; text-transform: uppercase;">
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="employeecode[]"  value='<?= $employeecode?>' readonly>
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="docusername[]"  value='<?= $docusername?>' readonly>
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="button" value="Del" onClick="return delemp('<?= $employeecode?>');">
				   </td>
				   </tr>
				   <?php
				   }
				   ?>
				   </tbody>
				   <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="employee[]" id="employee" value='' style="border: 1px solid #001E6A; text-transform: uppercase;">
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="employeecode[]" id="employeecode" value='' readonly>
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="text" name="docusername[]" id="docusername" value='' readonly>
				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input type="button" value="Add" onClick="functionaddemp();">
				   </td>
				  </tr>
				 <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			      </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Doctor" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
		</form>
		<form method="post" action="adddoctor1.php">
        <tr>
          <td>
		  <table width="924" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
			<tr bgcolor="#ecf0f5">
			<td colspan="10" align="left" class="bodytext31"><strong>Master Doctor - Existing</strong></td>
			</tr>
			<tr bgcolor="#FFFFFF">
			<td colspan="10" align="left" class="bodytext31"><input type="text" name="searchdoctor"  id="searchdoctor" size="40" value="<?php echo $searchdoctor; ?>" />
			&nbsp;&nbsp;<input type="submit" name="submit345" value="Search"></td>
			</tr>
			<tr>
			<th width="68" align="left" class="bodytext31"><strong>S.No</strong></th>
			<th width="126" align="left" class="bodytext31"><strong>Doctor Code</strong></th>
			<th width="320" align="left" class="bodytext31"><strong>Doctor Name</strong></th>
			<th width="320" align="left" class="bodytext31"><strong>Department</strong></th>
			<th width="132" align="right" class="bodytext31"><strong>Consultation Fee</strong></th>
			<th width="32" align="left" class="bodytext31">&nbsp;</th>
			<th width="125" align="left" class="bodytext31"><strong>Location</strong></th>
			<th width="65" align="left" class="bodytext31"><strong>Edit</strong></td>
			</tr>
			<?php
			$sno = 0;
			$colorloopcount = 0;
			$query11 = "select * from master_doctor where doctorname like '%$searchdoctor%' and status <> 'deleted' order by doctorname";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res11 = mysqli_fetch_array($exec11))
			{
			$sno = $sno + 1;
			$doctorcode = $res11['doctorcode'];
			$doctorname = $res11['doctorname'];
			$consultationfees = $res11['consultationfees'];
			$locationname = $res11['locationname'];
			
			$department = $res11['department'];
			
			
			$query110 = "select * from master_department where auto_number = '$department' and recordstatus <> 'deleted'";
			$exec110= mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res110 = mysqli_fetch_array($exec110);
			$res110department = $res110['department'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<tr <?php echo $colorcode; ?>>
			<td align="left" class="bodytext31"><?php echo $sno; ?></td>
			<td align="left" class="bodytext31"><?php echo $doctorcode; ?></td>
			<td align="left" class="bodytext31"><?php echo $doctorname; ?></td>
			<td align="left" class="bodytext31"><?php echo $res110department; ?></td>
			<td align="right" class="bodytext31"><?php echo $consultationfees; ?></td>
			<td align="left" class="bodytext31">&nbsp;</td>
			<td align="left" class="bodytext31"><?php echo $locationname; ?></td>
			<td align="left" class="bodytext31"><a href="editdoctor1.php?st=edit&&doctorcode=<?php echo $doctorcode; ?>&&menuid=<?php echo $menu_id; ?>">Edit</a></td>
			</tr>
			<?php
			} 
			?>
			</tbody>
			</table>
		  </td>
        </tr>
		</form>
    </table>
	
<script language="javascript">
</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
