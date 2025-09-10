<?php

session_start();

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d');

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');


	$banum = "1";
	
	$supplieranum = "";
	
	$custid = "";
	
	$custname = "";
	
	$balanceamount = "0.00";
	
	$openingbalance = "0.00";
	
	$total = '0.00';
	
	$searchsuppliername = "";
	
	$cbsuppliername = "";
	
	$snocount = "";
	
	$colorloopcount="";
	
	$range = "";
	
	$res1suppliername = '';
	
	$total1 = '0.00';
	
	$total2 = '0.00';
	
	$total3 = '0.00';
	
	$total4 = '0.00';
	
	$total5 = '0.00';
	
	$total6 = '0.00';
	
	$totalcon = 0;
	
	$totalconref = 0;
	
	$totaladv = 0;
	
	$totalipdep=0;
	
	$totaldepref=0;
	
	$totalipfinal =0;
	
	$totalipcredit=0;
	
	$totalotcs=0;
	
	$customername='';



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="cashrefundsreport.xls"');

header('Cache-Control: max-age=80');



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");



 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

	

$locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}
$customername=$searchsuppliername;
?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

       

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







<body>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="7" bgcolor="#ecf0f5" class="bodytext31">

             

				  </td>  

            </tr>

            <tr>
	
				  <td class="bodytext31" valign="center"  align="left" 
	
					bgcolor="#ffffff"><strong>No.</strong></td>
	
				  <td width="10%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
	
				  <td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><strong> Date </strong></td>
	
					 <td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><strong> Reg No </strong></td>
	
				  <td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><strong> Visit No </strong></td>
	
					<td width="5%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
	
					 <td width="8%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
	
				  <td width="4%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
	
					<td width="7%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
	
					<td width="7%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
	
				  <td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
	
					<td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
	
					<td width="7%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposits</strong></div></td>
	
					  <td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP Final</strong></div></td>
	
					<td width="7%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OTC Bill</strong></div></td>
	
					<td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
	
					<td width="6%" align="left" valign="center"  
	
					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Received By</strong></div></td>
	
					</tr>

				

			<?php

		

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			

			$cbcustomername=trim($cbcustomername);

		

			 //$res21employeename = $res21['employeename'];

			 $res21username = $cbcustomername;

			 

			$query31 = "select* from master_employee where employeename like '%$res21username%' and status <>'DELETED'";

			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exe31);

			if($res21username == '')

			{

			$res3username = "";

			}

			else 

			{

			$res3username = $res31["username"];

			}

			

		      

		

		  $query2 = "select * from refund_paynow where $pass_location and patientname like '%$searchsuppliername%' and transactiondate between '$ADate1' and '$ADate2' order by transactiondate desc";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res2 = mysqli_fetch_array($exec2))

		  {

     	  $res2patientname = $res2['patientname'];

		  $res2transactiondate = $res2['transactiondate'];

		  $res2visitcode = $res2['visitcode'];

		  $res2patientcode = $res2['patientcode'];

		  $res2billnumber = $res2['billnumber'];

		  $res2username = $res2['username'];

		  

		  $query3 = "select sum(labitemrate) as labitemrate1 from refund_paynowlab where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3= mysqli_fetch_array($exec3);

		  $res3labitemrate = $res3['labitemrate1'];

		  if($res3labitemrate == '')

		  {

		  $res3labitemrate = '0.00';

		  }

		  else

		  {

		  $res3labitemrate = $res3['labitemrate1'];

		  }

		  

		  $query4 = "select sum(amount) as amount1 from refund_paynowpharmacy where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res4= mysqli_fetch_array($exec4);

		  $res4pharmacyitemrate = $res4['amount1'];

		  if($res4pharmacyitemrate == '')

		  {

		  $res4pharmacyitemrate = '0.00';

		  }

		  else

		  {

		  $res4pharmacyitemrate = $res4['amount1'];

		  }

		  

		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from refund_paynowradiology where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5= mysqli_fetch_array($exec5);

		  $res5radiologyitemrate = $res5['radiologyitemrate1'];

		  if($res5radiologyitemrate == '')

		  {

		  $res5radiologyitemrate = '0.00';

		  }

		  else

		  {

		  $res5radiologyitemrate = $res5['radiologyitemrate1'];

		  }

		  

		  $query6 = "select sum(servicesitemrate) as servicesitemrate1 from refund_paynowservices where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res6 = mysqli_fetch_array($exec6);

		  $res6servicesitemrate = $res6['servicesitemrate1'];

		  if($res6servicesitemrate == '')

		  {

		  $res6servicesitemrate = '0.00';

		  }

		  else

		  {

		  $res6servicesitemrate = $res6['servicesitemrate1'];

		  }

		  

		  $query7 = "select sum(consultation) as consultation1 from refund_consultation where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

		  $res7consultationrate = $res7['consultation1'];

		  if($res7consultationrate == '')

		  {

		  $res7consultationrate = '0.00';

		  }

		  else

		  {

		  $res7consultationrate = $res7['consultation1'];

		  }

		  

		  $query8 = "select sum(referalrate) as referalrate from refund_paynowreferal where $pass_location and patientname = '$res2patientname' and patientvisitcode = '$res2visitcode'";

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res8 = mysqli_fetch_array($exec8);

		  $res6referalitemrate = $res8['referalrate'];

		  if($res6referalitemrate == '')

		  {

		  $res6referalitemrate = '0.00';

		  }

		  else

		  {

		  $res6referalitemrate = $res8['referalrate'];

		  }

		  

		  

		  $total = $res3labitemrate + $res4pharmacyitemrate + $res5radiologyitemrate + $res6servicesitemrate + $res7consultationrate + $res6referalitemrate;

		  $total1 = $total1 + $res3labitemrate;

		  $total2 = $total2 + $res4pharmacyitemrate;

		  $total3 = $total3 + $res5radiologyitemrate;

		  $total4 = $total4 + $res6servicesitemrate;

		  $total7 = $total7 + $res7consultationrate;

		  $total8 = $total8 + $res6referalitemrate;

		  $total6 = $total6 + $total;

		  

		  $snocount = $snocount + 1;

			

			//echo $cashamount;

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2transactiondate; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($res7consultationrate,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($res4pharmacyitemrate,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res6referalitemrate,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center">

			  <?php echo $res2username; ?></td>

           </tr>

			<?php

			}

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total7,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total4,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total8,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>

								<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            </tr>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>