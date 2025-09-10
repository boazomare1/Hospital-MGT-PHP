<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');



$docno = $_SESSION['docno'];

//get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		//location get end here



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$res21itemname='';

$res21itemcode='';

$docnumber1 = '';

//This include updatation takes too long to load for hunge items database.



if (isset($_REQUEST["rowcount"])) { echo $rowcount = $_REQUEST["rowcount"]; } else { $rowcount = ""; }



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}







if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchpatient = $_POST['patient'];

	$searchpatientcode=$_POST['patientcode'];

	

	$searchvisitcode=$_POST['visitcode'];

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];

	$docnumber=$_POST['docnumber'];

}

else

{

	$searchpatient = '';

	$searchpatientcode='';

	

	$searchvisitcode='';

	$fromdate=date('Y-m-d');

	$todate=date('Y-m-d');

	$docnumber='';

}	





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["labname"])) { $labname = $_REQUEST["labname"]; } else { $labname = ""; }

if (isset($_REQUEST["labcode"])) { $labcode = $_REQUEST["labcode"]; } else { $labcode = ""; }

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

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

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



function cbsuppliername1()

{

	document.cbform1.submit();

}







</script>

<script type="text/javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

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



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";

		return false;

	}

}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

  <script> 

$(function() {

	

$('#labname').autocomplete({

		

	source:'ajaxautocomplete_lab.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			$('#labcode').val(code);

			

			},

    });

});

</script>       

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

.number

{

padding-left:900px;

text-align:right;

font-weight:bold;

}

.bali

{

text-align:right;

}

.style1 {font-weight: bold}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

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

		

		

              <form name="cbform1" method="post" action="labtimereport.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Results Time Report</strong></td>

                 <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                 <option value="All">All</option>
                  <?php
	

						$query1 = "select locationcode,locationname from master_employeelocation where username = '$username' group by locationcode";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

              </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatient; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatientcode; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchvisitcode; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			      <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc Number</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $docnumber; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

               <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Lab Name</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="labname" type="text" id="labname" style="border: 1px solid #001E6A;" value="<?php echo $labname; ?>" size="50" autocomplete="off">

                <input name="labcode" type="hidden" id="labcode">

              </span></td>

              </tr>

            <tr>

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

           

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

	<form name="form1" id="form1" method="post" action="publishedlabresults.php">	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{


        if($location=='All')
		{
		$pass_location = "locationcode !=''";
		}
		else
		{
		$pass_location = "locationcode ='$location'";
		}

	$searchpatient = $_POST['patient'];

	$searchpatientcode=$_POST['patientcode'];

	

	$searchvisitcode=$_POST['visitcode'];

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];

	$docnumber=$_POST['docnumber'];


		$queryn21 = "select * from consultation_lab where publishstatus = 'completed' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and resultdoc like '%$docnumber%' and consultationdate between '$fromdate' and '$todate' and $pass_location and labitemcode like '%$labcode%'";

		$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

		$numn21=mysqli_num_rows($execn21);

		$resnw1 = $numn21;

	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1191" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="12" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Time Report </strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>

			 </tr>

            <tr>

              <td width="2%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>

				<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>

				<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname  </strong></div></td>

				

                <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test</strong></div></td>

                <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Requested</strong></div></td>

                

                                <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Collected</strong></div></td>

                <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Results Entered</strong></div></td>

               <!-- <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish DateTimg</strong></div></td>-->

				 <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Publishtime</strong></td>



             <td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Total Time</strong></td>

				

              </tr>

           <?php

		   if($labcode != ""){

		  $query23 = "select * from consultation_lab where publishstatus = 'completed'  and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and resultdoc like '%$docnumber%' and consultationdate between '$fromdate' and '$todate' and $pass_location and labitemcode = '$labcode'";

		   } else {

			 $query23 = "select * from consultation_lab where publishstatus = 'completed'  and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and resultdoc like '%$docnumber%' and consultationdate between '$fromdate' and '$todate' and $pass_location";  

		   }

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res23 = mysqli_fetch_array($exec23))

			{

			$patientcode = $res23['patientcode'];

			$visitcode = $res23['patientvisitcode'];

			$patientname = $res23['patientname'];

			$itemname = $res23['labitemname'];

			$requestedby = $res23['username'];

			$sampledatetime = $res23['sampledatetime'];

			$publishdatetime = $res23['publishdatetime'];

			$consultationdate = $res23['consultationdate'];

	 	$consultationtime = $res23['consultationtime'];

		$consul=$consultationdate.' '.$consultationtime;

			$resultdocno = $res23['resultdoc'];

			$accountname = $res23['accountname'];

			

		 	$sampletime = date('H:i:s',strtotime($sampledatetime));

			$publishtime = date('H:i:s',strtotime($publishdatetime));

			

			 $query023 = "select recorddate,recordtime from resultentry_lab where patientcode like '%$patientcode%' and patientvisitcode like '%$visitcode%' and patientname like '%$patientname%' ";

			$exec023 = mysqli_query($GLOBALS["___mysqli_ston"], $query023) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res023=mysqli_fetch_array($exec023);

			$recordate=$res023['recorddate'];

			$recordtime=$res023['recordtime'];

			$record=$recordate.' '.$recordtime;

			

	 	$consultime=date('H:i:s',strtotime($consultationtime));

			

			 $consultime1 = strtotime($consultime);

			 

		//	$consultime2 = date("H:i:s", $consultime);

			

			

			$time1 = strtotime($sampletime); 

			$time2 = strtotime($publishtime); 

			

			
$datetime1 = new DateTime($sampledatetime);
$datetime2 = new DateTime($publishdatetime);
$interval = $datetime1->diff($datetime2);
$elapsed = $interval->format('%h:%i:%s');
				

			$start = strtotime($consultime1);

			$end =  strtotime($publishtime);

			//$elapsed = $start - $end;

			//echo date("H:i", $elapsed);	

				$taken= $start - $consultime1;

				$totaltaken=date("h:i:s", $taken);

				

			//$totaltime = date("h:i:s", $elapsed);	

			$totaltime =  $elapsed;

			$query24 = "select * from master_employee where username = '$requestedby'";

			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res24 = mysqli_fetch_array($exec24);

			$requestedbyname = $res24['employeename'];

				

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

              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>

				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">

              

			  

				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 

             <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $accountname; ?>

			   </div></td>

               <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemname; ?>

			   </div></td>

               <td class="bodytext31" valign="center"  align="center">

			   <?php echo $consul; ?>

			    </td>

               <td class="bodytext31" valign="center"  align="center">

			   <?php echo $sampledatetime ?>

			    </td>

               <td class="bodytext31" valign="center"  align="center">

			   <?php echo $record; ?>

			    </td>

                   <td class="bodytext31" valign="center"  align="center">

			    <div align="center"><?php echo $publishdatetime; ?></div></td>



              <td class="bodytext31" valign="center"  align="left">

			    <?php echo $totaltime;

				?>

			  </td>

			  </tr>

		   <?php 

		   } 

		  

		   ?>           

            <tr>

             

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			             

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($totalpurchaseamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>



      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

               



			</tr>

            <?php 

			

				$url = "cbfrmflag1=cbfrmflag1&&patient=$searchpatient&&patientcode=$searchpatientcode&&visitcode=$searchvisitcode&&ADate1=$fromdate&&ADate2=$todate&&docnumber=$docnumber&&location=$location&&labcode=$labcode";

				?>

            <tr>

		<td colspan="3"><a href="print_labtimereportpdf.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>

		</tr>

        

          </tbody>

        </table>

		

		

	



	  <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  </form>

      <?php }?>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



