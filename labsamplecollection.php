<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");
//echo 'menu'.$menu_id;
include ("includes/check_user_access.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");



$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$timeonly = date("H:i:s");

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$dateonly1 = date("Y-m-d");

$titlestr = 'SALES BILL';

$approvest = array('1','2');

$patientcode1=$_REQUEST['patientcode'];

$query15="select priliminarysis from master_consultationlist where patientcode='$patientcode1'";

$exe15=mysqli_query($GLOBALS["___mysqli_ston"], $query15)or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

$res15=mysqli_fetch_array($exe15);

$priliminary=$res15["priliminarysis"];



if(isset($_REQUEST['status'])){$searchstatus = $_REQUEST['status'];}else{$searchstatus='';}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{   


$patientcode=$_REQUEST['patientcode'];

$visitcode=$_REQUEST['visitcode'];

$patientname=$_REQUEST['customername'];

//get locationcode and locationname for insertion

 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';



	$paynowbillprefix = 'LS-';

$paynowbillprefix1=strlen($paynowbillprefix);





$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='LS-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'LS-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



$docnumber=$billnumbercode;



$dateonly = date("Y-m-d");

foreach($_POST['lab'] as $key => $value)

		{

		$sampleid = '';

		  $labname=$_POST['lab'][$key];

		

		 $itemcode=$_POST['code'][$key];
		 $externallab=$_POST['externallab'][$key];

		//$sample=$_POST['sample'][$key];

		$chkanalyzer="select * from master_test_parameter where labcode='$itemcode'";
		$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $chkanalyzer);
        $resa1 = mysqli_fetch_array($execa1);
        $isanalyzer=0;
		if($resa1['sampletype']!=''){
          $sample=$resa1['sampletype'];
		  $isanalyzer=1;
		}else{
		$sample=$_POST['sample'][$key];
		}

		if($resa1['category']!=''){
          $categoryname=$resa1['category'];
		}else{
		  $categoryname=$_POST['categoryname'][$key];
		}

		 $itemstatus=$_POST['status'][$key];

		$remarks=$_POST['remarks'][$key];

		$refno = $_POST['refno'][$key];

		$sno = $_POST['sno'][$key];

		$refundackstatus = $_POST['refundackstatus'][$key];

		/*if(isset($_POST['machine'][$key]))
			$ismachine=1;
		else
			$ismachine=0; */

		

		

		$transferloc = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'|';

		//$transferlocsplit = explode('|',$transferloc);

		$transferloccode = isset($_POST['transferlocationcode'][$key])?$_POST['transferlocationcode'][$key]:'';

		$transferlocname = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'';

		

		if(isset($_POST['ack']))

		{

			$status='completed';

		}

		else

		{

			$status='pending';

		}

		

		if($refundackstatus=='acknow')

		{

			 $status1='norefund';

			$status='completed';

			$status2='norefund';

			//break;

		}

		else if($refundackstatus=='refund')

		{

			 $status1='refund';

			

			$status2='refund';

			$status='completed';

		}

		else

		{

			$status1='norefund';

			$status='pending';

		}

		//echo $status1;

		//exit;

	/*foreach($_POST['ack'] as $check)

	{

		$acknow=$check;

	

		if($acknow == $sno)

		{

			$status='completed';

			$status2='norefund';

			break;

		}

		else

		{

			$status='pending';

		}

	}

	$status1='norefund';

	foreach($_POST['ref'] as $check1)

	{

		$refund=$check1;

		if($refund == $sno)

		{

		$status1='refund';

		$status2='refund';

		$status='completed';

		break;

		}

		else

		{

		$status1='norefund';

		}

	}*/



	//echo $status1;

		

 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");

if($labname != "")

   {

	  

   if(($status == 'completed')&&($itemstatus != '')&&($status1 != 'refund'))

   {

	   

   $paynowbillprefix = 'OPS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from opipsampleid_lab where patientcode <> 'walkin' and sampleid <> '' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$sampleidno = $res2["sampleid"];

$billdigit=strlen($sampleidno);

if ($sampleidno == '')

{

	$sampleid ='OPS-'.'100';

	$openingbalance = '0.00';

	$maxanum=1;

}

else

{

	$sampleidno = $res2["sampleid"];

	$sampleid = substr($sampleidno,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$sampleid = intval($sampleid);

	$sampleid = $sampleid + 1;



	$maxanum = $sampleid;	

	$sampleid = 'OPS-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

//if($key == 0)

//{

$maxanum1 = $maxanum;

//}

$sampleprefex = substr($sample,0,3);

$sampleid1 = $sampleprefex.$maxanum1;

$sampleidno1 = $maxanum1;

   if($itemstatus != 'discard') {

	   if($isanalyzer==1){
   
  $querya21 = "select sampleid from opipsampleid_lab where patientcode <> 'walkin' and sampleid <> '' and patientvisitcode='$visitcode' and sample='$sample' and category='$categoryname' and isanalyzer='1' and docnumber='$docnumber' order by auto_number desc limit 0, 1";
   $exec261a=mysqli_query($GLOBALS["___mysqli_ston"], $querya21);
   $res12a = mysqli_fetch_array($exec261a);
   $sampleidno = $res12a["sampleid"];
   if($sampleidno!=''){
      $sampleid=$sampleidno;
	  $sampleprefex = substr($sample,0,3);
      $billdigit=strlen($sampleidno);
	  $sampleid2 = substr($sampleidno,$paynowbillprefix1, $billdigit);
	  $sampleid2 = intval($sampleid2);
      $sampleid1 = $sampleprefex.$sampleid2;
      $sampleidno1 = $sampleid2;

   }
 
}

	  

    $query26="insert into samplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,username,sampleid,status,remarks,locationcode,locationname,transferlabcode,transferlabname,externallab)values('$patientname','$patientcode',

   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber','$username','$sampleid','$itemstatus','$remarks','".$locationcodeget."','".$locationnameget."','$transferloccode','$transferlocname','$externallab')";

  $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   

 $query261="insert into opipsampleid_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,sampleid,locationcode,locationname,category,isanalyzer)values('$patientname','$patientcode',   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber','$sampleid','$locationcodeget','$locationnameget','$categoryname','$isanalyzer')";

   

 $exec261=mysqli_query($GLOBALS["___mysqli_ston"], $query261) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   

   $getdob = "select dateofbirth,gender from master_customer where customercode like '$patientcode'";

  $execdob = mysqli_query($GLOBALS["___mysqli_ston"], $getdob) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  $resdob = mysqli_fetch_array($execdob);

 $dateofbirth = $resdob['dateofbirth'];

 $gender = $resdob['gender'];

  list($year, $month, $day) = explode("-", $dateofbirth);

	if($dateofbirth=="0000-00-00" ||$dateofbirth>=date("Y-m-d"))

	{

    $age = 0;

	$duration = 'Days';

	}

	else{

	$age  = date("Y") - $year;

	$duration = 'Years';

	if($age == 0)

	{

	$age = date("m") - $month;

	$duration = 'Months';

	if($age == 0)

	{

	$age = date("d") - $day;

	$duration = 'Days';

	}

	}

	}

	$qrydpt = "select departmentname from master_visitentry where visitcode='$visitcode'";

	  $execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

 	$resdpt = mysqli_fetch_array($execdpt);

	$dpt = $resdpt['departmentname'];

	$datetime = date('Y-m-d h:i:s');

 //if($ismachine==1){

	  $qrygetparam = "select * from master_test_parameter where labcode like '$itemcode'";

	  $execgetparam = mysqli_query($GLOBALS["___mysqli_ston"], $qrygetparam) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

	  while($resparam = mysqli_fetch_array($execgetparam))

	  {

	  $parametername = $resparam['parametername'];

	  $parametercode = $resparam['parametercode'];

	  $qryparam = "INSERT INTO `pending_test_orders`( `patientname`,`patientcode`,`visitcode`, `testcode`, `testname`, `age`,`duration`, `gender`, `sample_id`,`full_sample_id`, `sample_type`, `patient_from`,`ward`, `dob`, `samplecollectedby`, `sampledate`, `parametercode`, `parametername`) values ('$patientname','$patientcode','$visitcode','$itemcode','$labname','$age','$duration','$gender','$sampleidno1','$sampleid1','$sample','Out-Patient','$dpt','$dateofbirth','$username','$datetime','$parametercode','$parametername')";

	   mysqli_query($GLOBALS["___mysqli_ston"], $qryparam) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	  } 
 //}

   

 $query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set requestedby = '$username', labsamplecoll='$status',labrefund='$status1',docnumber='$docnumber',sampleid='$sampleid',sampledatetime='".date('Y-m-d h:i:s')."' where labitemname='$labname' and patientvisitcode='$visitcode' and refno='$refno' and labitemcode = '$itemcode'")or die("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));

    

   }

  

   

     

	 }

	 

// if($status1=='refund')

//{

	//echo "update consultation_lab set labsamplecoll='$status',labrefund='$status1',remarks='$remarks' where labitemname='$labname' and patientvisitcode='$visitcode' and refno='$refno' and labitemcode = '$itemcode'";

	//exit;

	

	 $query291=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set requestedby = '$username', labsamplecoll='$status',labrefund='$status1',remarks='$remarks' where labitemname='$labname' and patientvisitcode='$visitcode' and refno='$refno' and labitemcode = '$itemcode'")or die("Error in Query291".mysqli_error($GLOBALS["___mysqli_ston"]));

//}

  	}

	

}

  header("location:collectedsampleview.php?patientcode=$patientcode&&visitcode=$visitcode&&docnumber=$docnumber&&status=$status1");

  exit;

  

}



