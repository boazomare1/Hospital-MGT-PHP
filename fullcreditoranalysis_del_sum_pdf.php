<?php

ob_start();

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");

require_once('html2pdf/html2pdf.class.php');

$sno1=0;
$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$totalamount1_final =0;
$totalamount301_final =0;
$totalamount601_final =0;
$totalamount901_final =0;
$totalamount1201_final =0;
$totalamount1801_final =0;
$totalamount2101_final =0;
$totalamount2401_final =0;
$totalamount120 =0;

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

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
	.bodytext31{
		font-size: 12px;

	}
</style>
 


<?php  include("print_header_pdf4.php"); ?>

 
<h4 align="center">Full Creditor Analysis Summary</h4>  

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; width: 90%" 

            bordercolor="#666666" cellspacing="0" cellpadding="4"  

            align="center" border="1">
          <tbody>

         
         <!-- <tr><td colspan="13">&nbsp;</td></tr> -->

            <tr>

              <td width="20" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td style="width: 10%;" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Supplier Name</strong></td>

				<!-- <td width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>GRN No</strong></td> -->

				 <!-- <td width="20" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong> Invoice No </strong></td> -->

             <td width="60" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> </strong></td>

              <td width="70" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Invoice Amt </strong></td>

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

			$arraysuppliercode = trim($_REQUEST['searchsuppliercode']);

			$searchsuppliername = trim($searchsuppliername);

			

			if($arraysuppliercode == '') {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			} else {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			}

			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $num_main=mysqli_num_rows($exec212);
			while ($res212 = mysqli_fetch_array($exec212))

			{

				// echo 1;

			$res21suppliername = $res212['suppliername'];

			$res21suppliercode = $res212['suppliercode'];

			// if($num_main==0){
			// 	$res21suppliername = $searchsuppliername;
			// 	$res21suppliercode = $arraysuppliercode;
			// }

			

			$query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222);

			$res22accountname = $res222['accountname'];
			$res22accountautonum = $res222['auto_number'];
			$id = $res222['id'];



			if( $res21suppliername != '')

			{

				//////////////// for opening Balance //////////
				$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			$invoicevalue1=0;
			$invoicevalue2=0;
				 
						

					$query1 = "SELECT billdate as date_entry,totalamount as payables, billnumber as billnumber from master_purchase where suppliercode = '$id' and recordstatus <> 'deleted' and billdate < '$ADate1'   group by billnumber
					 UNION ALL SELECT date(created_at) as date_entry, (-1*total_amount) as payables,  approve_id as billnumber from supplier_debit_transactions where supplier_id = '$id' and date(created_at) < '$ADate2'
					  ";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num1 = mysqli_num_rows($exec1);
					while($res1 = mysqli_fetch_array($exec1))
					{
					$entrydate  = $res1['date_entry'];
					$rescr1docno = $res1['billnumber'];
					$payables = $res1['payables'];
					$openingbalance += $payables;


					$query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$id' and billnumber = '$rescr1docno'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate <= '$ADate2'";
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
							$res3transactionamount = $res3['transactionamount1'];
							
							$res4return = 0;
							$query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber = '$rescr1docno' and entrydate <= '$ADate2'
								UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$rescr1docno' and transactiontype = 'PURCHASE' and transactiondate <= '$ADate2' )";
							$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res4 = mysqli_fetch_array($exec4))
							{
								$res4return += $res4['totalreturn'];
							}

								/////// for grns///////////////////////////////////
									$total_allocated_amount=0;
									// $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$rescr1docno' and recordstatus = 'allocated' and transactiondate < '$ADate1' order by auto_number desc";
									// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
									// while ($res3 = mysql_fetch_array($exec3))
									// {
									// $total_allocated_amount +=$res3['transactionamount'];
									// }
									/////////// for sdbts /////////////////
									$total_allocated_amount2=0;
					            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$rescr1docno' and recordstatus = 'allocated' and transactiondate <= '$ADate2' order by auto_number desc"; 
									$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
									$num123=mysqli_num_rows($exec3);
									while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount2 +=$res3['transactionamount']; }
									// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
									if($num123>0){
											 $pending_amountfromdb=$payables+$total_allocated_amount2;
										}
									///////////////////////////////////
										if($num123>0){
											 $invoicevalue1 =  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;
							  				$invoicevalue2 +=  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;

										}else{
							  				$invoicevalue1 =  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
							  				$invoicevalue2 +=  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
											}


							  $t1 = strtotime($entrydate);
					    	  $t2 = strtotime($ADate2);
							  $days_between = ceil(abs($t2 - $t1) / 86400);
							    if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue1; }
								if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue1; }
								if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue1; }
								if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue1; }
								if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue1; }
								if($days_between>180){ $total210=$total210+$invoicevalue1; }

									
								}


									// $totalamount1=$totalamount1+$payables;
									// $totalamount301=$totalamount301+$invoicevalue1;

									$totalamount1=$totalamount1+$openingbalance;
									$totalamount301=$totalamount301+$invoicevalue2;
									$totalamount601=$totalamount601+$totalamount30;
									$totalamount901=$totalamount901+$total60;
									$totalamount1201=$totalamount1201+$total90;
									$totalamount1801=$totalamount1801+$total120;
									$totalamount2101=$totalamount2101+$total180;
									$totalamount2401=$totalamount2401+$total210;
							 
 


					// $snocount = $snocount + 1;
				//////////////// for opening Balance //////////

			?>


           <tr  bgcolor="#ffffff">
            		<td colspan="1" class="bodytext31" valign="center"  align="left"><strong><?php echo $sno1+=1;?></strong></td>
            		<td colspan="1" class="bodytext31" valign="center"  align="left"><strong><?php echo strtoupper($res22accountname);?></strong></td>
            		 <td colspan="1" class="bodytext31" valign="center"  align="left">Opening Balance :  </td>
            		 <!-- <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td> -->
            		 <td class="bodytext31" valign="center"  align="right"> <?php echo number_format($openingbalance,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"> <?php echo number_format($invoicevalue2,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalamount30,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total60,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total90,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total120,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total180,2,'.',','); ?></td>
            		 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total210,2,'.',','); ?></td>

           </tr>


           

            
            


			<?php

			
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			

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

		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['billdate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['totalamount'];

		  $supplierbillnumber = $res1['supplierbillnumber'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/

		  

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

		  
 

		  ///////////////// sdbt allocated for grn numbers//////////
		  $total_allocated_amount=0;
		  // $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$res1billnumber' and recordstatus = 'allocated' order by auto_number desc";
				// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				// // $num=mysql_num_rows($exec3);
				// // 	if($num>0){
				// while ($res3 = mysql_fetch_array($exec3))
				// {
				// 		$total_allocated_amount +=$res3['transactionamount'];
				// }

		  ///////////////// sdbt allocated for grn numbers//////////
		  ///////////////// SPE  for grn numbers//////////
				$res5transactionamount_spe=0;
			// 	$query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
			// 	// $query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		 //  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		 //  $num5 = mysql_num_rows($exec5);
		 //  if($num5 > 0)
		 //  {
			//   while($res5 = mysql_fetch_array($exec5))
			//   {
			// 	  $res5billnumber = $res5['billnumber'];
			// 	  $res5openingbalance = $res5['openingbalance'];
			// 	  $res5docnumber = $res5['docno'];
			// 	  $res5transactionamount = $res5['transactionamount'];
			// 	  $res5transactionamount_spe += $res5['transactionamount'];
			// 	}
			// }
		  ///////////////// SPE  for grn numbers//////////

		  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return)-$total_allocated_amount-$res5transactionamount_spe;
		  $creditamount =  $res2transactionamount - ($res3transactionamount + $res4return);

		  $t1 = strtotime($res1transactiondate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue; }
			if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue; }
			if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue; }
			if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue; }
			if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue; }
			if($days_between>180) { $total210=$total210+$invoicevalue; }
 
		  if($res2transactionamount !=''){

		  $snocount = $snocount + 1;

			

			//echo $cashamount;

			

			

			?>


          <!--  <tr   >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php // echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php // echo $res1billnumber; ?></td>

              
                <td class="bodytext31" valign="center"  align="left"> <?php // echo $supplierbillnumber; ?></td>

              <td class="bodytext31" valign="center"  align="left"> <?php // echo $res1transactiondate; ?></td>
              

              <td class="bodytext31" valign="center"  align="right"> <?php // echo number_format($res2transactionamount,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right">

			    <?php // echo number_format($invoicevalue,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php // echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total210,2,'.',','); ?></td>

           </tr>
 -->
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

          <!--  <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php // echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php // echo $docno; ?></td>

              
                <td class="bodytext31" valign="center"  align="left"> <?php //// echo $entrydate; ?></td>

              <td class="bodytext31" valign="center"  align="left"> <?php // echo $entrydate; ?></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <?php // echo number_format($creditamount,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right">

			    <?php // echo number_format($creditamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php // echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total210,2,'.',','); ?></td>

           </tr> -->
           <?php
           $totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
?>

            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->
            <?php
             $query2 = "SELECT * from supplier_debit_transactions where supplier_id = '$id' and date(created_at) between '$ADate1' and '$ADate2'  order by created_at ASC";

			$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

			while($res2=mysqli_fetch_array($exe2))

			{

		 	// $creditamount=$res2['creditamount'];

		 

			 $docno = $res2['approve_id'];
		  $created_at = $res2['created_at'];

		  $timestamp = strtotime($created_at);
			$entrydate = date('Y-m-d', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss


		  $supplier_id_debitnotes = $res2['supplier_id'];

		   $debitamount_sbdt = $res2['total_amount'];

		   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////
		   $total_allocated_amount=0;
            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$docno' and recordstatus = 'allocated' order by auto_number desc"; 
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount +=$res3['transactionamount']; }
				// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
				$pending_amountfromdb=$debitamount_sbdt-$total_allocated_amount;

			   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////

			$t1 = strtotime($entrydate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		    if($days_between<30)

			{

			$totalamount30=$totalamount30-$pending_amountfromdb;

			}

			

			if($days_between>30 && $days_between<=60)

			{

			$total60=$total60-$pending_amountfromdb;

			}

			if($days_between>60 && $days_between<=90)

			{

			$total90=$total90-$pending_amountfromdb;

			}

			if($days_between>90 && $days_between<=120)

			{

			$total120=$total120-$pending_amountfromdb;

			}

			if($days_between>120 && $days_between<=180)

			{

			$total180=$total180-$pending_amountfromdb;

			}

			if($days_between>180)

			{

			$total210=$total210-$pending_amountfromdb;

			}

		  

			

			  if($debitamount_sbdt !=''){

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1-$debitamount_sbdt;

			$totalamount301=$totalamount301-$pending_amountfromdb;

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

           <!-- <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php // echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php // echo $docno; ?></td>

              
                <td class="bodytext31" valign="center"  align="left"> <?php //// echo $entrydate; ?></td>

              <td class="bodytext31" valign="center"  align="left"> <?php // echo $entrydate; ?></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <?php // echo '-'.number_format($debitamount_sbdt,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right"> <?php // echo '-'.number_format($pending_amountfromdb,2,'.',',');
               
                ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php // echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total210,2,'.',','); ?></td>

           </tr> -->
            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		

}

			

			}
			//////////////////////////// debit notes end ///////////////////////////
			//////////////////////////// SPE BILLS STARTS HERE ///////////////////////////
		// $query51 = "select auto_number from paymentmodecredit ";
		// $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		// $num = mysql_num_rows($exec51);
		// if($num>0)
		//   {
		  // $paymentdocno = $res45['billnumber'];
		  // $res5transactionamount = $res45['totalfxamount'];
		  // $res5transactiondate = $res45['groupdate'];

			$query5 = "select * from master_transactionpharmacy where suppliercode = '$id' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysqli_fetch_array($exec5))
		  {

	      $res5suppliername = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  $res5transactionamount = $res5['transactionamount'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  $entrydate = $res5['transactiondate'];

		  $res5transactionamount_balance=0;


		   $query852 = "select supplierbillnumber from master_purchase where billnumber = '$res5billnumber' ";
		  $exec852 = mysqli_query($GLOBALS["___mysqli_ston"], $query852) or die ("Error in Query852".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  $res852 = mysqli_fetch_array($exec852);
		  $res85supplierbillnumber = $res852['supplierbillnumber'];

		  $t1 = strtotime($entrydate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30-$res5transactionamount_balance; }
			if($days_between>30 && $days_between<=60) { $total60=$total60-$res5transactionamount_balance; }
			if($days_between>60 && $days_between<=90){ $total90=$total90-$res5transactionamount_balance; }
			if($days_between>90 && $days_between<=120) { $total120=$total120-$res5transactionamount_balance; }
			if($days_between>120 && $days_between<=180) { $total180=$total180-$res5transactionamount_balance; }
			if($days_between>180) { $total210=$total210-$res5transactionamount_balance; }

			

			  if($res5transactionamount !=''){
		  		$snocount = $snocount + 1;

		  		$totalamount1=$totalamount1-$res5transactionamount;
				$totalamount301=$totalamount301-$res5transactionamount_balance;
				$totalamount601=$totalamount601+$totalamount30;
				$totalamount901=$totalamount901+$total60;
				$totalamount1201=$totalamount1201+$total90;
				$totalamount1801=$totalamount1801+$total120;
				$totalamount2101=$totalamount2101+$total180;
				$totalamount2401=$totalamount2401+$total210;

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

           <!-- <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php // echo $res21suppliername; ?></td>

				<td class="bodytext31" valign="center"  align="left">

                <?php // echo $res5docnumber; ?></td>

              
                <td class="bodytext31" valign="center"  align="left"> <?php // echo $res85supplierbillnumber; ?></td>

              <td class="bodytext31" valign="center"  align="left"> <?php // echo $entrydate; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <?php // echo '-'.number_format($res5transactionamount,2,'.',','); ?></td>

               <td class="bodytext31" valign="center"  align="right"> <?php // echo  number_format($res5transactionamount_balance,2,'.',',');
               
                ?></td>

				<td class="bodytext31" valign="center"  align="left">

			    <?php // echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total90,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total120,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total180,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php // echo number_format($total210,2,'.',','); ?></td>

           </tr> -->
            <!-- /////////////////////////////////////// spe bills //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
}

 
			//////////////////////////// SPE BILLS ENDS HERE ///////////////////////////


			

			}

			?>
			 
			<tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              

				<td class="bodytext31" valign="center"  align="center"  bgcolor="#ecf0f5">&nbsp;</td>

              <!-- <td class="bodytext31" valign="center"  align="center"  bgcolor="#ecf0f5">&nbsp;</td> -->

                 <!-- <td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">&nbsp;</td> -->

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        

            </tr>


			

			<?php

			$totalamount1_final +=$totalamount1;
			$totalamount301_final +=$totalamount301;
			$totalamount601_final +=$totalamount601;
			$totalamount901_final +=$totalamount901;
			$totalamount1201_final +=$totalamount1201;
			$totalamount1801_final +=$totalamount1801;
			$totalamount2101_final +=$totalamount2101;
			$totalamount2401_final +=$totalamount2401;

			$snocount=0;
			$totalamount1=0;
		$totalamount301=0;
		$totalamount601=0;
		$totalamount901=0;
		$totalamount1201=0;
		$totalamount1801=0;
		$totalamount2101=0;
		$totalamount2401=0;

			} 

			}

			?>

			<tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              

				<td class="bodytext31" valign="center"  align="center"  bgcolor="#ecf0f5">&nbsp;</td>

              <!-- <td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">&nbsp;</td> -->

                 <!-- <td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5">&nbsp;</td> -->

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301_final,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount601_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount901_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1201_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1801_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2101_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2401_final,2,'.',','); ?></strong></td>        

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

        $html2pdf->Output('print_fullcreditor_Summary.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>