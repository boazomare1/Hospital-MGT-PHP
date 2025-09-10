<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;include ("includes/check_user_access.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$registrationdate = date('Y-m-d');
$registrationtime = date('H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];
$searchpaymenttype= '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	
 $query3 = "select * from master_location as ml LEFT JOIN login_locationdetails as ll ON ml.locationcode=ll.locationcode where ll.docno = '".$docno."' order by ml.locationname";
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
 $patientcodeprefix = 'EMER';
 $suffix =  date('y');
 

 
$patientcodeprefix1=strlen($patientcodeprefix);
 $query2 = "select customercode,auto_number from master_customer order by auto_number desc limit 0, 1"; 
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2customercode = $res2["customercode"];
 $res2auto_number = $res2["auto_number"];
if ($res2customercode == '')
{
	//$customercode = 'AMF00000001';
	$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;  
	$openingbalance = '0.00';
}
else
{
	$res2customercode = $res2["customercode"];
	//echo $res2customercode;

	//$customercode11 = explode("-",$res2customercode);
	//$customercode=$customercode11[1];
	// $customercode = intval($customercode);
	
	//$customercode = $customercode + 1;
	$customercode = $res2auto_number + 1;
//echo $customercode;
	$maxanum = $customercode;
	
	 $maxanum;
	
	//$customercode = 'AMF'.$maxanum1;
	$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
	$openingbalance = '0.00';
	//echo $companycode;
}
	
	
	//$customercode = 'AMF'.$maxanum1;
	
	$customername = $_REQUEST["customername"];
	$customername = strtoupper($customername);
	$customername = trim($customername);
	$customername = addslashes($customername);
	$gender = $_REQUEST["gender"];
	
	$mothername=$_REQUEST['mothername'];
	$mothername = strtoupper($mothername);
	$mothername = trim($mothername);
	$mothername = addslashes($mothername);
	
	$subtype = $_REQUEST['searchsubcode'];
	$age = $_REQUEST["age"];
	$typeofcustomer='';
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
	$mrdno = $_REQUEST["mrdno"];
	$promotion = $_REQUEST["promotion"];
	$faxnumber = '';
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks ='';
	$status ='';
	$tinnumber =$_REQUEST["tinnumber"];
	$cstnumber =$_REQUEST["cstnumber"];
	$openingbalance =$_REQUEST["openingbalance"];
	$insuranceid =$_REQUEST["insuranceid"];
	$nameofrelative = $_REQUEST['nameofrelative'];
	$dateofbirth = $_REQUEST['dateofbirth'];
	$maritalstatus = $_REQUEST['maritalstatus'];
	$occupation = $_REQUEST['occupation'];
	$nationalidnumber = $_REQUEST['nationalidnumber']; 
	$ageduration = $_REQUEST['ageduration'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$registrationdate = $_REQUEST['registrationdate'];
	$registrationtime = $_REQUEST['registrationtime'];
	$emer_patienttype = $_REQUEST['emer_patienttype'];
	
	$customermiddlename = $_REQUEST['customermiddlename'];
	$customermiddlename = strtoupper($customermiddlename);
	$customermiddlename = trim($customermiddlename);
	$customermiddlename = addslashes($customermiddlename);
	
	$customerlastname = $_REQUEST['customerlastname'];
	$customerlastname = strtoupper($customerlastname);
	$customerlastname = trim($customerlastname);
	$customerlastname = addslashes($customerlastname);
	$customerfullname=$customername.' '.$customermiddlename.' '.$customerlastname;

	$kinname = $_REQUEST['kinname'];
	$kincontactnumber = $_REQUEST['kincontactnumber'];
	$salutation = $_REQUEST['salutation'];
	
	$paymenttype = $_REQUEST['searchpaymentcode'];
	$subtype = $_REQUEST['searchsubcode'];
	$billtype = $_REQUEST['billtype'];
	$accountname = $_REQUEST['searchaccountcode'];
	$planname = $_REQUEST['planname'];
	$planvaliditystart = $_REQUEST['planvaliditystart'];
	$planexiprydate = $_REQUEST['planexpirydate'];
	$visitlimit = $_REQUEST['visitlimit'];	
	
	$maintype = $_REQUEST['searchpaymentcode'];
	$subtype = $_REQUEST['searchsubcode'];
	$accountexpirydate = $_REQUEST['accountexpirydate'];
	$planexpirydate = $_REQUEST['planexpirydate'];
	$overalllimit = $_REQUEST['overalllimit'];
	$ipoveralllimit = $_REQUEST['ipoveralllimit'];
	
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentage = $_REQUEST["planpercentage"];
	$buttonname = $_REQUEST['Submit222'];
	
	
	//$customercode=$_REQUEST['customercode'];
	$locationcode=$_REQUEST['location'];
	
	
	$query2 = "select * from master_customer where customercode = '$customercode' and nationalidnumber = '$nationalidnumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		
		$date = date('Y-m-d-H-i-s');
		$uploaddir = "patientphoto";
		//$final_filename="$companyname.jpg";
		$final_filename = "$customercode.jpg";
		$uploadfile123 = $uploaddir . "/" . $final_filename;
		$target_path = $uploadfile123;
		$imagepath = $target_path;
		
		//echo $_FILES['browse1']['name'];
		if ($_FILES['browse1']['name'] != '')
		{
			if(move_uploaded_file($_FILES['browse1']['tmp_name'], $target_path)) 
			{
			
				$query1 = "insert into master_customer (customercode,customername,typeofcustomer,address1,address2,
				area,city,state,country,pincode,phonenumber1,phonenumber2,faxnumber,mobilenumber,emailid1, emailid2,
				remarks, status, tinnumber, cstnumber, openingbalance, insuranceid, 
				gender, mothername,age, nameofrelative, dateofbirth, maritalstatus, occupation, nationalidnumber, 
				ageduration, salutation, bloodgroup, registrationdate, registrationtime, customerlastname,customerfullname,
				kinname, kincontactnumber, paymenttype,subtype,planname, 
				planvaliditystart, accountname, customermiddlename,visitlimit, 
				maintype, billtype,accountexpirydate, planexpirydate, overalllimit, planfixedamount, planpercentage, mrdno, promotion,username,locationcode,emer_patienttype,memberno,ipoveralllimit) 
				values('$customercode','$customername','$typeofcustomer','$address1','$address2','$area','$city',
				'$state','$country','$pincode','$phonenumber1','$phonenumber2','$faxnumber','$mobilenumber','$emailid1',
				'$emailid2','$remarks','$status', '$tinnumber', '$cstnumber', '$openingbalance', '$insuranceid', 
				'$gender','$mothername', '$age', '$nameofrelative', '$dateofbirth', '$maritalstatus', '$occupation',    '$nationalidnumber', 
				'$ageduration', '$salutation', '$bloodgroup', '$registrationdate', '$registrationtime', '$customerlastname','$customerfullname',
				'$kinname', '$kincontactnumber', '$paymenttype','$subtype','$planname', 
				'$planvaliditystart', '$accountname', '$customermiddlename','$visitlimit', 
				'$maintype', '$billtype','$accountexpirydate', '$planexpirydate', '$overalllimit', '$planfixedamount', '$planpercentage', '$mrdno', '$promotion','$username','".$locationcode."','$emer_patienttype','$customercode','$ipoveralllimit')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
				//echo $errmsg = "Success. Photo Upload Completed.";
				$query1 = "update master_customer set photoavailable = 'YES' where customercode = '$customercode'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$status = 'success';
			}
			else
			{
				//echo $errmsg = "Failed. Photo Upload Not Completed. File Size More Than 100 KB Not Accepted.";
				$status = 'failed';
			}
		}
		else
		{
				$query1 = "insert into master_customer (customercode,customername,typeofcustomer,address1,address2,
				area,city,state,country,pincode,phonenumber1,phonenumber2,faxnumber,mobilenumber,emailid1, emailid2,
				remarks, status, tinnumber, cstnumber, openingbalance, insuranceid, 
				gender,mothername,age, nameofrelative, dateofbirth, maritalstatus, occupation, nationalidnumber, 
				ageduration, salutation, bloodgroup, registrationdate, registrationtime, customerlastname,customerfullname,
				kinname, kincontactnumber, paymenttype,subtype,billtype,planname, 
				planvaliditystart, accountname, customermiddlename,visitlimit, 
				maintype, accountexpirydate, planexpirydate, overalllimit, planfixedamount, planpercentage, mrdno, promotion,username,locationcode,emer_patienttype,memberno,ipoveralllimit) 
				values('$customercode','$customername','$typeofcustomer','$address1','$address2','$area','$city',
				'$state','$country','$pincode','$phonenumber1','$phonenumber2','$faxnumber','$mobilenumber','$emailid1',
				'$emailid2','$remarks','$status', '$tinnumber', '$cstnumber', '$openingbalance', '$insuranceid', 
				'$gender','$mothername', '$age', '$nameofrelative', '$dateofbirth', '$maritalstatus', '$occupation', '$nationalidnumber', 
				'$ageduration', '$salutation', '$bloodgroup', '$registrationdate', '$registrationtime', '$customerlastname','$customerfullname',
				'$kinname', '$kincontactnumber', '$paymenttype','$subtype','$billtype','$planname', 
				'$planvaliditystart', '$accountname', '$customermiddlename','$visitlimit', 
				'$maintype', '$accountexpirydate', '$planexpirydate', '$overalllimit', '$planfixedamount', '$planpercentage', '$mrdno', '$promotion','$username','".$locationcode."','$emer_patienttype','$customercode','$ipoveralllimit')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$status = 'success';
		}
		
		$query102 = "select * from master_customer where registrationdate = '$registrationdate' and registrationtime = '$registrationtime' order by auto_number desc limit 0,1" ;
	    $exec102 = mysqli_query($GLOBALS["___mysqli_ston"], $query102) or die ("Error in Query102".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res102 = mysqli_fetch_array($exec102);
		$previouscustomercode = $res102['customercode'];
			
		$customername = '';
		$companyname = '';
		$gender = '';
		$mothername='';
		$age = '';
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
		$insuranceid = '';
		$nameofrelative = '';
		$dateposted = $updatedatetime;
		$dateofbirth = '';
		$maritalstatus = '';
		$occupation = '';
		$nationalidnumber = '';
		$ageduration = '';
		$bloodgroup = '';
		$customerlastname = '';
		$kinname = '';
		$kincontactnumber = '';
		$salutation = '';
	
		$customername = '';
		$customermiddlename = '';
		$customerlastname = '';
		$paymenttype = '';
		$subtype = '';
		$billtype = '';
		$accountname = '';
		$planname = '';
		$planvaliditystart = '';
		$planvalidityend = '';
		$visitlimit='';
	
		$maintype = '';
		$subtype = '';
		$accountexpirydate = '';
		$planexpirydate = '';
		$overalllimit = '';
	
		$planfixedamount = '';
		$planpercentage = '';
		
		
	}
	else
	{
		$status = 'failed';
		header ("location:addemergencypatient1.php?st=$status");
		exit;
	}
	if($buttonname == "Save Registration (Alt+S)")
	{
	header("location:addemergencypatient1.php?savedpatientcode=$previouscustomercode");
	exit;
		}
	if($buttonname == "Save & Go OP Visit (Alt+O)")
	{
	header("location:visitentry_op_new.php?patientcode=$previouscustomercode");
	exit;
		}
	if($buttonname == "Save & Go IP Visit (Alt+I)")
	{
	header("location:ipvisitentry_new.php?patientcode=$previouscustomercode");
	exit;
	}	
	
		exit;

}
else
{
	$customername = '';
	$companyname = "";
	$gender = '';
	$mothername='';
	$age = '';
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
	$insuranceid = "";
	$nameofrelative = '';
	$dateposted = $updatedatetime;
	$dateofbirth = '';
	$maritalstatus = '';
	$occupation = '';
	$nationalidnumber = '';
	$ageduration = '';
	$bloodgroup = '';
	$customerlastname = '';
	$kinname = '';
	$kincontactnumber = '';
	$salutation = '';

	$customername = '';
	$customermiddlename = '';
	$customerlastname = '';
	$paymenttype = '';
	$subtype = '';
	$billtype = '';
	$accountname = '';
	$planname = '';
	$planvaliditystart = '';
	$planexpiredate = '';
	$visitlimit = '';
	
	$maintype = '';
	$subtype = '';
	$accountexpirydate = '';
	$planexpirydate = '';
	$overalllimit = '';
	
	$planfixedamount = '';
	$planpercentage = '';
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Patient Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Patient Updated.";
		}
		$bgcolorcode = 'success';
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Photo Upload Failed Or Patient Already Exists.";
		$bgcolorcode = 'failed';
}