?>



<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

?>



<?php

if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }

if($errcode == 'failed')

{

	$errmsg="No Stock";

}

?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'LS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='LS-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'LS-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>



<link href="autocomplete.css" rel="stylesheet">



<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<script>  

function acknowledgevalid()

{

var chks = document.getElementsByName('ack[]');

var hasChecked = false;

for (var i = 0; i < chks.length; i++)

{

if (chks[i].checked)

{

hasChecked = true;

}

}

var chks1 = document.getElementsByName('ref[]');

hasChecked1 = false;

for(var j = 0; j < chks1.length; j++)

{

if(chks1[j].checked)

{

hasChecked1 = true;

}

}





if (hasChecked == false && hasChecked1 == false)

{

alert("Please either acknowledge a sample  or click back button on the browser to exit sample collection");

return false;

}

for(n=1;n<10;n++)

	{

		if(document.getElementById("ref"+n+"").checked==true)

		{

		if(document.getElementById("remarks"+n+"").value == '')

{

alert("Please Enter Remarks");

document.getElementById("remarks"+n+"").focus();

return false;

}	

		}

if(document.getElementById("status"+n+"").value == 'discard')

{

if(document.getElementById("remarks"+n+"").value == '')

{

alert("Please Enter Remarks");

document.getElementById("remarks"+n+"").focus();

return false;

}

}



if(document.getElementById("status"+n+"").value == 'transfer')

{

if(document.getElementById("transferlocation"+n+"").value == '')

{

alert("Please Select Account");

document.getElementById("transferlocation"+n+"").focus();

return false;

}

}

}



return true;

}



