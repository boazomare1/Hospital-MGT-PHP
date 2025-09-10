<?php
require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

error_reporting(0);


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$colorloopcount = '';

$transactiondatefrom = date('Y-m-d', strtotime('-6 day'));
$transactiondatefrom = '2000-01-01';
$transactiondateto = date('Y-m-d');

$sno = '';



if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

?>

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }

</style>


<style>

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 22px; COLOR: #000000; font-family: Times;}

.bodytextaddress {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000; font-family: Times;}

</style>

<?php



$locationcode = 'LTC-1';

$queryloc = "select * from master_location where locationcode = 'LTC-1' ";

// $execloc = mysqli_query($queryloc) or die ("Error in Queryloc".mysql_error());
$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$locationname = $resloc['locationname'];

$address1 = $resloc['address1'];

$address2 = $resloc['address2'];

$phone = $resloc['phone'];

$email = $resloc['email'];

$website = $resloc['website'];



// $queryloc = "select tinnumber from master_company";

// $execloc = mysqli_query($queryloc) or die ("Error in Queryloc".mysql_error());

// $resloc = mysqli_fetch_array($execloc);

// $tinnumber = $resloc['tinnumber'];
$tinnumber = '';

?>

<table width="auto" border="" cellpadding="0" cellspacing="0" style="margin: 10px 30px 0px 20px;">



  <tr >

    <td width="350" rowspan="5"  align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytext31"><?php

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";

			// $exec3showlogo = mysqli_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{ 

			?>

      <img src="logofiles/1.jpg" width="200" height="100" />

    <?php

			}

			?></td>

    <td width="320" align="right" valign="middle" 

	 bgcolor="#ffffff" class="bodytexthead"><?php echo $locationname; ?></td>

  </tr>

   <!--  <tr align="right">

      <td height="16" align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytexttin"><strong>Tin Number: <?= $tinnumber;?></strong></td>

    </tr> --> <tr>

      <td align="right" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?><br />

        <?php echo $address2; ?><br />

      Tel : <?php echo $phone; ?><br />

      Email : <?php echo $email; ?></td>

    </tr>

    <tr>

      <td align="right" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress">Website : <?php echo $website; ?></td>

  </tr>

</table>
<div style="margin: 10px 30px 0px 20px;"> <hr></div>

<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="750" align="left" border="0">
<!-- 
  <tr>

  <?php 

$query2 = "select * from master_company where auto_number = '$companyanum'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$companyname = $res2["companyname"];

?>

    <td colspan="5" align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">

	        <?php

			$strlen2 = strlen($companyname);

			$totalcharacterlength2 = 35;

			$totalblankspace2 = 35 - $strlen2;

			$splitblankspace2 = $totalblankspace2 / 2;

			for($i=1;$i<=$splitblankspace2;$i++)

			{

			$companyname = ' '.$companyname.' ';

			}

			?>

      <strong><?php echo $companyname; ?></strong></td>

    </tr>

  <tr>

    <td  colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>

  </tr> -->

  <tr>

    <td colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><div align="center"><strong><u>CASE SHEET</u></strong></div></td>

    </tr>

  <tr>


    <td colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>

  </tr>

  <tr>


    <td colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>

  </tr>
  <?php

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode'");

$execlab=mysqli_fetch_array($Querylab);

$patientname = $execlab['patientname'];

$bedno = $execlab['bed'];

$accountname = $execlab['accountname'];

$recorddate = $execlab['recorddate'];
  
  ?>
  <tr>

		<td width="30%" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><strong>Patient Name</strong></td>

		<td width="10%" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><strong>Visitcode</strong></td>

		<td width="10%" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><strong>Patientcode</strong></td>

		<td width="8%" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><strong>Bed No. </strong></td>

		<td width="10%" align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext32"><strong>Account</strong></td>
		

</tr>

<tr>


    <td colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>

  </tr>
 

   <tr>

		<td width="" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><?php echo $patientname;?></td>

        <!-- <td width="" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"></td> -->
        
		<td width="" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><?php echo $visitcode;?></td>

		<td width="" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><?php echo $patientcode;?></td>

		<td width="" align="left" valign="middle"    bgcolor="#FFFFFF" class="bodytext32"><?php echo $bedno;?></td>

		<td width="" align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext32"><?php echo $accountname;?></td>
		

