<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d');

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Appointment Schedule Report.xls"');

header('Cache-Control: max-age=80');


$errmsg = "";

$supplieranum = "";

$searchsuppliername = "";

$snocount = "";

$colorcode = "";

$colorloopcount = "";

$range = "";

$emailarray1 = '';

$emailarray = '';



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $ADate2;



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

	$fromdate = $_REQUEST['ADate1'];

	$todate = $_REQUEST['ADate2'];

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query33 = "DELETE FROM appointmentschedule_entry WHERE auto_number = '$delanum' ";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	$errmsg = "Appointed Deleted Successfully";

}



?>


 <style>

.xlText {

    mso-number-format: "\@";

}

</style>

 

</head>



<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

 <tr>
 	<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Appointment Schedule Report</strong></td>

 </tr>
 <tr>
 	<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><?php echo $ADate1; ?> To <?php echo $ADate2; ?></td>

 </tr>

  <tr>
 

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      

	  <tr>

        <td>

		

<?php

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



if ($cbfrmflag1 == 'cbfrmflag1')

{

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="943" 

            align="left" border="0">

          <tbody>

             

			  <tr>

				<td width="44"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">No  </td>

				<td width="268"  align="left" valign="center" 

				bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>	

				<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="style1">Reg No. </td>
				<td width="90"  align="left" valign="center"  bgcolor="#ffffff" class="style1">Phone </td>

				<td width="63"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Date </td>

				<td width="58"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Time </td>

				<td width="145"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Department</td>

				<td width="135"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Doctor</td>

				<td width="135"  align="left" valign="center" 

				bgcolor="#ffffff" class="style1">Remarks</td>

			     

			  </tr>					

           <?php

		$query1 = "SELECT * from appointmentschedule_entry where visitstatus = '' and appointmentdate between '$fromdate' and '$todate' and department in (SELECT departmentanum FROM `master_employeedepartment` where username like '$username') order by auto_number desc ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))

		{  

				$res1auto_number =$res1['auto_number'];

				$res1patientname =$res1['patientname'];

				$res1patientcode =$res1['patientcode'];
				$phone =$res1['phone'];

				$res1appointmentdate =$res1['appointmentdate'];

				$res1appointmenttime =$res1['appointmenttime'];

				$res1session =$res1['session'];

				$res2doctorname=$res1['consultingdoctor'];

				$res1department=$res1['department'];

				$remarks = $res1['remarks'];

				   

									

					$query3 = "select * from master_department where auto_number = '$res1department' and recordstatus = '' ";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num3=mysqli_num_rows($exec3);

					$res3 = mysqli_fetch_array($exec3);

					$res3department=$res3['department'];

					  

					

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

				<td width="44" align="left" valign="center" 

				class="bodytext31"><?php echo $snocount = $snocount + 1; ?></td>

					<td width="268"  align="left" valign="center" class="bodytext31"><?php echo $res1patientname; ?></td>

			    <td  align="left" valign="center" class="bodytext31"><?php echo $res1patientcode; ?></td>
			    <td  align="left" valign="center" class="bodytext31"><?php echo $phone; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res1appointmentdate; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo date('H:m',strtotime($res1appointmenttime)).'&nbsp;'.strtoupper($res1session); ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res3department; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $res2doctorname; ?></td>

				<td  align="left" valign="center" class="bodytext31"><?php echo $remarks; ?></td>

		 	    

		 	</tr>	

		 <?php } ?>	 
		 


          </tbody>

        </table>

<?php

}

?></td>


</tr>

</table>


 
</body>

</html>

