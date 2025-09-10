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

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }

 

if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }





$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$amount = '';

$processcount = 0;

$ipprocessstatus='';

$processstatus='';



 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["servicesitemcode"])) { $servicesitemcode = $_REQUEST["servicesitemcode"]; } else { $servicesitemcode = ""; }



if (isset($_REQUEST["patientname"])) { $searchpatientname = $_REQUEST["patientname"]; } else { $searchpatientname = ""; }

if (isset($_REQUEST["patientcode"])) { $searchpatientcode = $_REQUEST["patientcode"]; } else { $searchpatientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $searchvisitcode = $_REQUEST["visitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }

if (isset($_REQUEST["username"])) { $username1 = $_REQUEST["username"]; } else { $username1 = ""; }

if (isset($_REQUEST["processtype"])) { $processtype = $_REQUEST["processtype"]; } else { $processtype = ""; }



if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }

//echo $department;

if (isset($_REQUEST["doctorcode"])) { $doctorcode = $_REQUEST["doctorcode"]; } else { $doctorcode = ""; }

if (isset($_REQUEST["doctorname"])) { $doctorname = $_REQUEST["doctorname"]; } else { $doctorname = ""; }





if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype']; 

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];





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

<script src="js/jquery-1.11.1.min.js"></script>



<script>

$(document).ready(function(){

$('.showdocument').click(function(){

	var sno = $(this).attr('id');

	$('#show'+sno).toggle();	

});

fundisplaydpt();

});

</script>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">

function fundisplaydpt()

{

if(document.cbform1.patienttype.value == 'op')

{

document.getElementById('departmentrow').style.display = '';

}

else

{

document.getElementById('departmentrow').style.display = 'none';

}

}



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here