</tr>

  <tr>


    <td colspan="5" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>

  </tr>
  
</table>
<table cellspacing="3" cellpadding="0" width="750" align="left" border="0"> 
  <tr>
		<td  align="center" class="bodytext31"><strong>Visit Summary </strong></td>
 </tr>
</table>
<table cellspacing="3" cellpadding="0" width="750" align="left" border="0"> 

<tr>

		<td colspan="8" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>

	<?php 

		$query22=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_iptriage where patientcode='$patientcode' and visitcode='$visitcode' ");

		$exec22=mysqli_fetch_array($query22);

		$foodallergy = $exec22['foodallergy'];

		$drugallergy = $exec22['drugallergy'];

		$foodallergy = $exec22['foodallergy'];

		$emergencycontact = $exec22['emergencycontact'];

		$privatedoctor = $exec22['privatedoctor'];

		$weight = $exec22['weight'];

		$height = $exec22['height'];

		$bmi = $exec22['bmi'];

		$doctornotes = $exec22['notes'];

	    $ipconsultationdate = $exec22['consultationdate'];

	?>
   <tr>
   	<?php if($height!=''){ ?>
   
   <td  align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><strong>Height:</strong></td>

   <td width="50" align="middle" valign=""  bgcolor="#FFFFFF" class="bodytext32"><?php echo $height; ?></td>
<?php }if($weight!=''){  ?>
   
    <td  align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><strong>Weight:</strong></td>

   <td  width="50" align="middle" valign=""  bgcolor="#FFFFFF" class="bodytext32"><?php echo $weight; ?></td>
   <?php }if($drugallergy!=''){  ?>
    <td align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><strong>Drug Allergy: </strong></td>

   <td width="180" align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><?php echo $drugallergy; ?></td>
   <?php }if($foodallergy!=''){  ?>
   
   <td  align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><strong>Food  Allergy: </strong></td>

   <td width="180" align="left" valign=""  bgcolor="#FFFFFF" class="bodytext32"><?php echo $foodallergy; ?></td>
   
   <?php }  ?>

   </tr>
   
    <tr>

		<td colspan="8" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>

 <?php
$Queryadmission=mysqli_query($GLOBALS["___mysqli_ston"], "select  recorddate from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode'");

$execadmission=mysqli_fetch_array($Queryadmission);

$res2recorddate = $execadmission['recorddate'];
?>
<tr>

<td colspan="1" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Admission Date: </strong> </td>

<td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $res2recorddate; ?></td>
</tr>

   
<tr>

<td colspan="8" align="center" class="bodytext31">&nbsp;</td>

</tr> 

   <?php 

	$query36=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' ");

    $exec36=mysqli_fetch_array($query36);

	$res36recorddate = $exec36['recorddate'];

	?>
   <tr>
   	<?php if($bmi!=''){  ?>
   <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>BMI:</strong></td>

		<td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $bmi; ?></td>
			<?php }if($res36recorddate!=''){  ?>


		<td colspan="0" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Discharge Date: </strong> </td>

		<td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $res36recorddate; ?></td>
	<?php } ?>
   
   </tr>


   <tr>

		<td colspan="8" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>
 
  </table >

  <!-- ICD///////////////////////////////// -->

