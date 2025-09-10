<?php

ob_start();

session_start();

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');


require_once('html2pdf/html2pdf.class.php');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalamount = "0.00";

$totalamount30 = "0.00";

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$total60 = "0.00";

$total90 = "0.00";



$total120 = "0.00";

$total180 = "0.00";

$total210 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount601 = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$totalamount90 = '0.00';

$totalamount2401 = 0;

$totalamount302 = "0.00";

$totalamount602 = "0.00";

$totalamount902 = "0.00";

$totalamount1202 = "0.00";

$totalamount1802 = "0.00";

$totalamount2202 = "0.00";

$totalamount90 = '0.00';

$totalamount2402 = 0;

$totalamount60 = 0;

$totalamountgreater2 =0;



$ftotalamount1 = 0;

$ftotalamount301 = 0;

$ftotalamount601 = 0;

$ftotalamount901 = 0;

$ftotalamount1201 = 0;

$ftotalamount1801 = 0;

$ftotalamount2101 = 0;

$ftotalamount2401 = 0;

//This include updatation takes too long to load for hunge items database.

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



if (isset($_REQUEST["searchsuppliercode"])) { $arraysuppliercode = $_REQUEST["searchsuppliercode"]; } else { $arraysuppliercode = ""; }

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

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; 

}

-->

</style>

       

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

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


<h4 align="center">Full Creditor Analysis Summary</h4>  
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="5" width="100%" 

            align="center" border="1">

          <tbody>

            

            <tr>

              <td width="20" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="200" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Supplier</strong></td>

              <td width="80" align="right" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>

              <td width="80" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>

              <td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>60 days </strong></td>

				<td width="80"  align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>90 days</strong></td>

				<td width="80" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>120 days</strong></td>

              <td width="80" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>180 days </strong></td>

				<td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>180+ days </strong></td>

            </tr>

			

			<?php

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				//

				

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			

			$res1suppliername = '';

			$res1suppliercode = '';

			$res1transactiondate ='';

			//print_r($_POST);

		 

		  if($arraysuppliercode != '')

		  {

		  // $query212 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";
		  	$query212 = "select * from master_accountname where id = '$arraysuppliercode' and accountssub='12' group by id";

		  }

		  else if($arraysuppliercode == '')

		  {

		  // $query212 = "select * from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2'  group by suppliercode";
		  	$query212 = "select * from master_accountname where accountssub='12' group by id";

		  }

		  //echo $query212;

		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res212 = mysqli_fetch_array($exec212))

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

			// $snocount = $snocount + 1;

			

			// //echo $cashamount;

			// $colorloopcount = $colorloopcount + 1;

			// $showcolor = ($colorloopcount & 1); 

			// if ($showcolor == 0)

			// {

			// 	//echo "if";

			// 	$colorcode = 'bgcolor="#CBDBFA"';

			// }

			// else

			// {

			// 	//echo "else";

			// 	$colorcode = 'bgcolor="#ecf0f5"';

			// }

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$res21suppliername = trim($res21suppliername);

			



		  //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

	 	/*  $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by suppliercode";

		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

		  $num1 = mysql_num_rows($exec1);

		  while($res1 = mysql_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['billdate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['totalamount']; */

		   $query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode'  and (transactiontype = 'PURCHASE' or transactiontype = 'PAYMENT') and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['transactiondate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['transactionamount'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/

		  

		  $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'  and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  $res2transactionamount1 = $res2['transactionamount1'];

		   //////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2'";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res2transactionamount=$res2transactionamount1-$wh_tax_value;

		  

		  $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'   and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		   $res3transactionamount = $res3['transactionamount1'];

		  

		  $res4return = 0;

		  $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where  transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select billnumber from master_transactionpharmacy where transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

		  {

		  $res4return += $res4['totalreturn'];

		  }

			

		

		  

	 	  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return) ;

		  