function checkboxcheck(varserialnumber)

{



var varserialnumber = varserialnumber;





if(document.getElementById("ack"+varserialnumber+"").checked == true)

{

document.getElementById("refundackstatus"+varserialnumber+"").value='acknow';

document.getElementById("ref"+varserialnumber+"").disabled = true;

}

else

{

	document.getElementById("refundackstatus"+varserialnumber+"").value='';

document.getElementById("ref"+varserialnumber+"").disabled = false;

}

}



function checkboxcheck1(varserialnumber1)

{



var varserialnumber1 = varserialnumber1;

//alert(varserialnumber1);





if(document.getElementById("ref"+varserialnumber1+"").checked == true)

{

	

	document.getElementById("remarks"+varserialnumber1+"").style.display = '';

	

	document.getElementById("refundackstatus"+varserialnumber1+"").value='refund';

	

	

document.getElementById("ack"+varserialnumber1+"").disabled = true;

}

else

{

	document.getElementById("refundackstatus"+varserialnumber1+"").value='';

	document.getElementById("remarks"+varserialnumber1+"").style.display = 'none';

document.getElementById("ack"+varserialnumber1+"").disabled = false;

}

}



function funcOnLoadBodyFunctionCall()

{

funcremarkshide();



var varbilltype = document.getElementById("billtype").value

if(varbilltype =='PAY LATER')

{

for(i=1;i<=100;i++)

{

//alert('hi');

//document.getElementById("ref"+i+"").disabled = true;

}

}

}