<?php
 $query14 = "select * from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'  order by auto_number desc ";

						$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
						 $numcheck11=mysqli_num_rows($exec14); 
						 while ($res14 = mysqli_fetch_array($exec14))

						{

						$primarydiag = $res14['primarydiag'];

						$primaryicdcode = $res14['primaryicdcode'];
						$secicdcode = $res14['secicdcode'];
					}
	  if($primaryicdcode!='' || $secicdcode!=''){ 
						?>
	  	<table  cellspacing="3" cellpadding="3" width="1800" align="left" border="0">

        <tr>

	  <td colspan="9" align="center" valign="middle"   class="bodytext3">

				 <strong>ICD </strong></td> 

     </tr>
    


				  <?php  //discharge_icd
      $query14 = "select * from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'  order by auto_number desc ";

						$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res14 = mysqli_fetch_array($exec14))

						{

						$primarydiag = $res14['primarydiag'];

						$primaryicdcode = $res14['primaryicdcode'];

						$secondarydiag = $res14['secondarydiag'];

						$secicdcode = $res14['secicdcode'];	

						$consultationid = $res14['consultationid'];

						if($primaryicdcode != '')

						{

						?>
						 <tr  >

						 

						<td colspan="1" align="left"  class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3">Primary </td>

						<td  class="bodytext3">Primary Code</td>

						 

						</tr>
						

						<tr  >

						
           					 

           		 <td colspan="1" align="left"  class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3"><?php echo $primarydiag; ?></td>

						<td  class="bodytext3"><?php echo $primaryicdcode; ?></td>
						 

						</tr>

						<?php }

						if($secicdcode != '')

						{

						?>

						<tr>  

						 
						 
						<td colspan="1" align="left"  class="bodytext31"><strong> &nbsp;</strong></td>

						<td  class="bodytext3">Secondary </td>

						<td  class="bodytext3">Secondary Code</td>
						 

						</tr>

						<tr>  


           		 <td colspan="1" align="left"  class="bodytext31"><strong> &nbsp;</strong></td>


						<td  class="bodytext3"><?php echo $secondarydiag; ?></td>

						<td  class="bodytext3"><?php echo $secicdcode; ?></td>
						 

						</tr>

						

						<?php					

						}
						?>
						<tr>
						 
						 <td colspan="3" align="left"  class="bodytext31"><strong> &nbsp;</strong></td>
					</tr>
					 

						
					<?php } ?>
					 
		 
        <tr>

          <td>&nbsp;</td>

        </tr>

      </table>
  <?php } ?>
  <!-- ICD///////////////////////////////// -->
  <!-- ///////////////////////////////// -->
  
<?php

	  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $numcheck1=mysqli_num_rows($exec31); 
	  if($numcheck1>0){ ?>

<table  cellspacing="3" cellpadding="3" width="1800" align="left" border="0">
  
  <tr>

		<td colspan="8" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>
  
   
	 
  <tr>

	  <td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>VITALS INPUT </strong></td> 

  </tr>
  <tr>

	  <td colspan="6" align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td> 

  </tr>
	 
	 <tr>

		    <td width="69" class="bodytext3" valign="center"  align="left"  bgcolor="#ffffff"><strong>Date</strong></td>

			<td width="65"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>

			<td width="58"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Systolic</strong></td>

			<td width="62"  align="left" valign="center"   bgcolor="#ffffff" class="bodytext3"><strong>Diastolic</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Pulse</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Resp</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Username</strong></td>

	 </tr>
	 
	 <?php
	 
	  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);

	  $num=mysqli_num_rows($exec31);

	  while($res31=mysqli_fetch_array($exec31))

	  { 

       $recorddate=$res31['recorddate'];

	   $recorddate=date("d/m/Y", strtotime($recorddate));

	   $recordtime=$res31['recordtime'];

	   $res7username =$res31['username'];

	 

	   $systolic=$res31['systolic'];

	   //$stolic_array[] =$systolic;

	   //$highstolic=rsort($stolic_array);

	   //$highstolic[0];

	  

	   $diastolic=$res31['diastolic'];

	   //$diastolic_array[]=$diastolic;

	   //$diasort[]=sort($diastolic_array);

	  // $diasort[6];

	   //echo end($diastolic_array);

	   //$lastIndex = key($diastolic_array);  

	   //$last[] = $diastolic_array[$lastIndex];

	 

	   $resp=$res31['resp'];

	   $pulse=$res31['pulse'];

	   $tempc=$res31['tempc'];

	   $tempf=$res31['tempf'];

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

          <tr >

		 

		  <td height="25" width="69" class="bodytext3" valign="center"  align="left"  ><?php echo $recorddate; ?></td>

		   <td width="65" class="bodytext3" valign="center"  align="left" ><?php echo $recordtime; ?></td>

		  <td width="58" class="bodytext3" valign="center"  align="left" ><?php echo $systolic; ?></td>

		  <td width="62" class="bodytext3" valign="center"  align="left"><?php echo $diastolic; ?></td>

	      <td width="56" class="bodytext3" valign="center"  align="left"  ><?php echo $resp; ?></td>

		  <td width="56" class="bodytext3" valign="center"  align="left" ><?php echo $pulse; ?></td>

		  <td width="56" class="bodytext3" valign="center"  align="left" ><?php echo $res7username; ?></td>
		      

	    </tr>

		  <?php

		 }

		 ?>

