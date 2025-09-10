<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');



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

$accountname = '';

$amount = 0;



$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];





if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }	

if (isset($_REQUEST["services"])) { $services = $_REQUEST["services"]; } else { $services = ""; }			

			

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	$visitcode1 = 10;



}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }

//$task = $_REQUEST['task'];

if ($task == 'deleted')

{

	$errmsg = 'Payment Entry Delete Completed.';

}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

	$transactiondateto = date('Y-m-d');

}



?>

<?php  include("print_header1.php"); ?>



<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666" cellspacing="0" cellpadding="4" width="1600" 

            align="left" border="1">

           		<tbody>





	

          	<tr>

              <td width="10"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="20" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Bill Date</strong> </td>

              <td width="20" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Reg Code</strong> </td>

              <td width="20" align="left" valign="center"  

                bgcolor="#ffffff"  >Visit Code</td>

              <td width="20" align="left" valign="left"  

                bgcolor="#ffffff"  > <strong>Patitent Name</strong> </td>

              <td width="20" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Item Code</strong> </td>

              <td width="50" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Item Name</strong> </td>

			   <td width="50" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Category</strong> </td>

              <td width="20" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Rate</strong> </td>

                <td width="20" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Bill Type</strong> </td>

              <td width="5" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong>Account Name</strong> </td> 

			 

            </tr>				

            

            

			<?php

			

			$num1=0;

			$num2=0;

			$num3=0;

			$num6=0;

			$grandtotal = 0;

			$res2itemname = '';

			

			$ADate1 = $transactiondatefrom;

			$ADate2 = $transactiondateto;

			

			

		    if ($cbfrmflag1 == 'cbfrmflag1')

			{

			 $j = 0;

	  	  

			$crresult = array();
			
			
			if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}

			if($type=='OP')

			{

			$querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1  AND $pass_location

						   UNION ALL SELECT servicesitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externalservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location 

						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1 AND $pass_location";

			}

			else if($type=='IP')

			{

			$querycr1in = "SELECT servicesitemrateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_ipservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1 AND $pass_location";

			}

			else

			{

			$querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1 AND $pass_location

						   UNION ALL SELECT servicesitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externalservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1 AND $pass_location

						   UNION ALL SELECT servicesitemrateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_ipservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND wellnessitem <> 1 AND $pass_location";

			}			   

			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($rescr1 = mysqli_fetch_array($execcr1))

			{

			$j = $j+1;

			$patientcode = $rescr1['pcode'];

			$patientname = $rescr1['pname'];

			$patientvisitcode = $rescr1['vcode'];

			$itemcode = $rescr1['lcode'];

			$itemname = $rescr1['lname'];

			$billdate = $rescr1['date'];

			$servicesrate = $rescr1['income'];

			$total = $total + $servicesrate;



			$querysercate1in = "SELECT categoryname FROM `master_services` where itemcode='$itemcode'";

			$execsercate = mysqli_query($GLOBALS["___mysqli_ston"], $querysercate1in) or die ("Error in querysercate1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			$ressercate = mysqli_fetch_array($execsercate);

			$itemcate = $ressercate['categoryname'];

			

			//$res4billtype = $rescr1['billtype'];

			$res4accountname = $rescr1['accountname'];

			if($res4accountname != 'CASH COLLECTIONS')

			{

				$res4billtype = 'PAY LATER';

			}

			else

			{

				$res4billtype = 'PAY NOW';

			}

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = '';

			}

			else

			{

				//echo "else";

				$colorcode = '';

			}

			?>

               <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                 <?php echo $billdate; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

                 <?php echo $patientcode; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

                 <?php echo $patientvisitcode; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientname; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			     <?php echo $itemcode; ?> </td>

                <td class="bodytext31"  valign="center"  align="left">

			     <?php echo $itemname; ?> </td>

				<td class="bodytext31"  valign="center"  align="left">

			     <?php echo $itemcate; ?> </td>

                <td class="bodytext31" valign="center"  align="left">

			     <?php echo number_format($servicesrate,2,'.',','); ?> </td>

                <td class="bodytext31" valign="center"  align="left">

			     <?php echo $res4billtype; ?> </td>

                <td class="bodytext31"   valign="center"  align="left">

			     <?php echo $res4accountname; ?> </td>

				

           </tr>

  	 

		   <?php

			}

			

			 $amount = $amount + $total;	

			

			

		  $num4 = $num1 + $num2 + $num3 + $num6;

		 

		  $grandtotal = $grandtotal + $amount;

		  

		  $total = number_format($total,'2','.','');

		  

			if(true)

			{

	

			?>

          <tr>

              <td class="bodytext31" valign="center"  align="left"></td>

               <td class="bodytext31" valign="center"  align="left">

                                </td>

              <td class="bodytext31" valign="center"  align="left">

                                </td>

              <td colspan="4" class="bodytext31" valign="center"  align="left">

                                </td>

              <td class="bodytext31" valign="center"  align="left">

			  <strong>Total</strong></td>

              <td class="bodytext31" valign="center"  align="left">

			     <strong><?php echo number_format($amount,2); ?></strong> </td>

                <td class="bodytext31" valign="center"  align="left">

                                </td>

                <td class="bodytext31" valign="center"  align="left">

                                </td>

				

  </tr>

		   <?php

		   }

		   ?>

		   <tr>

			<td bgcolor="#FFFFFF" colspan="11" class="bodytext31" valign="center"  align="left">

			     <strong><?php echo 'Refund'; ?></strong> </td>

  </tr>	

		   <?php

		   $amount=0;

		   $total=0;

		   $j=0;

		   

		    if($type=="OP")

			{

			$querydr1in = "SELECT (servicesitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT servicesfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE servicesfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			if($type=="IP")

			{

			$querydr1in = "SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Service' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			else

			{

			$querydr1in = "SELECT (servicesitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,servicesitemcode as lcode, servicesitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterservices`  WHERE servicesitemname LIKE '%$services%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT servicesfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE servicesfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Service' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			while($resdr1 = mysqli_fetch_array($execdr1))

			{

			$j = $j+1;

			$patientcode = $resdr1['pcode'];

			$patientname = $resdr1['pname'];

			$patientvisitcode = $resdr1['vcode'];

			$itemcode = $resdr1['lcode'];

			$itemname = $resdr1['lname'];

			$billdate = $resdr1['date'];

			$servicesrate = $resdr1['income'];

			$total = $total + $servicesrate;



			$querysercate1in = "SELECT categoryname FROM `master_services` where itemcode='$itemcode'";

			$execsercate = mysqli_query($GLOBALS["___mysqli_ston"], $querysercate1in) or die ("Error in querysercate1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			$ressercate = mysqli_fetch_array($execsercate);

			$itemcate = $ressercate['categoryname'];

			

			//$res4billtype = $resdr1['billtype'];

			$res4accountname = $resdr1['accountname'];

			if($res4accountname != 'CASH COLLECTIONS')

			{

				$res4billtype = 'PAY LATER';

			}

			else

			{

				$res4billtype = 'PAY NOW';

			}

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = '';

			}

			else

			{

				//echo "else";

				$colorcode = '';

			}

			  ?>

               <tr>

              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                 <?php echo $billdate; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

                 <?php echo $patientcode; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

                 <?php echo $patientvisitcode; ?>               </td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientname; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			     <?php echo $itemcode; ?> </td>

                <td class="bodytext31"  valign="center"  align="left">

			     <?php echo $itemname; ?> </td>

				 <td class="bodytext31"  valign="center"  align="left">

			     <?php echo $itemcate; ?> </td>

                <td class="bodytext31" valign="center"  align="left">

			     <?php echo number_format($servicesrate,2,'.',','); ?> </td>

                <td class="bodytext31" valign="center"  align="left">

			     <?php echo $res4billtype; ?> </td>

                <td class="bodytext31"  valign="center"  align="left">

			     <?php echo $res4accountname; ?> </td>

				 

           </tr>

		   <?php

			}	

			$amount = $amount + $total;

			

		  $num4 = $num1 + $num2 + $num3 + $num6;

		  //$num4 = number_format($num4, '2', '.' ,''); 

		  

		  $grandtotal = $grandtotal - $amount;

		  

		  $total = number_format($total,'2','.','');

		  

			if(true)

			{

			 $snocount = $snocount + 1;

			 $colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = '';

			}

			else

			{

				//echo "else";

				$colorcode = '';

			}

			?>

          <tr>

              <td class="bodytext31" valign="center"  align="left"></td>

               <td class="bodytext31" valign="center"  align="left">

                                </td>

              <td class="bodytext31" valign="center"  align="left">

                                </td>

              <td colspan="4" class="bodytext31" valign="center"  align="left">

                                </td>

              <td class="bodytext31" valign="center"  align="left">

			  <strong>Total</strong></td>

              <td class="bodytext31" valign="center"  align="left">

			     <strong><?php echo number_format($amount,2); ?></strong> </td>

                <td class="bodytext31" valign="center"  align="left">

                                </td>

                <td class="bodytext31" valign="center"  align="left">

                                </td>			 

  </tr>

			<?php

			}

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

               <td colspan="4" class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"><strong><strong>Grand Total:</strong></strong></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"><strong><?php echo number_format($grandtotal,2);?></strong></td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td> 

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

				

  </tr>

			  <?php

			  }

			  ?>	

          </tbody>

</table>



		

<?php



    $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_servicerevenuereport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