</script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>



<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }



.ui-menu .ui-menu-item {

	margin:0;

	padding: 0;

	zoom: 1 !important;

}	

</style>

<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

?>

<script src="js/datetimepicker_css.js"></script>

<?php

$query65= "select * from master_visitentry where visitcode='$visitcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];





$query69="select * from master_customer where customercode='$patientcode'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$patientaccount=$res69['accountname'];







 $query232 = "SELECT primarydiag FROM `consultation_icd` WHERE patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";

	$exec232 = mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res132 = mysqli_fetch_array($exec232);

	$res132primarydiag = $res132["primarydiag"];



$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res78=mysqli_fetch_array($exec78);

$patientage=$res78['age'];

$patientdob=$res69['dateofbirth'];

//$patientage1=$res69['dobdiff'];

$patientgender=$res78['gender'];

$patientsubtype=$res78['subtype'];
$scheme_id=$res78['scheme_id'];
$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);


	$scheme_name = $res_sc['scheme_name'];


 list($year, $month, $day) = explode("-", $patientdob);

if($patientdob=="0000-00-00" ||$patientdob>=date("Y-m-d"))

{





    $year_diff  = 0;

    $month_diff = 0;

    $day_diff   = 0;

	}

else{







    $year_diff  = date("Y") - $year;

    $month_diff = date("m") - $month;

    $day_diff   = date("d") - $day;

	



	}

	

$subtype="select labtemplate from master_subtype where auto_number='$patientsubtype'";

$exesub=mysqli_query($GLOBALS["___mysqli_ston"], $subtype)or die("Error in subtype".mysqli_error($GLOBALS["___mysqli_ston"]));

$ressub=mysqli_fetch_array($exesub);

$labtemplate=$ressub['labtemplate'];









$query70="select * from master_accountname where auto_number='$patientaccount'";

$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);

$res70=mysqli_fetch_array($exec70);

$accountname=$res70['accountname'];



$query20 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$visitcode'";

$exec20=mysqli_query($GLOBALS["___mysqli_ston"], $query20);

$res20=mysqli_fetch_array($exec20);

$res20consultingdoctor=$res20['consultingdoctor'];



$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";

$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res612 = mysqli_fetch_array($exec612);

$orderedby = $res612['username'];

//$refno = $res612['refno'];

//get location code and name from table

  $locationcode=$res612['locationcode'];

  $locationname=$res612['locationname'];

 //get location end here



?>



</head>

<script>

function funcPrintBill()

 {

var patientcode;

patientcode = document.getElementById("customercode").value; 

var visitcode;

visitcode = document.getElementById("visitcode").value; 

var docnumber;

docnumber = document.getElementById("docnumber").value; 

var popWin; 

//popWin = window.open("print_labtest_label.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&billnumber="+docnumber,"OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

 }

 



function funcremarksshow(k)

{

var i = k;

//alert(k);

  for(i=1;i<10;i++)

	{

	if (document.getElementById("status"+i+"") != null) 

	{

		if (document.getElementById("status"+i+"").value == 'discard') 

		{	

			document.getElementById("remarks"+i+"").style.display = '';

			document.getElementById("transferlocation"+i+"").style.display = 'none';

		}

		if (document.getElementById("status"+i+"").value == 'transfer') 

		{	

			document.getElementById("transferlocation"+i+"").style.display = '';

			document.getElementById("remarks"+i+"").style.display = 'none';

		}

	}

	}	

}



function funcremarkshide()

{				

	for(i=1;i<10;i++)

	{

	if (document.getElementById("status"+i+"") != null) 

	{

		if (document.getElementById("status"+i+"").value == 'completed')  

		{	

			document.getElementById("remarks"+i+"").style.display = 'none';

			document.getElementById("transferlocation"+i+"").style.display = 'none';

		}

	}

	}			

}



function funcstatus(j)

