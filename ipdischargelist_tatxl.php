<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



/*header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="ipdischargetat.xls"');

header('Cache-Control: max-age=80');*/



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno=$_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

if(isset($_REQUEST['ADate1']))

   $transactiondatefrom = $_REQUEST['ADate1'];

else

  $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

if(isset($_REQUEST['ADate2']))

   $transactiondateto = $_REQUEST['ADate2'];

else

   $transactiondateto = date('Y-m-d');

$packagename1="";

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$total_hours='00';
$total_minutes='00';


$docno = $_SESSION['docno'];



 //get location for sort by location purpose

   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

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



<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

 <tr>

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

	 $locationcode = $_REQUEST['location'];

	

	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 

            align="left" border="1">

          <tbody>

             

            <tr>

              <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>No.</strong></div></td>

					 <td width="20%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>Patient Name</strong></div></td>

				 <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>Reg No</strong></div></td>

				 <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>IP Visit</strong></div></td>

				<td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>DOD</strong></div></td>

				<td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>DOF</strong></div></td>

				<td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div ><strong>TAT</strong></div></td>

				

			 

              </tr>

            

			<?php

			$sno=1;

			$query110 = "select * from ip_discharge where req_status = 'discharge' and locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by recorddate desc,recordtime desc";

			$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    while($res50 = mysqli_fetch_array($exec50))

		    {  

				

				

				$showcolor = ($sno & 1); 

				if ($showcolor == 0)

				{

					$colorcode = 'bgcolor="#CBDBFA"';

				}

				else

				{

					$colorcode = 'bgcolor="#ecf0f5"';

				}



			  $query221 = "select transactiondate,transactiontime from master_transactionpaylater where visitcode='".$res50['visitcode']."' and patientcode = '".$res50['patientcode']."' and transactiontype='finalize'";

			  $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res221 = mysqli_fetch_array($exec221);

			  $billdate = $res221['transactiondate'];

			  $billtime = $res221['transactiontime'];



			  if($billdate!='') {

				  $diff = intval((strtotime($billdate.' '.$billtime) - strtotime($res50['recorddate'].' '.$res50['recordtime']))/60);

                  //$hoursstay = $diff / ( 60 * 60 );

				  $hoursstay = intval($diff/60);

                  $minutesstay = $diff%60;

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
					//$total_time=$days ":Days".$hours: $minutes;
					$los=$days." Days ".$hours.":".$minutes;
					}

				  
				   $total_hours=$total_hours+$hoursstay;
				  $total_minutes=$total_minutes+$minutesstay;

			  }

			  else

				  $los= '';

		         

			?>





			<tr <?php echo $colorcode; ?>>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $sno;?></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $res50['patientname'];?></td>

			

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $res50['patientcode'];?></td>

             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $res50['visitcode'];?></td>

            

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $res50['recorddate'].' '.$res50['recordtime'];?></td>

				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $billdate.' '.$billtime;?></td>

				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $los;?></td>

				  

			</tr>

             

		<?php	

		   $sno++;

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

                bgcolor="#ecf0f5">Total</td>

				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><?php echo $total_time;?></td>

				  

			</tr>

          </tbody>

        </table>

<?php

}





?>		</td>

      </tr>

     

	 

    </table>

  </table>

</body>

</html>



