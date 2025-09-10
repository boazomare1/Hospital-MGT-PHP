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

$colorloopcount=0;

$searchsuppliername = "";

$totalconsultation = 0;

$totalpharma = 0;

$totallab = 0;

$totalrad = 0;

$totalser = 0;

$totalref = 0;

$referalfee=0;

$pharmfee=0;

$res7username = '';

ini_set('max_execution_time', 300);

$locationcode1=isset($_REQUEST['locationcode1'])?$_REQUEST['locationcode1']:'';
$location=$locationcode1;
$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$fromdate=isset($_REQUEST['fromdate'])?$_REQUEST['fromdate']:'';
$todate=isset($_REQUEST['todate'])?$_REQUEST['todate']:'';
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

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>



<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

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
$("#dialog1").dialog({
    width: '900px', // overcomes width:'auto' and maxWidth bug
	left:'118px',
    maxWidth: 600,
    height: 'auto',
    modal: true,
    fluid: true, //new option
	
    resizable: false
});
</script>
    

<script src="js/datetimepicker_css.js"></script>

</head>

<body>



<table width="101%" border="0" cellspacing="0" cellpadding="2">

 
  
   <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

          

	  <tr>

        <td>



<form name="form1" id="form1" method="post" action="patienthandledby.php">	

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="762" 

            align="left" border="0">

          <tbody>


<tr>
<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="2"><strong> Patient Code</strong></td>
<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="2"><strong>Patient Name </strong></td>
<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Visit</strong></td>
</tr>
<tr>
<?php
$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1patientfullname = $res1['patientfullname'];

$res1patientcode = $res1['patientcode'];

$res1visitcode = $res1['visitcode'];
?>
<tr>

<td  align="left" valign="center" class="bodytext31" colspan="2"><?php echo $res1patientcode; ?></td>
<td  align="left" valign="center" class="bodytext31" colspan="2"><?php echo $res1patientfullname; ?></td>
<td  align="left" valign="center" class="bodytext31"><?php echo $res1visitcode; ?></td>
</tr>
		 
<tr bgcolor="#ecf0f5">
    <td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Consultation</strong></td>
</tr>

<tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Consultation </strong></td>

<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Consultation Amount </strong></td>


