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
?>

<?php
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>

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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
#tempid table tr td{
FONT-WEIGHT: normal; !important;
FONT-SIZE: 11px; 	 !important;
COLOR: #3B3B3C;		 !important;
 FONT-FAMILY: Tahoma; !important;
}
</style>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="emrcasesheet.php" onKeyDown="return disableEnterKey(event)">

  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>

<table width="99%" border="0" cellspacing="0" cellpadding="2" style="padding-left:9px">
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
              <tr>
                <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Billing details</strong></td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
            
            

             <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Lab Tests </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Sample Collection</td>
			</tr>

       <?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
			$res7username = $res7['username'];
			$res7labrefund = $res7['labrefund'];
			$res7paymentstatus= $res7['paymentstatus'];
		    ?>
			 <tr>
            <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?></td>
			<?php 
			
			if($res7labrefund=='refund'){ ?>
			<td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res7labrefund; ?></td>
		    <?php } else{ ?>
		    <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res7paymentstatus; ?></td>
		    <?php
		    } ?>
            </tr>
			<?php } ?>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  
		  
		       <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Lab Amends </td>
				
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='lab'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

             <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Radiology Tests </td>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Result Entry</td>
			</tr>

         <?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode'";
			$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			while($res8=mysqli_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
			$res8username = $res8['username'];
			$res8paymentstatus = $res8['paymentstatus'];
			$res8radiologyrefund = $res8['radiologyrefund'];
		    ?> 
			<tr>
            <td colspan="2" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
            <?php echo $radiologyitemname.' - <strong>'.strtoupper($res8username).'</strong>'; ?> </td>
		    <?php 
		
			if($res8radiologyrefund=='refund'){ ?>
			<td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res8radiologyrefund; ?></td>
		    <?php	} else{ ?>
		    <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res8paymentstatus; ?></td>
		    <?php
		    } ?>
          </tr>
		  <?php } ?>
		   <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

		      <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Radiology Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='radiology'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  
              <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Procedures </td>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Result Entry</td>
			</tr>

          <?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode'";
			$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9);
			while($res9=mysqli_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
			$res9username = $res9['username'];
			$res9paymentstatus = $res9['paymentstatus'];
			$res9servicerefund = $res9['servicerefund'];
		    ?>
			<tr>
            <td colspan="2" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
            <?php echo $servicesitemname.' - <strong>'.strtoupper($res9username).'</strong>'; ?>; 
			</td> 
			<?php 			
			if($res9servicerefund=='refund'){ ?>
			<td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res9servicerefund; ?></td>
		    <?php	} else{ ?>
		    <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php echo $res9paymentstatus; ?></td>
		    <?php
		    } ?>
			</tr>
            <?php } ?>
	        <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  
		  
		      <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Procedures Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		     $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='services'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
 
              <?php //master_consultationpharmgeneric//
		     $querygeneric="select * from master_consultationpharmgeneric where patientvisitcode = '$visitcode'";
			$execgeneric=mysqli_query($GLOBALS["___mysqli_ston"], $querygeneric);
			$num6=mysqli_num_rows($execgeneric);
			while($res6=mysqli_fetch_array($execgeneric))
			 {
			$medicinecode = $res6['genericcode'];
			 $medicinename = $res6['genericname'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
			
			$dosemeasure = $res6['dosemeasure'];
			  $consultationid = $res6['consultation_id'];
			
			  $query44 = "select username from master_consultation where consultation_id = '$consultationid' and patientvisitcode='$visitcode' order by auto_number desc";
			$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
			$num44=mysqli_num_rows($exec44);
			$res44=mysqli_fetch_array($exec44);
			$res44username = $res44['username'];
			
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
			
		    ?>
			<?php } ?>


              <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"><span class="bodytext32" style="color:blue;font-weight:bold;font-size:medium">Prescribed Drugs </span></td>
			</tr>               
			
              <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
              
              
             
			  <?php
		    $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6);
			$num6=mysqli_num_rows($exec6);
			while($res6=mysqli_fetch_array($exec6))
			 {
			$medicinecode = $res6['medicinecode'];
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
			$res6consultingdoctor = $res6['consultingdoctor'];
			$res6approver = $res6['approver_username'];
			$dosemeasure = $res6['dosemeasure'];
			if($res6approver == '')
			{
			$res6approver ='Not Yet Approved';
			}
			$query44 = "select * from pharmacysales_details where itemcode = '$medicinecode' and visitcode='$visitcode' order by auto_number desc";
			$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
			$num44=mysqli_num_rows($exec44);
			$res44=mysqli_fetch_array($exec44);
			$res44username = $res44['username'];
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
		    ?>
			<tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename.'<br>Prescribed By - <strong>'.strtoupper($res6consultingdoctor).'</strong>'.'<br>Approved By - <strong>'.strtoupper($res6approver).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php } ?>
			
			
			
          
              <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Issued Drugs </td>
			</tr>               
    
         <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
			  <?php
		    $query60="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec60=mysqli_query($GLOBALS["___mysqli_ston"], $query60);
			$num60=mysqli_num_rows($exec60);
			while($res60=mysqli_fetch_array($exec60))
			 {
			$medicinecode1 = $res60['medicinecode'];
			$medicinename = $res60['medicinename'];
			$dose = $res60['dose'];
			$frequencyauto_number = $res60['frequencyauto_number'];
			$frequencycode = $res60['frequencycode'];
			$days = $res60['days'];
			$route = $res60['route'];
			$quantity = $res60['quantity'];
			$instructions = $res60['instructions'];
			$res6username = $res60['username'];
			$dosemeasure = $res60['dosemeasure'];
			
			$query440 = "select username from pharmacysales_details where itemcode = '$medicinecode1' and visitcode='$visitcode' order by auto_number desc";
			$exec440=mysqli_query($GLOBALS["___mysqli_ston"], $query440);
			$num440=mysqli_num_rows($exec440);
			$res440=mysqli_fetch_array($exec440);
			$res44username = $res440['username'];
			
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
			if($num440!=0)
			{
		    ?>
			<tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename.' - <strong>'.strtoupper($res44username).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php }
			 }?>
			 
			 
			  <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Refunded Drugs </td>
			</tr>               
    
         <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
			  <?php
			  
		    $query60="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec60=mysqli_query($GLOBALS["___mysqli_ston"], $query60);
			$num60=mysqli_num_rows($exec60);
			while($res60=mysqli_fetch_array($exec60))
			 {
			$medicinecode1 = $res60['medicinecode'];
			$medicinename = $res60['medicinename'];
			$dose = $res60['dose'];
			$frequencyauto_number = $res60['frequencyauto_number'];
			$frequencycode = $res60['frequencycode'];
			$days = $res60['days'];
			$route = $res60['route'];
			$quantity = $res60['quantity'];
			$instructions = $res60['instructions'];
			$res6username = $res60['username'];
			$dosemeasure = $res60['dosemeasure'];
			
			/*$query440 = "select username from pharmacysalesreturn_details where itemcode = '$medicinecode1' and visitcode='$visitcode' order by auto_number desc";
			$exec440=mysql_query($query440);
			$num440=mysql_num_rows($exec440);
			$res440=mysql_fetch_array($exec440);
			$res44username = $res440['username'];*/
			
			$res4311quantity=0;
			$query43 = "select itemcode,visitcode from pharmacysalesreturn_details where itemcode = '$medicinecode1' and visitcode='$visitcode'  group by itemcode";
			$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43);
			$num43=mysqli_num_rows($exec43);
			$res43=mysqli_fetch_array($exec43);
			$res43itemcode = $res43['itemcode'];
			$res43visitcode = $res43['visitcode'];
			
			$query431 = "select quantity from pharmacysalesreturn_details where itemcode = '$res43itemcode' and visitcode = '$res43visitcode'";
			$exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431);
			$num431=mysqli_num_rows($exec431);
			while($res431=mysqli_fetch_array($exec431))
			{
			$res431quantity= $res431['quantity'];
			$res4311quantity=$res4311quantity+$res431quantity;
			}
			
			
			
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
			if($num43!=0)
			{
		    ?>
			<tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename.' - <strong>'.strtoupper($res44username).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo number_format($res4311quantity); ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php }
			 }?>
			 
			 
			 
			 
			 
			   <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Drugs Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		     $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='Pharmacy'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
   
  	   <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>