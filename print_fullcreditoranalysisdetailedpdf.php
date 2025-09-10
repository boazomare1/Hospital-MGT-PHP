<?php

ob_start();

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");

require_once('html2pdf/html2pdf.class.php');


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');


$totalamount120=0;
$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";
$totalamount180 =0;
$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$totalamount = "0.00";

$totalamount30 = "0.00";

$total60 = "0.00";

$total90 = "0.00";

$total120 = "0.00";

$total180 = "0.00";

$total210 = "0.00";

$totalamount1 = "0.00";

$totalamount60 = 0;

$totalamount301 = "0.00";

$totalamount601 = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$totalamount2401 = "0.00";

//This include updatation takes too long to load for hunge items database.

//include("autocompletebuild_subtype.php");

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



if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

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

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



?>

<style type="text/css">

<!--

body {

	

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

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

<?php  include("print_header_pdf4.php"); ?>

 
<h4 align="center">Full Creditor Analysis Detailed</h4>  

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 

            align="center" border="1">
          <tbody>

         
         <!-- <tr><td colspan="13">&nbsp;</td></tr> -->

            <tr>

              <td width="20" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="160" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Supplier Name</strong></td>

				<td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>GRN No</strong></td>

                  <td width="60" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> Invoice No </strong></td>

             <td width="60" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Invoice Date </strong></td>

              

              <td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Invoice Amt </strong></td>

				<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bal. Amt</strong></td>

				<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>30 days</strong></td>

              <td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>60 days </strong></td>

				<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>90 days </strong></td>

			<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>120 days </strong></td>

				<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>180 days </strong></td>

				<td width="70" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>180+ days </strong></td>

			  </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

			$arraysupplier = $searchsuppliername;

			$arraysuppliername = $arraysupplier;

			$searchsuppliername = trim($arraysuppliername);

			$arraysuppliercode = $searchsuppliercode;

			$searchsuppliername = trim($searchsuppliername);

			

			if($searchsuppliercode == '') {

			// $query212 = "select suppliercode,suppliername from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";
				$query212 = "select * from master_accountname where accountssub='16' group by id";

			} else {

			// $query212 = "select suppliercode,suppliername from master_transactionpharmacy where suppliercode = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";
				$query212 = "select * from master_accountname where id = '$searchsuppliercode' and accountssub='16' group by id";

			}

			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res212 = mysqli_fetch_array($exec212))

			{

			// $res21suppliername = $res212['suppliername'];

			// $res21suppliercode = $res212['suppliercode'];

				$res21suppliername = $res212['accountname'];
				$res21suppliercode = $res212['id'];

			

			$query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222);

			$res22accountname = $res222['accountname'];



			if( $res21suppliername != '')

			{

			?>

			<!-- <tr >

            <td colspan="13"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr>  -->

			

			<?php

			

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$res21suppliername = trim($res21suppliername);

		  

		  //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

		   $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2'  and companyanum = '$companyanum' group by billnumber order by billdate asc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num1 = mysqli_num_rows($exec1);

		   if($num1>0){
		   ?>
		   <tr >

            <td colspan="13"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr> 
        <?php }

		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['billdate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount1 = $res1['totalamount'];

		  $supplierbillnumber = $res1['supplierbillnumber'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/


		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res2transactionamount=$res2transactionamount1-$wh_tax_value;

		  

		  $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  //$res2transactionamount = $res2['transactionamount1'];

		  

		  $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		   $res3transactionamount = $res3['transactionamount1'];

		  

		  $res4return = 0;

		  $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$ADate1' and '$ADate2'

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

		  {

		  	$res4return += $res4['totalreturn'];

		  }

		  

		  /*$query4 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'paylatercredit'";

		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

		  $res4 = mysql_fetch_array($exec4);

		  $res4transactionamount = $res4['transactionamount'];

		  

		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit'";

		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

		  $res5 = mysql_fetch_array($exec5);

		  $res5transactionamount = $res5['transactionamount'];*/

		  

		  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return);

		  if($invoicevalue>0)

		  {

		  $date1 = 30;

		  $date2 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date1)); 

		  

		  $query8 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2' ";

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res8 = mysqli_fetch_array($exec8);

		  $res8transactionamount1 = $res8['transactionamount1'];

		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date2' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res8transactionamount=$res8transactionamount1-$wh_tax_value;

	      

		  $query9 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT'  and transactiondate between '$date2' and '$ADate2' and recordstatus = 'allocated'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res9 = mysqli_fetch_array($exec9);

		  $res9transactionamount = $res9['transactionamount1'];

		  

		  $query10 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2')";

		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res10 = mysqli_fetch_array($exec10);

		  $res10return = $res10['totalreturn'];

		  

		  /*$query10 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit'  and transactiondate between '$date2' and '$ADate2'";

		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  $res10 = mysql_fetch_array($exec10);

		  $res10transactionamount = $res10['transactionamount'];

	

		  $query12 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'pharmacycredit'  and transactiondate between '$date2' and '$ADate2'";

		  $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());

		  $res12 = mysql_fetch_array($exec12);

		  $res12transactionamount = $res12['transactionamount'];*/

		  

		  $totalamount30 = $res8transactionamount - ($res9transactionamount + $res10return);

		  

		  $t1 = strtotime($res1transactiondate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  

		  if($days_between>30 && $days_between<=60)

		  {

		  $date3 = 60;

		  $date4 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date3)); 

		  

		  $query13 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2' ";

		  $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res13 = mysqli_fetch_array($exec13);

		  $res13transactionamount1 = $res13['transactionamount1'];


		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date4' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res13transactionamount=$res13transactionamount1-$wh_tax_value;



	      

		  $query14 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT' and transactiondate between '$date4' and '$ADate2' and recordstatus = 'allocated'";

		  $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res14 = mysqli_fetch_array($exec14);

		  $res14transactionamount = $res14['transactionamount1'];

		  

		  $query15 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2')";

		  $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res15 = mysqli_fetch_array($exec15);

		  $res15return = $res15['totalreturn'];

		  

		  /*$query15 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date4' and '$ADate2'";

		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());

		  $res15 = mysql_fetch_array($exec15);

		  $res15transactionamount = $res15['transactionamount'];

	

		  $query16 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'pharmacycredit' and transactiondate between '$date4' and '$ADate2'";

		  $exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());

		  $res16 = mysql_fetch_array($exec16);

		  $res16transactionamount = $res16['transactionamount'];*/

		  

		  $totalamount60 = $res13transactionamount - ($res14transactionamount + $res15return);

		  

		  $total60 = $totalamount60 - $totalamount30;

		  }

		  

		  if($days_between>60 && $days_between<=90)

		  {

		  $date5 = 90;

		  $date6 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date5));

		  

		  $query17 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2' ";

		  $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res17 = mysqli_fetch_array($exec17);

		  $res17transactionamount1 = $res17['transactionamount1'];


		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date6' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res17transactionamount=$res17transactionamount1-$wh_tax_value;


	      

		  $query18 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date6' and '$ADate2' and recordstatus = 'allocated'";

		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res18 = mysqli_fetch_array($exec18);

		  $res18transactionamount = $res18['transactionamount1'];

		  

		  $query19 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2')";

		  $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res19 = mysqli_fetch_array($exec19);

		  $res19return = $res19['totalreturn'];

		  

		  /*$query19 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date6' and '$ADate2'";

		  $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

		  $res19 = mysql_fetch_array($exec19);

		  $res19transactionamount = $res19['transactionamount'];

	

		  $query20 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date6' and '$ADate2'";

		  $exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());

		  $res20 = mysql_fetch_array($exec20);

		  $res20transactionamount = $res20['transactionamount'];*/

		  

		  $totalamount90 = $res17transactionamount - ($res18transactionamount + $res19return) /* + $res19transactionamount + $res20transactionamount*/;

		  

		  $total90 = $totalamount90 - $totalamount60;

		  }

		  

		  if($days_between>90 && $days_between<=120)

		  {

		  $date7 = 120;

		  $date8 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date7));

		  

		  $query21 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2' ";

		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res21 = mysqli_fetch_array($exec21);

		  $res21transactionamount1 = $res21['transactionamount1'];

		  ////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date8' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res21transactionamount=$res21transactionamount1-$wh_tax_value;

	      

		  $query22 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date8' and '$ADate2' and recordstatus = 'allocated'";

		  $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res22 = mysqli_fetch_array($exec22);

		  $res22transactionamount = $res22['transactionamount1'];

		  

		  $query23 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2')";

		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res23 = mysqli_fetch_array($exec23);

		  $res23return = $res23['totalreturn'];

		  

		  /*$query23 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date8' and '$ADate2'";

		  $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());

		  $res23 = mysql_fetch_array($exec23);

		  $res23transactionamount = $res23['transactionamount'];

	

		  $query24 = "select * from  master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date8' and '$ADate2'";

		  $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());

		  $res24 = mysql_fetch_array($exec24);

		  $res24transactionamount = $res24['transactionamount'];*/

		  

		  $totalamount120 = $res21transactionamount - ($res22transactionamount + $res23return)/* + $res23transactionamount + $res24transactionamount*/;

		  

		  $total120 = $totalamount120 - $totalamount90;

		  }

		  

		  if($days_between>120 && $days_between<=180)

		  {

		  $date9 = 180;

		  $date10 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));

		  

		  $query25 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2' ";

		  $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res25 = mysqli_fetch_array($exec25);

		  $res25transactionamount1 = $res25['transactionamount1'];


		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date10' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res25transactionamount=$res25transactionamount1-$wh_tax_value;

	      

		  $query26 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date10' and '$ADate2' and recordstatus = 'allocated'";

		  $exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res26 = mysqli_fetch_array($exec26);

		  $res26transactionamount = $res26['transactionamount1'];

		  

		  $query27 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2')";

		  $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res27 = mysqli_fetch_array($exec27);

		  $res27return = $res27['totalreturn'];

		  

		  /*$query27 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date10' and '$ADate2'";

		  $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());

		  $res27 = mysql_fetch_array($exec27);

		  $res27transactionamount = $res27['transactionamount'];

	

		  $query28 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date10' and '$ADate2'";

		  $exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());

		  $res28 = mysql_fetch_array($exec28);

		  $res28transactionamount = $res28['transactionamount'];*/

		  

		  $totalamount180 = $res25transactionamount - ($res26transactionamount + $res27return)/* + $res27transactionamount + $res28transactionamount*/;

		  

		  $total180 = $totalamount180 - $totalamount120;

		  }

		  

		  if($days_between>180)

		  {

		  // $date1 = 30;

		  // $date2 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date1)); 

		  

		  // $query8 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2' ";

		  // $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		  // $res8 = mysql_fetch_array($exec8);

		  // $res8transactionamount1 = $res8['transactionamount1'];


		  // /////////////// for wht //////////////
		  // $wh_tax_value=0;
		  //  $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date2' and '$ADate2' group by billnumber";
		  // $exec222 = mysql_query($query222) or die ("Error in Query222".mysql_error());
		  // $res222 = mysql_fetch_array($exec222);
		  // $wh_tax_value = $res222['wh_tax_value'];
		  // //////////////// for wht //////////////
		  // $res8transactionamount=$res8transactionamount1-$wh_tax_value;

	      

		  // $query9 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT'  and transactiondate between '$date2' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

		  // $res9 = mysql_fetch_array($exec9);

		  // $res9transactionamount = $res9['transactionamount1'];

		  

		  // $res10return = 0;

		  // $query10 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date2' and '$ADate2' 

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2')";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // while($res10 = mysql_fetch_array($exec10))

		  // {

		  // $res10return += $res10['totalreturn'];

		  // }

		  

		  // /*$query10 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit'  and transactiondate between '$date2' and '$ADate2'";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // $res10 = mysql_fetch_array($exec10);

		  // $res10transactionamount = $res10['transactionamount'];

	

		  // $query12 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'pharmacycredit'  and transactiondate between '$date2' and '$ADate2'";

		  // $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());

		  // $res12 = mysql_fetch_array($exec12);

		  // $res12transactionamount = $res12['transactionamount'];*/

		  

		  // $totalamount30 = $res8transactionamount - ($res9transactionamount + $res10return);

		  

		  // $t1 = strtotime($res1transactiondate);

    // 	  $t2 = strtotime($ADate2);

		  // $days_between = ceil(abs($t2 - $t1) / 86400);

		  

		  // if($days_between>30 && $days_between<=60)

		  // {

		  // $date3 = 60;

		  // $date4 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date3)); 

		  

		  // $query13 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2' ";

		  // $exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		  // $res13 = mysql_fetch_array($exec13);

		  // $res13transactionamount1 = $res13['transactionamount1'];

		  // /////////////// for wht //////////////
		  // $wh_tax_value=0;
		  //  $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date4' and '$ADate2' group by billnumber";
		  // $exec222 = mysql_query($query222) or die ("Error in Query222".mysql_error());
		  // $res222 = mysql_fetch_array($exec222);
		  // $wh_tax_value = $res222['wh_tax_value'];
		  // //////////////// for wht //////////////
		  // $res13transactionamount=$res13transactionamount1-$wh_tax_value;

	      

		  // $query14 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT' and transactiondate between '$date4' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());

		  // $res14 = mysql_fetch_array($exec14);

		  // $res14transactionamount = $res14['transactionamount1'];

		  

		  // $res15return = 0;

		  // $query15 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date4' and '$ADate2' ";

		  // $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());

		  // while($res15 = mysql_fetch_array($exec15))

		  // {

		  // $res15return += $res15['totalreturn'];

		  // }

		  

		  // $totalamount60 = $res13transactionamount - ($res14transactionamount + $res15return);

		  

		  // $total60 = $totalamount60 - $totalamount30;

		  // }

		  

		  // if($days_between>60 && $days_between<=90)

		  // {

		  // $date5 = 90;

		  // $date6 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date5));

		  

		  // $query17 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2' ";

		  // $exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());

		  // $res17 = mysql_fetch_array($exec17);

		  // $res17transactionamount1 = $res17['transactionamount1'];

		  // /////////////// for wht //////////////
		  // $wh_tax_value=0;
		  //  $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res1billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$date6' and '$ADate2' group by billnumber";
		  // $exec222 = mysql_query($query222) or die ("Error in Query222".mysql_error());
		  // $res222 = mysql_fetch_array($exec222);
		  // $wh_tax_value = $res222['wh_tax_value'];
		  // //////////////// for wht //////////////
		  // $res17transactionamount=$res17transactionamount1-$wh_tax_value;

	      

		  // $query18 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date6' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());

		  // $res18 = mysql_fetch_array($exec18);

		  // $res18transactionamount = $res18['transactionamount1'];

		  

		  // $res19return = 0;

		  // $query19 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date6' and '$ADate2'";

		  // $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

		  // while($res19 = mysql_fetch_array($exec19))

		  // {

		  // $res19return += $res19['totalreturn'];

		  // }

		  

		  // /*$query19 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date6' and '$ADate2'";

		  // $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

		  // $res19 = mysql_fetch_array($exec19);

		  // $res19transactionamount = $res19['transactionamount'];

	

		  // $query20 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date6' and '$ADate2'";

		  // $exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());

		  // $res20 = mysql_fetch_array($exec20);

		  // $res20transactionamount = $res20['transactionamount'];*/

		  

		  // $totalamount90 = $res17transactionamount - ($res18transactionamount + $res19return) /* + $res19transactionamount + $res20transactionamount*/;

		  

		  // $total90 = $totalamount90 - $totalamount60;

		  // }

		  

		  // if($days_between>90 && $days_between<=120)

		  // {

		  // $date7 = 120;

		  // $date8 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date7));

		  

		  // $query21 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2' ";

		  // $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());

		  // $res21 = mysql_fetch_array($exec21);

		  // $res21transactionamount = $res21['transactionamount1'];

	      

		  // $query22 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date8' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());

		  // $res22 = mysql_fetch_array($exec22);

		  // $res22transactionamount = $res22['transactionamount1'];

		  

		  // $res23return = 0;

		  // $query23 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date8' and '$ADate2'";

		  // $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());

		  // while($res23 = mysql_fetch_array($exec23))

		  // {

		  // $res23return += $res23['totalreturn'];

		  // }

		  // /*$query23 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date8' and '$ADate2'";

		  // $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());

		  // $res23 = mysql_fetch_array($exec23);

		  // $res23transactionamount = $res23['transactionamount'];

	

		  // $query24 = "select * from  master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date8' and '$ADate2'";

		  // $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());

		  // $res24 = mysql_fetch_array($exec24);

		  // $res24transactionamount = $res24['transactionamount'];*/

		  

		  // $totalamount120 = $res21transactionamount - ($res22transactionamount + $res23return)/* + $res23transactionamount + $res24transactionamount*/;

		  

		  // $total120 = $totalamount120 - $totalamount90;

		  // }

		  

		  // if($days_between>120 && $days_between<=180)

		  // {

		  // $date9 = 180;

		  // $date10 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));

		  

		  // $query25 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2' ";

		  // $exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());

		  // $res25 = mysql_fetch_array($exec25);

		  // $res25transactionamount = $res25['transactionamount1'];

	      

		  // $query26 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date10' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());

		  // $res26 = mysql_fetch_array($exec26);

		  // $res26transactionamount = $res26['transactionamount1'];

		  

		  // $res27return = 0;

		  // $query27 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date10' and '$ADate2'

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2')";

		  // $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());

		  // while($res27 = mysql_fetch_array($exec27))

		  // {

		  // $res27return += $res27['totalreturn'];

		  // }

		  

		  // /*$query27 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date10' and '$ADate2'";

		  // $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());

		  // $res27 = mysql_fetch_array($exec27);

		  // $res27transactionamount = $res27['transactionamount'];

	

		  // $query28 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date10' and '$ADate2'";

		  // $exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());

		  // $res28 = mysql_fetch_array($exec28);

		  // $res28transactionamount = $res28['transactionamount'];*/

		  

		  // $totalamount180 = $res25transactionamount - ($res26transactionamount + $res27return)/* + $res27transactionamount + $res28transactionamount*/;

		  

		  // $total180 = $totalamount180 - $totalamount120;

		  // }

		  

		  if($days_between>180)

		  {

		  $date11 = 2100;

		  $date12 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date11));

		  

		  $query29 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date12' and '$ADate2' ";

		  $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res29 = mysqli_fetch_array($exec29);

		  $res29transactionamount = $res29['transactionamount1'];

	      

		  $query30 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date12' and '$ADate2' and recordstatus = 'allocated'";

		  $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res30 = mysqli_fetch_array($exec30);

		  $res30transactionamount = $res30['transactionamount1'];

		  

		  $res31return = 0;

		  $query31 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date12' and '$ADate2'

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date12' and '$ADate2')";

		  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res31 = mysqli_fetch_array($exec31))

		  {

		  $res31return += $res31['totalreturn'];

		  }

		  

		  /*$query31 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date12' and '$ADate2'";

		  $exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());

		  $res31 = mysql_fetch_array($exec31);

		  $res31transactionamount = $res31['transactionamount2'];

	

		  $query32 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date12' and '$ADate2'";

		  $exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());

		  $res32 = mysql_fetch_array($exec32);

		  $res32transactionamount = $res32['transactionamount2'];*/

		  

		  $totalamount210 = $res29transactionamount - ($res30transactionamount + $res31return)/* + $res31transactionamount + $res32transactionamount*/;

		  

		  $total210 = $totalamount210 - $totalamount180;

		  }

		  }

		  }

		  else

		  {

				$totalamount30=0;

				$total60=0;

				$$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamount210=0;  

		  }

		  if($res2transactionamount !=''){

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

           <tr >

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php echo $res1billnumber; ?></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <?php echo $res21suppliername; ?></td>-->

                <td class="bodytext31" valign="center"  align="left"> <?php echo $supplierbillnumber; ?></td>

              <td class="bodytext31" valign="center"  align="left"> <?php echo $res1transactiondate; ?></td>

              
              <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($res2transactionamount,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($invoicevalue,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total210,2,'.',','); ?></td>

           </tr>

			<?php

			}

				$totalamount1 = $totalamount1 + $res2transactionamount;

				$totalamount301 = $totalamount301 + $invoicevalue;

				$totalamount601 = $totalamount601 + $totalamount30;

				$totalamount901 = $totalamount901 + $total60;

				$totalamount1201 = $totalamount1201 + $total90;

				$totalamount1801 = $totalamount1801 + $total120;

				$totalamount2101 = $totalamount2101 + $total180;

				$totalamount2401 = $totalamount2401 + $total210;

				

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$total60=0;

				$$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamount210=0;   

			}

			

		 	$query2="select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2'  group by docno";

			$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

			while($res2=mysqli_fetch_array($exe2))

			{

		 	$creditamount=$res2['creditamount'];

			$ledgername=$res2['ledgername'];

			$entrydate=$res2['entrydate'];

			$docno=$res2['docno'];

			

			$t1 = strtotime($entrydate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		    if($days_between<30)

			{

			$totalamount30=$totalamount30+$creditamount;

			}

			

			if($days_between>30 && $days_between<=60)

			{

			$total60=$total60+$creditamount;

			}

			if($days_between>60 && $days_between<=90)

			{

			$total90=$total90+$creditamount;

			}

			if($days_between>90 && $days_between<=120)

			{

			$total120=$total120+$creditamount;

			}

			if($days_between>120 && $days_between<=180)

			{

			$total180=$total180+$creditamount;

			}

			if($days_between>180)

			{

			$total210=$total210+$creditamount;

			}

		  

			

			  if($creditamount !=''){

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1+$creditamount;

			$totalamount301=$totalamount301+$creditamount;

			$totalamount601=$totalamount601+$totalamount30;

			$totalamount901=$totalamount901+$total60;

			$totalamount1201=$totalamount1201+$total90;

			$totalamount1801=$totalamount1801+$total120;

			$totalamount2101=$totalamount2101+$total180;

			$totalamount2401=$totalamount2401+$total210;

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

           <tr >

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php echo $docno; ?></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <?php echo $ledgername; ?></td>-->

              

              <td class="bodytext31" valign="center"  align="left"> <?php //echo $res1transactiondate; ?></td>
              
              <td class="bodytext31" valign="center"  align="left"> <?php echo $entrydate; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($creditamount,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($creditamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total210,2,'.',','); ?></td>

           </tr>

			<?php



$totalamount30=0;

				$total60=0;

			

				$total90=0;

			

				$total120=0;

			

				$total180=0;

			

				$total210=0;

			

}

			

			}

			////////////////////// for sdbt bills ///////////////////////
$total_debit=0;
				// $arraysuppliercode = $_POST['searchsuppliercode'];
				$query5 = "SELECT * from supplier_debit_transactions where supplier_id = '$res21suppliercode'  and date(created_at) between '$ADate1' and '$ADate2' order by created_at ASC";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  // $num5 = mysql_num_rows($exec5);
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		   $res5docnumber = $res5['approve_id'];
		  $created_at = $res5['created_at'];
		  $ref_no = $res5['ref_no'];
		   $res5transactionamount = $res5['total_amount'];

		 	 $timestamp = strtotime($created_at);
			 $entrydate = date('Y-m-d', $timestamp); // d.m.YYYY
		 
			$transactionamount='0';
			 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$res5docnumber' and recordstatus = 'allocated'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $num=mysql_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))
				{  $transactionamount += $res3['transactionamount'];
				}
				 $pending12 = $res5transactionamount-$transactionamount;

				 	$t1 = strtotime($entrydate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);
		    if($days_between<=30)
			{
			$totalamount30=$totalamount30-$pending12;
			}


			if($days_between>30 && $days_between<=60)
			{
			$total60=$total60-$pending12;
			}
			if($days_between>60 && $days_between<=90)
			{
			$total90=$total90-$pending12;
			}
			if($days_between>90 && $days_between<=120)
			{
			$total120=$total120-$pending12;
			}
			if($days_between>120 && $days_between<=180)
			{
			$total180=$total180-$pending12;
			}
			if($days_between>180)
			{
			$total210=$total210-$pending12;
			}


			  if($pending12 !=''){	

			  	 $snocount = $snocount + 1;


				$totalamount1 = $totalamount1 - $res5transactionamount;
				$totalamount301 = $totalamount301 - $pending12;
				$totalamount601 = $totalamount601 + $totalamount30;
				$totalamount901 = $totalamount901 + $total60;
				$totalamount1201 = $totalamount1201 + $total90;
				$totalamount1801 = $totalamount1801 + $total120;
				$totalamount2101 = $totalamount2101 + $total180;
				$totalamount2401 = $totalamount2401 + $total210;
				
			//echo $cashamount;
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}

			?>

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res5docnumber; ?></div></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ledgername; ?></div></td>-->
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php //echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $entrydate; ?></div></td>

              


              <td class="bodytext31" valign="center"  align="right">

			    <div align="right">-<?php echo number_format($res5transactionamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right">

			    <div align="right">-<?php echo number_format($pending12,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>

			<?php

			}

				$totalamount30=0;
				$total60=0;
				$total90=0;
				$total120=0;
				$total180=0;
				$total210=0;
			}

			///////////////////////
////////////////////// for sdbt bills ///////////////////////

			

			}

			}

			}

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              

				<td class="bodytext31" valign="center"  align="center" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                >&nbsp;</td>

                <td class="bodytext31" valign="center"  align="center" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                ><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        

            </tr>

    

          </tbody>

        </table>

<?php



    $content = ob_get_clean();



    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_fullcreditor.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>