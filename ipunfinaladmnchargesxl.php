<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$colorloopcount='';



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipunfinalreport_AdmissionCharges.xls"');
header('Cache-Control: max-age=80');



$colorloopcount ='';

$netamount='';

$totaladmncharges = 0;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="1">

          <tbody>

            <tr>

              <!-- <td width="10%" bgcolor="#fff" class="bodytext31">&nbsp;</td> -->

              <td colspan="7" bgcolor="#fff" class="bodytext31" align="center"><strong>Admission Charge Details</strong></td>

              <!-- <td width="10%" bgcolor="#fff" class="bodytext31">&nbsp;</td> -->

              </tr>            

			

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Doc. No</strong></td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Date</strong></td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Visitcode</strong></td>

              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Amount</strong></td>

            </tr>



        <?php

		$sno=0;

		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";

		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res66 = mysqli_fetch_array($exec66))

		{

			$patientcode = $res66['patientcode'];

			$visitcode = $res66['visitcode'];

			$sno = $sno + 1;

			

			$querymenu = "select * from master_customer where customercode='$patientcode'";

			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$nummenu=mysqli_num_rows($execmenu);

			$resmenu = mysqli_fetch_array($execmenu);

			$menusub=$resmenu['subtype'];
			$customerfullname=$resmenu['customerfullname'];

			

			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$mastervalue = mysqli_fetch_array($exec32);

			$currency=$mastervalue['currency'];

			$fxrate=$mastervalue['fxrate'];

			$subtype=$mastervalue['subtype'];

		

		$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			$packageanum1 = $res17['package'];

			

			$totaladmncharges = $totaladmncharges + $consultationfee;

			

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $viscode;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>

               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>

           </tr>

	<?php

		}

		

		

?>		

         <tr>

              <td colspan="6"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong>Total Admission Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#fff" class="bodytext31"><strong><?php echo number_format($totaladmncharges,2,'.',','); ?></strong></td>

            </tr>

          </tbody>

        </table>

        

			