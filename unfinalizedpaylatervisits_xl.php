<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$totallab = '0.00';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$totalamount1 = '0.00';

$totalamount2 = '0.00';

$totalamount3 = '0.00';

$totalamount4 = '0.00';

$totalamount5 = '0.00';

$totalamount6 = '0.00';

$totalamount7 = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$res3labitemrate = "";

//This include updatation takes too long to load for hunge items database.

include ("autocompletebuild_account2.php");

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:''; 

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-1 month')); }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

if($location=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$location'";
}	

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="unfinalizedpaylatervisits.xls"');

header('Cache-Control: max-age=80');

?>



<table border="1">

            <tr>

              <td   

                ><strong>No.</strong></td>

				<td width="8%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><strong>Reg. Date</strong></div></td>

              <td width="8%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>

              <td width="7%" align="left" valign="center"  

                 class="bodytext31"><strong>Reg. No </strong></td>

				<td width="11%" align="left" valign="center"  

                 class="bodytext31"><strong>Account </strong></td>

              <td width="14%" align="left" valign="center"  

                 class="bodytext31"><strong>Patient </strong></td>

				  <td width="14%" align="left" valign="center"  

                 class="bodytext31"><strong>Visit Created By </strong></td>

              <td width="7%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Total </strong></div></td>

				<td width="7%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Lab </strong></div></td>

              <td width="7%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Service </strong></div></td>

				<td width="8%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>

				<td width="7%" align="left" valign="center"  

                 class="bodytext31"><div align="right">

				  <div align="right"><strong>Radiology </strong></div>

				  </div></td>

				<td width="7%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>

				<td width="6%" align="left" valign="center"  

                 class="bodytext31"><div align="right"><strong>Referral </strong></div></td>

               

            </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				//if ($cbfrmflag1 == 'cbfrmflag1')

				{

			$query21 = "select accountfullname from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and accountfullname like '%$searchsuppliername%' and $pass_location group by accountfullname order by accountfullname desc";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res21 = mysqli_fetch_array($exec21))

			{

			$res21accountname = $res21['accountfullname'];

			

			$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			$res22accountname = $res22['accountname'];



			if( $res21accountname != '')

			{

			?>

			<!--<tr >

            <td colspan="5"><?php echo $res21accountname;?></td>

            </tr>-->

			

			<?php

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$res3labitemrate = "0.00";

		       

		  $query2 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,username from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and accountfullname = '$res21accountname' and consultationdate between '$ADate1' and '$ADate2' and $pass_location order by accountfullname desc ";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res2 = mysqli_fetch_array($exec2))

		  {

		  $res2patientcode = $res2['patientcode'];

		  $res2visitcode = $res2['visitcode'];

		  $res2patientfullname = $res2['patientfullname'];

		  $res2registrationdate = $res2['consultationdate'];

		  $res2accountname = $res2['accountfullname'];

		  $res2username = $res2['username'];

		 
		  

		  $query3 = "select sum(labitemrate) as labitemrate1 from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  $res3labitemrate = $res3['labitemrate1'];

		  if ($res3labitemrate =='')

		  {

		  $res3labitemrate = '0.00';

		  }

		  else 

		  {

		  $res3labitemrate = $res3['labitemrate1'];

		  }

		  $query4 = "select sum(servicesitemrate) as servicesitemrate1 from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res4 = mysqli_fetch_array($exec4);

		  $res4servicesitemrate = $res4['servicesitemrate1'];

		  if ($res4servicesitemrate =='')

		  {

		  $res4servicesitemrate = '0.00';

		  }

		  else 

		  {

		  $res4servicesitemrate = $res4['servicesitemrate1'];

		  }

		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5 = mysqli_fetch_array($exec5);

		  $res5radiologyitemrate = $res5['radiologyitemrate1'];

		  if ($res5radiologyitemrate =='')

		  {

		  $res5radiologyitemrate = '0.00';

		  }

		  else 

		  {

		   $res5radiologyitemrate = $res5['radiologyitemrate1'];

		  }

		  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res6 = mysqli_fetch_array($exec6);

		  $res6referalrate = $res6['referalrate1'];

		  if ($res6referalrate =='')

		  {

		  $res6referalrate = '0.00';

		  }

		  else 

		  {

		    $res6referalrate = $res6['referalrate1'];

		  }

		  

		  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

		  $res7consultationfees = $res7['consultationfees1'];

		 

		  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res8 = mysqli_fetch_array($exec8);

		  $res8copayfixedamount = $res8['copayfixedamount1'];

		  

		  $consultation = $res7consultationfees - $res8copayfixedamount;

		  

		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res9 = mysqli_fetch_array($exec9);

		  $res9pharmacyrate = $res9['totalamount1'];

		  if ($res9pharmacyrate == '')

		  {

		  $res9pharmacyrate = '0.00';

		  }

		  else 

		  {

		  $res9pharmacyrate = $res9['totalamount1'];

		  }

		  

		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate;

		  $totalamount1 = $totalamount1 + $totalamount;

		  $totalamount2 = $totalamount2 + $res3labitemrate;

		  $totalamount3 = $totalamount3 + $res4servicesitemrate;

		  $totalamount4 = $totalamount4 + $res9pharmacyrate;

		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;

		  $totalamount6 = $totalamount6 + $consultation;

		  $totalamount7 = $totalamount7 + $res6referalrate;

		  $snocount = $snocount + 1;

			

			//echo $cashamount;

			

	

			?>

           <tr >

              <td  ><?php echo $snocount; ?></td>

			   <td  >

                <div class="bodytext31"><?php echo $res2registrationdate; ?></div></td>

               <td  >

                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>

              <td  >

                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>

				<td  >

                <div class="bodytext31"><?php echo $res2accountname; ?></div></td>

              <td  >

			    <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>

				<td  >

			    <div class="bodytext31"><?php echo $res2username; ?></div></td>

              <td  >

			    <div align="right"><?php echo number_format($totalamount,2,'.',','); ?></div></td>

				<td  >

			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>

              <td  >

			  <div align="right"><?php echo number_format($res4servicesitemrate,2,'.',','); ?></div></td>

			  <td  >

			  <div align="right"><?php echo number_format($res9pharmacyrate,2,'.',','); ?></div></td>

			  <td  >

			  <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>

			  <td  >

			  <div align="right"><?php echo number_format($consultation,2,'.',','); ?></div></td>

			  <td >

			  <div align="right"><?php echo number_format($res6referalrate,2,'.',','); ?></div></td>

           </tr>

			<?php

			}

			}

			}

			}

			?>

            <tr>

              <td>&nbsp;</td>

              <td >&nbsp;</td>

				<td>&nbsp;</td>

              <td>&nbsp;</td>

				<td>&nbsp;</td>

				<td >&nbsp;</td>

              <td><strong>Total:</strong></td>

              <td ><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>

				 <td ><strong><?php echo number_format($totalamount2,2,'.',','); ?></strong></td>

				 <td ><strong><?php echo number_format($totalamount3,2,'.',','); ?></strong></td>

				 <td ><strong><?php echo number_format($totalamount4,2,'.',','); ?></strong></td>

				 <td ><strong><?php echo number_format($totalamount5,2,'.',','); ?></strong></td>

              <td><strong><?php echo number_format($totalamount6,2,'.',','); ?></strong></td>

				<td><strong><?php echo number_format($totalamount7,2,'.',','); ?></strong></td>

            </tr>


        </table>