{

var j = j;

if(document.getElementById("status"+j+"").value == 'discard')

{

funcremarksshow(j);

}

if(document.getElementById("status"+j+"").value == 'transfer')

{

funcremarksshow(j);

}

if(document.getElementById("status"+j+"").value == 'completed')

{

funcremarkshide();

}

}

function validcheck()

{



if(confirm("Do You Want To Save The Record?")==false){return false;}	



for(n=1;n<10;n++)

	{

if(document.getElementById("status"+n+"").value == 'discard')

{

if(document.getElementById("remarks"+n+"").value == '')

{

alert("Please Enter Remarks");

document.getElementById("remarks"+n+"").focus();

return false;

}

}



if(document.getElementById("status"+n+"").value == 'transfer')

{

if(document.getElementById("transferlocation"+n+"").value == '')

{

alert("Please Select Account");

document.getElementById("transferlocation"+n+"").focus();

return false;

}

}



}

}



$(function() {

	

$('.transfer').autocomplete({

		

	source:'ajaxtransferlocsearch.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

		    var textid = $(this).attr('id');

			var tid = textid.split('transferlocation');

			//alert(tid[1]);

			var loccode = ui.item.acccode;

			var locname = ui.item.accname;

			

			$('#transferlocationcode'+tid[1]).val(loccode);

			

			},

    });

});

</script>  



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="frmsales" id="frmsales" method="post" action="labsamplecollection.php" onKeyDown="return disableEnterKey(event)" onSubmit=" return validcheck() && funcPrintBill1(); ">

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

<!--  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

-->

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">

    <tr>

    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#011E6A">

              

                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 

                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">

               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>

	  <td class="bodytext3" width="25%" align="left" valign="middle" bgcolor="#ecf0f5">

				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>

                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>

				

                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />

                

                <td width="27%" bgcolor="#ecf0f5" class="bodytext3">

               

                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>

               

               <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>

                <td width="23%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">

			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>                  </td>

              </tr>

			 

		

			  <tr>

				 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location </strong></td>

                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><?php echo $locationname;?> </strong></td>

                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">

                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">

			    <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>

                <td class="bodytext3" width="25%" align="left" valign="middle" >

			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>

                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>

                <td align="left" class="bodytext3" valign="top" >

				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

             

			    

			  </tr>

				  <tr>

                  <td align="left" valign="top" class="bodytext3" ><strong>Ordered By </strong></td>

			    <td align="left" class="bodytext3" valign="top" ><?php echo $orderedby; ?></td>



			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3">

				<input name="patientage" type ="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php  if($year_diff>0){echo $year_diff." year";} else {if($month_diff>0){echo $month_diff." month";} else{echo $day_diff." days";}}?>

				&

				<input name="patientgender" type="hidden" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>

                <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3">

				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>				  </tr>

			    

				  <tr>

				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Primary Diagnosis</strong></td>

                  <td colspan="1" align="left" valign="middle" class="bodytext3">

				<input name="primarydiag" id="primarydiag" type="hidden" value="<?php echo $res132primarydiag; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $res132primarydiag; ?>

                  </td>

                                   

                 <td align="left" class="bodytext3" valign="top" ><strong>Preliminary</strong></td>

                                    <td align="left" class="bodytext3" valign="top" ><?php echo $priliminary;?></td>



            <td align="left" class="bodytext3" valign="top" ><strong>Scheme :</strong></td>

                                    <td align="left" class="bodytext3" valign="top" ><?php echo $scheme_name;?></td>

				  </tr>

                  <tr>

                  <td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td><td align="left" class="bodytext3" valign="top" >&nbsp;</td>                  </tr>

            </tbody>

        </table></td>

      </tr>

      

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

					<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>

              <td width="18%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>

				 <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"><strong>Remarks</strong></td>
				 <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"></td>

			      </tr>





			<?php



			$colorloopcount = '';

			$sno = '';



						$queryaa1 = "select categoryname,auto_number from master_categorylab order by categoryname ";

						$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($resaa1 = mysqli_fetch_array($execaa1))

						{

				

						$data_count=0;

						$categoryname = $resaa1["categoryname"];

						$auto_number = $resaa1["auto_number"];

					?>

						

					



				  		<?php

			$ssno=0;

			$tno=0;

			$totalamount=0;			

		
 $locationcode;
	$query61 = "select a.* from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname'  where a.patientcode = '$patientcode' and a.patientvisitcode = '$visitcode' and a.labsamplecoll='$searchstatus'  and (a.labrefund='norefund' or a.labrefund='') and a.paymentstatus='completed' and a.labitemname <> '' and (a.billtype='PAY NOW' or (a.billtype='PAY LATER')) group by b.itemcode";



$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

 $numb=mysqli_num_rows($exec61);

while($res61 = mysqli_fetch_array($exec61))

{
$dis_it='';
$billtype = $res61["billtype"];

$approvalstatus = $res61["approvalstatus"];



if( $billtype=='PAY LATER'  and (!in_array($approvalstatus,$approvest))){

	continue;

}



if($tno==0){

	echo '<tr> <td colspan="7" class="bodytext31" bgcolor="oldlace" > '.$categoryname .' </td> </tr>';

}

$tno++;



$labname =$res61["labitemname"];

$labitemcode=$res61["labitemcode"];



$refno =$res61["refno"];



if($labtemplate =='')

{

$query68="select * from master_lab where itemcode='$labitemcode' and status <> 'deleted'";

}

else

{

	$query68="select * from master_lab where itemcode='$labitemcode' and status <> 'deleted'";

}

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);

$res68=mysqli_fetch_array($exec68);

$samplename=$res68['sampletype'];

$itemcode=$res68['itemcode'];

//$externallab=$res68['externallab'];

if($res68["externallab"]=='yes' || $res68["externallab"] == 'on' || $res68["externallab"]=='YES'){
  $externallab = 1;
  $colorcode = 'bgcolor="yellow"';
}
else{
  $externallab ='';
  $colorcode = '';
}

if($billtype=='PAY LATER')
{
$dis_it='disabled';	
}
else
{
$dis_it='';
}
$query41="select * from master_categorylab where categoryname='$labname'";

$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41);