</table>
    <?php

		 }
		  $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);

	  $numcheck2=mysqli_num_rows($exec32);
	  if($numcheck2>0){
		 ?>
	  
<table  cellspacing="3" cellpadding="3" width="1800" align="left" border="0">
  
  <tr>

		<td colspan="8" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>
  
  
  <tr>

	  <td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>INPUT / OUTPUT</strong></td> 

  </tr>
  <tr>

	  <td colspan="6" align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td> 

  </tr>
	 
	 <tr>

		    <td width="69" class="bodytext3" valign="center"  align="left"  bgcolor="#ffffff"><strong>Date</strong></td>

			<td width="65"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>

			<td width="58"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Vomitus</strong></td>

			<td width="62"  align="left" valign="center"   bgcolor="#ffffff" class="bodytext3"><strong>Urine</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Diarrhea</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>N/Gast</strong></td>
			
			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Drains</strong></td>

			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Infused</strong></td>
			
			<td width="56"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Others</strong></td>

	 </tr>
	 
	 <?php

	   

	  $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

	  $exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);

	  $num=mysqli_num_rows($exec32);

	  while($res32=mysqli_fetch_array($exec32))

	  { 

       $fluids=$res32['fluids'];

	   $recorddate=date("d/m/Y", strtotime($res32['recorddate']));

	   $recordtime=$res32['recordtime'];

	   $vomitus=$res32['vomitus'];

	   $urine=$res32['urine'];

	   $drains=$res32['drains'];

       $diarrhea=$res32['diarrhea'];

	   $ngast=$res32['ngast'];

	   $bottle=$res32['bottle'];

	   $amount=$res32['amount'];

	   $infused=$res32['infused'];

	   $others=$res32['others'];




			?>

        <tr >

          <td class="bodytext3"  height="25" width="69"><?php echo $recorddate; ?></td>

          <td class="bodytext3" height="25" width="69" ><?php echo $recordtime; ?></td>

          <td class="bodytext3" height="25" width="69" ><?php echo $vomitus; ?></td>

          <td class="bodytext3" height="25" width="69"  ><?php echo $urine; ?></td>

          <td  class="bodytext3" height="25" width="69"><?php echo $diarrhea; ?></td>

           <td class="bodytext3" height="25" width="69"   ><?php echo $ngast; ?></td>

          <td  class="bodytext3" height="25" width="69"><?php echo $drains; ?></td> 

           <td  class="bodytext3" height="25" width="69"><?php echo $infused; ?></td>    

           <td   class="bodytext3" height="25" width="69"><?php echo $others; ?></td>                 

        </tr>

        <?php

		 }

		 ?>

