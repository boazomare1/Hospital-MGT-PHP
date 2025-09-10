<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");



$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];



$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$dateonly1 = date("Y-m-d");

$timeonly= date("H:i:s");

$titlestr = 'SALES BILL';

$colorloopcount = '';

$sno = '';



$docno = $_SESSION["docno"];
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{   

	//////////////////// FOR AUDIT RESULT ENTRY //////////////////				  
 $paynowbillprefix_ad = 'ARE-';
$paynowbillprefix1_ad=strlen($paynowbillprefix_ad);
$query2_ad = "select * from audit_resultentry_lab order by auto_number desc limit 0, 1";
$exec2_ad = mysqli_query($GLOBALS["___mysqli_ston"], $query2_ad) or die ("Error in Query2_ad".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2_ad = mysqli_fetch_array($exec2_ad);
$billnumber_ad = $res2_ad["audit_id"];
$billdigit_ad=strlen($billnumber_ad);
if ($billnumber_ad == '')
{
	$billnumbercode_ad ='ARE-'.'1';
}
else
{
	$billnumber_ad = $res2_ad["audit_id"];
	$billnumbercode_ad = substr($billnumber_ad,$paynowbillprefix1_ad, $billdigit_ad);
	//echo $billnumbercode_ad;
	$billnumbercode_ad = intval($billnumbercode_ad);
	$billnumbercode_ad = $billnumbercode_ad + 1;

	$maxanum_ad = $billnumbercode_ad;
	$billnumbercode_ad = 'ARE-' .$maxanum_ad;
	//echo $companycode;
}
//////////////////// FOR AUDIT RESULT ENTRY //////////////////	

$patientcode=$_REQUEST['patientcode'];

$visitcode=$_REQUEST['visitcode'];

$patientname=$_REQUEST['customername'];

$sampleid = $_REQUEST['sampleid'];

$doctorname = $_REQUEST['doctorname'];

 if($patientcode == 'DIRECT')

				  {

				  $patientcode = 'walkin';

				  

				  }

				  if($visitcode == 'DIRECT')

				  {

				  $visitcode = 'walkinvis';

				  

				  }

				  





$docnumber=$_REQUEST['docnumber'];

$samplecollectiondocnumber=$_REQUEST['samplecollectiondocno'];

$accountname = $_REQUEST['account'];





$dateonly = date("Y-m-d");

foreach($_POST['lab'] as $key => $value)

		{

	     $labname = $_POST['lab'][$key];

		 $itemcode = $_POST['code'][$key];

		$resultvalue=$_POST['result'][$key];

		$unit=$_POST['units'][$key];

		$referencevalue=$_POST['reference'][$key];

		$refname = $_POST['referencename'][$key];

		

		 			

		$color = $_POST['color'][$key];

		

		if($resultvalue != '')

		{

			/*$query26="insert into resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname)values('$patientname','$patientcode',

   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname')";

   $exec26=mysql_query($query26) or die(mysql_error());*/


	  $chkreff="select * from resultentry_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  itemcode='$itemcode' and referencename='$refname' and docnumber='$docnumber' and sampleid='$sampleid'";
	  $exec262=mysqli_query($GLOBALS["___mysqli_ston"], $chkreff) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
      $num313 = mysqli_num_rows($exec262);

	  if($num313>0){
   

	 $query26 ="update resultentry_lab  set resultvalue='$resultvalue',color='$color',edited_by='$username',edited_date='$updatedatetime' where patientcode='$patientcode' and patientvisitcode='$visitcode' and  itemcode='$itemcode' and referencename='$refname' and docnumber='$docnumber' and sampleid='$sampleid'";

	$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die("Query26".mysqli_error($GLOBALS["___mysqli_ston"]));




	  }else{
       
	   $query26="insert into resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname)values('$patientname','$patientcode',
		 '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname')";
		 $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   }

   // FOR AUDIT ENTRY
	$query333 = "select * from resultentry_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  itemcode='$itemcode' and referencename='$refname' and docnumber='$docnumber' and sampleid='$sampleid'";
	$exec333 = mysqli_query($GLOBALS["___mysqli_ston"], $query333) or die ("Error in Query333".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res333 = mysqli_fetch_array($exec333);
	// $patientname = $res333["patientname"];
	// $referencevalue = $res333["referencevalue"];
	// $unit = $res333["unit"];
	// $accountname = $res333["account"];
	$refcomments = $res333["referencecomments"];
	$radiology = $res333["radiology"];
	// $color = $res333["color"];
	// $sampleid = $res333["sampleid"];
	$equipmentcode = $res333["equipmentcode"];
	$equipmentname = $res333["equipmentname"];
	$resultstatus = $res333["resultstatus"];
	$doctorname = $res333["doctorname"];

	// $sampleid = $res333["sampleid"];
 
   $query262="INSERT into audit_resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,referencecomments,radiology,color,sampleid,username,equipmentcode,equipmentname,audit_id,datetime,ipaddress,locationname,locationcode,doctorname,resultstatus)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$refcomments','$radiology','$color','$sampleid','$username','$equipmentcode','$equipmentname','$billnumbercode_ad','$updatedatetime','$ipaddress','$locationname','$locationcode','$doctorname','$resultstatus')";
   // ,edited_by,edited_date == ,'$username','$updatedatetime'
   $exec262=mysqli_query($GLOBALS["___mysqli_ston"], $query262) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   // FOR AUDIT ENTRY
}

		

		/*foreach($_POST['ack'] as $ch)

		{

		 $acknow=$ch;

		

		if($acknow == $itemcode)

		{

		

		$status1='completed';

		

		if($resultvalue == '')

		{

			$query26="insert into resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname)values('$patientname','$patientcode',

   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname')";

   $exec26=mysql_query($query26) or die(mysql_error());

}

	 

 $query76 = "update samplecollection_lab set resultentry='$status1' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";

 $exec76 = mysql_query($query76) or die(mysql_error());

 

 $query77 = "update resultentry_lab set resultstatus='completed' where docnumber='$docnumber'";

 $exec77 = mysql_query($query77) or die(mysql_error());

 $query29=mysql_query("update consultation_lab set resultentry='$status1',resultdoc='$docnumber' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$samplecollectiondocnumber'");

	}

		

	}*/

	

	   /* $query31 = "select * from master_lablinking where labcode = '$itemcode' and recordstatus = ''";

	$exec31 = mysql_query($query31) or die(mysql_error());

	$num31 = mysql_num_rows($exec31);

	while($res31 = mysql_fetch_array($exec31))

	{

	$pharmacyitemcode = $res31['itemcode'];

	$pharmacyitemname = $res31['itemname'];

	$pharmacyquantity = $res31['quantity'];

	

	$query311 = "select * from master_itempharmacy where itemcode = '$pharmacyitemcode'"; 

	$exec311 = mysql_query($query311) or die ("Error in Query31".mysql_error());

	$res311 = mysql_fetch_array($exec311);

	$pharmacyrate = $res311['rateperunit'];

	$categoryname = $res311['categoryname'];

	

	$pharmacyamount = $pharmacyrate * $pharmacyquantity;

	

	$query57 = "select * from purchase_details where itemcode='$pharmacyitemcode'";

//echo $query57;

	$res57=mysql_query($query57);

	$num57=mysql_num_rows($res57);

	//echo $num57;

	while($exec57 = mysql_fetch_array($res57))

	{

	 $batchname = $exec57['batchnumber']; 

//echo $batchname;

$companyanum = $_SESSION["companyanum"];

			 $itemcode = $pharmacyitemcode;

			 $batchname = $batchname;

	include ('autocompletestockbatch.php');

	$currentstock = $currentstock;

	 $currentstock;

	if($currentstock > 0 )

	{

	

	mysql_query("insert into pharmacysales_details(itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,categoryname)values('$pharmacyitemname','$pharmacyitemcode','$pharmacyquantity','$pharmacyrate','$pharmacyamount','$batchname','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly1','$accountname','$docnumber','$timeonly','$location','$store','$categoryname')");



	}

	}

	}*/

 

	

		 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");



	

}

header("location:editlabresultlist.php");

exit();



}



?>



<?php

if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }

if($errcode == 'failed')

{

	$errmsg="No Stock";

}



?>

<script>

function funcrange(varserialnumber1)

{

//alert('hi');

var varserialnumber1 = varserialnumber1;

//alert(varserialnumber1);

var varrange111 = document.getElementById("range111"+varserialnumber1+"").value;

var varrange112 = document.getElementById("range112"+varserialnumber1+"").value;

var result1 = document.getElementById("result"+varserialnumber1+"").value;

//alert(result1);

//alert(varrange112);

if(parseFloat(result1) < parseFloat(varrange111))

{

//alert('h');

document.getElementById("result"+varserialnumber1+"").style.borderColor="orange";

document.getElementById("color"+varserialnumber1+"").value="orange";



}

else if(parseFloat(result1) > parseFloat(varrange112))

{

//alert('hi');

document.getElementById("result"+varserialnumber1+"").style.borderColor="red";

document.getElementById("color"+varserialnumber1+"").value="red";

}

else if(parseFloat(result1) >= parseFloat(varrange111) && parseFloat(result1) <=(varrange112))

{

document.getElementById("result"+varserialnumber1+"").style.borderColor="green";

document.getElementById("color"+varserialnumber1+"").value="green";

}

}





function acknowledgevalid()

{

funcPrint();

var chks = document.getElementsByName('ack[]');

var hasChecked = false;

for (var i = 0; i < chks.length; i++)

{

if (chks[i].checked)

{

hasChecked = true;

break;

}

}

if (hasChecked == false)

{

alert("Please acknowledge a lab item  or click back button on the browser to exit lab result entry");

return false;

}

return true;

}