if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
}

	
$query3 = "select * from login_locationdetails where docno = '".$docno."' and username = '$username' order by locationname";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3locationcode = $res3['locationcode'];

$query77 = "select * from master_location where locationcode = '$res3locationcode'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
 $patientcodeprefix = 'EMER';
 $suffix =  date('y');
 
 
$patientcodeprefix1=strlen($patientcodeprefix);
 $patientcodeprefix1=$patientcodeprefix1+1;
$query2 = "select customercode,auto_number from master_customer order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2customercode = $res2["customercode"];
 $res2auto_number = $res2["auto_number"];
$customercode11=array();
if ($res2customercode == '')
{
	//$customercode = 'AMF00000001';
	$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;
	$openingbalance = '0.00';
}
else
{
	
	$res2customercode = $res2["customercode"];
	//echo $res2customercode;

	//$customercode11 = explode("-",$res2customercode);
	//$customercode=$customercode11[1];
	// $customercode = intval($customercode);
	
	//$customercode = $customercode + 1;
	$customercode = $res2auto_number + 1;
//echo $customercode;
	$maxanum = $customercode;
	
	 $maxanum;
	
	//$customercode = 'AMF'.$maxanum1;
	$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
	$openingbalance = '0.00';
	//echo $companycode;
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Patient To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


include ("autocompletebuild_emergencypaymenttype.php");

?>  
<script type="text/javascript" src="js/autocomplete_paymenttype.js"></script>
<script type="text/javascript" src="js/autosuggestpaymenttype.js"></script>
<script type="text/javascript" src="js/autocomplete_subtypes.js"></script>
<script type="text/javascript" src="js/autosuggestsubtypes.js"></script>
<script type="text/javascript" src="js/autocomplete_account.js"></script>
<script type="text/javascript" src="js/autosuggestaccount.js"></script>

<script type="text/javascript" src="js/autocomplete_county.js"></script>
<script type="text/javascript" src="js/autosuggestcounty.js"></script>
<script type="text/javascript">
function funcautocomplete() 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchpaymenttype"), new StateSuggestions());
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsubtype"), new StateSuggestions1());
	var oTextbox = new AutoSuggestControl2(document.getElementById("searchaccountname"), new StateSuggestions2());  
	var oTextbox = new AutoSuggestControl23(document.getElementById("state"), new StateSuggestions3());        
      
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<script>
function funcPopupOnLoad1()
{
<?php 
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes+" ","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>

<script>
function funcPopupOnLoad2()
{
<?php 
if (isset($_REQUEST["savedpatientcode1"])) { $savedpatientcode1 = $_REQUEST["savedpatientcode1"]; } else { $savedpatientcode1 = ""; }
?>
var patientcodes1;
var patientcodes1 = "<?php echo $savedpatientcode1; ?>";
//alert(patientcodes1);
if(patientcodes1 != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes1+" ","OriginalWindowA5",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>

<script>
function funcPopupOnLoader()
{
funcautocomplete();
funcPopupOnLoad1();
funcPopupOnLoad2();
}
</script>

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

function GetDifference1()
{
	//To reset any existing values;
	document.getElementById("age").value = "";
	document.getElementById("ageduration").value = "";

	var dtFrom = document.getElementById("dateofbirth").value;
	var dtTo = document.getElementById("todaydate").value;
	//alert(dtFrom);
	//alert(dtTo);

   //To change format from YYYY-MM-DD to MM-DD-YYYY
    var mystr1 = dtFrom;
    var myarr1 = mystr1.split("-");
    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
    
    var mystr2 = dtTo;
    var myarr2 = mystr2.split("-");
    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
    
	var dtFrom = new Date(dtFrom);
	var dtTo = new Date(dtTo);
    
	//document.getElementById("totalmonths1").value = months_between(dtFrom, dtTo);
	var varMonthCount = months_between(dtFrom, dtTo);
	var varMonthCount = parseInt(varMonthCount);
	if (varMonthCount <= 12)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById("age").value = varMonthCount;
		document.getElementById('ageduration').value = 'MONTHS';
	}
	
	//alert (varMonthCount);
	//To Count Days.
	if (varMonthCount == 0)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById('ageduration').value = 'DAYS';
	
		var dtFrom = document.getElementById("dateofbirth").value;
		var dtTo = document.getElementById("todaydate").value;
		
		///*
		//To change format from YYYY-MM-DD to MM-DD-YYYY
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		//alert (myarr1);
	    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
		
		var mystr2 = dtTo;
		var myarr2 = mystr2.split("-");
	    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
		
		//alert (dtFrom);
		//alert (dtTo);
		
		var dtFrom = new Date(dtFrom);
		var dtTo = new Date(dtTo);
		
		//alert (dtFrom);
		//alert (dtTo);
		
		//*/
		
		// 24 hours, 60 minutes, 60 seconds, 1000 milliseconds
		var varDaysCount = Math.round((dtTo - dtFrom) / (1000 * 60 * 60 * 24)); // round the amount of days
		//alert (varDaysCount);
		document.getElementById("age").value = varDaysCount;

	}
	
	if (varMonthCount > 12)
	{
		var dtFrom = document.getElementById("dateofbirth").value;
		//alert(dtFrom);
	
	   //To change format from YYYY-MM-DD to YYYYMMDD
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		var dtFrom = myarr1[0] + "" + myarr1[1] + "" + myarr1[2];
		//alert (dtFrom);
		
		//var dob='19800810';
		var dob = dtFrom;
		var year = Number( dob.substr(0,4) );
		var month = Number( dob.substr(4,2) ) - 1;
		var day = Number( dob.substr(6,2) );
		var today = new Date();
		var age = today.getFullYear() - year;
		if( today.getMonth() < month || ( today.getMonth() == month && today.getDate() < day )) { age--; }
		//alert(age);
		var varYearsCount = age;
		
		document.getElementById('ageduration').value = 'YEARS';
		document.getElementById("age").value = varYearsCount;
	}
	idhide();
	
}

function months_between(date1, date2)
{
	return date2.getMonth() - date1.getMonth() + (12 * (date2.getFullYear() - date1.getFullYear()));
}

function dobcalc()
{
var age=document.getElementById("age").value;
document.getElementById('ageduration').value = 'YEARS';
var year1= new Date();
var yob=year1.getFullYear() - age;
var dob= yob+"-"+"0"+1+"-"+"0"+1;
document.getElementById("dateofbirth").value = dob;
//alert(dob);
}

function process1backkeypress1()
{
	
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function funcGenderAutoSelect1()
{
	
	<?php
	$query11 = "select * from master_salutation where recordstatus = ''";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11salutation = $res11["salutation"];
	$res11gender = $res11['gender'];
	?>
		if(document.form1.salutation.value == "<?php echo $res11salutation; ?>")
		{
			document.getElementById("gender").value = "<?php echo $res11gender; ?>";
		}
	<?php
	}
	
	?>
	
}
function funcVistLimit()
{
	var varPlanName = document.getElementById("planname").value;
	var dataString = "planname="+varPlanName;
	$.ajax({
		url: "customerplanlimit.php",
		method: "GET",
		data: dataString,
		success: function(data){
			var dataSplit = data.split("|");
			//alert(dataSplit[0]);
			document.getElementById("planexpirydate").value = dataSplit[0];	
			document.getElementById("planfixedamount").value = dataSplit[1];
			document.getElementById("planpercentage").value = dataSplit[2];
			document.getElementById("visitlimit").value = dataSplit[3];
			document.getElementById("overalllimit").value = dataSplit[4];
			document.getElementById("ipvisitlimit").value = dataSplit[5];
			document.getElementById("ipoveralllimit").value = dataSplit[6];
		}
	});		
}


<?php /*?>function funcPaymentTypeChange1()
{alert('ok');
	document.getElementById("billtype").value = "";
	
	//alert (document.form1.paymenttype.value);

	if(document.form1.searchpaymentcode.value == "1") // For CASH
	{	
		document.getElementById("billtype").value = "PAY NOW";
	}
	else
	{
		document.getElementById("billtype").value = "PAY LATER";
	}	
	
	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12["auto_number"];
	$res12paymenttype = $res12["paymenttype"];
	?>
	if(document.getElementById("searchpaymentcode").value=="<?php echo $res12paymenttypeanum; ?>")
	{
		document.getElementById("subtype").options.length=null; 
		var combo = document.getElementById('subtype'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' order by subtype";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10subtypeanum = $res10["auto_number"];
		$res10subtype = $res10["subtype"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}<?php */?>


<?php /*?>function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_subtype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12subtypeanum = $res12["auto_number"];
	$res12subtype = $res12["subtype"];
	?>
	if(document.getElementById("subtype").value=="<?php echo $res12subtypeanum; ?>")
	{
		document.getElementById("accountname").options.length=null; 
		var combo = document.getElementById('accountname'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Account Name", ""); 
		<?php
		$query10 = "select * from master_accountname where subtype = '$res12subtypeanum' and recordstatus = 'ACTIVE' and expirydate > NOW() order by accountname";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$res10accountname = $res10["accountname"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountname;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}<?php */?>

<?php /*?>function funcAccountNameChange1()
{alert('work');<?php  if($functionval==1){ ?>
	<?php
	$query11 = "select * from master_accountname where recordstatus = 'ACTIVE'";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11accountnameanum = $res11["auto_number"];
	$res11accountname = $res11["accountname"];
	$res11expirydate = $res11["expirydate"];
	?>
		if(document.getElementById("searchaccountcode").value=="<?php echo $res11accountnameanum; ?>")
		{
		document.getElementById("accountexpirydate").value = "<?php echo $res11expirydate; ?>";
		
		document.getElementById("planname").options.length=null; 
		var combo = document.getElementById('planname'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Plan Name", ""); 
		<?php
		$query10 = "select * from master_planname where accountname = '$res11accountnameanum' and planexpirydate > NOW() and recordstatus <> 'deleted' order by planname";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10plannameanum = $res10["auto_number"];
		$res10planname=$res10["planname"];
		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10planname;?>", "<?php echo $res10plannameanum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?><?php }?>
	
}<?php */?>

	
function process1()
{
		

	
	var alpha = /^[a-zA-Z ]*$/; 
	//alert ("Inside Function");
	if (document.form1.searchpaymentcode.value == "")
	{
		alert ("Please Select Plan Type.");
		document.form1.searchpaymenttype.focus();
		return false;
	}
	if (document.form1.searchsubcode.value == "")
	{
		alert ("Please Select Sub Type.");
		document.form1.searchsubtype.focus();
		return false;
	}
	if (document.form1.searchaccountcode.value == "")
	{
		alert ("Please Select Account Name.");
		document.form1.searchaccountname.focus();
		return false;
	}
	if (document.form1.billtype.value == "PAY LATER")
	{
		if (document.form1.searchaccountname.value == "")
		{
			alert ("Please Select Account Name.");
			document.form1.searchaccountname.focus();
			return false;
		}
		if (document.form1.planname.value == "")
		{
			alert ("Please Select Plan Name.");
			document.form1.planname.focus();
			return false;
		}
	}
	/*
	if (document.form1.salutation.value == "")
	{
		alert ("Please Select Salutation.");
		document.form1.salutation.focus();
		return false;
	}
	*/
	if (document.form1.gender.value == "")
	{
		alert ("Please Select Gender");
		document.form1.gender.focus();
		return false;
	}
	if (document.form1.customername.value == "")
	{
		alert ("Please Enter First Name.");
		document.form1.customername.focus();
		return false;
	}

	//Submit222.disabled = true; return true;	
	if (confirm("Do You Want To Save The Record?")==false){return false;}
	 
printbill();
	
            
return true;
   
}

function namevalid(key)
{
/*	var alpha = /^[a-zA-Z ]*$/; 
	if (isNaN(document.form1.age.value))
	{
		alert ("Please Enter Number to Age");
		document.form1.age.focus();
		return false;
	}
	if(!alpha.test(document.form1.customername.value))
	{
		alert ("Please Enter Alphabet First Name.");
		document.form1.customername.focus();
		return false;
	}
	if(!alpha.test(document.form1.customermiddlename.value))
	{
		alert ("Please Enter Alphabet Middle Name.");
		document.form1.customermiddlename.focus();
		return false;
	}
	if(!alpha.test(document.form1.customerlastname.value))
	{
		alert ("Please Enter Alphabet Last Name.");
		document.form1.customerlastname.focus();
		return false;
	}*/
	 var keycode = (key.which) ? key.which : key.keyCode;

	 if(!(keycode < 48 || keycode > 57))
	{
		return false;
	}
}
function validatenumerics(key) {
           //getting key code of pressed key
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes

           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               //alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;
 

       }
function idhide()
{
	if(document.getElementById("ageduration").value=='YEARS')
	{
		if (document.getElementById("age").value < 18)
		{
			document.form1.nationalidnumber.disabled = true;
		}
		else
		{
			document.form1.nationalidnumber.disabled = false;
		}
	}
	else
	{
		document.form1.nationalidnumber.disabled = true;
	}
}

//location change code change
function locationform(frm,val)
{

<?php $query11 = "select * from master_location where 1";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$scriptlocationcode = $res11["locationcode"];
	$scriptlocationprefix = $res11["prefix"];
	?>
	if(document.getElementById("location").value=="<?php echo $scriptlocationcode; ?>")
		{
		document.getElementById("customercode").value = "<?php echo $scriptlocationprefix.'-'.$maxanum.'-'.date('y'); ?>";
		
		}
	<?php
	 }?>
	//document.form1.customercode.value='ok';
	
}
</script>

<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script type="text/javascript" src="js/nationalidnovalidation1.js"></script>
<script type="text/javascript" src="js/nationalidnovalidation2.js"></script>

<body onLoad="funcPopupOnLoader()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" enctype="multipart/form-data" action="addemergencypatient1.php" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1316" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="4"><strong> New Patient Registration </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td colspan="5" align="left" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						?>                  </td>
              </tr>
              <tr>
                <td colspan="15" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else  { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <tr><td  class="bodytext3" ><strong> Location </strong></td>
              <td  class="bodytext3" >
              <select name="location" id="location"   style="border: 1px solid #001E6A;" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno'  group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						<option value="<?php echo $locationcode; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>                  </tr>
               
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
	<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"> 
				  <input type="text" name="searchpaymenttype" id="searchpaymenttype" value="EMERGENCY" autocomplete="off" tabindex="1">
				  <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" VALUE='7'>
				  <?php /*?><select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();"  style="width: 150px; display:none;">
                  <option value="" selected="selected">Select Type</option>  
				  <?php
				$query5 = "select * from master_paymenttype where recordstatus = ''";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["paymenttype"];
				?>
                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
                  </select><?php */?></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input type="text" name="searchsubtype" id="searchsubtype" value="EMERGENCY" autocomplete="off" tabindex="2">
				  <input type="hidden" name="searchsubcode" id="searchsubcode" value='27'>
				  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
				 <?php /*?> <select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" style="display:none">
                    <option value="" selected="selected">Select Subtype</option>
<!--					
					<?php
				if ($subtype == '')
				{
					echo '<option value="" selected="selected">Select Subtype</option>';
				}
				else
				{
					$query51 = "select * from master_subtype where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51subtype = $res51["subtype"];
					echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';
				}
				
				$query5 = "select * from master_subtype where recordstatus = '' order by subtype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["subtype"];
				?>
                    <option value="<?php echo $res5paymenttype; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
-->				  
                  </select><?php */
				  $query51 = "select * from master_accountname where recordstatus = 'ACTIVE' and auto_number = '1814'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51accountname = $res51["accountname"];
					$accountexpirydate =  $res51["expirydate"];
				  ?>				  </td>
				  <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Account </span></td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				  <input name="searchaccountname" type="text" id="searchaccountname" value="<?=$res51accountname;?>" autocomplete="off" tabindex="3">
              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  <input name="searchaccountcode" id="searchaccountcode" value="1814" type="hidden">
						<?php /*?><select name="accountname" id="accountname" onChange="return funcAccountNameChange1()" style="display:none;">
                      <option value="" selected="selected">Select Account Name</option>
<!--					  
					  <?php
				if ($accountname == '')
				{
					echo '<option value="" selected="selected">Select Account Name</option>';
				}
				else
				{
					$query51 = "select * from master_accountname where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51accountname = $res51["accountname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51accountname.'" selected="selected">'.$res51accountname.'</option>';
				}
				
				$query5 = "select * from master_accountname where recordstatus = '' order by accountname";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5accountname = $res5["accountname"];
				?>
                      <option value="<?php echo $res5accountname; ?>"><?php echo $res5accountname; ?></option>
                      <?php
				}
				?>
-->				
                    </select><?php */?>
				    </strong></td>
					<td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Validity </span></td>
				  <td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountexpirydate" id="accountexpirydate" value="<?php echo $accountexpirydate; ?>" readonly  ></td>
				</tr>
				<tr>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Plan </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input type="hidden" name="planvaliditystart" id="planvaliditystart" value="<?php echo $registrationdate; ?>" readonly  >
                      <strong><span class="bodytext312"> 
					  <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('insurancevaliditystart')" style="cursor:pointer"/>-->
					  <input type="hidden" name="insuranceid" id="insuranceid" value="<?php echo $insuranceid; ?>"    size="20">
                      </span>
                      <select name="planname" id="planname"  onChange="return funcVistLimit()" style="width: 150px;" tabindex="4">
                      <option value="">Select Plan</option>
					<?php	$query5 = "select * from master_planname where accountname = '1814' order by planname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5accountname = $res5["planname"];
				$planexpirydate = $res5["planexpirydate"];
				?>
                      <option value="<?php echo $res5anum; ?>"><?php echo $res5accountname; ?></option>
                      <?php
				}
				?>
                      </select>
                      </strong></td>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Copay </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="planfixedamount" id="planfixedamount" readonly value=""  ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				  <input name="tpacompany" id="tpacompany" value="" type="hidden">
<!--				  
					<select name="tpacompany" id="tpacompany">
					<?php
					if ($tpacompany == '')
					{
					echo '<option value="" selected="selected">Select TPA Company</option>';
					}
					else
					{
					$query51 = "select * from master_tpacompany where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51tpacompany = $res51["tpacompany"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51tpacompany.'" selected="selected">'.$res51tpacompany.'</option>';
					}
					
					$query5 = "select * from master_tpacompany where recordstatus = '' order by tpacompany";
					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res5 = mysqli_fetch_array($exec5))
					{
					$res5anum = $res5["auto_number"];
					$res5tpacompany = $res5["tpacompany"];
					?>
					<option value="<?php echo $res5tpacompany; ?>"><?php echo $res5tpacompany; ?></option>
					<?php
					}
					?>
					</select>
