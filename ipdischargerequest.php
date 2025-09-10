<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";







if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag1 == 'frmflag1')

{

  //  exit;   

       //get locationcode and locationname for inserting

 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

//get ends here

		$paynowbillprefix7 = 'DIS-';

$paynowbillprefix17=strlen($paynowbillprefix7);

$query27 = "select * from ip_discharge order by auto_number desc limit 0, 1";

$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

$res27 = mysqli_fetch_array($exec27);

$billnumber7 = $res27["docno"];

$billdigit7=strlen($billnumber7);



if ($billnumber7 == '')

{

	$billnumbercode7 =$paynowbillprefix7.'1';

		$openingbalance = '0.00';



}

else

{

	$billnumber7 = $res27["docno"];

	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);

	//echo $billnumbercode;

	$billnumbercode7 = intval($billnumbercode7);

	$billnumbercode7 = $billnumbercode7 + 1;



	$maxanum7 = $billnumbercode7;


	

	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;

		}

		$patientname = $_REQUEST['patientname'];

		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];

		$locationcode = $_REQUEST['locationcode'];
		$accname = $_REQUEST['accname'];

		$ward1 = $_REQUEST['wardanum'];

		$bed1 = $_REQUEST['bedanum'];

		$readytodischarge = $_REQUEST['readytodischarge'];

		$frompage = $_REQUEST['frompage'];

		$patientdischargestatus = $_REQUEST['dischargestatus'];

			

		$query33 = "select * from ip_discharge where docno='$billnumbercode7'";

		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$num33 = mysqli_num_rows($exec33);

		if($num33 == 0)

		{

		if($readytodischarge == 1)

		{

		

		foreach($_POST['dis'] as $key=>$value)

		{

	    $pairs111 = $_POST['dis'][$key];

		$pairvar111 = addslashes($pairs111);

		$pairs112 = $_POST['code'][$key];

		$pairvar112 = addslashes($pairs112);

		$pairs113 = $_POST['dis1'][$key];

				$pairs113 = addslashes($pairs113);



		$pairs114 = $_POST['code1'][$key];

		

		$icdquery = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_icd where disease = '$pairvar111'"); 

		$execicd = mysqli_fetch_array($icdquery);

		$diseasecode = $execicd['icdcode'];

		

		if($pairvar111 != "")

		{

		

		 $icdquery1 = "insert into discharge_icd(dischargeid,patientcode,patientname,patientvisitcode,dischargedate,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$billnumbercode7','$patientcode','$patientname','$visitcode','$updatedate','$pairvar111','$pairs112','$pairs113','$pairs114','$locationnameget','$locationcodeget')";

		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		

		}

		}

		

	//	exit;

		$query67 = "insert into ip_discharge(docno,patientname,patientcode,visitcode,accountname,ward,bed,dischargestatus,recordtime,recorddate,ipaddress,username,locationname,locationcode,req_status,patientdischargestatus,requesttime,requestdate)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$readytodischarge','$updatetime','$updatedate','$ipaddress','$username','".$locationnameget."','".$locationcodeget."','request','$patientdischargestatus','$updatetime','$updatedate')";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		/*$query79 = "update master_bed set recordstatus='' where auto_number='$bed1' and ward='$ward1' and locationcode='".$locationcodeget."'";

		$exec79 = mysql_query($query79) or die(mysql_error());*/

		

		$query81 = "update master_ipvisitentry set discharge='request' where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."'";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$query51 = "select * from ip_bedallocation where visitcode='$visitcode' and locationcode = '$locationcodeget' and recordstatus='transfered'";

		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$num51 = mysqli_num_rows($exec51);

		if($num51 == 0)

		{

			$query88 = "update ip_bedallocation set recordstatus='request' where recordstatus='' and patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."'";

			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysql_query());

		}

		else

		{	

			$query59 = "select ward,bed from ip_bedallocation where visitcode='$visitcode' and recordstatus='' and locationcode = '$locationcodeget' ";

			$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res59 = mysqli_fetch_array($exec59);

			$ward = $res59['ward'];

			$bed = $res59['bed'];

			

			$query881 = "update ip_bedtransfer set recordstatus='request' where recordstatus='' and patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."'";

			$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysql_query());

		}

		

		$query8811 = "update newborn_motherdetails set discharge='request' where patientcode='$patientcode' and patientvisitcode='$visitcode' and locationcode='".$locationcodeget."'";

		$exec8811 = mysqli_query($GLOBALS["___mysqli_ston"], $query8811) or die(mysql_query());

		

		

	}

	

			}

		if($frompage == 'newborn')

		{

		header("location:newbornactivity.php");

		}

		else

		{

		header("location:ipdischargerequestlist.php");

		}

		exit;



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

}





?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'DIS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from ip_discharge order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);



if ($billnumber == '')

{

	$billnumbercode =$paynowbillprefix.'1';

		$openingbalance = '0.00';



}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = $paynowbillprefix .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



?>

<?php



if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if(isset($_REQUEST['patientlocation'])) { $patientlocationcode = $_REQUEST["patientlocation"]; } else { $patientlocationcode = ""; }