</table>  
<?php } ?>
<!-- ////////////////////////////////////////// drugs ///////////////// -->
<table  cellspacing="3" cellpadding="0" width="50%" align="left" border="0">
  
 <tr>
 <td colspan="3"></td>
 </tr>
 
  <tr>

	  <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Drugs </strong></td> 

  </tr>
  
  <tr>
 <td colspan="3"></td>
 </tr>
  <tr>
 
	  <td width="20" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Sno</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Medicine</strong></td> 
	  <td width="50" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Quantity</strong></td> 
	  <td width="60" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Requested</strong></td> 
      <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Dose</strong></td> 
	  <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Days</strong></td> 
	  <td width="60" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Measure</strong></td> 
	  <td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Route</strong></td> 
	  <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Freq</strong></td> 
      <td width="60" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Username</strong></td> 

  </tr>

  
  	
                 <?php
             $rsno=0;

             $query34 = "select * from ipmedicine_prescription where patientcode = '$patientcode' and visitcode = '$visitcode'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $docno = $res34['docno'];
		   $quantity = $res34['prescribed_quantity'];
		   $res34date = $res34['date'];
		   $rateperunit = $res34['rateperunit'];
		   $totalrate = $res34['totalrate'];
		   $freestatus = $res34['freestatus'];
		   $username = $res34['username'];
		   $ipaddress = $res34['ipaddress'];
		   $issuedocno = $res34['issuedocno'];
		   $dischargemedicine = $res34['dischargemedicine'];
    


  				  $query35 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' and (docno='$docno' or docno='$issuedocno') and itemcode='$itemcode'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res11221 = mysqli_fetch_array($exec35))

				  {

				   $issuedqty = $res11221['quantity'];
		   $issueduser = $res11221['username'];
		   $issuedipaddress = $res11221['ipaddress'];
		   $issueddate = $res11221['date'];
		   $itemnameph = $res11221['itemname'];
           $dose = $res11221['dose'];
		   $days= $res11221['days'];
		   $dosemeasure = $res11221['dosemeasure'];
           $route = $res11221['route'];
		   $frequency= $res11221['frequency'];

		}

				  ?>

                  <tr>

				  <?php 

				  if(1) { 
				  $rsno=$rsno+1;
				  ?> 
  					<td width="" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $rsno; ?>&nbsp;</td>					
                    <td width="" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $itemnameph; ?>&nbsp;</td>
                    <td width="50" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo round($quantity,2); ?>&nbsp;</td>
                    <td width="60" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $res34date; ?>&nbsp;</td>
                    <td width="40" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $dose; ?>&nbsp;</td>
                    <td width="40" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $days; ?>&nbsp;</td>
                    <td width="60" bgcolor="#ffffff" class="bodytext3"  align="left"><?php echo $dosemeasure; ?>&nbsp;</td>
                    <td width="70" bgcolor="#ffffff" class="bodytext3"  align="left"><?php echo $route; ?>&nbsp;</td>
					<td width="40" bgcolor="#ffffff" class="bodytext3"  align="left"><?php echo $frequency; ?>&nbsp;</td>
                    <td width="60" bgcolor="#ffffff" class="bodytext3"  align="left"><?php echo $username; ?>&nbsp;</td>

                  <?php } ?>

				  </tr>

			<?php  } ?>
	
	 
	
</table>
<!-- ////////////////////////////////////////// drugs ///////////////// -->

<?php

		  
		 $query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname " ;

	  $exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33);

	  $numcheck3=mysqli_num_rows($exec33);
	  if($numcheck3>0){
		 ?>
	  
<table  cellspacing="3" cellpadding="3" width="1800" align="left" border="0">
  
  <tr>

		<td colspan="2" align="center" class="bodytext31">&nbsp;</td>
	
 </tr>
  
  
  <tr>

	  <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>LAB TESTS </strong></td> 

  </tr>
  
  
  
  
  <tr>
   <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Sno</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Item Name</strong></td> 
	</tr>  
	 
	 <?php
   $sno=0;
      $query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname " ;

	  $exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33);

	  $num=mysqli_num_rows($exec33);

	  while($res33=mysqli_fetch_array($exec33))

	  { 

		

		$itemname='';

		//$itemname=$res33['itemname'];

		$labdocnumber=$res33['docnumber'];

		$itemname=$res33['itemname'];

         

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
			$sno=$sno+1;

			?>

          <tr >
          <td width="50" class="bodytext3" valign="center"  align="left"  ><?php echo $sno; ?></td>
		  <td width="200" class="bodytext3" valign="center"  align="left"  ><?php echo $itemname; ?></td>

		</tr>

		   <?php

		 }

		 ?>