-->
				  <input type="text" name="billtype" id="billtype" readonly value="PAY LATER" >
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				  <input type="text" name="overalllimit" id="overalllimit" readonly  >
				  <input type="hidden" name="planpercentage" id="planpercentage" readonly  >
				  <input type="hidden" name="visitlimit" id="visitlimit" value="" readonly  >
                  <input type="hidden" name="ipvisitlimit" id="ipvisitlimit" value="">
                  <input type="hidden" name="ipoveralllimit" id="ipoveralllimit" value="">
                  </td>
				  </tr>
				
				<tr>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Salutation</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				    <select name="salutation" id="salutation" style="width: 150px;" tabindex="5">
                      <?php
				if ($salutation == '')
				{
					echo '<option value="" selected="selected">Select Salutation</option>';
				}
				else
				{
					$query51 = "select * from master_salutation where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51salutation = $res51["salutation"];
					$res51gender = $res51['gender'];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51salutation.'" selected="selected">'.$res51salutation.' </option>';
				}
				
				$query5 = "select * from master_salutation where recordstatus = '' order by salutation";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5salutation = $res5["salutation"];
				$res5gender = $res5['gender'];
				?>
                      <option value="<?php echo $res5salutation; ?>"><?php echo $res5salutation; ?></option>
                      <?php
				}
				?>
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sex</td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <select name="gender" id="gender" tabindex="6">
				  <option value="">Select Sex</option>
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
				  </select>
				  