if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}



	$query12 = "select * from master_location where locationcode='$patientlocationcode'";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res12 = mysqli_fetch_array($exec12);

	

	 $patientlocationname = $res12["locationname"];

	

?>

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

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script src="js/jquery-ui.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">

<script type="text/javascript" src="js/insertnewitem13.js"></script>

<script type="text/javascript" src="js/insertnewitem14.js"></script>

<?php include ("js/dropdownlist1icd.php"); ?>

<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_newicd.js"></script>





<?php include ("js/dropdownlist1icd1.php"); ?>

<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>

<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>







<script>





function btnDeleteClick13(delID13)

{

	//alert ("Inside btnDeleteClick.");

	//var newtotal;

	//alert(delID4);

	var varDeleteID13= delID13;

	//alert(varDeleteID4);

	

	//alert(rateref);

	//alert (varDeleteID3);

	var fRet13; 

	fRet13 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet13 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child13 = document.getElementById('idTR'+varDeleteID13);  

	//alert (child3);//tr name

    var parent13 = document.getElementById('insertrow13'); // tbody name.

	document.getElementById ('insertrow13').removeChild(child13);

	

	var child13= document.getElementById('idTRaddtxt'+varDeleteID13);  //tr name

    var parent13 = document.getElementById('insertrow13'); // tbody name.

	

	if (child13 != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow13').removeChild(child13);

	}



	

}





function btnDeleteClick14(delID14)

{

	//alert ("Inside btnDeleteClick.");

	//var newtotal;

	//alert(delID4);

	var varDeleteID14= delID14;

	//alert(varDeleteID4);

	

	//alert(rateref);

	//alert (varDeleteID3);

	var fRet14; 

	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet14 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child14 = document.getElementById('idTR'+varDeleteID14);  

	//alert (child3);//tr name

    var parent14 = document.getElementById('insertrow14'); // tbody name.

	document.getElementById ('insertrow14').removeChild(child14);

	

	var child14= document.getElementById('idTRaddtxt'+varDeleteID14);  //tr name

    var parent14 = document.getElementById('insertrow14'); // tbody name.

	

	if (child14 != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow14').removeChild(child14);

	}



	

}



function funcOnLoadBodyFunctionCall()

{ 



	funcCustomerDropDownSearch10();

	funcCustomerDropDownSearch15();



}



function validcheck()

{



	

if(document.getElementById("ward").value == '')

{

alert("Please Select Ward");

document.getElementById("ward").focus();

return false;

}

if(document.getElementById("bed").value == '')

{

alert("Please Select Bed");

document.getElementById("bed").focus();

return false;

}

}







function funcwardChange1()

{

	/*if(document.getElementById("ward").value == "1")

	{

		alert("You Cannot Add Account For CASH Type");

		document.getElementById("ward").focus();

		return false;

	}*/

	<?php 

	$query12 = "select * from master_ward where recordstatus=''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12wardanum = $res12["auto_number"];

	$res12ward = $res12["ward"];

	?>

	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")

	{

		document.getElementById("bed").options.length=null; 

		var combo = document.getElementById('bed'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = '' and locationcode='$patientlocationcode'";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10bedanum = $res10['auto_number'];

		$res10bed = $res10["bed"];

		

		

		

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 

		<?php 

		

		}

		?>

	}

	<?php

	}

	?>	

}



function funcvalidation()

{

if(document.getElementById("insertrow13").childNodes.length < 2)

	{

	alert("Please Enter the primary disease");

	 document.getElementById("dis").focus();

		return false;

	}

	

	if(document.getElementById("dischargestatus").value == "")

	{

		alert("Select Discharge Status");

		document.getElementById("dischargestatus").focus();

		return false;	

	}



if(document.getElementById("readytodischarge").checked == false)

{

alert("Please Click on Ready To Discharge");

return false;

}



}

</script>





