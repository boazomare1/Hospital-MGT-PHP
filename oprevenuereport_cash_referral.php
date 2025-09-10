<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



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

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top">

      <table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">

          <tbody>
			<tr>
			<td colspan="11" align = "right" >
				<a href="excel_oprevenuereport_cash_referral.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&locationcode=<?php echo $locationcode; ?>"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>
			</td>			
			</tr>
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

                  <td width="14%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>

                  <td width="12%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Visitcode</strong></td>

                  <td width="16%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>

                  <td width="16%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>

                  <td width="16%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Location Name</strong></td>

              </tr>

             

            <?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$colorloopcount = '';

					$tot_amount = 0.00;

					$snocount=0;



		        if($locationcode!='All')

				{

			//this query for consultation

			$query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode,cashamount,billnumber from billing_paynowreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			// $query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode,cashamount,billnumber from billing_paynowreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' ";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  // $amount = $res1['cashamount'];
				  $amount = $res1['referalrate'];
				  
				   $billnumber = $res1['billnumber'];

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				?>

				    	  

				<tr bgcolor="#ecf0f5">

                  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>
				  
				   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_amount,2,'.',',');  ?></strong></div></td>

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



<?php include ("includes/footer1.php"); ?>

</body>

</html>