<!--				  
				  <select name="gender">
                      <option value="" selected="selected">Select Gender</option>
                      <option value="MALE">MALE</option>
                      <option value="FEMALE">FEMALE</option>
                    </select>  
-->					</td>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Type </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <select name="emer_patienttype" id="emer_patienttype">
				  <option value="ADULT">ADULT</option>
				  <option value="CHILD">CHILD</option>
				  </select>
				  <input type="hidden" name="dateofbirth" id="dateofbirth" value="" onChange="return GetDifference1()" style="background-color:#ecf0f5;" readonly>
                      <strong><span class="bodytext312"> </span></strong>
                      <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>"></td>
					  <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"></td>
			      <td align="left" valign="middle" bgcolor="#ecf0f5"><input name="age" type="hidden" maxlength="3" id="age" value="" size="5" onKeyUp="return dobcalc();" onBlur="return idhide();" onKeyPress="return validatenumerics(event);" tabindex="7">
			        <!--				  
				  <select name="age">
                    <option value="">Select Age</option>
					<?php
					for ($i=0;$i<=125;$i++)
					{
					?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php
					}
					?>
                  </select>
-->
                      <input type="hidden" name="ageduration" id="ageduration" value="" size="5" readonly>
					  <input type="hidden" name="planexpirydate" id="planexpirydate" value="<?php echo $planexpirydate; ?>" readonly  >
                      <!--					 
					 <select name="ageduration" id="ageduration">
                        <option value="YEARS" selected="selected">YEARS</option>
                        <option value="MONTHS">MONTHS</option>
                        <option value="DAYS">DAYS</option>
                      </select>
