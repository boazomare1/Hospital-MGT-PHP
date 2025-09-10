<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="oprevenuereport_credit_consultation.xls"');
header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	$locationcode = $_REQUEST['locationcode'];

	$department=isset($_REQUEST['department'])?$_REQUEST['department']:'%%';

}



	

	$query12 = "select locationname from master_location where locationcode='$locationcode' order by locationname";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res12 = mysqli_fetch_array($exec12);

	$res1location = $res12["locationname"];





?>

<style type="text/css">



body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}


</style>

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1900" border="0" cellspacing="0" cellpadding="2">

 

  <tr>


    <td width="99%" valign="top">

      <table width="116%" border="0" cellspacing="0" cellpadding="0">


      

      <tr>

        <td>

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" align="left" border="1">

          <tbody>

            <tr>

             <td colspan="12" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Revenue &nbsp; From &nbsp;<?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></strong></td>

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					

					

				}	

					?> 			

               </td>

              </tr>

             <tr>

              	  <td width="3%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>

                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
				  
				  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Number</strong></td>

                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Reg.No</strong></td>

                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Visit No</strong></td>

                  <td width="16%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
                  <td width="16%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Doctor</strong></td>
                  <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>
                  <td width="4%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Dr.Share%</strong></td>
                  <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Dr.Share</strong></td>

                   <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Hosp.Share</strong></td>
                  <td width="12%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Location Name</strong></td>

              </tr>

             

            <?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$colorloopcount = '';

					$tot_amount = 0.00;

					$snocount=0;

					$tot_doctor_amount = 0;
					$tot_hospital_amount = 0;



		        if($locationcode!='All')

				{

			//this query for consultation

			$query1 = "select patientcode,patientname,totalamount,billdate,locationname,visitcode,doctorname,consultation_percentage,sharingamount,billno as billnumber from billing_paylaterconsultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry where department like '$department')
				order by billdate";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['totalamount'];
				  
				  $billnumber = $res1['billnumber'];

				  $doctorname = $res1['doctorname'];

				  $doctor_share_percentage = $res1['consultation_percentage']; 

				  $doctor_amount = $res1['sharingamount'];

				  $hospital_amount = $amount - $doctor_amount;

				  $tot_doctor_amount = $tot_doctor_amount + $doctor_amount;

				  $tot_hospital_amount = $tot_hospital_amount + $hospital_amount;

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>
				  
				   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $doctor_share_percentage; ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($doctor_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($hospital_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				?>

				    	  

				<tr>
					 <td class="bodytext31" colspan="5" valign="center"  align="left"><strong></strong></td>
                  <td class="bodytext31"  valign="center"  align="left"><strong>Total</strong></td>

                 <!--  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>-->

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td> 

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_amount,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_doctor_amount,2,'.',',');  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_hospital_amount,2,'.',',');  ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  </tr>

		   

				  <?php

				}

				}

			

			?>

          </tbody>

        </table>

       </td>

      </tr>

    </table>

   </td>

  </tr> 

</table>

</body>

</html>