</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

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

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

    

      

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1360" 

            align="left" border="0">

          <tbody>

		  <?php

            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

		    if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

				$sno=1;

				

			?>

			 <tr bgcolor="#011E6A">

                      <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Report</strong></td>

            </tr>

			<tr>

              <td width="24"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>

              <td width="107" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Request Date</strong></td>

              <td width="114" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>

              <td width="86" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>

              <td width="141" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>

				<td width="141" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient Department</strong></td>

              <td width="156" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Package Code</strong></td>

                <td width="187" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Package Name</strong></td>

                <td width="125" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Package Quantity</strong></td>

				   <td width="125" align="center" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>

                <td width="35" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Processed </strong></td>

				 <td width="156" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Doctor</strong></td>

               <td width="60" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Request Time</strong></td>

				 <td width="60" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Requested By</strong></td>

			

                  

            </tr>

			

			<?php
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	


		if($doctorcode==''){

					

				$queryservices="select cs.auto_number,cs.patientvisitcode,cs.patientcode,cs.servicesitemcode from consultation_services cs join billing_paynow bpn on cs.patientvisitcode=bpn.visitcode where  cs.consultationdate between '$ADate1' and '$ADate2'  and cs.$pass_location and cs.servicesitemcode ='$servicesitemcode'  and cs.username like '%$username1%'  GROUP BY cs.auto_number 

 UNION ALL select cs.auto_number,cs.patientvisitcode,cs.patientcode,cs.servicesitemcode from consultation_services cs join billing_paylater bpn on cs.patientvisitcode=bpn.visitcode where  cs.consultationdate between '$ADate1' and '$ADate2'  and cs.$pass_location and cs.servicesitemcode ='$servicesitemcode'  and cs.username like '%$username1%' GROUP BY cs.auto_number";

				$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($resservice=mysqli_fetch_array($exservice))

				{

					$patientcode=$resservice['patientcode'];

					$patientvisitcode=$resservice['patientvisitcode'];

					$servicesitemcode=$resservice['servicesitemcode'];

					$auto_number = $resservice['auto_number'];

					$drydptpt = "select department from master_department where auto_number in (select department from master_visitentry where visitcode='$patientvisitcode')";

					$execdptpt = mysqli_query($GLOBALS["___mysqli_ston"], $drydptpt) or die("error in drydptpt".mysqli_error($GLOBALS["___mysqli_ston"]));

					$resdptpt = mysqli_fetch_array($execdptpt);

					$patientdepartment = $resdptpt['department'];

					

					  $serviceqty="select process,serviceqty as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate, consultationtime,servicesitemcode,servicesitemname,amount,username from consultation_services where patientcode ='$patientcode' and patientvisitcode='$patientvisitcode' and servicesitemcode='$servicesitemcode'  and $pass_location and auto_number='$auto_number' ";

					$exserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceqty) or die ("error in serviceqty".mysqli_error($GLOBALS["___mysqli_ston"]));

					while ($resqty=mysqli_fetch_array($exserqty))



{					

					 $servicesquantity=$resqty['servicesquantity'];

					$patientname=$resqty['patientname'];

					$consultationdate=$resqty['consultationdate'];

					$consultationtime=$resqty['consultationtime'];

					$servicesitemname=$resqty['servicesitemname'];

					 $amount=$resqty['amount'];

					$requestedby=$resqty['username'];



					$process=$resqty['process'];

					

					if($process=='completed')

					{

						$processstatus='Yes';

						$processcount++;

					}

					else

					{

						$processstatus='No';

					}

					//$approvedby=$resqty['approvedby'];

					$approvedby='';

					

					

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

                    <td width="24"  align="left" 

               class="bodytext31"><?php echo $sno++;?></td>

                <td width="107"  align="left" 

                 class="bodytext31"><?php echo $consultationdate;?></td>

                <td width="114"  align="left" 

                class="bodytext31"><?php echo $patientcode;?></td>

                <td width="86"  align="left" 

                class="bodytext31"><?php echo $patientvisitcode;?></td>

                <td width="141"  align="left" 

                class="bodytext31"><?php echo $patientname;?></td>

				<td width="141"  align="left" 

                class="bodytext31"><?php echo $patientdepartment;?></td>

                <td width="156"  align="left" 

                 class="bodytext31"><?php echo $servicesitemcode;?></td>

                 <td width="187"  align="left" 

                 class="bodytext31"><?php echo $servicesitemname;?></td>

                 <td width="125"  align="center" 

                 class="bodytext31"><?php echo $servicesquantity;?></td>

				 <td width="125"  align="center" 

                 class="bodytext31"><?php echo number_format($amount, 2);?></td>

                 <td width="20"  align="left" 

                 class="bodytext31"><?php echo $processstatus;?></td>

				 <td width="20"  align="left" 

                 class="bodytext31"><?php echo $doctorname;?></td>

				 <td width="20"  align="left" 

                 class="bodytext31"><?php echo $consultationtime;?></td>

                <td width="60"  align="left" 

                 class="bodytext31"><?php echo $requestedby;?></td>

                    </tr>

                    

					<?php	

				}

				}

		}

			

	

					   $queryipservices="select cs.auto_number,cs.patientvisitcode,cs.patientcode,cs.servicesitemcode,cs.doctorname from ipconsultation_services cs join billing_ip bpn on cs.patientvisitcode=bpn.visitcode where  cs.consultationdate between '$ADate1' and '$ADate2' and cs.servicesitemcode='$servicesitemcode' and  cs.doctorcode like '%$doctorcode%' and cs.$pass_location and cs.username like '%$username1%' GROUP BY cs.auto_number order by cs.consultationdate desc";

				$exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryipservices) or die("error in queryipservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($resipservice=mysqli_fetch_array($exipservice))

				{

					$ippatientcode=$resipservice['patientcode'];

					$ippatientvisitcode=$resipservice['patientvisitcode'];

					$ipservicesitemcode=$resipservice['servicesitemcode'];

					$auto_number = $resipservice['auto_number'];

					$doctorname=$resipservice['doctorname'];



					

					 $serviceipqty="select process,serviceqty as servicesquantity,patientcode,patientvisitcode,patientname,consultationdate,consultationtime,servicesitemcode,servicesitemname,amount,username,processedby from ipconsultation_services where patientcode ='$ippatientcode' and patientvisitcode='$ippatientvisitcode' and servicesitemcode='$ipservicesitemcode' and $pass_location and auto_number='$auto_number' ";

					$exipserqty=mysqli_query($GLOBALS["___mysqli_ston"], $serviceipqty) or die ("error in serviceipqty".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($resipqty=mysqli_fetch_array($exipserqty))

					{

					 $servicesipquantity=$resipqty['servicesquantity'];

					$servicesipquantity=number_format($servicesipquantity,2);

					

					

					$ippatientname=$resipqty['patientname'];

					$ipconsultationdate=$resipqty['consultationdate'];

					$ipconsultationtime=$resipqty['consultationtime'];

					$ipservicesitemname=$resipqty['servicesitemname'];

					$amount=$resipqty['amount'];

					 $iprequestedby=$resipqty['username'];

					 $ipprocessedby=$resipqty['processedby'];

					//$ipapprovedby=$resipqty['approvedby'];

					$ipprocess=$resipqty['process'];

					

					if($ipprocess=='completed')

					{

						$ipprocessstatus='Yes';

						$processcount++;

					}

					else

					{

						$ipprocessstatus='No';

					}

					

					

					

					

					

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

                    <td width="24"  align="left" 

               class="bodytext31"><?php echo $sno++;?></td>

                <td width="107"  align="left" 

                 class="bodytext31"><?php echo $ipconsultationdate;?></td>

                <td width="114"  align="left" 

                class="bodytext31"><?php echo $ippatientcode;?></td>

                <td width="86"  align="left" 

                class="bodytext31"><?php echo $ippatientvisitcode;?></td>

                <td width="141"  align="left" 

                class="bodytext31"><?php echo $ippatientname;?></td>

				<td width="141"  align="left" 

                class="bodytext31"><?php echo 'IN Patient';?></td>

                <td width="156"  align="left" 

                 class="bodytext31"><?php echo $ipservicesitemcode;?></td>

                 <td width="187"  align="left" 

                 class="bodytext31"><?php echo $ipservicesitemname;?></td>

                 <td width="125"  align="center" 

                 class="bodytext31"><?php echo $servicesipquantity;?></td>

				  <td width="125"  align="center" 

                 class="bodytext31"><?php echo number_format($amount, 2);?></td>

                 <td width="20"  align="left" 

                 class="bodytext31"><?php echo $ipprocessstatus;?></td>

				 <td width="20"  align="left" 

                 class="bodytext31"><?php echo $doctorname;?></td>

				 <td width="60"  align="left" 

                 class="bodytext31"><?php echo $ipconsultationtime;?></td>

				 <td width="60"  align="left" 

                 class="bodytext31"><?php echo $iprequestedby;?></td>

              

                    </tr>

                    

					<?php	

				}

				}

			

				

			?>

		

			<?php	

				}

			?>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



