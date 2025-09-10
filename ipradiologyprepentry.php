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

$timeonly = date("H:i:s");

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$dateonly1 = date("Y-m-d");

$titlestr = 'SALES BILL';



$errmsg = "";





if (isset($_REQUEST["q_itemcode"])) { $q_itemcode = $_REQUEST["q_itemcode"]; } else { $q_itemcode = ""; }

if (isset($_REQUEST["q_refno"])) { $q_refno = $_REQUEST["q_refno"]; } else { $q_refno = ""; }



if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }



if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }



$query69="select * from master_customer where customercode='$patientcode'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$patientdob=$res69['dateofbirth'];

 //$patientdob=$res69['dateofbirth'];

if($patientdob=="0000-00-00" ||$patientdob>=date("Y-m-d"))

{





    $year_diff  = 0;

    $month_diff = 0;

    $day_diff   = 0;

	}

else{

 list($year, $month, $day) = explode("-", $patientdob);



    $year_diff  = date("Y") - $year;

    $month_diff = date("m") - $month;

    $day_diff   = date("d") - $day;

	}



if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'success')

{

		$errmsg = "Saved Successfully.";

}

if ($st == 'failed')

{

		$errmsg = "Failed to save";

}



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{   

$patientcode=$_REQUEST['patientcode'];

$visitcode=$_REQUEST['visitcode'];

$patientname=$_REQUEST['customername'];

$docnumber=$_REQUEST['docnumber'];

$billtype = $_REQUEST['billtype'];

$account = $_REQUEST['account'];







//get locationcode and locationname for insert

$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';



$dateonly = date("Y-m-d");

foreach($_POST['radiology'] as $key => $value)

		{

	

		$u1=0;

		

		if($_POST['urgent'][$key])

		{$u1=1;}

	

		$radiologyname=$_POST['radiology'][$key];

		$itemcode=$_POST['code'][$key];

		$auto_number=$_POST['auto_number'][$key];		

		$remarks=$_POST['remarks'][$key];

		$clinical=$_POST['clinical'][$key];

		if(isset($_POST['ack']))

		{

			$status='completed';

		}

		else

		{

			

		$status='pending';

		}

	foreach($_POST['ack'] as $check)

		{

		$acknow=$check;

		if($acknow == $itemcode)

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

	

	foreach($_POST['ref'] as $check1)

	{

	$refund=$check1;

	if($refund == $itemcode)

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

	}

	

if($radiologyname != "")

   {

   

   if($status2=='refund')

		{

		

$new_datetime=date('Y-m-d H:i:s');			

	 mysqli_query($GLOBALS["___mysqli_ston"], "update ipconsultation_radiology set  clinical_diagnosis='$clinical',prepstatus='$status',resultentry='$status1' ,urgent='$u1',radiologyrefund='$status1',preparation_datetime='$new_datetime'  where patientvisitcode='$visitcode' and radiologyitemcode='$itemcode' and auto_number='$auto_number'"); 

//      $query26="update ipresultentry_radiology set refund='$status1' ";

  // $exec26=mysql_query($query26) or die(mysql_error());

mysqli_query($GLOBALS["___mysqli_ston"], "update ipconsultation_radiology set docnumber='$docnumber',locationcode ='".$locationcodeget."',locationname='".$locationnameget."',comments='$remarks'  where patientvisitcode='$visitcode' and radiologyitemcode='$itemcode' and auto_number='$auto_number'");

   

   $query42="select * from master_ipvisitentry where visitcode='$visitcode' and itemrefund='refund'";

   $exec42=mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $num42=mysqli_num_rows($exec42);

   if($num42 > 0)

   {

   $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   }

   else

   {

    $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='$status2' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   }

 



}//refund



  else{

	$new_datetime=date('Y-m-d H:i:s');	
	
	$exclude='';	   
$query612 = "select exclude from master_radiology where itemcode='$itemcode'";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res612 = mysqli_fetch_array($exec612);
$exclude = $res612['exclude'];		

  $query234="update ipconsultation_radiology set  clinical_diagnosis='$clinical',prepstatus='$status' ,urgent='$u1',radiologyrefund='$status1',preparation_datetime='$new_datetime',exclude='$exclude'  where patientvisitcode='$visitcode' and radiologyitemcode='$itemcode' and auto_number='$auto_number'";

   $exec234=mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

      $query26="update ipresultentry_radiology set refund='$status1' ";

  // $exec26=mysql_query($query26) or die(mysql_error());

/*mysql_query("update ipconsultation_radiology set docnumber='$docnumber',locationcode ='".$locationcodeget."',locationname='".$locationnameget."',comments='$remarks'  where patientvisitcode='$visitcode' and radiologyitemcode='$itemcode'");*/

   

   $query42="select * from master_ipvisitentry where visitcode='$visitcode' and itemrefund='refund'";

   $exec42=mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   $num42=mysqli_num_rows($exec42);

   if($num42 > 0)

   {

   $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   }

   else

   {

    $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='$status2' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   }

 

  }//refund else



}



}



    header("location:radiologyprep.php");

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

<script src="jquery/jquery-1.11.3.min.js"></script>

<script>





function disableafterclick (varserialnumber3)

 {

var varserialnumber3 = varserialnumber3;

document.getElementById("Class"+varserialnumber3+"").disabled = true;

}



function updateTextField(varserialnumber)

 {

	//var e = document.getElementById('Class');

	//var strText = e.options[e.selectedIndex].text;

	//var strText = e.options[e.selectedIndex].value;

	 //document.getElementById("editor1").disabled="disabled"

    var z = document.getElementById("editor1"+varserialnumber+"").id;	 

	

	//z.value+="blah test 123";

	

	var varserialnumber = varserialnumber;

	var x = document.getElementById("Class"+varserialnumber+"").selectedIndex;

	var y = document.getElementById("Class"+varserialnumber+"").options;

	//alert("Index: " + y[x].index + " is " + y[x].text);

	//document.getElementById('editor1').value= strText; 

	// alert(strText); 

    //document.getElementById('editor1').value= strText; 

   //alert(z);

	//self.location='radiologyentry.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&cat=' + y[x].index+'&&sno='+varserialnumber +'&&tid='+z ;

 }	

 

 function toggleTextArea() 

 {

 		CKEDITOR.appendTo( 'tdata',

				null,

				'<p></p>'

			);

}	



 







function makeDisable1(varserialnumber3)

 {

 var varserialnumber3 = varserialnumber3;

 

 if(document.getElementById("Class"+varserialnumber3+"").checked == true)

{

var x = document.getElementById("Class"+varserialnumber3+"");

x.disabled=true

}

}

function funcOnLoadBodyFunctionCall()

{

	

var varbilltype = document.getElementById("billtype").value;

if(varbilltype == 'PAY LATER')

{

for(i=1;i<=100;i++)

{

document.getElementById("ref"+i+"").disabled = true;

}

}

}





function acknowledgevalid()

{



var chks = document.getElementsByClassName('ack[]');

var hasChecked = false;

for (var i = 0; i < chks.length; i++)

{

if (chks[i].checked)

{

hasChecked = true;

//alert(document.getElementById('comments'+(j+1)).value);

if(document.getElementById('clinical'+(i+1)).value=="")

{

	alert("Please enter clinical diagnosis");

	document.getElementById('clinical'+(i+1)).focus();

	return false;

}





}

}





var chks1 = document.getElementsByClassName('ref[]');

hasChecked1 = false;

for(var j = 0; j < chks1.length; j++)

{

if(chks1[j].checked)

{

hasChecked1 = true;



//alert(document.getElementById('comments'+(j+1)).value);

if(document.getElementById('remarks'+(j+1)).value=="")

{

	alert("Please enter remarks");

	document.getElementById('remarks'+(j+1)).focus();

	return false;

}



}

}







if (hasChecked == false && hasChecked1 == false)

{

alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");

return false;

}

return true;

}



function makeDisable1(varserialnumber3)

 {

 var varserialnumber3 = varserialnumber3;

 

 if(document.getElementById("Class"+varserialnumber3+"").checked == true)

{

var x = document.getElementById("Class"+varserialnumber3+"");

x.disabled=true

}





}

	

function checkboxcheck(varserialnumber)

{



var varserialnumber = varserialnumber;



var varbilltype = document.getElementById("billtype").value;



if(document.getElementById("ack"+varserialnumber+"").checked == true)

{

document.getElementById("clinical"+varserialnumber+"").style.display='block';

document.getElementById("Class"+varserialnumber+"").style.visibility = 'visible';



document.getElementById("ref"+varserialnumber+"").disabled = true;

document.getElementById("urgent"+varserialnumber+"").disabled = false;



}

else

{

document.getElementById("clinical"+varserialnumber+"").style.display='none';

document.getElementById("Class"+varserialnumber+"").style.visibility = 'hidden';



if(varbilltype != 'PAY LATER')

{

document.getElementById("ref"+varserialnumber+"").disabled = false;

}



document.getElementById("urgent"+varserialnumber+"").disabled = true;

if(document.getElementById("urgent"+varserialnumber+"").checked==true)

{

	document.getElementById("urgent"+varserialnumber+"").checked=false;

	}



}

}



function checkboxcheck1(varserialnumber1)

{



var varserialnumber1 = varserialnumber1;



if(document.getElementById("ref"+varserialnumber1+"").checked == true)

{

document.getElementById("ack"+varserialnumber1+"").checked = false;

document.getElementById("ack"+varserialnumber1+"").disabled = true;

document.getElementById("urgent"+varserialnumber1+"").disabled = true;

document.getElementById("remarks"+varserialnumber1+"").style.display='block';

document.getElementById("clinical"+varserialnumber1+"").style.display='none';



if(document.getElementById("urgent"+varserialnumber1+"").checked==true)

{document.getElementById("urgent"+varserialnumber1+"").checked=false;}



}

else

{

document.getElementById("ack"+varserialnumber1+"").disabled = false;

document.getElementById("urgent"+varserialnumber1+"").disabled = false;

	document.getElementById("remarks"+varserialnumber1+"").style.display = 'none';



}

}	





</script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>





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



 select { visibility:hidden; }



body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {

	font-size: 36px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }



.ckeditor {display:none;}

</style>

<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

?>

<script src="js/datetimepicker_css.js"></script>

<?php

$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];

//get locationcode and locationrate

 $locationcode=$res65['locationcode'];

 $locationname=$res65['locationname'];

//get location ends here



$query69="select * from master_customer where customercode='$patientcode'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$patientaccount=$res69['accountname'];



$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res78=mysqli_fetch_array($exec78);

$patientage=$res78['age'];

$patientgender=$res78['gender'];

$billtype = $res78['billtype'];

$patientsubtype = $res78['subtype'];



$subtype="select radtemplate from master_subtype where auto_number='$patientsubtype'";

$exesub=mysqli_query($GLOBALS["___mysqli_ston"], $subtype)or die("Error in subtype".mysqli_error($GLOBALS["___mysqli_ston"]));

$ressub=mysqli_fetch_array($exesub);

$radtemplate=$ressub['radtemplate'];



$query70="select * from master_accountname where auto_number='$patientaccount'";

$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);

