<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="customerstatement.xls"');

header('Cache-Control: max-age=80');



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;



$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

$balanceamt=0;		  









if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchcustomercode"])) { $searchcustomercode = $_REQUEST["searchcustomercode"]; } else { $searchcustomercode = ""; }

//echo $searchcustomercode;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $amount;

?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="7%"  class="bodytext31">&nbsp;</td>

              <td colspan="14"  class="bodytext31">

           

 				

            </td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

                 <td width="21%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>

              <td width="18%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>

                              <td width="18%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Balance</strong></div></td>

				

            </tr>

            <?php

			

				

				

				//---------------opening balance--------//

			

				

				$colorloopcount = '';

				$sno=1;

				$balanceamt=0;

		 	    $querycustomer="select * from master_customer where customercode = '$searchcustomercode' and registrationdate < '$ADate1' group by customercode";

			$execust=mysqli_query($GLOBALS["___mysqli_ston"], $querycustomer) or die("error in querycustomer".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $numrows=mysqli_num_rows($execust);

			while($rescust=mysqli_fetch_array($execust))

			{

 			

			$registrationdate=$rescust['registrationdate'];

			  $customername=$rescust['customerfullname'];

			$customercode=$rescust['customercode'];

			$debit=0;

				$creditamount=0;

			?>

           

            <?php

		 	  $visitentry="select visitcode,consultationdate,billtype from master_visitentry where patientcode='$customercode' and consultationdate < '$ADate1' group by visitcode order by auto_number desc";

			$exevisit=mysqli_query($GLOBALS["___mysqli_ston"], $visitentry) or die("Error in visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resvisit=mysqli_fetch_array($exevisit))

			{

				

				 $visitcode=$resvisit['visitcode'];

				 $consdate=$resvisit['consultationdate'];

				  $billtype=$resvisit['billtype'];

				if($billtype =="PAY NOW")

				{

					

					   $paylab="select sum(consultation) as consultation from billing_consultation where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exlab=mysqli_query($GLOBALS["___mysqli_ston"], $paylab) or die("Error in $paylab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numlab=mysqli_num_rows($exlab);

				  if($numlab >0)

				  {

					 

				  while($reslab=mysqli_fetch_array($exlab))

				  {

				  $consultation=$reslab['consultation'];

				 

				  }

				  $balanceamt += $consultation;

				  ?>

                 

				  <?php

				  

				  }

					

					

				$paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,accountname,billdate from billing_paynow where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numrow=mysqli_num_rows($paynow);

				while($respaynow=mysqli_fetch_array($paynow))

				{

					

				 //$debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				  $consdate=$respaynow['billdate'];

				  

				  $paylab="select sum(labitemrate) as labitemrate from billing_paynowlab where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exlab=mysqli_query($GLOBALS["___mysqli_ston"], $paylab) or die("Error in $paylab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numlab=mysqli_num_rows($exlab);

				  if($numlab >0)

				  {

					 

				  while($reslab=mysqli_fetch_array($exlab))

				  {

				  $labdebit=$reslab['labitemrate'];

				 

				  }

				  $balanceamt += $labdebit;

				  ?>

                 

				  <?php

				  

				  }

				    $paypharmacy="select sum(amount) as amount from billing_paynowpharmacy where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $expharmacy=mysqli_query($GLOBALS["___mysqli_ston"], $paypharmacy) or die("Error in $paypharmacy".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numpharmacy=mysqli_num_rows($expharmacy);

				  if($numpharmacy >0)

				  {

					  $pharmdebit=0;

				  while($respharmacy=mysqli_fetch_array($expharmacy))

				  {

				  $pharmacydebit=$respharmacy['amount'];

				  

				  }

				  $balanceamt += $pharmacydebit;

				   ?>

                 

				  <?php

				  

				  }

				  

				   $payradiology="select sum(radiologyitemrate) as radiologyitemrate from billing_paynowradiology where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exradiology=mysqli_query($GLOBALS["___mysqli_ston"], $payradiology) or die("Error in $payradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numradiology=mysqli_num_rows($exradiology);

				  if($numradiology >0)

				  {

					 

				  while($resradiology=mysqli_fetch_array($exradiology))

				  {

				  $radiologydebit=$resradiology['radiologyitemrate'];

				  

				  }	

				  $balanceamt += $radiologydebit;

				  			   ?>

                 

				  <?php

				  

				  }

				  

				   $payreferal="select sum(referalrate) as referalrate from billing_paynowreferal where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exreferal=mysqli_query($GLOBALS["___mysqli_ston"], $payreferal) or die("Error in $payreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numreferal=mysqli_num_rows($exreferal);

				  if($numreferal >0)

				  {

					  $refdebit=0;

				  while($resreferal=mysqli_fetch_array($exreferal))

				  {

					  

				  $referaldebit=$resreferal['referalrate'];

				   

				  }

				  $balanceamt += $referaldebit;

				    ?>

                 

				  <?php

				  

				  }

				  

				  $payservices="select sum(amount) as amount from billing_paynowservices where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exservices=mysqli_query($GLOBALS["___mysqli_ston"], $payservices) or die("Error in $payservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numservices=mysqli_num_rows($exservices);

				  if($numservices >0)

				  {

					  

				  while($resservices=mysqli_fetch_array($exservices))

				  {

				  $servicesdebit=$resservices['amount'];

				  

				  }

				  $balanceamt += $servicesdebit;

				   ?>

                  

				  <?php

				  

				  }

				  

				

				}

				

				  

				 $refundpaynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(transactionamount) as refamount,billnumber,accountname,transactiondate from refund_paynow where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while($resrefund=mysqli_fetch_array($refundpaynow))

				 {

				  //$creditamount=$resrefund['refamount'];

				  $billnumber =$resrefund['billnumber'];

				  $accountname =$resrefund['accountname'];

				  $consdate=$resrefund['transactiondate'];

				  

				   $refundlab="select sum(labitemrate) as labitemrate from refund_paynowlab where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundlab=mysqli_query($GLOBALS["___mysqli_ston"], $refundlab) or die("Error in $refundlab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundlab=mysqli_num_rows($exrefundlab);

				  if($numrefundlab > 0)

				  {

				  while($resrefundlab=mysqli_fetch_array($exrefundlab))

				  {

					  

					$labcredit=$resrefundlab['labitemrate'];  

					

					$balanceamt -=$labcredit;

					

				  ?>

			

			<?php

				  }

				  }

				  

				     $refundpharm="select sum(amount) as amount from refund_paynowpharmacy where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundpharm=mysqli_query($GLOBALS["___mysqli_ston"], $refundpharm) or die("Error in $refundpharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundpharm=mysqli_num_rows($exrefundpharm);

				  if($numrefundpharm > 0)

				  {

				  while($resrefundpharm=mysqli_fetch_array($exrefundpharm))

				  {

					 

					 $pharmcredit=$resrefundpharm['amount'];  

					

					

					$balanceamt -=$pharmcredit;

					

				  }

				  ?>

			

			<?php

				  }

				  

				   $refundradiology="select sum(radiologyitemrate) as radiologyitemrate from refund_paynowradiology where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundradiology=mysqli_query($GLOBALS["___mysqli_ston"], $refundradiology) or die("Error in $refundradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundradiology=mysqli_num_rows($exrefundradiology);

				  if($numrefundradiology > 0)

				  {

				  while($resrefundradiology=mysqli_fetch_array($exrefundradiology))

				  {

					 

					$radiologycredit=$resrefundradiology['radiologyitemrate'];  

					

					

					$balanceamt -=$radiologycredit;

				

				  }

				  ?>

			

			<?php

				  }

				  

				  $refundreferal="select sum(referalrate) as referalrate from refund_paynowreferal where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundreferal=mysqli_query($GLOBALS["___mysqli_ston"], $refundreferal) or die("Error in $refundreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numexrefundreferal=mysqli_num_rows($exrefundreferal);

				  if($numexrefundreferal > 0)

				  {

				  while($resrefundreferal=mysqli_fetch_array($exrefundreferal))

				  {

					 

					$referalcredit=$resrefundreferal['referalrate'];  

					

					

					$balanceamt -=$referalcredit;

					

				  }

				  ?>

			

			<?php

				  }

				  

				   $refundservices="select sum(serviceamount) as serviceamount from refund_paynowservices where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundservices=mysqli_query($GLOBALS["___mysqli_ston"], $refundservices) or die("Error in $refundservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundservices=mysqli_num_rows($exrefundservices);

				  if($numrefundservices > 0)

				  {

				  while($resrefundservices=mysqli_fetch_array($exrefundservices))

				  {

					  

					$servicescredit=$resrefundservices['serviceamount'];  

					

					$balanceamt -=$servicescredit;

					

				  }

				  ?>

			

			<?php

				  }

				  

				

			

				 }

				 

				 }

				

				if($billtype =="PAY LATER")

				{

					$laterlabbalance=0;

					//laterpharmbalance

					//laterraadiologybalance

					//$a="select sum(totalamount) as totamount,billno,accountname,billdate from billing_paylater where visitcode='$visitcode' group by visitcode";

				$paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,accountname,billdate from billing_paylater where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numrow=mysqli_num_rows($paynow);

				 while($respaynow=mysqli_fetch_array($paynow))

				 {

					 

				  $debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				   $consdate=$respaynow['billdate'];

				   

				   //consultation//

				   

				    $latercon="select  sum(totalamount) as totalamount from billing_paylaterconsultation where visitcode='$visitcode' group by billno";

				   $exlatercon=mysqli_query($GLOBALS["___mysqli_ston"], $latercon) or die("Error in $latercon".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlatercon=mysqli_num_rows($exlatercon);

				   if($numlatercon > 0)

				   {

				while($reslatercon=mysqli_fetch_array($exlatercon))

				{

					 $paylatercon=$reslatercon['totalamount'];

					 

			

			$balanceamt +=$paylatercon;

			?>

			

			<?php

			}

				   }

				   

				    $laterlab="select  sum(labitemrate) as labitemrate from billing_paylaterlab where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterlab=mysqli_query($GLOBALS["___mysqli_ston"], $laterlab) or die("Error in $laterlab".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterlab=mysqli_num_rows($exlaterlab);

				   if($numlaterlab > 0)

				   {

				while($reslaterlab=mysqli_fetch_array($exlaterlab))

				{

					 $paylaterlab=$reslaterlab['labitemrate'];

					 

			

			$balanceamt +=$paylaterlab;

			?>

			

			<?php

			}

				   }

				   

				   //pharmacy//

				   

				    $laterpharm="select sum(amount) amount from billing_paylaterpharmacy where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterpharm=mysqli_query($GLOBALS["___mysqli_ston"], $laterpharm) or die("Error in $laterpharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterpharm=mysqli_num_rows($exlaterpharm);

				   if($numlaterpharm > 0)

				   {

				while($reslaterpharm=mysqli_fetch_array($exlaterpharm))

				{

					 $paylaterpharm=$reslaterpharm['amount'];

					

			

			$balanceamt +=$paylaterpharm;

			?>

			

			<?php

			}

				   }

				   

				   //radiology//

				    $laterradiology="select sum(radiologyitemrate) as radiologyitemrate from billing_paylaterradiology where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterradiology=mysqli_query($GLOBALS["___mysqli_ston"], $laterradiology) or die("Error in $laterradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				    $numlaterradiology=mysqli_num_rows($exlaterradiology);

				   if($numlaterradiology > 0)

				   {

				while($reslaterradiology=mysqli_fetch_array($exlaterradiology))

				{

					$paylaterradiology=$reslaterradiology['radiologyitemrate'];

					

			 

			$balanceamt +=$paylaterradiology;

			?>

			 

			<?php

			}

				   }

				   

				   //referral//

				    $laterreferal="select sum(referalamount) as referalamount from billing_paylaterreferal where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterreferal=mysqli_query($GLOBALS["___mysqli_ston"], $laterreferal) or die("Error in $laterreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				    $numlaterreferal=mysqli_num_rows($exlaterreferal);

				   if($numlaterreferal > 0)

				   {

				while($reslaterreferal=mysqli_fetch_array($exlaterreferal))

				{

					$paylaterreferal=$reslaterreferal['referalamount'];

					

			

			$balanceamt +=$paylaterreferal;

			?>

			

			<?php

			}

				   }

				   //services//

				   

				     $laterservices="select sum(servicesitemrate) as servicesitemrate from billing_paylaterservices where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterservices=mysqli_query($GLOBALS["___mysqli_ston"], $laterservices) or die("Error in $laterservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterservices=mysqli_num_rows($exlaterservices);

				   if($numlaterservices > 0)

				   {

					  

				while($reslaterservices=mysqli_fetch_array($exlaterservices))

				{

					 $paylaterservices=$reslaterservices['servicesitemrate'];

					

			 

			$balanceamt +=$paylaterservices;

			?>

			

			<?php

			}

				   }

				   

				 }

				 

				 

				 $refundpaynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(transactionamount) as refamount,billno,accountname,billdate from refund_paylater where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while($resrefund=mysqli_fetch_array($refundpaynow))

				 {

				 //$creditamount=$resrefund['refamount'];

				 $billnumber =$resrefund['billno'];

				  $accountname =$resrefund['accountname'];

				  $consdate=$resrefund['billdate'];

				  

				  $refund_lab="select sum(labitemrate) as labitemrate from refund_paylaterlab where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_lab=mysqli_query($GLOBALS["___mysqli_ston"], $refund_lab) or die("Error in refund_lab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_lab=mysqli_num_rows($exrefund_lab);

				  if($numrefund_lab > 0)

				  {

				  while($resrefund_lab=mysqli_fetch_array($exrefund_lab))

				  {

					$refund_paylaterlab=$resrefund_lab['labitemrate'];

					

			

			$balanceamt -=$refund_paylaterlab;

			?>

			

			<?php

			}

				

			}

			

			$refund_pharmacy="select sum(amount) as amount from refund_paylaterpharmacy where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_pharm=mysqli_query($GLOBALS["___mysqli_ston"], $refund_pharmacy) or die("Error in refund_pharmacy".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_pharm=mysqli_num_rows($exrefund_pharm);

				  if($numrefund_pharm > 0)

				  {

					  

				  while($resrefund_pharm=mysqli_fetch_array($exrefund_pharm))

				  {

					 $refund_paylaterpharm=$resrefund_pharm['amount'];

					

			 

			$balanceamt -=$refund_paylaterpharm;

			?>

			

			<?php

			}

				

			}

			

			

			$refund_radiology="select sum(radiologyitemrate) as radiologyitemrate from refund_paylaterradiology where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_radiology=mysqli_query($GLOBALS["___mysqli_ston"], $refund_radiology) or die("Error in refund_radiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_radiology=mysqli_num_rows($exrefund_radiology);

				  if($numrefund_radiology > 0)

				  {

				  while($resrefund_radiology=mysqli_fetch_array($exrefund_radiology))

				  {

					$refund_paylaterrad=$resrefund_radiology['radiologyitemrate'];

					

			

			$balanceamt -=$refund_paylaterrad;

			?>

			 

			<?php

			}

				

			}

			

			$refund_referal="select sum(referalrate) as referalrate from refund_paylaterreferal where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_referal=mysqli_query($GLOBALS["___mysqli_ston"], $refund_referal) or die("Error in refund_referal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_referal=mysqli_num_rows($exrefund_referal);

				  if($numrefund_referal > 0)

				  {

				  while($resrefund_referal=mysqli_fetch_array($exrefund_referal))

				  {

					$refund_paylaterref=$resrefund_referal['referalrate'];

					

			

			$balanceamt -=$refund_paylaterref;

			?>

			

			<?php

			}

				

			}

			

			$refund_service="select sum(amount) as amount from refund_paylaterservices where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_service=mysqli_query($GLOBALS["___mysqli_ston"], $refund_service) or die("Error in refund_service".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_service=mysqli_num_rows($exrefund_service);

				  if($numrefund_service > 0)

				  {

				  while($resrefund_service=mysqli_fetch_array($exrefund_service))

				  {

					$refund_services=$resrefund_service['amount'];

					

			 

			$balanceamt -=$refund_paylaterref;

			?>

			

			<?php

			}

				

			}

			

				  }

			

			

			

				}

			

			}

			

			

			//-----------IP---------------//

			 $visitentry="select visitcode,consultationdate,billtype from master_ipvisitentry where patientcode='$customercode' and consultationdate < '$ADate1' group by visitcode order by auto_number desc";

			$exevisit=mysqli_query($GLOBALS["___mysqli_ston"], $visitentry) or die("Error in visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resvisit=mysqli_fetch_array($exevisit))

			{

				  $visitcode=$resvisit['visitcode'];

				 $consdate=$resvisit['consultationdate'];

				  $billtype=$resvisit['billtype'];

				

				$paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,billdate,accountname from billing_ip where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $numrow=mysqli_num_rows($paynow);

				 while($respaynow=mysqli_fetch_array($paynow))

				 {

				 // $debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				   $consdate=$respaynow['billdate'];

				   

				   $ipadmission=" select sum(amount) as amount from billing_ipadmissioncharge where visitcode='$visitcode' group by docno";

				   $exadmission=mysqli_query($GLOBALS["___mysqli_ston"], $ipadmission) or die("Error in $ipadmission".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numipadmission=mysqli_num_rows($exadmission);

				   

				   while($resipadmission=mysqli_fetch_array($exadmission))

				   {

					   $ipadmissioncharge=$resipadmission['amount'];

				   

				  if($ipadmissioncharge >0 )

			{

		

			 $balanceamt = $balanceamt + $ipadmissioncharge;

			?>

			 

			<?php

			}

				 }

				 

				 $ipambulance=" select sum(amount) as amount from billing_ipambulance where visitcode='$visitcode' group by docno";

				   $exipambulance=mysqli_query($GLOBALS["___mysqli_ston"], $ipambulance) or die("Error in $ipambulance".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numipambulance=mysqli_num_rows($exipambulance);

				   

				   while($resipambulance=mysqli_fetch_array($exipambulance))

				   {

					   $ipambulancecharge=$resipambulance['amount'];

				   

				  if($ipambulancecharge >0 )

			{

			 

			 $balanceamt = $balanceamt + $ipambulancecharge;

			?>

			

			<?php

			}

				 }

				 

				  $ipbed=" select sum(amount) as amount from billing_ipbedcharges where visitcode='$visitcode' group by docno";

				   $exipbed=mysqli_query($GLOBALS["___mysqli_ston"], $ipbed) or die("Error in $ipbed".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipbed=mysqli_fetch_array($exipbed))

				   {

					   $ipbedcharge=$resipbed['amount'];

				   

				  if($ipbedcharge >0 )

			{

		

			 $balanceamt = $balanceamt + $ipbedcharge;

			?>

			

			<?php

			}

				 }

				 

				  $iphomecare=" select sum(amount) as amount from billing_iphomecare where visitcode='$visitcode' group by docno";

				   $exiphomecare=mysqli_query($GLOBALS["___mysqli_ston"], $iphomecare) or die("Error in $iphomecare".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiphomecare=mysqli_fetch_array($exiphomecare))

				   {

					   $iphomecarecharge=$resiphomecare['amount'];

				   

				  if($ipresiphomecarecharge >0 )

			{

			

			

			 $balanceamt = $balanceamt + $iphomecarecharge;

			?>

			

			<?php

			}

				 }

				 

				   $iplab=" select sum(labitemrate) as labitemrate from billing_iplab where patientvisitcode='$visitcode' group by billnumber";

				   $exiplab=mysqli_query($GLOBALS["___mysqli_ston"], $iplab) or die("Error in $iplab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiplab=mysqli_fetch_array($exiplab))

				   {

					     $iplabcharge=$resiplab['labitemrate'];

				   

				  if($iplabcharge >0 )

			{

			

			 $balanceamt = $balanceamt + $iplabcharge;

			?>

			

			<?php

			}

				 }

				 

				  $ipmisc=" select sum(amount) as amount from billing_ipmiscbilling where visitcode='$visitcode' group by docno";

				   $exipmisc=mysqli_query($GLOBALS["___mysqli_ston"], $ipmisc) or die("Error in $ipmisc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipmisc=mysqli_fetch_array($exipmisc))

				   {

					   $ipmisccharge=$resipmisc['amount'];

				   

				  if($ipmisccharge >0 )

			{

			 

			

			 $balanceamt = $balanceamt + $ipmisccharge;

			?>

			 

			<?php

			}

				 }

				 

				   $ipnhif=" select sum(amount) as amount from billing_ipnhif where visitcode='$visitcode' group by docno";

				   $exipnhif=mysqli_query($GLOBALS["___mysqli_ston"], $ipnhif) or die("Error in $ipnhif".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipnhif=mysqli_fetch_array($exipnhif))

				   {

					   $ipnhifcharge=$resipnhif['amount'];

				   

				  if($ipnhifcharge >0 )

			{

			 

			

			 $balanceamt = $balanceamt + $ipnhifcharge;

			?>

			

			<?php

			}

				 }

				 

				  $ipot=" select sum(amount) as amount from billing_ipotbilling where visitcode='$visitcode' group by docno";

				   $exipot=mysqli_query($GLOBALS["___mysqli_ston"], $ipot) or die("Error in $ipot".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipot=mysqli_fetch_array($exipot))

				   {

					   $ipotcharge=$resipot['amount'];

				   

				  if($ipotcharge >0 )

			{

			 

			

			 $balanceamt = $balanceamt + $ipotcharge;

			?>

			

			<?php

			}

				 }

				 

				  $ippharm=" select sum(amount) as amount from billing_ippharmacy where patientvisitcode='$visitcode' group by billnumber";

				   $exippharm=mysqli_query($GLOBALS["___mysqli_ston"], $ippharm) or die("Error in $ippharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resippharm=mysqli_fetch_array($exippharm))

				   {

					   $ippharmcharge=$resippharm['amount'];

				   

				  if($ippharmcharge >0 )

			{

			 

			

			 $balanceamt = $balanceamt + $ippharmcharge;

			?>

			

			<?php

			}

				 }

				 

				 

				 $ipprivate="select sum(amount) as amount from billing_ipprivatedoctor where visitcode='$visitcode' group by docno";

				   $exipprivate=mysqli_query($GLOBALS["___mysqli_ston"], $ipprivate) or die("Error in $ipprivate".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipprivate=mysqli_fetch_array($exipprivate))

				   {

					   $ipprivatecharge=$resipprivate['amount'];

				   

				  if($ipprivatecharge >0 )

			{

			 

			 $balanceamt = $balanceamt + $ipprivatecharge;

			?>

			

			<?php

			}

				 }

				 

				  $iprad="select sum(radiologyitemrate) as radiologyitemrate from billing_ipradiology where patientvisitcode='$visitcode' group by billnumber";

				   $exiprad=mysqli_query($GLOBALS["___mysqli_ston"], $iprad) or die("Error in $iprad".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiprad=mysqli_fetch_array($exiprad))

				   {

					    $ipradcharge=$resiprad['radiologyitemrate'];

				   

				  if($ipradcharge >0 )

			{

			

			 $balanceamt = $balanceamt + $ipradcharge;

			?>

			

			<?php

			}

				 }

				 

				 

				  $ipservice="select sum(servicesitemrate) as servicesitemrate from billing_ipservices where patientvisitcode='$visitcode' group by billnumber";

				   $exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $ipservice) or die("Error in $ipservice".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipservice=mysqli_fetch_array($exipservice))

				   {

					   $ipservicecharge=$resipservice['servicesitemrate'];

				   

				  if($ipservicecharge >0 )

			{

			

			 $balanceamt = $balanceamt + $ipservicecharge;

			?>

			

			<?php

			}

				 }

				 

				 

				 }

				

				 $credit=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as refamount,billno,billdate,accountname from ip_creditnote where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($rescredit=mysqli_fetch_array($credit))

				{

				 $creditamount=$rescredit['refamount'];

				$billnumber =$resrefund['billno'];

				  $accountname =$resrefund['accountname'];

				   $consdate=$resrefund['billdate'];

				if($creditamount > 0)

			{

			

			$balanceamt -=$creditamount;

			?>

			

			<?php

			}

				}

			}

			}

		

				//----opening balance end--//

				

				

				

				?>

                <tr>

            <td colspan="2" align="right" class="bodytext31" ><strong></strong></td>

            <td colspan="1" align="right" class="bodytext31" ><strong>Opening Balance</strong></td>

            <td colspan="3" align="right" class="bodytext31" ><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

                <?php

				

				

				$openingcount=0;

				$openingbalance=$balanceamt;

				$colorloopcount = '';

				$sno=1;

				$balanceamt=0;

		 	      $querycustomer="select * from master_customer where customercode = '$searchcustomercode' and registrationdate between '$ADate1' and '$ADate2' group by customercode";

			$execust=mysqli_query($GLOBALS["___mysqli_ston"], $querycustomer) or die("error in querycustomer".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $numrows=mysqli_num_rows($execust);

			while($rescust=mysqli_fetch_array($execust))

			{

 			

			$registrationdate=$rescust['registrationdate'];

			  $customername=$rescust['customerfullname'];

			$customercode=$rescust['customercode'];

			$debit=0;

				$creditamount=0;

			?>

            

            <tr>

            <td colspan="6" align="left" class="bodytext31" ><strong><?= $customername.'('.$customercode.')';?></strong></td>

            </tr>

            <?php

			//----------------op-------------//

		 	   $visitentry="select visitcode,consultationdate as adate1,billtype from master_visitentry where patientcode='$customercode' and consultationdate between '$ADate1' and '$ADate2' group by visitcode union all select visitcode,consultationdate as adate1,billtype from master_ipvisitentry where patientcode='$customercode' and consultationdate between '$ADate1' and '$ADate2' group by visitcode order by adate1 desc";

			$exevisit=mysqli_query($GLOBALS["___mysqli_ston"], $visitentry) or die("Error in visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resvisit=mysqli_fetch_array($exevisit))

			{

				

				

				 $visitcode=$resvisit['visitcode'];

				 $consdate=$resvisit['adate1'];

				  $billtype=$resvisit['billtype'];

				if($billtype =="PAY NOW")

				{

					

					 $paylab="select sum(consultation) as consultation,billnumber,accountname,billdate from billing_consultation where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exlab=mysqli_query($GLOBALS["___mysqli_ston"], $paylab) or die("Error in $paylab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numlab=mysqli_num_rows($exlab);

				  if($numlab >0)

				  {

					 

				  while($reslab=mysqli_fetch_array($exlab))

				  {

				  $consultation=$reslab['consultation'];

				   $billnumber =$reslab['billnumber'];

				  $accountname =$reslab['accountname'];

				  $consdate=$reslab['billdate'];

				  }

				  $balanceamt += $consultation;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

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

                  <tr  <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit consultation(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($consultation,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  

				  

				 

				  

				  }

				  

					

				$paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,accountname,billdate from billing_paynow where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numrow=mysqli_num_rows($paynow);

				while($respaynow=mysqli_fetch_array($paynow))

				{

					

				 //$debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				  $consdate=$respaynow['billdate'];

				  

				  $paylab="select sum(labitemrate) as labitemrate from billing_paynowlab where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exlab=mysqli_query($GLOBALS["___mysqli_ston"], $paylab) or die("Error in $paylab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numlab=mysqli_num_rows($exlab);

				  if($numlab >0)

				  {

					 $openingcount++;

				  while($reslab=mysqli_fetch_array($exlab))

				  {

				  $labdebit=$reslab['labitemrate'];

				  

				  

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

				  

				  $balanceamt += $labdebit;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

				  

				  }

				  ?>

                  <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Lab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($labdebit,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  

				  }

				      $paypharmacy="select sum(amount) as amount from billing_paynowpharmacy where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $expharmacy=mysqli_query($GLOBALS["___mysqli_ston"], $paypharmacy) or die("Error in $paypharmacy".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numpharmacy=mysqli_num_rows($expharmacy);

				  

					 

					  

				  while($respharmacy=mysqli_fetch_array($expharmacy))

				  {

				     $pharmacydebit=$respharmacy['amount'];

				  if($pharmacydebit >0)

				  {

				   $openingcount++;

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

				  

				  $balanceamt += $pharmacydebit;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

				  

				   ?>

                  <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Pharmacy(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($pharmacydebit,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  }

				  }

				  

				   $payradiology="select sum(radiologyitemrate) as radiologyitemrate from billing_paynowradiology where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exradiology=mysqli_query($GLOBALS["___mysqli_ston"], $payradiology) or die("Error in $payradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numradiology=mysqli_num_rows($exradiology);

				  if($numradiology >0)

				  {

					 $openingcount++;

				  while($resradiology=mysqli_fetch_array($exradiology))

				  {

				   $radiologydebit=$resradiology['radiologyitemrate'];

				  

				  

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

				  	

				  $balanceamt += $radiologydebit;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

				  }?>

                  <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Radiology(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($radiologydebit,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  

				  }

				  

				   $payreferal="select sum(referalrate) as referalrate from billing_paynowreferal where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exreferal=mysqli_query($GLOBALS["___mysqli_ston"], $payreferal) or die("Error in $payreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numreferal=mysqli_num_rows($exreferal);

				  if($numreferal >0)

				  {

					  $openingcount++;

					  $refdebit=0;

				  while($resreferal=mysqli_fetch_array($exreferal))

				  {

					  

				  $referaldebit=$resreferal['referalrate'];

				   

				   

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

				  

				  $balanceamt += $referaldebit;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

				  }?>

                  <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Referal(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($referaldebit,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  

				  }

				  

				  $payservices="select sum(amount) as amount from billing_paynowservices where patientcode='$customercode' and patientvisitcode='$visitcode' group by billnumber";

				  $exservices=mysqli_query($GLOBALS["___mysqli_ston"], $payservices) or die("Error in $payservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numservices=mysqli_num_rows($exservices);

				  if($numservices >0)

				  {

					  $openingcount++;

					  

				  while($resservices=mysqli_fetch_array($exservices))

				  {

				  $servicesdebit=$resservices['amount'];

				  

				  

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

				  

				  $balanceamt += $servicesdebit;

				  if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

				  }?>

                  <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Services(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($servicesdebit,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

                <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

				

            </tr>

				  <?php

				  

				  }

				  

				

				}

				

				 

				 $refundpaynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(transactionamount) as refamount,billnumber,accountname,transactiondate from refund_paynow where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while($resrefund=mysqli_fetch_array($refundpaynow))

				 {

				  //$creditamount=$resrefund['refamount'];

				  $billnumber =$resrefund['billnumber'];

				  $accountname =$resrefund['accountname'];

				  $consdate=$resrefund['transactiondate'];

				  

				   $refundlab="select sum(labitemrate) as labitemrate from refund_paynowlab where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundlab=mysqli_query($GLOBALS["___mysqli_ston"], $refundlab) or die("Error in $refundlab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundlab=mysqli_num_rows($exrefundlab);

				  if($numrefundlab > 0)

				  {

					  $openingcount++;

				  while($resrefundlab=mysqli_fetch_array($exrefundlab))

				  {

					  

					$labcredit=$resrefundlab['labitemrate'];  

					

					

					$balanceamt -=$labcredit;

					if($labcredit > 0)

			{

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

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			

			

				  

				  ?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Lab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($labcredit,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				  }

				  }

				  

				     $refundpharm="select sum(amount) as amount from refund_paynowpharmacy where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundpharm=mysqli_query($GLOBALS["___mysqli_ston"], $refundpharm) or die("Error in $refundpharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundpharm=mysqli_num_rows($exrefundpharm);

				  if($numrefundpharm > 0)

				  {

					  $openingcount++;

				  while($resrefundpharm=mysqli_fetch_array($exrefundpharm))

				  {

					 

					 $pharmcredit=$resrefundpharm['amount'];  

					

					

					$balanceamt -=$pharmcredit;

					if($pharmcredit > 0)

			{

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

			

			

			}

				  }

				   if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

				  ?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Pharmacy(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($pharmcredit,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

				  }

				  

				   $refundradiology="select sum(radiologyitemrate) as radiologyitemrate from refund_paynowradiology where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundradiology=mysqli_query($GLOBALS["___mysqli_ston"], $refundradiology) or die("Error in $refundradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundradiology=mysqli_num_rows($exrefundradiology);

				  if($numrefundradiology > 0)

				  {

					  $openingcount++;

				  while($resrefundradiology=mysqli_fetch_array($exrefundradiology))

				  {

					 

					$radiologycredit=$resrefundradiology['radiologyitemrate'];  

					

					

					$balanceamt -=$radiologycredit;

					if($radiologycredit > 0)

			{

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

			

			

			}

				  }

				   if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

				  ?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Radiology(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($radiologycredit,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

				  }

				  

				  $refundreferal="select sum(referalrate) as referalrate from refund_paynowreferal where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundreferal=mysqli_query($GLOBALS["___mysqli_ston"], $refundreferal) or die("Error in $refundreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numexrefundreferal=mysqli_num_rows($exrefundreferal);

				  if($numexrefundreferal > 0)

				  {

					  $openingcount++;

				  while($resrefundreferal=mysqli_fetch_array($exrefundreferal))

				  {

					 

					$referalcredit=$resrefundreferal['referalrate'];  

					

					

					$balanceamt -=$referalcredit;

					if($referalcredit > 0)

			{

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

			

			

			}

				  }

				   if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

				  ?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Referral(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($referalcredit,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

				  }

				  

				   $refundservices="select sum(serviceamount) as serviceamount from refund_paynowservices where patientvisitcode='$visitcode' group by billnumber";

				  $exrefundservices=mysqli_query($GLOBALS["___mysqli_ston"], $refundservices) or die("Error in $refundservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefundservices=mysqli_num_rows($exrefundservices);

				  if($numrefundservices > 0)

				  {

					  $openingcount++;

				  while($resrefundservices=mysqli_fetch_array($exrefundservices))

				  {

					  

					$servicescredit=$resrefundservices['serviceamount'];  

					

					$balanceamt -=$servicescredit;

					if($servicescredit > 0)

			{

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

			

			

			}

				  }

				   if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

				  ?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Services(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($servicescredit,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

				  }

				  

				

			

				 }

				 

				 }

				

				if($billtype =="PAY LATER")

				{

					$laterlabbalance=0;

					//laterpharmbalance

					//laterraadiologybalance

					//$a="select sum(totalamount) as totamount,billno,accountname,billdate from billing_paylater where visitcode='$visitcode' group by visitcode";

				 $paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,accountname,billdate from billing_paylater where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numrow=mysqli_num_rows($paynow);

				   

				 while($respaynow=mysqli_fetch_array($paynow))

				 {

					 

					 

				  $debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				   $consdate=$respaynow['billdate'];

				   

				   //consultation//

				   

				    $latercon="select  sum(totalamount) as totalamount from billing_paylaterconsultation where visitcode='$visitcode' group by billno";

				   $exlatercon=mysqli_query($GLOBALS["___mysqli_ston"], $latercon) or die("Error in $latercon".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlatercon=mysqli_num_rows($exlatercon);

				   if($numlatercon > 0)

				   {

					   $openingcount++;

				while($reslatercon=mysqli_fetch_array($exlatercon))

				{

					 $paylatercon=$reslatercon['totalamount'];

					 

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

			$balanceamt +=$paylatercon;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  } 

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Lab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylatercon,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   

				    $laterlab="select  sum(labitemrate) as labitemrate from billing_paylaterlab where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterlab=mysqli_query($GLOBALS["___mysqli_ston"], $laterlab) or die("Error in $laterlab".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterlab=mysqli_num_rows($exlaterlab);

				   if($numlaterlab > 0)

				   { 

				   $openingcount++;

				while($reslaterlab=mysqli_fetch_array($exlaterlab))

				{

					 $paylaterlab=$reslaterlab['labitemrate'];

					 

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

			$balanceamt +=$paylaterlab;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Lab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylaterlab,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   

				   //pharmacy//

				   

				    $laterpharm="select sum(amount) amount from billing_paylaterpharmacy where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterpharm=mysqli_query($GLOBALS["___mysqli_ston"], $laterpharm) or die("Error in $laterpharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterpharm=mysqli_num_rows($exlaterpharm);

				   if($numlaterpharm > 0)

				   {

					   $openingcount++;

				while($reslaterpharm=mysqli_fetch_array($exlaterpharm))

				{

					 $paylaterpharm=$reslaterpharm['amount'];

					

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

			$balanceamt +=$paylaterpharm;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Pharmacy(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylaterpharm,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   

				   //radiology//

				    $laterradiology="select sum(radiologyitemrate) as radiologyitemrate from billing_paylaterradiology where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterradiology=mysqli_query($GLOBALS["___mysqli_ston"], $laterradiology) or die("Error in $laterradiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				    $numlaterradiology=mysqli_num_rows($exlaterradiology);

				   if($numlaterradiology > 0)

				   {

					   $openingcount++;

				while($reslaterradiology=mysqli_fetch_array($exlaterradiology))

				{

					$paylaterradiology=$reslaterradiology['radiologyitemrate'];

					

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

			$balanceamt +=$paylaterradiology;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Radiology(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylaterradiology,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   

				   //referral//

				    $laterreferal="select sum(referalamount) as referalamount from billing_paylaterreferal where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterreferal=mysqli_query($GLOBALS["___mysqli_ston"], $laterreferal) or die("Error in $laterreferal".mysqli_error($GLOBALS["___mysqli_ston"]));

				    $numlaterreferal=mysqli_num_rows($exlaterreferal);

				   if($numlaterreferal > 0)

				   { $openingcount++;

				while($reslaterreferal=mysqli_fetch_array($exlaterreferal))

				{

					$paylaterreferal=$reslaterreferal['referalamount'];

					

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

			$balanceamt +=$paylaterreferal;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Referral(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylaterreferal,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   //services//

				   

				     $laterservices="select sum(servicesitemrate) as servicesitemrate from billing_paylaterservices where patientvisitcode='$visitcode' group by billnumber";

				   $exlaterservices=mysqli_query($GLOBALS["___mysqli_ston"], $laterservices) or die("Error in $laterservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numlaterservices=mysqli_num_rows($exlaterservices);

				   if($numlaterservices > 0)

				   {

					  $openingcount++;

				while($reslaterservices=mysqli_fetch_array($exlaterservices))

				{

					 $paylaterservices=$reslaterservices['servicesitemrate'];

					

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

			$balanceamt +=$paylaterservices;

			if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit Services(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($paylaterservices,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				   }

				   

				 }

				 

				 

				 $refundpaynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(transactionamount) as refamount,billno,accountname,billdate from refund_paylater where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while($resrefund=mysqli_fetch_array($refundpaynow))

				 {

				 //$creditamount=$resrefund['refamount'];

				 $billnumber =$resrefund['billno'];

				  $accountname =$resrefund['accountname'];

				  $consdate=$resrefund['billdate'];

				  

				  $refund_lab="select sum(labitemrate) as labitemrate from refund_paylaterlab where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_lab=mysqli_query($GLOBALS["___mysqli_ston"], $refund_lab) or die("Error in refund_lab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_lab=mysqli_num_rows($exrefund_lab);

				  if($numrefund_lab > 0)

				  {

					  $openingcount++;

				  while($resrefund_lab=mysqli_fetch_array($exrefund_lab))

				  {

					 

					$refund_paylaterlab=$resrefund_lab['labitemrate'];

					

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

			$balanceamt -=$refund_paylaterlab;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Lab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($refund_paylaterlab,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				

			}

			

			$refund_pharmacy="select sum(amount) as amount from refund_paylaterpharmacy where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_pharm=mysqli_query($GLOBALS["___mysqli_ston"], $refund_pharmacy) or die("Error in refund_pharmacy".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_pharm=mysqli_num_rows($exrefund_pharm);

				  if($numrefund_pharm > 0)

				  {

					  $openingcount++;

				  while($resrefund_pharm=mysqli_fetch_array($exrefund_pharm))

				  {

					 $refund_paylaterpharm=$resrefund_pharm['amount'];

					

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

			$balanceamt -=$refund_paylaterpharm;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Pharmacy(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($refund_paylaterpharm,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				

			}

			

			

			$refund_radiology="select sum(radiologyitemrate) as radiologyitemrate from refund_paylaterradiology where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_radiology=mysqli_query($GLOBALS["___mysqli_ston"], $refund_radiology) or die("Error in refund_radiology".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_radiology=mysqli_num_rows($exrefund_radiology);

				  if($numrefund_radiology > 0)

				  {

					  $openingcount++;

				  while($resrefund_radiology=mysqli_fetch_array($exrefund_radiology))

				  {

					$refund_paylaterrad=$resrefund_radiology['radiologyitemrate'];

					

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

			$balanceamt -=$refund_paylaterrad;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Radiology(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($refund_paylaterrad,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				

			}

			

			$refund_referal="select sum(referalrate) as referalrate from refund_paylaterreferal where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_referal=mysqli_query($GLOBALS["___mysqli_ston"], $refund_referal) or die("Error in refund_referal".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_referal=mysqli_num_rows($exrefund_referal);

				  if($numrefund_referal > 0)

				  {

					  $openingcount++;

				  while($resrefund_referal=mysqli_fetch_array($exrefund_referal))

				  {

					$refund_paylaterref=$resrefund_referal['referalrate'];

					

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

			$balanceamt -=$refund_paylaterref;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Referral(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($refund_paylaterref,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				

			}

			

			$refund_service="select sum(amount) as amount from refund_paylaterservices where patientvisitcode='$visitcode' group by billnumber";

				  $exrefund_service=mysqli_query($GLOBALS["___mysqli_ston"], $refund_service) or die("Error in refund_service".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $numrefund_service=mysqli_num_rows($exrefund_service);

				  if($numrefund_service > 0)

				  {

					  $openingcount++;

				  while($resrefund_service=mysqli_fetch_array($exrefund_service))

				  {

					$refund_services=$resrefund_service['amount'];

					

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

			$balanceamt -=$refund_paylaterref;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit Services(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($refund_services,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				

			}

			

				  }

			

			

			

				}

			

			}

			

			

			//-----------IP---------------//

			   //$visitentry="select visitcode,consultationdate,billtype from master_ipvisitentry where patientcode='$customercode' and consultationdate between '$ADate1' and '$ADate2' group by visitcode order by auto_number desc";

			   

			$exevisit=mysqli_query($GLOBALS["___mysqli_ston"], $visitentry) or die("Error in visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resvisit=mysqli_fetch_array($exevisit))

			{

				

				  $visitcode=$resvisit['visitcode'];

				 $consdate=$resvisit['adate1'];

				  $billtype=$resvisit['billtype'];

				

				$paynow=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as totamount,billno,billdate,accountname from billing_ip where visitcode='$visitcode' group by visitcode")or die("Error in paynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $numrow=mysqli_num_rows($paynow);

				 

				 while($respaynow=mysqli_fetch_array($paynow))

				 {

				 // $debit =$respaynow['totamount'];

				  $billnumber =$respaynow['billno'];

				  $accountname =$respaynow['accountname'];

				   $consdate=$respaynow['billdate'];

				   

				   $ipadmission=" select sum(amount) as amount from billing_ipadmissioncharge where visitcode='$visitcode' group by docno";

				   $exadmission=mysqli_query($GLOBALS["___mysqli_ston"], $ipadmission) or die("Error in $ipadmission".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numipadmission=mysqli_num_rows($exadmission);

				   

				   while($resipadmission=mysqli_fetch_array($exadmission))

				   {

					   $ipadmissioncharge=$resipadmission['amount'];

				   

				  if($ipadmissioncharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipadmissioncharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipadmission(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipadmissioncharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				 $ipambulance=" select sum(amount) as amount from billing_ipambulance where visitcode='$visitcode' group by docno";

				   $exipambulance=mysqli_query($GLOBALS["___mysqli_ston"], $ipambulance) or die("Error in $ipambulance".mysqli_error($GLOBALS["___mysqli_ston"]));

				   $numipambulance=mysqli_num_rows($exipambulance);

				   

				   while($resipambulance=mysqli_fetch_array($exipambulance))

				   {

					   $ipambulancecharge=$resipambulance['amount'];

				   

				  if($ipambulancecharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipambulancecharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipambulance(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipambulancecharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $ipbed=" select sum(amount) as amount from billing_ipbedcharges where visitcode='$visitcode' group by docno";

				   $exipbed=mysqli_query($GLOBALS["___mysqli_ston"], $ipbed) or die("Error in $ipbed".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipbed=mysqli_fetch_array($exipbed))

				   {

					   $ipbedcharge=$resipbed['amount'];

				   

				  if($ipbedcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipbedcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipbedcharges(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipbedcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $iphomecare=" select sum(amount) as amount from billing_iphomecare where visitcode='$visitcode' group by docno";

				   $exiphomecare=mysqli_query($GLOBALS["___mysqli_ston"], $iphomecare) or die("Error in $iphomecare".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiphomecare=mysqli_fetch_array($exiphomecare))

				   {

					   $iphomecarecharge=$resiphomecare['amount'];

				   

				  if($ipresiphomecarecharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $iphomecarecharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit iphomecare(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($iphomecarecharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				   $iplab=" select sum(labitemrate) as labitemrate from billing_iplab where patientvisitcode='$visitcode' group by billnumber";

				   $exiplab=mysqli_query($GLOBALS["___mysqli_ston"], $iplab) or die("Error in $iplab".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiplab=mysqli_fetch_array($exiplab))

				   {

					     $iplabcharge=$resiplab['labitemrate'];

				   

				  if($iplabcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $iplabcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit iplab(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($iplabcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $ipmisc=" select sum(amount) as amount from billing_ipmiscbilling where visitcode='$visitcode' group by docno";

				   $exipmisc=mysqli_query($GLOBALS["___mysqli_ston"], $ipmisc) or die("Error in $ipmisc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipmisc=mysqli_fetch_array($exipmisc))

				   {

					   $ipmisccharge=$resipmisc['amount'];

				   

				  if($ipmisccharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipmisccharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipmisc(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipmisccharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				   $ipnhif=" select sum(amount) as amount from billing_ipnhif where visitcode='$visitcode' group by docno";

				   $exipnhif=mysqli_query($GLOBALS["___mysqli_ston"], $ipnhif) or die("Error in $ipnhif".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipnhif=mysqli_fetch_array($exipnhif))

				   {

					   $ipnhifcharge=$resipnhif['amount'];

				   

				  if($ipnhifcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipnhifcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipnhif(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipnhifcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $ipot=" select sum(amount) as amount from billing_ipotbilling where visitcode='$visitcode' group by docno";

				   $exipot=mysqli_query($GLOBALS["___mysqli_ston"], $ipot) or die("Error in $ipot".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipot=mysqli_fetch_array($exipot))

				   {

					   $ipotcharge=$resipot['amount'];

				   

				  if($ipotcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipotcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipot(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipotcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $ippharm=" select sum(amount) as amount from billing_ippharmacy where patientvisitcode='$visitcode' group by billnumber";

				   $exippharm=mysqli_query($GLOBALS["___mysqli_ston"], $ippharm) or die("Error in $ippharm".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resippharm=mysqli_fetch_array($exippharm))

				   {

					   $ippharmcharge=$resippharm['amount'];

				   

				  if($ippharmcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ippharmcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ippharmacy(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ippharmcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				 

				 $ipprivate="select sum(amount) as amount from billing_ipprivatedoctor where visitcode='$visitcode' group by docno";

				   $exipprivate=mysqli_query($GLOBALS["___mysqli_ston"], $ipprivate) or die("Error in $ipprivate".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipprivate=mysqli_fetch_array($exipprivate))

				   {

					   $ipprivatecharge=$resipprivate['amount'];

				   

				  if($ipprivatecharge >0 )

			{

				$openingcount++;



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

			

			 $balanceamt = $balanceamt + $ipprivatecharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipprivateDoctor(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipprivatecharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				  $iprad="select sum(radiologyitemrate) as radiologyitemrate from billing_ipradiology where patientvisitcode='$visitcode' group by billnumber";

				   $exiprad=mysqli_query($GLOBALS["___mysqli_ston"], $iprad) or die("Error in $iprad".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resiprad=mysqli_fetch_array($exiprad))

				   {

					    $ipradcharge=$resiprad['radiologyitemrate'];

				   

				  if($ipradcharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipradcharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipradiology(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipradcharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				 

				  $ipservice="select sum(servicesitemrate) as servicesitemrate from billing_ipservices where patientvisitcode='$visitcode' group by billnumber";

				   $exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $ipservice) or die("Error in $ipservice".mysqli_error($GLOBALS["___mysqli_ston"]));

				  

				   while($resipservice=mysqli_fetch_array($exipservice))

				   {

					   $ipservicecharge=$resipservice['servicesitemrate'];

				   

				  if($ipservicecharge >0 )

			{

				$openingcount++;

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

			

			 $balanceamt = $balanceamt + $ipservicecharge;

			 if($openingcount==1)

				  {

					  $balanceamt+=$openingbalance;

				  }

			?>

			 <tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Debit ipservices(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= number_format($ipservicecharge,2,'.',',');?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?="";?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				 }

				 

				 

				 }

				

				 $credit=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(totalamount) as refamount,billno,billdate,accountname from ip_creditnote where visitcode='$visitcode' group by visitcode")or die("Error in refundpaynow".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($rescredit=mysqli_fetch_array($credit))

				{

				 $creditamount=$rescredit['refamount'];

				$billnumber =$resrefund['billno'];

				  $accountname =$resrefund['accountname'];

				   $consdate=$resrefund['billdate'];

				if($creditamount > 0)

			{

				$openingcount++;

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

			$balanceamt -=$creditamount;

			 if($openingcount==1)

				  {

					  $balanceamt-=$openingbalance;

				  }

			?>

			<tr  >

              <td class="bodytext31" valign="center"  align="left" 

               ><?php echo $sno++; ?></td>

              <td width="8%" align="left" valign="center"  

                class="bodytext31"><?php echo $consdate;?></td>

                 <td width="21%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><?php echo "Towards Credit(".$billnumber.','.$visitcode.','.$accountname.")";?></div></td>

                

                

              <td width="22%" align="right" valign="center"  

                 class="bodytext31"><?= "";?></td>

              <td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($creditamount,2,'.',',');?></td>

				<td width="18%" align="right" valign="center"  

                class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

            </tr>

			<?php

			}

				}

			}

			}

			

			?>

			

		<tr>

        <td colspan="5" class="bodytext31" align="right" ><strong>Total:</strong></td><td   colspan="1" align="right" class="bodytext31"><?= number_format($balanceamt,2,'.',',');?></td>

        </tr>

        

</table>