-->                  </td>
				</tr>
				
				<tr>
				  <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> First Name   </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="customername" id="customername" value="<?php echo 'EMERGENCY'; ?>" readonly style="text-transform:uppercase;" size="20" onKeyPress="return namevalid(event);" tabindex="8">
                  <input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" size="45"></td>
				<td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Middle Name   </span></td> 
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="<?php echo date('Y-m-d'); ?>" readonly style=" text-transform:uppercase;" size="20" onKeyPress="return namevalid(event);" tabindex="9"></td>
				<td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Last Name   </span></td> 
				<td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customerlastname" id="customerlastname" value="<?php echo date('H:i:s'); ?>" readonly style="text-transform:uppercase;" size="20" onKeyPress="return namevalid(event);" tabindex="10"></td>
				
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">National ID 				   </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input name="nationalidnumber" id="nationalidnumber" value=""  onBlur="return funcNationalIDValidation1()" style="text-transform:uppercase;" size="20" tabindex="11"/>				   </td>
				</tr>
				<tr>
				  <td colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Personal Details </strong></td>
				  </tr>
			    <tr>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Guardian </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
			        <input name="mothername" type="text" id="mothername" value="" size="20" />
			      </label></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Status </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="maritalstatus" style="width: 150px;">
                      <option value="" selected="selected">Select Marital Status</option>
                      <option value="SINGLE">SINGLE</option>
                      <option value="MARRIED">MARRIED</option>
                    </select>                  </td>
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Blood Group </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <select name="bloodgroup" id="bloodgroup" style="width: 150px;">
				  <option value="" selected="selected">Select Blood Group</option>
				  <?php
				  	$query55 = "select * from master_bloodgroup where recordstatus = '' order by bloodgroup";
				$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res55 = mysqli_fetch_array($exec55))
				{
				$res5anum = $res55["auto_number"];
				$res5bloodgroup = $res55["bloodgroup"];
				
				?>
                      <option value="<?php echo $res5bloodgroup; ?>"><?php echo $res5bloodgroup; ?></option>
                      <?php
				}
				?>
				  </select></td>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 1 </td>
			    <td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address1" id="address1" value="<?php echo $address1; ?>"    size="20" /></td>
	    	      </tr>
			   
			    <tr>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Occupation</td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="occupation" id="occupation" value="<?php echo $occupation; ?>" size="20" /></td>
			           <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">City </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="city" id="city" value="<?php echo $city; ?>"  size="20" />
