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



$errmsg = "";

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



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="cashbillsreportnew.xls"');

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

				 <td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>  Date </strong></td>

              <td width="19%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>

				  <td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>

                           <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit No </strong></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>

   				  <td width="12%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>

				<td width="12%" align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><div align="center"><strong>Received By</strong></div></td>

				<td width="12%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

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

			

		      

		

		  $query4 = "select * from master_billing where $pass_location and patientfullname like '%$searchsuppliername%' and username like '%$res3username%' and billingdatetime between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientfullname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['billingdatetime'];

			$amount = $res4['totalamount'];

			$billnumber = $res4['billnumber'];

			$receivedby = $res4['username'];

			$total6 = $total6 + $amount;



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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

             <td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $receivedby; ?></div></td>

			  

           </tr>

			<?php

			}

			?>

			<?php

		  $query4 = "select * from master_transactionpaynow where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

		//	$amount = $res4['transactionamount'];

			$billnumber = $res4['billnumber'];

			$receivedby1 = $res4['username'];

			//$total6 = $total6 + $amount;

$res2patientfullname=$patientname;

			$res2visitcode=	$visitcode;

			

		  	

			 $query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where patientname = '$patientname' and billnumber = '$billnumber'";

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

		  

		  $query24 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where patientname = '$res2patientfullname' and billnumber = '$billnumber'";

		  $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query4". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res24= mysqli_fetch_array($exec24);

		  $res4pharmacyitemrate = $res24['amount1'];

		  if($res4pharmacyitemrate == '')

		  {

		  $res4pharmacyitemrate = '0.00';

		  }

		  else

		  {

		  $res4pharmacyitemrate = $res24['amount1'];

		  }

		  

		  $query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where patientname = '$res2patientfullname' and billnumber = '$billnumber'";

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

		  
		// and wellnesspkg = '1'
		  $query6 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where patientname = '$res2patientfullname' and billnumber = '$billnumber' and wellnesspkg = '0'";

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

		  

		  $query7 = "select sum(cashamount) as referalrate1 from billing_paynowreferal where patientname = '$res2patientfullname' and billnumber = '$billnumber'";

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

		  $res7referalitemrate = $res7['referalrate1'];

		  if($res7referalitemrate == '')

		  {

		  $res7referalitemrate = '0.00';

		  }

		  else

		  {

		  $res7referalitemrate = $res7['referalrate1'];

		  }

		  

		  $amount = $res3labitemrate + $res4pharmacyitemrate + $res5radiologyitemrate + $res6servicesitemrate + $res7referalitemrate;

		  $total1 = $total1 + $res3labitemrate;

		  $total2 = $total2 + $res4pharmacyitemrate;

		  $total3 = $total3 + $res5radiologyitemrate;

		  $total4 = $total4 + $res6servicesitemrate;

		  $total5 = $total5 + $res7referalitemrate;

		  $total6 = $total6 + $amount;

		  

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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $receivedby1; ?></td>

			  

           </tr>

			<?php

			}

			?>

					<?php

		  $query4 = "select * from master_transactionexternal where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

			$amount = $res4['transactionamount'];

			$billnumber = $res4['billnumber'];

			$receivedby2 = $res4['username'];

			$total6 = $total6 + $amount;



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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="center"><?php echo $receivedby2; ?></td> 

			  

           </tr>

			<?php

			}

			?>

			<?php

		  $query4 = "select * from master_transactionadvancedeposit where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = '';

			$date = $res4['transactiondate'];

				$res40cashamount1 = $res4['cashamount'];

			$res40cardamount1 = $res4['cardamount'];

			$res40creditamount1 = $res4['creditamount'];

			$res40chequeamount1 = $res4['chequeamount'];

			$res40onlineamount1 = $res4['onlineamount']; 

			$res40transactionamount = $res4['transactionamount'];

			

			$amount = $res40cardamount1 + $res40cashamount1+$res40chequeamount1+$res40onlineamount1+$res40creditamount1;

			

			//$amount = $res4['transactionamount'];

			$billnumber = $res4['docno'];

			$recv = $res4['username'];

			$total6 = $total6 + $amount;



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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="center"><?php echo $recv; ?></td>  

			  

           </tr>

			<?php

			}

			?>

				<?php

		  $query4 = "select * from master_transactionipdeposit where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactionmodule <> 'Adjustment' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

				$res40cashamount1 = $res4['cashamount'];

			$res40cardamount1 = $res4['cardamount'];

			$res40creditamount1 = $res4['creditamount'];

			$res40chequeamount1 = $res4['chequeamount'];

			$res40onlineamount1 = $res4['onlineamount']; 

			$res40transactionamount = $res4['transactionamount'];

			

			$amount = $res40cardamount1 + $res40cashamount1+$res40chequeamount1+$res40onlineamount1+$res40creditamount1;

			//$amount = $res4['transactionamount'];

			$billnumber = $res4['docno'];

			$recv1 = $res4['username'];

			$total6 = $total6 + $amount;



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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="center"><?php echo $recv1; ?></td>   

			  

           </tr>

			<?php

			}

			?>

			

			<?php

		  $query4 = "select * from master_transactionip where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

				$res40cashamount1 = $res4['cashamount'];

			$res40cardamount1 = $res4['cardamount'];

			$res40creditamount1 = $res4['creditamount'];

			$res40chequeamount1 = $res4['chequeamount'];

			$res40onlineamount1 = $res4['onlineamount']; 

			$res40transactionamount = $res4['transactionamount'];

			

			$amount = $res40cardamount1 + $res40cashamount1+$res40chequeamount1+$res40onlineamount1+$res40creditamount1;

		//	$amount = $res4['transactionamount'];

			$billnumber = $res4['billnumber'];

			$recv2 = $res4['username'];

			

			

			if($amount != '0.00')

