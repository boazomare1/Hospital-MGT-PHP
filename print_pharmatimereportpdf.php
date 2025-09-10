<?php

session_start();

include ("db/db_connect.php");

ob_start();

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$tot1 = "00";

$tot2 = "00";

$tot3='00';

$awt_2='00';

$final_total='00';

$total_hours='00'; 

$total_minutes='00'; 

$tot_time='00'; 

$total_minutes='00'; 

$averageTimeFormatted='00';
$averageSeconds='00';
$averageMinutes='00';
$averageHours='00';
$averageTimePerVisit='00';
$totalSeconds='00';


$docno = $_SESSION['docno'];

//get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		//location get end here

if($location=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$location'";
}

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



$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

//$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];





if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];



	$searchpatient = '';

	$searchpatientcode='';

	

	$searchvisitcode='';

	$fromdate=date('Y-m-d');

	$todate=date('Y-m-d');

	$docnumber='';

	





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["labname"])) { $labname = $_REQUEST["labname"]; } else { $labname = ""; }

if (isset($_REQUEST["labcode"])) { $labcode = $_REQUEST["labcode"]; } else { $labcode = ""; }

//$st = $_REQUEST['st'];



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C;

}

-->

</style>

      

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

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

<?php  include("print_header1.php"); ?>

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchpatient = $_REQUEST['patient'];

	$searchpatientcode=$_REQUEST['patientcode'];

	

	$searchvisitcode=$_REQUEST['visitcode'];

	$fromdate=$_REQUEST['ADate1'];

	$todate=$_REQUEST['ADate2'];

	//$docnumber=$_REQUEST['docnumber'];

		

?>

<h3 align="center">Pharma TAT Report</h3>

		<table id="AutoNumber3"  width="600" border="1" cellspacing="0" cellpadding="4">

         

            <tr>
            
            <td align="left" valign="center" class="bodext31"><strong>No.</strong></td>
            
            <td   align="left" valign="center" class="bodytext31"><strong> Patient </strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Reg No  </strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Visit No  </strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Accountname  </strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Medicine</strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Requested</strong></td>
            
            
            <td align="left" valign="center" class="bodytext31"><strong>Issued By</strong></td>
            
            <td  align="left" valign="center" class="bodytext31"><strong>Total Time</strong></td>
            
            </tr>

           <?php
		   
		   
			  $query23 = "select * from master_consultationpharm where  patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'  and recorddate between '$fromdate' and '$todate' and $pass_location and medicineissue='completed'";  


			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res23 = mysqli_fetch_array($exec23))

			{

			$patientcode = $res23['patientcode'];

			$visitcode = $res23['patientvisitcode'];

			$patientname = $res23['patientname'];

			$itemname = $res23['medicinename'];

			$requestedby = $res23['username'];

			//$publishdatetime = $res23['publishdatetime'];

			$consultationdate = $res23['recorddate'];

	 	    $consultationtime = $res23['consultationtime'];

		    $consul=$consultationdate.' '.$consultationtime;

			$resultdocno = $res23['docnumber'];

			$accountname = $res23['accountname'];
			
			
			$querymed12="select entrydate,entrytime,username from pharmacysales_details where visitcode='$visitcode' and docnumber='$resultdocno'";
			$execmed12=mysqli_query($GLOBALS["___mysqli_ston"], $querymed12);
			$resmed12=mysqli_fetch_array ($execmed12);
			$entrydate=$resmed12['entrydate'];
			$entrytime=$resmed12['entrytime'];
			$pharm_user=$resmed12['username'];
			
		/*			
			$consultationtime=strtotime($consultationtime);
			$reptime=strtotime($entrytime);
			$totalTimeInSeconds = $consultationtime-$reptime;
            $totalTimeInSeconds=abs($totalTimeInSeconds);
           $totalTime = gmdate('H:i', $totalTimeInSeconds);
	
	 	    $consultime=date('H:i:s',strtotime($consultationtime));

			 $consultime1 = strtotime($consultime);


			$start = strtotime($consultime1);*/
		

			   $diff = intval((strtotime($consultationdate.' '.$consultationtime) - strtotime($entrydate.' '.$entrytime))/60);
			   
			   $diff=abs($diff);

				   $hoursstay = intval($diff/60);

                  $minutesstay = $diff%60;
				  
				  $hoursstay=abs($hoursstay);
				  $minutesstay=abs($minutesstay);
				  
				   $los=$hoursstay.':'.$minutesstay;
				  
					if($hoursstay>='24')
					{
					// Split the time into hours and minutes
					list($hours, $minutes) = explode(':', $los);
					
					// Convert hours and minutes to seconds
					$total_seconds = ($hours * 3600) + ($minutes * 60);
					
					// Calculate days, hours, and minutes
					$days = floor($total_seconds / (60 * 60 * 24));
					$hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
					$minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
					$hours=abs($hours);
					$minutes=abs($minutes);
					//$total_time=$days ":Days".$hours: $minutes;
					$los=$days." Days ".$hours.":".$minutes;
					}

				 
				  
				  $total_hours=$total_hours+$hoursstay;
				  $total_minutes=$total_minutes+$minutesstay;

			


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

				$colorcode = '';

			}

			?>

          <tr>

              <td height=""  align="left" valign="center" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>

			   <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>

				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
	  

				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 

             <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>

               <td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?> </td>

               <td class="bodytext31" valign="center"  align="center"><?php echo $consul; ?></td>

               <td class="bodytext31" valign="center"  align="center"><?php echo $entrydate;?><?php echo $entrytime;?></td>


              <td class="bodytext31" valign="center"  align="left"><?php echo $los;?></td>

			  </tr>

		   <?php 

		   } 

		  $total_minutes = ($total_hours * 60) + $total_minutes;