</script>

<script>

function funcLabHideView(para)

{	

var idname=para;

alert(idname);

 if (document.getElementById(idname) != null) 

	{

	document.getElementById(idname).style.display = 'none';

	}			

}

function funcLabShowView(param)

{

var idname1=param;



  if (document.getElementById(idname) != null) 

     {

	 document.getElementById(idname).style.display = 'none';

	}

	if (document.getElementById(idname) != null) 

	  {

	  document.getElementById(idname).style.display = '';

	 }

}

/*function funcPrint()

{

var varCustomercode = document.getElementById('customercode').value;

var varVisitcode = document.getElementById('visitcode').value;

var varDocnum = document.getElementById('docnumber').value;

window.open("print_labresultentry.php?patientcode=" + varCustomercode + "&&visitcode="+ varVisitcode + "&&docnumber=" + varDocnum);

}

*/

</script>

<script>

function funcOnLoadBodyFunctionCall()

{

funcLabHideView();

	}



function funcrefrange()

{

alert(document.getElementById("rangeref").innerHTML);

}

function validcheck()

{

var varUserChoice; 

	varUserChoice = confirm('Have you entered all the results ? Once acknowledged, patient will exit from View Samples. Pl Confirm.'); 

	//alert(fRet); 

	if (varUserChoice == false)

	{

		document.getElementById("ack").checked = false;

	}

	

}



function coasearch(varCallFrom,itemcode,reference)