</table>
  <?php

		 }
		 $query1 = "select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numcheck4=mysqli_num_rows($exec1);
	  if($numcheck4>0){

				  

		 ?>
<table  cellspacing="3" cellpadding="0" width="50%" align="left" border="0">
  
 <tr>
 <td colspan="3"></td>
 </tr>
 
  <tr>

	  <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>RADIOLOGY TESTS  </strong></td> 

  </tr>
  
  <tr>
 <td colspan="3"></td>
 </tr>
  <tr>

	  <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Sno</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Item Name</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Visit Date</strong></td> 

  </tr>
  
  	
                 <?php
             $rsno=0;
  				  $query1 = "select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				  while ($res1 = mysqli_fetch_array($exec1))

				  {

				  $visitcode = $res1['patientvisitcode'];

				  $visitdate = $res1['recorddate'];
				  $itemnameRD = $res1['itemname'];

				  ?>

                  <tr>

				  <?php 

				  if($searchpatient!= '') { 
				  $rsno=$rsno+1;
				  ?> 
  					<td width="" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $rsno; ?>&nbsp;</td>
					
                    <td width="" bgcolor="#ffffff" class="bodytext3" align="left"><?php echo $itemnameRD; ?>&nbsp;</td>

                    <td width="" bgcolor="#ffffff" class="bodytext3"  align="left"><?php echo $visitdate; ?>&nbsp;</td>

                  <?php } ?>

				  </tr>

			<?php  } ?>
	
	 
	
</table>
<?php  }
 $query34="select * from  ip_progressnotes where visitcode = '$visitcode' order by recorddate desc" ;

	  $exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);

	  $numcheck5=mysqli_num_rows($exec34);
	  if($numcheck5>0){
 ?>
<table  cellspacing="3" cellpadding="0" width="50%" align="left" border="0">
  
 <tr>
 <td colspan="3"></td>
 </tr>
 <tr>
 <td colspan="3"></td>
 </tr>
 
  <tr>

	  <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Nursing cardex  </strong></td> 
	  
	  

  </tr>
  <tr>
 <td colspan="3"></td>
 </tr>
  
  
  <tr>

	  <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Sno</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Record Date</strong></td> 
	  <td width="300" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Note</strong></td> 

  </tr>
  
  	
              <?php
 $nsno=0;
      $query34="select * from  ip_progressnotes where visitcode = '$visitcode' order by recorddate desc" ;

	  $exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);

	  $num=mysqli_num_rows($exec34);

	  while($res34=mysqli_fetch_array($exec34))

	  { 

		$notes=$res34['notes'];

		$recorddate=$res34['recorddate'];

		$usernamenurse=$res34['username'];

		

		

		

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

			
$nsno=$nsno+1;
			?>

      <tr >
       <td class="bodytext3" valign="center"  align="left"><?php echo $nsno; ?></td>
	  
	     <td  align="left" valign="center"  class="bodytext3"  ><?php echo  date("d/m/Y", strtotime($recorddate)); ?></td>

        <td width="500"  align="left" valign="center"  class="bodytext3"  ><?php echo $notes.' - <strong>'.$usernamenurse.'</strong>'; ?></td>

	  </tr>

	  

	   <?php

		 } 

		 ?>
</table>
	  <!-- /////////////////////////// -->
	  <?php  }
 $query35="select * from  ip_doctornotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;

	  $exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35);

	  $numcheck6=mysqli_num_rows($exec35);
	  if($numcheck6>0){
 ?>
<table  cellspacing="3" cellpadding="0" width="50%" align="left" border="0">
  
 <tr>
 <td colspan="3"></td>
 </tr>
  
 
  <tr>

	  <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Doctor Notes  </strong></td> 
	  
	  

  </tr>
  <tr>
 <td colspan="3"></td>
 </tr>
  
  
  <tr>

	  <td width="40" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Sno</strong></td> 
	  <td width="100" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Record Date</strong></td> 
	  <td width="300" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Note</strong></td> 

  </tr>
  
	  <!-- /////////////////////////// -->

	  <?php 

	      $query35="select * from  ip_doctornotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;

	  $exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35);

	  $num=mysqli_num_rows($exec35);

	  while($res35=mysqli_fetch_array($exec35))

	  { 

		$ipdoctornotes=$res35['notes'];

		 $templatedata = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $ipdoctornotes);

		$newcontent = preg_replace("/<p[^>]*?>/", "", $templatedata);
        $newcontent = str_replace("</p>", "<br/>", $newcontent);
        $newcontent = str_replace("</pre>", "<br/>", $newcontent);
		$ipdoctornotes=$newcontent;

		$iprecorddate=$res35['recorddate'];

		$usernamedoc=$res35['username'];

		

		

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
$nsno=$nsno+1;
		

	  ?>	   

	     <tr >	
		  <td class="bodytext3" valign="center"  align="left"><?php echo $nsno; ?></td>

         <td class="bodytext3" valign="center"  align="left"><?php echo  date("d/m/Y", strtotime($iprecorddate)); ?></td>

         <td width="500"  class="bodytext3" valign="center"  align="left" ><?php echo $ipdoctornotes.' - <strong>'.$usernamedoc.'</strong>'; ?></td>

      </tr>

      <?php } ?>

	
	 
	
</table>


<?php
}


  $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

		$html2pdf->setDefaultFont('Arial');

//      $html2pdf->setModeDebug();

        //$html2pdf->SetMargins('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('casesheet.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