$res70=mysqli_fetch_array($exec70);

$accountname=$res70['accountname'];

?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'RRE-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from ipresultentry_radiology where patientcode <> 'walkin' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='IPRRE-'.'1';

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

	

	

	$billnumbercode = 'IPRRE-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall(); ">

<form name="frmsales" id="frmsales" method="post" action="ipradiologyprepentry.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">

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

  

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="1324" border="0" cellspacing="0" cellpadding="0">

  

    <tr>

 <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td></tr>

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#011E6A">

              

                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 

                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">

               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>

	  <td width="25%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">

				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>

                  </td>

                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>

				

                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />

                

                <td width="27%" bgcolor="#ecf0f5" class="bodytext3">

               

                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                  <img src="images2/cal.gif" style="cursor:pointer"/>

				</td>

               <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>

                <td width="15%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">

			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>

                  </td>

               

              </tr>

			 

		

			  <tr>



			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>

                <td width="25%" align="left" valign="middle" class="bodytext3">

			<input name="visitcode" type="hidden" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>

                  </td>

                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>

                <td colspan="1" align="left" valign="middle" class="bodytext3">

				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

                

              <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location </strong></td>

                <td width="2%" colspan="1" align="left" valign="middle" class="bodytext3"><?php echo $locationname;?>

                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">

                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">

				</td>

			    </tr>

				  <tr>



			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3" >

				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php if($year_diff>0){echo $year_diff." year";} else {if($month_diff>0){echo $month_diff." month";} else{echo $day_diff." days";}} ?>

				&

				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>

			        </td>

                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td colspan="3" align="left" valign="top" class="bodytext3">

				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>

				<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">

				

				  </tr>

			  

			   

				  <tr>

				   <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>primary diagnosis</strong></td>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>

              

				  </tr>

            </tbody>

        </table>

		

		</td>

      </tr>

      

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="95%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

              <td width="15%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>

					<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>

					<td width="24%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>

                <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"><strong>Remarks</strong></td>

				 <td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions</strong></div></td>

                <td width="24%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Clinical Diagnosis</strong></div></td>

			    <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"><strong>Urgent</strong></td>

			      </tr>

				  

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;			