<!--				
				<select name="city" id="city" >
                  <option value="">Select City</option>
                </select>
-->				   </td>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31"><span class="bodytext32">State </span></span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<!--<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />-->
				<input type="text" name="state" id="state" >
				<?php /*?><select name="state" id="state" onChange="return processflowitem1()" style="width: 150px;">
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
			$exec1 = mysql_query($query1) or die ("Error in Query1.state".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$state = $res1["state"];
			?>
                  <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                  <?php
			  }
			  ?>
                </select><?php */?>
                <input name="addpatientcountyhiddentextbox" id="addpatientcountyhiddentextbox" value="" type="hidden">
			  <input name="searchcountycode" id="searchcountycode" value="" type="hidden">			</td>
				<td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 2 </td>
                <td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="address2" id="address2" value="<?php echo $address2; ?>"    size="20" /></td>
			    </tr>
             
				
			 <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Area</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext31">
				     <input name="area" id="area" value="<?php echo $location; ?>"    size="20" />
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Post Box </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="pincode" id="pincode" value="<?php echo $pincode; ?>"    size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Country </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<!--<input name="country" id="country" value="<?php echo 'KENYA';//$country; ?>" style="border: 1px solid #001E6A"  size="20" />-->
			  <input type="text" name="country" id="country" value="KENYA" style="width: 150px;">
             <?php /*?> <select name="settingsvalue" id="settingsvalue" style="width: 150px;">
            <?php
			$query1 = "select * from master_settings where modulename = 'SETTINGS' and settingsname = 'DEFAULT_COUNTRY_SETTING' 
			and status <> 'deleted' and companyanum = '$companyanum' and companycode = '$companycode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1settingsvalue = $res1['settingsvalue'];
			?>
            <option value="<?php echo $res1settingsvalue; ?>" selected="selected"><?php echo $res1settingsvalue; ?></option>
            <?php
			}
			$query2 = "select * from master_country where status = ''";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2country = $res2['country'];
			$res2country = strtoupper($res2country);
			?>
            <option value="<?php echo $res2country; ?>"><?php echo $res2country; ?></option>
			<?php
			}
			?>
                </select><?php */?>				</td>
			      </tr>
				 <tr>
				   <td colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Contact Details </strong></td>
			      </tr>
				 <tr>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">MRD No. </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="mrdno" id="mrdno" value="<?php //echo $emailid1; ?>" size="20">			        </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Mobile No </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input name="mobilenumber" id="mobilenumber" value="<?php echo $faxnumber2; ?>"    size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 1 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" size="20">
			        <input type="hidden" name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" /></td>
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Next Kin</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="kinname" id="kinname" value="<?php echo $kinname; ?>" size="20" /></td>
			      </tr>
		
				 <tr>
                 
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  hidden="true">Promotion </td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" hidden="true"><select name="promotion" style="width: 150px;" hidden="true">
                      <option value="" selected="selected">Select Promotion</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>                  </td>
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Additional No  </td>
				    <td align="left" valign="middle"  bgcolor="#ecf0f5">
				   <input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>"   size="20" />
				   <input type="hidden" name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>"    size="20"></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 2 </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" size="20">
			        <input type="hidden" name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="text-transform: uppercase;"  size="20" /></td>
					 
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Kin Tel# </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="kincontactnumber" id="kincontactnumber" value="<?php echo $kincontactnumber; ?>" size="20" /></td>
				 <tr>
				   <td colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Misc  Details </strong></span></td>
			      </tr>
				 <tr>
				 <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Reg  Code </td>
				  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5"><strong><span class="bodytext312">
                    <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('insurancevalidityend')" style="cursor:pointer"/>-->
                    <input  name="customercode" id="customercode" value="<?php echo $customercode; ?>" readonly style=" background-color:#ecf0f5;" size="20">
                  </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Reg Date </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $registrationdate; ?>" readonly   style="background-color:#ecf0f5;" size="16">
                       <strong><span class="bodytext312"> <img src="images2/cal.gif" style="cursor:pointer"/> </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> Reg Time </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationtime" id="registrationtime" value="<?php echo $registrationtime; ?>"  style="background-color:#ecf0f5;">
			        <input type="hidden" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="border: 1px solid #001E6A;" size="20"></td>
					
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Photo </td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
                     <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                     <input type="file" name="browse1" value="" />
                    <strong>Only JPG or JPEG Files. </strong>
				   &nbsp;</td>
				 </tr>
				 
                 <tr>
                <td colspan="7" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
				 <?php 
				  $query1 = "select * from master_employeerights where username = '$username' and submenuid = 'SM003'";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $rowcount1 = mysqli_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?><?php
				  }
				  ?>
				  <?php 
				  $query1 = "select * from master_employeerights where username = '$username' and submenuid = 'SM011'";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $rowcount1 = mysqli_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?>
				  <input name="Submit222" type="submit"  id="submit1" value="Save & Go OP Visit (Alt+O)" accesskey="o" class="button" />
                  <?php
				  }
				  ?>
				  <?php 
				  $query1 = "select * from master_employeerights where username = '$username' and submenuid = 'SM011'";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $rowcount1 = mysqli_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?>
				  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				  <input name="Submit222" type="submit" id="submit2" value="Save & Go IP Visit (Alt+I)" accesskey="i" class="button" />
				  </font></font></font></font>
				  <?php
				  }
				  ?><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   <input name="Submit222" type="submit" id="submit" value="Save Registration (Alt+S)" accesskey="s" class="button" />
                   <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   <input name="Submit2223" type="reset"  value="Reset (Alt+R)" accesskey="r" class="button"/>
                   </font></font></font></font>                   </font></font></font></font>               </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>

</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