$num41=mysqli_num_rows($exec41);

if($num41 > 0)

{

//$itemcode=$ssno;

$ssno=$ssno + 1;

}

$sno = $sno + 1;

?>

  <tr <?php echo $colorcode; ?>>

  <td class="bodytext31" valign="center"  align="left"><div align="center">

  		<input type="hidden" name="sno[]" value="<?php echo $sno; ?>"> 

        

        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"  <?php echo $dis_it;?>/></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>

		<input type="hidden" name="lab[]"  value="<?php echo $labname;?>">

       
        <input type="hidden" name="externallab[]" value="<?php echo $externallab; ?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="refno[]" value="<?php echo $refno; ?>">

        <input type="hidden" name="refundackstatus[]" id="refundackstatus<?php echo $sno; ?>" value="">

        

		<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>

       </div></td><input type="hidden" name="sample[]" value="<?php echo $samplename; ?>">
	   <input type="hidden" name="categoryname[]" value="<?php echo $categoryname; ?>">

        <td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $sno; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>

		 <td class="bodytext31" valign="center"  align="left"><div align="center">

		 <select name="status[]" id="status<?php echo $sno; ?>" onChange="return funcstatus('<?php echo $sno; ?>');">

		 <option value="completed">Completed</option>

		 </select>

		 </div></td>

		  <td align="center" valign="center" class="bodytext311"><textarea name="remarks[]" id="remarks<?php echo $sno; ?>"></textarea>

		  <input type="text" class="transfer" name="transferlocation[]" id="transferlocation<?php echo $sno; ?>" style="border: 1px solid #001E6A;">

		  <input type="hidden" name="transferlocationcode[]" id="transferlocationcode<?php echo $sno; ?>" style="border: 1px solid #001E6A;">

		  </td>		
		  <td align='center' class="bodytext31">
		 

		  </td>

						</tr>

			<?php 

		

			}

			}

		?>

			

           

          </tbody>

        </table>		</td>

      </tr>

      

      

      

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr>

              <td width="54%" align="right" valign="top" >

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" />

               </td>

              

            </tr>

          </tbody>

        </table></td>

      </tr>

    </table>

  </table>



</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>

