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

	$docnumber=$_REQUEST['docnumber'];

		

?>

<h3 align="center">Time Report</h3>

		<table id="AutoNumber3"

            bordercolor="#666666" cellspacing="5" cellpadding="5" width="1283" 

            align="left" border="1" style="border-collapse:collapse;">

         

              <tr>

              <td align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

				<td   align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>

				<td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Reg No  </strong></td>

				<td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Visit No  </strong></td>

              <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Accountname  </strong></td>

				

                <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Test</strong></td>

                <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Requested</strong></td>

                

                                <td align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Sample Collected</strong></td>

                <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Results Entered</strong></td>

               <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Publishtime</strong></td>



             <td align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Total Time</strong></td>

				

              </tr>

           <?php

		   if($labcode != ""){

		  $query23 = "select * from consultation_lab where publishstatus = 'completed' and $pass_location and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and resultdoc like '%$docnumber%' and consultationdate between '$fromdate' and '$todate' and labitemcode = '$labcode'";

		   } else {

			 $query23 = "select * from consultation_lab where publishstatus = 'completed' and $pass_location and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and resultdoc like '%$docnumber%' and consultationdate between '$fromdate' and '$todate'";  

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

			

			

				

			$start = strtotime($consultime1);

			$end =  strtotime($publishtime);

			$elapsed = $start - $end;

			//echo date("H:i", $elapsed);	

				$taken= $start - $consultime1;

				$totaltaken=date("h:i:s", $taken);

				

			$totaltime = date("h:i:s", $elapsed);	

			

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

          <tr>

              <td align="left" valign="center" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>

			   <td width="140" class="bodytext31" valign="center"  align="left">

			  <?php echo $patientname; ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php echo $patientcode; ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php echo $visitcode; ?></td>

				<td width="150" class="bodytext31" valign="center"  align="left">

			    <?php echo $accountname; ?>

			   </td>

               <td width="150" class="bodytext31" valign="center"  align="left">

			    <?php echo $itemname; ?>

			   </td>

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

			    <?php echo $publishdatetime; ?></td>



              <td class="bodytext31" valign="center"  align="left">

			    <?php echo $totaltime;

				?>

			  </td>

			  </tr>

		   <?php 

		   } 

		   ?>           

            <tr>

            <td colspan="11">&nbsp;</td>

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

        $html2pdf->Output('LabtimeReport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 

?>