{

	var varCallFrom = varCallFrom;

	var itemcode = itemcode;

	var reference = reference;

	window.open("labreference.php?callfrom="+varCallFrom+"&&itemcode="+itemcode+"&&reference="+reference,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

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

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

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

</style>

<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

$docnumber = $_REQUEST["docnumber"];

$sampleid = $_REQUEST['sampleid'];


$query79="SELECT recorddate from samplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";
$exec79=mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res79=mysqli_fetch_array($exec79);
 $date2_recorddate=$res79['recorddate'];


$query55 = "update samplecollection_lab set entrywork='Inprogress',entryworkby='$username' where sampleid='$sampleid'";

//$exec55 = mysql_query($query55) or die(mysql_error());



?>

<script src="js/datetimepicker_css.js"></script>

<?php

$query65= "select * from master_visitentry where patientcode='$patientcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];



$query69="select * from master_customer where customercode='$patientcode'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$patientaccount=$res69['accountname'];


$dateofbirth=$res69['dateofbirth'];
$date1=strtotime($dateofbirth);
$date2=strtotime($date2_recorddate);
$datediff = $date2 - $date1;
 $birth_days = round($datediff / (60 * 60 * 24));

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res78=mysqli_fetch_array($exec78);

$patientage=$res78['age'];

$patientgender=$res78['gender'];



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



$query24 = "select * from master_employee where username = '$orderedby'";

				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res24 = mysqli_fetch_array($exec24);

				$orderedbyname = $res24['employeename'];



?>

<?php





if($Patientname == '')

{

 $query34 = "select * from consultation_lab where resultdoc='$docnumber'";

$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res34 = mysqli_fetch_array($exec34);

$externalbillno = $res34['billnumber'];

$orderedby = $res612['username'];



 $query66="select * from billing_external where billno='$externalbillno'";

				$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res66=mysqli_fetch_array($exec66);

				$patientage=$res66['age'];

				$patientgender=$res66['gender'];

			    $Patientname = $res66['patientname'];

	 if($patientcode == 'walkin')

				  {

				  $patientcode = 'walkin';

				  

				  }

				  if($visitcode == 'walkinvis')

				  {

				  $visitcode = 'walkinvis';

				  

				  }

}

?>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body>

<form name="frm" id="frmsales" method="post" action="editlabresult.php" onKeyDown="return disableEnterKey(event)">

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

<!--  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

-->

  <tr>

    <td width="0%">&nbsp;</td>

    <td width="88%" valign="top">

	<table width="1058" border="0" cellspacing="0" cellpadding="0">

    <tr>

    <td colspan="3" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>

      <tr>

        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#ecf0f5">

			 

              

                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 

                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">

               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>

	  <td width="22%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5">

				<input name="customername" id="customer" type="hidden" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>

                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>

				

                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />

                

                <td width="26%" bgcolor="#ecf0f5" class="bodytext3">

               

                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>

				<td width="11%" align="left" valign="middle"  class="bodytext3"><strong>Doc No</strong></td>

                <td width="21%" align="left" class="bodytext3" valign="middle" >

			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $docnumber; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $docnumber; ?>                  </td>

              </tr>

			  <tr>

			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>

                <td width="22%" align="left" valign="middle" class="bodytext3">

			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>

                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>

                <td align="left" valign="top" class="bodytext3">

				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

             

			    <td align="left" valign="top" class="bodytext3"><strong>Ordered By </strong></td>

			    <td align="left" valign="top" class="bodytext3"><?php echo $orderedbyname; ?></td>

				<input type="hidden" name="doctorname" id="doctorname" value="<?php echo $orderedbyname; ?>">

			  </tr>

				  <tr>



			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3">

				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>

				&

				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>

                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td colspan="1" align="left" valign="top" class="bodytext3">

				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>

				<input type="hidden" name="samplecollectiondocno" id="docnum" value="<?php echo $docnumber; ?>">				</td>

				<input type="hidden" name="sampleid" id="sampleid" value="<?php echo $sampleid; ?>">

				<td colspan="1" align="left" valign="top" class="bodytext3"><strong>Sample Doc No</strong></td>

				<td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $docnumber; ?></td>

				  </tr>

				  <tr>

				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>

				  </tr>

            </tbody>

        </table></td>

      </tr>

	

     <tr>

	  <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>Sample Id : <?php echo $sampleid; ?></strong></td>

				 

	      </tr>

				  

				   <tr>

				   		    <td width="5%" class="bodytext366" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>

			<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Result value</strong></div></td>

			<td width="5%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Units</strong></div></td>

			<td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Reference Value</strong></div></td>

					

		  </tr>

				  <?php

				  

				  if($patientcode == 'DIRECT')

				  {

				  $patientcode = 'walkin';

				  

				  }

				  if($visitcode == 'DIRECT')

				  {

				  $visitcode = 'walkinvis';

				  

				  }

	  $query31="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid = '$sampleid' and resultstatus = 'completed' and docnumber='$docnumber' group by itemname";

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $num=mysqli_num_rows($exec31);

	  while($res31=mysqli_fetch_array($exec31))

	  { 

	   $labname1=$res31['itemname'];

	   $labitemcode = $res31['itemcode'];
        $locationcode = $res31['locationcode'];

	   

	

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

			$sno = $sno + 1;

		?>		  

			  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="center"><div align="left"><?php echo $labname1; ?></div></td>

			  	  

              <td class="bodytext31" valign="center"  align="center">

			  <div align="center">

			  <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcShowDetailHide('<?php echo $sno; ?>')" onClick="return funcShowDetailView('<?php echo $sno; ?>')">			  </div>			  </td>

               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>

			       	  <td class="bodytext31" valign="center"  align="center">

			  <div class="bodytext31"></div></td>

			  

		

         </tr>

		 	<tr id="idTRSub<?php echo $sno; ?>">

			<td colspan="7"  align="left" valign="center" class="bodytext31">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1108"

            align="left" border="0">

              <tbody>

               

			   <?php 

			   $subTRsno = 0;

			   $sn = 0;

			  $query52="select * from master_labreference where itemname='$labname1' and itemcode='$labitemcode' and (gender = '$patientgender' or gender='All' or gender='') and '$birth_days' >= agefrom and '$birth_days' <= ageto and status <> 'deleted' ";

			   $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52);

			   $num=mysqli_num_rows($exec52);

			   while($res52=mysqli_fetch_array($exec52))

			   {

			   $labname2=$res52['itemname'];

			 $itemcode2=$res52['itemcode'];

			    /* $query52="select * from master_lab where itemname='$labname2'";

				  $exec52=mysql_query($query52);

				  $res52=mysql_fetch_array($exec52);*/

				  $labunit1=$res52['itemname_abbreviation'];

				   $labreferenceunit = $res52['referenceunit'];

				   

				$labreferencename = $res52['referencename'];

				$labitemanum = $res52['auto_number'];

				 

				 

				

				   $labreferencerange = $res52['referencerange'];

				  

				  //echo $labreferencerange1[0]; 

				  $labreferencevalue1=$res52['referencevalue'];

				  

				  $query43 = "select * from resultentry_lab where sampleid='$sampleid' and itemcode = '$itemcode2' and referencename = '$labreferencename' order by auto_number desc";

				  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res43 = mysqli_fetch_array($exec43);

				  $result = $res43['resultvalue'];

				  

				  

				  $query64 = "select * from master_labreference where itemcode='$itemcode2' and referencename = '$labreferencename' and status <> 'deleted'  group by referencename";

				  $exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				  $num64 = mysqli_num_rows($exec64);

				  if($num64 > 0)

				  {

				  

				  	$subTRcolorloopcount = $subTRcolorloopcount + 1;

				$subTRshowcolor = ($subTRcolorloopcount & 1); 

				if ($subTRshowcolor == 0)

				{

					//echo "if";

					$subTRcolorcode = 'bgcolor="#CBDBFA"';

				}

				else

				{

					//echo "else";

					$subTRcolorcode = 'bgcolor="#ecf0f5"';

				}

						   ?> 

						     <tr <?php echo $subTRcolorcode; ?>>

							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">

                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="450"><div class="bodytext311"> <?php if($labreferencename == '')

				   {

				   echo $labname2;

				   }

				   else

				   {

				   echo $labreferencename;

				   } ?></div></td>

				    <input type="hidden" name="lab[]" value="<?php echo $labname2;?>">

				   <input type="hidden" name="referencename[]" value="<?php echo $labreferencename; ?>">

				  <input type="hidden" name="code[]" value="<?php echo $itemcode2; ?>">

				  

				  <?php

				  

				  $labreferencerange1 = $labreferencerange;

				  $labreferencerange1 = explode('-',$labreferencerange1);

				  if(!ctype_digit($labreferencerange1[0]))

				{

				$labreferencerange1length = strlen($labreferencerange1[0]);

				$labreferencerange1symbol = substr($labreferencerange1[0],0,1);

				$labreferencerange1withoutsymbol = substr($labreferencerange1[0],1,$labreferencerange1length);

				if($labreferencerange1symbol == '<')

				{

				$labreferencerange1[0] = 0;

				$labreferencerange1[1] = $labreferencerange1withoutsymbol;

				}

				if($labreferencerange1symbol == '>')

				{

				$labreferencerange1[0] = $labreferencerange1withoutsymbol;

				$labreferencerange1[1] = 1000000;

				}

				}

				  

				 $query49 = "select * from resultentry_lab where patientcode='$patientcode' and itemcode='$itemcode2' and referencename='$labreferencename' order by auto_number desc limit 0,1";

				 $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res49 = mysqli_fetch_array($exec49);

				 $pastresult = $res49['resultvalue'];

				  ?>

                  <td width="434" align="center" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="center">

				   <input type="hidden" name="serialnumber" id="serialnumber<?php echo $sn; ?>" value="<?php echo $sn = $sn+1; ?>">


				  <!-- <input type="text" name="result[]" id="result<?php echo $sn; ?>" onBlur="return funcrange('<?php echo $sn; ?>')" value="<?php echo $result; ?>"/>-->

				   <textarea rows="3" cols="30" name="result[]" id="result<?php echo $sn; ?>" size="25" value="" onBlur="return funcrange('<?php echo $sn; ?>')"><?php echo $result; ?></textarea>
				   

				   <!--<label onClick="javascript:coasearch('<?php echo $sn; ?>','<?php echo $itemcode2; ?>','<?php echo $labreferencename; ?>')">Click</label>
-->

				 <input type="hidden" name="range111[]" id="range111<?php echo $sn; ?>" value="<?php echo $labreferencerange1[0] ; ?>">

				  <input type="hidden" name="range112[]" id="range112<?php echo $sn; ?>" value="<?php echo $labreferencerange1[1] ; ?>">

				  <input type="hidden" name="color[]" id="color<?php echo $sn; ?>" value="">

				   </div></td>

                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="75"><div align="left"> <?php if($labreferenceunit == '')

				  {

				  echo $labunit1;

				  }

				  else

				  {

				  echo $labreferenceunit;

				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>

                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="75" style="color:red;"><?php echo $pastresult; ?></td>

                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="358"><div align="left" id="rangeref" onClick="return funcrefrange();"> <?php if($labreferencerange == '')

			   {

			   echo $labreferencevalue1;

			   }

			   else

			   {

			   echo $labreferencerange;

			   } ?></div><input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/></td>

              </tr>

			  <?php 

		 }

		 }

		 ?>

			  </tbody>

            </table>			</td>

			

			</tr>

			 

		 <?php

		  

		 }

		 ?>

		 

				  

				  

				  	<script language="javascript">

			//alert ("Inside JS");

			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.

			for (i=1;i<=100;i++)

			{

				if (document.getElementById("idTRSub"+i+"") != null) 

				{

					document.getElementById("idTRSub"+i+"").style.display = 'none';

				}

			}

			

			function funcShowDetailView(varSerialNumber)

			{

				//alert ("Inside Function.");

				var varSerialNumber = varSerialNumber

				//alert (varSerialNumber);



				for (i=1;i<=100;i++)

				{

					if (document.getElementById("idTRSub"+i+"") != null) 

					{

						document.getElementById("idTRSub"+i+"").style.display = 'none';

					}

				}



				if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 

				{

					document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';

				}

			}

			

			function funcShowDetailHide(varSerialNumber)

			{

				//alert ("Inside Function.");

				var varSerialNumber = varSerialNumber

				//alert (varSerialNumber);



				for (i=1;i<=100;i++)

				{

					if (document.getElementById("idTRSub"+i+"") != null) 

					{

						document.getElementById("idTRSub"+i+"").style.display = 'none';

					}

				}

			}

			</script>	



      <tr>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name: 

               <input name="user" type="hidden" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>

          </tr>

			   <tr> 

              <td colspan="7" align="right" valign="top" >

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

                     <input name="Submit2223" type="submit" value="Update " onClick="return acknowledgevalid()"  accesskey="b" class="button"/>

               </td>

          </tr>

      </table>

	</td>

    <td width="12%" valign="top">

	<table>

	<tr>

	<td>&nbsp;</td>

	<td width="41">&nbsp;</td>

	</tr>

	<tr>

	<td>&nbsp;</td>

	<td>&nbsp;</td>

	</tr>

	<tr>

	<td>&nbsp;</td>

	<td>&nbsp;</td>

	</tr>

	<tr>

	<td>&nbsp;</td>

	<td>&nbsp;</td>

	</tr>

	<!--<tr>

	<td align="left" valign="middel" width="35" bgcolor="orange"></td>

	<td class="bodytext32"><strong>Below Range</strong></td>

	</tr>

    <tr>

	<td align="left" valign="middel" width="35" bgcolor="green"></td>

	<td class="bodytext32"><strong>Normal</strong></td>

	</tr>

	<tr>

	<td align="left" valign="middel" width="35" bgcolor="red"></td>

	<td class="bodytext32"><strong>Above Range</strong></td>

	</tr>-->

	</table></td>

	</tr>

  </table>   



</form>

<?php include ("includes/footer1.php"); ?>



</body>

</html>