$query61 = "select * from ipconsultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry='pending'   and radiologyitemcode='$q_itemcode' and auto_number='$q_refno'  and prepstatus='pending' group by radiologyitemname";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec61);

while($res61 = mysqli_fetch_array($exec61))

{

$radiologyname =$res61["radiologyitemname"];

$radiologycode =$res61["radiologyitemcode"];

$billtype = $res61['billtype'];

$radiologyinstructions = $res61['radiologyinstructions'];
$exclude='';
$query610 = "select exclude from master_radiology where itemcode = '$radiologycode'";
$exec610 = mysqli_query($GLOBALS["___mysqli_ston"], $query610) or die ("Error in Query610".mysqli_error($GLOBALS["___mysqli_ston"]));
$res610 = mysqli_fetch_array($exec610);
$exclude =$res610["exclude"];



if($radtemplate =='')

{

$query68="select * from master_radiology where itemname='$radiologyname' and itemcode='$radiologycode' and status <> 'deleted'";

}

else

{

$query68="select * from $radtemplate where itemname='$radiologyname' and itemcode='$radiologycode' and status <> 'deleted'";

}



//$query68="select * from master_radiology where itemname='$radiologyname'";

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);

$res68=mysqli_fetch_array($exec68);

$itemcode=$res68['itemcode'];

