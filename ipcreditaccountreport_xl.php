<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");






$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$tottransactionamount1 = '';

$registrationdate = '';

$packageanum1 = '';

$billtype = '';

$tottransactionamount = '';


header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="IP Credit Account Report.xls"');

header('Cache-Control: max-age=80');



$invoice_amt_total = 0;
$deposits_total = 0;
$outstanding_total = 0;

 $colorloopcount1 =0;

 $sno1 = 0;

 $transactionamount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 	$locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

$searchsuppliername=isset($_REQUEST['searchsuppliername'])?$_REQUEST['searchsuppliername']:'';

if($locationcode1=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$locationcode1'";
			}	

?>


<style>

.xlText {

    mso-number-format: "\@";

}

</style>






</head>







<body>

 

<table  border="0" cellspacing="0" cellpadding="2">

  <tr>
  	<?php $transactiondatefrom = $_REQUEST['transactiondatefrom'];

					$transactiondateto = $_REQUEST['transactiondateto']; ?>

<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>IP Credit Account Report</strong></td>

 </tr>
 <tr>
 	<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></td>

 </tr>

<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td>

      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 



            align="left" border="0">

            <tbody>

            

             <tr>

              <td width="2%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

					 <td width="12%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>

				 <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>

				

				 <td width="4%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>

				  <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">

                <div align="center"><strong>IP Date</strong></div></td>

                <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Type</strong> </div></td>

                <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sub Type</strong> </div></td>

					 <td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No</strong> </div></td>

                

					 <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>

			<!--  <td width="9%"  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Deposits </strong></div></td> -->
                   <td width="9%"  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Amount</strong></div></td>


            <td width="9%"  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposits</strong></div></td>
				    <td width="6%"  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Outstanding</strong></div></td>

				 <td width="9%"  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> visit Limit</strong></div></td>
				 <td width="9%"  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Pre Auth</strong></div></td>

				 <!-- <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Interim</strong></div></td> -->

               

              </tr>

               </tbody>

			  <?php 

			   if (isset($_POST["cbfrmflag1"])) { $cbfrmflag1 = $_POST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



                 if(1)

				 {

					$transactiondatefrom = $_REQUEST['transactiondatefrom'];

					$transactiondateto = $_REQUEST['transactiondateto'];

					$searchpatient = $_REQUEST['searchpatient'];

					$searchpatientcode = $_REQUEST['searchpatientcode'];

					$searchvisitcode = $_REQUEST['searchvisitcode'];
					$locationcode = $_REQUEST['locationcode'];

 //$query34 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' and recordstatus <> '' and locationcode ='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";

 $query34 = "select * from ip_bedallocation where  recorddate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and visitcode NOT IN (select visitcode from billing_ip) and visitcode NOT IN (select visitcode from billing_ipcreditapproved) and $pass_location";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num1 = mysqli_num_rows($exec34);

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $patientname = $res34['patientname'];

		   $patientcode = $res34['patientcode'];

		  $visitcode = $res34['visitcode'];

		   $docnumberr = $res34['docno'];

		   

		   $query36 = "select * from ip_bedtransfer where patientcode= '$patientcode' and visitcode='$visitcode'  and $pass_location  order by auto_number desc ";

		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num36 = mysqli_num_rows($exec36);

		   $res36 = mysqli_fetch_array($exec36);

		   $nbed = $res36['bed'];

		   

           $query35 = "select * from ip_bedallocation where patientcode= '$patientcode' and visitcode='$visitcode' and docno = '$docnumberr' and paymentstatus = '' and creditapprovalstatus = ''  ";

		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res35 = mysqli_fetch_array($exec35);

		   $bednumber = $res35['bed'];

		   $paymentstatus = $res35['paymentstatus'];

		   $creditapprovalstatus = $res35['creditapprovalstatus'];

		   

		     

		   if($num36 > 0)

		     {

			   $bednumber = $nbed; 

			  }

		   

		   $query50 = "select * from master_bed where auto_number='$bednumber'";

		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  $res50 = mysqli_fetch_array($exec50);

						  $bednames = $res50['bed'];

		 

		  

			include ('ipcreditaccountreport3_ipcredit.php');

			// $total = $overalltotal;
			$total = 0;
		//echo  $overalltotal;

		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and $pass_location ";

		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res82 = mysqli_fetch_array($exec82);

		   $accountname = $res82['accountfullname'];

		   $registrationdate = $res82['registrationdate'];

		   $billtype = $res82['billtype'];

		   $overalllimit = $res82['overalllimit'];

		   $patienttype=$res82['type'];

		   $subtype=$res82['subtype'];
		   
		    $visitlimit=$res82['visitlimit'];
			
			$preauth_ref=$res82['preauth_ref'];
		   
		   $query_subtypename = "SELECT subtype from master_subtype where auto_number = '".$subtype."'";
		   	$exec_subtypename = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtypename) or die ("Error in query_subtypename".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ressubtypename = mysqli_fetch_array($exec_subtypename);
			$subtypename=$ressubtypename['subtype'];

		   //$consultationfee = $res82['admissionfees'];

		   

		     $query83 = "select sum(transactionamount) from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'  and recordstatus ='' and $pass_location";

		     $exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		     $res83 = mysqli_fetch_array($exec83);

			$transactionamount = $res83['sum(transactionamount)'];

			

			$tottransactionamount = $tottransactionamount + $transactionamount;

			$tottransactionamount1 = $tottransactionamount1 + $total;

			  

		    $colorloopcount1 = $colorloopcount1 + 1;

			$showcolor1 = ($colorloopcount1 & 1); 

			if ($showcolor1 == 0)

			{

				//echo "if";

				$colorcode1 = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode1 = 'bgcolor="#ecf0f5"';

			}

			$invoice_amt_total += $overalltotal+($totaldepositamount-$totaldepositrefundamount);
			$deposits_total +=($totaldepositamount-$totaldepositrefundamount);
			$outstanding_total +=$overalltotal;


			?>

			  <tr <?php echo $colorcode1; ?>>	  

             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $registrationdate; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patienttype; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $subtypename; ?></div></td>

               

               

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bednames; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accountname; ?></div></td>

			  <!-- <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($transactionamount,2,'.',','); ?></div></td> -->

			  <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($overalltotal+($totaldepositamount-$totaldepositrefundamount),2,'.',','); ?></div></td>


			<td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format(($totaldepositamount-$totaldepositrefundamount),2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($overalltotal,2,'.',',');  ?></div></td>
			 
			 <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($visitlimit,2,'.',',');  ?></div></td>
			 
			  <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo $preauth_ref;  ?></div></td>


			 <!-- <td width="4%"  align="center" valign="center" class="bodytext31"><div align="center"><a target="_blank" href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>View</strong></a> </div></td>
 -->
			  </tr>

			 

		   <!-- <tr>

		   

           <td class="bodytext31" valign="center"  align="center" colspan="9"></td>

           <td class="bodytext31" valign="center" >

           <div align="center"><strong>

		   <?php //echo number_format($tottransactionamount,2,'.',','); ?></strong></div>

           </td>

          

		   <td class="bodytext31" valign="center"  align="right"><div align="center"><strong><?php echo number_format($tottransactionamount1,2,'.',','); ?></strong></div></td>

         </tr> -->

 <?php

			  } ?>

			 

			 

				<?php }

			  ?>
			<tr> 
              <td colspan="8" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5">&nbsp;</td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b>Total : </b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($invoice_amt_total,2,'.',',');  ?></b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($deposits_total,2,'.',',');  ?></b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($outstanding_total,2,'.',',');  ?></b></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5">&nbsp;</td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5">&nbsp;</td>
           	</tr>

		 

          </tbody>

		  

        </table>

		</td>

        </tr>



	 

	  

    </table>

 
</body>

</html>