$query45122 = "select billnumber from master_purchase where suppliercode = '$res1suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by billnumber";		  $exe45122=mysqli_query($GLOBALS["___mysqli_ston"], $query45122);

		  while($res45122=mysqli_fetch_array($exe45122))

		  {

		 $resbill=$res45122['billnumber']; 

	 	   $query451= "select transactiondate,sum(transactionamount) as transactionamount,billnumber,mrnno from master_transactionpharmacy where   billnumber='$resbill' and  suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber";

		  

		  $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

     $num451 = mysqli_num_rows($exec451);

	 if($num451>0)

		  {

		  while($res451=mysqli_fetch_array($exec451))

		{  

		

		  

		  

	  $res451transactiondate = $res451['transactiondate'];

		$res451transactionamount1 = $res451['transactionamount'];

		  $res451billnumber=$res451['billnumber'];

		   $res451mrnno=$res451['mrnno'];


		   /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res451billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res451transactionamount=$res451transactionamount1-$wh_tax_value;

		  

		  $query452= "select sum(transactionamount) as transactionamount from master_transactionpharmacy where  billnumber='$res451billnumber' and  suppliercode = '$res1suppliercode'  and transactiontype = 'PAYMENT' and recordstatus='allocated'  and transactiondate between '$ADate1' and '$ADate2' group by billnumber";

		  $exe452=mysqli_query($GLOBALS["___mysqli_ston"], $query452);

		  $res452=mysqli_fetch_array($exe452);

		  

		 $totalpayment=$res452['transactionamount'];

		  

		  $returnamount = 0;

		  $query652 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res451billnumber' and  transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res451billnumber' and entrydate between '$ADate1' and '$ADate2'";

		  $exe652=mysqli_query($GLOBALS["___mysqli_ston"], $query652) or die("Error in query652".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res652=mysqli_fetch_array($exe652))

		  {

		  $returnamount += $res652['totalreturn'];

		  }

		  

		if($snocount==0)

		{

		 $totalamount420 =$res451transactionamount-($totalpayment + $returnamount)+$openingbalance;

}

else

{

$totalamount420 =$res451transactionamount-($totalpayment + $returnamount);

}

			$totalamount451 =$totalamount420;		 

		  $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res451transactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		

		  

		  if($days_between <= 30)

		  {

		

		  $totalamount302 = $totalamount302 + $totalamount451;

		

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		

		  $totalamount602 = $totalamount602 + $totalamount451;

		

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		

		  $totalamount902 = $totalamount902 + $totalamount451;

		

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		

		  $totalamount1202 = $totalamount1202 + $totalamount451;

		

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		

		  $totalamount1802 = $totalamount1802 + $totalamount451;

		

		  }

		  else

		  {

		

		  $totalamountgreater2 = $totalamountgreater2 + $totalamount451;

		  }

	

		   }

		

		}

		}

		 

		

		  

				$totalamount1 = $totalamount1 + $res2transactionamount;

				

				$totalamount301 = $totalamount301 + $invoicevalue;

				$totalamount601 = $totalamount601 + $totalamount302;

				$totalamount901 = $totalamount901 + $totalamount602;

				$totalamount1201 = $totalamount1201 + $totalamount902;

				$totalamount1801 = $totalamount1801 + $totalamount1202;

				$totalamount2101 = $totalamount2101 + $totalamount1802;

				$totalamount2401 = $totalamount2401 + $totalamountgreater2;

				

				$ftotalamount1 = $ftotalamount1 + $res2transactionamount;

				

				$ftotalamount301 = $ftotalamount301 + $invoicevalue;

				$ftotalamount601 = $ftotalamount601 + $totalamount302;

				$ftotalamount901 = $ftotalamount901 + $totalamount602;

				$ftotalamount1201 = $ftotalamount1201 + $totalamount902;

				$ftotalamount1801 = $ftotalamount1801 + $totalamount1202;

				$ftotalamount2101 = $ftotalamount2101 + $totalamount1802;

				$ftotalamount2401 = $ftotalamount2401 + $totalamountgreater2;

				

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$totalamount60=0;

				$totalamount90=0;

				$totalamount120=0;

				$totalamount180=0;

				$totalamount210=0;

				$totalamount302=0;

				$totalamount602=0;

				$totalamount902=0;

				$totalamount1202=0;

				$totalamount1802=0;

				$totalamount2102=0;

				$totalamountgreater2=0;

				

				$total60=0;

				$total90=0;

				$total120=0;

				$total180=0;

				$total210=0;

				   

			}
		}

			

					 	$query2="select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno";

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

			

				$totalamount1 = $totalamount1 + $creditamount;

				$totalamount301 = $totalamount301 + $creditamount;

				$totalamount601 = $totalamount601 + $totalamount30;

				$totalamount901 = $totalamount901 + $total60;

				$totalamount1201 = $totalamount1201 + $total90;

				$totalamount1801 = $totalamount1801 + $total120;

				$totalamount2101 = $totalamount2101 + $total180;

				$totalamount2401 = $totalamount2401 + $total210;

				

				$ftotalamount1 = $ftotalamount1 + $creditamount;

				$ftotalamount301 = $ftotalamount301 + $creditamount;

				$ftotalamount601 = $ftotalamount601 + $totalamount30;

				$ftotalamount901 = $ftotalamount901 + $total60;

				$ftotalamount1201 = $ftotalamount1201 + $total90;

				$ftotalamount1801 = $ftotalamount1801 + $total120;

				$ftotalamount2101 = $ftotalamount2101 + $total180;

				$ftotalamount2401 = $ftotalamount2401 + $total210;

			//echo $cashamount;

			

		



			

}

			$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$totalamount60=0;

				$totalamount90=0;

				$totalamount120=0;

				$totalamount180=0;

				$totalamount210=0;

				

				$totalamount302=0;

				$totalamount602=0;

				$totalamount902=0;

				$totalamount1202=0;

				$totalamount1802=0;

				$totalamount2102=0;

				$total60=0;

				$total90=0;

				$total120=0;

				$total180=0;

				$total210=0;

			}

		  
			///////////////////////
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
				$totalamount1 = $totalamount1 - $pending12;
				$totalamount301 = $totalamount301 - $pending12;
				$totalamount601 = $totalamount601 + $totalamount30;
				$totalamount901 = $totalamount901 + $total60;
				$totalamount1201 = $totalamount1201 + $total90;
				$totalamount1801 = $totalamount1801 + $total120;
				$totalamount2101 = $totalamount2101 + $total180;
				$totalamount2401 = $totalamount2401 + $total210;
				

				$ftotalamount1 = $ftotalamount1 - $pending12;
				$ftotalamount301 = $ftotalamount301 - $pending12;
				$ftotalamount601 = $ftotalamount601 + $totalamount30;
				$ftotalamount901 = $ftotalamount901 + $total60;
				$ftotalamount1201 = $ftotalamount1201 + $total90;
				$ftotalamount1801 = $ftotalamount1801 + $total120;
				$ftotalamount2101 = $ftotalamount2101 + $total180;
				$ftotalamount2401 = $ftotalamount2401 + $total210;
			//echo $cashamount;
			}

				$res2transactionamount=0;
				$invoicevalue=0;
				$totalamount30=0;
				$totalamount60=0;
				$totalamount90=0;
				$totalamount120=0;
				$totalamount180=0;
				$totalamount210=0;			
				$totalamount302=0;
				$totalamount602=0;
				$totalamount902=0;
				$totalamount1202=0;
				$totalamount1802=0;
				$totalamount2102=0;
				$total60=0;
				$total90=0;
				$total120=0;
				$total180=0;
				$total210=0;
			}

			///////////////////////
				
				if($totalamount301!=0	||	$totalamount601!=0	||	$totalamount901!=0	||	$totalamount1201!=0	||	$totalamount1801!=0	||	$totalamount2101!=0	||	$totalamount2401!=0) 
				// if(1)
				{

				$snocount = $snocount + 1;
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

			<tr >

			<td align="left" class="bodytext3"><?php echo $snocount; ?></td>

			<td align="left" class="bodytext3"><?php echo $res21suppliername; ?></td>

			 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount301,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount601,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount901,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount1201,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount1801,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount2101,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount2401,2,'.',','); ?></td>

            </tr>

			<?php

			

			

			}

				$totalamount1 = 0;

				$totalamount301 = 0;

				$totalamount601 = 0;

				$totalamount901 = 0;

				$totalamount1201 = 0;

				$totalamount1801 = 0;

				$totalamount2101 = 0;

				$totalamount2401 = 0;

			

		  }

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                ><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount301,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount901,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount1201,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($ftotalamount2401,2,'.',','); ?></strong></td>

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