// Ensure minutes are within 0-59 range (handle overflow)
$minutes = $total_minutes % 60;
if ($minutes < 0) {
  $minutes += 60; // Correct for negative values
  $total_hours--;  // Decrement hours if minutes go below 0
}

// Calculate hours from remaining minutes
$hours = floor($total_minutes / 60);

// Format the output as H:i
$total_time = sprintf("%d:%02d", $hours, $minutes);
$fin_hour=$hours;
$fin_min=$minutes;
$tot_time=$total_time;
if($hours>='24')
{
// Split the time into hours and minutes
list($hours, $minutes) = explode(':', $total_time);

// Convert hours and minutes to seconds
$total_seconds = ($hours * 3600) + ($minutes * 60);

// Calculate days, hours, and minutes
$days = floor($total_seconds / (60 * 60 * 24));
$hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
$minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
//$total_time=$days ":Days".$hours: $minutes;
$total_time=$days." Days ".$hours.":".$minutes;
}
		    ?>

<tr>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">Total</td>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $total_time;?></td>

</tr>

<?php
			
			//echo "the time--->".$tot_time=$hours.":".$minutes;
//echo "the totaltimeeee---->".$tot_time;
$snocount=$sno;
			// Split total time into hours, minutes, and seconds
list($hours, $minutes) = sscanf($tot_time, "%d:%d");

$totalSeconds = $hours * 3600 + $minutes * 60;

// Calculate average time per visit in seconds
$averageTimePerVisit = $totalSeconds / $snocount;

// Convert average time per visit back to hours, minutes, and seconds
$averageHours = floor($averageTimePerVisit / 3600);
$averageMinutes = floor(($averageTimePerVisit % 3600) / 60);
$averageSeconds = $averageTimePerVisit % 60;

// Format the result
$averageTimeFormatted = sprintf('%02d:%02d:%02d', $averageHours, $averageMinutes, $averageSeconds);
			 

?>
            
             <tr>

             

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

			             

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"></td>

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"></td>

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

		    <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">AWT</td>

            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $averageTimeFormatted;?></td>

			</tr>


        </table>



      <?php }?>

   
    <?php

	require_once('html2pdf/html2pdf.class.php');

	

    $content = ob_get_clean();



    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('PharmaTat.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 

?>