<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

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

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="form1" id="form1" method="post" action="ipdischargerequest.php" onSubmit="return validcheck()">	

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14">&nbsp;</td>

  </tr>

  <tr>

    <td width="2%">&nbsp;</td>

   

    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      

	 

	

		<tr>

		<td>



		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

           <?php

		  

		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

		   $query2 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec2);

		

		while($res1 = mysqli_fetch_array($exec2))

		{

		

		

		$locationcodeget = $res1['locationcode'];

		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";

		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res551 = mysqli_fetch_array($exec551);

		$locationnameget = $res551['locationname'];

		}?>

             <tr>

			  <td width="12%" align="center" valign="center" class="bodytext31"><strong> Doc No</strong></td>

			   <td width="13%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>

			   <td width="8%"  align="center" valign="center" class="bodytext31"><strong>Date</strong></td>

			   <td width="13%"  align="center" valign="center" class="bodytext31"> 

			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>

                    <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>               </td>

					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Time</strong></td>

                      <td colspan="2" align="left" valign="center" class="bodytext31"> <input type="text" name="time" id="time" value="<?php echo $updatetime; ?>" size="10" readonly></td>

					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Location</strong></td>

                      <td colspan="2" align="left" valign="center" class="bodytext31"><?php echo $locationnameget; ?>

                       <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">

				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">

                       <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $patientlocationcode; ?>" size="10" readonly></td>

                      

             </tr>

            <tr>

              

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>

           

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>

				 <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>

				<td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>

				<td width="21%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>

              </tr>

           <?php

            $colorloopcount ='';

		

		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus ='' and locationcode='$patientlocationcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientfullname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		

		

		$query67 = "select * from master_accountname where auto_number='$accountname'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 

		$res67 = mysqli_fetch_array($exec67);

		$accname = $res67['accountname'];

		

		

		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='' and locationcode='$patientlocationcode'";

		   $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res63 = mysqli_fetch_array($exec63);

		   $num63 = mysqli_num_rows($exec63);

		   if($num63 > 0)

		   {

		   $ward = $res63['ward'];

		   $bed = $res63['bed'];

		   }

		   

		   $query65 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='' and locationcode='$patientlocationcode' order by auto_number desc";

		   $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res65 = mysqli_fetch_array($exec65);

		    $num65 = mysqli_num_rows($exec65);

		   if($num65 > 0)

		   {

		   $ward = $res65['ward'];

		   $bed = $res65['bed'];

		   }

		   

		  /* $query71 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$patientlocationcode'  order by auto_number desc";

		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res71 = mysqli_fetch_array($exec71);

		   $num71 = mysqli_num_rows($exec71);

		   if($num71 > 0)

		   {

		    $ward = $res71['ward'];

		    $bed = $res71['bed'];

		   }*/

				$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus='' and locationcode='$patientlocationcode'";

						  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  $res7811 = mysqli_fetch_array($exec7811);

						  $wardname1 = $res7811['ward'];

						  

						  $query50 = "select * from master_bed where auto_number='$bed' and locationcode='$patientlocationcode'";

		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  $res50 = mysqli_fetch_array($exec50);

						  $bedname = $res50['bed'];

	



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

             

			  <td colspan="2"  align="left" valign="center" class="bodytext31">

			    <div align="center"><?php echo $patientname; ?></div></td>

				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>

				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>

				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">

				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">

				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">

				 <input name="frompage" id="frompage" value="<?php echo $frompage; ?>" type="hidden">

				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">

				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">

			

				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">

			   </tr>

		   <?php 

		   } 

		  

		   ?>

           

            <tr>

             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             	</tr>

          </tbody>

        </table>		</td>

		</tr>

		

		</table>		</td>

		</tr>

	

      <tr>

        <td>&nbsp;</td>

      </tr>

	    <tr id="disease">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">

                     <!--

					 <tr>

                     <td class="bodytext3">Priliminary Diseases</td>

				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>

                   </tr> -->

                     



                     <tr>

					 <td width="72" class="bodytext3"></td>

                       <td width="423" class="bodytext3">Disease</td>

                       <td class="bodytext3">Code</td>

					   <td class="bodytext3"></td>

                     </tr>

					  <tr>

					 <div id="insertrow13">					 </div></tr>

                     					  <tr>

					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">

					  <input type="hidden" name="diseas" id="diseas" value="">

					  <td class="bodytext3">Primary</td>

				   <td width="423"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>

				      <td width="101"><input name="code[]" type="text" id="code" readonly size="8">

				        <input name="autonum" type="hidden" id="autonum" readonly size="8">

					  <input name="searchdisease1hiddentextbox" type= "hidden" id = "searchdisease1hiddentextbox" >

					  <input name="chapter[]" type="hidden" id="chapter" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem13()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

					   </tr>

				      </table>						</td>

		        </tr>

				

				 

				  <tr id="disease1">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">

                     <tr>

					 <td width="72" class="bodytext3"></td>

                       <td width="423" class="bodytext3">Disease</td>

                       <td class="bodytext3">Code</td>

					   <td class="bodytext3"></td>

                     </tr>

					  <tr>

					 <div id="insertrow14">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">

					  <input type="hidden" name="diseas1" id="diseas1" value="">

					  <td class="bodytext3">Secondary </td>

				   <td width="423"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>

				      <td width="101"><input name="code1[]" type="text" id="code1" readonly size="8">

					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">

					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >

					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

				      </tr>

				      </table>						</td>

		        </tr>

				<tr>

        <td>&nbsp;</td>

        </tr>  

       <tr>

        <td>&nbsp;</td>

		 <td class="bodytext311" align="left"></td>

		  <td class="bodytext311" align="left">Discharge Status &nbsp; <select id="dischargestatus" name="dischargestatus">

                  	<option value="">Select</option>

                    <option value="alive">Alive</option>

                    <option value="death">Death</option>

                    <option value="transfer">Transfer</option>

                    <option value="abscond">Abscond</option>

                    <option value="medical_advice">Against Medical Advice</option>

                    <option value="disposed">Disposed</option>

                  </select></td>

		<td width="26%" align="right" valign="center" class="bodytext311">Request To Discharge</td>

		<td width="29%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="readytodischarge" id="readytodischarge" value="1"></td>

      </tr>

	  <tr>

        <td>&nbsp;</td>

		 <td>&nbsp;</td>

		  <td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td width="37%" align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />

        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>

                 

      </tr>

    </table>

  </table>

</form>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