$sno = $sno + 1;

if($exclude=='yes'){
  $externalrad = 1;
  $colorcode = 'bgcolor="yellow"';
}
else{
  $externalrad ='';
  $colorcode = '';
}

?>





  <tr <?php echo $colorcode;?>>

		<td height="40"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $radiologyname;?></div></td>

		<input type="hidden" name="radiology[<?php echo $sno; ?>]" value="<?php echo $radiologyname; ?>">

		<input type="hidden" name="code[<?php echo $sno; ?>]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="auto_number[<?php echo $sno; ?>]" value="<?php echo $q_refno; ?>">

		

		   <td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[<?php echo $sno; ?>]" value="<?php echo $itemcode; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>'); return makeDisable('<?php echo $sno; ?>');" class="ack[]"  /></div></td>

	

	

			   	      </td>

<td class="bodytext31" valign="center"  align="left"><div align="center">

<input type="checkbox" name="ref[<?php echo $sno; ?>]"  class="ref[]"  id="ref<?php echo $sno; ?>"value="<?php echo $itemcode; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>

 <td align="center" valign="center" class="bodytext311" id="remarks123<?php echo $sno; ?>">

 <textarea name="remarks[<?php echo $sno; ?>]"  class="remarks[]"  id="remarks<?php echo $sno; ?>" style="display:none"></textarea>

 </td>

 						  <td height="40"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $radiologyinstructions;?></div></td>



			  <td class="bodytext31" valign="center"  align="left"><div align="center" class="checkcomment">

			  <textarea name="clinical[<?php echo $sno; ?>]" id="clinical<?php echo $sno; ?>" style="display:none"></textarea></div></td>



          <td class="bodytext31" valign="center"  align="left"><div align="center">

			<input type="checkbox" name="urgent[<?php echo $sno; ?>]" class="urgent[]" id="urgent<?php echo $sno; ?>" value="<?php echo $sno; ?>" /></div></td>

		

           

            

            	</tr>

				<tr>

				<?php 

			    $editorid = $_REQUEST['tid'];

				$templatecode = $_REQUEST['cat'];

                $templatesno = $_REQUEST['sno'];

 				$query19 = "select * from master_radiologytemplate where auto_number='$templatecode' ";

				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$numb=mysqli_num_rows($exec19);

                $res19 = mysqli_fetch_array($exec19);

				$templatedata= $res19['templatedata']; 

			  ?>

			   

               <td colspan="3">

			 

			  </td>

			 

               </tr>

			<?php 

		

			}

		?>

			   

			 

			  

			 

               </tr>

          </tbody>

        </table>

		

			</td>

      </tr>

      

      

      

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr>

              <td width="54%" align="right" valign="top" >

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>

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