</tr>

			  <?php 
			  
			if($locationcode1=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$locationcode1'";
			}	

          	 $qry12 = "select visitcode as visitcode,consultationdate as date from master_visitentry where paymentstatus <> 'completed' and consultationdate between '$fromdate' and '$todate' and $pass_location  and visitcode='$visitcode' order by date ASC";

				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $qry12) or die("Error in Qry12 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res12 = mysqli_fetch_array($exec12))

				{

				$visitcode  = $res12['visitcode'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				$qrysub  = "select fxrate from master_subtype where auto_number = '$subtype'";

				$execsub = mysqli_query($GLOBALS["___mysqli_ston"], $qrysub) or die("Error in Qrysub ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$ressub = mysqli_fetch_array($execsub);

				$fxrate = $ressub['fxrate'];

				if($res1['paymentstatus'] != 'completed')

				{

				$consultationfee = $res1['consultationfees'];

				if($billtype =='PAY LATER' ){

				if( $forall = 'yes' && $planpercentage > 0)

				{

				$consultationfee  =($consultationfee*$planpercentage/100)*$fxrate;

				}

				else

				{

				$consultationfee  =($planfixedamount)*$fxrate;

				}

				}

				}
				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo "Consultation Fee"; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></td>

     
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }
			   ?>
               
<tr bgcolor="#ecf0f5">
<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Pharmacy</strong></td>
</tr>
<tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Medicine Name </strong></td>

<td width="137"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy Amount</strong></td>

</tr>
			   <?php
			     $qry121 = "select patientvisitcode as visitcode,recorddate as date,amount as pharmamount,auto_number as auto_number from master_consultationpharm where pharmacybill='pending' and medicineissue='pending' and amendstatus='2' and recorddate between '$fromdate' and '$todate'  and $pass_location  and patientvisitcode='$visitcode'";

				$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $qry121) or die("Error in Qry121". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res121 = mysqli_fetch_array($exec121))

				{

				$visitcode  = $res121['visitcode'];
				$auto_number  = $res121['auto_number'];
								
				 $qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				 $qrypharm  = "select sum(amount) as pharmamount,medicinename from master_consultationpharm where auto_number='$auto_number'";

				$execpharm = mysqli_query($GLOBALS["___mysqli_ston"], $qrypharm) or die("Error in qrypharm ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$respharm = mysqli_fetch_array($execpharm);

				$pharmfee = $respharm['pharmamount'];
				
				$medicinename = $respharm['medicinename'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$pharmfee = $pharmfee*$planpercentage/100;

				}

			

				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo $medicinename; ?></td>

					<td  align="right" valign="center" class="bodytext31"> <?php echo number_format($pharmfee,2,'.',','); ?></td>

				             
     
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }
			   ?>
<tr bgcolor="#ecf0f5">
<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Lab</strong></td>
</tr>

			   
			   <tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Lab Name </strong></td>

<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Lab Amount </strong></td>


</tr>

			  <?php 
			$colorloopcount=0;

          	   $qry128 = "select patientvisitcode as visitcode,consultationdate as date,auto_number from consultation_lab where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((copay <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location and patientvisitcode='$visitcode'";

				$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $qry128) or die("Error in Qry128". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res128 = mysqli_fetch_array($exec128))

				{

			$visitcode  = $res128['visitcode'];
				$auto_number  = $res128['auto_number'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				$qrysub  = "select fxrate from master_subtype where auto_number = '$subtype'";

				$execsub = mysqli_query($GLOBALS["___mysqli_ston"], $qrysub) or die("Error in Qrysub ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$ressub = mysqli_fetch_array($execsub);

				$fxrate = $ressub['fxrate'];

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qrylab  = "select sum(labitemrate) as labamount from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate' and auto_number='$auto_number'";

				}

				else

				{

				$qrylab  = "select sum(labitemrate) as labamount,labitemname from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate' and auto_number='$auto_number'";

				}

				$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die("Error in Qrylab ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$reslab = mysqli_fetch_array($execlab);

				$labfee = $reslab['labamount'];
				$labitemname = $reslab['labitemname'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$labfee = ($labfee*$planpercentage/100)*$fxrate;

				}


			if($labfee>0)
			{

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo $labitemname; ?></td>


					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($labfee,2,'.',','); ?></td>

     
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

			}

			   }

			  ?>

<tr bgcolor="#ecf0f5">
<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Service</strong></td>
</tr>
<tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Service Name </strong></td>

<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Service Amount </strong></td>


</tr>

			  <?php 
	
              $colorloopcount=0;
          	  $qry12 = "select  patientvisitcode as visitcode,consultationdate as date,auto_number ,sum(amount) as seramount,servicesitemname from consultation_services where paymentstatus='pending' and consultationdate between '$fromdate' and '$todate' and $pass_location and patientvisitcode='$visitcode'";
					$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $qry12) or die("Error in Qry12 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res12 = mysqli_fetch_array($exec12))

				{

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';
				
				 $visitcode  = $res12['visitcode'];
				$auto_number  = $res12['auto_number'];
				$servicefee = $res12['seramount'];
				$servicesitemname = $res12['servicesitemname'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];


				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				
				if($forall == 'yes' && $planpercentage > 0)

				{

				$servicefee = ($servicefee*$planpercentage/100)*$fxrate;

				}
				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo $servicesitemname; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($servicefee,2,'.',','); ?></td>

                
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }
			   ?>
               
<tr bgcolor="#ecf0f5">
<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Radiology</strong></td>
</tr>
<tr>             
<tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Radiology Name</strong></td>

<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Radiology Amount </strong></td>


</tr>

			  <?php 
	
              $colorloopcount=0;
          	   $qry129 = "select patientvisitcode as visitcode,consultationdate as date,auto_number from consultation_radiology where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0)))or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location and patientvisitcode='$visitcode'";

				$exec129 = mysqli_query($GLOBALS["___mysqli_ston"], $qry129) or die("Error in Qry129 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res129 = mysqli_fetch_array($exec129))

				{

				$visitcode  = $res129['visitcode'];
				$auto_number  = $res129['auto_number'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qryrad  = "select sum(radiologyitemrate) as radamount,radiologyitemname from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				 $qryrad  = "select sum(radiologyitemrate) as radamount,radiologyitemname from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $qryrad) or die("Error in Qryrad ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resrad = mysqli_fetch_array($execrad);

				$radfee = $resrad['radamount'];
				$radiologyitemname = $resrad['radiologyitemname'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$radfee = ($radfee*$planpercentage/100)*$fxrate;

				}
				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo $radiologyitemname; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($radfee,2,'.',','); ?></td>

                
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }
			   ?>
<tr bgcolor="#ecf0f5">
<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Referal</strong></td>
</tr>
<tr>              
<tr>

<td width="70"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

<td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" colspan="3"><strong>Referal Name</strong></td>

<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Referal Amount </strong></td>


</tr>

			  <?php 
	
              $colorloopcount=0;
          	    $qry1298 = "select patientvisitcode as visitcode,consultationdate as date,auto_number from consultation_referal where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) and consultationdate between '$fromdate' and '$todate' and referalrate > 0 and $pass_location and patientvisitcode='$visitcode'";

				$exec1298 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1298) or die("Error in Qry1298 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res1298 = mysqli_fetch_array($exec1298))

				{

				$visitcode  = $res1298['visitcode'];
				$auto_number  = $res1298['auto_number'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

					 $qryref  = "select sum(referalrate) as refamount,referalname from consultation_referal where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed'  and consultationdate between '$fromdate' and '$todate' and auto_number='$auto_number'";

				

				$execref = mysqli_query($GLOBALS["___mysqli_ston"], $qryref) or die("Error in qryref ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resref = mysqli_fetch_array($execref);

				$referalfee = $resref['refamount'];
				$referalname = $resref['referalname'];
				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31" colspan="3"><?php echo $referalname; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($referalfee,2,'.',','); ?></td>

                
				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }
			 ?>

			<!--<tr>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5">&nbsp;</td>

				<td  align="left" valign="center" 

				bgcolor="#ecf0f5" class="bodytext31"><strong>Grand Total :</strong></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong><?php $grandtotal = $totalconsultation +$totalpharma +$totallab +$totalrad +$totalser +$totalref ; echo number_format($grandtotal,2,'.',','); ?></strong></td>

				

				<td colspan="2" class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong>Total :</strong></td>

				

			

				<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalconsultation,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalpharma,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totallab,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalser,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalrad,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalref,2,'.',','); ?></strong></td>

			</tr>-->

          </tbody>

        </table>

		 </form>

		 

		 <?php

		 

		 ?></td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