{

$total6 = $total6 + $amount;

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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="center"><?php echo $recv2; ?></td>  

			  

           </tr>

			<?php

			}

			}

			?>

					<?php

		  $query4 = "select * from master_transactionipcreditapproved where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

				$res40cashamount1 = $res4['cashamount'];

			$res40cardamount1 = $res4['cardamount'];

			$res40creditamount1 = $res4['creditamount'];

			$res40chequeamount1 = $res4['chequeamount'];

			$res40onlineamount1 = $res4['onlineamount']; 

			$res40transactionamount = $res4['transactionamount'];

			

			$amount = $res40cardamount1 + $res40cashamount1+$res40chequeamount1+$res40onlineamount1+$res40creditamount1;

			//$amount = $res4['transactionamount'];

			$billnumber = $res4['billnumber'];

			$recv3 = $res4['username'];

			

			if($amount != '0.00')

{

$total6 = $total6 + $amount;

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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="center"><?php echo $recv3; ?></td>   

			  

           </tr>

			<?php

			}

			}

			?>

		

			

								<?php

		  $query4 = "select * from refund_paynow where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and transactiondate between '$ADate1' and '$ADate2'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

{



			$patientname = $res4['patientname'];

			$patientcode = $res4['patientcode'];

			$visitcode = $res4['visitcode'];

			$date = $res4['transactiondate'];

			$amount = $res4['transactionamount'];

			$billnumber = $res4['billnumber'];

			$recv4 = $res4['username'];

			

			if($amount != '0.00')

{



$total6 = $total6 - $amount;

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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"> - <?php echo number_format($amount,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $recv4; ?></td>

			  

           </tr>

			<?php

			}

			}





$query54 = "select * from deposit_refund where $pass_location and patientname like '%$searchsuppliername%' and username like '%$res3username%' and recorddate between '$ADate1' and '$ADate2'"; 

		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res54 = mysqli_fetch_array($exec54))

{



			$patientname = $res54['patientname'];

			$patientcode = $res54['patientcode'];

			$visitcode = $res54['visitcode'];

			$date = $res54['recorddate'];

			$amount = $res54['amount'];

			$billnumber = $res54['docno'];

			$recv4 = $res54['username'];

			

			if($amount != '0.00')

{



$total6 = $total6 - $amount;

			

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

                <div class="bodytext31"><?php echo $date; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $visitcode; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

             <td  align="left" valign="center" class="bodytext31"><div align="right"> - <?php echo number_format($amount,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $recv4; ?></td>

			  

           </tr>

			<?php

			}

			

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

					<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>



              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

								<td  align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			 

			</tr>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>